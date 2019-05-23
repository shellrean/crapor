<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
    $this->load->model('M_siswa');
  }
  /**
   * Show all database siswa and create datatable
   * 
   * @return view
   */ 
  public function index()
  {
    $data['siswas'] = $this->db->get('siswa')->result();
    $this->template->load('template','siswa/index',$data);
  }

  /**
   * Sinkron database
   * 
   * @return ajax
   */
  public function sync()
  {

    $siswas = $this->M_siswa->sync();
    
    $no = 1; 
    foreach($siswas as $siswa) {
      $data = [
        'id'    => $siswa->id_siswa,
        'nis'   => $siswa->nis,
        'nisn'  => $siswa->nisn,
        'nama' => $siswa->nama_siswa,
        'jk'    => $siswa->jk,
        'temp_lahir' => $siswa->temp_lahir,
        'tgl_lahir' => $siswa->tgl_lahir,
        'agama' => $siswa->agama,
        'status_keluarga' => $siswa->status_keluarga,
        'anak_ke' => $siswa->anak_ke,
        'alamat' => $siswa->alamat,
        'telp'    => $siswa->telp,
        'asal_sekolah' => $siswa->asal_sekolah,
        'kelas_diterima' => $siswa->kelas_diterima,
        'tgl_diterima' => $siswa->tgl_diterima,
        'nama_ayah' => $siswa->nama_ayah,
        'nama_ibu'  => $siswa->nama_ibu,
        'alamat_orangtua' => $siswa->alamat_orangtua,
        'tlp_ortu' => $siswa->tlp_ortu,
        'pekerjaan_ayah' => $siswa->pekerjaan_ayah,
        'pekerjaan_ibu' => $siswa->pekerjaan_ibu,
        'nama_wali' => $siswa->nama_wali,
        'telp_wali' => $siswa->telp_wali,
        'pekerjaan_wali' => $siswa->pekerjaan_wali,
        'kelas_id' => 0
      ];
      $this->db->insert('siswa',$data);
      $no ++;
    }
    
    echo json_encode(['jumlah' => $no]);

  }

  /**
   * Truncate table
   * 
   * 
   * 
   */
  public function drop()
  {
    $this->db->truncate('siswa');
  }


}