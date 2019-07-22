<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('mapel') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-backward"></i>
            </span>
            <span class="text">Kembali</span>
          </a>
      
        </div>
        <form action="<?= base_url('mapel/create') ?>" method="post">
        <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kode mapel</label>
                  <input type="text" name="id_mapel" class="form-control" placeholder="Kodemapel" value="<?= uniqid() ?>" readonly>
                  <?= form_error('id_mapel','<small class="form-text text-danger">','</small>') ?>
                </div>
                
                <div class="form-group">
                  <label>Nama mapel</label>
                  <input type="text" name="nama_mapel" class="form-control" placeholder="Nama mapel">
                  <?= form_error('nama_mapel','<small class="form-text text-danger">','</small>') ?>
                </div>
                <div class="form-group">
                  <label>Jurusan</label>
                  <select name="kurikulum_id" id="" class="select2 form-control">
                    <?php foreach($jurusans as $jurusan): ?>
                    <option value="<?= $jurusan->kurikulum_id ?>"><?= get_kurikulum($jurusan->kurikulum_id) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div> 
                <div class="form-group">
                  <label>Bobot (P:K)</label>
                  <select name="bobot" id="" class="select2 form-control">
                    <option value="50:50">50:50</option>
                    <option value="60:40">60:40</option>
                    <option value="40:60">40:60</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kelompok mapel</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="A0" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      A (Mapel Agama)
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="A1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="B0">
                    <label class="form-check-label" for="exampleRadios1">
                      B
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C">
                    <label class="form-check-label" for="exampleRadios1">
                      C
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C2">
                    <label class="form-check-label" for="exampleRadios1">
                      C2
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelompok" id="kelompok" value="C3">
                    <label class="form-check-label" for="exampleRadios1">
                      C3
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label>Kelas 10 </label>
                  <input type="checkbox" name="kelas_X" value="1">
                </div>
                <div class="form-group">
                  <label>Kelas 11</label>
                  <input type="checkbox" name="kelas_XI" value="1">
                </div>
                <div class="form-group">
                  <label>Kelas 12</label>
                  <input type="checkbox" name="kelas_XII" value="1">
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