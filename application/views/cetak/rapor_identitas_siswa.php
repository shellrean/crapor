<?php
$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();

$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
?>
<div class="text-center">
<h4>KETERANGAN TENTANG DIRI SISWA</h4><br>
<br>
<br>
</div>
<table width="100%" id="alamat">
  <tr>
    <td style="width: 5%;">1.</td>
    <td style="width: 25%;padding:5px;">Nama Siswa (Lengkap)</td>
    <td style="width: 5%;">:</td>
    <td style="width: 65%"><?php echo $s->nama; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">2.</td>
    <td style="width: 25%;padding:5px;">Nomor Induk/NISN</td>
    <td style="width: 5%;">:</td>
    <td style="width: 65%"><?php echo $s->nis.' / '.$s->nisn; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">3.</td>
    <td style="width: 25%;padding:5px;">Tempat, Tanggal Lahir</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->temp_lahir.', '.$s->tgl_lahir ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">4.</td>
    <td style="width: 25%;padding:5px;">Jenis Kelamin</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo ($s->jk == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">5.</td>
    <td style="width: 25%;padding:5px;">Agama</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?= $s->agama; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">6.</td>
    <td style="width: 25%;padding:5px;">Status dalam Keluarga</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->status_keluarga; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">7.</td>
    <td style="width: 25%;padding:5px;">Anak Ke</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->anak_ke; ?></td>
  </tr>
  
  <tr>
    <td style="width: 5%;">8.</td>
    <td style="width: 25%;padding:5px;">Alamat Siswa</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->alamat; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">9.</td>
    <td style="width: 25%;padding:5px;">Nomor Telepon Rumah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->telp; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">10.</td>
    <td style="width: 25%;padding:5px;">Sekolah Asal</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->asal_sekolah; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">11.</td>
    <td style="width: 25%;padding:5px;">Diterima di sekolah ini</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%">&nbsp;</td>
  </tr>
  
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">Di kelas</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->kelas_diterima; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">Pada tanggal</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?= $s->tgl_diterima ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">Nama Orang Tua</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%">&nbsp;</td>
  </tr>
   
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">a. Ayah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->nama_ayah; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">b. Ibu</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->nama_ibu; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">12.</td>
    <td style="width: 25%;padding:5px;">Alamat Orang Tua</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->alamat_orangtua; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">Nomor Telepon Rumah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->tlp_ortu; ?></td>
  </tr>
  
  <tr>
    <td style="width: 5%;">13.</td>
    <td style="width: 25%;padding:5px;">Pekerjaan Orang Tua</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%">&nbsp;</td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">a. Ayah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->pekerjaan_ayah; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">b. Ibu</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->pekerjaan_ibu; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">14.</td>
    <td style="width: 25%;padding:5px;">Nama Wali Siswa</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->nama_wali; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">15.</td>
    <td style="width: 25%;padding:5px;">Alamat Wali Siswa</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->alamat_wali; ?></td>
  </tr>
  
  <tr>
    <td style="width: 5%;">&nbsp;</td>
    <td style="width: 25%;padding:5px;">Nomor Telepon Rumah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->telp_wali; ?></td>
  </tr>
  <tr>
    <td style="width: 5%;">16.</td>
    <td style="width: 25%;padding:5px;">Pekerjaan Wali Siswa</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $s->pekerjaan_wali; ?></td>
  </tr>
  
</table>
<table width="100%">
  <tr>
    <td style="width: 15%;padding:5px;" rowspan="5">
  </td>
  
	<td style="width: 15%;padding:5px;" rowspan="5">
		<table width="100%" style="border: 1px solid #000;">
			<tr>
				<td class="text-center" style="padding-top:50px; padding-bottom:50px;">Pas Foto<br>3 x 4</td>
			</tr>
		</table>
	</td>
	<td style="width: 15%;padding:5px;" rowspan="5">&nbsp;</td>
    <td style="width: 50%;padding:5px;"><?php echo $sekolah->kabupaten; ?>, .................................,20....</td>
  </tr>
  
  <tr>
    <td style="width: 50%;padding:5px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="width: 50%;padding:5px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="width: 50%;padding:5px;"><?php echo $setting->kepsek; ?></td>
  </tr>
  <tr>
    <td style="width: 50%;padding:5px;"><nip>NIP. <?php echo $setting->nip_kepsek; ?></nip></td>
  </tr>
</table>
</body>
</html> 