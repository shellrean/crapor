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
  public function get_prakerin(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['kelas_id'] = $_POST['kelas_id'];
		$data['siswa_nis'] = $_POST['siswa_nis'];
    $this->load->view('rapor/add_pkl',$data);
	}

}