<div class="container-fluid">
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
      <input type="hidden" id="rombel_id" value="<?= $kelas_id; ?>" />


      <script>
      $(function(){
        var rombel_id = $('#rombel_id').val();
        $( "#sortable1, #sortable2" ).sortable({
          placeholder: "ui-state-highlight",
          connectWith: ".connectedSortable"
        }).disableSelection();

        $( "#sortable2" ).on( "sortreceive", function( event, ui ) {
        	var siswa_nis = ui.item.find('input').val();
        	console.log('receive');
        	$.ajax({
        		url: '<?= site_url('kelas/simpan_anggota');?>',
        		type: 'post',
        		data: {rombel_id:rombel_id,siswa_nis:siswa_nis},
        		success: function(response){
        			var view = $.parseJSON(response);
        			noty({
        				text        : view.text, 
        				type        : view.type,
        				timeout		: 1500,
        				dismissQueue: true,
        				animation: {
        					open: {height: 'toggle'},
        					close: {height: 'toggle'}, 
        					easing: 'swing', 
        					speed: 500 
                },
                
        			});
        		}
        	});
        } );
        $( "#sortable2" ).on( "sortremove", function( event, ui ) {
        	var siswa_nis = ui.item.find('input').val();
        	console.log('remove');
        	$.ajax({
        		url: '<?= site_url('kelas/hapus_anggota');?>',
        		type: 'post',
        		data: {rombel_id:rombel_id,siswa_nis:siswa_nis},
        		success: function(response){
        			var view = $.parseJSON(response);
        			noty({
        				text        : view.text,
        				type        : view.type,
        				timeout		: 1500,
        				dismissQueue: true,
        				animation: {
        					open: {height: 'toggle'},
        					close: {height: 'toggle'}, 
        					easing: 'swing', 
        					speed: 500 
        				}
        			});
        		}
        	});
        } );
      });
      </script>
  

    <div class="row">
      <div class="col-md-6">
        <ul id="sortable1" class="connectedSortable">
        <?php foreach($siswas as $f){ ?>
          <li class="ui-state-default">
          <input type="hidden" name="siswa" value="<?= $f->nis; ?>" />
          <?= $f->nama; ?>
          </li> 
        <?php } ?>
        </ul> 
      </div>

      <div class="col-md-6">
        <form id="anggota">
        <ul id="sortable2" class="connectedSortable">
          <?php foreach($anggota as $a){
          $siswa = $this->db->get_where('siswa',['nis' => $a->nis])->row();
          ?>
          <li class="ui-state-highlight">
            <input type="hidden" name="siswa" value="<?= isset($siswa->nis) ? $siswa->nis : ''; ?>" />
            <?= isset($siswa->nama) ? $siswa->nama : ''; ?>
          </li>
          <?php } ?>
        </ul>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery.noty.packaged.js"></script>

  </div>
</div>