<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
  }
  public function index()
  {

  }

  public function rapor_pdf($kur,$ajaran_id,$kelas_id,$siswa_nis)
  { 
    $m_pdf = new \Mpdf\Mpdf();
    $data['ajaran_id'] = $ajaran_id;
    $data['kelas_id'] = $kelas_id;
    $data['siswa_nis'] = $siswa_nis;
    $data['kurikulum_id'] = $kur;
 
    $siswa = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();
    $kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();
    $pdfFilePath = strtolower(str_replace(' ','_',$siswa->nama)).".pdf";

    # setup logo
    $wm = base_url() . 'assets/img/logo43.png';
    $m_pdf->SetWatermarkImage($wm);
    $m_pdf->showWatermarkImage = false;
    $m_pdf->SetHTMLFooter('<b style="font-size:8px;"><i>'.$siswa->nama.' - '.$kelas->nama.'<i></b>');
    
    # header dan cover
    $rapor_header = $this->load->view('cetak/rapor_header',$data,true);
    $m_pdf->WriteHTML($rapor_header);
    $rapor_cover=$this->load->view('cetak/rapor_cover', $data, true);
    $m_pdf->WriteHTML($rapor_cover);
    
    # identitas sekolah
    $m_pdf->AddPage('P');
    $rapor_identitas_sekolah=$this->load->view('cetak/rapor_identitas_sekolah', $data, true);
    $m_pdf->WriteHTML($rapor_identitas_sekolah);

    # identitas pelajar
    $m_pdf->AddPage('P');
    $rapor_identitas_siswa=$this->load->view('cetak/rapor_identitas_siswa', $data, true);
    $m_pdf->WriteHTML($rapor_identitas_siswa);

    # page penilaian
    $m_pdf->AddPage('P');
    $rapor_nilai=$this->load->view('cetak/rapor_nilai', $data, true);
    $m_pdf->WriteHTML($rapor_nilai);

    $rapor_catatan_akademik=$this->load->view('cetak/rapor_catatan_akademik', $data, true);
    $m_pdf->WriteHTML($rapor_catatan_akademik);


    # page dudi ekskul dan absensi
    $m_pdf->AddPage('P');
    $rapor_prakerin=$this->load->view('cetak/rapor_prakerin', $data, true);
    $m_pdf->WriteHTML($rapor_prakerin);

    $rapor_ekskul=$this->load->view('cetak/rapor_ekskul', $data, true);
    $m_pdf->WriteHTML($rapor_ekskul);

    $rapor_absen=$this->load->view('cetak/rapor_absen', $data, true);
    $m_pdf->WriteHTML($rapor_absen);

    
// $rapor_prestasi=$this->load->view('cetak/rapor_prestasi', $data, true);
// $m_pdf->WriteHTML($rapor_prestasi);




$rapor_footer=$this->load->view('cetak/rapor_footer', $data, true);
$m_pdf->WriteHTML($rapor_footer);
    //download it.
//Output($file,'I') browser
//Output($file,'F') simpan di server
//Output($file,'S') Kirim ke email
//Output($file,'D') Download
$m_pdf->Output($pdfFilePath,'I');   
}
}