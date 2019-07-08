<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapor extends MY_Controller
{

  /**
   * Contruct all required loader
   * 
   * @return param
   */
  public function __construct()
  {
    parent::__construct();

    is_login();

  }


  /**
   * Show wali kelas absensi from their students
   * 
   * 
   * @return view
   */
  public function absen()
  {
    $data['ajarans'] = $this->db->get('ajaran')->result();
   
    # query selected class
    $this->db->from('kelas');
    $this->db->group_by(['tingkat']);
    $this->db->order_by('tingkat','ASC');
    
    $data['kelases'] =  $this->db->get()->result();
    $data['form_action'] = 'rapor/simpan_absensi';;
    
    # load our view
    $this->template->load('template','rapor/absensi',$data);
  }
  
  /**
   * Save our absensi kelas
   * 
   * 
   * @return redirect
   */
  public function simpan_absensi()
  {
    # take data from post method form
    $ajaran_id = $this->input->post('ajaran_id',true);
    $kelas_id  = $this->input->post('kelas_id',true);
    $siswa_nis = $this->input->post('siswa_nis',true);
    
    # foreach the array data 
		foreach($siswa_nis as $key=>$siswa){

      $absen = $this->db->get_where('absen',[
        'ajaran_id'     => $ajaran_id,
        'kelas_id'      => $kelas_id,
        'siswa_nis'     => $siswa,
      ])->row();

      # if data already existing
			if($absen){
				$data = [
						'sakit' => $_POST['sakit'][$key],
						'izin' 	=> $_POST['izin'][$key],
						'alpa'	=> $_POST['alpa'][$key],
        ];
        
        # ubah data absensi
        $this->db->update('absen',$data,[
          'ajaran_id'     => $ajaran_id,
          'kelas_id'      => $kelas_id,
          'siswa_nis'     => $siswa,
        ]);

        $message = "Data berhasil diubah";
        helper_log("Mengubah", "Mengubah data absensi dengan nis ".$siswa);

			} else {
        $data = [
          'ajaran_id'     => $ajaran_id,
          'kelas_id'      => $kelas_id,
          'siswa_nis'     => $siswa,
          'sakit'         => $_POST['sakit'][$key],
          'izin'          => $_POST['izin'][$key],
          'alpa'          => $_POST['alpa'][$key]
        ];
        # simpan data absensi
        $this->db->insert('absen',$data);
        $message = "Data berhasil ditambahkan";
        helper_log("add", "Menambahkan data absen dengan nis ".$siswa);
			}
    }
    
    # finish our code
    alertsuccess('message',$message);
		redirect('rapor/absen');
  }

  /**
   * Show our catatan page
   * 
   * 
   * @return 
   */
  public function catatan()
  {
    $data['form_action'] = 'rapor/simpan_catatan';
    $this->template->load('template','rapor/catatan',$data);

  }

  /**
   * Store our catatan wali kelas
   * 
   * 
   * @return 
   */
  public function simpan_catatan()
  {
    $ajaran_id = $this->input->post('ajaran_id',true);
    $kelas_id = $this->input->post('kelas_id',true);
    $siswa_nis = $this->input->post('siswa_nis',true);
    
    foreach($siswa_nis as $key=>$siswa){
      
      $where = [
        'ajaran_id'   => $ajaran_id,
        'kelas_id'    => $kelas_id,
        'siswa_nis'   => $siswa
      ];
      $deskripsi_antar_mapel = $this->db->get_where('catatan',$where)->num_rows();

			if($deskripsi_antar_mapel){
        $data = [
          'uraian_deskripsi' => $_POST['uraian_deskripsi'][$key]
        ];
        $this->db->update('catatan',$data,$where);

        helper_log('update','Mengubah catatan siswa dengan nis '.$siswa);
        $message = 'Berhasil memperbaharui catatan wali kelas';
			} else {
				$data = [
          'ajaran_id'   => $ajaran_id,
          'kelas_id'    => $kelas_id,
          'siswa_nis'   => $siswa,
          'uraian_deskripsi' => $_POST['uraian_deskripsi'][$key],
        ];
        $this->db->insert('catatan',$data);
        helper_log('add','Menambah catatan siswa dengan nis '.$siswa);
        $message = 'Berhasil menambah catatan wali kelas';
      }
      
      
    }
    alertsuccess('message',$message);
		redirect('rapor/catatan');
  }

  /**
   * Show perakerin dashboard
   * 
   * 
   * @return
   */
  public function pkl()
  {
    $data['form_action'] = 'rapor/simpan_pkl';
    $this->template->load('template','rapor/pkl',$data);
  }
  
  /**
   * Save our submitted adata
   * 
   * 
   * @return
   */
  public function simpan_pkl()
  {
    $ajaran_id = $this->input->post('ajaran_id',true);
    $kelas_id = $this->input->post('kelas_id',true);
    $siswa_nis = $this->input->post('siswa_nis',true);
    $mitra_prakerin = $this->input->post('mitra_prakerin',true);
    $lokasi_prakerin = $this->input->post('lokasi_prakerin',true);
    $lama_prakerin = $this->input->post('lama_prakerin',true);
    $keterangan_prakerin = $this->input->post('keterangan_prakerin',true);
    
    $data = [
      'ajaran_id'           => $ajaran_id,
      'kelas_id'            => $kelas_id,
      'siswa_nis'           => $siswa_nis,
      'mitra_prakerin'      => $mitra_prakerin,
      'lokasi_prakerin'     => $lokasi_prakerin,
      'lama_prakerin'       => $lama_prakerin,
      'keterangan_prakerin' => $keterangan_prakerin,
    ];
    
    $this->db->insert('pkl',$data);

    alertsuccess('message','Berhasil manambahkan data pkl untuk siswa dengan nis '.$siswa_nis);
		redirect('rapor/pkl');
  }

  /**
   * Delete pkl selected by id
   * 
   * 
   * @return 
   */
  public  function delete_pkl($id)
  {
    $this->db->delete('pkl',['id' => $id]);
    alertsuccess('message','Berhasil menghapus data pkl');
		redirect('rapor/pkl');
  }

  /**
   * Return our modal pkl
   * 
   * 
   * @return
   */
  public function edit_pkl($id)
  {
    if($_POST){
			$this->db->update('pkl',
				array(
					'mitra_prakerin' => $_POST['mitra_prakerin'], 
					'lokasi_prakerin' => $_POST['lokasi_prakerin'], 
					'lama_prakerin' => $_POST['lama_prakerin'],
					'keterangan_prakerin' => $_POST['keterangan_prakerin']
				)
			,[
        'id' => $id
      ]);

			$ajaran_id = $_POST['ajaran_id'];
			$kelas_id = $_POST['kelas_id'];
			$siswa_nis = $_POST['siswa_nis'];
			$this->_form_prakerin($ajaran_id,$kelas_id,$siswa_nis);
		} else {  
      $data['prakerin'] = $this->db->get_where('pkl',['id' => $id])->row();
      $this->template->set('modal_title','Edit data prakerin');
      $this->template->set('modal_footer', '<a class="btn btn-info btn-sm" id="button_form" href="javascript:void(0);">Update</a>');
      $this->template->load('modal','rapor/edit_pkl',$data);
		}
  }

  /**
   * Show form prakerin 
   * 
   * 
   * @return
   */
  private function _form_prakerin($ajaran_id,$kelas_id,$siswa_nis){
		$data['ajaran_id'] = $ajaran_id;
		$data['kelas_id'] = $kelas_id;
		$data['siswa_nis'] = $siswa_nis;
		$this->load->view('rapor/add_pkl', $data);
  }
  
  /**
   * show our ekstrakkurikuler
   * 
   * 
   * @return
   */
  public function ekskul()
  {
    $data['form_action'] = 'rapor/simpan_ekskul';
    $this->template->load('template','rapor/ekskul',$data);
  }
  /**
   * store our ekstrakkurikuler
   * 
   * 
   * @return
   */
  public function simpan_ekskul()
  {
    $ajaran_id = $_POST['ajaran_id'];
		$kelas_id = $_POST['kelas_id'];
		$ekskul_id = $_POST['ekskul_id'];
    $siswa_nis = $_POST['siswa_nis'];
    
		foreach($siswa_nis as $key=>$siswa){
    
      $where = [
        'ajaran_id'     => $ajaran_id,
        'ekskul_id'     => $ekskul_id,
        'kelas_id'      => $kelas_id,
        'siswa_nis'     => $siswa,
      ];

      $nilai_ekskul = $this->db->get_where('nilai_ekskul',$where)->row();

      if($nilai_ekskul){

        $this->db->update('nilai_ekskul',[
          'nilai'             => $_POST['nilai'][$key],
          'deskripsi_ekskul' 	=> $_POST['deskripsi_ekskul'][$key],
        ],$where);

			} else {
        $data = [
          'ajaran_id'     => $ajaran_id,
          'kelas_id'      => $kelas_id,
          'ekskul_id'     => $ekskul_id,
          'siswa_nis'     => $siswa,
          'nilai'         => $_POST['nilai'][$key],
          'deskripsi_ekskul'=> $_POST['deskripsi_ekskul'][$key],
        ];

        $this->db->insert('nilai_ekskul',$data);
			}
    }
    
    helper_log(uniqid(),'Mengubah nilai ekskul');
    alertsuccess('message','Berhasil menambah nilai ekskul');
    redirect('rapor/ekskul');
  }

  public function cetak_rapor()
  {
    $guru = get_my_info();

    $kelas = $this->db->get_where('kelas',['guru_id' => $guru->id])->row();
      
    $kelas_id = isset($kelas->id) ? $kelas->id : 0;

    $kurikulum_id = isset($kelas->kurikulum_id) ? $kelas->kurikulum_id : 0;
      
    $ajaran = get_ta();
      
		$data['query'] = 'wali';
		$data['kelas_id'] = $kelas_id;
    $data['ajaran_id'] = $ajaran->id;
    $data['nama_kompetensi'] = 2013;

    $kompetensi = $this->db->get_where('data_kurikulum',['kurikulum_id' => $kurikulum_id])->row();

    $nama_kompetensi = isset($kompetensi->nama_kurikulum) ? $kompetensi->nama_kurikulum : 0;
    
    $this->template->load('template','cetak/rapor',$data);
  }

  public function cetak_ledger()
  {
    
  }
  
  
} 