<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          Praktik kerja lapangan
        </div>
        <form action="<?= base_url().$form_action ?>" method="post">

        <?php 

				$ajaran = get_ta();
				$guru = get_my_info();
        $kelas = get_kelas_by_id_guru($guru->id);
        $data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas->id])->result();
      
        ?> 


        <div class="card-body">
          <input type="hidden" name="query" id="query" value="prakerin" />
					<input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>" />
					<input type="hidden" name="kelas_id" value="<?= $kelas->id; ?>" />
          <input type="hidden" id="base_url" value="<?= base_url() ?>">
					<div class="form-group">
						<label for="siswa_id" class="col-sm-2 control-label">Nama Siswa</label>
						<div class="col-sm-5">
							<select name="siswa_nis" class="select2 form-control" id="siswa" required>
								<option value="">&#10147; Pilih siswa</option>
								<?php foreach($data_siswa as $siswa){ ?>
								<option value="<?= $siswa->nis; ?>"><?php echo $siswa->nama; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
        </div>
 
        <div class="card-footer">
          <div id="result"></div>
        </div>

        </form>
    </div>
</div>