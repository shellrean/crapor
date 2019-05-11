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
                              <a href="<?= base_url('mapel/edit/'.$mapel->id_mapel) ?>" class="btn btn-sm btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="far fa-edit"></i>
                                </span>
                                <span class="text">Edit</span>
                              </a>
                              <a href="<?= base_url('mapel/delete/'.$mapel->id_mapel) ?>" class="btn btn-sm btn-danger btn-icon-split" onclick=" return confirm(`Data Ini akan dihapus?`) ">
                                <span class="icon text-white-50">
                                  <i class="fas fa-trash-alt"></i> 
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