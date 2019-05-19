<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="<?= base_url('panel/menu') ?>" class="btn btn-sm btn-warning btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-angle-double-left"></i> 
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <form action="<?= base_url('panel/create'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan nama menu" value="<?= set_value('title') ?>">
            <?= form_error('title','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Link</label>
            <input type="text" class="form-control" name="link" id="link" placeholder="Masukkan link" value="<?= set_value('link') ?>">
            <?= form_error('link','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Icon</label>
            <input type="text" class="form-control" name="icon" id="icon" placeholder="Masukkan icon fontawesome" value="<?= set_value('icon') ?>">
            <?= form_error('icon','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select class="select2 form-control" name="role_id">
              <option value="1">Admin</option>
              <option value="2">User</option>
              <option value="3">Wali kelas</option>
            </select>
            <?= form_error('role','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Parent menu</label>
            <select class="select2 form-control" name="is_main_menu" id="is_main_menu">
              <option value="0">Singgle menu</option>
              <?php foreach($menus as $m): ?>
              <option value="<?= $m->id ?>"><?= $m->title ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('is_main_menu','<small class="form-text text-danger">','</small>') ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      <button type="submit" class="btn btn-success btn-icon-split">
        <span class="icon text-white-50">
          <i class="far fa-save"></i>
        </span>
        <span class="text">Simpan</span>
      </button>
    </div>
    </form>
  </div>
</div>