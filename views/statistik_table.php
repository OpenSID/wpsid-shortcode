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
