<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('panel/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah menu</span>
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama menu</th>
                            <th>Link</th>
                            <th>Parent menu</th>
                            <td>Role</td>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu) : ?>
                        <tr>
                            <td><?= $menu->id ?></td>
                            <td><?= $menu->title ?></td>
                            <td><?= $menu->link ?></td>
                            <td>
                              <?php if($menu->is_main_menu == 0): ?>
                                <span class="badge badge-info">Singgle menu</span>
                              <?php else: ?>
                                <span class="badge badge-success"><?= $menu->is_main_menu ?></span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if($menu->role == 1): ?>
                                <span class="badge badge-info">Admin</span>
                              <?php elseif($menu->role == 2): ?>
                                <span class="badge badge-success">User</span>
                              <?php elseif($menu->role == 3): ?>
                                <span class="badge badge-success">Wali kelas</span>
                              <?php endif; ?>
                            </td> 
                            <td>
                              <a href="<?= base_url('panel/edit/'.$menu->id) ?>" class="btn btn-sm btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="far fa-edit"></i>
                                </span>
                                <span class="text">Edit</span>
                              </a>
                              <a href="<?= base_url('panel/delete/'.$menu->id) ?>" class="btn btn-sm btn-danger btn-icon-split" onclick=" return confirm(`Data Ini akan dihapus?`) ">
                                <span class="icon text-white-50">
                                  <i class="far fa-trash-alt"></i>
                                </span>
                                <span class="text">Hapus</span>
                              </a>
                            </td>
                        </tr>
                        <?php
                      endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 