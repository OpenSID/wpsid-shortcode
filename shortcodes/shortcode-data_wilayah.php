<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Data_wilayah_Shortcode extends OpenSID_Shortcode {
	public function setup($action, array $data) {
		parent::setup( $action, $data );
		$data['heading'] = "Populasi Per Wilayah";
		$data['total'] = OpenSID::load_ci_model( 'Wilayah' )->total();
		$data['main'] = OpenSID::load_ci_model( 'Wilayah' )->list_data();
		ob_start();
		echo self::render( $data );
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	private static function render($data) {
		extract( $data );
		?>
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Data Demografi Berdasar <?php echo esc_attr( $heading ) ?></h3>
		</div>
		<div class="box-body">
			<?php if ( count( $main ) > 0 ) { ?>
			<table class="table table-striped">
				<thead>
				<tr>
					<th>No</th>
					<th>Nama Dusun</th>
					<th>Nama Kepala Dusun</th>
					<th>Jumlah RT</th>
					<th>Jumlah KK</th>
					<th>Jiwa</th>
					<th>Lk</th>
					<th>Pr</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ( $main as $data ) { ?>
				<tr>
					<td><?php echo esc_attr( $data['no'] )?></td>
					<td><?php echo esc_attr( strtoupper( $data['dusun'] ) )?></td>
					<td><?php echo esc_attr( strtoupper( $data['nama_kadus'] ) )?></td>
					<td class="angka"><?php echo esc_attr( $data['jumlah_rt'] )?></td>
					<td class="angka"><?php echo esc_attr( $data['jumlah_kk'] )?></td>
					<td class="angka"><?php echo esc_attr( $data['jumlah_warga'] )?></td>
					<td class="angka"><?php echo esc_attr( $data['jumlah_warga_l'] )?></td>
					<td class="angka"><?php echo esc_attr( $data['jumlah_warga_p'] )?></td>
				</tr>
					<?php
				} ?>
				</tbody>
				<tfoot>
				<tr>
					<th colspan="3" class="angka">TOTAL</th>
					<th class="angka"><?php echo esc_attr( $total['total_rt'] )?></th>
					<th class="angka"><?php echo esc_attr( $total['total_kk'] )?></th>
					<th class="angka"><?php echo esc_attr( $total['total_warga'] )?></th>
					<th class="angka"><?php echo esc_attr( $total['total_warga_l'] )?></th>
					<th class="angka"><?php echo esc_attr( $total['total_warga_p'] )?></th>
				</tr>
				</tfoot>
			</table>
			<?php
		} else {
			?>
			<div class="">Belum ada data</div>
			<?php
		} ?>
		</div>
	</div>
	<?php
	}
} // class OpenSID_Data_wilayah_Shortcode
