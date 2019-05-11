<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  public function __construct()
  {
    
    parent::__construct();

  }

  /**
   * Show our dashboard
   * 
   * 
   * @return view
   */
  public function index()
  {
    $this->template->load('template','dashboard/index');
  }

  /**
   * Show all data get from id kelas
   * 
   * 
   * @return view
   */
  public function siswa()
  {
    $guru = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row();
    $kelas = $this->db->get_where('kelas',['guru_id' => $guru->id])->row();
    $data['siswas'] = $this->db->get_where('siswa',['kelas_id' => $kelas->id])->result();
    $this->template->load('template','dashboard/siswa',$data);
  }
}