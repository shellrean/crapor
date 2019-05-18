<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$border = '';
		$class = 'table table-bordered';
	} else {
		$border = 'border="1"';
		$class = 'table';
	}
}

$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();
$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
$ajaran = $this->db->get('ajaran',['id' => $ajaran_id])->row();
$rombel = $this->db->get('kelas',['id' => $kelas_id])->row();

$kelompok_a = preg_quote('A0', '~'); // don't forget to quote input string!
$kelompok_b = preg_quote('B0', '~'); // don't forget to quote input string!
$kelompok_c = preg_quote('C', '~'); // don't forget to quote input string!
$all_mapel = $this->db->get_where('kurikulum',[
  'ajaran_id'     => $ajaran_id,
  'kelas_id'      => $kelas_id
])->result();
?>
<div class="strong">B.&nbsp;&nbsp;Pengetahuan dan Keterampilan</div>
<table <?php echo $border; ?> class="<?php echo $class; ?>">
	<thead>
  <tr>
    <th style="vertical-align:middle;width: 2px;" align="center" rowspan="2">No</th>
    <th style="vertical-align:middle;width: 200px;" rowspan="2">Mata Pelajaran</th>
    <th colspan="4" align="center" class="text-center">Pengetahuan</th>
	<th colspan="4" align="center" class="text-center">Keterampilan</th>
  </tr>
  <tr>
    <th align="center" style="width:10px;" class="text-center">KKM</th>
	<th align="center" style="width:10px;" class="text-center">Angka</th>
	<th align="center" style="width:10px;" class="text-center">Predikat</th>
	<th align="center" style="width:150px;" class="text-center">Deskripsi</th>
    <th align="center" style="width:10px;" class="text-center">KKM</th>
	<th align="center" style="width:10px;" class="text-center">Angka</th>
	<th align="center" style="width:10px;" class="text-center">Predikat</th>
	<th align="center" style="width:150px;" class="text-center">Deskripsi</th>
  </tr>
	</thead>
	<tbody>
	<?php
	foreach($all_mapel as $allmapel){
		$get_id_mapel[] = $allmapel->id_mapel;
	}
	if($kurikulum_id == 2013){
		$mapel_a = preg_grep('~' . $kelompok_a . '~', $get_id_mapel);
		$mapel_b = preg_grep('~' . $kelompok_b . '~', $get_id_mapel);
		$mapel_c = preg_grep('~' . $kelompok_c . '~', $get_id_mapel);
		$mapel_a = filter_agama_mapel($ajaran_id,$rombel_id,$get_id_mapel, $mapel_a, $s->agama);
		if($mapel_a){
	?>
		<tr>
			<td colspan="10">Kelompok A</td>
		</tr>
	<?php
		$i=1;
		foreach($mapel_a as $mapela){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $mapela, $s->id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$mapela,$s->id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_value = '-';
				}
			}
			$all_nilai_keterampilan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $mapela, $s->id);
			if($all_nilai_keterampilan_remedial){
				$nilai_keterampilan_value = $all_nilai_keterampilan_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$mapela,$s->id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_value = '-';
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapela,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
		?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapela); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapela); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapela),$nilai_pengetahuan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapela); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapela),$nilai_keterampilan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok A (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
	if($mapel_b){
	$mapel_group = $mapel_a + $mapel_b + $mapel_c;
	$mapel_tambahan = array_diff($get_id_mapel, $mapel_group);
	if($mapel_tambahan){
		$mapel_b = $mapel_b + $mapel_tambahan;
	}
	?>
		<tr>
			<td colspan="10">Kelompok B</td>
		</tr>
	<?php
		$i=1;
		foreach($mapel_b as $mapelb){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $mapelb, $s->id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$mapelb,$s->id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_value = '-';
				}
			}
			$all_nilai_keterampilann_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $mapelb, $s->id);
			if($all_nilai_keterampilann_remedial){
				$nilai_keterampilan_value = $all_nilai_keterampilann_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$mapelb,$s->id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_value = '-';
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapelb,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
		?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapelb); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapelb); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapelb),$nilai_pengetahuan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapelb); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapelb),$nilai_keterampilan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok B (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
	if($mapel_c){
	?>
		<tr>
			<td colspan="10">Kelompok C</td>
		</tr>
	<?php
		$i=1;
		foreach($mapel_c as $mapelc){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $mapelc, $s->id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$mapelc,$s->id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_value = '-';
				}
			}
			$all_nilai_keterampilan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $mapelc, $s->id);
			if($all_nilai_keterampilan_remedial){
				$nilai_keterampilan_value = $all_nilai_keterampilan_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$mapelc,$s->id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_value = '-';
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$mapelc,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
		?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$mapelc); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapelc); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapelc),$nilai_pengetahuan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$mapelc); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$mapelc),$nilai_keterampilan_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php
	$i++; }
	} else {
	?>
		<tr>
			<td colspan="10">Kelompok C (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php } 
} elseif($all_mapel){ 
	foreach($all_mapel as $allmapel){
		$get_id_mapel[] = $allmapel->id_mapel;
	}
	foreach($get_id_mapel as $abc){
		$get_id_2006[$abc] = substr($abc,0,2);
	}
	$normatif_1 = preg_quote(10, '~'); // don't forget to quote input string!
	$normatif_2 = preg_quote(20, '~'); // don't forget to quote input string!
	$normatif_3 = preg_quote(30, '~'); // don't forget to quote input string!
	$normatif_4 = preg_quote(50, '~'); // don't forget to quote input string!
	$normatif_5 = preg_quote(84, '~'); // don't forget to quote input string!
	$adaptif_1 = preg_quote(40, '~'); // don't forget to quote input string!
	$adaptif_2 = preg_quote(80, '~'); // don't forget to quote input string!
	$produktif = preg_quote('P', '~'); // don't forget to quote input string!
	$cari_mulok = preg_quote(85, '~'); // don't forget to quote input string!
	$mapel_normatif_1 = preg_grep('~' . $normatif_1 . '~', $get_id_2006);
	$mapel_normatif_2 = preg_grep('~' . $normatif_2 . '~', $get_id_2006);
	$mapel_normatif_3 = preg_grep('~' . $normatif_3 . '~', $get_id_2006);
	$mapel_normatif_4 = preg_grep('~' . $normatif_4 . '~', $get_id_2006);
	$mapel_normatif_5 = preg_grep('~' . $normatif_5 . '~', $get_id_2006);
	$mapel_adaptif_1 = preg_grep('~' . $adaptif_1 . '~', $get_id_2006);
	$mapel_adaptif_2 = preg_grep('~' . $adaptif_2 . '~', $get_id_2006);
	foreach($mapel_normatif_1 as $agama => $value){
		$mapel_agama[$agama] = get_nama_mapel($ajaran_id,$rombel_id,$agama);
	}
	if(isset($mapel_agama)){
		foreach($mapel_agama as $key=>$m_agama){
			if (strpos($m_agama,get_agama($s->agama)) !== false) {
				$mapel_normatif_1_alias[$key] = substr($key,0,2);
			}
		}
	}
	if(isset($mapel_normatif_1_alias)){
		$mapel_normatif_1 = $mapel_normatif_1_alias;
	}
	$mapel_normatif = $mapel_normatif_1 + $mapel_normatif_2 + $mapel_normatif_3 + $mapel_normatif_4 + $mapel_normatif_5;
	$mapel_adaptif = $mapel_adaptif_1 + $mapel_adaptif_2;
	$mapel_produktif1 = preg_grep('~' . $produktif . '~', $get_id_2006);
	$mapel_produktif = $mapel_produktif1;
	$all_mulok1 = preg_grep('~' . $cari_mulok . '~', $get_id_2006);
	$all_mulok = $all_mulok1;
	$mapel_group = $mapel_normatif + $mapel_adaptif + $mapel_produktif + $all_mulok;
	$mapel_tambahan = array_diff($get_id_2006, $mapel_group);
	if($mapel_tambahan){
		$mapel_adaptif = $mapel_adaptif + $mapel_tambahan;
	}
	$i=1;
	if($mapel_normatif){
?>
		<tr>
			<td colspan="10">Normatif</td>
		</tr>
		<?php
		$i=1;
		foreach($mapel_normatif as $normatif => $value){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $normatif, $siswa_id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_normatif_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$normatif,$siswa_id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_normatif_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_normatif_value = 0;
				}
			}
			$all_nilai_keterampilan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $normatif, $siswa_id);
			if($all_nilai_keterampilan_remedial){
				$nilai_keterampilan_normatif_value = $all_nilai_keterampilan_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$normatif,$siswa_id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_normatif_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_normatif_value = 0;
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$normatif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
		?>
		<tr>
			<td align="center" valign="top"><?php echo $i; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$normatif); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$normatif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_normatif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$normatif),$nilai_pengetahuan_normatif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$normatif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_normatif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$normatif),$nilai_keterampilan_normatif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
		<?php 		
			$i++;
			}
		} else {
		?>
		<tr>
			<td colspan="10">Normatif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
		<?php
		}
	if($mapel_adaptif){
		$a=isset($i) ? $i : 1;
	?>
		<tr>
			<td colspan="10">Adaptif</td>
		</tr>
	<?php
		foreach($mapel_adaptif as $adaptif => $value){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $adaptif, $siswa_id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_adaptif_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$adaptif,$siswa_id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_adaptif_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_adaptif_value = 0;
				}
			}
			$all_nilai_keterampilan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $adaptif, $siswa_id);
			if($all_nilai_keterampilan_remedial){
				$nilai_keterampilan_adaptif_value = $all_nilai_keterampilan_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$adaptif,$siswa_id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_adaptif_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_adaptif_value = 0;
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$adaptif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
	?>
		<tr>
			<td align="center" valign="top"><?php echo $a; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$adaptif); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$adaptif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_adaptif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$adaptif),$nilai_pengetahuan_adaptif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$adaptif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_adaptif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$adaptif),$nilai_keterampilan_adaptif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
	<?php 
			$a++;
		}
	} else { ?>
		<tr>
			<td colspan="10" class="text-center">Mata Pelajaran Adaptif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)</td>
		</tr>
	<?php }
	$b=isset($a) ? $a : 1;
	if($mapel_produktif){
	?>
		<tr>
			<td colspan="10">Produktif</td>
		</tr>
	<?php
		foreach($mapel_produktif as $produktif => $value){
			$all_nilai_pengetahuan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 1, $rombel_id, $produktif, $siswa_id);
			if($all_nilai_pengetahuan_remedial){
				$nilai_pengetahuan_produktif_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
			} else {
				$all_nilai_pengetahuan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,1,$rombel_id,$produktif,$siswa_id);
				if($all_nilai_pengetahuan){
					$nilai_pengetahuan = 0;
					foreach($all_nilai_pengetahuan as $allnilaipengetahuan){
						$nilai_pengetahuan += $allnilaipengetahuan->nilai;
					}
					$nilai_pengetahuan_produktif_value = number_format($nilai_pengetahuan,0);
				} else {
					$nilai_pengetahuan_produktif_value = 0;
				}
			}
			$all_nilai_keterampilan_remedial = Remedial::find_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_data_siswa_id($ajaran_id, 2, $rombel_id, $produktif, $siswa_id);
			if($all_nilai_keterampilan_remedial){
				$nilai_keterampilan_produktif_value = $all_nilai_keterampilan_remedial->rerata_remedial;
			} else {
				$all_nilai_keterampilan = Nilaiakhir::find_all_by_ajaran_id_and_kompetensi_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,2,$rombel_id,$produktif,$siswa_id);
				if($all_nilai_keterampilan){
					$jumlah_penilaian_keterampilan = count($all_nilai_keterampilan);
					$nilai_keterampilan = 0;
					foreach($all_nilai_keterampilan as $allnilaiketerampilan){
						$nilai_keterampilan += $allnilaiketerampilan->nilai; // $jumlah_penilaian_keterampilan;
					}
					$nilai_keterampilan_produktif_value = number_format($nilai_keterampilan,0);
				} else {
					$nilai_keterampilan_produktif_value = 0;
				}
			}
			$deskripsi = Deskripsi::find_by_ajaran_id_and_rombel_id_and_mapel_id_and_siswa_id($ajaran_id,$rombel_id,$produktif,$s->id);
			$deskripsi_pengetahuan = '';
			$deskripsi_keterampilan = '';
			if($deskripsi){
				$deskripsi_pengetahuan = $deskripsi->deskripsi_pengetahuan;
				$deskripsi_keterampilan = $deskripsi->deskripsi_keterampilan;
			}
	?>
		<tr>
			<td align="center" valign="top"><?php echo $b; ?></td>
			<td valign="top"><?php echo get_nama_mapel($ajaran_id,$rombel_id,$produktif); ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$produktif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_pengetahuan_produktif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$produktif),$nilai_pengetahuan_produktif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_pengetahuan; ?></td>
			<td valign="top" align="center"><?php echo get_kkm($ajaran_id,$rombel_id,$produktif); ?></td>
			<td valign="top" align="center"><?php echo $nilai_keterampilan_produktif_value; ?></td>
			<td valign="top" align="center"><?php echo konversi_huruf(get_kkm($ajaran_id,$rombel_id,$produktif),$nilai_keterampilan_produktif_value); ?></td>
			<td valign="top"><?php echo $deskripsi_keterampilan; ?></td>
		</tr>
			
		<?php 
		$b++;
		}
	} else { ?>
		<tr>
			<td colspan="10" class="text-center">
				Mata Pelajaran Produktif (Belum ada mata pelajaran di rombongan belajar <?php echo $rombel->nama; ?>)
			</td>
		</tr>
	<?php } 
} 
?>
	</tbody>
</table>