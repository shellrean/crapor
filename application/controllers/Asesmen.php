<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asesmen extends CI_Controller
{

  /**
   * Get page for add prakerin with ajax
   * 
   * 
   * @return
   */
  public function get_prakerin()
  {
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['kelas_id'] = $_POST['kelas_id'];
		$data['siswa_nis'] = $_POST['siswa_nis'];
    $this->load->view('rapor/add_pkl',$data);
  }
  
  /**
   * Get page for ekstrakukikuler with ajax
   * 
   * 
   * @return 
   */
  public function get_ekskul()
  {
    $data['ajaran_id'] = $_POST['ajaran_id'];
		$data['ekskul_id'] = $_POST['ekskul_id'];
    $data['kelas_id'] = $_POST['kelas_id'];
    
    
    $this->load->view('rapor/add_ekskul',$data);
  }

}