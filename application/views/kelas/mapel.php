<form id="pembelajaran">
  <input type="hidden" name="rombel_id" value="<?= $data_kelas->id; ?>" />
	<input type="hidden" name="keahlian_id" id="keahlian_id" value="<?= $data_kelas->jurusan_id; ?>" />
	<input type="hidden" name="query" id="query" value="kurikulum" />
<?php
	$tingkat = $data_kelas->tingkat;
  $kurikulum_id = $data_kelas->jurusan_id;
  
	if($tingkat == 10){
		$query_kelas = 'kelas_X';
	} elseif($tingkat == 11){
		$query_kelas = 'kelas_XI';
	} elseif($tingkat == 12){
		$query_kelas = 'kelas_XII';
	} elseif($tingkat == 13){ 
		$query_kelas = 'kelas_XIII';
  }
  
  $all_mapel = $this->db->get_where('data_mapel',['kurikulum_id' => $kurikulum_id, $query_kelas => 1])->result();
?>

<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('kelas') ?>" class="btn btn-sm btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-angle-double-left"></i> 
            </span>
            <span class="text">Kembali</span>
          </a>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="pembelajaran">
              <thead>
                <th class="text-center" width="5%">No</th>
                <th width="50%">Mata pelajaran</th>
                <th width="45%">Guru mata pelajaran</th>
              </thead>
              <tbody id="editable">
                
              <?php $i=1;
                if($all_mapel){
                foreach($all_mapel as $mapel){
                  $query = 'kurikulum';
              ?>

              <tr>
                <td>
                  <div class="text-center"><?= $i; ?></div>
                </td>
                <td>
                  <?= get_nama_mapel($ajaran_id,$data_kelas->id,$mapel->id_mapel); ?>
                  <input type="hidden" name="mapel" value="<?= $mapel->id_mapel ?>">
                </td>
                <td>
                <input type="hidden" class="guru" name="guru" value="<?= get_guru_mapel($ajaran_id,$data_kelas->id,$mapel->id_mapel,'id') ?>">

                <a class="guru" href="javascript:void(0)" id="country" data-type="select" data-name="guru" data-value="<?= get_guru_mapel($ajaran_id,$data_kelas->id,$mapel->id_mapel,'id');?>" title="Pilih Guru"></a>
                

                </td>
              </tr>
              <?php $i++;}
              } else { ?>
                <tr class="tr_a">
                  <td colspan="3">Mata Pelajaran belum tersedia. Silahkan tambah mata pelajaran di data master mapel</td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <a href="javascript:void(0)" class="simpan_pembelajaran btn btn-sm btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-save"></i>
            </span>
            <span class="text">Simpan</span>
          </a>
        </div>
    </div>
</div> 
</form>

<script src="<?= base_url('assets') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap-editable/css/bootstrap-editable.css">

<script src="<?= base_url() ?>assets/vendor/bootstrap-editable/js/jquery.mockjax.js"></script>

<script src="<?= base_url() ?>assets/vendor/bootstrap-editable/js/bootstrap-editable.js"></script>



<script src="<?= base_url(); ?>assets/js/jquery.noty.packaged.js"></script>
<script>

$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
$(function(){
  $.fn.editable.defaults.url = '<?= site_url(); ?>';
  
	$.get('<?= base_url('user/guru'); ?>', function( response ) {
		var data = $.parseJSON(response);
		var guru = [];
		$.each(data, function(i, item) {
        	guru.push({value: item.id, text: item.text});
    	});
		$('tbody#editable tr td a.nama_mapel').editable({
				type: 'text', 
				pk: 1,
				name: 'nama_mapel',
				title: 'Edit Nama Mapel',
				success: function(response, newValue) {
					$(this).prev().val(newValue);
				}
      });
		$('tbody#editable tr td a.guru').editable({
	    source: guru,
      emptytext : 'Pilih Guru',
		  success: function(response,newValue) {
        $(this).prev().val(newValue);
    	}
	  });   
  });
  
	$('a.simpan_pembelajaran').click(function(){
    var data = $("form#pembelajaran").serializeObject();

    var result = $.parseJSON(JSON.stringify(data));

		$.each(result.guru, function (i, item) {
			$.ajax({
				url: '<?= base_url('kelas/simpan_pembelajaran'); ?>',
				type: 'post',
				data: {keahlian_id:result.keahlian_id, rombel_id:result.rombel_id, query:result.query, guru_id:item, mapel_id:result.mapel[i]},
				success(response){
					var view = $.parseJSON(response);
					noty({
						text        : view.text,
						type        : view.type,
						timeout		: 1500,
						dismissQueue: true,
						layout      : 'topLeft',
						animation: {
							open: {height: 'toggle'},
							close: {height: 'toggle'}, 
							easing: 'swing', 
							speed: 500 
						}
          });
          
				}
			});
		});
	});
});
</script>
