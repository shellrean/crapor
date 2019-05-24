<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4 ">
      <div class="card-header">
        <a href="<?= base_url('siswa') ?>" class="btn btn-sm btn-warning btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-backward"></i>
          </span>
          <span class="text">Kembali</span>
        </a>
      </div>
      <div class="card-body maxeder">
        <form action="<?= base_url('siswa/edit/'.$siswa->id) ?>" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>NIS</label>
              <input type="text" name="nis" class="form-control" placeholder="Nomor induk siswa" value="<?= $siswa->nis ?>">
              <?= form_error('nis','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>NISN</label>
              <input type="text" name="nisn" class="form-control" placeholder="Nomor induk siswa nasional" value="<?= $siswa->nisn ?>">
              <?= form_error('nisn','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Nama lengkap</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" value="<?= $siswa->nama?>">
              <?= form_error('nama','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Jenis kelamin</label>
              <select name="jk" class="select2 form-control">
                <option value="L" <?= ($siswa->jk == 'L' ? 'selected' : '') ?>>Laki-laki</option>
                <option value="P" <?= ($siswa->jk == 'P' ? 'selected' : '') ?>>Perempuan</option>
              </select>
              <?= form_error('jk','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Tempat lahir</label>
              <input type="text" name="temp_lahir" class="form-control" placeholder="Tempat lahir" value="<?= $siswa->temp_lahir ?>">
              <?= form_error('temp_lahir','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Tanggal lahir</label>
              <input type="text" name="tgl_lahir" class="form-control" placeholder="Tanggal lahir (dd M Y)" value="<?= $siswa->tgl_lahir ?>">
              <?= form_error('tgl_lahir','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Agama</label>
              <select name="agama" class="select2 form-control">
                <option value="ISLAM" <?= ($siswa->agama == 'ISLAM' ? 'selected' : '') ?>>Islam</option>
                <option value="KRISTEN" <?= ($siswa->agama == 'KRISTEN' ? 'selected' : '') ?>>Kristen</option>
                <option value="KATOLIK" <?= ($siswa->agama == 'KATOLIK' ? 'selected' : '') ?>>Katolik</option>
                <option value="HINDU" <?= ($siswa->agama == 'HINDU' ? 'selected' : '') ?>>Hindu</option>
                <option value="KONG HU CU" <?= ($siswa->agama == 'KONG HU CU' ? 'selected' : '') ?>>Kong hu cu</option>
              </select>
              <?= form_error('agama','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Status dalam keluarga</label>
              <select name="status_keluarga" class="select2 form-control">
                <option value="ANAK KANDUNG" <?= ($siswa->status_keluarga == 'ANAK KANDUNG' ? 'selected' : '') ?>>Anak kandung</option>
                <option value="ANAK ANGKAT" <?= ($siswa->status_keluarga == 'ANAK ANGKAT' ? 'selected' : '') ?>>Anak angkat</option>
              </select>
              <?= form_error('status_keluarga','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Anak ke</label>
              <input type="number" name="anak_ke" class="form-control" placeholder="Anak ke" value="<?= $siswa->anak_ke ?>">
              <?= form_error('anak_ke','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea name="alamat" class="form-control" placeholder="Alamat "><?= $siswa->alamat ?></textarea>
              <?= form_error('alamat','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Telp rumah</label>
              <input type="text" name="telp_rumah" class="form-control" placeholder="Telp rumah" value="<?= $siswa->telp ?>">
              <?= form_error('telp_rumah','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Asal sekolah</label>
              <input type="text" name="asal_sekolah" class="form-control" placeholder="Asal sekolah" value="<?= $siswa->asal_sekolah ?>">
              <?= form_error('asal_sekolah','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Diterima dikelas</label>
              <input type="text" name="kelas_diterima" class="form-control" placeholder="Diterima dikelas" value="<?= $siswa->kelas_diterima ?>">
              <?= form_error('kelas_diterima','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Tanggal diterima</label>
              <input type="text" name="tgl_diterima" class="form-control" placeholder="Tanggal diterima" value="<?= $siswa->tgl_diterima ?>">
              <?= form_error('tgl_diterima','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Nama ayah</label>
              <input type="text" name="nama_ayah" class="form-control" placeholder="Nama ayah" value="<?= $siswa->nama_ayah ?>">
              <?= form_error('nama_ayah','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Nama ibu</label>
              <input type="text" name="nama_ibu" class="form-control" placeholder="Nama ibu" value="<?= $siswa->nama_ibu ?>">
              <?= form_error('nama_ibu','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Alamat orangtua</label>
              <textarea name="alamat_ortu" class="form-control" placeholder="Alamat orangtua"><?= $siswa->alamat_orangtua ?></textarea>
              <?= form_error('alamat_ortu','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Telp orangtua</label>
              <input type="text" name="telp_ortu" class="form-control" placeholder="Telp orangtua" value="<?= $siswa->tlp_ortu ?>">
              <?= form_error('telp_ortu','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Pekerjaan ayah</label>
              <input type="text" name="pekerjaan_ayah" class="form-control" placeholder="Pekerjaan ayah" value="<?= $siswa->pekerjaan_ayah ?>">
              <?= form_error('pekerjaan_ayah','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Pekerjaan ibu</label>
              <input type="text" name="pekerjaan_ibu" class="form-control" placeholder="Pekerjaan ibu" value="<?= $siswa->pekerjaan_ibu ?>">
              <?= form_error('pekerjaan_ibu','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Nama wali</label>
              <input type="text" name="nama_wali" class="form-control" placeholder="Nama wali" value="<?= $siswa->nama_wali ?>">
              <?= form_error('nama_wali','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Alamat wali</label>
              <textarea name="alamat_wali" class="form-control" placeholder="Alamat wali"><?= $siswa->alamat_wali ?></textarea>
              <?= form_error('alamat_wali','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Telp wali</label>
              <input type="text" name="telp_wali" class="form-control" placeholder="Telp wali" value="<?= $siswa->telp_wali ?>">
              <?= form_error('telp_wali','<small class="form-text text-danger">','</small>') ?>
            </div>
            <div class="form-group">
              <label>Pekerjaan wali</label>
              <input type="text" name="pekerjaan_wali" class="form-control" placeholder="Pekerjaan wali" value="<?= $siswa->pekerjaan_wali ?>">
              <?= form_error('pekerjaan_wali','<small class="form-text text-danger">','</small>') ?>
            </div>

            <div class="form-group">
              <button class="btn btn-sm btn-success btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-save"></i>
                </span>
                <span class="text">Simpan</span>
              </button>
            </div>
            </div>
          </form>
        </div>
      </div>

    </div>
</div> 