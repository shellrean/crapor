<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends MY_Controller
{
  
  /**
   * Conctruct all required loaded codeigniter and parented
   * 
   * codeigniter
   */
  public function __construct()
  {
    parent:: __construct();

    $this->load->library('form_validation');
    
    is_login();
    is_admin();
  } 

  /**
   * Get the setting and show ours dashboard config.php
   * and check the user has user post or not
   * 
   * 
   * @return view
   */
  public function index()
  {
    $this->form_validation->set_rules('periode','Periode','required');

    if( $this->form_validation->run() == false ) {

      $data['setting'] = $this->db->get('setting')->row();
      $this->template->load('template','admin/config',$data);

    }
    else {
      $this->_save();

    }

  }

  /**
   * Call this method if the validation form is true
   * 
   * 
   * @return boolean
   */
  private function _save()
  {
    # set the setting field
    $setting = [
      'periode' 		=> $this->input->post('periode'),
      'rumus'       => $this->input->post('rumus'),
      'url_api'     => $this->input->post('api_url')
    ];
 
    # define semester
    $strings = $setting['periode'];
    $strings = explode('|',$strings);
    $tapel = $strings[0];
    $semester = str_replace(' ','',$strings[1]);
    if($semester == 'SemesterGanjil'){
      $smt = 1;
    } else {
      $smt = 2;
    }

    # get count where condition
    $ajarans = $this->db->get_where('ajaran',['tahun' => $tapel,'smt'=>$smt])->num_rows();

    # if where condition is not found
    if(!$ajarans){
      $data_ajarans = array(
        'tahun'				=> $tapel,
        'smt' 				=> $smt
      ); 
      $this->db->insert('ajaran',$data_ajarans);
    } 

    # update setting table
    $this->db->update('setting',$setting,['id' => 1]);

    # executed last code
    helper_log('update','Mengubah configurasi umum');
    alertsuccess('message','Configurasi berhasil diubah');
    redirect('config'); 
  }

  /**
   * Show our dashboard if the validation form is false
   * 
   * 
   * @return view
   */
  public function sekolah()
  {

    if($this->form_validation->run('config/sekolah') == false) {

      $data['sekolah'] = $this->db->get('data_sekolah')->row();
      $data['setting'] = $this->db->get('setting')->row();
      $this->template->load('template','admin/sekolah',$data);

    } else {

      # define the required data
      $data = [
        'nama'            => $this->input->post('nama'),
        'nss'             => $this->input->post('nss'),
        'alamat_sekolah'  => $this->input->post('alamat_sekolah'),
        'kode_pos'        => $this->input->post('kode_pos'),
        'telp'            => $this->input->post('telp'),
        'faks'            => $this->input->post('faks'),
        'kecamatan'       => $this->input->post('kecamatan'),
        'kabupaten'       => $this->input->post('kota'),
        'provinsi'        => $this->input->post('provinsi'),
        'website'         => $this->input->post('website'),
        'email'           => $this->input->post('email'),
      ];
      $setting = [
        'kepsek'          => $this->input->post('kepsek'),
        'nip_kepsek'      => $this->input->post('nip_kepsek'),
      ];

      $data_keahlian = $this->input->post('kompetensi_keahlian');

      # get all fiend in keahlian table
			$keahlian = $this->db->get('keahlian')->result();
			if($keahlian){
				foreach($keahlian as $ahli){
          $this->db->delete('keahlian',['id' => $ahli->id]);
				}
      }
      
      # insert each the selected kurikulum to keahlian table
			foreach($data_keahlian as $datakeahlian){
        $keahlian = [
          'kurikulum_id'  => $datakeahlian,
        ];
        $this->db->insert('keahlian',$keahlian);
      }
      $this->db->update('setting',$setting,['id' => '1']);
      $this->db->update('data_sekolah',$data,['id' => '1']);

      # finaly code
      helper_log('update','Mengubah data sekolah');
      alertsuccess('message','Data sekolah berhasil diubah');
      redirect('config/sekolah');
    }
  }

  public function sync()
  {
    $this->load->model('M_siswa');
    $this->db->truncate('siswa');
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
        'kelas_id' => $siswa->kelas_id
      ];
      $this->db->insert('siswa',$data);
      $no ++;
    }

    $db2 = $this->load->database('database_kedua', TRUE);
    $this->db->truncate('anggota_kelas');
    $anggotas = $db2->get('anggota_kelas')->result();
    foreach($anggotas as $anggota) {
      $data = [
        'id'    => $anggota->id,
        'nis'   => $anggota->nis,
        'id_kelas'=> $anggota->id_kelas,
        'ajaran_id' => $anggota->ajaran_id
      ];
      $this->db->insert('anggota_kelas',$data);
    }

    $this->db->truncate('kelas');
    $kelases = $db2->get('kelas')->result();
    foreach($kelases as $kelas) {
      $data = [
        'id'    => $kelas->id,
        'guru_id' => $kelas->guru_id,
        'tingkat' => $kelas->tingkat,
        'jurusan_id' => $kelas->jurusan_id,
        'nama'      => $kelas->nama,
        'slug'    => $kelas->slug
      ];
      $this->db->insert('kelas',$data);
    }
    $this->db->truncate('ajaran');
    $ajarans = $db2->get('ajaran')->result();
    foreach($ajarans as $ajaran) {
      $data = [
        'id'    => $ajaran->id,
        'tahun' => $ajaran->tahun,
        'smt'   => $ajaran->smt
      ];
      $this->db->insert('ajaran',$data);
    }

    $result['status'] = 'oke';
    echo json_encode($result);
    
  }


}