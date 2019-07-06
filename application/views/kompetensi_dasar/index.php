<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('kompetensi_dasar/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah kompetensi dasar</span>
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th style="width: 8%">Mata Pelajaran</th>
                        <th style="width: 5%">Kode</th>
                        <th style="width: 5%">Kelas</th>
                        <th style="width: 5%">Aspek</th>
                        <th style="width: 20%">Isi Kompetensi</th>
                        <th style="width: 8%">Aksi</th>
                       </tr> 
                    </thead> 
                    <tbody>
                        <?php foreach($result as $kd): ?>
                        <tr>
                          <td><?= $kd->nama_mapel ?></td>
                          <td><?= $kd->id_mapel ?></td>
                          <td><?= $kd->tingkat ?></td>
                          <td><?= $kd->aspek ?></td>
                          <td><?= $kd->kompetensi_dasar ?></td>
                          <td>
                            <div class="btn-group">
                              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= base_url('kompetensi_dasar/edit/'.$kd->id) ?>">Edit</a>
                                <a class="dropdown-item confirm" href="<?= base_url('kompetensi_dasar/delete/'.$kd->id) ?>">Hapus</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 