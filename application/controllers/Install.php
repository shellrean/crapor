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

		# laod library
		$this->load->library(array('session', 'template','user_agent','form_validation'));


		try {
			$success = install_success();
			if ($success) {
				redirect('Auth');
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
      case '4':
        if (!empty($this->db_error)) {
          redirect('install/index/2');
        }

		# validate form input
        $this->form_validation->set_rules('username','Username','trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('password1','Password','trim|required|matches[password2]|min_length[3]');
        $this->form_validation->set_rules('password2','Password confirm','trim|required|matches[password1]');

        if($this->form_validation->run() == false) {
          $this->template->load('install','install/step3');
        } else {
          $data = [
            'username'  => $this->input->post('username'),
            'name'      => $this->input->post('name'),
            'nip'       => $this->input->post('nip'),
            'password'  => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
            'role_id'   => 1,
            'is_active' => 1,
            'slug'      => uniqid().generateRandomString(20),
          ];
          $this->db->insert('user',$data);
          alertsuccess('message','Instalasi aplikasi berhasil');
          redirect('Auth');
        }
      break;
      case '3':
        if (!empty($this->db_error)) {
          redirect('install/index/2');
        }

		# validate form input
		$this->form_validation('nama','Nama sekolah','required');
		$this->form_validation('nss','Nss','required');
		$this->form_validation('npsn','Npsn','required');
		$this->form_validation('alamat_sekolah','Alamat sekolah','required');
		$this->form_validation('kode_pos','Kode pos','required');
		$this->form_validation('telp','Telp','required');
		$this->form_validation('faks','Faks','required');
		$this->form_validation('kecamatan','Kecamatan','required');
		$this->form_validation('kota','Kota','required');
		$this->form_validation('provinsi','Provinsi','required');
		$this->form_validation('website','Website','required');
		$this->form_validation('email','Email','required');

        if($this->form_valition->run() == false)
        {
          $data = [
            'nama'      => $this->input->post('nama',true),
            'nss'       => $this->input->post('nss',true),
            'npsn'      => $this->input->post('npsn',true),
            'alamat_sekolah' => $this->input->post('alamat_sekolah',true),
            'kode_pos'  => $this->input->post('kode_pos',true),
            'telp'      => $this->input->post('telp',true),
            'faks'      => $this->input->post('faks',true),
            'kecamatan' => $this->input->post('kecamatan',true),
            'kabupaten' => $this->input->post('kota',true),
            'provinsi'  => $this->input->post('provinsi',true),
            'website'   => $this->input->post('website',true),
            'email'     => $this->input->post('email',true),
          ];
          $this->db->insert('data_sekolah',$data);
          redirect('install/index/4');
        } else {
          $this->template->load('install','install/step2');
        }
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
