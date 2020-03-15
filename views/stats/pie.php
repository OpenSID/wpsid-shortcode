<?php
$this->opensid->register_script( 'js/highcharts/highcharts' );
$this->opensid->register_script( 'js/highcharts/highcharts-more' );
$this->opensid->register_script( 'js/highcharts/exporting' );

$chart_data = [];
foreach ( $stat as $data ) {
    if ( $data['nama'] && $data['jumlah'] !== "-" AND $data['nama'] !== "TOTAL" ) {
      $chart_data[] = [$data['nama'], (int)$data['jumlah']];
    }
}
$chart_data = json_encode($chart_data, 320);
?>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', (e) => {
		new Highcharts.Chart({
					chart:{
						renderTo:'container-pie'
					},
					title:0,
					plotOptions:{
						pie:{
							allowPointSelect:true,
							cursor:'pointer',
							showInLegend:true
						}
					},
					series:[
						{
							type:'pie',
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
			<div id="container-pie"></div>
			<div id="contentpane">
				<div class="ui-layout-north panel top"></div>
			</div>
		</div>
	</div>
