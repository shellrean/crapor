<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card shadow mb-4">
      <div class="card-header py-3">
        Penilaian pengetahuan
      </div>
      <form action="<?= base_url().$form_action ?>" method="post">
      
      <?php
      /** 
       * php code 
       * 
       **/
      $ajaran = get_ta();
      $tahun_ajaran = $ajaran->tahun. ' (SMT '.$ajaran->smt.')';
      $data_kompetensi = $this->db->get('keahlian')->result();

      /**
       * End php code
       */
      ?>
      
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tahun ajaran</label>
              <input type="hidden" name="kompetensi_id" value="<?= $kompetensi_id; ?>" >
              <input type="hidden" name="query" id="query" value="<?= $query; ?>" >
              <input type="hidden" name="query_2" id="query_2" value="kd_penilaian">
              <input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>">
              <input type="hidden" id="base_url" value="<?= base_url() ?>">

              <input type="text" class="form-control" value="<?= $tahun_ajaran; ?>" readonly />
            </div>
            <div class="form-group">
              <label>Tingkat</label>
              <select name="kelas" class="select2 form-control" id="kelas">
                <option value="">&#10147; Pilih tingkat</option>
                <?php foreach($kelases as $kelas){?>
                <option value="<?= $kelas->tingkat; ?>">Kelas <?= $kelas->tingkat; ?></option>
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
            <div class="form-group">
              <label>Penilaian</label>
              <select name="rencana_id" class="select2 form-control" id="penilaians">
                <option value="">&#10147;  Pilih penilaian</option>
              </select>
            </div>
            <div class="form-group">
              <div id="rumus"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div id="result"></div>
        <button type="submit" class="btn btn-sm btn-success btn-icon-split simpan" style="display:none;">
          <span class="icon text-white-50">
            <i class="fas fa-fw fa-save"></i> 
          </span>
          <span class="text">Simpan hasil</span>
        </button>
        <a href="javascript:void(0)" id="rerata" class="btn btn-sm btn-info btn-icon-split" style="display:none;">
          <span class="icon text-white-50">
            <i class="fas fa-fw fa-sync-alt"></i> 
          </span>
          <span class="text">Generate</span>
        </a>
      </div>
      </form>
  </div>
</div> 