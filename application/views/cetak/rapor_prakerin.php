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
<div class="strong">C.&nbsp;&nbsp;Praktik Kerja Lapangan</div>
<table <?= $atribute; ?>>
	<thead>
		<tr>
			<th style="width: 5%;" align="center">No</th>
			<th style="width: 30%;">Mitra DU/DI</th>
			<th style="width: 35%;">Lokasi</th>
			<th style="width: 10%;" align="center">Lamanya<br>(bulan)</th>
			<th style="width: 20%;" align="center">Keterangan</th>
		</tr>
	</thead>
	<tbody>
  <?php 
  $prakerin = $this->db->get_where('pkl',[
    'ajaran_id'   => $ajaran_id,
    'kelas_id'    => $kelas_id,
    'siswa_nis'   => $siswa_nis
  ])->result();
	if($prakerin){
		$i=1;
		foreach($prakerin as $prak){
		?>
		<tr>
			<td align="center"><?php echo $i; ?></td>
			<td><?php echo $prak->mitra_prakerin; ?></td>
			<td><?php echo $prak->lokasi_prakerin; ?></td>
			<td align="center"><?php echo $prak->lama_prakerin; ?></td>
			<td><?php echo $prak->keterangan_prakerin; ?></td>
		</tr>
		<?php
		$i++;
		}
	} else {
	?>
		<tr>
			<td colspan="5" align="center">Belum ada data untuk ditampilkan</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>