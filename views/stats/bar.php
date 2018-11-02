<?php
$this->opensid->register_script( 'js/highcharts/exporting' );
$this->opensid->register_script( 'js/highcharts/highcharts-more' );
$this->opensid->register_script( 'js/highcharts/highcharts' );
?>
<script type="text/javascript">
		jQuery(function () {
			var chart;
			jQuery(document).ready(function () {
				chart = new Highcharts.Chart({
					chart:{ renderTo:'container-bar'},
					title:0,
					xAxis:{
						categories:[
							<?php  $i = 0;foreach ( $stat as $data ) {
								$i ++; ?>
								<?php if ( $data['jumlah'] != "-" AND $data['nama'] != "TOTAL" ) {
									echo "'$i',";
								} ?>
								<?php }?>
						]
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
							data:[
								<?php  foreach ( $stat as $data ) { ?>
									<?php if ( $data['jumlah'] != "-" AND $data['nama'] != "TOTAL" ) { ?>
										['<?php echo esc_attr( $data['nama'] )?>',<?php echo esc_attr( $data['jumlah'] )?>],
										<?php } ?>
									<?php }?>
							]
						}
					]
				});
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
