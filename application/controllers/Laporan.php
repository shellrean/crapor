<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_login();
  }

  public function rapor()
  {
    $data['query'] = 'waka';
    $data['ajarans'] = $this->db->get('ajaran')->result();
    
    $this->db->from('kelas');
    $this->db->group_by('tingkat');
    $this->db->order_by('tingkat','ASC');
    $data['kelases'] = $this->db->get()->result();

    $this->template->load('template','laporan/rapor',$data);
  }
}