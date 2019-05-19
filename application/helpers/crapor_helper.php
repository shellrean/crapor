<?php
defined('BASEPATH') or exit('No direct script access allowed');

/** 
 * ########################################################################################
 * Herlper crapor
 * ########################################################################################
 * @package   crapor
 * @author    Kuswandi <wandinak17@gmail.com>
 * @copyright Copyright (c) 2018 - 2019
 * @since     1.0
 *
 * #######################################################################################
 */

  /**
   * Helper untuk membuat flash message sukses
   * @param  string $name
   * @param  string $text
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function alertsuccess($name,$text) {
    $CI =& get_instance();
    $alert = ' 
    <div class="alert alert-success fade show" role="alert">
    '.$text.'
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    ';
    return $CI->session->set_flashdata($name,$alert);
  }

  /**
   * Helper untuk membuat flash message error
   * @param  string $name
   * @param  string $text
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function alerterror($name,$text) {
    $CI =& get_instance();
    $alert = ' 
    <div class="alert alert-danger fade show" role="alert">
    '.$text.'
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    ';
    return $CI->session->set_flashdata($name,$alert);
  }

  /**
   * Helper untuk membuat string random
   * @param  integer $length default 10
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  /**
   * Helper untuk mengecek apakah user sudah login
   * @return boolean
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function is_login()
  {
    $CI =& get_instance();
    if (!$CI->session->has_userdata('user_craport_identifer')) {
      redirect('auth');
    }
  }

  /**
   * Helper untuk mengecek apakah user yang login adalah admin
   * @return boolean
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function is_admin()
  {
    $CI =& get_instance();
    if( $CI->session->userdata('role_id') != 1) {
      redirect('errors/denied');
    }
  }


  /**
   * Helper untuk membuat expired session
   * @return boolean
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function expiress_by()
  {
    $CI =& get_instance();
    $timeout = $CI->session->set_userdata(['expiress_by' => time() + 30]);
    return $timeout;
  }

  /**
   * Helper untuk mengambil tahun ajaran saat ini
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_ta(){
    $CI =& get_instance();
    $settings = $CI->db->get('setting')->row();
    $strings = $settings->periode;
    $strings = explode('|',$strings);
    $tapel = $strings[0];
    $semester = str_replace(' ','',$strings[1]);
    if($semester == 'SemesterGanjil'){
      $smt = 1;
    } else {
      $smt = 2;
    }	
    
    $ajarans = $CI->db->get_where('ajaran',[
      'tahun' => $tapel, 
      'smt' => $smt
    ])->row();
    return $ajarans;
  }

  /**
   * Helper untuk mengambil tahun ajaran berikutnya
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_ta_next()
  {
    $CI =& get_instance();
    $ajaran = get_ta();

    $ext = explode('/',$ajaran->tahun);
    $t1 = $ext[0]+1;
    $t2 = $ext[1]+1;
    $tahun = $t1.'/'.$t2;
    $find = $CI->db->get_where('ajaran',[
      'tahun' => $tahun, 
      'smt' => 1
    ])->row();
    
    if(!$find) {
      $CI->db->insert('ajaran',['tahun' => $tahun,'smt' => 1]);
      $return = $CI->db->insert_id();
    } else {
      $return = $find->id;
    }
    return $return;
  }

  /**
   * Helper untuk mengambil data semester berikutnya
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_ta_smt()
  {
    $CI =& get_instance();
    $ajaran = get_ta();

    $find = $CI->db->get_where('ajaran',[
      'tahun' => $ajaran->tahun,
      'smt'   => 2
    ])->row();
    
    if(!$find) {
      $CI->db->insert('ajaran',[
        'tahun' => $ajaran->tahun,
        'smt'   => 2
      ]);
      $return = $CI->db->insert_id();
    } else {
      $return = $find->id;
    }
    return $return;
  }
  
  /**
   * Helper untuk mengambil nama kurikulum 
   * @param integer $kurikulum_id
   * @param string $query
   * @return boolean
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_kurikulum($kurikulum_id,$query='nama'){
    $CI =& get_instance();
    $kompetensi = $CI->db->get_where('data_kurikulum',[
      'kurikulum_id' => $kurikulum_id
    ])->row();
    return $kompetensi->nama_kurikulum;
  }

  /**
   * Helper untuk mengambil nama mapel
   * @param integer $ajaran_id
   * @param integer $rombel_id
   * @param string $id_mapel
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_nama_mapel($ajaran_id, $rombel_id, $id_mapel){
    $CI =& get_instance();

    $get_nama_mapel = $CI->db->get_where('data_mapel',[
      'id_mapel' => $id_mapel
    ])->row();
    
    if(isset($get_nama_mapel->nama_mapel)){
      $nama_mapel = $get_nama_mapel->nama_mapel;
    } else {
      $nama_mapel = get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel);
    }
    
    return $nama_mapel;
  }

  /**
   * Helper untuk mengambil nama mapel alias 
   * @param integer $ajaran_id
   * @param integer $rombel_id
   * @param string $id_mapel
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel){

    $CI =& get_instance();

    $get_nama_mapel = $CI->db->get_where('kurikulum',[
      'ajaran_id' => $ajaran_id,
      'kelas_id'  => $rombel_id, 
      'id_mapel'  => $id_mapel
    ])->row();

    $nama_mapel = isset($get_nama_mapel->nama_mapel_alias) ? ($get_nama_mapel->nama_mapel_alias) ? $get_nama_mapel->nama_mapel_alias : '' : '';
    
    return $nama_mapel;
  }

  /**
   * Helper untuk mengambil nama guru mapel
   * @param integer $ajaran_id
   * @param integer $rombel_id
   * @param string $query
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_guru_mapel($ajaran_id, $rombel_id, $id_mapel, $query = 'nama'){

    $CI =& get_instance();

    $get_mapel = $CI->db->get_where('kurikulum',[
      'ajaran_id' => $ajaran_id,
      'kelas_id' => $rombel_id, 
      'id_mapel' => $id_mapel
    ])->row();

    $nama_guru_mapel['id'] = isset($get_mapel->guru_id) ? $get_mapel->guru_id : 0;
    $nama_guru_mapel['nama'] = isset($get_mapel->guru_id) ? get_nama_guru($get_mapel->guru_id) : 0;
    return $nama_guru_mapel[$query];
  }

  /**
   * Helper untuk mengambil nama guru 
   * @param integer $id_guru
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_nama_guru($id_guru){
    $CI =& get_instance();

    $guru = $CI->db->get_where('user',[
      'id' => $id_guru
    ])->row();
    $nama_guru = isset($guru->name) ? $guru->name : '-';
    return $nama_guru;
  }

  /**
   * Helper untuk mengambil info dari sesion
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_my_info()
  {
    $CI =& get_instance();

    $guru = $CI->db->get_where('user',[
      'username' => $CI->session->userdata('username')
    ])->row();

    return $guru;
  }

  /**
   * Helper untuk mengambil nama kelas
   * @param integer $kelas_id
   * @return string
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_nama_kelas($kelas_id)
  {
    $CI =& get_instance();
    $kelas = $CI->db->get_where('kelas',['id' => $kelas_id])->row();
    $nama_kelas = isset($kelas->nama) ? $kelas->nama : '-';
    return $nama_kelas;
  }

  /**
   * Helper untuk mengambil kelas dengan id_guru
   * @param integer $id_guru
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_kelas_by_id_guru($id_guru)
  {
    $CI =& get_instance();
    $kelas = $CI->db->get_where('kelas',['guru_id' => $id_guru])->row();
    return $kelas;
  }

  /**
   * Helper untuk mengambil data siswa agama
   * @param integer $nama_mapel
   * @param integer $kelas_id
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function filter_agama_siswa($nama_mapel,$kelas_id)
  {
    $CI =& get_instance();
    $agamas = array(1=>'Islam',2=>'Kristen',3=>'Katolik',4=>'Hindu',5=>'Buddha',6=>'Konghucu',98=>'Tidak diisi',99=>'Lainnya');
    foreach($agamas as $key=>$value){
      if (strpos($nama_mapel, $value) !== false) {
        var_dump('ini');
        // $data_siswa = Datasiswa::find('all',array('conditions' => array("data_rombel_id = ? AND agama = ? OR data_rombel_id = ? AND agama = ?",$rombel_id, $value, $rombel_id, $key)));
        $data_siswa = $this->db->get_where('data_siswa',[
          'data_kelas_id'   => $kelas_id,
          'agama'           => $value,
        ])->reulst();
        break;
      } else {
        $data_siswa = $CI->db->get_where('siswa',['kelas_id' => $kelas_id])->result();
      }
    }
    return $data_siswa;
  }

  /**
   * Helper untuk mengambil nilai kkm
   * @param integer $ajaran_id
   * @param integer $kelas_id
   * @param integer $id
   * @return object
   * @author Kuswandi <wandinak17@gmail.com>
   */
  function get_kkm($ajaran_id, $kelas_id, $id)
  {
    $CI =& get_instance();
    $get_kkm = $CI->db->get_where('kurikulum',[
      'ajaran_id'     => $ajaran_id,
      'kelas_id'      => $kelas_id,
      'id_mapel'      => $id,
    ])->row();
    $kkm = isset($get_kkm->kkm) && $get_kkm->kkm ? $get_kkm->kkm : '-';
    return $kkm;
  }