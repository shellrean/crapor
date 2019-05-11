<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('kelas/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah kelas</span>
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Kenaikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($kelases as $kelas) : ?>
                          <tr> 
                            <td><?= $no ?></td>
                            <td><?= $kelas->tingkat ?></td>
                            <td><?= get_kurikulum($kelas->jurusan_id) ?></td>
                            <td>
                              <?php if($ajaran->smt == 2): ?>
                              <a href="<?= base_url('kelas/kenaikan/'.$kelas->id) ?>" class="btn btn-sm btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-angle-double-up"></i>
                                </span>
                                <span class="text">Kenaikan</span>
                              </a> 
                              <?php else: ?>
                              <a href="<?= base_url('kelas/lanjut/'.$kelas->id) ?>" class="btn btn-sm btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-angle-double-up"></i>
                                </span>
                                <span class="text">Lanjut semester</span>
                              </a> 
                              <?php endif; ?>
                            </td>
                            <td>
                              
                              <a href="<?= base_url('kelas/anggota/'.$kelas->slug) ?>" class="btn btn-sm btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-user"></i> 
                                </span>
                                <span class="text">Anggota</span>
                              </a>
                              
                              <a href="<?= base_url('kelas/mapel/'.$kelas->slug) ?>" class="btn btn-sm btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-clipboard-list"></i> 
                                </span>
                                <span class="text">Mapel</span>
                              </a>

                              <a href="<?= base_url('kelas/edit/'.$kelas->slug) ?>" class="btn btn-sm btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="far fa-edit"></i>
                                </span>
                                <span class="text">Edit</span>
                              </a>
                              <a href="<?= base_url('kelas/delete/'.$kelas->slug) ?>" class="btn btn-sm btn-danger btn-icon-split" onclick=" return confirm(`Data Ini akan dihapus?`) ">
                                <span class="icon text-white-50">
                                  <i class="fas fa-backspace"></i> 
                                </span>
                                <span class="text">Hapus</span>
                              </a>

                            </td>
                          </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 