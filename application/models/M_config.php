<?php

/**
 * Class Model untuk Config
 *
 * @package Crapor
 * @author Kuswandi <wandinak17@gmail.com>
 */
class M_config extends CI_Model
{
  /**
   * Method untuk membuat tabel-tabel default pada aplikasi
   * @param  string $table  bisa all atau nama_tabelnya tanpa prefix
   * @return boolean
   */
  public function create_default_table($table = "all")
  {
    $default_table = array(
        "absen",
        "ajaran",
        "anggota_kelas",
        // "catatan",
        // "data_kurikulum",
        // "data_mapel",
        // "data_sekolah",
        // "ekskul",
        // "kd",
        // "keahlian",
        // "kelas",
        // "kurikulum",
        // "log",
        // "login",
        // "login_log",
        // "menus",
        // "metode",
        // "nilai",
        // "nilaiakhir",
        // "nilai_ekskul",
        // "pkl",
        // "remedial",
        // "rencana",
        // "rencana_penilaian",
        // "role_khusus",
        // "setting",
        // "siswa",
        // "user",
    );

    if ($table == "all") {
        foreach ($default_table as $tb) {
            $nama_fungsi = "create_tb_{$tb}";
            $this->$nama_fungsi();
        }
    } elseif (in_array($table, $default_table)) {
        $nama_fungsi = "create_tb_{$table}";
        $this->$nama_fungsi();
    }

    return true;
  }

  /**
   * Method untuk membuat tabel absen
   */
  public function create_tb_absen()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}absen` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kelas_id` int(11) NOT NULL,
      `siswa_nis` int(11) NOT NULL,
      `sakit` int(11) NOT NULL,
      `izin` int(11) NOT NULL,
      `alpa` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat table ajaran
   */
  public function create_tb_ajaran()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}ajaran` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tahun` varchar(128) NOT NULL,
      `smt` varchar(128) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat table anggota kelas
   */
  public function create_tb_anggota_kelas()
  {
    $this->db->query("CREATE TABLE `anggota_kelas` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nis` int(11) DEFAULT NULL,
      `id_kelas` int(11) UNSIGNED DEFAULT NULL,
      `ajaran_id` int(11) UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
}