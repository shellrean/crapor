<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
  }

  public function pengetahuan()
  {
    $query = $this->db->from('kelas');
    $query->group_by(['tingkat']);
    $query->order_by('tingkat','ASC');
    $data['kelases'] = $query->get()->result();

    
    $data['form_action'] = 'penilaian/simpan_nilai';
    $data['query']  = 'rencana_penilaian';
    $data['kompetensi_id'] = 1;
    $this->template->load('template','penilaian/pengetahuan',$data);
	} 
  public function keterampilan()
  {
    $query = $this->db->from('kelas');
    $query->group_by(['tingkat']);
    $query->order_by('tingkat','ASC');
    $data['kelases'] = $query->get()->result();

    
    $data['form_action'] = 'penilaian/simpan_nilai';
    $data['query']  = 'rencana_penilaian';
    $data['kompetensi_id'] = 2;
    $this->template->load('template','penilaian/keterampilan',$data);
  } 
  
  public function remedial()
  {
    $query = $this->db->from('kelas');
    $query->group_by(['tingkat']);
    $query->order_by('tingkat','ASC');
    $data['kelases'] = $query->get()->result();

    
    $data['form_action'] = 'penilaian/simpan_remedial';
    $data['query']  = 'remedial';
    $data['kompetensi_id'] = 1;
    $this->template->load('template','penilaian/remedial',$data);
  }
  
  public function get_rerata()
  {
    $siswa_nis = $_POST['siswa_nis'];
		$jumlah_kd = $_POST['jumlah_kd'];
		$bobot = $_POST['bobot_kd'];
		$all_bobot = $_POST['all_bobot'];
    $kompetensi_id = $_POST['kompetensi_id'];
    
		$total_bobot = 0;
		foreach($all_bobot as $allbobot){
			$total_bobot += $allbobot;
		}
		$total_bobot = ($total_bobot > 0) ? $total_bobot : 1;
		$bobot = ($bobot > 0) ? $bobot : 1;
		$output['jumlah_form'] = count($siswa_nis);
		foreach($siswa_nis as $k=>$siswa){
			$hitung=0;
			for ($i = 1; $i <= $jumlah_kd; $i++) {
				$hitung += $_POST['kd_'.$i][$k];
			}
			$hasil = $hitung/$jumlah_kd;
			$rerata_nilai = $hasil*$bobot;
      $rerata_jadi = number_format($rerata_nilai/$total_bobot,2);
      
			$record['value'] 	= number_format($hitung/$jumlah_kd,0);
			$record['rerata_text'] 	= 'x '.$bobot.' / '.$total_bobot.' =';
			$record['rerata_jadi'] 	= $rerata_jadi;
			$output['rerata'][] = $record;
		}
    $settings = $this->db->get('setting')->row();
		$html = '';
		if($settings->rumus == 1){
			$html .= '<p><strong>Rumus nilai akhir per penilaian: </strong><br /><div class="alert alert-success fade show" role="alert">Rerata * Bobot Penilaian / Total bobot penilaian per mapel</div></p>';
			$html .= '<div class="alert alert-info fade show" role="alert"><p>Keterangan: <br />Bobot : '.$bobot.'<br />Total Bobot : '.$total_bobot.'</p></div>';
		}
    $output['rumus'] = $html;
      
		echo json_encode($output);
  }

  public function simpan_nilai()
  {
    $ajaran_id = $_POST['ajaran_id'];
		$kelas_id = $_POST['kelas_id'];
		$id_mapel = $_POST['id_mapel'];
    $penilaian_penugasan = $_POST['rencana_id'];
    
		$post = explode("#", $penilaian_penugasan);
		$rencana_id = $post[0];
		$bentuk_penilaian = $post[1];
    $rencana_penilaian_id = $post[2];
    
    $get_rencana = $this->db->get_where('rencana',['id' => $rencana_id])->row();
    $jumlah_kd = $_POST['jumlah_kd'];
		$siswa_nis = $_POST['siswa_nis'];
		$redirect = '';
    
    if($get_rencana->kompetensi_id == 1){
			$redirect = 'pengetahuan';
		} else {
			$redirect = 'keterampilan';
    }
    
		foreach($siswa_nis as $k=>$siswa){
			for ($i = 1; $i <= $jumlah_kd; $i++) {
				if($_POST['kd_'.$i][$k] > 100){
          alerterror('message','Tambah data nilai '.$redirect.' gagal. Nilai tidak boleh lebih besar dari 100');
					redirect('penilaian/'.$redirect);
				}
			}
		}
		foreach($siswa_nis as $k=>$siswa){
      $where = [
        'ajaran_id'     => $ajaran_id,
        'kompetensi_id' => $get_rencana->kompetensi_id,
        'kelas_id'      => $kelas_id,
        'mapel_id'      => $id_mapel,
        'data_siswa_nis'     => $siswa,
        'rencana_penilaian_id' => $rencana_penilaian_id
      ];

      $nilai_akhir = $this->db->get_where('nilaiakhir',$where)->row();

			if($nilai_akhir){
        $data = [
          'rerata_nilai'	=> $_POST['rerata'][$k],
          'nilai'	 		=> $_POST['rerata_jadi'][$k],
        ];
        $this->db->update('nilaiakhir',$data,$where);
			} else {
        $data = [
          'ajaran_id'       => $ajaran_id,
          'kompetensi_id'   => $get_rencana->kompetensi_id,
          'kelas_id'        => $kelas_id,
          'mapel_id'        => $id_mapel,
          'rencana_penilaian_id'  => $rencana_penilaian_id,
          'data_siswa_nis'       => $siswa,
          'rerata_nilai'    => $_POST['rerata'][$k],
          'nilai'           => $_POST['rerata_jadi'][$k],
        ];
        $this->db->insert('nilaiakhir',$data);
			}
			for ($i = 1; $i <= $jumlah_kd; $i++) {
        $where = [
          'ajaran_id'     => $ajaran_id,
          'kompetensi_id' => $get_rencana->kompetensi_id,
          'kelas_id'      => $kelas_id,
          'mapel_id'      => $id_mapel,
          'data_siswa_nis'=> $siswa,
          'rencana_penilaian_id'=> $_POST['rencana_penilaian_id_'.$i][$k],
        ];
        $nilai = $this->db->get_where('nilai',$where)->row();
				if($nilai){
          $data = [
						'ajaran_id' => $ajaran_id, 
						'kompetensi_id' => $get_rencana->kompetensi_id, 
						'kelas_id' => $kelas_id, 
						'mapel_id' => $id_mapel, 
						'data_siswa_nis' => $siswa,
						'rencana_penilaian_id' => $_POST['rencana_penilaian_id_'.$i][$k],
						'nilai'	=> $_POST['kd_'.$i][$k],
						'rerata'	=> $_POST['rerata'][$k],
						'rerata_jadi'	=> $_POST['rerata_jadi'][$k]
          ];
          $this->db->update('nilai',$data,$where);
				} else {
          $data = [
						'ajaran_id' => $ajaran_id, 
						'kompetensi_id' => $get_rencana->kompetensi_id, 
						'kelas_id' => $kelas_id, 
						'mapel_id' => $id_mapel, 
						'data_siswa_nis' => $siswa,
						'rencana_penilaian_id' => $_POST['rencana_penilaian_id_'.$i][$k],
						'nilai'	=> $_POST['kd_'.$i][$k],
						'rerata'	=> $_POST['rerata'][$k],
						'rerata_jadi'	=> $_POST['rerata_jadi'][$k]
          ];
          $this->db->insert('nilai',$data);
				}
			}	
		}
    helper_log(uniqid(),'Menambahkan nilai '.$redirect);
    alertsuccess('message','Berhasil menambahkan data nilai '.$redirect);
		redirect('penilaian/'.$redirect);
  }

  public function simpan_remedial(){
		$ajaran_id = $_POST['ajaran_id'];
		$kelas_id = $_POST['kelas_id'];
		$kompetensi_id = $_POST['kompetensi_id'];
		$id_mapel = $_POST['id_mapel'];
		$data_siswa = $_POST['siswa_nis'];
		$rerata = $_POST['rerata'];  
		$rerata_akhir = $_POST['rerata_akhir'];
		$rerata_remedial = $_POST['rerata_remedial'];
		foreach($data_siswa as $k=>$siswa){

      $where = [
        'ajaran_id'     => $ajaran_id,
        'kompetensi_id' => $kompetensi_id,
        'kelas_id'      => $kelas_id,
        'mapel_id'      => $id_mapel,
        'data_siswa_nis'     => $siswa
      ]; 
			$remedial = $this->db->get_where('remedial',$where)->row();
      if($remedial){
				
        $data = [
          'nilai' => serialize($rerata[$siswa]),
					'rerata_akhir' => $rerata_akhir[$k],
					'rerata_remedial' => $rerata_remedial[$k]
        ];
        $this->db->update('remedial',$data,$where);
        helper_log(uniqid(),'Memperbarui nilai remedial');
        alertsuccess('message','Berhasil memperbarui data nilai remedial');
			} else {
				foreach($rerata as $rata){
					array_walk($rata, 'check_great_than_one_fn');
				}
        $data = [
          'ajaran_id'     => $ajaran_id,
          'kompetensi_id' => $kompetensi_id,
          'kelas_id'      => $kelas_id,
          'mapel_id'      => $id_mapel,
          'data_siswa_nis'=> $siswa,
          'nilai'         => serialize($rerata[$siswa]),
          'rerata_akhir'  => $rerata_akhir[$k],
          'rerata_remedial'=> $rerata_remedial[$k],
        ];
        $this->db->insert('remedial',$data);
        helper_log(uniqid(),"Menambahkan nilai remedial");
        alertsuccess('message','Tambah data nilai remedial berhasil');
			}
		}
		redirect('penilaian/remedial');
	}
}