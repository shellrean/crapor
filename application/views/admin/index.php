 <!-- Begin Page Content -->
<div class="container-fluid">

<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah siswa</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_siswa ?></div>
          </div>
          <div class="col-auto">
            <i class="far fa-smile-beam fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah matpel</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_mapel ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-swatchbook fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah kelas</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_kelas ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-object-group fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah pengguna</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count_user ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 md-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-header">Statistik pelajaran per mapel</div>
      <div class="card-body">
        <canvas id="pieChart" style="height:250px"></canvas>  
      </div>
    </div>
  </div>

</div>
</div>

<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script>
$(document).ready(function(){
	var PieData = [];
	$.ajax({
		url: "<?php echo site_url('ajax/get_chart');?>", 
		method: "GET",
		success: function(response) {
			var result = $.parseJSON(response);
			$.each(result.result, function (i, item) {
				PieData.push({
					value: item.value,
					color: item.color,
					highlight: item.highlight,
					label: item.label
				});
			});
			var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
			var pieChart = new Chart(pieChartCanvas);
			var pieOptions = {
				//Boolean - Whether we should show a stroke on each segment
				segmentShowStroke: true,
				//String - The colour of each segment stroke
				segmentStrokeColor: "#fff",
				//Number - The width of each segment stroke
				segmentStrokeWidth: 2,
				//Number - The percentage of the chart that we cut out of the middle
				percentageInnerCutout: 50, // This is 0 for Pie charts
				//Number - Amount of animation steps
				animationSteps: 100,
				//String - Animation easing effect
				animationEasing: "easeOutBounce", 
				//Boolean - Whether we animate the rotation of the Doughnut
				animateRotate: true,
				//Boolean - Whether we animate scaling the Doughnut from the centre
				animateScale: false,
				//Boolean - whether to make the chart responsive to window resizing
				responsive: true,
				// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
				maintainAspectRatio: true,
				//String - A legend template
				legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
			};
			//Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			pieChart.Doughnut(PieData, pieOptions);
		}
	});
});
</script>