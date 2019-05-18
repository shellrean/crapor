<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  /**
   * Conctruct all required loaded codeigniter and parented
   * 
   * codeigniter
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('M_log');
  }

  /**
   * Show login page if the user don't login 
   * And show if the validation form is false
   * 
   * 
   * @return view
   */
  public function index()
  {
    $this->_cekLogin();

    $this->form_validation->set_rules('username', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('auth/login');
    } else {
      $this->_login();
    }
  }

  /**
   * Call this method if the user has give validation form is true
   * 
   * 
   * @return boolen
   */
  private function _login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['username' => $username])->row();

    # if the user is find in database
    if ($user) {
      
      # check is user active ?
      if ($user->is_active == 1) {

        # verify if user find
        if (password_verify($password, $user->password)) {

          $query = $this->db->get_where('login',['username' => $username]);

          # make identifer for session 
          $identifer = uniqid(); 
          
          # set all session data and take it in array
          $data = [
            'username' => $user->username,
            'role_id'  => $user->role_id,
            'slug'     => $user->slug,
            'user_craport_identifer' => $identifer,
          ];
          $this->session->set_userdata($data);
          
          # set user agent
          $ip     = get_client_ip_env();
          $device = $this->agent->platform();
          $agent  = agent();

          # check type role of the user
          if ($user->role_id == 1) {

            helper_log("login", "Login | ".$ip." | ".$device." | ".$agent);
            redirect('panel');
            
          } else {

            helper_log("login", "Login | ".$ip." | ".$device." | ".$agent);
            redirect('dashboard');
            
          }
          
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong password!</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      This username has not been activated!</div>');
        redirect('auth');
      }

    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
      Username is not registered!</div>');
      redirect('auth');
    }
  }

  /**
   * Logout from system and destroy all the user sesson
   * redirect user to login view
   * 
   * 
   * @return view
   */
  public function logout()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('role_id');
    $this->session->unset_userdata('slug');
    $this->session->unset_userdata('user_craport_identifer');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been log out!</div>');
    redirect('auth');
  }

  /**
   * Private method for check the user 
   * is user logged
   */
  private function _cekLogin()
  {
    if ($this->session->has_userdata('user_craport_identifer')) {
      if ($this->session->userdata('role_id') == 1) {
        redirect('panel');
      } else {
        redirect('dashboard');
      }
    }
  }
}
