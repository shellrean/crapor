<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <?php  if(!$this->db->get('siswa')->row()): ?>
          <a href="<?= base_url('siswa/sync') ?>" id="sync" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-sync"></i>
            </span>
            <span class="text">Sinkron dinasti</span>
          </a>
          <?php else: ?>
          <a href="<?= base_url('siswa/drop') ?>" id="delet" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-trash"></i>
            </span>
            <span class="text">Hapus seluruh data siswa</span>
          </a>
          <?php endif; ?>

      
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
                            <td><?= $siswa->nama ?></td>
                            <td><?= $siswa->jk ?></td>
                          </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 