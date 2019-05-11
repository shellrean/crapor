<?php
  $data = $this->db->get_where('data_mapel',['id_mapel' => $kd->id_mapel])->row();
?>

<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('kompetensi_dasar') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-backward"></i>
            </span>
            <span class="text">Kembali</span>
          </a>
        </div>
        <div class="card-body">
          <table class="table">
          <tr>
            <td>Kode mapel / tingkat</td>
            <td><?= $data->id_mapel .' / '.$kd->tingkat?></td>
          </tr>
          <tr>
              <td>Mata Pelajaran</td>
              <td><?= $data->nama_mapel; ?></td>
            </tr>
            <tr>
              <td></td><td></td>
            </tr>
          </table>
          <form id="formEditKd">
          <input type="hidden" value="<?= base_url() ?>" id="base_url">
          <input type="hidden" value="<?= $kd->id ?>" id="id_edited">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode KD</label>
                  <input type="text" name="kd_id" id="kd_id" class="form-control" value="<?= $kd->id_kd ?>">
                </div>

                <div class="form-group">
                  <label>Isi KD</label>
                  <textarea rows="10" name="kd_uraian" id="kd_uraian" class="form-control"><?= $kd->kompetensi_dasar ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Simpan</span>
          </a>
        </div>
    </div>
  </form>
</div> 