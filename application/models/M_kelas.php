<?php

class M_kelas extends CI_Model
{
  /**
   * Get all class from database and return
   *
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  public function getAllKelas()
  {

    return $this->db->query("
      SELECT j.nama_kurikulum as jurusan, g.name as nama_guru, k.*
	  FROM data_kurikulum j , kelas k, user g
	  WHERE k.jurusan_id = j.kurikulum_id AND k.guru_id=g.id;
    ")->result();

  }

  /**
   * Get all keahlian from databaes selected from data kurikulum
   *
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  public function getAllKeahlian()
  {

    return $this->db->query("
      SELECT * FROM data_kurikulum
	  WHERE kurikulum_id IN (SELECT kurikulum_id FROM keahlian)
    ")->result();

  }

}
