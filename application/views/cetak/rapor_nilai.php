<?php
$uri = $this->uri->segment_array();
if(isset($uri[3])){
	if($uri[3] == 'review_rapor'){
		$border = '';
		$class = 'table table-bordered';
	} else {
		$border = 'border="1"';
		$class = 'table';
	}
}

$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();
$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
$ajaran = $this->db->get('ajaran',['id' => $ajaran_id])->row();
$rombel = $this->db->get('kelas',['id' => $kelas_id])->row();

$kelompok_a = preg_quote('A0', '~'); // don't forget to quote input string!
$kelompok_b = preg_quote('B0', '~'); // don't forget to quote input string!
$kelompok_c = preg_quote('C', '~'); // don't forget to quote input string!
$all_mapel = $this->db->get_where('kurikulum',[
  'ajaran_id'     => $ajaran_id,
  'kelas_id'      => $kelas_id
])->result();
?>


<div class="strong">B.&nbsp;&nbsp;Pengetahuan dan Keterampilan</div>

<table <?php echo $border; ?> class="<?php echo $class; ?>">
  
  <thead>
  <tr>
    <th style="vertical-align:middle;width: 2px;" rowspan="2">No</th>
    <th style="vertical-align:middle;width: 200px;" rowspan="2">Mata Pelajaran</th>
    <th colspan="4"  class="text-center">Pengetahuan</th>
	<th colspan="4"  class="text-center">Keterampilan</th>
  </tr>
  <tr>
    <th  style="width:10px;" class="text-center">KKM</th>
	<th  style="width:10px;" class="text-center">Angka</th>
	<th  style="width:10px;" class="text-center">Predikat</th>
	<th  style="width:150px;" class="text-center">Deskripsi</th>
    <th  style="width:10px;" class="text-center">KKM</th>
	<th  style="width:10px;" class="text-center">Angka</th>
	<th  style="width:10px;" class="text-center">Predikat</th>
	<th  style="width:150px;" class="text-center">Deskripsi</th>
  </tr>
  </head>

</table>