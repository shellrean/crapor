<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('perencanaan/add_pengetahuan') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-plus"></i>
            </span>
            <span class="text">Tambah rencana penilaian pengetahuan</span>
          </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th style="vertical-align:middle" width="10%">Tahun Ajaran</th>
                          <th style="vertical-align:middle" width="8%">Kelas</th>
                          <th style="vertical-align:middle" width="30%">Mata Pelajaran</th>
                          <th style="vertical-align:middle" width="10%">Nama Guru</th>
                          <th class="text-center" width="5%">Jumlah <br />Penilaian</th>
                          <th class="text-center" width="5%">Jumlah <br />KD</th>
                          <th  style="vertical-align:middle;width: 5%" class="text-center">Tindakan</th>
                        </tr> 
                    </thead>
                    <tbody> 
                      <?php foreach($result as $d): ?>
                      <tr>
                        <td><?= $ajaran->tahun ?></td>
                        <td><?= get_nama_kelas($d->kelas_id) ?></td>
                        <td><?= get_nama_mapel($ajaran->id,$d->kelas_id,$d->id_mapel) ?></td>
                        <td><?= get_nama_guru($d->guru_id) ?></td>
                        <td><?= count($this->M_perencanaan->get_all_rencana_penilaian($d->id)) ?></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 