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
		$this->register_stats_shortcodes();
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
        if (empty($_GET['rest_route'])) {
          printf(
            __( 'Using Wordpress %s, ' . strtoupper( OPENSID_APP_TYPE ) . ' %s and WPSID Shortcode Plugin %s', 'wpsid-shortcode' ),
            $data['wp_version'],
            $data['opensid_version'],
            $data['plugin_version']
          );
        }
		}
	}

	public function data_wilayah() {
		$wilayah = new \Wilayah_model();
		$data['heading'] = "Populasi Per Wilayah";
		$data['total'] = $wilayah->total();
		$data['main'] = $wilayah->list_data();

		$this->load->view('data_wilayah', $data);
	}

	public function layanan_mandiri_widget() {
		$data['sid_home'] = WPSID::config('sid_home');
		$data['mandiri_page'] = get_page_link(WPSID::config('mandiri_page'));
		$view = 'mandiri/'. ($this->opensid->is_user_logged_in() ? 'profile' : 'form');

		$this->load->view($view, $data);
	}

	public function layanan_mandiri_detail() {
		$First_m = new \First_m();

		if( isset($_POST['mandiri']) && $_POST['mandiri'] == 'login' )
			$First_m->siteman();

		if( isset($_REQUEST['mandiri']) && $_REQUEST['mandiri'] == 'logoff' )
			$First_m->logout();

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
				$view = 'help';
				break;

			case 'lapor':
				$view = 'lapor';
				break;

			case 'bantuan':
				$nik = $_SESSION['nik'];
				$data['daftar_bantuan'] = $this->db->select('p.*,pp.*')
								->where(array('peserta' => $nik))
								->join('program p','p.id = pp.program_id')
								->get('program_peserta pp')
								->result_array();
				$view = 'program_bantuan';
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

	protected $stats_shortcodes = array(
		'data_pendidikan' => 0,
		'data_pekerjaan' => 1,
		'data_perkawinan' => 2,
		'data_agama' => 3,
		'data_jenis_kelamin' => 4,
		'data_warga_negara' => 5,
		'data_status_penduduk' => 6,
		'data_golongan_darah' => 7,
		'data_cacat' => 9,
		'data_menahun' => 10,
		'data_umur' => 13,
		'data_pendidikan_sedang_ditempuh' => 14,
		'data_cara_kb' => 16,
		'data_akta_kelahiran' => 17,
	);

	protected function register_stats_shortcodes() {
		$cb = array('WPSID', 'shortcode_callback');

		foreach ($this->stats_shortcodes as $code => $stat_type) {
			add_shortcode('wpsid_'. $code, $cb);
		}
	}

	public function __call($method, $args) {
		foreach ($this->stats_shortcodes as $code => $stat_type) {
			if ($code != $method) continue;

			return $this->load->view(
				$this->statistik->get_view($args[0]),
				$this->statistik->get_data($stat_type)
			);
		}
	}
}
