<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$atribute = ' class="table table-bordered col-md-4"';
	} else {
		$atribute = 'border="1" style="margin-left:1px;" width="500px;"';
	}
}
?>
<div class="strong">G.&nbsp;&nbsp;Ketidakhadiran</div>
<table <?php echo $atribute; ?>>
	<tbody>
  <?php
  $data = $this->db->get_where('absen',[
    'ajaran_id'     => $ajaran_id,
    'kelas_id'      => $kelas_id,
    'siswa_nis'     => $siswa_nis
  ])->row();
	if($data){
		?>
		<tr>
			<td width="200">Sakit</td>
			<td> : <?php echo $data->sakit; ?> hari</td>
		</tr>
		<tr>
			<td>Izin</td>
			<td width="300"> : <?php echo $data->izin; ?> hari</td>
		</tr>
		<tr>
			<td>Tanpa Keterangan</td>
			<td> : <?php echo $data->alpa; ?> hari</td>
		</tr>
		<?php
	} else {
	?>
		<tr>
			<td width="200">Sakit</td>
			<td> : .... hari</td>
		</tr>
		<tr>
			<td>Izin</td>
			<td width="300"> : .... hari</td>
		</tr>
		<tr>
			<td>Tanpa Keterangan</td>
			<td> : .... hari</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>