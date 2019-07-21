<?php
$data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas_id])->result();
?>
<div class="card">
  <div class="card-body">


<div class="table-responsive no-padding">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="20%">Nama Siswa</th>
				<th width="20%">Predikat</th>
				<th width="60%">Deskripsi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($data_siswa){
				foreach($data_siswa as $siswa){

        $nilai_ekskul = $this->db->get_where('nilai_ekskul',[
          'ajaran_id'     => $ajaran_id,
          'ekskul_id'     => $ekskul_id,
          'kelas_id'      => $kelas_id,
          'siswa_nis'     => $siswa->nis
        ])->row();
      ?>
			<tr>
				<td>
					<input type="hidden" name="siswa_nis[]" value="<?= $siswa->nis; ?>" />
					<?= $siswa->nama; ?>
				</td>
				<td>
					<select name="nilai[]" class="form-control" id="nilai_ekskul">
						<option value="">&#10147; Pilih predikat</option>
						<option value="1"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 1) ? 'selected="selected"' : ''; ?>>Sangat Baik</option>
						<option value="2"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 2) ? 'selected="selected"' : ''; ?>>Baik</option>
						<option value="3"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 3) ? 'selected="selected"' : ''; ?>>Cukup</option>
						<option value="4"<?php echo (isset($nilai_ekskul->nilai) && $nilai_ekskul->nilai == 4) ? 'selected="selected"' : ''; ?>>Kurang</option>
					</select>
				</td>
				<td><input type="text" class="form-control" id="deskripsi_ekskul" name="deskripsi_ekskul[]" value="<?php echo isset($nilai_ekskul->deskripsi_ekskul) ? $nilai_ekskul->deskripsi_ekskul : ''; ?>" /></td>
			</tr>
			<?php
				}
			} else {
			?>
			<tr>
				<td colspan="4" class="text-center">Tidak ada data siswa di rombongan belajar terpilih</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>

<button type="submit" class="btn btn-sm btn-success btn-icon-split my-2">
  <span class="icon text-white-50">
    <i class="far fa-save"></i>
  </span>
  <span class="text">Simpan</span>
</button>

<script>
$('select#nilai_ekskul').change(function(e) {
	e.preventDefault();
	var ini = $(this).val();
	var nama_ekskul = $("#ekskul option:selected").text();
	var nilai_ekskul = $(this).find("option:selected").text();
	if(ini == ''){
		$(this).closest('td').next('td').find('input').val('');
	} else {
		$(this).closest('td').next('td').find('input').val('Melaksanakan kegiatan '+nama_ekskul+' dengan '+nilai_ekskul);
	}
});
</script>