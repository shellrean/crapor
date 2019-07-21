<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          Data siswa
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($siswas as $siswa) : ?>
                          <tr>
                            <td><?= $no ?></td>
                            <td><?= $siswa->nis ?></td>
                            <td><?= $siswa->nisn ?></td>
                            <td><?= $siswa->nama_siswa ?></td>
                            <td><?= $siswa->jk ?></td>
                          </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 