<?php
$this->opensid->register_script( 'js/highcharts/highcharts' );
$this->opensid->register_script( 'js/highcharts/highcharts-more' );
$this->opensid->register_script( 'js/highcharts/exporting' );

$chart_data = [];
$categories = [];
foreach ( $stat as $data ) {
    if ( $data['nama'] && $data['jumlah'] !== "-" AND $data['nama'] !== "TOTAL" ) {
      $chart_data[] = [$data['nama'], (int)$data['jumlah']];
    }
}

foreach ( $stat as $i => $data ) {
  if ( $data['jumlah'] != "-" AND $data['nama'] != "TOTAL" ) {
    $categories[] = $i + 1;
  }
}

$chart_data = json_encode($chart_data, 320);
$categories = json_encode($categories, 320);
?>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', (e) => {
			new Highcharts.Chart({
					chart:{ renderTo:'container-bar'},
					title:0,
					xAxis:{
						categories: <?= $categories ?>,
					},
					plotOptions:{
						series:{
							colorByPoint:true
						},
						column:{
							pointPadding:-0.1,
							borderWidth:0
						}
					},
					legend:{
						enabled:false
					},
					series:[
						{
							type:'column',
							name:'Jumlah Populasi',
							shadow:1,
							border:1,
							data: <?= $chart_data ?>,
						}
					]
				});
  });
	</script>
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Grafik Data Demografi Berdasar <?php echo $heading; ?></h3>
			<div class="box-tools pull-right">
			</div>
		</div>
		<div class="box-body">
			<div id="container-bar"></div>
			<div id="contentpane">
				<div class="ui-layout-north panel top"></div>
			</div>
		</div>
	</div>
