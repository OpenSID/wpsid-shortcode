<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Data_statistik_Shortcode extends OpenSID_Shortcode {
	public function __construct() {
		parent::__construct();
	}
	public function setup($action, array $data) {
		parent::setup( $action, $data );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$statistik = OpenSID::load_ci_model( 'Laporan_Penduduk' );
				$data['jenis_laporan'] = $statistik->jenis_laporan( $data['statistik'] );
				$data['heading'] = $statistik->judul_statistik( $data['statistik'] );
				$data['stat'] = $statistik->list_data( $data['statistik'] );
				break;
			case 'sidcri':
				$data['__model_class_name__'] = 'First_Penduduk_M';
				$data['__model_class_file__'] = OPENSID_APPPATH . '/donjo-app/models/first_penduduk_m.php';
				$statistik = OpenSID::load_ci_model( 'First_Penduduk_M', $data );
				switch($data['statistik']) {
					case "pendidikan-dalam-kk":
						$data['heading'] = "Pendidikan";
						break;
					case "pekerjaan":
						$data['heading'] = "Pekerjaan";
						break;
					case "status-perkawinan":
						$data['heading'] = "Status Perkawinan";
						break;
					case "agama":
						$data['heading'] = "Agama";
						break;
					case "jenis-kelamin":
						$data['heading'] = "Jenis Kelamin";
						break;
					case "golongan-darah":
						$data['heading'] = "Golongan Darah";
						break;
					case "kelompok-umur":
						$data['heading'] = "Kelompok Umur";
						break;
					case "warga-negara":
						$data['heading'] = "Warga Negara";
						break;
					case "pendidikan-ditempuh":
						$data['heading'] = "Pendidikan Sedang Ditempuh";
						break;
					default:
						$data['heading'] = "TIDAK DIKENALI";
						break;
				}
				$data['jenis_laporan'] = $data['statistik'];
				$data['heading'] = $data['heading'];
				$data['stat'] = $statistik->list_data( $data['statistik'] );
				break;
		}
		ob_start();
		if ( $data['statistik'] == null ) {
			echo 'Anda menggunakan ' . OPENSID_APP_TYPE . ', shortcode ini hanya dapat digunakan bersama OpenSID.';
		} else {
			echo self::render( $data );
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	private static function render($data) {
		$data['type'] = ( isset( $data['type'] ) ) ? $data['type'] : '';
		switch($data['type']) {
			case 'grafik':
				self::_js();
				self::_grafik( $data );
				break;
			case 'pie':
				self::_js();
				self::_pie( $data );
				break;
			case 'tabel':
				self::_tabel( $data );
				break;
			default:
				self::_js();
				self::_pie( $data );
				self::_grafik( $data );
				self::_tabel( $data );
				break;
		}
	}
	private static function _tabel($data) {
		extract( $data );
		?>
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Tabel Data Demografi Berdasar <?php echo $heading; ?></h3>
		</div>
		<div class="box-body">
			<table class="table table-striped">
				<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">Kelompok</th>
					<th colspan="2">Jumlah</th>
					<?php if ( $jenis_laporan == 'penduduk' ) { ?>
					<th colspan="2">Laki-laki</th>
					<th colspan="2">Perempuan</th>
					<?php } ?>
				</tr>
				<tr>
					<th style='text-align:right'>n</th>
					<th style='text-align:right'>%</th>
					<?php if ( $jenis_laporan == 'penduduk' ) { ?>
					<th style='text-align:right'>n</th>
					<th style='text-align:right'>%</th>
					<th style='text-align:right'>n</th>
					<th style='text-align:right'>%</th>
					<?php } ?>
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 0; $l = 0; $p = 0;
					foreach ( $stat as $data ) {
						?>
					<tr>
						<td class="angka"><?php echo esc_attr( $data['no'] ); ?></td>
						<td><?php echo esc_attr( $data['nama'] ); ?></td>
						<td class="angka"><?php echo esc_attr( $data['jumlah'] ); ?></td>
						<td class="angka"><?php echo esc_attr( $data['persen'] ); ?></td>
						<?php if ( $jenis_laporan == 'penduduk' ) { ?>
						<td class="angka"><?php echo esc_attr( $data['laki'] ); ?></td>
						<td class="angka"><?php echo esc_attr( $data['persen1'] ); ?></td>
						<td class="angka"><?php echo esc_attr( $data['perempuan'] ); ?></td>
						<td class="angka"><?php echo esc_attr( $data['persen2'] ); ?></td>
						<?php } ?>
					</tr>
						<?php
						$i = $i + $data['jumlah'];
						$l = $l + $data['laki'];
						$p = $p + $data['perempuan'];
					} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	}
	private static function _pie($data) {
		extract( $data );
		?>
	<script type="text/javascript">
		jQuery(function () {
			var chart;
			jQuery(document).ready(function () {
				chart = new Highcharts.Chart({
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
			<div id="container-pie"></div>
			<div id="contentpane">
				<div class="ui-layout-north panel top"></div>
			</div>
		</div>
	</div>
	<?php
	}
	private static function _grafik($data) {
		extract( $data );
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
	<?php
	}
	private static function _js() {
		$frontend_page = new OpenSID_Frontend_Page;
		$frontend_page->enqueue_script_opensid( 'js/highcharts/highcharts' );
		$frontend_page->enqueue_script_opensid( 'js/highcharts/highcharts-more' );
		$frontend_page->enqueue_script_opensid( 'js/highcharts/exporting' );
	}
} // class OpenSID_Data_statistik_Shortcode
