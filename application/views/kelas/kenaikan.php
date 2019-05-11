<div class="container-fluid">
		<div class="card">
      <div class="card-header">
        <a href="<?= base_url('kelas') ?>" class="btn btn-sm btn-warning btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-backward"></i>
          </span>
          <span class="text">Kembali</span>
        </a>
        <a href="#" id="select-all" class="btn btn-sm btn-info btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-check-double"></i>
          </span>
          <span class="text">Pilih semua</span>
        </a>
        <a href="#" id="deselect-all" class="btn btn-sm btn-danger btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-times-circle"></i>
          </span>
          <span class="text">Lepas semua</span>
        </a>
      </div>
      
      <div class="card-body">
        
            <select id='pilih_siswa' multiple='multiple' class="form-control">
                <?php foreach($anggota as $a){ 
                
                $siswa = $this->db->get_where('siswa',['nis' => $a->nis])->row();

                ?>
                <option value="<?php echo $siswa->nis; ?>" style="margin: 5px 0; padding: 8px 4px; border: 1px solid #eee;"><?php echo $siswa->nama; ?></option>
                <?php } 
                ?>
            </select>
            
            <select id="pilih_rombel_kenaikan" class="form-control" style="margin-top:20px;">
              <option value="">Naik ke kelas ?</option>
              <?php 
              if($data_kelas){
                foreach($data_kelas as $rombel){?>
                <option value="<?php echo $rombel->id; ?>"><?php echo $rombel->nama; ?></option>
              <?php 
                }
                
              } 
              elseif($find->tingkat == 12) { ?>
                <option value="lulus">Lulus</option>
               <?php }
              else { ?>
                <option value="">Rombongan belajar tidak ditemukan</option>
              <?php } ?>
            </select> 

      </div>

      <div class="card-footer">
        <a href="#" class="proses_kenaikan btn btn-sm btn-success btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-level-up-alt"></i>
          </span>
          <span class="text">Proses kenaikan</span>
        </a>
      </div>
    </div>
</div>


<link rel="stylesheet" href="<?= base_url(); ?>assets/css/multi-select.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
$('#pilih_siswa').multiSelect();
$('#select-all').click(function(){
  $('#pilih_siswa').multiSelect('select_all');
  return false;
});
$('#deselect-all').click(function(){
  $('#pilih_siswa').multiSelect('deselect_all');
  return false;
});
$('.proses_kenaikan').click(function(){
	var id_siswa = $('#pilih_siswa').val();
	var id_rombel = $('#pilih_rombel_kenaikan').val();
	if($.isEmptyObject(id_siswa)){
    alert('Error! Silahkan pilih siswa terlebih dahulu');
		return false;
	} 
	if(id_rombel == ''){
    alert('Error! Silahkan pilih kelas tujuan terlebih')
		return false;
	}
	$.ajax({
		url: '<?= base_url('kelas/proses_kenaikan/'); ?>',
		type: 'post',
		data: {nis_siswa:id_siswa,id_kelas:id_rombel},
		success: function(response){
      window.location.href="<?= base_url() ?>kelas";
		}
  });
})

</script>	