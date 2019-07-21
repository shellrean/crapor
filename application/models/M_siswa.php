<?php

class M_siswa extends CI_Model
{
  public function __construct()
  {

    parent::__construct();

  }

  /**
   * Method untuk sinkron dengan database ke dua Application/config/database.php
   * @return object
   */
  public function sync()
  {
    $db2 = $this->load->database('database_kedua', TRUE);

    return $db2->get_where('siswa',['active' => 1])->result();
  }
}
