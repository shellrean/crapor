<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
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
                            <th>Icon</th>
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
                            <td><div class="icon-circle bg-info ?>">
                                  <i class="<?= $menu->icon ?> text-white"></i>
                                </div></td>
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
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Aksi
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="<?= base_url('panel/edit/'.$menu->id) ?>">Edit</a>
                                  <a class="dropdown-item confirm" href="<?= base_url('panel/delete/'.$menu->id) ?>">Hapus</a>
                                </div>
                              </div>
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