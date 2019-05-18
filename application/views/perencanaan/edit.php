<link rel="stylesheet" href="<?= base_url('assets/') ?>css/tooltip-viewport.css">

<script src="<?= base_url('assets/') ?>js/tooltip-viewport.js"></script>



<div class="container-fluid">
		<div class="card shadow mb-4">
				<div class="card-header py-3">
          <a href="<?= base_url('perencanaan/pengetahuan') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-angle-double-left"></i> 
            </span>
            <span class="text">Kembali</span>
          </a>
				</div>
				
				<div class="card-body">
          <?php
						if($kompetensi_id == 1){ 
							$action = 'update_perencanaan';
						} else {
							$action = 'update_perencanaan';
						}
						$attributes = array('class' => 'form-horizontal');

						$bentuk_penilaian = $this->db->get_where('metode',[
							'ajaran_id'   => $rencana->ajaran_id,
							'kompetensi_id' => $kompetensi_id
						])->result();
					?>
					<form action="<?= base_url().$form_action.$action ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-3">Tahun Ajaran</label>
							<div class="col-sm-5">
								<input type="hidden" name="rencana_id" id="rencana_id" value="<?php echo $rencana->id; ?>" />
								<input type="hidden" name="kompetensi_id" id="kompetensi_id" value="<?php echo $kompetensi_id; ?>" />
								<input name="ajaran_id" type="hidden" value="<?php echo $rencana->ajaran_id; ?>" />
								<input name="rombel_id" type="hidden" value="<?php echo $rencana->kelas_id; ?>" />
								<input name="id_mapel" type="hidden" value="<?php echo $rencana->id_mapel; ?>" />

								<select class="select2 form-control" id="ajaran_id" disabled>
									<option value="">== Pilih Tdahun Ajaran ==</option>
									<?php foreach($ajarans as $ajaran){?>
									<option value="<?php echo $ajaran->id; ?>"<?php echo ($rencana->ajaran_id == $ajaran->id) ? ' selected' : ''; ?>><?php echo $ajaran->tahun; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

            <div class="form-group">
              <label class="col-sm-3">Kelas</label>
				  		<div class="col-sm-5">
                <select class="select2 form-control" id="rombel_id_perencanaan" disabled>
									<option value="">== Pilih Kelas ==</option>
									<?php foreach($kelases as $rombel){?>
									<option value="<?php echo $rombel->id; ?>"<?php echo ($rencana->kelas_id == $rombel->id) ? ' selected="selected"' : ''; ?>><?php echo $rombel->nama; ?></option>
									<?php } ?>
								</select>
              </div>
            </div>
								
						<div class="form-group">
              <label class="col-sm-3">Mata Pelajaran</label>
				  		<div class="col-sm-5">
                <select class="select2 form-control" id="id_mapel_perencanaan" disabled>
									<option value="">== Pilih Mata Pelajaran ==</option>
									<?php
									$all_mapel = $this->db->get_where('kurikulum',['kelas_id' => $rencana->kelas_id])->result();
									if($all_mapel){
										foreach($all_mapel as $mapel){
											$data_mapel = $this->db->get_where('data_mapel',['id_mapel' => $mapel->id_mapel])->row();
											?>
											<option value="<?php echo $mapel->id_mapel; ?>"<?php echo ($rencana->id_mapel == $mapel->id_mapel) ? ' selected="selected"' : ''; ?>><?php echo $data_mapel->nama_mapel.' ('.$data_mapel->id_mapel.')'; ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
			
						<div id="result_kd">
							<?php
							$data_kelas = $this->db->get_where('kelas',['id' => $rencana->kelas_id])->row();
							if($kompetensi_id == 1){
								$aspek = 'P';
							} else {
								$aspek = 'K';
							}
							
							$all_kd_alias = $this->db->get_where('kd',[
								'id_mapel'      => $rencana->id_mapel,
								'tingkat'       => $data_kelas->tingkat,
								'aspek'         => $aspek,
							])->result();
							
							if($all_kd_alias){
								foreach($all_kd_alias as $kd_alias){
									$result[$kd_alias->id][] = $kd_alias->id_kd;
								}
							} 
							else {
								$all_kd = $this->db->get_where('kd',[
									'id_mapel'      => $rencana->id_mapel,
									'tingkat'       => $data_kelas->tingkat,
									'aspek'         => 'PK'
								])->result();

								foreach($all_kd as $kd){
									$result[$kd->id] = $kd->id_kompetensi;
								}
							}

							$this->db->group_by(['nama_penilaian']);
							$this->db->order_by('bentuk_penilaian','ASC');

							$rencana_penilaian_group = $this->db->get_where('rencana_penilaian',[
								'rencana_id'      => $rencana->id,
							])->result();
							?>

							<table class="table table-bordered" id="clone">
								<thead>
									<tr>
										<th class="text-center">Aktifitas Penilaian</th>
										<th class="text-center">Teknik</th>
										<th class="text-center" width="10">Bobot</th>
										<?php
										foreach($result as $key=>$kd_result){
											$kd = $this->db->get_where('kd',['id' => $key])->row();
										?>
										<th class="text-center"><a href="javascript:void(0)" class="tooltip-top" title="<?php echo $kd->kompetensi_dasar; ?>"><?php echo $kd->id_kd; ?></a></th>
										<?php } ?>
										<th class="text-center">Keterangan</th>
										<th class="text-center">Hapus</th>
									</tr>
								</thead>

								<tbody>
									<?php $i=1;foreach($rencana_penilaian_group as $group) {?>
									<tr>
										<td>
											<input class="form-control input-sm" type="text" value="<?php echo $group->nama_penilaian;?>" disabled="disabled" />
											<input type="hidden" name="nama_penilaian[]" value="<?php echo $group->nama_penilaian;?>" />
										</td>
										<td>
											<select class="form-control input-sm" disabled="disabled">
												<option value="">- Pilih -</option>
												<?php 
												if($bentuk_penilaian){
													foreach($bentuk_penilaian as $value){ ?>
												<option value="<?php echo $value->id; ?>"<?php echo isset($group->bentuk_penilaian) ? ($group->bentuk_penilaian == $value->id) ? ' selected="selected"' : '' : ''; ?>><?php echo $value->nama_metode; ?></option>
												<?php } 
												} else {
												?>
												<option value="">Belum ada</option>
												<?php } ?>
											</select>
											<input type="hidden" name="bentuk_penilaian[]" value="<?php echo $group->bentuk_penilaian;?>">
										</td>
										<td>
											<input class="form-control input-sm" type="text" value="<?php echo $group->bobot_penilaian; ?>" disabled="disabled">
											<input type="hidden" name="bobot_penilaian[]" value="<?php echo $group->bobot_penilaian; ?>">
										</td>
										<?php
										foreach($result as $key=>$kd_result){
											$kd = $this->db->get_where('kd',['id' => $key])->row();
											$rencana_penilaian = $this->db->get_where('rencana_penilaian',[
												'rencana_id'        => $rencana->id,
												'kompetensi_id'     => $rencana->kompetensi_id,
												'nama_penilaian'    => $group->nama_penilaian,
												'kd_id'             => $kd->id
											])->row();
										?>
										<td style="vertical-align:middle;">
											<input type="hidden" name="kd_id_<?php echo $i; ?>[]" value="<?php echo $kd->id; ?>" />
											<div class="text-center"><input <?php echo (isset($rencana_penilaian->kd_id) && $rencana_penilaian->kd_id == $kd->id) ? 'checked="checked"' : ''; ?> type="checkbox" class="icheck" name="kd_<?php echo $i; ?>[]" value="<?php echo $kd->id_kd; ?>|<?php echo $kd->id; ?>" /></div>
										</td>
										<?php } ?>
										<td>
											<input class="form-control input-sm" type="text" value="<?php echo $group->keterangan_penilaian;?>" disabled="disabled" />
											<input class="form-control input-sm" type="hidden" name="keterangan_penilaian[]" value="<?php echo $group->keterangan_penilaian;?>" />
										</td>
										<td class="text-center"><a class="confirm btn btn-sm btn-warning" href="<?php echo site_url('perencanaan/delete_rp/'.$group->id); ?>"><i class="fas fa-trash"></i></a></td>
									</tr>
									<?php $i++;} ?>
								</tbody>
							</table>
						</div>
					
				</div>
				<div class="card-footer">
          <button type="submit" class="btn btn-sm btn-success simpan btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-save"></i> 
            </span>
            <span class="text">Simpan</span>
          </button>
				</div>
		</div>
	</div>
</form>

<script>
$('a.confirm').bind('click',function(e) {
	var ini = $(this).parents('tr');
	e.preventDefault();
	var url = $(this).attr('href');
	swal({
		title: "Anda yakin?",
		text: "Tindakan ini tidak bisa dikembalikan!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Hapus!",
		showLoaderOnConfirm: true,
		preConfirm: function() {
			return new Promise(function(resolve) {
				$.get(url)
				.done(function(response) {
					var data = $.parseJSON(response);
					swal({title:data.title, html:data.text, type:data.type}).then(function() {
						ini.remove();
					});
				})
			})
		}
	});
});
</script>