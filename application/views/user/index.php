<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('user/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-user-plus"></i>
            </span>
            <span class="text">Tambah user</span>
          </a>
          <a href="<?= base_url('user/upload') ?>" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-cloud-upload-alt"></i> 
            </span>
            <span class="text">Upload user</span>
          </a>
      
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <td>Status</td>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $user->username ?></td>
                            <td><?= $user->name ?></td>
                            <td>
                              <?php if($user->role_id == 1): ?>
                                <span class="badge badge-info">Admin</span>
                                <?php else: ?>
                                <span class="badge badge-success">User</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if($user->is_active == 1): ?>
                                <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                <span class="badge badge-danger">Tidak Aktif</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Aksi
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="<?= base_url('user/edit/'.$user->id) ?>">Edit</a>
                                  <a class="dropdown-item confirm" href="<?= base_url('user/delete/'.$user->id) ?>">Hapus</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="<?= base_url('user/reset/'.$user->id) ?>">Reset password</a>
                                </div>
                              </div>
                            </td>
                        </tr>
                        <?php $no++;
                      endforeach; ?>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
</div> 