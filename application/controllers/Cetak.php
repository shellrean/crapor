<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

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


    $wm = base_url() . 'assets/img/logo43.png';
    $m_pdf->SetWatermarkImage($wm);
    $m_pdf->showWatermarkImage = false;
    $m_pdf->SetHTMLFooter('<b style="font-size:8px;"><i>'.$siswa->nama.' - '.$kelas->nama.'<i></b>');
    
    $rapor_header = $this->load->view('cetak/rapor_header',$data,true);
    $m_pdf->WriteHTML($rapor_header);
    
    // $rapor_cover=$this->load->view('cetak/rapor_cover', $data, true);
    // $m_pdf->WriteHTML($rapor_cover);
    // $m_pdf->AddPage('P');


    // $rapor_identitas_sekolah=$this->load->view('cetak/rapor_identitas_sekolah', $data, true);
    // $m_pdf->WriteHTML($rapor_identitas_sekolah);

    // $m_pdf->AddPage('P');
    // $rapor_identitas_siswa=$this->load->view('cetak/rapor_identitas_siswa', $data, true);
    // $m_pdf->WriteHTML($rapor_identitas_siswa);


// $this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
//  $rapor_sikap=$this->load->view('backend/cetak/rapor_sikap', $data, true);
// $this->m_pdf->pdf->WriteHTML($rapor_sikap);

$m_pdf->AddPage('P');
 $rapor_nilai=$this->load->view('cetak/rapor_nilai', $data, true);
$m_pdf->WriteHTML($rapor_nilai);

$rapor_prakerin=$this->load->view('cetak/rapor_prakerin', $data, true);
$m_pdf->WriteHTML($rapor_prakerin);

$rapor_ekskul=$this->load->view('cetak/rapor_ekskul', $data, true);
$m_pdf->WriteHTML($rapor_ekskul);

$rapor_prestasi=$this->load->view('cetak/rapor_prestasi', $data, true);
$m_pdf->WriteHTML($rapor_prestasi);

$rapor_absen=$this->load->view('cetak/rapor_absen', $data, true);
$m_pdf->WriteHTML($rapor_absen);

// $rapor_catatan_wali_kelas=$this->load->view('backend/cetak/rapor_catatan_wali_kelas', $data, true);
// $this->m_pdf->pdf->WriteHTML($rapor_catatan_wali_kelas);
// $rapor_footer=$this->load->view('backend/cetak/rapor_footer', $data, true);
// $this->m_pdf->pdf->WriteHTML($rapor_footer);
    //download it.
//Output($file,'I') browser
//Output($file,'F') simpan di server
//Output($file,'S') Kirim ke email
//Output($file,'D') Download
$m_pdf->Output($pdfFilePath,'I');   
}
}