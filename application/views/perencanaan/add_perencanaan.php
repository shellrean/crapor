<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('perencanaan/add_pengetahuan') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-plus"></i>
            </span>
            <span class="text">Tambah rencana penilaian pengetahuan</span>
          </a>
        </div>
        <form action="<?= base_url().$form_action ?>" >
        <?php
 
            $ajaran = get_ta();
            $tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
            $data_kompetensi = $this->db->get('keahlian')->result();

        ?>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tahun pelajaran</label>
                  <input type="hidden" id="base_url" value="<?= base_url() ?>">
                  <input type="hidden" name="query" id="query" value="<?= $query; ?>" />
                  <input type="hidden" name="kompetensi_id" id="kompetensi_id" value="1" />
                  <input type="hidden" name="ajaran_id" id="ajaran_id" value="<?= $ajaran->id; ?>" />
                  <input type="text" class="form-control" value="<?= $tahun_ajaran ?>" readonly>
                </div>
 
                <div class="form-group">
                  <label>Tingkat</label>
                  <select name="kelas" class="select2 form-control" id="kelas">
                    <option value="">&#10147; Pilih tingkat</option>
                    <?php foreach($kelas as $k){?>
                    <option value="<?= $k->tingkat; ?>">Tingkat <?= $k->tingkat; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Kelas</label>
                  <select name="kelas_id" class="select2 form-control" id="rombel">
                    <option value="">&#10147; Pilih kelas</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Mata pelajaran</label>
                  <select name="id_mapel" class="select2 form-control" id="mapel">
						        <option value="">&#10147; Pilih mata pelajaran</option>
					        </select>
              </div>
            </div>
        </div>
        
    </div>
      
        <div class="card-footer">
        <div class="box-footer table-responsive no-padding" id="result"> 
			</div>  
          


        </div>
        </form>
</div> 