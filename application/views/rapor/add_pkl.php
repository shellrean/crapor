<div class="card">
<div class="card-body">


<div class="col-sm-12" id="form">
	<div class="form-group">
		<label for="mitra_prakrein" class="col-sm-2 control-label">Mitra DU/DI</label>
		<div class="input-group col-sm-6">
			<input type="text" name="mitra_prakerin" id="mitra_prakerin" class="form-control" placeholder="Masukkan nama dunia kerja/industri" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lokasi_prakerin" class="col-sm-2 control-label">Lokasi</label>
		<div class="input-group col-sm-6">
			<input type="text" name="lokasi_prakerin" id="lokasi_prakerin" class="form-control" placeholder="Masukkan alamat lokasi dudi" required />			
		</div>
	</div>
	<div class="form-group">
		<label for="lama_prakerin" class="col-sm-2 control-label">Lamanya (bulan)</label>
		<div class="input-group col-sm-6">
			<input type="text" class="form-control" name="lama_prakerin" id="lama_prakerin" placeholder="Masukkan lama waktu perakerin dalam angka" required />
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan_prakerin" class="col-sm-2 control-label">Keterangan</label>
		<div class="input-group col-sm-6">
			<input type="text" class="form-control" name="keterangan_prakerin" id="keterangan_prakerin" placeholder="Masukkan kerangka (opsi)" required />
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2"></div>
		<div class="col-sm-6">
    <button type="submit" class="btn btn-sm btn-success btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-save"></i>
      </span>
      <span class="text">Simpan</span>
    </button>
		</div>
	</div>
</div>

</div>
</div>
		<div style="clear:both"></div>
		<div class="table-responsive no-padding">
		<?php
		$prakerins = $this->db->get_where('pkl',[
      'ajaran_id'     => $ajaran_id,
      'kelas_id'      => $kelas_id,
      'siswa_nis'     => $siswa_nis
    ])->result();
    ?>
			<table class="table table-bordered table-hover" id="table" style="margin-bottom:20px;">
				<thead>
					<th width="2%" style="vertical-align:middle;" class="text-center">No</th>
					<th width="20%" style="vertical-align:middle;">Mitra DU/DI</th>
					<th width="20%" style="vertical-align:middle;">Lokasi</th>
					<th width="5%" class="text-center">Lamanya<br />(bulan)</th>
					<th width="43%" style="vertical-align:middle;">Keterangan</th>
					<th width="15%" style="vertical-align:middle;" class="text-center">Aksi</th>
				</thead>
				<tbody>
					<?php
					if($prakerins){
						$i=1;
						foreach($prakerins as $prakerin){
					?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td><?php echo $prakerin->mitra_prakerin; ?></td>
						<td><?php echo $prakerin->lokasi_prakerin; ?></td>
						<td class="text-center"><?php echo $prakerin->lama_prakerin; ?></td>
						<td><?php echo $prakerin->keterangan_prakerin; ?>
						<td>
              <div class="btn-group">
                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item toggle-modal" href="<?= base_url('rapor/edit_pkl/'.$prakerin->id) ?>">Edit</a>
                  <a class="dropdown-item confirm"  href="<?= base_url('rapor/delete_pkl/'.$prakerin->id); ?>">Hapus</a>
                </div>
              </div>
            </td>
					</tr>
					<?php
						$i++;
						}
					
					} else { ?>
					<tr>
						<td colspan="6" class="text-center">Belum ada data untuk ditampilkan</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
<script>
$('a.toggle-modal').bind('click',function(e) {
	e.preventDefault();
	var url = $(this).attr('href');
	if (url.indexOf('#') == 0) {
		$('#modal_content').modal('open');
	} else {
		$.get(url, function(data) {
			$('#modal_content').modal();
			$('#modal_content').html(data);
		}).done(function(data) {
			if(data == 'activate' || data == 'deactivate'){
				$('#modal_content').modal('hide');
				var url      = window.location.href;
				window.location.replace(url);
			}
		$('input:text:visible:first').focus();
		});
	}
});
</script>