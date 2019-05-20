<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    # load helper
    $this->load->helper(array('url', 'file','log','crapor'));
    
    try {
      check_db_connection();
    } catch (Exception $e) {
      redirect('install');
    }

    # cek apakah sudah berhasil install
    if (check_success_install() == false) {
      redirect('install');
    }

  }



}