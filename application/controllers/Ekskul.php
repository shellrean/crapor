<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekskul extends CI_Controller
{

  /**
   * Show all database ekskul and create datatable
   * 
   * @return view
   */
  public function index()
  {
    $this->template->load('template','ekskul/index');
  }

}