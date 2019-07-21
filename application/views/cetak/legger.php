<?php 
$kelas = $this->db->get_where('kelas',['id' => $kelas_id])->row();
?>
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header py-3">
          Ledger Cetak
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover " id="table" width="100%" cellspacing="0">
                	<tr>
                		<td>
                			<p><a href="<?php echo site_url('cetak/legger/'.$ajaran_id.'/'.$kelas_id.'/1'); ?>" target="_blank" class="btn btn-sm btn-success" title="Download Legger Pengetahuan Kelas <?php echo $kelas->nama; ?>">
							<i class="fas fa-download"></i></a> Download Legger Pengetahuan Kelas <?php echo $kelas->nama; ?></p>
                		</td>
                		<td>
                			<p><a href="<?php echo site_url('cetak/legger/'.$ajaran_id.'/'.$kelas_id.'/2'); ?>" target="_blank" class="btn btn-sm btn-success" title="Download Legger Keterampilan Kelas <?php echo $kelas->nama; ?>">
							<i class="fas fa-download"></i></a> Download Legger Keterampilan Kelas <?php echo $kelas->nama; ?></p>
                		</td>
                	</tr>
                </table>
            </div>
        </div>
    </div>
</div> 