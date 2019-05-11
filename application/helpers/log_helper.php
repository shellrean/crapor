<?php

/**
 * Helper for create log and save to database
 * 
 * params $tipe = "type of log"
 * params $str = string can write to database in desc
 */
function helper_log($tipe = "", $str = ""){
  $CI =& get_instance();

  if (strtolower($tipe) == "login"){
    $log_tipe   = 0;
  }
  elseif(strtolower($tipe) == "logout")
  {
    $log_tipe   = 1;
  }
  elseif(strtolower($tipe) == "add"){
    $log_tipe   = 2;
  }
  elseif(strtolower($tipe) == "edit"){
    $log_tipe  = 3;
  }
  else{
    $log_tipe  = 4;
  }

  $param['user']      = $CI->session->userdata('username');
  $param['tipe']      = $log_tipe;
  $param['desc']      = $str;

  $CI->load->model('M_log');

  $CI->M_log->save_log($param);
}

/**
 * Function for get the clent ip addre
 * 
 * no params required
 */
function get_client_ip_server() {
  $ipaddress = '';
  if ($_SERVER['HTTP_CLIENT_IP'])
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if($_SERVER['HTTP_X_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if($_SERVER['HTTP_X_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if($_SERVER['HTTP_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if($_SERVER['HTTP_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if($_SERVER['REMOTE_ADDR'])
    $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
    $ipaddress = 'UNKNOWN';

  return $ipaddress;
}
function get_client_ip_env() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

/**
 * Get user agent identity where this user login
 * 
 * no params required
 */
function agent() {
  $CI =& get_instance();
  $CI->load->library('user_agent');

  if ($CI->agent->is_browser())
  {
    $agent = $CI->agent->browser().' '.$CI->agent->version();
  }
  elseif ($CI->agent->is_robot())
  {
    $agent = $CI->agent->robot();
  }
  elseif ($CI->agent->is_mobile())
  {
    $agent = $CI->agent->mobile();
  }
  else
  {
    $agent = 'Unidentified User Agent';
  }
  return $agent;
}