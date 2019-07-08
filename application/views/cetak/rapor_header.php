<?php
$s = $this->db->get_where('siswa',['nis' => $siswa_nis])->row();

$sekolah = $this->db->get('data_sekolah')->row();
$setting = $this->db->get('setting')->row();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $s->nama ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/bootstrap/bootstrap.min.css">
<style>
body{background:#FFFFFF !important; background-color:#FFFFFF;font-family:Times; font-size:12px;}
h3{font-size:14px;}
table tr td,table tr th{padding:5px;}
.strong {font-weight:bold;}
</style>
</head>
<body>