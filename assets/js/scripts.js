/*
|--------------------------------------------------------------------------
| Main javascript
|--------------------------------------------------------------------------
|
| package   crapor
| author    Kuswandi <wandinak17@gmail.com>
| copyright Copyright (c) 2018 - 2019
| since     1.0
|
| ------------------------------------------------------------------------
*/

/**
 * Menjalankan pace saat ajax request dimulai
 * 
 */
$(document).ajaxStart(function() {
  Pace.restart();
})

/**
 * ---------------------------------------------
 */
$("#sync").on('click',function(e){
  var URL = $(this).attr('href')
  e.preventDefault();
  $.ajax({
    url: URL,
    type: 'GET',     
    contentType: false,
    cache: false, 
    processData:false,
    beforeSend: function (){
      $("#loading").css('display','block');                   
    },
    success: function(data, textStatus, jqXHR){
      $("#result").html(data);
      $("#loading").css('display','none');
      var enc = JSON.parse(data);
      alert('Total '+enc.jumlah+ ' siswa');
      window.location.href="siswa";
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert("Error");
    }         
  });
  
});    


/**
 * ---------------------------------------------
 */
$("#delet").on('click',function(e) {
  e.preventDefault();
if(confirm('Seluruh data siswa akan dihapus?')) {
  if(confirm('Yakin sekali lagi?')) {

    var URL = $(this).attr('href')
    $.ajax({
      url: URL,
      type: 'GET',     
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function (){
        $("#loading").css('display','block');                   
      },
      success: function(data, textStatus, jqXHR){
        $("#result").html(data);
        $("#loading").css('display','none');
        window.location.href="siswa";
      },
      error: function(jqXHR, textStatus, errorThrown){
      }         
    });
  }
}

}); 

/** 
 * Instantiate select2 dan datatable
 * 
 * --------------------------------------------------------------
 */ 
$(document).ready(function() {
  $('#table').DataTable({ 
		"bLengthChange": false, 
		"bSort": false,
		"oLanguage": {
			"oPaginate": {
				"sNext": "Selanjutnya",
				"sPrevious": "Sebelumnya",
			},
			"sInfo": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
			"sSearch": "Cari:",
			"sEmptyTable": "Tidak ada data untuk ditampilkan",
			"sInfoEmpty": "Menampilkan 0 sampai 0 dari total 0 data",
			"sLengthMenu": "_MENU_ entri",
		}
	});
  $( ".select2" ).select2({
    theme: 'bootstrap4',
  });
  
})


/**
 * Triger changed
 * 
 * --------------------------------------------------------------
 */ 
$('#jurusan').change(function(){
  $("#kelas").val('');
  $("#rombel").val(''); 
  $("#mapel").val('');
  $("#kelas").trigger('change.select2');
  $("#rombel").trigger('change.select2');
  $("#mapel").trigger('change.select2');
})

$('#kelas').change(function(){
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  $.ajax({
    url: $('#base_url').val()+'ajax/get_rombel',
    type: 'post',
    data: $("form").serialize(),
    success: function(response){
      $('.simpan').hide();
      $('#result').html('');
      $('table.table').addClass("jarak1");
      var data = $.parseJSON(response);
      $('#rombel').html('<option value="">&#10147; Pilih kelas</option>');
      if($.isEmptyObject(data.result)){
      } else {
        $.each(data.result, function (i, item) {
          $('#rombel').append($('<option>', { 
            value: item.value,
            text : item.text
          }));
        }); 
      }
    }
  });
});


/**
 * ---------------------------------------------
 */
$('#rombel').change(function(){
  var get = '';
  var nama_kur = '';
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  var query = $('#query').val();
  if(query == 'rapor'){
    get = 'rapor';
  } else if(query == 'legger'){
    get = 'legger';
  } else if(query == 'deskripsi_antar_mapel'){
    get = 'deskripsi_antar_mapel';
  } else if(query == 'absensi'){
    get = 'absensi';
  } else if(query == 'nama_kur_kurikulum'){
    get = 'kurikulum';
  } else {
    get = 'mapel';
  } 
  $.ajax({
    url: $('#base_url').val()+'ajax/get_'+get,
    type: 'post',
    data: $("form").serialize(),
    success: function(response){ 
      result = checkJSON(response);
      if(result == true){ 
        var data = $.parseJSON(response);
        $('#mapel').html('<option value="">&#10147; Pilih mata pelajaran</option>');
        if($.isEmptyObject(data.mapel)){
        } else {
          $.each(data.mapel, function (i, item) {
            $('#mapel').append($('<option>', { 
              value: item.value,
              text : item.text
            }));
          });
        }
      } else {
        $('.simpan').show();
        $('#result').html(response);
        $('#result_alt').html(response);
      }
    }
  });
});



