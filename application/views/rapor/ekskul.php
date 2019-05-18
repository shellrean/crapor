<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3"> 
          Ekstrakurikuler
        </div>
        <form action="<?= base_url().$form_action ?>" method="post">

        <?php 

				$ajaran = get_ta();
				$guru = get_my_info();
        $kelas = get_kelas_by_id_guru($guru->id);
        $data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas->id])->result();

        $all_ekskul = $this->db->get_where('ekskul',['ajaran_id' => $ajaran->id])->result();
      
        ?>  


        <div class="card-body">
          <input type="hidden" name="query" id="query" value="ekskul" />
					<input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>" />
					<input type="hidden" name="kelas_id" value="<?= $kelas->id; ?>" />
          <input type="hidden" id="base_url" value="<?= base_url('asesmen') ?>">
					<div class="form-group">
						<label class="control-label">Ekstrakurikuler</label>
						<div class="col-sm-5">
							<select name="ekskul_id" class="select2 form-control" id="ekskul" required>
								<option value="">&#10147; Pilih ekskul</option>
								<?php foreach($all_ekskul as $ekskul){ ?>
								<option value="<?= $ekskul->id; ?>"><?= $ekskul->nama_ekskul; ?></option>
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