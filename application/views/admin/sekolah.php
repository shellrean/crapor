<div class="container-fluid">
  <?= $this->session->flashdata('message'); ?>
  <div class="card">
    <div class="card-header">
      Profil sekolah
    </div>
    <form action="<?= base_url('config/sekolah'); ?>" method="post">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="fom-group">
            <label>Nama sekolah</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama sekolah" value="<?= $sekolah->nama ?>">
            <?= form_error('nama','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>NSS</label>
            <input type="text" name="nss" class="form-control" placeholder="NSS" value="<?= $sekolah->nss ?>">
            <?= form_error('NSS','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>NPSN</label>
            <input type="text" name="npsn" class="form-control" placeholder="NPSN" value="<?= $sekolah->nss ?>">
            <?= form_error('NSS','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Alamat sekolah</label>
            <input type="text" name="alamat_sekolah" class="form-control" placeholder="Alamat sekolah" value="<?= $sekolah->alamat_sekolah ?>">
            <?= form_error('alamat_sekolah','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Kode pos</label>
            <input type="text" name="kode_pos" class="form-control" placeholder="Kode pos" value="<?= $sekolah->kode_pos ?>">
            <?= form_error('kode_pos','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Telp</label>
            <input type="text" name="telp" class="form-control" placeholder="No telp" value="<?= $sekolah->telp ?>">
            <?= form_error('telp','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Keahlian</label>
            <select name="kompetensi_keahlian[]" id="" class="select2 form-control" multiple>

            <?php
              $keahlian = $this->db->get('keahlian')->result();
              if($keahlian) {
                foreach($keahlian as $ahli) {
                  $ahli_id[] = $ahli->kurikulum_id;
                }
              }
              if(isset($ahli_id)) {
                $ahli_id = $ahli_id;
              } else {
                $ahli_id = array();
              }
              $kurikulum = $this->db->get('data_kurikulum')->result();
              foreach($kurikulum as $komp):
            ?>
              <option value="<?= $komp->kurikulum_id ?>" <?= (isset($keahlian) && in_array($komp->kurikulum_id,$ahli_id)) ? 'selected' : ''; ?>><?= $komp->nama_kurikulum; ?></option>
            <?php
              endforeach;
            ?>

            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="fom-group">
            <label>Faks</label>
            <input type="text" name="faks" class="form-control" placeholder="No faks" value="<?= $sekolah->faks ?>">
            <?= form_error('faks','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="<?= $sekolah->kecamatan ?>">
            <?= form_error('kecamatan','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Kabupaten/Kota</label>
            <input type="text" name="kota" class="form-control" placeholder="Kabupaten/Kota" value="<?= $sekolah->kabupaten ?>">
            <?= form_error('kota','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Provinsi</label>
            <input type="text" name="provinsi" class="form-control" placeholder="Provinsi" value="<?= $sekolah->provinsi ?>">
            <?= form_error('provinsi','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Website</label>
            <input type="text" name="website" class="form-control" placeholder="Website" value="<?= $sekolah->website ?>">
            <?= form_error('website','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="fom-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email" value="<?= $sekolah->email ?>">
            <?= form_error('email','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Nama kepala sekolah</label>
            <input type="text" name="kepsek" class="form-control" placeholder="Nama kepala sekolah" value="<?= $setting->kepsek ?>">
            <?= form_error('kepsek','<small class="form-text text-danger">','</small>') ?>
          </div>
          <div class="form-group">
            <label>Nip Kepala sekolah</label>
            <input type="text" name="nip_kepsek" class="form-control" placeholder="Nip kepala sekolah" value="<?= $setting->nip_kepsek ?>">
            <?= form_error('nip_kepsek','<small class="form-text text-danger">','</small>') ?>
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
