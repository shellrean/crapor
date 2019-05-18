<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$atribute = ' class="table table-bordered"';
	} else {
		$atribute = ' border="1" class="table"';
	}
}
$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();
$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
$ajaran = $this->db->get('ajaran',['id' => $ajaran_id])->row();
$rombel = $this->db->get('kelas',['id' => $kelas_id])->row();

?>
<div class="strong">E.&nbsp;&nbsp;Ekstrakurikuler</div>
<table <?php echo $atribute; ?>>
	<thead>
		<tr>
			<th style="width: 5%;">No</th>
			<th style="width: 35%;">Kegiatan Ekstrakurikuler</th>
			<th style="width: 60%;">Keterangan</th>
		</tr>
	</thead>
	<tbody>
	<?php
  $ekskul = $this->db->get_where('nilai_ekskul',[
    'ajaran_id'     => $ajaran_id,
    'kelas_id'      => $kelas_id,
    'siswa_nis'     => $siswa_nis
  ])->result();

  if($ekskul){
		$i=1;
		foreach($ekskul as $eks){
      $nama_ekskul = $this->db->get_where('ekskul',['id' => $eks->ekskul_id])->row();
			if($eks->deskripsi_ekskul){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $nama_ekskul->nama_ekskul; ?></td>
			<td><?php echo $eks->deskripsi_ekskul; ?></td>
		</tr>
		<?php
		}
		$i++;
		}
	} else {
	?>
		<tr>
			<td colspan="3" align="center">Belum ada data untuk ditampilkan</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>