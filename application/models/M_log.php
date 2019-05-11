<?php
class M_log extends CI_Model
{ 
  public function save_log($param)
  {
      $sql        = $this->db->insert_string('log',$param);
      $ex         = $this->db->query($sql);
      return $this->db->affected_rows($sql);
  }
}