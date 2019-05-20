<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Install extends CI_Controller
{
    private $db_error;
    private $prefix;

    function __construct()
    {
      parent::__construct();


      # load helper
      $this->load->helper(array('url', 'file','log','crapor'));

      $this->load->library(array('session', 'template','user_agent'));

    try {
        $success = install_success();
        if ($success) {
            redirect('login');
        }
    } catch (Exception $e) {
        $this->db_error = $e->getMessage();
    }
 
    if (empty($this->db_error)) {
        $this->load->database();

            include APPPATH . 'config/database.php';

            $this->prefix = $db['default']['dbprefix'];

            # load model
            $this->load->model([
              'M_config'
            ]);
            # load session
            $this->load->library('session');
        }
    }

  public function index($step = '')
  {
    switch ($step) {
      case '3': 

      break;
      case '2':
        if (empty($this->db_error)) {
          # cek tabel pengaturan, jika sudah ada lanjut ke step 2
          if ($this->db->table_exists('setting')) {
            redirect('install/index/3');
          }

          $this->db->trans_start();

          $this->M_config->create_default_table("all");
            redirect('install/index/3');
        }

        $set_base_url = explode('index.php', current_url());
        $data['set_base_url'] = $set_base_url[0];

        $ambil_error = "";
        if (!empty($this->db_error)) {
            $ambil_error = get_alert('danger', $this->db_error);
        }
        $data['error'] = $ambil_error; 
        $this->template->load('install','install/step1', $data);
      break;

      case '1':
      default:
        $this->template->load('install','setup');
      break;
    }
  }

}