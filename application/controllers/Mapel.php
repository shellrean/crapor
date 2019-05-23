<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
    $this->load->library('form_validation');
  }
  /**
   * Show our dashboard 
   * 
   * 
   * @return view
   */
  public function index()
  {
    $this->db->select('*');
    $this->db->from('data_mapel');
    $this->db->join('data_kurikulum', 'data_kurikulum.kurikulum_id = data_mapel.kurikulum_id');
    $query = $this->db->get();

    $data['mapels'] = $query->result();
    $this->template->load('template','mapel/index',$data);
  }

  /**
   * Show create form
   * 
   * 
   * @return view
   */
  public function create()
  {
    if($this->form_validation->run('mapel') == false) {
      
      $this->db->select('*');
      $this->db->from('keahlian');
      $this->db->join('data_kurikulum', 'data_kurikulum.kurikulum_id = keahlian.kurikulum_id');
      $data['jurusans'] = $this->db->get()->result();

      $this->template->load('template','mapel/create',$data);
    }
    else {
      $id_mapel = $this->input->post('kelompok',true).'-'.$this->input->post('id_mapel');
      $data = [
        'id_mapel'      => $id_mapel,
        'nama_mapel'    => $this->input->post('nama_mapel'),
        'kurikulum_id'  => $this->input->post('kurikulum_id'),
        'bobot'         => $this->input->post('bobot'),
        'kelas_X'       => $this->input->post('kelas_X'),
        'kelas_XI'      => $this->input->post('kelas_XI'), 
        'kelas_XII'     => $this->input->post('kelas_XII'),
      ];

      $this->db->insert('data_mapel',$data);

      helper_log("add", "Menambahkan data mapel");
      alertsuccess('message','Data berhasil ditambahkan');
      redirect('mapel');
    }
  }
  /**
   * Edit the mapel field
   * 
   * 
   * @return bool
   */
  public function edit($id_mapel)
  {
    if( $this->form_validation->run('mapel') == false) {

      $this->db->select('*');
      $this->db->from('keahlian');
      $this->db->join('data_kurikulum', 'data_kurikulum.kurikulum_id = keahlian.kurikulum_id');
      $data['jurusans'] = $this->db->get()->result();
      $mapel = $this->db->get_where('data_mapel',['id_mapel' => $id_mapel])->row();
      $data['mapel'] = $mapel;
      $this->template->load('template','mapel/edit',$data);
 
    }
    else {
      $id_mapel = $this->input->post('id_mapel',true);
      $this->db->where('id_mapel',$id_mapel);
      $data = [
        'id_mapel'      => $id_mapel, 
        'nama_mapel'    => $this->input->post('nama_mapel'),
        'kurikulum_id'  => $this->input->post('kurikulum_id'),
        'bobot'         => $this->input->post('bobot'),
        'kelas_X'       => $this->input->post('kelas_X'),
        'kelas_XI'      => $this->input->post('kelas_XI'), 
        'kelas_XII'     => $this->input->post('kelas_XII'),
      ];

      $this->db->update('data_mapel',$data);

      helper_log("update", "Mengubah data mapel");
      alertsuccess('message','Data berhasil diubah');
      redirect('mapel');
    }
  }
  /**
   * Delete matpel indentifier with id_mapel
   * 
   * 
   * @return redirect
   */
  public function delete($id_mapel)
  {
    $this->db->delete('data_mapel',['id_mapel' => $id_mapel]);

    helper_log("delete", "Menghapus data mapel");
    alertsuccess('message','Data berhasil dihapus');
    redirect('mapel');
  }
}