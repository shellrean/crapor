<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
{

  /**
   * Construct parrent controller and
   *
   * 
   */
  public function __construct()
  {
    parent::__construct();
    
    is_login();

    $this->load->model('M_kelas');
    $this->load->model('M_admin');
    $this->load->library('form_validation');
  }

  /**
   * Show all database kelas and create datatable
   * 
   * 
   * @return view
   */
  public function index()
  {

    $data = [

      'ajaran'    => get_ta(),
      'kelases'   => $this->M_kelas->getAllKelas(),
    
    ];
    $this->template->load('template','kelas/index',$data);
  
  }

  /**
   * Create  klasses
   * 
   * @return boolean
   */
  public function create()
  {
    # make form validation
    $this->form_validation->set_message('is_unique', 'Teacher is already taken');
    $this->form_validation->set_rules('name','Name','required|trim');
    $this->form_validation->set_rules('wali_kelas','Wali kelas','required|is_unique[kelas.guru_id]|trim');
    $this->form_validation->set_rules('jurusan','Jurusan','required|trim');
    $this->form_validation->set_rules('tingkat','Tingkat','required|in_list[10,11,12]|trim');

    if($this->form_validation->run() == false)
    {
      $data =  [
        'gurus'     => $this->db->get_where('user',['role_id' => 2])->result(),
        'keahlians' => $this->M_kelas->getAllKeahlian(),
      ];

      $this->template->load('template','kelas/create',$data);
    }
    else {
      $data = [
        'guru_id'       => $this->input->post('wali_kelas',true),
        'tingkat'       => $this->input->post('tingkat',true),
        'jurusan_id'    => $this->input->post('jurusan',true),
        'nama'          => $this->input->post('name',true),
        'slug'          => uniqid().generateRandomString().time(),
      ];

      $this->db->insert('kelas',$data);

      # finaly code
      helper_log("add", "Menambahkan data kelas");
      alertsuccess('message','Data berhasil ditambahkan');
      redirect('kelas');
    }
  }

  /**
   * Edit kelas by id query from url
   * 
   * @param id_kelas
   */
  public function edit($slug_kelas)
  {
    # make form validation
    $this->form_validation->set_rules('name','Name','required|trim');
    $this->form_validation->set_rules('wali_kelas','Wali kelas','required|trim');
    $this->form_validation->set_rules('jurusan','Jurusan','required|trim');
    $this->form_validation->set_rules('tingkat','Tingkat','required|in_list[10,11,12]|trim');

    if($this->form_validation->run() == false) 
    {

      $data = [
        'gurus'     => $this->db->get_where('user',['role_id' => 2])->result(),
        'keahlians' => $this->M_kelas->getAllKeahlian(),
        'kelas'     => $this->db->get_where('kelas',['slug' => $slug_kelas])->row(),
      ];
      $this->template->load('template','kelas/edit',$data);

    }
    else {

      $data = [
        'guru_id'       => $this->input->post('wali_kelas',true),
        'tingkat'       => $this->input->post('tingkat',true),
        'jurusan_id'    => $this->input->post('jurusan',true),
        'nama'          => $this->input->post('name',true),
        'slug'          => uniqid().generateRandomString().time(),
      ];
      $this->db->update('kelas',$data,['slug' => $slug_kelas]);

      # finaly code
      helper_log("update", "Mengubah data kelas");
      alertsuccess('message','Data berhasil diubah');
      redirect('kelas');
    
    }
  }
  /**
   * Generate anggota kelas 
   * 
   *  
   * @param bool
   */
  public function anggota($slug)
  {
    # get tahun ajaran now
    $ajaran = get_ta();

    # select the where condition
    $kelas = $this->db->get_where('kelas',['slug' => $slug])->row();

    $data = [
      'kelas_id' => $kelas->id,
      'siswas'   => $this->db->get_where('siswa',[

        'kelas_id'  => 0,
        'active'    => 1

      ])->result(),
      'anggota'  => $this->db->get_where('anggota_kelas',[

        'ajaran_id' => $ajaran->id,
        'id_kelas'  => $kelas->id

      ])->result(),
    ];
    $this->template->load('template','kelas/anggota',$data);
  }

  /**
   * Save anggota rombel ajax request
   * 
   * 
   * @return json
   */
  public function simpan_anggota()
  {
    $kelas_id   = $this->input->post('rombel_id',true);
    $siswa_nis  = $this->input->post('siswa_nis',true);

    # get tahun ajaran now
    $ajaran = get_ta();
    
    # select array condition
    $find = $this->db->get_where('anggota_kelas',[

      'ajaran_id' => $ajaran->id, 
      'id_kelas'  => $kelas_id,
      'nis'       => $siswa_nis

    ])->num_rows();
    
    if($find){

      # update kelas_id in selected selected
      $this->db->update('siswa',['kelas_id' => $kelas_id], ['nis' => $siswa_nis]);
      $status = [

        'type'    => 'warning',
        'text'    => 'Berhasil mengubah anggota kelas',
        'title'   => 'Data tersimpan!',
      
      ];

    } 
    else {

      # update kelas_id in selected siswa
      $this->db->update('siswa',['kelas_id' => $kelas_id], ['nis' => $siswa_nis]);
      
      $data = [
      
        'ajaran_id' => $ajaran->id,
        'id_kelas'  => $kelas_id,
        'nis'       => $siswa_nis,
      
      ];

      # insert $data to anggota_kelas table
      $this->db->insert('anggota_kelas',$data);
      
      $status = [
        
        'type'    => 'success',
        'text'    => 'Berhasil menambah anggota rombel',
        'title'   => 'Data Tersimpan!',
      
      ];
    }
    
    # return with json code encode
		echo json_encode($status);
  }
  /**
   * Save anggota rombel ajax request
   * 
   * 
   * @return json
   */
  public function hapus_anggota()
  {
    $kelas_id   = $this->input->post('rombel_id',true);
    $siswa_nis  = $this->input->post('siswa_nis',true);

    # get tahun ajaran now
    $ajaran = get_ta();
    
    # select array condition
    $find = $this->db->get_where('anggota_kelas',[

      'ajaran_id' => $ajaran->id, 
      'id_kelas'  => $kelas_id,
      'nis'       => $siswa_nis

    ])->row();

		if($find){

      $this->db->update('siswa',['kelas_id' => 0],['nis' => $siswa_nis]);

      $this->db->delete('anggota_kelas',[

        'ajaran_id' => $ajaran->id, 
        'id_kelas' => $kelas_id,
        'nis' => $siswa_nis

      ]);
      
      $status = [
        'type'    => 'error',
        'text'    => 'Berhasil menghapus anggota kelas',
        'title'   => 'Data tersimpan',
      ];

		} else {
      $status = [
        'type'    => 'error',
        'text'    => 'Data anggota kelas tidak ditemukan',
        'title'   => 'Data tersimpan',
      ];
    }

    # return with json code encode
		echo json_encode($status);
  }

  /**
   * Atur mata pelajaran
   * 
   * 
   * @return view
   */
  public function mapel($slug_kelas)
  {
    # get tahun ajaran now
    $ajaran = get_ta();

    $data = [

      'data_rombel' => $this->db->get_where('kelas',['slug' => $slug_kelas])->row(),
      'ajaran_id'   => $ajaran->id,
      'data_kelas'  => $this->db->get_where('kelas',['slug' => $slug_kelas])->row(),

    ];
    
    $this->template->load('template','kelas/mapel',$data);
  }

  /**
   * Save mapel in sended form
   * 
   * 
   * @return json
   */
  public function simpan_pembelajaran()
  {

    $ajaran = get_ta();
    
		$query      = $this->input->post('query',true);
		$rombel_id  = $this->input->post('rombel_id',true);
    $mapel_id   = $this->input->post('mapel_id',true);
    
    # get with where condition
    $data_mapel = $this->db->get_where('data_mapel',['id_mapel' => $mapel_id])->row();

		$guru_id      = isset($_POST['guru_id']) ? $_POST['guru_id'] : '0';
    $keahlian_id  = isset($_POST['keahlian_id']) ? $_POST['keahlian_id'] : '';
    
		$data_kurikulum = array(

			'ajaran_id'			=> $ajaran->id,
			'kelas_id'			=> $rombel_id,
			'id_mapel'			=> $mapel_id,
			'guru_id'			  => $guru_id,
      'keahlian_id'		=> $keahlian_id
      
    );
    
		$data_kurikulum_update = array(

			'id_mapel'    => $mapel_id,
			'guru_id'     => $guru_id,
      'keahlian_id' => $keahlian_id
      
    );
    
		if($query == 'kurikulum'){

      $find = $this->db->get_where('kurikulum',[

        'ajaran_id' => $ajaran->id, 
        'kelas_id'  => $rombel_id, 
        'id_mapel'  => $mapel_id

      ])->row();

			if($find){

				if($find->guru_id == 0){

          $this->db->delete('kurikulum',[
          
            'ajaran_id' => $ajaran->id, 
            'kelas_id'  => $rombel_id, 
            'id_mapel'  => $mapel_id
          
            ]);
        
        } else {
          
          $this->db->where([

            'ajaran_id' => $ajaran->id, 
            'kelas_id' => $rombel_id, 
            'id_mapel' => $mapel_id
            
          ]);
          $this->db->update('kurikulum',$data_kurikulum_update);
          
				}
				
        $status = [

          'type'   => 'warning',
          'text'   =>'Berhasil mengupdate pembelajaran',
          'title'  => 'Data Tersimpan!',

        ];
        
			} else {

				if($guru_id !=0){
          
          $this->db->insert('kurikulum',$data_kurikulum);
          
          $status = [
            
            'icon'  => 'fas fa-check',
            'type'  => 'success',
            'text'  => 'Berhasil menambah pembelajaran',
            'title' => 'Data Tersimpan!',

          ];

				} else {

          $nama_mapel = isset($data_mapel->nama_mapel) ? $data_mapel->nama_mapel : $mapel_id;
          
          $status = [
            
            'icon'  => 'fas fa-times',
            'type'  => 'info',
            'text'  => 'Guru tidak dipilih untuk mata pelajaran '.$nama_mapel,
            'title' => 'Data dilewati!',
            
          ];
          
				}
			}
    }

		echo json_encode($status);
	}
  /**
   * Kenaikan kelas 
   * 
   * 
   * @return
   */
  public function kenaikan($id)
  {
    $find = $this->db->get_where('kelas',['id' => $id])->row();
 
    $data = [

      'anggota'     => $this->db->get_where('anggota_kelas',[

        'id_kelas'  => $id,
        'ajaran_id' => $ajaran->id

      ])->result(),

      'find'        => $find,
      'data_kelas'  => $this->db->get_where('kelas',[

        'tingkat'   => $find->tingkat+1, 
        'jurusan_id'=> $find->jurusan_id

      ])->result(),
      'ajaran'      => get_ta(), 
    
    ];

    $this->template->load('template','kelas/kenaikan',$data);
  }
  /**
   * Proses kenaikan
   *
   *  
   * @method post
   */
  public function proses_kenaikan()
  {

    $id_kelas   = $this->input->post('id_kelas',true); 
    $nis_siswa  = $this->input->post('nis_siswa',true);
    

    $kelas = $this->db->get_where('kelas',['id' => $id_kelas])->row();
    
    $this->db->where_in('nis', $nis_siswa);
    $siswa = $this->db->get('siswa')->result();
    
    if($id_kelas == 'lulus'){

      $this->db->where_in('nis', $nis_siswa);
      $siswa = $this->db->get('siswa')->result();
      
			if(is_array($siswa)){
				foreach($siswa as $s){
          $this->db->where('nis',$s->nis);
          $this->db->update('siswa',['active' => 0]);
          
          $db2 = $this->load->database('database_kedua', TRUE);

          $db2->where('nis',$s->nis);
          $db2->update('siswa',['active' => 0]);
          
        }
      }
      return true;
    }
    $ajaran = get_ta_next();
    if(is_array($siswa)){
			foreach($siswa as $s){
        $this->db->where('nis',$s->nis);
        $this->db->update('siswa',['kelas_id' => $id_kelas]);

        $attr = [
          'ajaran_id'   => $ajaran,
          'id_kelas'    => $id_kelas,
          'nis'   => $s->nis
        ];
        $this->db->insert('anggota_kelas',$attr);
			}
    } 
    
    helper_log("update", "Menaikkan data kelas");
    alertsuccess('message','Proses kenaikan kelas berhasil');
  }
  /**
   * Proses lanjut semester
   * 
   * 
   */
  public function lanjut($id_kelas)
  {
    $ajaran = get_ta();
    $find = $this->db->get_where('kelas',['id' => $id_kelas])->row();
    $data['anggota'] = $this->db->get_where('anggota_kelas',['id_kelas' => $id_kelas,'ajaran_id' => $ajaran->id])->result();
    $data['find'] = $find;
    $data['ajaran'] = $ajaran;
    $this->template->load('template','kelas/lanjut',$data);
  }  

  /**
   * Proses lanjut semester
   * 
   * 
   * 
   */
  public function proses_lanjut()
  {
    $ajaran = get_ta_smt();

    $id_kelas = $this->input->post('id_kelas',true); 
    
    $kelas = $this->db->get_where('kelas',['id' => $id_kelas])->row();
    
    $nis_siswa = $this->input->post('nis_siswa',true);

    $this->db->where_in('nis', $nis_siswa);
    $siswa = $this->db->get('siswa')->result();

    if(is_array($siswa)){
			foreach($siswa as $s){
        $this->db->where('nis',$s->nis);
        $this->db->update('siswa',['kelas_id' => $id_kelas]);

        $attr = [
          'ajaran_id'   => $ajaran,
          'id_kelas'    => $id_kelas,
          'nis'         => $s->nis
        ];
        $this->db->insert('anggota_kelas',$attr);
			}
    } 
    
    helper_log("update", "Melanjutkan semester data kelas");
    alertsuccess('message','Proses lanjut semester kelas berhasil');
  }
  /**
   * Hapus Kelas by slug integreted by id
   * 
   * @param slug
   */
  public function delete($slug_kelas)
  {
    $this->db->delete('kelas',['slug' => $slug_kelas]);
    helper_log("delete", "Menghapus data kelas");
    alertsuccess('message','Data berhasil dihapus');
    redirect('kelas');
  }


}