/**
 * Check type of response
 * 
 * --------------------------------------------------------------
 */ 
var checkJSON = function(m) {
  if (typeof m == 'object') { 
    try{ m = JSON.stringify(m); 
    } catch(err) { 
      return false; 
    }
  }
  if (typeof m == 'string') {
    try{ m = JSON.parse(m); 
    } catch (err) {
      return false;
    }
  }
  if (typeof m != 'object') { 
    return false;
  }
  return true;
};


/**
 * Kompetensi dasar submit
 * 
 * --------------------------------------------------------------
 */ 
$('#myform').submit(function(e) {
  e.preventDefault();

  $.ajax({
    url: $('#base_url').val()+'kompetensi_dasar/store',
    type: 'post',
    data: $("form").serialize(),
    success: function(response){
      var view = $.parseJSON(response);
      $.notify({
        icon: 'fas fa-fw fa-clipboard-check',
        message: view.text,
      },{
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutUp'
        },
        type: view.type,
        delay: 500, 
      });
      
      $("#kelas").val('');
      $("#rombel").val(''); 
      $("#mapel").val('');
      $("#kd_uraian").val('');
      $("#kd_id").val('');
      $("#kelas").trigger('change.select2');
      $("#rombel").trigger('change.select2');
      $("#mapel").trigger('change.select2');

    }
  });
})
/**
 * Kompetensi dasar submit
 * 
 * --------------------------------------------------------------
 */ 
$('#myform2').submit(function(e) {
  e.preventDefault();

  $.ajax({
    url: $('#base_url').val(),
    type: 'post',
    data: $("form").serialize(),
    success: function(response){
      var view = $.parseJSON(response);
      $.notify({
        icon: 'fas fa-fw fa-clipboard-check',
        message: view.text,
      },{
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutUp'
        },
        type: view.type,
        delay: 500, 
      });
      
      $("#kelas").val('');
      $("#rombel").val(''); 
      $("#mapel").val('');
      $("#kd_uraian").val('');
      $("#kd_id").val('');
      $("#kelas").trigger('change.select2');
      $("#rombel").trigger('change.select2');
      $("#mapel").trigger('change.select2');

    }
  });
})
/**
 * Kompetensi dasar submit
 * 
 * --------------------------------------------------------------
 */ 
$('#formEditKd').submit(function(e) {
  e.preventDefault();
  var id_edited = $('#id_edited').val();
  $.ajax({
    url: $('#base_url').val()+'kompetensi_dasar/update/'+id_edited,
    type: 'post',
    data: $("form").serialize(),
    success: function(response){
      var view = $.parseJSON(response);
      $.notify({
        icon: 'fas fa-fw fa-clipboard-check',
        message: view.text,
      },{
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutUp'
        },
        type: view.type,
        delay: 500, 
      });
    }
  });
})

/**
 * Sisw changed
 * 
 * --------------------------------------------------------------
 */ 
$('#siswa').change(function(){
  var query = $('#query').val();
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  $('#result').html('');
  $('.simpan').hide();
  $('.cancel').hide();
  $('#rerata').hide();
  $.ajax({
    url: $('#base_url').val()+'asesmen/get_'+query,
    type: 'post',
    data: $('form').serialize(),
    success: function(response){
      $('.simpan').show();
      $('.cancel').hide();
      $('#form').fadeOut();
      $('#result').html(response);
      $('table.table').addClass("jarak1");
      $('.add').show();
      $('#rerata').show();
    }
  });

});
/**
 * ekskul changed
 * 
 * --------------------------------------------------------------
 */
$('#ekskul').change(function(){
  var query = $('#query').val();
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  $.ajax({
    url: $('#base_url').val()+'/get_'+query,
    type: 'post',
    data: $('form').serialize(),
    success: function(response){
      $('.simpan').show();
      $('.cancel').hide();
      $('#form').fadeOut();
      $('#result').html(response);
      $('table.table').addClass("jarak1");
      $('.add').show();
      $('#rerata').show();
    }
  });
});
/**
 * mapel changed
 * 
 * --------------------------------------------------------------
 */

