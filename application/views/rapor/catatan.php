<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          Catatan wali kelas
        </div>
        
        <div class="card-body">
        <form action="<?= base_url().$form_action ?>" method="post">
      <?php
      $ajaran = get_ta();
      $guru = get_my_info();
      $data_kelas = $this->db->get_where('kelas',['guru_id' => $guru->id])->row();
      $data_siswa = $this->db->get_where('siswa',['kelas_id' => $data_kelas->id])->result();

      ?>
			<input type="hidden" name="ajaran_id" value="<?= $ajaran->id; ?>" />
			<input type="hidden" name="kelas_id" value="<?= $data_kelas->id; ?>" />
			<div class="table-responsive no-padding">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="20%">Nama Siswa</th>
							<th width="80%">Deskripsi</th>
						</tr>
					</thead>
					<tbody
            <?php 
            if($data_siswa){
              foreach($data_siswa as $siswa){ 
            ?>
            <?php
            
            $deskripsi_antar_mapel = $this->db->get_where('catatan',[
              'ajaran_id'     => $ajaran->id,
              'kelas_id'      => $data_kelas->id,
              'siswa_nis'     => $siswa->nis
            ])->row();

            $data_deskripsi = '';
            if($deskripsi_antar_mapel){
              $data_deskripsi .= $deskripsi_antar_mapel->uraian_deskripsi;
            }
            ?>

            <tr>
              <td>
                <input type="hidden" name="siswa_nis[]" value="<?= $siswa->nis; ?>" /> 
                <?= $siswa->nama.'<br />'; ?>
                <?= $siswa->nisn.'<br />'; ?>
              </td>
              <td>
                <textarea class="form-control" name="uraian_deskripsi[]" style="width: 100%; height: 100px; font-size: 16px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $data_deskripsi; ?></textarea>
              </td>
            </tr>
				    <?php } }?>
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
  </form>
</div>
</div>
