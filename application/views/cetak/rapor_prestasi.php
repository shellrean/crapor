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
<div class="strong">F.&nbsp;&nbsp;Prestasi</div>
<table <?php echo $atribute; ?>>
	<thead>
		<tr>
			<th style="width: 5%;" >No</th>
			<th style="width: 35%;" >Jenis Prestasi</th>
			<th style="width: 60%;" >Keterangan</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>