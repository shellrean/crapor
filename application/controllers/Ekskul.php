<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekskul extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->library('form_validation');
  }

  /**
   * Show all database ekskul and create datatable
   * 
   * @return view
   */
  public function index()
  {
    
    $this->db->from('ekskul');
    $this->db->order_by('id','ASC');
    
    $data['ekskuls'] = $this->db->get()->result();

    $this->template->load('template','ekskul/index',$data);
  } 

  /**
   * Create ekskul
   * 
   * @return
   */
  public function create()
  {
    $data['ajarans'] = $this->db->get('ajaran')->result();
    
    # selected query builder
    $this->db->from('kelas');
    $this->db->group_by(['tingkat']);
    $this->db->order_by('tingkat','ASC');
    $data['kelases'] = $this->db->get()->result();
    $data['form_action'] = 'ekskul/store';

    $data['data_guru'] = $this->db->get_where('user',['role_id' => 2])->result();
    $this->template->load('template','ekskul/create',$data);
  }

  /**
   * Store ekskul
   * 
   * 
   * @return
   */
  public function store()
  {
    $data = [
      'ajaran_id'     => $this->input->post('ajaran_id',true),
      'guru_id'       => $this->input->post('guru_id',true),
      'nama_ekskul'   => $this->input->post('nama_ekskul',true),
      'nama_ketua'    => $this->input->post('nama_ketua',true),
      'nomor_kontak'  => $this->input->post('nomor_kontak',true)
    ];

    helper_log(uniqid(),'Menambahkan ekskul');
    $this->db->insert('ekskul',$data);

    alertsuccess('message','Berhasil menambahkan data ekskul');
		redirect('ekskul');

  }

  /**
   * Delete ekskul
   * 
   * @param id
   */
  public function delete($id)
  {
    $this->db->delete('ekskul',['id' => $id]);
    helper_log(uniqid(),'Menghapus ekskul');

    alertsuccess('message','Berhasil menghapus  data ekskul');
    redirect('ekskul');
  }

  /**
   * Edit ekskul
   * 
   * 
   * @param id
   */
  public function edit($id)
  {
    $data['form_action'] = 'ekskul/update/'.$id;
    $data['ekskul'] = $this->db->get_where('ekskul',['id' => $id])->row();

    $data['data_guru'] = $this->db->get_where('user',['role_id' => 2])->result();
    $this->template->load('template','ekskul/edit',$data);
  }

  /**
   * Update 
   * 
   * 
   * @param id
   */
  public function update($id)
  {
    $data = [
      'ajaran_id'     => $this->input->post('ajaran_id',true),
      'guru_id'       => $this->input->post('guru_id',true),
      'nama_ekskul'   => $this->input->post('nama_ekskul',true),
      'nama_ketua'    => $this->input->post('nama_ketua',true),
      'nomor_kontak'  => $this->input->post('nomor_kontak',true)
    ];

    helper_log(uniqid(),'Mengubah data ekskul');
    $this->db->update('ekskul',$data,['id' => $id]);

    alertsuccess('message','Berhasil mengubah data ekskul');
		redirect('ekskul');
  }

}