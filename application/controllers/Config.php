<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
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
    $this->form_validation->set_rules('periode','required');

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
    # call method
    $this->_validate();

    if($this->form_validation->run() == false) {

      $data['sekolah'] = $this->db->get('data_sekolah')->row();
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
      
      $this->db->update('data_sekolah',$data,['id' => '1']);

      # finaly code
      helper_log('update','Mengubah data sekolah');
      alertsuccess('message','Data sekolah berhasil diubah');
      redirect('config/sekolah');
    }
  }

  /**
   * Call this method for validate the data sekolah field 
   * 
   * 
   * @return boolean
   */
  private function _validate()
  {
    $this->form_validation->set_rules('nama','Nama sekolah','required|trim');
    $this->form_validation->set_rules('nss','NPSN/NSS','required');
    $this->form_validation->set_rules('alamat_sekolah','Alamat sekolah','required');
    $this->form_validation->set_rules('kode_pos','Kode pos','required');
    $this->form_validation->set_rules('telp','No telp','required');
    $this->form_validation->set_rules('faks','No faks','required');
    $this->form_validation->set_rules('kecamatan','Kecamatan','required');
    $this->form_validation->set_rules('kota','Kabupaten/Kota','required');
    $this->form_validation->set_rules('provinsi','Provinsi','required');
    $this->form_validation->set_rules('website','Website','required');
    $this->form_validation->set_rules('email','Email','required');
  }

}