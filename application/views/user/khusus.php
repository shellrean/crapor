<div class="container-fluid">
<?= $this->session->flashdata('message'); ?>
  <div class="card shadow mb-4">
    <div class="card-header">
       <a href="<?= base_url('user/add_khusus') ?>" class="btn btn-sm btn-info btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-user-plus"></i>
        </span>
        <span class="text">Tambah user</span>
      </a>
    </div>
    <div class="card-body">
      <table class="table table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Role</th>
                  <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
              <?php $no = 1;
              foreach ($users as $user) : ?>
              <tr>
                  <td><?= $no ?></td>
                  <td><?= get_nama_guru($user->guru_id) ?></td>
                  <td>
                    <?php if($user->role_id == 4): ?>
                      <span class="badge badge-info">Wakil kurikulum</span>
                      <?php else: ?>
                      <span class="badge badge-success">Bk</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?= base_url('user/delete_khusus/'.$user->id) ?>" class="btn btn-sm btn-danger btn-icon-split" onclick=" return confirm(`Data Ini akan dihapus?`) ">
                      <span class="icon text-white-50">
                        <i class="fas fa-user-slash"></i> 
                      </span>
                      <span class="text">Hapus</span>
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
