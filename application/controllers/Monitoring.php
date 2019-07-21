<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
  }
  public function analisis()
  {
    $this->db->from('kelas');
    $this->db->group_by('tingkat');
    $this->db->order_by('tingkat','ASC');
    $data['kelas'] = $this->db->get()->result();
    $this->template->load('template','monitoring/analisis',$data);
	} 

}