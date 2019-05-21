<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asesmen extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    is_login();
  }
  /**
   * Get page for add prakerin with ajax
   * 
   * 
   * @return
   */
  public function get_prakerin()
  {
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['kelas_id'] = $_POST['kelas_id'];
		$data['siswa_nis'] = $_POST['siswa_nis'];
    $this->load->view('rapor/add_pkl',$data);
  }
  
  /**
   * Get page for ekstrakukikuler with ajax
   * 
   * 
   * @return 
   */
  public function get_ekskul()
  {
    $data['ajaran_id'] = $_POST['ajaran_id'];
		$data['ekskul_id'] = $_POST['ekskul_id'];
    $data['kelas_id'] = $_POST['kelas_id'];
    
    
    $this->load->view('rapor/add_ekskul',$data);
  }

  /**
   * Get page for kd_penilaian with ajax
   * 
   * 
   * @return 
   */
  public function get_kd_penilaian()
  {
		$html = '';
    $settings   = $this->db->get('setting')->row();
		$ajaran_id = $_POST['ajaran_id'];
		$post	= $_POST['rencana_id'];
		$post = explode("#", $post);
		$rencana_id = $post[0];
		$nama_penilaian = $post[1];
		$bobot_kd = $post[3];
		$bobot_kd = ($bobot_kd > 0) ? $bobot_kd : 1;
		$kelas_id	= $_POST['kelas_id'];
		$id_mapel = $_POST['id_mapel'];
    $kompetensi_id = $_POST['kompetensi_id'];
    
    $rencana = $this->db->get_where('rencana',['id' => $rencana_id])->row();
		$html .= '<input type="hidden" name="bobot_kd" value="'.$bobot_kd.'" />';
    
    $all_rencana = $this->db->get_where('rencana',[
      'ajaran_id'     => $ajaran_id,
      'kelas_id'      => $kelas_id,
      'id_mapel'      => $id_mapel,
      'kompetensi_id' => $kompetensi_id
    ])->result();
    foreach($all_rencana as $ren){
			$id_rencana[] = $ren->id;
    } 
    
    $this->db->from('rencana_penilaian');
    $this->db->group_by('nama_penilaian');
    $this->db->order_by('id','ASC');
    $this->db->where_in('rencana_id',$id_rencana);
    $get_all_bobot_new = $this->db->get()->result();

    $data_mapel = $this->db->get_where('data_mapel',['id_mapel' => $id_mapel])->row();
		if($data_mapel){
			$nama_mapel = $data_mapel->nama_mapel;
		} else {
			$nama_mapel = '';
    }
    
    $this->db->from('rencana_penilaian');
    $this->db->group_by('nama_penilaian');
    $this->db->where('rencana_id',$rencana->id);
    $get_all_bobot = $this->db->get()->result();

    
    $all_pengetahuan = $this->db->get_where('rencana_penilaian',[
      'rencana_id'      => $rencana_id,
      'nama_penilaian'  => $nama_penilaian,
    ])->result();
    $html .= '<link rel="stylesheet" href="'.base_url('assets/').'css/tooltip-viewport.css">';
		$html .= '<script src="'.base_url('assets/').'js/tooltip-viewport.js"></script>';
    $data_siswa = filter_agama_siswa($nama_mapel,$rencana->kelas_id);  
		foreach($get_all_bobot_new as $getbobot){
			$set_bobot = ($getbobot->bobot_penilaian > 0) ? $getbobot->bobot_penilaian : 1;
			$html .= '<input type="hidden" name="all_bobot[]" value="'.$set_bobot.'" />';
			$html .= '<input type="hidden" name="rencana_penilaian_id[]" value="'.$getbobot->id.'" />';
		} 
		if($all_pengetahuan){
			$jumlah_kd = count($all_pengetahuan);
			$html .= '<input type="hidden" name="jumlah_kd" value="'.$jumlah_kd.'" />';
			$html .= '<input type="hidden" name="rencana" value="'.$rencana_id.'" />';
			$html .= '<div class="table-responsive no-padding">';
			$html .= '<table class="table table-bordered table-hover">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th rowspan="2" style="vertical-align: middle;">Nama Siswa</th>';
			$html .= '<th class="text-center" colspan="'.$jumlah_kd.'">Kompetensi Dasar</th>';
			$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Nilai</th>';
			
			if($settings->rumus == 1){
				$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rumus</th>';
				$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Nilai Akhir<br />Per Penilaian</th>';
			}
			$html .= '</tr>';
			$html .= '<tr>';
			foreach($all_pengetahuan as $allpengetahuan){
        $kd = $this->db->get_where('kd',['id' => $allpengetahuan->kd_id])->row();
        $id_kd = $kd->id_kd;
				$html .= '<th><a href="javacript:void(0)" class="tooltip-left" title="'.$kd->kompetensi_dasar.'">'.$id_kd.'</a></th>';
			}
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$no=0;
			foreach($data_siswa as $siswa){
				$html .= '<input type="hidden" name="siswa_nis[]" value="'.$siswa->nis.'" />';
				$html .= '<tr>';
				$html .= '<td>';
				$html .= $siswa->nama;
				$html .= '</td>';
				$i=1;
				foreach($all_pengetahuan as $allpengetahuan){
          $nilai = $this->db->get_where('nilai',[
            'ajaran_id'     => $ajaran_id,
            'kompetensi_id' => $rencana->kompetensi_id,
            'kelas_id'      => $rencana->kelas_id,
            'mapel_id'      => $rencana->id_mapel,
            'data_siswa_nis'=> $siswa->nis,
            'rencana_penilaian_id' => $allpengetahuan->id,
          ])->row();

					$nilai_value = isset($nilai) ? $nilai->nilai : '';
					$rerata = isset($nilai) ? $nilai->rerata : '';
					$rerata_jadi = isset($nilai) ? $nilai->rerata_jadi : '';
					$html .= '<input type="hidden" name="rencana_penilaian_id_'.$i.'[]" value="'.$allpengetahuan->id.'" />';
					$html .= '<td><input type="text" name="kd_'.$i.'[]" size="10" class="form-control" value="'.$nilai_value.'" autocomplete="off" maxlength="3" required /></td>';
					$i++;
        }
        
        $html .= '<td><input type="text" name="rerata[]" id="rerata_'.$no.'" size="10" class="form-control" value="'.$rerata.'" readonly /></td>';
          
				if($settings->rumus == 1){
					$html .= '<td class="text-center"><strong><span id="rerata_text_'.$no.'"></span></strong></td>';
					$html .= '<td><input type="text" name="rerata_jadi[]" id="rerata_jadi_'.$no.'" size="10" class="form-control" value="'.$rerata_jadi.'" readonly /></td>';
				} else {
					$html .= '<input type="hidden" name="rerata_jadi[]" id="rerata_jadi_'.$no.'" size="10" class="form-control" value="'.$rerata_jadi.'" readonly />';
				}
				$html .= '</tr>';
				$no++;
			}
			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';
		} else {
			$html .= '<h5 class="text-danger"><i>Tidak ada KD terpilih di Perencanaan Penilaian</i></h5>';
    }
    

	
		echo $html;
	}
	public function get_remedial(){ 
		$html = '';
		$settings = $this->db->get('setting')->row();

		$ajaran_id = $_POST['ajaran_id'];
		$kelas_id	= $_POST['kelas_id'];
		$id_mapel = $_POST['id_mapel'];
		$kelas = $_POST['kelas'];
		$aspek = $_POST['aspek']; 
		$kompetensi_id = ($aspek == 'P') ? 1 : 2;

		$data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas_id])->result();
		$get_all_kd = $this->db->get_where('kd',[
			'id_mapel'			=> $id_mapel,
			'tingkat'				=> $kelas,
			'aspek'					=> $aspek
		])->result();

		if(!$get_all_kd){
			$get_all_kd = $this->db->get_where('kd',[
				'id_mapel'			=> $id_mapel,
				'tingkat'				=> $kelas,
				'aspek'					=> 'PK'
			])->result();
		}
		$count_get_all_kd = count($get_all_kd);
		$kkm = get_kkm($ajaran_id, $kelas_id, $id_mapel);
		$html .= '<input type="hidden" name="kompetensi_id" value="'.$kompetensi_id.'" />';
		$html .= '<input type="hidden" id="get_kkm" value="'.$kkm.'" />';
		$html .= '<div class="row"><div class="col-md-6">';
		$html .= '<table class="table table-bordered">';
		$html .= '<tr>';
		$html .= '<td colspan="2" class="text-center">';
		$html .= '<strong>Keterangan</strong>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td width="30%">';
		$html .= 'KKM';
		$html .= '</td>';
		$html .= '<td>';
		$html .= $kkm;
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '<input type="text" class="bg-danger form-control form-control-sm" />';
		$html .= '</td>';
		$html .= '<td>';
		$html .= 'Tidak tuntas (input aktif)';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '<input type="text" class="bg-success form-control form-control-sm" />';
		$html .= '</td>';
		$html .= '<td>';
		$html .= 'Tuntas (input non aktif)';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div></div>';
		$html .= '<div class="card"><div class="card-body">';
		$html .= '<table class="table table-bordered table-hover">';
		$html .= '<thead>'; 
		$html .= '<tr>';
		$html .= '<th rowspan="2" style="vertical-align: middle;">Nama Siswa</th>';
		$html .= '<th class="text-center" colspan="'.count($get_all_kd).'">Kompetensi Dasar</th>';
		$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Akhir</th>';
		$html .= '<th rowspan="2" style="vertical-align: middle;" class="text-center">Rerata Remedial</th>';
		$html .= '</tr>';
		$html .= '<tr>';
		$get_all_kd_finish = count($get_all_kd);
		foreach($get_all_kd as $all_kd){
			$id_kd = $all_kd->id_kd;
			$id_kds[] = $all_kd->id;
			$html .= '<th><a href="javacript:void(0)" class="tooltip-left" title="'.$all_kd->kompetensi_dasar.'">&nbsp;&nbsp;&nbsp;'.$id_kd.'&nbsp;&nbsp;&nbsp;</a></th>';
		}
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$no=0;
		$rencana = $this->db->get_where('rencana',[
			'ajaran_id'						=> $ajaran_id,
			'id_mapel'						=> $id_mapel,
			'kelas_id'						=> $kelas_id,
			'kompetensi_id'				=> $kompetensi_id,
		])->result();
		if($rencana){
			foreach($rencana as $ren){
				$id_rencana[] = $ren->id;
			}
			$this->db->from('rencana_penilaian');
			$this->db->order_by('kd_id','ASC');
			$this->db->where_in('rencana_id',$id_rencana);
			$all_rencana_penilaian = $this->db->get()->result();
			if($all_rencana_penilaian){
				foreach($all_rencana_penilaian as $arp){
					$rencana_penilaian_id[] = $arp->id;
				}
			}
		}
		foreach($data_siswa as $siswa){
			$remedial = $this->db->get_where('remedial',[
				'ajaran_id'					=> $ajaran_id,
				'kompetensi_id'			=> $kompetensi_id,
				'kelas_id'					=> $kelas_id,
				'mapel_id'					=> $id_mapel,
				'data_siswa_nis'		=> $siswa->nis
			])->row();
			$html .= '<input type="hidden" name="siswa_nis[]" value="'.$siswa->nis.'" />';
			$html .= '<tr>';
			$html .= '<td>';
			$html .= $siswa->nama;
			$html .= '</td>';
			if($remedial){
				$all_nilai = unserialize($remedial->nilai);
				$set_nilai = 0;
				foreach($all_nilai as $key=>$nilai){
					$set_nilai += $nilai;
					if($kkm > number_format($nilai)){
						$aktif = '';
						$bg = 'bg-danger text-white';
					} else {
						$aktif = 'readonly';
						$bg = 'bg-success text-white';
					}
					$html .= '<td class="text-center">';$html .= '<input type="text" name="rerata['.$siswa->nis.'][]" size="10" class="'.$bg.' form-control input-sm" value="'.number_format($nilai,0).'" '.$aktif.' />';
					$html .= '</td>';
					$no++;
				}
				$count_all_nilai = count($all_nilai);
				if($count_all_nilai < $count_get_all_kd){
					$get_all_kd_finish = $count_all_nilai;
					$kurang = ($count_get_all_kd - $count_all_nilai);
					for ($x = 1; $x <= $kurang; $x++) {
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
					}
				}
				if($kkm > $remedial->rerata_akhir){
					$bg_rerata_akhir = 'text-danger';
				} else {
					$bg_rerata_akhir = 'text-success';
				}
				if($kkm > $remedial->rerata_remedial){
					$bg_rerata_remedial = 'text-danger';
				} else {
					$bg_rerata_remedial = 'text-success';
				}
				$html .= '<td id="rerata_akhir" class="text-center '.$bg_rerata_akhir.'"><strong>';
				$html .= '<input type="hidden" id="rerata_akhir_input" name="rerata_akhir[]" value="'.$remedial->rerata_akhir.'" />';
				$html .= $remedial->rerata_akhir;
				$html .= '</strong></td>';
				$html .= '<td id="rerata_remedial" class="text-center '.$bg_rerata_remedial.'"><strong>';
				$html .= '<input type="hidden" id="rerata_remedial_input" name="rerata_remedial[]" value="'.$remedial->rerata_remedial.'" />';
				$html .= $remedial->rerata_remedial;
				$html .= '</strong></td>';
			} else {
				if(isset($id_rencana)){
					$set_rencana_id = implode("','",$id_rencana);
					$all_nilai = $this->db->query("select b.kd_id, a.id,a.data_siswa_nis, a.rencana_penilaian_id, avg(a.nilai) as rata_rata from `nilai` a INNER JOIN rencana_penilaian b ON b.id = a.rencana_penilaian_id AND b.rencana_id IN('$set_rencana_id') WHERE a.data_siswa_nis = $siswa->nis GROUP BY b.kd_id")->result();
					$no = 1;
					$count_all_nilai = count($all_nilai);
					if($all_nilai){
						$set_nilai = 0;
						foreach($all_nilai as $key=>$nilai){
							$set_nilai += $nilai->rata_rata;
							if($kkm > number_format($nilai->rata_rata)){
								$aktif = '';
								$bg = 'bg-danger text-white';
							} else {
								$aktif = 'readonly';
								$bg = 'bg-success text-white';
							}
							$html .= '<td class="text-center">';
							$html .= '<input type="hidden" name="rencana_penilaian_id[]" value="'.$nilai->rencana_penilaian_id.'" />';
							$html .= '<input type="text" name="rerata['.$siswa->nis.'][]" size="10" class="'.$bg.' form-control input-sm" value="'.number_format($nilai->rata_rata,0).'" '.$aktif.' />';
							$html .= '</td>';
							$no++;
						}
						if($count_all_nilai < $count_get_all_kd){
							$get_all_kd_finish = $count_all_nilai;
							$kurang = ($count_get_all_kd - $count_all_nilai);
							for ($x = 1; $x <= $kurang; $x++) {
								$html .= '<td class="text-center">';
								$html .= '-';
								$html .= '</td>';
							}
						}
						$rerata_akhir = number_format($set_nilai / count($all_nilai),0);
						if($kkm > $rerata_akhir){
							$bg = 'text-danger';
						} else {
							$bg = 'text-success';
						}
						$html .= '<td id="rerata_akhir" class="text-center '.$bg.'"><strong>';
						$html .= '<input type="hidden" id="rerata_akhir_input" name="rerata_akhir[]" value="'.$rerata_akhir.'" />';
						$html .= $rerata_akhir;
						$html .= '</strong></td>';
						$html .= '<td id="rerata_remedial" class="text-center '.$bg.'"><strong>';
						$html .= '<input type="hidden" id="rerata_remedial_input" name="rerata_remedial[]" value="'.$rerata_akhir.'" />';
						$html .= $rerata_akhir;
						$html .= '</strong></td>';
					} else {
						$html .= '<td class="text-center" colspan="'.count($get_all_kd).'">';
						$html .= 'Nilai tidak ditemukan';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
						$html .= '<td class="text-center">';
						$html .= '-';
						$html .= '</td>';
					}
					$no++;
				} else {
					$html .= '<td class="text-center" colspan="'.count($get_all_kd).'">';
					$html .= 'Perencanaan penilaian belum dilakukan!';
					$html .= '</td>';
					$html .= '<td class="text-center">';
					$html .= '-';
					$html .= '</td>';
					$html .= '<td class="text-center">';
					$html .= '-';
					$html .= '</td>';
				}
			}
			$html .= '</tr>';
		}
		$html .= '<input type="hidden" id="get_all_kd" value="'.$get_all_kd_finish.'" />';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<link rel="stylesheet" href="'.base_url('assets/').'css/tooltip-viewport.css">';
		$html .= '<script src="'.base_url().'assets/js/tooltip-viewport.js"></script>';
		$html .= '<script src="'.base_url().'assets/js/remedial.js"></script>';
		echo $html;
	}

	public function get_analisis_penilaian(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['kelas_id'] = $_POST['kelas_id'];
		$data['mapel_id'] = $_POST['id_mapel'];
		$post	= $_POST['penilaian'];
		$post = explode("#", $post);
		$data['rencana_id'] = $post[0];
		if(!isset($post[1])){
			exit;
		}
		$data['nama_penilaian'] = $post[1];
		$data['kompetensi_id'] = $post[2]; 
		$this->load->view('monitoring/analisis_penilaian',$data);
	}

}