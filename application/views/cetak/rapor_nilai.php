
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
$ajaran = $this->db->get_where('ajaran',['id' => $ajaran_id])->row();
$kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();

$kelompok_a = preg_quote('A0', '~'); // don't forget to quote input string!
$kelompok_b = preg_quote('B0', '~'); // don't forget to quote input string!
$kelompok_c = preg_quote('C', '~'); // don't forget to ro input string!
$all_mapel = $this->db->get_where('kurikulum',[
  'ajaran_id'     => $ajaran_id,
  'kelas_id'      => $kelas_id
])->result();
?>
<table>
  <tr>
    <td>Nama Peserta Didik</td><td>:</td><td><?= $s->nama ?></td>
  </tr>
  <tr>
    <td>NISN/NIS</td><td>:</td> <td><?= $s->nisn.'/'.$s->nis ?></td>
  </tr>
  <tr>
    <td>Kelas/Semester</td><td>:</td> <td><?= $kelas->nama.'/'.$ajaran->smt ?></td>
  </tr>
  <tr>
    <td>Tahun Pelajaran</td><td>:</td> <td><?= $ajaran->tahun ?></td>
  </tr>
</table>
<br>

<div class="strong">A.&nbsp;&nbsp;Nilai Akademik</div>
  <table <?= $border; ?> class="<?= $class; ?>">
    <thead>
      <tr>
        <th style="text-align:center;width: 2px;" >No</th>
        <th style="text-align:center;width: 310px;">Mata Pelajaran</th>
        <th style="text-align:center;" >Pengetahuan</th>
        <th style="text-align:center;">Keterampilan</th>
        <th style="text-align:center;">Nilai akhir</th>
        <th style="text-align:center;">Predikat</th>
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
        // $mapel_a = filter_agama_mapel($ajaran_id,$kelas_id,$get_id_mapel, $mapel_a, $s->agama);
      if($mapel_a){ 
      ?>
      <tr>
        <td colspan="6">A. Muatan Nasional</td>
		  </tr>
      <?php
        $i=1;
        foreach($mapel_a as $mapela){
          $all_nilai_pengetahuan_remedial = $this->db->get_where('remedial',[
            'ajaran_id'			=> $ajaran_id,
            'kompetensi_id'	=> 1,
            'kelas_id'			=> $kelas_id,
            'mapel_id'			=> $mapela,
            'data_siswa_nis'			=> $s->nis
          ])->row();

          if($all_nilai_pengetahuan_remedial){
            $nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
          } else {
            $all_nilai_pengetahuan = $this->db->get_where('nilaiakhir',[
              'ajaran_id'			=> $ajaran_id,
              'kompetensi_id'	=> 1,
              'kelas_id'			=> $kelas_id,
              'mapel_id'			=> $mapela,
              'data_siswa_nis'			=> $s->nis,
            ])->result();
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
          $all_nilai_keterampilan_remedial = $this->db->get_where('remedial',[
            'ajaran_id'			=> $ajaran_id,
            'kompetensi_id'	=> 2,
            'kelas_id'			=> $kelas_id,
            'mapel_id'			=> $mapela,
            'data_siswa_nis'			=> $s->nis
          ])->row();
          if($all_nilai_keterampilan_remedial){
            $nilai_pengetahuan_value = $all_nilai_keterampilan_remedial->rerata_remedial;
          } 
          else {
            $all_nilai_keterampilan = $this->db->get_where('nilaiakhir',[
              'ajaran_id'			=> $ajaran_id,
              'kompetensi_id'	=> 2,
              'kelas_id'			=> $kelas_id,
              'mapel_id'			=> $mapela,
              'data_siswa_nis'			=> $s->nis,
            ])->result();
            if($all_nilai_keterampilan){
              $nilai_pengetahuan = 0;
              foreach($all_nilai_keterampilan as $allnilaiketerampilan){
                $nilai_keterampilan += $allnilaiketerampilan->nilai;
              }
              $nilai_keterampilan_value = number_format($nilai_keterampilan,0);
            } else {
              $nilai_keterampilan_value = '-';
            }
          }
        
      ?>
		  <tr>
        <td valign="top"><?= $i; ?></td>
        <td valign="top"><?= get_nama_mapel($ajaran_id,$kelas_id,$mapela); ?></td>
        <td valign="top"><?= $nilai_pengetahuan_value; ?></td>
        <td valign="top"><?= $nilai_keterampilan_value; ?></td>
        <td>fdf</td>
        <td>fdfd</td>

		  </tr>
      
      <?php
        $i++; }
        } else {
      ?>
      <tr>
        <td colspan="6">Muatan Nasional (Belum ada mata pelajaran di kelas <?= $kelas->nama; ?>)</td>
      </tr>
			<?php } 
			if($mapel_b){ ?>
				<tr>
					<td colspan="6">B. Muatan Kewilayan</td>
		  	</tr>
			<?php
        $i=1;
        foreach($mapel_b as $mapelb){
          $all_nilai_pengetahuan_remedial = $this->db->get_where('remedial',[
            'ajaran_id'			=> $ajaran_id,
            'kompetensi_id'	=> 1,
            'kelas_id'			=> $kelas_id,
            'mapel_id'			=> $mapelb,
            'data_siswa_nis'			=> $s->nis
          ])->row();

          if($all_nilai_pengetahuan_remedial){
            $nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
          } else {
            $all_nilai_pengetahuan = $this->db->get_where('nilaiakhir',[
              'ajaran_id'			=> $ajaran_id,
              'kompetensi_id'	=> 1,
              'kelas_id'			=> $kelas_id,
              'mapel_id'			=> $mapelb,
              'data_siswa_nis'			=> $s->nis,
            ])->result();
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
          $all_nilai_keterampilan_remedial = $this->db->get_where('remedial',[
            'ajaran_id'			=> $ajaran_id,
            'kompetensi_id'	=> 2,
            'kelas_id'			=> $kelas_id,
            'mapel_id'			=> $mapelb,
            'data_siswa_nis'			=> $s->nis
          ])->row();
          if($all_nilai_keterampilan_remedial){
            $nilai_pengetahuan_value = $all_nilai_keterampilan_remedial->rerata_remedial;
          } 
          else {
            $all_nilai_keterampilan = $this->db->get_where('nilaiakhir',[
              'ajaran_id'			=> $ajaran_id,
              'kompetensi_id'	=> 2,
              'kelas_id'			=> $kelas_id,
              'mapel_id'			=> $mapelb,
              'data_siswa_nis'			=> $s->nis,
            ])->result();
            if($all_nilai_keterampilan){
              $nilai_pengetahuan = 0;
              foreach($all_nilai_keterampilan as $allnilaiketerampilan){
                $nilai_keterampilan += $allnilaiketerampilan->nilai;
              }
              $nilai_keterampilan_value = number_format($nilai_keterampilan,0);
            } else {
              $nilai_keterampilan_value = '-';
            }
          }
      ?>
		  <tr>
        <td valign="top"><?= $i; ?></td>
        <td valign="top"><?= get_nama_mapel($ajaran_id,$kelas_id,$mapelb); ?></td>
        <td valign="top"><?= $nilai_pengetahuan_value; ?></td>
        <td valign="top"><?= $nilai_keterampilan_value; ?></td>
				<td></td>
				<td></td>

		  </tr>
      
      <?php
        $i++; }
        } else {
      ?>
      <tr>
        <td colspan="6">Muatan Kewilayahan (Belum ada mata pelajaran di kelas <?= $kelas->nama; ?>)</td>
      </tr>
			<?php }
				if($mapel_c){ ?>
				
					<tr>
						<td colspan="6">C. Muatan Peminatan Kejuruan</td>
					</tr>
				<?php
					$i=1;
					foreach($mapel_c as $mapelc){
						$all_nilai_pengetahuan_remedial = $this->db->get_where('remedial',[
							'ajaran_id'			=> $ajaran_id,
							'kompetensi_id'	=> 1,
							'kelas_id'			=> $kelas_id,
							'mapel_id'			=> $mapelc,
							'data_siswa_nis'			=> $s->id
						])->row();
	
						if($all_nilai_pengetahuan_remedial){
							$nilai_pengetahuan_value = $all_nilai_pengetahuan_remedial->rerata_remedial;
						} else {
							$all_nilai_pengetahuan = $this->db->get_where('nilaiakhir',[
								'ajaran_id'			=> $ajaran_id,
								'kompetensi_id'	=> 1,
								'kelas_id'			=> $kelas_id,
								'mapel_id'			=> $mapelc,
								'data_siswa_nis'			=> $s->id,
							])->result();
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
				?>
				<tr>
					<td valign="top"><?= $i; ?></td>
					<td valign="top"><?= get_nama_mapel($ajaran_id,$kelas_id,$mapelc); ?></td>
					<td valign="top"><?= $nilai_pengetahuan_value; ?></td>
					<td valign="top"><?= konversi_huruf(get_kkm($ajaran_id,$kelas_id,$mapelc),$nilai_pengetahuan_value); ?></td>
					<td></td>
					<td></td>
	
				</tr>
				
				<?php
					$i++; }
					} else {
				?>
				<tr>
					<td colspan="6">Muatan Kejuruan (Belum ada mata pelajaran di kelas <?= $kelas->nama; ?>)</td>
				</tr>
				<?php }  
    }?>

	</tbody>
</table>
	</div>