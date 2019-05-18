<?php
$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();

$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();

?>
<div class="text-center">
	<h3>RAPOR SISWA<br>SEKOLAH MENENGAH KEJURUAN<br>(SMK)</h3><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
	<?php /*img src="<?php echo site_url('assets/img/logo.png'); ?>" border="0" width="200" */ ?>
	<img src="<?php echo (isset($sekolah->logo_sekolah) && $sekolah->logo_sekolah != '') ? base_url().PROFILEPHOTOSTHUMBS.$sekolah->logo_sekolah: base_url().'assets/img/logo1.png'; ?>" width="200" border="0" />
<br>
<br>
<br>
<br>
<br>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="width:47%; float:left; padding:7px;">Nama Siswa:</div>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="border:#000000 1px solid; width:47%; float:left; padding:7px;"><?php echo strtoupper($s->nama); ?></div>
<div style="width:25%; float:left;">&nbsp;</div>
<br>
<br>
<br>
<br>
<br>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="width:47%; float:left; padding:7px;">NISN:</div>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="width:25%; float:left;">&nbsp;</div>
<div style="border:#000000 1px solid; width:47%; float:left; padding:7px;"><?php echo $s->nisn; ?></div>
<div style="width:25%; float:left;">&nbsp;</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h3>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>REPUBLIK INDONESIA</h3>
</div>