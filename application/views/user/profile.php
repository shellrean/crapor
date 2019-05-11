<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card" style="width: 30rem;">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <img class="card-img-top" src="<?= base_url('assets/img/profile/'.$user->image) ?>" alt="Card image cap">
        </div>
        <div class="col-md-8">
        <table class="table table-striped">
          <thead>
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td><?= $user->name ?></td>
            </tr>
            <tr>
              <td>User login</td>
              <td>:</td>
              <td><?= $user->username ?></td>
            </tr>
          </thead>
        </table>
        </div>
      </div>
    </div>
    <form action="<?= base_url('user/profile') ?>" method="post" enctype="multipart/form-data">
    <div class="card-footer text-muted">
      <input type="file" name="image">
      <button type="submit" class="btn btn-sm btn-info">Upload foto</button>
    </div>
    </form>
  </div>
  
  <div class="card mt-3" style="width: 30rem;">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <form action="<?= base_url('user/ubahpass') ?>" method="post">
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password1" class="form-control" placeholder="Password">
            <?= form_error('password1','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Confirm password</label>
            <input type="password" name="password2" class="form-control" placeholder="Confirm password">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-sm btn-warning">Ubah password</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>