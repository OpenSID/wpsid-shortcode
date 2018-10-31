<?php
namespace wpsid;

use WPSID;

class Statistik_model extends \CI_Model
{
	private $version;
	private $path;

	public function __construct() {
	}

	public function get_view($atts) {
		$presentasi = strtr(
			element('type', $atts),
			array('grafik' => 'bar', 'tabel' => 'table')
		) ?: 'default';

		return "statistik_$presentasi";
	}

	public function get_data($jenis) {
		$lap_penduduk = new \Laporan_penduduk_model();
		$data['jenis_laporan'] = $lap_penduduk->jenis_laporan($jenis);
		$data['heading'] = $lap_penduduk->judul_statistik($jenis);
		$data['stat'] = $lap_penduduk->list_data($jenis);

		return $data;
	}
}
