<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card shadow mb-4">
      <div class="card-header py-3">
        Penilaian keterampilan
      </div>
      <form action="" method="post">
      
      <?php
      /** 
       * php code 
       * 
       **/
      // $ajaran = get_ta();
      // $tahun_ajaran = $ajaran->tahun. ' (SMT '.$ajaran->smt.')';
      // $data_kompetensi = $this->db->get('keahlian')->result();
      $ajarans = $this->db->get('ajaran')->result();
      /**
       * End php code
       */
      ?>
      
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tahun ajaran</label>
              <input type="hidden" name="query" id="query" value="rapor" >
              <input type="hidden" id="base_url" value="<?= base_url() ?>">
 
              <select name="ajaran_id" class="select2 form-control" id="ajarans">
                <option value="">&#10147; Pilih tahun ajaran</option>
                <?php foreach($ajarans as $ajaran){?>
                <option value="<?= $ajaran->id; ?>">Tahun <?= $ajaran->tahun.'Semester '.$ajaran->smt ?></option>
                <?php } ?>
              </select>

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
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div id="result"></div>
      </div>
      </form>
  </div>
</div> 