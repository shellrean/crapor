<?php

$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();
$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
$ajaran = $this->db->get_where('ajaran',['id' => $ajaran_id])->row();
$kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();

$catatan = $this->db->get_where('catatan',[
  'ajaran_id'     => $ajaran_id,
  'kelas_id'      => $kelas_id,
  'siswa_nis'     => $s->nis
])->row();
$uraian_deskripsi = isset($catatan->uraian_deskripsi) ? $catatan->uraian_deskripsi : '';

?>
<div class="strong">B.&nbsp;&nbsp;Catatan Akademik</div>
<table width="100%" border="1">
  <tr>
    <td style="padding:10px 10px 60px 10px;"><?= $uraian_deskripsi; ?></td>
  </tr>
</table>

