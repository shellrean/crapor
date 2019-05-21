<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kompetensi_dasar extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();

    is_login();
  }
  /**
   * Show our dashboard
   * 
   * 
   * @return 
   */
  public function index()
  {
    $ajaran = get_ta(); 
    $guru = get_my_info();

    $this->db->select('kd.*,kurikulum.kelas_id as kelas_id, kurikulum.ajaran_id as ajaran_id, data_mapel.nama_mapel');
    $this->db->from('kd');
    $this->db->join('kurikulum', 'kurikulum.id_mapel = kd.id_mapel','inner');
    $this->db->join('data_mapel','kd.id_mapel = data_mapel.id_mapel','left');
    $this->db->where(['kurikulum.guru_id' => $guru->id,'kurikulum.ajaran_id' => $ajaran->id]);
    $data['result'] = $this->db->get()->result();

    $this->template->load('template','kompetensi_dasar/index',$data);
  }

  /**
   * Create kompetensi dasar
   * 
   * 
   * @return
   */
  public function create()
  {
    $ajaran = get_ta(); 
    $guru = get_my_info();


    $this->db->where('guru_id',$guru->id);
    $this->db->group_by("id_mapel");
    $data['all_mapel'] = $this->db->get('kurikulum')->result();
    $data['kelases'] = $this->db->group_by('tingkat')->get('kelas')->result();
    
    $this->template->load('template','kompetensi_dasar/create',$data);
  }

  /**
   * Edit kompetensi dasar by id
   * 
   * 
   * @return
   */
  public function edit($id)
  {
    $data['kd'] = $this->db->get_where('kd',['id' => $id])->row();
    $this->template->load('template','kompetensi_dasar/edit',$data);
  }
  /**
   * Submit form kompetensi dasar
   * 
   * 
   * @return json
   */
  public function store()
  {
    $data = [
      'id_kd'             => $this->input->post('kd_id',true),
      'aspek'             => $this->input->post('kompetensi_id',true),
      'id_mapel'          => $this->input->post('mapel_id',true),
      'tingkat'           => $this->input->post('kelas',true),
      'kompetensi_dasar'  => $this->input->post('kd_uraian',true),
    ];

    $this->db->insert('kd',$data);

    $status['type'] = 'success';
		$status['text'] = 'Berhasil menambah kompetensi dasar dengan id mapel '. $this->input->post('mapel_id',true);
    $status['title'] = 'Data Tersimpan!';
   
    echo json_encode($status);
  }
  /**
   * Submit form kompetensi dasar for update
   * 
   * 
   * @return json
   */
  public function update($id)
  {
    $data = [
      'id_kd'             => $this->input->post('kd_id',true),
      'kompetensi_dasar'  => $this->input->post('kd_uraian',true),
    ];

    $this->db->update('kd',$data,['id' => $id]);

    $status['type'] = 'warning';
		$status['text'] = 'Berhasil mengubah kompetensi dasar dengan id '. $id;
    $status['title'] = 'Data Tersimpan!';
   
    echo json_encode($status);
  }

  /**
   * Delete kompetensi dasar
   * 
   * 
   * @return json
   */
  public function delete($id)
  {
    $this->db->delete('kd',['id' => $id]);

    helper_log(uniqid(),'Menghapus kompetensi dasar');
    alertsuccess('message','Berhasil menghapus kompetensi dasar');
    redirect('kompetensi_dasar');
  }
   

}