<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="<?= base_url('kelas') ?>" class="btn btn-sm btn-warning btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-angle-double-left"></i> 
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <form action="<?= base_url('kelas/edit/'.$kelas->slug); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Nama kelas</label>
            <input type="text" name="name" placeholder="Nama kelas" class="form-control" value="<?= $kelas->nama ?>">
            <?= form_error('name','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Tingkat</label>
            <select name="tingkat" class="select2 form-control">
              <option value="10" <?= ($kelas->tingkat == 10) ? "selected" : "" ?>>10</option>
              <option value="11" <?= ($kelas->tingkat == 11) ? "selected" : "" ?>>11</option>
              <option value="12" <?= ($kelas->tingkat == 12) ? "selected" : "" ?>>12</option>
            </select>
          </div>
          <div class="form-group">
            <label>Wali kelas</label>
            <select name="wali_kelas" class="select2 form-control ">
              <?php foreach($gurus as $guru): ?>
                <option value="<?= $guru->id ?>" <?= ($guru->id == $kelas->guru_id? "selected" : "") ?>><?= $guru->name ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('wali_kelas','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Jurusan</label>
            <select name="jurusan" class="select2 form-control">
              <?php foreach($keahlians as $keahlian): ?>
                <option value="<?= $keahlian->kurikulum_id ?>" <?= ($keahlian->kurikulum_id == $kelas->jurusan_id? "selected" : "") ?>><?= $keahlian->nama_kurikulum ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
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