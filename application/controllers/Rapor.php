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
    
    $this->template->load('template','cetak/legger',$data);

  }

  public function perkembangan_karakter()
  {
    $this->template->load('template','rapor/perkembangan_karakter');
  }

  public function format_karakter()
  {
    $ajaran = get_ta();
    $guru = get_my_info();
    $kelas = get_kelas_by_id_guru($guru->id);

    $data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas->id])->result();

    $siswa = $this->db->get('siswa')->result();
    $this->load->library('excel');
    // Panggil class PHPExcel nya
    $excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Perkembangan karakter")
                 ->setSubject("Perkembangan karakter")
                 ->setDescription("Template perkembangan karakter")
                 ->setKeywords("perkembangan_karakter");
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "ajaran_id");
    $excel->setActiveSheetIndex(0)->setCellValue('B1','kelas_id');
    $excel->setActiveSheetIndex(0)->setCellValue('C1', "siswa_nis");
    $excel->setActiveSheetIndex(0)->setCellValue('D1', "NAMA SISWA");
    $excel->setActiveSheetIndex(0)->setCellValue('E1','integritas');
    $excel->setActiveSheetIndex(0)->setCellValue('F1','religius');
    $excel->setActiveSheetIndex(0)->setCellValue('G1','nasionalis');
    $excel->setActiveSheetIndex(0)->setCellValue('H1','mandiri');
    $excel->setActiveSheetIndex(0)->setCellValue('I1','gotong_royong');
    $excel->setActiveSheetIndex(0)->setCellValue('J1','catatan');
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
    $excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30); 

    $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach($data_siswa as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $ajaran->id);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $kelas->id);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nis);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->nama);

      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);

      $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(100); 
      $numrow++; // Tambah 1 setiap kali looping
    }
    // Set width kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(15); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(45); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(45); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom C
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Template perkembangan_karakter");
    $excel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="karakter_'.$kelas->nama.'.xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }

  public function import_karakter()
  {
    // $jumlah_guru = $this->db->get_where('user')->num_rows();
    $this->load->library('excel');
    
    $status=array(); 
    
    $importdata = $_REQUEST['data'];
    $date   = new DateTime;
    
    $fileName = $_FILES['import_karakter']['name'];
    $config['upload_path'] = './uploads/files/';
    $config['file_name'] = $fileName;
    $config['allowed_types'] = 'xls|xlsx';
    $config['overwrite'] = TRUE; 
    $this->load->library('upload');
    
    $this->upload->initialize($config);
    if(!$this->upload->do_upload('import_karakter')){
      $status['type'] = 'error';
      $status['text'] = $this->upload->display_errors();
      $status['title'] = 'Upload file error!';
      echo json_encode($status);
      exit();
    }
    
    $inputFileName = './uploads/files/'.$fileName;
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
      $worksheetTitle = $worksheet->getTitle();
      $highestRow = $worksheet->getHighestRow(); // e.g. 10
      $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
      $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    }
    
    $nrColumns = ord($highestColumn) - 64;
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $status['highestColumn'] = $highestColumn;
    $status['highestRow'] = $highestRow;
    $status['sheet'] = $sheet;
    $status['nrColumns'] = $nrColumns;
    
    if($highestColumn == 'J') { // Import data guru
      $row = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false);
      foreach ($cellIterator as $k=>$cell) {
        $key[] = $cell->getValue();
      }
      for ($row = 2; $row <= $highestRow; ++ $row) {
        $val = array();
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
          $cell = $worksheet->getCellByColumnAndRow($col, $row);
          $val[] = $cell->getValue();
        }
        $i=0;
        foreach($val as $k=>$v){
          $InsertData[] = array(
            "$key[$i]"=> $v
            );
          $i++;
        }
        $flat = call_user_func_array('array_merge', $InsertData);
        $masukkan[] = array_merge($flat);
      }
      $jumlah_data_import = count($masukkan);
      $sum=0;
      $data_sudah_ada = array();
      $gagal_insert_user = array();
      
    foreach($masukkan as $k=>$v){
      $a = $this->db->get_where('perkembangan_karakter',['ajaran_id' => $v['ajaran_id'],'kelas_id' => $v['kelas_id'], 'siswa_nis' => $v['siswa_nis']])->result();
      $sum+=count($a);
      
      if(!$a){
        $ajaran_id   = $v['ajaran_id'];
        $kelas_id    = $v['kelas_id'];
        $siswa_nis   = $v['siswa_nis'];
        $religius    = $v['religius'];
        $nasionalis  = $v['nasionalis'];
        $mandiri     = $v['mandiri'];
        $gotong_royong = $v['gotong_royong'];
        $catatan     = $v['catatan'];

        $this->db->insert('perkembangan_karakter',[
          'ajaran_id'   => $ajaran_id,
          'kelas_id'    => $kelas_id,
          'religius'    => $religius,
          'nasionalis'  => $nasionalis,
          'mandiri'     => $mandiri,
          'gotong_royong'=> $gotong_royong,
          'catatan'     => $catatan
        ]);
      } else {
        $data_sudah_ada[] .= 'Data sudah ada';
      }
    }
    $jml_data_sudah_ada = count($data_sudah_ada);
    $kolom = ($highestRow - 1);
    $disimpan = ($kolom - $sum);
    $ditolak = ($kolom - $jml_data_sudah_ada);
    $status['text'] = '<table width="100%" class="table table-bordered">
        <tr>
          <td class="text-center">Jumlah data</td>
          <td class="text-center">Status</td>
        </tr>
        <tr>
          <td>'.$disimpan.'</td>
          <td><span class="badge badge-success">sukses disimpan</span></td>
        <tr>
          <td>'.$jml_data_sudah_ada.'</td>
          <td><span class="badge badge-danger">data sudah ada</span></td>
        </tr>
        </table>';
      $status['type'] = 'success';
      $status['title'] = 'Import data sukses!';
    } else {
      $status['type'] = 'error';
      $status['text'] = 'Format Import tidak sesuai. Silahkan download template yang telah disediakan.';
      $status['title'] = 'Import data gagal!';
    }
    unlink($inputFileName);
  echo json_encode($status);
  }
  
  
} 