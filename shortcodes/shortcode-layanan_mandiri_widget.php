<?php
defined('ABSPATH') || die('No direct script access allowed!');
class OpenSID_Layanan_Mandiri_Widget_Shortcode extends OpenSID_Shortcode {
	public function __construct() {
		parent::__construct();
	}
	public function setup($action, array $data) {
		parent::setup($action, $data);
		$options = get_option( OPENSID_OPTION_KEY );
		$data['sid_home'] = $options['sid_home'];
		$data['mandiri_page'] = get_page_link($options['mandiri_page']);
		ob_start();
		echo self::render($data);
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	private static function render($data) {
		if( self::_is_logged() )
			self::_widget_data($data);
		else
			self::_widget_form($data);
	}
	private static function _is_logged() {
		return (( isset($_SESSION['mandiri']) && $_SESSION['mandiri'] == 1) ? true : false);
	}
	private static function _widget_form($data) {
		?>
	<div class="box box-primary box-solid">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3><br>Silakan datang atau hubungi operator desa untuk mendapatkan kode PIN anda.
		</div>
		<div class="box-body">
			<?php echo (isset($_POST['mandiri']) && isset($_SESSION['mandiri']) && $_SESSION['mandiri'] == -1) ? '<span style="color: red !important"><strong>NIK atau PIN salah!</strong></span><br>' : '';?>
			<h4>Masukan NIK dan PIN</h4>
			<form action="<?php echo $data['mandiri_page']?>" method="post">
				<input name="nik" type="text" placeholder="NIK" style="margin-left:0px" value="<?php echo (OPENSID_DEMO_SITE) ? '5201142005716996' : '';?>" required="">
				<input name="pin" type="password" placeholder="PIN" style="margin-left:0px" value="<?php echo (OPENSID_DEMO_SITE) ? '123456' : '';?>" required="">
				<button type="submit" name="mandiri" value="login" id="submit" style="margin-left:0px">Masuk</button>
			</form>
		</div>
	</div>
	<?php
	}
	private static function _widget_data($data) {
		?>
	<div class="box box-primary box-solid">
	  <div class="box-header">
	    <h3 class="box-title"><i class="fa fa-user"></i> Layanan Mandiri</h3>
	  </div>
	  <div class="box-body">
	  <ul id="ul-mandiri">
		  <table id="mandiri" width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tbody>
			  <tr>
				  <td width="25%">Nama</td>
				  <td width="2%" class="titik">:</td>
				  <td width="73%"><?php echo $_SESSION['nama']?></td>
			  </tr>
			  <tr>
				  <td bgcolor="#eee">NIK</td>
				  <td class="titik" bgcolor="#eee">:</td>
				  <td bgcolor="#eee"><?php echo $_SESSION['nik']?></td>
			  </tr>
			  <tr>
				  <td>No KK</td>
				  <td class="titik">:</td>
				  <td><?php echo $_SESSION['no_kk']?></td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $data['mandiri_page']?>" method="get">
						  <button type="submit" name="mandiri" value="profil" class="btn btn-primary btn-block">Profil</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $data['mandiri_page']?>" method="get">
						  <button type="submit" name="mandiri" value="layanan" class="btn btn-primary btn-block">Layanan</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $data['mandiri_page']?>" method="get">
						  <button type="submit" name="mandiri" value="lapor" class="btn btn-primary btn-block">Lapor</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $data['mandiri_page']?>" method="get">
						  <button type="submit" name="mandiri" value="bantuan" class="btn btn-primary btn-block">Bantuan</button>
					  </form>
				  </td>
			  </tr>
			  <tr>
				  <td colspan="3">
					  <form action="<?php echo $data['mandiri_page']?>" method="get">
						  <button type="submit" name="mandiri" value="logoff" class="btn btn-danger btn-block">Keluar</button>
					  </form>
				  </td>
			  </tr>
			  </tbody>
		  </table>
	  </ul></div>
	</div>
		<?php
	}
} // class OpenSID_Layanan_Mandiri_Widget
