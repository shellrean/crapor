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
    <form action="<?= base_url('user/create_khusus'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">

          <div class="form-group">
            <label>User</label>
            <select name="user_id" id="" class="select2 form-control">
              <?php foreach($users as $user): ?>
              <option value="<?= $user->id ?>"><?= $user->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role_id" id="" class="select2 form-control">
              <option value="4">Wakil kurikulum</option>
              <option value="5">Guru bk</option>
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