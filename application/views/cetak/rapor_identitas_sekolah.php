<?php
$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
?>
<div class="text-center">
<h3>RAPOR SISWA<br>SEKOLAH MENENGAH KEJURUAN<br>(SMK)</h3><br>
</div>
<table width="100%">
  <tr>
    <td style="width: 30%;padding:20px;">Nama Sekolah</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->nama; ?></td>
  </tr>
  <tr>
    <td style="width: 30%;padding:20px;">NPSN / NSS</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->npsn; ?> / <?php echo $sekolah->nss; ?></td>
  </tr>
  <tr>
  <tr>
    <td style="width: 30%;padding:20px;">Alamat</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->alamat_sekolah; ?></td>
  </tr>
  <tr>
    <td style="width: 30%; padding:20px;">&nbsp;</td>
    <td style="width: 5%">&nbsp;</td>
    <td style="width: 65%">Kode Pos <?php echo $sekolah->kode_pos; ?> Telp. <?php echo $sekolah->telp; ?></td>
  </tr>
  <!-- <tr>
    <td style="width: 30%;padding:20px;">Kelurahan</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->desa_kelurahan; ?></td>
  </tr> -->
  <tr>
    <td style="width: 30%;padding:20px;">Kecamatan</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->kecamatan; ?></td>
  </tr>
  <tr>
    <td style="width: 30%;padding:20px;">Kota/Kabupaten</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->kabupaten; ?></td>
  </tr>
  <tr>
    <td style="width: 30%;padding:20px;">Provinsi</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->provinsi; ?></td>
  </tr>
  <tr>
    <td style="width: 30%;padding:20px;">Website</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->website; ?></td>
  </tr>
  <tr>
    <td style="width: 30%;padding:20px;">Email</td>
    <td style="width: 5%">:</td>
    <td style="width: 65%"><?php echo $sekolah->email; ?></td>
  </tr>
</table>