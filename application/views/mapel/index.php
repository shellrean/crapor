<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('mapel/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah mapel</span>
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mapel</th>
                            <th>Jurusan</th> 
                            <th>10 </th>
                            <th>11 </th>
                            <th>12 </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($mapels as $mapel) : ?>
                          <tr>
                            <td><?= $mapel->nama_mapel ?></td>
                            <td><?= get_kurikulum($mapel->kurikulum_id) ?></td>
                            <td><?= ($mapel->kelas_X == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>' ) ?></td>
                            <td><?= ($mapel->kelas_XI == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>' ) ?></td>
                            <td><?= ($mapel->kelas_XII == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>' ) ?></td>
                            <td>
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Aksi
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="<?= base_url('mapel/edit/'.$mapel->id_mapel) ?>">Edit</a>
                                  <a class="dropdown-item" href="<?= base_url('mapel/edit/'.$mapel->id_mapel) ?>">Hapus</a>
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