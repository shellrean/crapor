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
    <form action="<?= base_url('user/create'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" value="<?= set_value('username') ?>">
            <?= form_error('username','<small class="form-text text-danger">','</small>') ?>
          </div>

          <div class="form-group">
            <label>Nama lengkap</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama lengkap" value="<?= set_value('name') ?>">
            <?= form_error('name','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Nip</label>
            <input type="text" class="form-control" name="nip" id="nip" placeholder="Masukkan nama nip" value="<?= set_value('name') ?>">
            <?= form_error('nip','<small class="form-text text-danger">','</small>') ?>
          </div>      
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password1" id="password1" placeholder="Masukkan password" >
                <?= form_error('password1','<small class="form-text text-danger">','</small>') ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm password</label>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Masukkan password">
              </div>
            </div>
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