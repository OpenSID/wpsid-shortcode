<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Frontend_Controller extends OpenSID_Controller {
	public function __construct() {
		parent::__construct();
		if( !session_id() ) {
			session_start();
		}
		add_action( 'init', array($this, 'init_shortcodes'), 20 ); // run on priority 20 as WP-Table Reloaded Shortcodes are registered at priority 10
		add_action('template_redirect', array($this, 'opensid_handle_redirects'));
	}
	function opensid_handle_redirects() {
		$options = get_option(OPENSID_OPTION_KEY);
		if( !empty($_REQUEST['wpsid-redirect-to']) ) {
			wp_redirect($_REQUEST['wpsid-redirect-to']);
			exit;
		}
		if( !empty($_REQUEST['print']) ) {
			switch(esc_attr($_REQUEST['print'])) {
				case 'kartu_keluarga':
					wp_redirect($options['sid_home'] . '/index.php/first/cetak_kk/1/1');
					exit;
					break;
				case 'biodata':
					wp_redirect($options['sid_home'] . '/index.php/first/cetak_biodata/1');
					exit;
					break;
			}
		}
	}
	private static function opensid_shortcode($this, $shortcode, $function = '', $remove_old = false) {
		if ( empty( $function ) )
			$function = $shortcode;
		$shortcode = 'wpsid_' . $shortcode;
		if ( $remove_old )
			remove_shortcode( $shortcode );
		add_shortcode( $shortcode, array($this, $function) );
	}
	public function init_shortcodes() {
		self::opensid_shortcode( $this, 'version' );
		self::opensid_shortcode( $this, 'data_wilayah' );
		self::opensid_shortcode( $this, 'data_pendidikan' );
		self::opensid_shortcode( $this, 'data_pekerjaan' );
		self::opensid_shortcode( $this, 'data_perkawinan' );
		self::opensid_shortcode( $this, 'data_agama' );
		self::opensid_shortcode( $this, 'data_jenis_kelamin' );
		self::opensid_shortcode( $this, 'data_warga_negara' );
		self::opensid_shortcode( $this, 'data_status_penduduk' );
		self::opensid_shortcode( $this, 'data_golongan_darah' );
		self::opensid_shortcode( $this, 'data_cacat' );
		self::opensid_shortcode( $this, 'data_menahun' );
		self::opensid_shortcode( $this, 'data_umur' );
		self::opensid_shortcode( $this, 'data_pendidikan_sedang_ditempuh' );
		self::opensid_shortcode( $this, 'data_cara_kb' );
		self::opensid_shortcode( $this, 'data_akta_kelahiran' );
		self::opensid_shortcode( $this, 'layanan_mandiri_widget' );
		self::opensid_shortcode( $this, 'layanan_mandiri_detail' );
	}
	public function version($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array(
			'type' => 'plain', //default: plain
		), $atts );
		return OpenSID::load_shortcode( 'version', $shortcode_atts );
	}
	public function data_wilayah() { return OpenSID::load_shortcode( 'data_wilayah' ); }
	public function data_pendidikan($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 0;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'pendidikan-dalam-kk';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_pekerjaan($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 1;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'pekerjaan';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_perkawinan($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 2;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'status-perkawinan';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_agama($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 3;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'agama';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_jenis_kelamin($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 4;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'jenis-kelamin';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_warga_negara($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 5;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'warga-negara';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_status_penduduk($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 6;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = null;
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_golongan_darah($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 7;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'golongan-darah';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_cacat($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 9;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = null;
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_menahun($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 10;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = null;
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_umur($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 13;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'kelompok-umur';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_pendidikan_sedang_ditempuh($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 14;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = 'pendidikan-ditempuh';
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_cara_kb($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 16;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = null;
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function data_akta_kelahiran($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		switch(OPENSID_APP_TYPE) {
			case 'opensid':
				$shortcode_atts['statistik'] = 17;
				break;
			case 'sidcri':
				$shortcode_atts['statistik'] = null;
				break;
		}
		return OpenSID::load_shortcode( 'data_statistik', $shortcode_atts );
	}
	public function layanan_mandiri_widget($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		return OpenSID::load_shortcode( 'layanan_mandiri_widget', $shortcode_atts );
	}
	public function layanan_mandiri_detail($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array('type' => null,), $atts );
		return OpenSID::load_shortcode( 'layanan_mandiri_detail', $shortcode_atts );
	}
} // class OpenSID_Frontend_Controller
