<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perencanaan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_perencanaan');
	}
  /**
   * Show perencanaan dashboard
   * 
   * 
   * @return perencanaan view
   */
  public function pengetahuan()
  {
    $guru 	= get_my_info();
		$ajaran = get_ta();

		# make query to result 
    $this->db->from('rencana');
    $this->db->join('kelas a','rencana.kelas_id = a.id','inner');
    $this->db->join('kurikulum b','rencana.id_mapel = b.id_mapel','inner');
    $this->db->where([
			'b.ajaran_id' => $ajaran->id ,
			'b.guru_id' => $guru->id,
			'b.ajaran_id' => $ajaran->id
		]);
		
		# set data will send to view
		$data['result'] = $this->db->get()->result();
		$data['ajaran'] = $ajaran;

		# load view
    $this->template->load('template','perencanaan/pengetahuan',$data);
  }

  /**
   * Show create page perencanaan pengetahuan
   * 
   * 
   * 
   * @return true arg
   */
  public function add_pengetahuan()
  {
    $data['ajarans'] = $this->db->get('ajaran')->result();
		
		$guru 	= get_my_info();
		 
		$this->db->from('kurikulum');
		$this->db->group_by(['kelas_id']);
		$this->db->order_by('kelas_id','ASC');
		$this->db->where(['guru_id' => $guru->id]);
		$data_mapel = $this->db->get()->result();
			
			

    foreach($data_mapel as $datamapel){
			$rombel_id[] = $datamapel->kelas_id;
		}
		if(isset($rombel_id)){
			$id_rombel = $rombel_id;
		} else {
			$id_rombel = array();
		}

		$this->db->from('kelas');
		$this->db->where_in('id',$id_rombel);
		$data['rombels'] = $this->db->get()->result();
		
		$this->db->from('kelas');
		$this->db->group_by(['tingkat']);
		$this->db->order_by('tingkat','ASC');
		$data['kelas'] = $this->db->get()->result();

		$data['form_action'] 	= 'perencanaan/simpan_perencanaan';
		$data['query']				= 'kd';
		$this->template->load('template','perencanaan/add_perencanaan',$data);
	}
	
	/**
	 * Save perencanaan
	 *
	 *  
	 * @return 
	 */
	public function simpan_perencanaan()
	{
		if($_POST){
			$kompetensi_id		= $_POST['kompetensi_id'];
			$ajaran_id			= $_POST['ajaran_id'];
			$rombel_id			= $_POST['rombel_id'];
			$id_mapel			= $_POST['id_mapel'];
			$nama_penilaian		= $_POST['nama_penilaian'];
			$bentuk_penilaian	= $_POST['bentuk_penilaian'];
			$bobot_penilaian	= isset($_POST['bobot_penilaian']) ? $_POST['bobot_penilaian'] : '';
			$keterangan_penilaian	= $_POST['keterangan_penilaian'];
			
			$bobot_penilaian_result = 1;
			if($kompetensi_id == 1){
				$redirect = 'pengetahuan';
			} else {
				$redirect = 'keterampilan';
			}
			for ($i = 1; $i <= count($nama_penilaian); $i++) {
				$kd[]		= isset($_POST['kd_'.$i]) ? $_POST['kd_'.$i] : '';
				$kd_id[]	= isset($_POST['kd_id_'.$i]) ? $_POST['kd_id_'.$i] : '';
			}
			$rencana = new Rencana();
			$rencana->ajaran_id			= $ajaran_id;
			$rencana->id_mapel			= $id_mapel;
			$rencana->rombel_id			= $rombel_id;
			$rencana->kompetensi_id		= $kompetensi_id;
			$rencana->save();
			foreach($kd as $k=>$v){
				if($bobot_penilaian){
					if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
						$bobot_penilaian_result = $bobot_penilaian[$k];
					}
				} else {
					$bobot_penilaian_result = '0';
				}
				if(is_array($v)){
					foreach($v as $ks=>$vs){
						$get_post_kd = explode("|", $vs);
						$id_kompetensi = $get_post_kd[0];
						$id_kd = $get_post_kd[1];
						$new_rencana_penilaian					= new Rencanapenilaian();
						$new_rencana_penilaian->rencana_id		= $rencana->id;
						$new_rencana_penilaian->kompetensi_id	= $kompetensi_id;
						$new_rencana_penilaian->nama_penilaian	= $nama_penilaian[$k];
						$new_rencana_penilaian->bentuk_penilaian= $bentuk_penilaian[$k];
						$new_rencana_penilaian->bobot_penilaian	= $bobot_penilaian_result;
						$new_rencana_penilaian->keterangan_penilaian	= $keterangan_penilaian[$k];
						$new_rencana_penilaian->kd_id			= $id_kd;
						$new_rencana_penilaian->kd				= $id_kompetensi;
						$new_rencana_penilaian->save();
					}
				}
			}
			$this->session->set_flashdata('success', 'Berhasil menambah rencana penilaian '.$redirect);
			redirect('admin/perencanaan/'.$redirect);
		}
	}
}