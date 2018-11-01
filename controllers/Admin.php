<?php
namespace wpsid;

use WPSID;

class Admin
{
	private $options;

	function index() {
		WPSID::sid_path_ready() OR add_settings_error('opensid_error_sid_path', '', __('SID Path error: not directory', 'wpsid-shortcode'), 'error');
		$this->render_view('admin/config');
	}

	function shortcode() {
		$this->render_view('admin/shortcode');
	}

	function about() {
		$this->render_view('admin/about');
	}

	protected function render_view($view, $data=array()) {
		include WPSID_DIR ."views/$view.php";
	}
}
