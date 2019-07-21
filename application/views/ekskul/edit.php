<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('ekskul') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-angle-double-left"></i> 
            </span>
            <span class="text">Kembali</span>
          </a>
        </div>
        <form action="<?= base_url().$form_action ?>" method="post">
        <div class="card-body">
        
        <?php
          $readonly = ''; 
          $ajaran = $this->db->get_where('ajaran',['id' => $ekskul->ajaran_id])->row();
          $tahun_ajaran = $ajaran->tahun. ' (SMT '. $ajaran->smt.')';
        ?>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Tahun pelajaran</label>
              <input type="text" name="name" placeholder="Nama kelas" class="form-control" value="<?= $tahun_ajaran; ?>" readonly>
              <?= form_error('name','<small class="form-text text-danger">','</small>') ?>
            </div>

            <div class="form-group">
              <label>Guru pembimbing</label>
              <select name="guru_id" class="form-control select2">
                <?php foreach($data_guru as $guru): ?>
                  <option value="<?= $guru->id ?>" <?= ($ekskul->guru_id = $guru->id) ? 'selected' : '' ?> ><?= $guru->name ?></option>
                <?php endforeach; ?>
              </select>
            </div>

          
            <input type="hidden" name="query" value="ekskul" >
            <input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>" >

            <div class="form-group">
              <label>Nama eksktrakurikuler</label>
              <input type="text" name="nama_ekskul" placeholder="Masukkan nama eksktrakurikuler" class="form-control" value="<?= $ekskul->nama_ekskul ?>" required>
              <?= form_error('nama_ekskul','<small class="form-text text-danger">','</small>') ?>
            </div>

            <div class="form-group">
              <label>Nama ketua</label>
              <input type="text" name="nama_ketua" placeholder="Masukkan nama ketua" class="form-control" value="<?= $ekskul->nama_ketua ?>" required>
              <?= form_error('nama_ketua','<small class="form-text text-danger">','</small>') ?>
            </div>

            <div class="form-group">
              <label>Nomor kontak</label>
              <input type="text" name="nomor_kontak" placeholder="Masukkan nomor kontak ekskul" class="form-control" value="<?= $ekskul->nomor_kontak ?>" required>
              <?= form_error('nomor_kontak','<small class="form-text text-danger">','</small>') ?>
            </div>

          </div>
        </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success btn-icon-split btn-sm">
            <span class="icon text-white-50">
              <i class="far fa-save"></i>
            </span>
            <span class="text">Simpan</span>
          </button>
        </div>
        </form>
    </div>
</div> 