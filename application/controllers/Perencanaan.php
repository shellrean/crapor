<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perencanaan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		is_login();
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
			'b.ajaran_id' => $ajaran->id,
			'rencana.kompetensi_id'	=> 1,
		]);
		$this->db->select('rencana.*,b.guru_id AS guru_id');
		
		# set data will send to view
		$data['result'] = $this->db->get()->result();
		$data['ajaran'] = $ajaran;

		# load view
    $this->template->load('template','perencanaan/pengetahuan',$data);
	}
  /**
   * Show perencanaan dashboard
   * 
   * 
   * @return perencanaan view
   */
  public function keterampilan()
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
			'b.ajaran_id' => $ajaran->id,
			'rencana.kompetensi_id'	=> 2,
		]);
		$this->db->select('rencana.*,b.guru_id AS guru_id');
		
		# set data will send to view
		$data['result'] = $this->db->get()->result();
		$data['ajaran'] = $ajaran;
 
		# load view
    $this->template->load('template','perencanaan/keterampilan',$data);
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
   * Show create page perencanaan pengetahuan
   * 
   * 
   * 
   * @return true arg
   */
  public function add_keterampilan()
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
		$this->template->load('template','perencanaan/add_keterampilan',$data);
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
			$kelas_id			= $_POST['kelas_id'];
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

			$data = [
				'ajaran_id'			=> $ajaran_id,
				'id_mapel'			=> $id_mapel,
				'kelas_id'			=> $kelas_id,
				'kompetensi_id'	=> $kompetensi_id
			];
			$this->db->insert('rencana',$data);

			$rencana_id =  $this->db->insert_id();
			
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

						$data = [
							'rencana_id'			=> $rencana_id,
							'kompetensi_id'		=> $kompetensi_id,
							'nama_penilaian'	=> $nama_penilaian[$k],
							'bentuk_penilaian'=> $bentuk_penilaian[$k],
							'bobot_penilaian'	=> $bobot_penilaian_result,
							'keterangan_penilaian' => $keterangan_penilaian[$k],
							'kd_id'						=> $id_kd,
							'kd'							=> $id_kompetensi
						];

						$this->db->insert('rencana_penilaian',$data);
					}
				}
			}
			$this->session->set_flashdata('success', 'Berhasil menambah rencana penilaian '.$redirect);
			redirect('perencanaan/'.$redirect);
		}
	}

	public function edit($kompetensi_id,$id)
	{
		$data['kompetensi_id'] = $kompetensi_id;
		$data['rencana'] = $this->db->get_where('rencana',['id' => $id])->row();
		$data['ajarans'] = $this->db->get('ajaran')->result();
		$data['kelases'] = $this->db->get('kelas')->result();

		$data['form_action'] = 'perencanaan/';
		$this->template->load('template','perencanaan/edit',$data);
	}

	public function update_perencanaan()
	{
		if($_POST){
			$rencana_id			= $_POST['rencana_id'];
			$kompetensi_id		= $_POST['kompetensi_id'];
			$ajaran_id			= $_POST['ajaran_id'];
			$kelas_id			= $_POST['rombel_id'];
			$id_mapel			= $_POST['id_mapel'];
			$nama_penilaian		= $_POST['nama_penilaian'];
			$bentuk_penilaian	= $_POST['bentuk_penilaian'];
			$bobot_penilaian	= $_POST['bobot_penilaian'];
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
			// $rencana			= Rencana::find($rencana_id);
			$rencana = $this->db->get_where('rencana',['id' => $rencana_id])->row();
			if($rencana){
				foreach($kd as $k=>$v){
					if(is_array($v)){
						foreach($v as $ks=>$vs){
							$get_post_kd = explode("|", $vs);
							$id_kompetensi = $get_post_kd[0];
							$id_kd = $get_post_kd[1];
							$rencana_penilaian = $this->db->get_where('rencana_penilaian',[
								'rencana_id'			=> $rencana->id,
								'nama_penilaian'	=> $nama_penilaian[$k],
								'kompetensi_id'		=> $kompetensi_id,
								'kd_id'						=> $id_kd,
							])->result();
							if($rencana_penilaian){
								if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
									$bobot_penilaian_result = $bobot_penilaian[$k];
								}
								foreach($rencana_penilaian as $rp){
									$id_rp[] = $rp->id;
										$data = array(
											'nama_penilaian' => $nama_penilaian[$k], 
											'bentuk_penilaian' => $bentuk_penilaian[$k], 
											'bobot_penilaian' => $bobot_penilaian_result, 
											'kd_id' => $id_kd, 
											'kd' => $id_kompetensi
										);
										$this->db->update('rencana_penilaian',$data,['id' => $rp->id]);
								}
							} else {
								$data = [
									'rencana_id'				=> $rencana->id,
									'kompetensi_id'			=> $kompetensi_id,
									'nama_penilaian'		=> $nama_penilaian[$k],
									'bentuk_penilaian'	=> $bentuk_penilaian[$k],
									'bobot_penilaian'		=> $bobot_penilaian[$k],
									'kd_id'							=> $id_kd,
									'kd'								=> $id_kompetensi
								];
								$this->db->insert('rencana_penilaian',$data);

								$new_rp[] = $new_rencana_penilaian->id;
							}
						}
					}
				}
				if(isset($id_rp)){
					if(isset($new_rp)){
						$id_rp = array_merge($id_rp,$new_rp);
					}
					$this->db->from('rencana_penilaian');
					$this->db->where([
						'rencana_id'	=> $rencana->id,
					]);
					$this->db->where_not_in('id',$id_rp);
					$del_rp = $this->db->get()->result();

					foreach($del_rp as $drp){
						
						$this->db->delete('rencana_penilaian',['id' => $drp->id]);
					}
				}
			} else {
				$data = [
					'ajaran_id'			=> $ajaran_id,
					'id_mapel'			=> $id_mapel,
					'kelas_id'			=> $kelas_id,
					'kompetensi_id'	=> $kompetensi_id,
				];
				$this->db->insert('rencana',$data);

				foreach($kd as $k=>$v){
					if($bobot_penilaian[$k] != 0 || $bobot_penilaian[$k] != ''){
						$bobot_penilaian_result = $bobot_penilaian[$k];
					}
					if(is_array($v)){
						foreach($v as $ks=>$vs){
							$get_post_kd = explode("|", $vs);
							$id_kompetensi = $get_post_kd[0];
							$id_kd = $get_post_kd[1];

							$data = [
								'rencana_id'			=> $rencana->id,
								'kompetensi_id'		=> $kompetensi_id,
								'nama_penilaian'	=> $nama_penilaian[$k],
								'bentuk_penilaian'=> $bentuk_penilaian[$k],
								'bobot_penilaian'	=> $bobot_penilaian_result,
								'kd_id'						=> $id_kd,
								'kd'							=> $id_kompetensi,
							];
							$this->db->insert('rencana_penilaian',$data);
						}
					}
				}

			}
			alertsuccess('message','Berhasil mengubah rencana penilaian '.$redirect);
			redirect('perencanaan/'.$redirect);
		}
	} 

	public function delete_rp($id)
	{
		$rp = $this->db->get_where('rencana_penilaian',['id' => $id])->row();
		$all_rencana = $this->db->get_where('rencana_penilaian',[
			'rencana_id'			=> $rp->rencana_id,
			'kompetensi_id'		=> $rp->kompetensi_id,
			'nama_penilaian'	=> $rp->nama_penilaian
		])->result();

		foreach($all_rencana as $rencana){
			$this->db->delete('rencana_penilaian',['id' => $rencana->id]);
		}
		$status['type'] = 'success';
			$status['text'] = 'Data berhasil dihapus';
			$status['title'] = 'Data Terhapus!';

			echo json_encode($status);
	}

	public function delete($id){
			$this->db->delete('rencana',['id' => $id]);
			$status['type'] = 'success';
			$status['text'] = 'Data berhasil dihapus';
			$status['title'] = 'Data Terhapus!';

		echo json_encode($status);
	}
}