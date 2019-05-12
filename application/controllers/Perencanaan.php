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
    // $guru = get_my_info();
    
    $data['ajarans'] = $this->db->get('ajaran')->result();
		
		
    // $loggeduser = $this->ion_auth->user()->row();
		$guru 	= get_my_info();
		 

    
    // if($loggeduser->data_guru_id){
			// $data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
			
			$this->db->from('kurikulum');
			$this->db->group_by(['kelas_id']);
			$this->db->order_by('kelas_id','ASC');
			$this->db->where(['guru_id' => $guru->id]);
			$data_mapel = $this->db->get()->result();
			
			

      // $data_mapel = $this->db->get_where('kurilulum',['guru_id' => $guru->id])->result();

			// var_dump($data_mapel);
			
      foreach($data_mapel as $datamapel){
				$rombel_id[] = $datamapel->kelas_id;
			}
			if(isset($rombel_id)){
				$id_rombel = $rombel_id;
			} else {
				$id_rombel = array();
			}
			// $data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $id_rombel)));
			// $rombels = $this->db->get_where('data_rombel',['id' => $id_rombel])->result();
			
			$this->db->from('kelas');
			$this->db->where_in('id',$id_rombel);
			$data['rombels'] = $this->db->get()->result();
		// } else {
		// 	$data['rombels'] = Datarombel::all();
    // }
    

		// $data['kelas'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->db->from('kelas');
		$this->db->group_by(['tingkat']);
		$this->db->order_by('tingkat','ASC');
		$data['kelas'] = $this->db->get()->result();

		// $this->template->title('Administrator Panel')
		// ->set_layout($this->admin_tpl)
		// ->set('form_action', 'admin/perencanaan/simpan_perencanaan')
		// ->set('page_title', 'Perencanaan Penilaian Pengetahuan')
		// ->set('query', 'kd')
		// ->set('kompetensi_id', 1)
		// ->build($this->admin_folder.'/perencanaan/add_perencanaan',$data);
		$data['form_action'] 	= 'perencanaan/simpan_perencanaan';
		$data['query']				= 'kd';
		$this->template->load('template','perencanaan/add_perencanaan',$data);
  }
}