<?php
defined('ABSPATH') || die('No direct script access allowed!');
class OpenSID_Layanan_Mandiri_Detail_Shortcode extends OpenSID_Shortcode {
	public function __construct() {
		parent::__construct();
	}
	public function setup($action, array $data) {
		parent::setup($action, $data);
		if( isset($_POST['mandiri']) && $_POST['mandiri'] == 'login' )
			OpenSID::load_ci_model('first')->siteman();
		if( isset($_REQUEST['mandiri']) && $_REQUEST['mandiri'] == 'logoff' )
			OpenSID::load_ci_model('first')->logout();
		if( !self::_is_logged() ) {
			echo do_shortcode('[wpsid_layanan_mandiri_widget]');
		} else {
			$options = get_option(OPENSID_OPTION_KEY);
			$data['sid_home'] = $options['sid_home'];
			$data['mandiri_page'] = get_page_link($options['mandiri_page']);
			$data['detail'] = (!empty($_REQUEST['mandiri'])) ? $_REQUEST['mandiri'] : 'profil';
			$data['setting']['sebutan_dusun'] = $this->setting->sebutan_dusun;
			switch($data['detail']) {
				default;
				case 'profil':
					$data['penduduk'] = OpenSID::load_ci_model('penduduk')->get_penduduk($_SESSION['id']);
					$data['print'] = (!empty($_REQUEST['print'])) ? $_REQUEST['print'] : false;
					break;
				case 'layanan':
					break;
				case 'lapor':
					break;
				case 'bantuan':
					$nik = $_SESSION['nik'];
					$data['daftar_bantuan'] = $this->db->select('p.*,pp.*')
									->where(array('peserta' => $nik))
									->join('program p','p.id = pp.program_id')
									->get('program_peserta pp')
									->result_array();
					break;
			}
			if(isset($_POST['submit-lapor'])){
				$outp = $this->db->insert('komentar', array(
						'komentar' => strip_tags($_POST["komentar"]),
						'owner' => strip_tags($_POST["owner"]),
						'email' => strip_tags($_POST["email"]),
						'enabled' => 2,
						'id_artikel' => '775')
				);
				$data['success'] = $outp;
			}
			ob_start();
			echo self::render($data);
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;
		}
	}
	private static function render($data) {
		if( $data['print'] ) {
			switch($data['print']) {
				case 'kartu_keluarga':
					self::_print_kartu_keluarga($data);
					break;
				case 'biodata':
					self::_print_biodata($data);
					break;
			}
		} else {
			switch($data['detail']) {
				default:
				case 'profil':
					self::_detail_profile($data);
					break;
				case 'layanan':
					self::_detail_layanan($data);
					break;
				case 'lapor':
					self::_detail_lapor($data);
					break;
				case 'bantuan':
					self::_detail_bantuan($data);
					break;
			}
		}
	}
	private static function _is_logged() {
		return ((isset($_SESSION['mandiri']) && $_SESSION['mandiri'] == 1) ? true : false);
	}
	private static function _detail_profile($data) {
		?>
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
	<?php
	}
	private static function _detail_layanan($data) {
		?>
	<div class="artikel">
		<div class="teks">
			<p>Salah satu fungsi aplikasi Sistem Informasi Desa (SID) adalah untuk mengoptimalkan pelayanan administrasi publik berbasis data. Pelayanan administrasi publik yang bisa dilakukan dengan aplikasi SID meliputi pelayanan olah data dan pelayanan olah dokumen/surat. Pelayanan olah data dapat dilakukan dengan memanfaatkan fungsi-fungsi statistik yang dapat dimanfaatkan untuk laporan dan rujukan pengambilan keputusan. Pelayanan olah dokumen bisa dilakukan dari data yang telah diolah dan/atau dari pengelolaan administrasi surat-menyurat.<br>
			</p>
			<p>Aplikasi SID menghimpun seluruh data penduduk desa, sehingga bisa digunakan untuk data dasar pembuatan surat administrasi kependudukan. Pelayanan administrasi persuratan itu dapat dikelola oleh pemerintah desa di kantor pemerintah desa masing-masing. Tata cara pemanfaatan module cetak surat aplikasi SID dalam alur pelayanan publik di kantor desa secara garis besar dapat dilakukan dengan urutan sebagai berikut:</p>
			<p></p>
			<ol>
				<li>Penduduk pemohon surat datang dengan membawa kartu identitas diri (KTP atau Kartu Keluarga/KK) dan diterima oleh staf pemerintah desa yang bertugas dalam pelayanan.</li>
				<li>Pastikan keberadaan dan status penduduk tersebut dalam database SID di Module "Penduduk". Gunakan fasilitas "Cari" dengan mengisikan nama atau NIK penduduk tersebut. Jika ada perubahan status, perbarui saat itu juga berdasarkan laporan penduduk yang bersangkutan. Jika penduduk tersebut belum terdaftar dalam database, masukkan data penduduk yang bersangkutan ke dalam SID merujuk pada dokumen kependudukan yang dimilikinya (wajib disertai dengan dokumen pendukung lainnya bagi penduduk pendatang/tinggal sementara). Jika data penduduk tersebut sudah tersimpan dalam SID, pembuatan surat dapat dilakukan.</li>
				<li>Klik module "Cetak Surat" untuk memulai pembuatan surat.</li>
				<li>Klik salah satu jenis surat yang akan dibuat, sesuaikan dengan jenis urusan yang diajukan oleh penduduk pemohon surat. Jika jenis surat yang dimohonkan tidak tersedia dalam daftar surat di SID, gunakan jenis surat terakhir yang berjudul "Ubah Sesuaikan".</li>
				<li>Isikan NIK / Nama, nomor surat, keterangan, dan hal lainnya sesuai kolom isian pada jenis surat yang dibuat.</li>
				<li>Pilih nama dan jabatan kepala desa atau perangkat desa yang berwenang melakukan pengesahan atas nama kepala desa.</li>
				<li>Setelah semua kolom terisi dengan benar, surat bisa langsung dicetak dengan klik tombol "Cetak" di bagian kanan bawah, atau bisa diedit lebih lanjut ke versi doc. dengan klik "Export Doc" di bagian kanan bawah.</li>
				<li>Surat dapat dicetak dua eksemplar, 1 eks. untuk penduduk pemohon surat dan 1 eks. untuk arsip pemerintah desa.</li>
				<li>Setiap jenis surat yang tercetak akan tersimpan data lognya di Menu "Surat Keluar"</li>
			</ol>
			<p></p>
			<p>Demikian panduan pembuatan surat dengan menggunakan aplikasi SID. Selamat menyelenggarakan pelayanan administrasi publik.</p>
		</div>
	</div>
	<?php
	}
	private static function _detail_lapor($data) {
		?>
	<div class="artikel">
		<?php if( $data['success'] === true ) echo "<p>Data telah terkirim, dan akan segera kami proses</p>"; ?>
		<form id="validasi" action="" method="POST" enctype="multipart/form-data">
			Silahkan laporkan perubahan data kependudukan anda.
			<table class="form">
				<tr>
					<th>Pengirim</th>
					<td>
						<input class="inputbox" type="text" name="owner" value="<?php echo $_SESSION['nama']?>" size="30"/>
					</td>
				</tr>
				<tr>
					<th>NIK</th>
					<td>
						<input class="inputbox" type="text" name="email" value="<?php echo $_SESSION['nik']?>" size="30"/>
					</td>
				</tr>
				<tr>
					<td>Laporan</td>
					<td>
						<textarea name="komentar" rows="15" cols="80" style="width: 90%; height: 100%"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="submit-lapor">
						<input type="submit" value="Kirim">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
	}
	private static function _detail_bantuan($data) {
		$daftar_bantuan = $data['daftar_bantuan'];
		?>
	<div class="artikel">
	  <?php if(!empty($daftar_bantuan)): ?>
	    <table  class="table table-bordered">
	      <caption><h3>Daftar Bantuan Yang Diterima (Sasaran Perorangan)</h3></caption>
	      <thead>
	        <tr>
	          <th>Nama</th>
	          <th>Awal</th>
	          <th>Akhir</th>
	          <th>ID KARTU</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php foreach ($daftar_bantuan as $bantuan) : ?>
	        <tr>
	          <td><?php echo $bantuan['nama']?></td>
	          <td><?php echo tgl_indo($bantuan['sdate'])?></td>
	          <td><?php echo tgl_indo($bantuan['edate'])?></td>
	          <td>
	            <?php if($bantuan['no_id_kartu']) : ?>
	              <button type="button" target="kartu_peserta" title="Kartu Peserta" href="<?php echo site_url('first/kartu_peserta/'.$bantuan['id'])?>" onclick="show_kartu_peserta($(this));" class="uibutton special"><span class="fa fa-print">&nbsp;</span><?php echo $bantuan['no_id_kartu']?></button>
	            <?php endif; ?>
	          </td>
	        </tr>
	      <?php endforeach; ?>
	      </tbody>
	    </table>
	  <?php else: ?>
	    <span>Anda tidak terdaftar dalam program bantuan apapun</span>
	  <?php endif; ?>
	</div>
	<?php
	}
	private static function _print_kartu_keluarga($data){
	}
	private static function _print_biodata($data){
	}
} // class OpenSID_Layanan_Mandiri_Widget
