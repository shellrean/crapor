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

    # page karakter siswa
    $m_pdf->AddPage('P');
    $rapor_karakter=$this->load->view('cetak/rapor_karakter',$data, true);
    $m_pdf->WriteHTML($rapor_karakter);

    # footer
    $rapor_footer=$this->load->view('cetak/rapor_footer', $data, true);
    $m_pdf->WriteHTML($rapor_footer);
    
    //download it.
    //Output($file,'I') browser
    //Output($file,'F') simpan di server
    //Output($file,'S') Kirim ke email
    //Output($file,'D') Download
    $m_pdf->Output($pdfFilePath,'I');   
  }

  public function rapor_debug($kur,$ajaran_id,$kelas_id,$siswa_nis){
    $data['ajaran_id'] = $ajaran_id;
    $data['kelas_id'] = $kelas_id;
    $data['siswa_nis'] = $siswa_nis;
    $data['kurikulum_id'] = $kur;
    $this->load->view('cetak/rapor_header',$data);
    $this->load->view('cetak/rapor_cover', $data);
    $this->load->view('cetak/rapor_identitas_sekolah', $data);
    $this->load->view('cetak/rapor_identitas_siswa', $data);
    $this->load->view('cetak/rapor_nilai', $data);
    $this->load->view('cetak/rapor_catatan_akademik', $data);
    $this->load->view('cetak/rapor_prakerin', $data);
    $this->load->view('cetak/rapor_ekskul', $data);
    $this->load->view('cetak/rapor_absen', $data);
    $this->load->view('cetak/rapor_karakter',$data);
    $this->load->view('cetak/rapor_footer', $data);
  }

  public function legger($ajaran_id,$kelas_id,$kompetensi_id) 
  {
    $sekolah = $this->db->get('data_sekolah')->row();
    $ajaran = get_ta();
    $nama_kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();
    $get_wali = $this->db->get_where('user',['id' => $nama_kelas->guru_id])->row();
    $data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas_id])->result();

    $data_mapel = $this->db->get_where('kurikulum',[
        'ajaran_id'     => $ajaran_id,
        'kelas_id'      => $kelas_id
    ])->result();

    $this->load->library('excel');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    $nama_kompetensi = 'PENGETAHUAN';
    if($kompetensi_id == 2) {
        $nama_kompetensi = 'KETERAMPILAN';
    }

    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);

    $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('0000000000');

    $objPHPExcel->getActiveSheet()->mergeCells('A8:C8');

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setCellValue('A1','LEDGER '.$nama_kompetensi);
    $objPHPExcel->getActiveSheet()->setCellValue('A2',strtoupper($sekolah->nama));
    $objPHPExcel->getActiveSheet()->setCellValue('A3','TAHUN PELAJARAN '.strtoupper($ajaran->tahun));
    $objPHPExcel->getActiveSheet()->setCellValue('C4','KELAS');
    $objPHPExcel->getActiveSheet()->setCellValue('C5','WALI KELAS');
    $objPHPExcel->getActiveSheet()->setCellValue('D4',$nama_kelas->nama);
    $objPHPExcel->getActiveSheet()->setCellValue('D5',$get_wali->name);

    $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue('A8', 'KKM');
    $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue('A7', 'NO.');
    $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue('B7', 'NISN');
    $objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue('C7', 'NAMA SISWA');
    $objPHPExcel->getActiveSheet()->setTitle('LEGGER');

    $row = 9;
    $row_mapel = 7;
    $row_kkm = 8;
    $merger_mapel = 4;
    $merger_wali = 5;
    $x = 'D';
    $plus1 = 'E';
    $plus2 = 'F';

    for($i=0;$i<count($data_mapel); $i++) {
        $huruf[] = $x;
        $last = $x;
        $plus_1 = $plus1;
        $plus_2 = $plus2;
        $x++;
        $plus1++;
        $plus2++;
    }

    $i=1; 
    foreach($data_siswa as $siswa):
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $i);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $siswa->nisn);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $siswa->nama);

        foreach($data_mapel as $key=>$mapel) :
            $where = [ 
                'ajaran_id'     => $ajaran_id,
                'kompetensi_id' => $kompetensi_id,
                'kelas_id'      => $kelas_id,
                'mapel_id'      => $mapel->id_mapel,
                'data_siswa_nis'=> $siswa->nis,
            ];

            $all_nilai = $this->db->get_where('nilaiakhir',$where)->result();

            if($all_nilai) {
                $nilai_value = 0;
                foreach($all_nilai as $allnilai) {
                    $nilai_value += $allnilai->nilai;
                }
                $jumlah_nilai = number_format($nilai_value,2);
            } else {
                $jumlah_nilai = 0;
            }

            $objPHPExcel->getActiveSheet()->getStyle($huruf[$key].$row_mapel)->getAlignment()->setTextRotation(90);
            $objPHPExcel->getActiveSheet()->getColumnDimension($huruf[$key])->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($huruf[$key].$row_mapel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row_mapel,get_nama_mapel($ajaran_id,$kelas_id,$mapel->id_mapel));
            $objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row_kkm, get_kkm($ajaran_id,$kelas_id,$mapel->id_mapel));
            $objPHPExcel->getActiveSheet()->setCellValue($huruf[$key].$row, number_format($jumlah_nilai,0));
            $objPHPExcel->getActiveSheet()->setCellValue($plus_1.$row, '=SUM(D'.$row.':'.$huruf[$key].$row.')');
            $objPHPExcel->getActiveSheet()->setCellValue($plus_2.$row, '=AVERAGE(D'.$row.':'.$huruf[$key].$row.')');
            $objPHPExcel->getActiveSheet()->getStyle($plus_1.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getStyle($plus_2.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        endforeach;
        $i++;
        $row++;
    endforeach;

    $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$plus_2.'1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:'.$plus_2.'2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:'.$plus_2.'3');
    $objPHPExcel->getActiveSheet()->mergeCells('D4:'.$plus_2.'4');
    $objPHPExcel->getActiveSheet()->mergeCells('D5:'.$plus_2.'5');

    $objPHPExcel->getActiveSheet()->getColumnDimension($plus_1)->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($plus_2)->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->getStyle($plus_1.$row_mapel)->getAlignment()->setTextRotation(90);
    $objPHPExcel->getActiveSheet()->getStyle($plus_2.$row_mapel)->getAlignment()->setTextRotation(90);

    $objPHPExcel->getActiveSheet()->setCellValue($plus_1.$row_mapel, 'JUMLAH');
    $objPHPExcel->getActiveSheet()->setCellValue($plus_2.$row_mapel, 'RATA-RATA');
    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '00000000'),
                ),
            ),
        );

    $objPHPExcel->getActiveSheet()->getStyle('A7:'.$plus_2.($row - 1))->applyFromArray($styleArray);
    $filename = 'LEDGER '.$nama_kompetensi.'_'.str_replace(' ','_',$nama_sekolah->nama).'.xlsx';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output');

  }
}