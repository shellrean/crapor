<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
    $this->load->model('M_siswa');
    $this->load->library('form_validation');
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
        'id'                => $siswa->id_siswa,
        'nis'               => $siswa->nis,
        'nisn'              => $siswa->nisn,
        'nama'              => $siswa->nama_siswa,
        'jk'                => $siswa->jk,
        'temp_lahir'        => $siswa->temp_lahir,
        'tgl_lahir'         => $siswa->tgl_lahir,
        'agama'             => $siswa->agama,
        'status_keluarga'   => $siswa->status_keluarga,
        'anak_ke'           => $siswa->anak_ke,
        'alamat'            => $siswa->alamat,
        'telp'              => $siswa->telp,
        'asal_sekolah'      => $siswa->asal_sekolah,
        'kelas_diterima'    => $siswa->kelas_diterima,
        'tgl_diterima'      => $siswa->tgl_diterima,
        'nama_ayah'         => $siswa->nama_ayah,
        'nama_ibu'          => $siswa->nama_ibu,
        'alamat_orangtua'   => $siswa->alamat_orangtua,
        'tlp_ortu'          => $siswa->tlp_ortu,
        'pekerjaan_ayah'    => $siswa->pekerjaan_ayah,
        'pekerjaan_ibu'     => $siswa->pekerjaan_ibu,
        'nama_wali'         => $siswa->nama_wali,
        'telp_wali'         => $siswa->telp_wali,
        'pekerjaan_wali'    => $siswa->pekerjaan_wali,
        'kelas_id'          => 0
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

  public function create()
  {
    if($this->form_validation->run('siswa/create') == false){
      $this->template->load('template','siswa/create');
    }
    else {
      $data = [
        'nis'               => $this->input->post('nis',true),
        'nisn'              => $this->input->post('nisn',true),
        'nama'              => $this->input->post('nama',true),
        'jk'                => $this->input->post('jk',true),
        'temp_lahir'        => $this->input->post('temp_lahir',true),
        'tgl_lahir'         => $this->input->post('tgl_lahir',true),
        'agama'             => $this->input->post('agama',true),
        'status_keluarga'   => $this->input->post('status_keluarga',true),
        'anak_ke'           => $this->input->post('anak_ke',true),
        'alamat'            => $this->input->post('alamat',true),
        'telp'              => $this->input->post('telp_rumah',true),
        'asal_sekolah'      => $this->input->post('asal_sekolah',true),
        'kelas_diterima'    => $this->input->post('kelas_diterima',true),
        'tgl_diterima'      => $this->input->post('tgl_diterima',true),
        'nama_ayah'         => $this->input->post('nama_ayah',true),
        'nama_ibu'          => $this->input->post('nama_ibu',true),
        'alamat_orangtua'   => $this->input->post('alamat_ortu',true),
        'tlp_ortu'          => $this->input->post('telp_ortu',true),
        'pekerjaan_ayah'    => $this->input->post('pekerjaan_ayah',true),
        'pekerjaan_ibu'     => $this->input->post('pekerjaan_ibu',true),
        'nama_wali'         => $this->input->post('nama_wali',true),
        'alamat_wali'       => $this->input->post('alamat_wali',true),
        'telp_wali'         => $this->input->post('telp_wali',true),
        'pekerjaan_wali'    => $this->input->post('pekerjaan_wali',true),

      ];
      $this->db->insert('siswa',$data);
      helper_log("add", "Menambah data siswa");
      alertsuccess('message','Data berhasil ditambah');
      redirect('siswa/index');
    }
  }

  /**
   * Edit data siswa with id_siswa
   * 
   * 
   * @return view
   */
  public function edit($id)
  {
    if($this->form_validation->run('siswa/create') == false)
    {
      $data['siswa'] = $this->db->get_where('siswa', ['id' => $id])->row();
      $this->template->load('template','siswa/edit',$data);
    }
    else {
      $data = [
        'nis'               => $this->input->post('nis',true),
        'nisn'              => $this->input->post('nisn',true),
        'nama'              => $this->input->post('nama',true),
        'jk'                => $this->input->post('jk',true),
        'temp_lahir'        => $this->input->post('temp_lahir',true),
        'tgl_lahir'         => $this->input->post('tgl_lahir',true),
        'agama'             => $this->input->post('agama',true),
        'status_keluarga'   => $this->input->post('status_keluarga',true),
        'anak_ke'           => $this->input->post('anak_ke',true),
        'alamat'            => $this->input->post('alamat',true),
        'telp'              => $this->input->post('telp_rumah',true),
        'asal_sekolah'      => $this->input->post('asal_sekolah',true),
        'kelas_diterima'    => $this->input->post('kelas_diterima',true),
        'tgl_diterima'      => $this->input->post('tgl_diterima',true),
        'nama_ayah'         => $this->input->post('nama_ayah',true),
        'nama_ibu'          => $this->input->post('nama_ibu',true),
        'alamat_orangtua'   => $this->input->post('alamat_ortu',true),
        'tlp_ortu'          => $this->input->post('telp_ortu',true),
        'pekerjaan_ayah'    => $this->input->post('pekerjaan_ayah',true),
        'pekerjaan_ibu'     => $this->input->post('pekerjaan_ibu',true),
        'nama_wali'         => $this->input->post('nama_wali',true),
        'alamat_wali'       => $this->input->post('alamat_wali',true),
        'telp_wali'         => $this->input->post('telp_wali',true),
        'pekerjaan_wali'    => $this->input->post('pekerjaan_wali',true),

      ];
      $this->db->where('id_siswa',$id);
      $this->db->update('siswa',$data);
      helper_log("add", "Mengubah data siswa");
      alertsuccess('message','Data berhasil diubah');
      redirect('siswa/index');
    }
  }
  public function detail($id_siswa)
  {
    $data['siswa'] = $this->db->get_where('siswa',['id' => $id_siswa])->row();
    $this->template->set('modal_title','Detail siswa');
    $this->template->load('modal','siswa/view',$data);
  }
  /**
   * Hapus siswa
   * 
   */
  public function delete($id_siswa)
  {
    $this->db->delete('siswa',['id' => $id_siswa]);
    helper_log("delete", "Menghapus data siswa");

    $data['title'] = 'Sukses';
    $data['text'] = 'Data berhasil dihapus';
    $data['type'] = 'success';
    
    echo json_encode($data);
    
  }

}