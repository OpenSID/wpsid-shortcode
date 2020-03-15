<?php
namespace wpsid;

use WPSID;

class Statistik_model extends \CI_Model
{
	public function __construct() {
	}

	public function get_view($atts) {
		$presentasiType = strtr(
			element('type', (array)$atts),
			array('grafik' => 'bar', 'tabel' => 'table')
		) ?: 'default';

		return "stats/$presentasiType";
	}

	public function get_data($jenis) {
		$lap_penduduk = new \Laporan_penduduk_model();
		$data['jenis_laporan'] = $lap_penduduk->jenis_laporan($jenis);
		$data['heading'] = $lap_penduduk->judul_statistik($jenis);
		$data['stat'] = $lap_penduduk->list_data($jenis);

		return $data;
	}
}
