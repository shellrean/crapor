<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="<?= base_url('user') ?>" class="btn btn-sm btn-warning btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-angle-double-left"></i> 
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <form action="<?= base_url('user/edit/'.$users->id); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" value="<?= $users->username; ?>">
            <?= form_error('username','<small class="form-text text-danger">','</small>') ?>
          </div>

          <div class="form-group">
            <label>Nama lengkap</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama lengkap" value="<?= $users->name; ?>">
            <?= form_error('name','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Nip</label>
            <input type="text"  class="form-control" name="nip" id="nip" placeholder="Masukkan nama nip" value="<?= $users->nip; ?>">
            <?= form_error('nip','<small class="form-text text-danger">','</small>') ?>
          </div>  

          <div class="form-group">
            <label>Status</label>
            <select name="is_active" id="is_active" class="select2 form-control">
              <option value="0" <?= ($users->is_active == 0) ? 'selected' : '' ?> >Tidak aktif</option>
              <option value="1" <?= ($users->is_active == 1) ? 'selected' : '' ?> >Aktif</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      <button type="submit" class="btn btn-success btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="far fa-save"></i>
        </span>
        <span class="text">Simpan</span>
      </button>
    </div>
    </form>
  </div>
</div>