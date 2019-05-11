<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors extends CI_Controller
{
  public function index()
  {

  }
  public function denied()
  {
    $this->load->view('errors/403');
  }
}