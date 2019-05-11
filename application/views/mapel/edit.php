<div class="container-fluid">
    <!-- DataTales Example -->
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('mapel') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-backward"></i>
            </span>
            <span class="text">Kembali</span>
          </a>
      
        </div>
        <form action="<?= base_url('mapel/edit/'.$mapel->id_mapel) ?>" method="post">
        <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode mapel</label>
                  <input type="text" name="id_mapel" class="form-control" placeholder="Kodemapel" value="<?= $id_mapel ?>" readonly>
                  <?= form_error('id_mapel','<small class="form-text text-danger">','</small>') ?>
                </div>
                <div class="form-group">
                  <label>Nama mapel</label>
                  <input type="text" name="nama_mapel" class="form-control" placeholder="Nama mapel" value="<?= $mapel->nama_mapel ?>">
                  <?= form_error('nama_mapel','<small class="form-text text-danger">','</small>') ?>
                </div>
                <div class="form-group">
                  <label>Jurusan</label>
                  <select name="kurikulum_id" id="" class="form-control">
                    <?php foreach($jurusans as $jurusan): ?>
                    <option value="<?= $jurusan->kurikulum_id ?>" <?= ($mapel->kurikulum_id == $jurusan->kurikulum_id ? 'selected' : '') ?>><?= get_kurikulum($jurusan->kurikulum_id) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kelompok mapel</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="A" <?= ($kelompok == 'A' ? 'checked' : '') ?>>
                    <label class="form-check-label" for="exampleRadios1">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="B" <?= ($kelompok == 'B' ? 'checked' : '') ?>>
                    <label class="form-check-label" for="exampleRadios1">
                      B
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C1" <?= ($kelompok == 'C1' ? 'checked' : '') ?>>
                    <label class="form-check-label" for="exampleRadios1">
                      C1
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C2" <?= ($kelompok == 'C2' ? 'checked' : '') ?>>
                    <label class="form-check-label" for="exampleRadios1">
                      C2
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C3" <?= ($kelompok == 'C3' ? 'checked' : '') ?>>
                    <label class="form-check-label" for="exampleRadios1">
                      C3
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label>Kelas 10 </label>
                  <input type="checkbox" name="kelas_X" value="1" <?= ($mapel->kelas_X == 1 ? 'checked' : '') ?>>
                </div>
                <div class="form-group">
                  <label>Kelas 11</label>
                  <input type="checkbox" name="kelas_XI" value="1" <?= ($mapel->kelas_XI == 1 ? 'checked' : '') ?>>
                </div>
                <div class="form-group">
                  <label>Kelas 12</label>
                  <input type="checkbox" name="kelas_XII" value="1" <?= ($mapel->kelas_XII == 1 ? 'checked' : '') ?>>
                </div>
              </div>
            </div>
        </div>
        <div class="card-footer text-muted">
          <button type="submit" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-save"></i>
             </span>
            <span class="text">Simpan</span>
           </button>
        </div>
        </form>
    </div>
</div> 