$('#mapel').change(function(){
	var ini = $(this).val();
	if(ini == ''){
		return false;
	}
	var query = $('#query').val();
  var url_get = $('#base_url').val()+'ajax/get_';
	if(query == 'analisis_penilaian'){
		query = 'rencana_id';
	}
	if(query == 'analisis_kompetensi'){
		query = 'all_kd';
	} 
	if(query == 'sikap'){
		query = 'undefined';
	}
	
	$.ajax({
		url: url_get+query,
		type: 'post',
		data: $("form").serialize(),
		success(response){
			$('#kompetensi').html('<option value="">&#10147; Pilih kompetensi penilaian </option>');
			$('#penilaians').html('<option value="">&#10147; Pilih penilaian </option>');
			$('#kd').html('<option value="">&#10147; Pilih KD </option>');
			result = checkJSON(response);
			if(result == true){
				var data = $.parseJSON(response);
				if($.isEmptyObject(data.result)){
				} else {
					$.each(data.result, function (i, item) {
						$('#siswa').append($('<option>', { 
							value: item.value,
							text : item.text,
							}));
						$('#kompetensi').append($('<option>', { 
							value: item.value,
							text : item.text,
							}));
						$('#penilaians').append($('<option>', { 
							value: item.value,
							text : item.text,
							}));
						$('#kd').append($('<option>', { 
							value: item.value,
							text : item.text,
							})); 
					});
				}
			} else {		
				$('.simpan').show();
				$('.cancel').hide();
				$('#form').fadeOut();
				var test =$('#result');
				if(test.is('input')){
					$('#result').val(response);
				} else {
					$('#result').html(response);
				}
				$('table.table').addClass("jarak1");
				$('.add').show();
			}
		}
	});
});



$('#penilaians').change(function(){
  var query = $('#query_2').val();
  if(typeof query == 'undefined'){
    var query = $('#query').val();
  }
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  $('#result').html('');
  $('.simpan').hide();
  $('.cancel').hide();
  $('#rerata').hide();
  $('#rerata_remedial').hide();
  $.ajax({
    url: $('#base_url').val()+'asesmen/get_'+query,
    type: 'post',
    data: $('form').serialize(),
    success: function(response){
      $('#rerata_remedial').show();
      result = checkJSON(response);
      if(result == true){
        $('#kd').html('<option value="">&#10147 Pilih KD </option>');
        var data = $.parseJSON(response);
        if($.isEmptyObject(data.result)){
        } else {
          $.each(data.result, function (i, item) {
            $('#kd').append($('<option>', { 
              value: item.value, 
              text : item.text,
              }));
          });
        }
      } else {
        $('.simpan').hide();
        $('.cancel').hide();
        $('#form').fadeOut();
        $('#result').html(response);
        $('table.table').addClass("jarak1");
        $('.add').show();
        $('#rerata').show();
      }
    }
  });
});

$('#rerata').click(function(){
  var form_data = $('form').serialize();
  $.ajax({
    url: $('#base_url').val()+'penilaian/get_rerata',
    type: 'post',
    data: form_data,
    success: function(response){
      var data = $.parseJSON(response);
      $('.simpan').show();
      $('#rumus').html(data.rumus);
      if($.isEmptyObject(data.rerata)){
      } else { 
        $.each(data.rerata, function (i, item) {
          $('#rerata_'+i).val(item.value);
          $('#rerata_jadi_'+i).val(item.rerata_jadi);
          $('#rerata_text_'+i).html(item.rerata_text);
        });
      }
    }
  });
});
$('#rerata_remedial').click(function(){
  $('form').submit();
});

$('#kompetensi').change(function(){
  var ini = $(this).val();
  if(ini == ''){
    return false;
  }
  var query = $('#query').val();
  if(query == 'analisis_penilaian'){
    query = 'rencana_penilaian';
  }
  $.ajax({ 
    url: $('#base_url').val()+'ajax/get_'+query,
    type: 'post',
    data: $("form").serialize(),
    success: function(response){
      $('#penilaians').html('<option value="">&#10147 Pilih penilaian</option>');
      result = checkJSON(response);
      if(result == true){
        var data = $.parseJSON(response);
        if($.isEmptyObject(data.result)){
        } else {
          $.each(data.result, function (i, item) {
            $('#siswa').append($('<option>', { 
              value: item.value,
              text : item.text,
              }));
            $('#penilaians').append($('<option>', { 
              value: item.value,
              text : item.text,
              }));
          });
        }
      } else {		
        $('.simpan').show();
        $('.cancel').hide();
        $('#form').fadeOut();
        var test =$('#result');
        if(test.is('input')){
          $('#result').val(response);
        } else {
          $('#result').html(response);
        }
        $('table.table').addClass("jarak1");
        $('.add').show();
      }
    }
  });
});

$('#ajarans').change(function(){
  $("#kelas").val('');
  $("#rombel").val('');
  $("#mapel").val('');
  $("#kelas").trigger('change.select2');
  $("#rombel").trigger('change.select2');
  $("#mapel").trigger('change.select2');
});