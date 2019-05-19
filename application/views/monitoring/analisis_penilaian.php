<?php
$rencana = $this->db->get_where('rencana',['id' => $rencana_id])->row();
$rencana_penilaian = $this->db->get_where('rencana_penilaian',[
	'rencana_id'			=> $rencana_id,
	'nama_penilaian'		=> $nama_penilaian
])->result();
if($rencana_penilaian){
	foreach($rencana_penilaian as $rp){
		$nama_penilaian = $rp->nama_penilaian;
		$nilais[] = $this->db->get_where('nilai',['rencana_penilaian_id'	=> $rp->id])->result();
	}
	foreach($nilais as $nilai){
		foreach($nilai as $n){
			$nilai_value[$n->data_siswa_nis] = $n->rerata;
		} 
	}
}
if(!isset($nilai_value)){
	$nilai_value = array();
}
?>


<div class="card shadow mb-4">
	<div class="card-header py-3">
		Sebaran Hasil Penilaian
	</div>

	<div class="card-body">
		<div class="col-md-8">
			<table class="table table-bordered">
				<tr>
					<td width="40%">Kelas</td>
					<td class="text-center" width="2%">:</td>
					<td width="58%"><?php echo get_nama_kelas($kelas_id); ?></td>
				</tr>
				<tr>
					<td>Mata Pelajaran</td>
					<td class="text-center">:</td>
					<td><?php echo get_nama_mapel($ajaran_id, $kelas_id, $mapel_id); ?></td>
				</tr>
				<tr>
					<td>Penilaian</td>
					<td class="text-center">:</td>
					<td><?php echo $nama_penilaian; ?></td>
				</tr>
				<tr>
					<td>KKM</td>
					<td class="text-center">:</td>
					<td><?php echo get_kkm($ajaran_id, $kelas_id, $mapel_id); ?></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="col-sm-9">
		<div id="bar-chart" style="height: 300px;"></div>
	</div>

	<div class="col-sm-2">
		<table class="table table-bordered table-hover">
			<tr>
				<td width="50%" class="text-center"><a class="tooltip-left" href="javascript:void(0)" title="<?php echo predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'b') + 1 .'-'.predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'a'); ?>">A</a></td>
				<td width="50%" class="text-center">
					<?php echo sebaran_tooltip($nilai_value,predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'b'),predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'a'),'left'); ?>
				</td>
			</tr>
			<tr>
				<td class="text-center"><a class="tooltip-left" href="javascript:void(0)" title="<?php echo predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'c') + 1 .'-'.predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'b'); ?>">B</a></td>
				<td class="text-center">
					<?php echo sebaran_tooltip($nilai_value,predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'c'),predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'b'),'left'); ?>
				</td>
			</tr>
			<tr>
				<td class="text-center"><a class="tooltip-left" href="javascript:void(0)" title="<?php echo get_kkm($ajaran_id, $kelas_id, $mapel_id).'-'.predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'c'); ?>">C</a></td>
				<td class="text-center">
					<?php echo sebaran_tooltip($nilai_value,get_kkm($ajaran_id, $kelas_id, $mapel_id),predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'c'),'left'); ?>
				</td>
			</tr>
			<tr>
				<td class="text-center"><a class="tooltip-left" href="javascript:void(0)" title="<?php echo 0 .'-'.predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'d'); ?>">D</a></td>
				<td class="text-center"><?php echo sebaran_tooltip($nilai_value,0,predikat(get_kkm($ajaran_id, $kelas_id, $mapel_id),'d'),'left'); ?></td>
			</tr>
		</table> 
	</div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>assets/css/tooltip-viewport.css">
<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.resize.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.pie.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.categories.min.js"></script>
<script src="<?= base_url()?>assets/js/tooltip-viewport.js"></script>


<script>
$(function () {
	/*
	* BAR CHART
	* --------
	*/
	var a1 = [
        [0, <?php echo count(sebaran($nilai_value,100,95)); ?>],
		[1, <?php echo count(sebaran($nilai_value,94,90)); ?>],
		[2, <?php echo count(sebaran($nilai_value,89,85)); ?>],
		[3, <?php echo count(sebaran($nilai_value,84,80)); ?>],
		[4, <?php echo count(sebaran($nilai_value,79,75)); ?>],
		[5, <?php echo count(sebaran($nilai_value,74,70)); ?>],
		[6, <?php echo count(sebaran($nilai_value,69,65)); ?>],
		[7, <?php echo count(sebaran($nilai_value,64,60)); ?>],
		[8, <?php echo count(sebaran($nilai_value,59,55)); ?>],
		[9, <?php echo count(sebaran($nilai_value,54,50)); ?>],
		[10, <?php echo count(sebaran($nilai_value,49,0)); ?>]

    ];
	var bar_data = [{
        label: "Sebaran Siswa",
        data: a1,
		color: "#3c8dbc"
    }];
	$.plot("#bar-chart", bar_data, {
		series: {
			bars: {
				show: true,
				barWidth: 0.5,
				align: "center"
				}
		},
		xaxis: {
			mode: "categories",
			tickLength: 0,
			ticks: [
                [0, "100-95"],
                [1, "94-90"],
                [2, "89-85"],
                [3, "84-80"],
				[4, "79-75"],
				[5, "74-70"],
				[6, "69-65"],
				[7, "64-60"],
				[8, "59-55"],
				[9, "54-50"],
				[10, "49-0"],
            ]
		},
		yaxis: {
			tickDecimals:0
		},
		grid: {
            hoverable: true,
            clickable: true,
			borderWidth: 1,
			borderColor: "#f3f3f3",
			tickColor: "#f3f3f3"
        },
		valueLabels: {
            show: true
        },
		legend: {
        show: true,
        noColumns: 0,
		margin: [10,-10]
    	},
	});
                /* END BAR CHART */
});
var previousPoint = null,
    previousLabel = null;

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 30,
        border: '2px solid ' + color,
        padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}


$("#bar-chart").on("plothover", function (event, pos, item) {
    if (item) {
        if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
            previousPoint = item.dataIndex;
            previousLabel = item.series.label;
            $("#tooltip").remove();

            var x = item.datapoint[0];
            var y = item.datapoint[1];
            var color = item.series.color;

            //console.log(item.series.xaxis.ticks[x].label);               

            showTooltip(item.pageX,
            item.pageY,
            color,
                "<strong>" + item.series.label + "</strong><br>Rentang nilai " + item.series.xaxis.ticks[x].label + " : <strong>" + y + " siswa</strong>");
        }
    } else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});
</script>