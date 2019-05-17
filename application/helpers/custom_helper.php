<?php

/**
 * Helper untuk membuat pesan alert success sebagai flash message
 * 
 * params $name = name of message
 * params $text = text of alert message
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
 * Helper untuk membuat pesan alert error sebagai flash message
 * 
 * params $name = name of message
 * params $text = text of alert message
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
 * Generate random string for slug
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
 * Check is login
 * 
 * 
 */
function is_login()
{
  $CI =& get_instance();
  if (!$CI->session->has_userdata('user_craport_identifer')) {
    redirect('auth');
  }
  $CI->db->where('username',$CI->session->userdata('username'));
  $CI->db->update('login',['time' => time()]);
}

/**
 * Check is admin 
 *
 */
function is_admin()
{
  $CI =& get_instance();
  if( $CI->session->userdata('role_id') != 1) {
    redirect('errors/denied');
  }
}


/**
 * Identifer expiress time by
 * 
 * 
 * 
 */
function expiress_by()
{
  $CI =& get_instance();
  $timeout = $CI->session->set_userdata(['expiress_by' => time() + 30]);
  return $timeout;
}

/**
 * Get tahun jaran sekarang
 * 
 * 
 * 
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
  
  $ajarans = $CI->db->get_where('ajaran',['tahun' => $tapel, 'smt' => $smt])->row();
	return $ajarans;
}

/**
 * get next semester 
 * 
 * 
 */
function get_ta_next()
{
  $CI =& get_instance();
  $ajaran = get_ta();

  $ext = explode('/',$ajaran->tahun);
  $t1 = $ext[0]+1;
  $t2 = $ext[1]+1;
  $tahun = $t1.'/'.$t2;
  $find = $CI->db->get_where('ajaran',['tahun' => $tahun, 'smt' => 1])->row();
  
  if(!$find) {
    $CI->db->insert('ajaran',['tahun' => $tahun,'smt' => 1]);
    $return = $CI->db->insert_id();
  } else {
    $return = $find->id;
  }
  return $return;
}
/**
 * get next semester 
 * 
 *  
 */
function get_ta_smt()
{
  $CI =& get_instance();
  $ajaran = get_ta();

  $find = $CI->db->get_where('ajaran',['tahun' => $ajaran->tahun,'smt' => 2])->row();
  
  if(!$find) {
    $CI->db->insert('ajaran',['tahun' => $ajaran->tahun,'smt' => 2]);
    $return = $CI->db->insert_id();
  } else {
    $return = $find->id;
  }
  return $return;
}
/**
 * Get kunikulum name without frefix
 * 
 * 
 */
function get_kurikulum($kurikulum_id,$query='nama'){
	$CI =& get_instance();
  $kompetensi = $CI->db->get_where('data_kurikulum',['kurikulum_id' => $kurikulum_id])->row();
  return $kompetensi->nama_kurikulum;
}


/**
 * 
 * Get nama mapel
 * 
 * 
 * 
 * 
 */
function get_nama_mapel($ajaran_id, $rombel_id, $id_mapel){
  $CI =& get_instance();

  $get_nama_mapel = $CI->db->get_where('data_mapel',['id_mapel' => $id_mapel])->row();
	if(isset($get_nama_mapel->nama_mapel)){
		$nama_mapel = $get_nama_mapel->nama_mapel;
	} else {
		$nama_mapel = get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel);
	}
  
  return $nama_mapel;
}

/**
 * Get nama mapel alias
 * 
 * 
 * 
 */
function get_nama_mapel_alias($ajaran_id, $rombel_id, $id_mapel){

  $CI =& get_instance();
  
  $get_nama_mapel = $CI->db->get_where('kurikulum',['ajaran_id' => $ajaran_id,'kelas_id' => $rombel_id, 'id_mapel' => $id_mapel])->row();

	$nama_mapel = isset($get_nama_mapel->nama_mapel_alias) ? ($get_nama_mapel->nama_mapel_alias) ? $get_nama_mapel->nama_mapel_alias : '' : '';
  
  return $nama_mapel;
}

/**
 * 
 * Get guru mapel
 * 
 * 
 */
function get_guru_mapel($ajaran_id, $rombel_id, $id_mapel, $query = 'nama'){

  $CI =& get_instance();

  $get_mapel = $CI->db->get_where('kurikulum',['ajaran_id' => $ajaran_id,'kelas_id' => $rombel_id, 'id_mapel' => $id_mapel])->row();
	$nama_guru_mapel['id'] = isset($get_mapel->guru_id) ? $get_mapel->guru_id : 0;
	$nama_guru_mapel['nama'] = isset($get_mapel->guru_id) ? get_nama_guru($get_mapel->guru_id) : 0;
	return $nama_guru_mapel[$query];
}

/**
 * Get nama guru
 * 
 * 
 * 
 */
function get_nama_guru($id_guru){
  $CI =& get_instance();

  $guru = $CI->db->get_where('user',['id' => $id_guru])->row();
	$nama_guru = isset($guru->name) ? $guru->name : '-';
	return $nama_guru;
}

/**
 * Get id guru
 * 
 * 
 * 
 */
function get_my_info()
{
  $CI =& get_instance();

  $guru = $CI->db->get_where('user',['username' => $CI->session->userdata('username')])->row();
  return $guru;
}

/**
 * Get nama kelas 
 * 
 * $kelas_id
 * 
 */
function get_nama_kelas($kelas_id)
{
  $CI =& get_instance();
  $kelas = $CI->db->get_where('kelas',['id' => $kelas_id])->row();
  $nama_kelas = isset($kelas->nama) ? $kelas->nama : '-';
  return $nama_kelas;
}

/**
 * Get kelas by id_guru
 * 
 * 
 * $id_guru
 */
function get_kelas_by_id_guru($id_guru)
{
  $CI =& get_instance();
  $kelas = $CI->db->get_where('kelas',['guru_id' => $id_guru])->row();
  return $kelas;
}

