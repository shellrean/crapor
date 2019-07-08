<?php
$qry = $this->db->query("SELECT * FROM siswa s,anggota_kelas k WHERE s.nis=k.nis AND k.ajaran_id = '$ajaran_id' AND k.id_kelas='$kelas_id'")->result();
$data_siswa = $qry;

$kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();
?>

<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
      <div class="card-header">
        Hasil belajar siswa
      </div>
      <div class="card-body">
<div style="clear:both;"></div>
<div class="table-responsive no-padding">
<table class="table table-bordered table-hover" id="table" width="100%" cellspacing="0">
		<thead>
			<tr> 
				<th width="60%">Nama Siswa</th>
        <td>Aksi</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($data_siswa){
				foreach($data_siswa as $siswa){
			?>
			<tr>
        <td><?= $siswa->nama; ?></td>
        <td>
          <a href="<?= base_url('cetak/rapor_pdf/'.$nama_kompetensi.'/'.$ajaran_id.'/'.$kelas_id.'/'.$siswa->nis) ?>" target="_blank" class="btn btn-sm btn-danger btn-icon-split" title="Cetak rapor">
            <span class="icon text-white-50">
              <i class="fas fa-file-pdf"></i>
            </span>
            <span class="text">Cetak pdf</span>
          </a>
        </td>
        
			</tr>
			<?php
				}
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
</div>
</div>
<script>
$('.tooltip-left').tooltip({
    placement: 'left',
    viewport: {selector: 'body', padding: 2}
  })
</script>