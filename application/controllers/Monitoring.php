<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
  }
  public function analisis(){
		// $admin_group = array(1,2,3,5,6);
		// hak_akses($admin_group);
		// $data['ajarans'] = Ajaran::all();
    // $data['rombels'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
    $this->db->from('kelas');
    $this->db->group_by('tingkat');
    $this->db->order_by('tingkat','ASC');
    $data['kelas'] = $this->db->get()->result();
		// $this->template->title('Administrator Panel')
		// ->set_layout($this->admin_tpl)
		// ->set('page_title', 'Analisis Hasil Penilaian')
    // ->build($this->admin_folder.'/monitoring/analisis',$data);
    $this->template->load('template','monitoring/analisis',$data);
	} 

}