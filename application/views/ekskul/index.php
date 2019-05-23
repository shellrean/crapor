<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('ekskul/create') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah ekskul</span>
          </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered " id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Tahun Pelajaran</th>
                          <th>Nama Ekskul</th>
                          <th>Nama Pembina</th>
                          <th>Nama Ketua</th>
                          <th>Nomor Kontak</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($ekskuls as $d): ?>

                      <?php

                        # some commentar
                        $ajaran = $this->db->get_where('ajaran',['id' => $d->ajaran_id])->row();
                        $tahun_ajaran = $ajaran->tahun;

                        # some comentar
                        $guru = $this->db->get_where('user',['id' => $d->guru_id])->row();
                        if($guru){
                          $nama_guru = $guru->name;
                        }
                      ?>

                      <tr>
                        <td><?= $tahun_ajaran ?></td>
                        <td><?= $d->nama_ekskul ?></td>
                        <td><?= $nama_guru ?></td>
                        <td><?= $d->nama_ketua ?></td>
                        <td><?= $d->nomor_kontak ?></td>
                        <td>

						              <div class="btn-group">
                              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= base_url('ekskul/edit/'.$d->id) ?>">Edit</a>
                                <a class="dropdown-item confirm" href="<?= base_url('ekskul/delete/'.$d->id) ?>">Hapus</a>
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
