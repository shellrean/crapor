<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('siswa/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah data siswa</span> 
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nis</th>
                            <th>Nisn</th>
                            <th>Nama lengkap</th>
                            <th>L/P</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($siswas as $siswa) : ?>
                          <tr>
                            <td><?= $no ?></td>
                            <td><?= $siswa->nis ?></td>
                            <td><?= $siswa->nisn ?></td>
                            <td><?= $siswa->nama ?></td>
                            <td><?= $siswa->jk ?></td>
                            <td>
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Aksi
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item toggle-modal" href="<?= base_url('siswa/detail/'.$siswa->id) ?>">Detail</a>
                                  <a class="dropdown-item" href="<?= base_url('siswa/edit/'.$siswa->id) ?>">Edit</a>
                                  <a class="dropdown-item confirm" href="<?= base_url('siswa/delete/'.$siswa->id) ?>">Hapus</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 