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
        "catatan",
        "data_kurikulum",
        "data_mapel",
        "data_sekolah",
        "ekskul",
        "kd",
        "keahlian",
        "kelas",
        "kurikulum",
        "log",
        "login",
        "login_log",
        "menus",
        "metode",
        "nilai",
        "nilaiakhir",
        "nilai_ekskul",
        "notif",
        "perkembangan_karakter",
        "pkl",
        "remedial",
        "rencana",
        "rencana_penilaian",
        "role_khusus",
        "setting",
        "siswa",
        "user",
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
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}anggota_kelas` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nis` varchar(255) DEFAULT NULL,
      `id_kelas` int(11) UNSIGNED DEFAULT NULL,
      `ajaran_id` int(11) UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel catatan
   */
  public function create_tb_catatan()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}catatan` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kelas_id` int(11) NOT NULL,
      `siswa_nis` int(11) NOT NULL,
      `uraian_deskripsi` longtext CHARACTER SET utf8 NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel 
   */
  public function create_tb_data_kurikulum()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}data_kurikulum` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `kurikulum_id` int(11) NOT NULL,
      `nama_kurikulum` text CHARACTER SET utf8 NOT NULL,
      `bidang_keahlian` text,
      `program_keahlian` text,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->db->query("INSERT INTO `data_kurikulum` (`id`, `kurikulum_id`, `nama_kurikulum`, `bidang_keahlian`, `program_keahlian`) VALUES
    (300, 642, 'Otomatisasi Dan Tata Kelola Perkantoran', 'Bisnis dan Manajemen', 'Manajemen Perkantoran'),
    (301, 643, 'Akuntansi dan Keuangan Lembaga', 'Bisnis dan Manajemen', 'Akuntansi dan Keuangan'),
    (302, 644, 'Bisnis Daring dan Pemasaran', 'Bisnis dan Manajemen', 'Bisnis dan Pemasaran'),
    (303, 218, 'Teknik komputer dan jaringan', 'Teknologi Informasi dan Komunikasi', 'Teknik Komputer dan Informatika');
    ");
  }
  /**
   * Method untuk membuat tabel data_mapel
   */
  public function create_tb_data_mapel()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}data_mapel` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `id_mapel` varchar(128) NOT NULL,
      `nama_mapel` varchar(255) NOT NULL,
      `kurikulum_id` varchar(32) NOT NULL,
      `kelas_X` int(11) DEFAULT '0',
      `kelas_XI` int(11) DEFAULT '0',
      `kelas_XII` int(11) DEFAULT '0',
      `bobot` varchar(10) DEFAULT '50:50',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel data_sekolah
   */
  public function create_tb_data_sekolah()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}data_sekolah` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nama` varchar(128) NOT NULL,
      `nss` varchar(128) NOT NULL,
      `npsn` varchar(128) NOT NULL,
      `alamat_sekolah` varchar(128) NOT NULL,
      `kode_pos` varchar(128) NOT NULL,
      `telp` varchar(128) NOT NULL,
      `faks` varchar(128) NOT NULL,
      `kecamatan` varchar(128) NOT NULL,
      `kabupaten` varchar(128) NOT NULL,
      `provinsi` varchar(128) NOT NULL,
      `website` varchar(128) NOT NULL,
      `email` varchar(128) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel ekskul
   */
  public function create_tb_ekskul()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}ekskul` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `guru_id` int(11) NOT NULL,
      `nama_ekskul` varchar(255) NOT NULL,
      `nama_ketua` varchar(255) NOT NULL,
      `nomor_kontak` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel kd
   */
  public function create_tb_kd()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}kd` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `id_kd` varchar(64) NOT NULL,
      `aspek` varchar(64) NOT NULL,
      `id_mapel` varchar(32) NOT NULL,
      `tingkat` varchar(8) NOT NULL,
      `kompetensi_dasar` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel keahlian
   */
  public function create_tb_keahlian()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}keahlian` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `kurikulum_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel kelas
   */
  public function create_tb_kelas()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}kelas` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `guru_id` int(11) NOT NULL,
      `tingkat` int(11) NOT NULL,
      `jurusan_id` int(11) NOT NULL,
      `nama` varchar(128) NOT NULL,
      `slug` varchar(255) DEFAULT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel kurikulum
   */
  public function create_tb_kurikulum()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}kurikulum` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `ajaran_id` varchar(64) DEFAULT NULL,
      `kelas_id` varchar(64) DEFAULT NULL,
      `id_mapel` varchar(64) DEFAULT NULL,
      `guru_id` varchar(64) DEFAULT NULL,
      `keahlian_id` varchar(64) DEFAULT NULL,
      `kkm` int(11) DEFAULT '75',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method unntuk membuat tabel log
   */
  public function create_tb_log()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}log` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `tipe` varchar(100) NOT NULL,
      `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `user` varchar(128) DEFAULT NULL,
      `desc` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel login
   */
  public function create_tb_login()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}login` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(128) NOT NULL,
      `identifer` varchar(255) DEFAULT NULL,
      `time` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat login_log
   */
  public function create_tb_login_log()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}login_log` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `login_id` int(11) NOT NULL,
      `lasttime` datetime NOT NULL,
      `agent` text NOT NULL,
      `last_activity` int(10) UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel menu
   */
  public function create_tb_menus()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}menus` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` varchar(50) DEFAULT NULL,
      `link` varchar(50) DEFAULT NULL,
      `icon` varchar(50) DEFAULT NULL,
      `is_main_menu` int(2) DEFAULT NULL,
      `role` int(1) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    $this->db->query("INSERT INTO `{$this->db->dbprefix}menus` (`id`, `title`, `link`, `icon`, `is_main_menu`, `role`) VALUES
    (1, 'Dashboard', 'panel', 'fas fa-fw fa-tachometer-alt', 0, 1),
    (3, 'Management', 'management', 'fas fa-fw fa-object-ungroup', 0, 1),
    (4, 'User akun', 'user', 'fas fa-fw fa-circle-notch', 3, 1),
    (5, 'Menu manage', 'panel/menu', 'fas fa-fw fa-circle-notch', 3, 1),
    (8, 'Configurasi', 'config', 'fas fa-fw fa-circle-notch', 3, 1),
    (9, 'Home', 'dashboard', 'fas fa-fw fa-home', 0, 2),
    (15, 'Profile sekolah', 'config/sekolah', 'fas fa-fw fas fa-fw fa-school', 0, 1),
    (16, 'Data master', 'data_master', 'fas fa-fw fa-server', 0, 1),
    (17, 'Siswa', 'siswa', 'fas fa-fw fa-circle-notch', 16, 1),
    (18, 'Kelas', 'kelas', 'fas fa-fw fa-circle-notch', 16, 1),
    (19, 'Mapel', 'mapel', 'fas fa-fw fa-circle-notch', 16, 1),
    (20, 'Komptensi dasar', 'kompetensi_dasar', 'fab fa-fw fa-red-river', 0, 2),
    (21, 'Perencanaan', 'perencanaan', 'fas fa-fw fa-pencil-ruler', 0, 2),
    (22, 'Pengetahuan', 'perencanaan/pengetahuan', 'fas fa-fw fa-circle-notch', 21, 2),
    (23, 'Keterampilan', 'perencanaan/keterampilan', 'fas fa-fw fa-circle-notch', 21, 2),
    (24, 'Rapor hasil belajar', 'rapor', 'fab fa-fw fa-readme', 0, 3),
    (25, 'Catatan wali kelas', 'rapor/catatan', 'fas fa-fw fa-circle-notch', 24, 3),
    (26, 'Praktik kerja lapangan', 'rapor/pkl', 'fas fa-fw fa-circle-notch', 24, 3),
    (27, 'Absensi', 'rapor/absen', 'fas fa-fw fa-circle-notch', 24, 3),
    (28, 'Ekstrakurikuler', 'rapor/ekskul', 'fas fa-fw fa-circle-notch', 24, 3),
    (29, 'Karakter', 'rapor/perkembangan_karakter', 'fas fa-fw fa-circle-notch', 24, 3),
    (30, 'Cetak ledger', 'rapor/cetak_ledger', 'fas fa-fw fa-circle-notch', 24, 2),
    (31, 'Ekstrakurikuler', 'ekskul', 'fas fa-fw fa-circle-notch', 16, 1),
    (33, 'Penilaian', 'penilaian', 'fas fa-fw fa-boxes', 0, 2),
    (34, 'Pengetahuan', 'penilaian/pengetahuan', 'fas fa-fw fa-circle-notch', 33, 2),
    (35, 'Keterampilan', 'penilaian/keterampilan', 'fas fa-fw fa-circle-notch', 33, 2),
    (36, 'Remedial', 'penilaian/remedial', 'fas fa-fw fa-circle-notch', 33, 2),
    (37, 'Analisis', 'monitoring', 'fab fa-fw fa-think-peaks', 0, 2),
    (38, 'Hasil penilaian', 'monitoring/analisis', 'fas fa-fw fa-circle-notch', 37, 2),
    (39, 'Role khusus', 'user/khusus', 'fas fa-fw fa-circle-notch', 3, 1),
    (40, 'Laporan', 'laporan', 'fas fa-fw fa-circle-notch', 0, 4),
    (41, 'Rapor hasil belajar', 'laporan/rapor', 'fas fa-fw fa-circle-notch', 40, 4),
    (42, 'Cetak rapor', 'rapor/cetak_rapor', 'fas fa-fw fa-circle-notch', 24, 2);");
  }
  /**
   * Method untuk membuat tabel metode
   */
  public function create_tb_metode()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}metode` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kompetensi_id` int(2) NOT NULL,
      `nama_metode` varchar(100) CHARACTER SET utf8 NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel nilai
   */
  public function create_tb_nilai()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}nilai` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kompetensi_id` int(11) NOT NULL,
      `kelas_id` varchar(11) NOT NULL,
      `mapel_id` varchar(255) NOT NULL,
      `data_siswa_nis` varchar(11) NOT NULL,
      `rencana_penilaian_id` varchar(255) NOT NULL,
      `nilai` varchar(255) NOT NULL,
      `rerata` varchar(11) NOT NULL,
      `rerata_jadi` varchar(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel nilaiakhir
   */
  public function create_tb_nilaiakhir()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}nilaiakhir` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kompetensi_id` int(11) NOT NULL,
      `kelas_id` varchar(11) NOT NULL,
      `mapel_id` varchar(255) NOT NULL,
      `data_siswa_nis` varchar(11) NOT NULL,
      `rencana_penilaian_id` int(11) NOT NULL,
      `rerata_nilai` varchar(255) NOT NULL,
      `nilai` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel nilai_ekskul
   */
  public function create_tb_nilai_ekskul()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}nilai_ekskul` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `ekskul_id` int(11) NOT NULL,
      `kelas_id` varchar(11) NOT NULL,
      `siswa_nis` varchar(11) NOT NULL,
      `nilai` varchar(255) NOT NULL,
      `deskripsi_ekskul` longtext NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /** 
   * Method untuk membuat tabel notifikasi
   */
  public function create_tb_notif()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}notif` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` int(5) NOT NULL,
      `icon` varchar(255) NOT NULL,
      `bg` varchar(50) NOT NULL,
      `title` varchar(255) NOT NULL,
      `notif` text NOT NULL,
      `showed` int(11) NOT NULL,
      `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel perkembangan karakter
   */
  public function create_tb_perkembangan_karakter()
  {
    $this->db->query(" CREATE TABLE `{$this->db->dbprefix}perkembangan_karakter` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kelas_id` int(11) NOT NULL,
      `siswa_nis` varchar(50) NOT NULL,
      `integritas` text DEFAULT NULL,
      `religius` text DEFAULT NULL,
      `nasionalis` text DEFAULT NULL,
      `mandiri` text DEFAULT NULL,
      `gotong_royong` text DEFAULT NULL,
      `catatan` text DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel pkl
   */
  public function create_tb_pkl()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}pkl` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kelas_id` int(11) NOT NULL,
      `siswa_nis` varchar(11) NOT NULL,
      `mitra_prakerin` varchar(255) CHARACTER SET utf8 NOT NULL,
      `lokasi_prakerin` varchar(255) NOT NULL,
      `lama_prakerin` varchar(255) NOT NULL,
      `keterangan_prakerin` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel remedial
   */
  public function create_tb_remedial()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}remedial` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ajaran_id` int(11) NOT NULL,
      `kompetensi_id` int(11) NOT NULL,
      `kelas_id` varchar(11) NOT NULL,
      `mapel_id` varchar(255) NOT NULL,
      `data_siswa_nis` varchar(11) NOT NULL,
      `nilai` text NOT NULL,
      `rerata_akhir` varchar(255) NOT NULL,
      `rerata_remedial` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
  /**
   * Method untuk membuat tabel rencana
   */
  public function create_tb_rencana()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}rencana` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `ajaran_id` varchar(4) NOT NULL,
      `id_mapel` varchar(64) NOT NULL,
      `kelas_id` varchar(64) NOT NULL,
      `kompetensi_id` varchar(64) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel rencana penilaian
   */
  public function create_tb_rencana_penilaian()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}rencana_penilaian` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `rencana_id` int(11) NOT NULL,
      `kompetensi_id` int(11) NOT NULL,
      `nama_penilaian` varchar(255) NOT NULL,
      `bentuk_penilaian` int(11) NOT NULL,
      `bobot_penilaian` int(11) NOT NULL,
      `keterangan_penilaian` varchar(255) NOT NULL,
      `kd_id` int(11) NOT NULL,
      `kd` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel role khusus
   */
  public function create_tb_role_khusus()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}role_khusus` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `guru_id` int(11) NOT NULL,
      `role_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel setting
   */
  public function create_tb_setting()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}setting` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `periode` varchar(128) NOT NULL DEFAULT '',
      `rumus` int(11) NOT NULL,
      `kepsek` varchar(255) DEFAULT NULL,
      `nip_kepsek` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $this->db->query("INSERT INTO `setting` (`id`, `periode`, `rumus`, `kepsek`, `nip_kepsek`) VALUES
    (1, '2018/2019 | Semester Ganjil', 1, '- ', '-');");
  }
  /**
   * Method untuk membuat tabel siswa
   */
  public function create_tb_siswa()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}siswa` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nis` varchar(15) NOT NULL,
      `nisn` varchar(200) NOT NULL,
      `nama` varchar(100) NOT NULL DEFAULT '',
      `jk` enum('L','P') DEFAULT NULL,
      `temp_lahir` varchar(15) NOT NULL,
      `tgl_lahir` varchar(50) NOT NULL,
      `agama` varchar(50) NOT NULL,
      `status_keluarga` varchar(15) NOT NULL,
      `anak_ke` int(12) NOT NULL,
      `alamat` text NOT NULL,
      `telp` varchar(15) NOT NULL,
      `asal_sekolah` varchar(100) NOT NULL,
      `kelas_diterima` varchar(12) NOT NULL,
      `tgl_diterima` varchar(50) NOT NULL,
      `nama_ayah` varchar(100) NOT NULL,
      `nama_ibu` varchar(100) NOT NULL,
      `alamat_orangtua` text NOT NULL,
      `tlp_ortu` varchar(24) DEFAULT NULL,
      `pekerjaan_ayah` varchar(50) DEFAULT NULL,
      `pekerjaan_ibu` varchar(50) DEFAULT NULL,
      `nama_wali` varchar(100) DEFAULT NULL,
      `alamat_wali` text,
      `telp_wali` varchar(15) DEFAULT NULL,
      `pekerjaan_wali` varchar(50) DEFAULT NULL,
      `foto` varchar(255) NOT NULL DEFAULT 'default-siswa.png',
      `kelas_id` int(11) NOT NULL DEFAULT '0',
      `active` int(11) NOT NULL DEFAULT '1',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }
  /**
   * Method untuk membuat tabel user
   */
  public function create_tb_user()
  {
    $this->db->query("CREATE TABLE `{$this->db->dbprefix}user` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `username` varchar(128) DEFAULT NULL,
      `password` varchar(255) DEFAULT NULL,
      `name` varchar(128) DEFAULT NULL,
      `nip` varchar(128) DEFAULT NULL,
      `role_id` int(1) DEFAULT NULL,
      `is_active` int(1) DEFAULT NULL,
      `image` varchar(255) DEFAULT 'default.png',
      `slug` varchar(255) DEFAULT NULL,
      `login` int(1) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  }
}