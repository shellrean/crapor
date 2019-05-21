<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panel extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('form_validation');

    is_login();
    is_admin();
    
  }

  public function index()
  {
    $data['count_siswa'] = $this->db->count_all('siswa');
    $data['count_mapel'] = $this->db->count_all('data_mapel');
    $data['count_kelas'] = $this->db->count_all('kelas');

    $this->db->where('role_id', 2);
    $this->db->from('user');
    
    $data['count_user'] = $this->db->count_all_results();
    $this->template->load('template', 'admin/index',$data);
  }

  public function menu()
  {
    $data['menus'] = $this->db->get('menus')->result();
    $this->template->load('template','admin/menu',$data);
  }

  public function delete($id)
  {
    $this->db->delete('menus',['id'=>$id]);
    helper_log("delete", "Menghapus menu");
    alertsuccess('message','Data berhasil dihapus');
    redirect("panel/menu");  
  }
 
  public function create()
  {
    $this->form_validation->set_rules('title','Nama menu','required');
    $this->form_validation->set_rules('link','Link','trim|required');
    $this->form_validation->set_rules('icon','Icon','required');
    $this->form_validation->set_rules('role_id','Role','required');
    $this->form_validation->set_rules('is_main_menu','Main menu','required');

    if($this->form_validation->run() == false) {
      $data['menus'] = $this->db->get_where('menus',['is_main_menu' => 0])->result();
      $this->template->load('template','admin/create',$data);
    } else {
      $data = [
        'title'   => $this->input->post('title'),
        'link'    => $this->input->post('link'),
        'icon'    => $this->input->post('icon'),
        'role' => $this->input->post('role_id'),
        'is_main_menu'  => $this->input->post('is_main_menu')
      ];

      $this->db->insert('menus',$data);
      helper_log("add", "Menambahkan menu");
      alertsuccess('message','Data berhasil ditambahkan');
      redirect("panel/menu");  
    }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('title','Nama menu','required');
    $this->form_validation->set_rules('link','Link','trim|required');
    $this->form_validation->set_rules('icon','Icon','required');
    $this->form_validation->set_rules('role_id','Role','required');
    $this->form_validation->set_rules('is_main_menu','Main menu','required');

    if($this->form_validation->run() == false) {
      $data['menu'] = $this->db->get_where('menus',['id' => $id])->row();
      $data['menus'] = $this->db->get_where('menus',['is_main_menu' => 0])->result();
      $this->template->load('template','admin/edit',$data);
    } else {
      $data = [
        'title'   => $this->input->post('title'),
        'link'    => $this->input->post('link'),
        'icon'    => $this->input->post('icon'),
        'role' => $this->input->post('role_id'),
        'is_main_menu'  => $this->input->post('is_main_menu')
      ];

      $this->db->update('menus',$data,['id' => $id]);
      helper_log("edit",'Mengedit data menu');
      alertsuccess('message','Data berhasil diubah');
      redirect("panel/menu");  
    }
  }
}
