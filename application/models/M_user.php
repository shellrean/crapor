<?php
class M_user extends CI_Model
{ 
  public function __construct()
  {
    parent::__construct();
  }

  public function upload_file($filename){
    /* Load librari upload */
    $this->load->library('upload'); 
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
    
    /* Load konfigurasi uploadnya */
    $this->upload->initialize($config);
    
    /* Lakukan upload dan Cek jika proses upload berhasil */
		if($this->upload->do_upload('file')){ 

		/* Jika berhasil */
		$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
		return $return;
		}else{

		/* Jika gagal */
		$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
		return $return;
		}
	}
	

}