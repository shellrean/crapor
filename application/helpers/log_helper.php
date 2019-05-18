<?php
defined('BASEPATH') or exit('No direct script access allowed');

/** 
 * ########################################################################################
 * Herlper log
 * ########################################################################################
 * @package   crapor
 * @author    Kuswandi <wandinak17@gmail.com>
 * @copyright Copyright (c) 2018 - 2019
 * @since     1.0
 *
 * #######################################################################################
 */

  /**
   * Helper untuk membuat log
   * @param  string $log_tipe
   * @param  string $str
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function helper_log($log_tipe = "", $str = ""){
    $CI =& get_instance();

    $param = [
      'user'      => $CI->session->userdata('username'),
      'tipe'      => $log_tipe,
      'desc'      => $str. ' |'.get_client_ip_env().' | '.agent(),
    ];

    $CI->load->model('M_log');

    $CI->M_log->save_log($param);
  }

  /**
   * Helper untuk mendapatkan ip server
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
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

  /**
   * Helper untuk mendapatkan ip client
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
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
   * Helper untuk mendapatkan agent user
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
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

  /**
   * Helper untuk mendapatkan ip
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_ip()
  {
    return $_SERVER['REMOTE_ADDR'];
  }