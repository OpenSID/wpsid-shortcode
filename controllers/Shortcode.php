<?php
namespace wpsid;

use WPSID;

class Shortcode extends \CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->opensid = new Opensid_model();
		$this->statistik = new Statistik_model();
		$this->opensid->load_donjolib_helper();
	}

	public function version($attrs) {
		$type = element('type', $attrs) ?: 'plain';
		$data['wp_version'] = get_bloginfo( 'version' );
		$data['opensid_version'] = $this->opensid->get_version();
		$data['plugin_version'] = WPSID::VERSION;

		switch($type) {
			case 'html':
				$this->load->view('version', $data);
				break;

			case 'plain':
			default:
				printf(
					__( 'Using Wordpress %s, ' . strtoupper( OPENSID_APP_TYPE ) . ' %s and WPSID Shortcode Plugin %s', 'wpsid-shortcode' ),
					$data['wp_version'],
					$data['opensid_version'],
					$data['plugin_version']
				);
		}
	}

	public function data_wilayah() {
		$wilayah = new \Wilayah_model();
		$data['heading'] = "Populasi Per Wilayah";
		$data['total'] = $wilayah->total();
		$data['main'] = $wilayah->list_data();

		$this->load->view('data_wilayah', $data);
	}

	public function data_pendidikan($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(0)
		);
	}

	public function data_pekerjaan($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(1)
		);
	}

	public function data_perkawinan($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(2)
		);
	}

	public function data_agama($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(3)
		);
	}

	public function data_jenis_kelamin($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(4)
		);
	}

	public function data_warga_negara($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(5)
		);
	}

	public function data_status_penduduk($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(6)
		);
	}

	public function data_golongan_darah($atts) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(7)
		);
	}

	public function data_cacat($atts, $content = null) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(9)
		);
	}

	public function data_menahun($atts, $content = null) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(10)
		);
	}

	public function data_umur($atts, $content = null) {
		$this->load->view(
				$this->statistik->get_view($atts),
				$this->statistik->get_data(13)
		);
	}

	public function data_pendidikan_sedang_ditempuh($atts, $content = null) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(14)
		);
	}

	public function data_cara_kb($atts, $content = null) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(16)
		);
	}

	public function data_akta_kelahiran($atts, $content = null) {
		$this->load->view(
			$this->statistik->get_view($atts),
			$this->statistik->get_data(17)
		);
	}

	public function layanan_mandiri_widget() {
		$data['sid_home'] = WPSID::config('sid_home');
		$data['mandiri_page'] = get_page_link(WPSID::config('mandiri_page'));
		$view = 'mandiri/'. ($this->opensid->is_user_logged_in() ? 'profile' : 'form');

		$this->load->view($view, $data);
	}

	public function layanan_mandiri_detail() {
		if( isset($_POST['mandiri']) && $_POST['mandiri'] == 'login' )
			(new \First_m)->siteman();

		if( isset($_REQUEST['mandiri']) && $_REQUEST['mandiri'] == 'logoff' )
			OpenSID::load_ci_model('first')->logout();

		if (!$this->opensid->is_user_logged_in())
			return $this->layanan_mandiri_widget();

		$options = WPSID::$config;
		$data['sid_home'] = $options['sid_home'];
		$data['mandiri_page'] = get_page_link($options['mandiri_page']);
		$data['detail'] = (!empty($_REQUEST['mandiri'])) ? $_REQUEST['mandiri'] : 'profil';
		$data['setting']['sebutan_dusun'] = $this->setting->sebutan_dusun;

		switch($data['detail']) {
			default:
			case 'profil':
				$data['penduduk'] = (new \Penduduk_model)->get_penduduk($_SESSION['id']);
				$data['print'] = (!empty($_REQUEST['print'])) ? $_REQUEST['print'] : false;
				$view = 'profile_detail';
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

		$this->load->view("mandiri/$view", $data);
	}
}
