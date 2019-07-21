<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card">
    <div class="card-header">
      Konfigurasi umum aplikasi
    </div>
    <form action="<?= base_url('config'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Semester sekarang</label>
            <select name="periode" id="" class="select2 form-control">
            <?php

              $tahun = [0,0,1,1,2,2]; 
              $i = 0;
              foreach($tahun as $t):
                if($i%2) {
                  $periode = 'Genap';
                } else {
                  $periode = 'Ganjil';
                }
                $t1 = (date('Y')+$t)-2;
                $t2 = (date('Y')+$t)-1;
                $t3 = 'Semester '.$periode;
                $value = $t1.'/'.$t2.' | '.$t3;
            ?>
              <option value="<?= $value ?>" <?= ($setting->periode == $value) ? ' selected' : '';?>>
                <?= $t1.'/'.$t2.' Semester '.$periode ?>
              </option>
            <?php
              $i++;
              endforeach;
            ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tampilkan rumus</label>
            <select name="rumus" id="" class="select2 form-control">
              <option value="1" <?= ($setting->rumus == 1) ? 'selected' : ''; ?>>Ya</option>
              <option value="0" <?= ($setting->rumus == 0) ? 'selected' : ''; ?>>Tidak</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      <button type="submit" class="btn btn-sm btn-success btn-icon-split">
        <span class="icon text-white-50">
          <i class="far fa-save"></i>
        </span>
        <span class="text">Simpan pengaturan</span>
      </button>
      <a href="<?= base_url('config/sync') ?>" id="sync" class="btn btn-sm btn-warning btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-sync"></i>
        </span>
        <span class="text">Sinkron dengan api server pusat</span>
      </a>
    </div>
    </form>
  </div>
</div>

