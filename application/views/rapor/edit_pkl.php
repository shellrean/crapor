<?php
$id 			= $prakerin->id;
$ajaran_id		= $prakerin->ajaran_id;
$rombel_id		= $prakerin->kelas_id;
$siswa_id		= $prakerin->siswa_nis;
$mitra_prakerin	= $prakerin->mitra_prakerin;
$lokasi_prakerin 	= $prakerin->lokasi_prakerin;
$lama_prakerin = $prakerin->lama_prakerin;
$keterangan_prakerin	= $prakerin->keterangan_prakerin;
?>
<?php echo ($this->session->flashdata('error')) ? error_msg($this->session->flashdata('error')) : ''; ?>
<?php echo ($this->session->flashdata('success')) ? success_msg($this->session->flashdata('success')) : ''; ?>
<input type="hidden" id="id_prakerin_edit" value="<?php echo $id; ?>" />
<input type="hidden" id="ajaran_id_edit" value="<?php echo $ajaran_id; ?>" />
<input type="hidden" id="rombel_id_edit" value="<?php echo $rombel_id; ?>" />
<input type="hidden" id="siswa_id_edit" value="<?php echo $siswa_id; ?>" />
<div id="form">
	<div class="form-group">
		<label>Mitra DU/DI</label>
		<div class="input-group">
			<input type="text" name="mitra_prakerin" id="mitra_prakerin_edit" class="form-control" value="<?php echo $mitra_prakerin; ?>" required />			
		</div>
	</div>
	<div class="form-group">
		<label>Lokasi</label>
		<div class="input-group">
			<input type="text" name="lokasi_prakerin" id="lokasi_prakerin_edit" class="form-control" value="<?php echo $lokasi_prakerin; ?>" required />			
		</div>
	</div>
	<div class="form-group">
		<label>Lamanya (bulan)</label>
		<div class="input-group">
			<input type="text" class="form-control" name="lama_prakerin" id="lama_prakerin_edit" value="<?php echo $lama_prakerin; ?>" required />
		</div>
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<div class="input-group">
			<input type="text" class="form-control" name="keterangan_prakerin" id="keterangan_prakerin_edit" value="<?php echo $keterangan_prakerin; ?>" required />
		</div>
	</div>
<script>
$('#button_form').click(function(){
	var id = $('#id_prakerin_edit').val();
	var ajaran_id = $('#ajaran_id_edit').val();
	var kelas_id = $('#rombel_id_edit').val();
	var siswa_nis = $('#siswa_id_edit').val();
	var mitra_prakerin = $('#mitra_prakerin_edit').val();
	var lokasi_prakerin = $('#lokasi_prakerin_edit').val();
	var lama_prakerin = $('#lama_prakerin_edit').val();
	var keterangan_prakerin = $('#keterangan_prakerin_edit').val();
	$.ajax({
		url: '<?= base_url('rapor/edit_pkl'); ?>/'+id,
		type: 'post',
		data: {id:id,ajaran_id:ajaran_id,kelas_id:kelas_id,siswa_nis:siswa_nis,mitra_prakerin:mitra_prakerin,lokasi_prakerin:lokasi_prakerin,lama_prakerin:lama_prakerin,keterangan_prakerin:keterangan_prakerin},
		success(response){
			$('#modal_content').modal('hide');
			$('#result').html(response); 
		}
	});
});

</script>