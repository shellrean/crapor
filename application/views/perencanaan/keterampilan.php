<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('perencanaan/add_keterampilan') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-plus"></i>
            </span>
            <span class="text">Tambah rencana penilaian keterampilan</span>
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
                        <?php
                          $this->db->from('rencana_penilaian');
                          $this->db->group_by(['nama_penilaian']);
                          $this->db->where(['rencana_id' => $d->id]);
                          $rencana_penilaian_group = $this->db->get()->result();

                          $this->db->from('rencana_penilaian');
                          $this->db->group_by(['kd_id']);
                          $this->db->where(['rencana_id' => $d->id]);

                          $rencana_penilaian = $this->db->get()->result();
                          $jumlah_rencana_penilaian = count($rencana_penilaian);
                        ?>

                        <td><?= $ajaran->tahun ?></td>
                        <td><?= get_nama_kelas($d->kelas_id) ?></td>
                        <td><?= get_nama_mapel($ajaran->id,$d->kelas_id,$d->id_mapel) ?></td>
                        <td><?= get_nama_guru($d->guru_id) ?></td> 
                        <td><?= count($rencana_penilaian_group) ?></td>
                        <td><?= $jumlah_rencana_penilaian ?></td> 
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Aksi
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item toggle-modal" href="<?= base_url('perencanaan/edit/'.$d->kompetensi_id.'/'.$d->id) ?>">Edit</a>
                              <a class="dropdown-item confirm" href="<?= base_url('perencanaan/delete/'.$d->id) ?>">Hapus</a>
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