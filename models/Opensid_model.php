<?php
namespace wpsid;

use WPSID;

class Opensid_model extends \CI_Model
{
	private $version;

	public function get_version() {
		if (!$this->version) {
			$opensid_helper_file = WPSID::config('ci_app_path') .'helpers/opensid_helper.php';

			if (is_file($opensid_helper_file)) {
				$contents = file_get_contents($opensid_helper_file);
				preg_match('~define\s*\(\s*[\'"]VERSION[\'"],\s*[\'"]\s*([^\'"]+)\s*[\'"]\s*\)~', $contents, $matches);
				$this->version = $matches[1];
			}
		}

		return $this->version ?: __( 'Unknown version', 'wpsid-shortcode' );
	}

	public function register_css( $name, array $dependencies = array() ) {
		$css_file = "assets/{$name}.css";
		$css_url = WPSID::config('sid_path') . '/' . $css_file;

		wp_enqueue_style( "opendsid-{$name}", $css_url, $dependencies, WPSID::VERSION );
	}

	public function register_script( $name, array $dependencies = array(), array $localize_script = array(), $force_minified = false ) {
		$js_file = "assets/{$name}.js";
		$js_url = WPSID::config('sid_path') . '/' . $js_file;

		wp_enqueue_script( "opendsid-{$name}", $js_url, $dependencies, WPSID::VERSION, true );

		foreach ( $localize_script as $var_name => $var_data ) {
			wp_localize_script( "opendsid-{$name}", "opendsid_{$var_name}", $var_data );
		}
	}

	public function is_user_logged_in() {
		return $this->session->mandiri > 0;
	}

	public function load_donjolib_helper() {
		$php = file_get_contents(WPSID::config('ci_app_path') .'helpers/donjolib_helper.php');
		$php = preg_replace('/function\s+selected(.+?)\}\s+function/ms', "\nfunction", $php);
		eval("?> $php");
	}
}
