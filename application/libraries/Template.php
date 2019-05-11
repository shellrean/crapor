<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template
{
  var $template_data = array();

  function set($name, $value)
  {
    $this->template_data[$name] = $value;
  }

  function load($template = '', $view = '', $view_data = array(), $return = false)
  {
    $this->CI = &get_instance();
    $this->set('content_view', $this->CI->load->view($view, $view_data, true));
    return $this->CI->load->view($template, $this->template_data, $return);
  }
}
