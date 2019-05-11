<?php

class M_kelas extends CI_Model 
{
  /**
   * Get all class from database and return
   * 
   * @return 
   */
  public function getAllKelas()
  {

    return $this->db->query("
      SELECT J.nama_kurikulum as jurusan, G.name as nama_guru, K.* FROM data_kurikulum J , kelas k, user G WHERE k.jurusan_id = J.kurikulum_id AND k.guru_id=g.id;
    ")->result();

  }

  /**
   * Get all keahlian from databaes selected from data kurikulum
   * 
   * 
   * @return 
   */
  public function getAllKeahlian()
  {

    return $this->db->query("
      SELECT * FROM data_kurikulum WHERE kurikulum_id IN (SELECT kurikulum_id FROM keahlian)
    ")->result();

  }

}