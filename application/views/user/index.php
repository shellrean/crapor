<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
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
                              <a href="<?= base_url('user/edit/'.$user->id) ?>" class="btn btn-sm btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="far fa-edit"></i>
                                </span>
                                <span class="text">Edit</span>
                              </a>
                              <a href="<?= base_url('user/delete/'.$user->id) ?>" class="btn btn-sm btn-danger btn-icon-split" onclick=" return confirm(`Data Ini akan dihapus?`) ">
                                <span class="icon text-white-50">
                                  <i class="fas fa-user-slash"></i> 
                                </span>
                                <span class="text">Hapus</span>
                              </a>
                              <a href="<?= base_url('user/reset/'.$user->id) ?>" class="btn btn-sm btn-info btn-icon-split" onclick=" return confirm(`Password user ini akan direset?`) ">
                                <span class="icon text-white-50">
                                  <i class="fas fa-sync"></i> 
                                </span>
                                <span class="text">Reset password</span>
                              </a>
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