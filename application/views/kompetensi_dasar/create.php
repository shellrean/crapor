<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('kompetensi_dasar') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-backward"></i>
            </span>
            <span class="text">Kembali</span>
          </a>
          <form id="myform">
          <input type="hidden" value="<?= base_url() ?>" id="base_url">
          <input type="hidden" name="query" id="query" value="add_kd" />

        </div>
        <div class="card-body"> 
            <!--- --------------------- -->
            <?php 
            $ajaran = get_ta();
            $tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
            $data_kompetensi = $this->db->get('keahlian')->result();
            ?>
          <input type="hidden" name="query" id="query" value="add_kd" />
          <input type="hidden" name="ajaran_id" value="<?php echo $ajaran->id; ?>" />
          
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tahun pelajaran</label>
                  <input type="text" class="form-control" value="<?= $tahun_ajaran ?>" readonly>
                </div>

                <div class="form-group">
                  <label>Tingkat</label>
                  <select name="kelas" class="select2 form-control" id="kelas" required>
                    <option value="">&#10147; Pilih tingkat</option>
                    <?php foreach($kelases as $rombel){?>
                    <option value="<?php echo $rombel->tingkat; ?>"<?php echo (isset($tingkat)) ? ($tingkat == $rombel->tingkat ? ' selected="selected"' : '') : ''; ?>>Kelas <?php echo $rombel->tingkat; ?></option>
                    <?php } ?>
                  </select>
                </div>
 
                <div class="form-group">
                  <label>Kelas</label>
                  <select name="rombel_id" class="select2 form-control" id="rombel" required>
                    <option value="">&#10147; Pilih kelas</option>
                  </select>
                </div> 

                <div class="form-group">
                  <label>Mata Pelajaran</label>
                  <select name="mapel_id" class="select2 form-control" id="mapel" required>
                    <option value="">&#10147; Pilih mata pelajaran</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Aspek Penilaian</label>
                  <select name="kompetensi_id" class="select2 form-control" id="kompetensi_id" required>
                    <option value="P">Pengetahuan</option>
                    <option value="K">Keterampilan</option>
                  </select>
                </div>
                  
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode KD</label>
                  <input type="text" name="kd_id" id="kd_id" class="form-control"/>
                </div>

                <div class="form-group">
                  <label>Isi KD</label>
                  <textarea rows="10" name="kd_uraian" id="kd_uraian" class="form-control"></textarea>
                </div>
              </div>
            </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Simpan</span>
          </a>
        </div>
    </div>
  </form>
</div> 