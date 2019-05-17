<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          Data absensi kelas
        </div>
        <form action="<?= base_url().$form_action ?>" method="post">
        <div class="card-body">
          <?php
            $ajaran = get_ta();
            $guru   = get_my_info();

            $kelas      = $this->db->get_where('kelas',['guru_id' => $guru->id])->row();
            $data_siswa = $this->db->get_where('siswa',['kelas_id' => $kelas->id])->result();
          
          ?> 
        
          <input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>" />
          <input type="hidden" name="kelas_id" value="<?= $kelas->id; ?>" />
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" width="100%" cellspacing="0">
              <thead>
                <tr> 
                  <th width="70%">Nama Siswa</th>
                  <th width="10%">Sakit</th>
                  <th width="10%">Izin</th>
                  <th width="10%">TK</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if($data_siswa){
                  foreach($data_siswa as $siswa):

                  $absen = $this->db->get_where('absen',[
                    'ajaran_id'     => $ajaran->id,
                    'kelas_id'      => $kelas->id,
                    'siswa_nis'     => $siswa->nis,
                  ])->row();

                ?>
                <tr>
                  <td>
                    <input type="hidden" name="siswa_nis[]" value="<?= $siswa->nis; ?>" />
                    <?= $siswa->nama; ?>
                  </td>
                  <td><input type="text" class="form-control" name="sakit[]" value="<?= (isset($absen->sakit)) ? $absen->sakit: ''; ?>" /></td>
                  <td><input type="text" class="form-control" name="izin[]" value="<?= isset($absen) ? $absen->izin : ''; ?>" /></td>
                  <td><input type="text" class="form-control" name="alpa[]" value="<?= isset($absen) ? $absen->alpa : ''; ?>" /></td>
                </tr>
                <?php
                  endforeach;
                } else {
                ?>

                <tr>
                  <td colspan="4" class="text-center">Tidak ada data siswa di rombongan belajar terpilih</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-save"></i>
            </span>
            <span class="text">Simpan</span>
          </button>
        </div>
    </div>
    </form>
</div>