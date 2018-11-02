<?php
namespace WPSID;

use WPSID;

class Shortcodes extends \CI_Controller
{
	public function version($atts, $content = null) {
		$shortcode_atts = shortcode_atts( array(
			'type' => 'plain', //default: plain
		), $atts );
		return OpenSID::load_shortcode( 'version', $shortcode_atts );
	}

	public function data_wilayah() {
		$wilayah = new \Wilayah_model;
		$data['heading'] = "Populasi Per Wilayah";
		$data['total'] = $wilayah->total();
		$data['main'] = $wilayah->list_data();
		$this->render('data_wilayah', $data);
	}

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

	protected function render($view, $data=array())
	{
		// code...
	}
}
