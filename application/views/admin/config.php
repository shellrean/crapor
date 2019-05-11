<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card">
    <div class="card-header">
      Configurasi umum aplikasi
    </div>
    <form action="<?= base_url('config'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Semester sekarang</label>
            <select name="periode" id="" class="form-control">
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
    </div>
    </form>
  </div>
</div>

