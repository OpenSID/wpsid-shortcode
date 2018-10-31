	<div class="artikel">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form">
			<tr>
				<th colspan="3" class="judul" scope="col"><b>KARTU KELUARGA PENDUDUK</b></th>
			</tr>
			<tr>
				<td colspan="3" class="button" scope="col"><a href="<?php echo esc_url(add_query_arg('print', 'kartu_keluarga', $data['mandiri_page'])) ?>" target="_blank">
					<button type="button" class="btn btn-success"><i class="fa fa-print"></i> CETAK KARTU KELUARGA</button>
				</a></td>
			</tr>
			<tr>
				<th colspan="3" class="judul" scope="col"><b>BIODATA PENDUDUK</b></th>
			</tr>
			<tr>
				<td width="36%">Nama</td>
				<td width="2%">:</td>
				<td width="62%"><?php echo strtoupper(unpenetration($data['penduduk']['nama']))?></td>
			</tr>
			<tr class="shaded">
				<td>NIK</td>
				<td>:</td>
				<td><?php echo $data['penduduk']['nik']?></td>
			</tr>
			<tr>
				<td>No KK</td>
				<td>:</td>
				<td><?php echo $data['penduduk']['no_kk']?></td>
			</tr>
			<tr class="shaded">
				<td>Akta Kelahiran</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['akta_lahir'])?></td>
			</tr>
			<tr>
				<td><?php  echo ucwords($data['setting']['sebutan_dusun'])?></td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['dusun'])?></td>
			</tr>
			<tr class="shaded">
				<td>RT/RW</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['rt'])?>/<?php echo $data['penduduk']['rw']?></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['sex'])?></td>
			</tr>
			<tr class="shaded">
				<td>Tempat, Tanggal Lahir</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['tempatlahir'])?>, <?php echo strtoupper($data['penduduk']['tanggallahir'])?></td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['agama'])?></td>
			</tr>
			<tr class="shaded">
				<td>Pendidikan Dalam KK</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['pendidikan_kk'])?></td>
			</tr>
			<tr>
				<td>Pendidikan yang sedang ditempuh</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['pendidikan_sedang'])?></td>
			</tr>
			<tr class="shaded">
				<td>Pekerjaan</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['pekerjaan'])?></td>
			</tr>
			<tr>
				<td>Status Perkawinan</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['kawin'])?></td>
			</tr>
			<tr class="shaded">
				<td>Warga Negara</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['warganegara'])?></td>
			</tr>
			<tr>
				<td>Dokumen Paspor</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['dokumen_pasport'])?></td>
			</tr>
			<tr class="shaded">
				<td>Dokumen Kitas</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['dokumen_kitas'])?></td>
			</tr>
			<tr>
				<td>Alamat Sebelumnya</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['alamat_sebelumnya'])?></td>
			</tr>
			<tr class="shaded">
				<td>Alamat Sekarang</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['alamat'])?></td>
			</tr>
			<tr>
				<td>Akta Perkawinan</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['akta_perkawinan'])?></td>
			</tr>
			<tr class="shaded">
				<td>Tanggal Perkawinan</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['tanggalperkawinan'])?></td>
			</tr>
			<tr>
				<td>Akta Perceraian</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['akta_perceraian'])?></td>
			</tr>
			<tr class="shaded">
				<td>Tanggal Perceraian</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['tanggalperceraian'])?></td>
			</tr>
			<tr class="judul">
				<td><b>Data Orang Tua</b></td>
				<td>&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td>NIK Ayah</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['ayah_nik'])?></td>
			</tr>
			<tr class="shaded">
				<td>Nama Ayah</td>
				<td>:</td>
				<td><?php echo strtoupper(unpenetration($data['penduduk']['nama_ayah']))?></td>
			</tr>
			<tr>
				<td>NIK Ibu</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['ibu_nik'])?></td>
			</tr>
			<tr class="shaded">
				<td>Nama Ibu</td>
				<td>:</td>
				<td><?php echo strtoupper(unpenetration($data['penduduk']['nama_ibu']))?></td>
			</tr>
			<tr>
				<td>Cacat</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['cacat'])?></td>
			</tr>
			<tr class="shaded">
				<td>Status</td>
				<td>:</td>
				<td><?php echo strtoupper($data['penduduk']['status'])?></td>
			</tr>
			<tr>
				<td colspan="3" class="button" scope="col"><a href="<?php echo esc_url(add_query_arg('print', 'biodata', $data['mandiri_page'])) ?>" target="_blank">
					<button type="button" class="btn btn-success"><i class="fa fa-print"></i> CETAK BIODATA</button>
				</a></td>
			</tr>
		</table>
	</div>
