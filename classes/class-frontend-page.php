<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Frontend_Page {
	
	public function enqueue_style_opensid( $name, array $dependencies = array() ) {
		$suffix = '';
		$css_file = "assets/{$name}{$suffix}.css";
		$css_url = OPENSID_HOMEURL . '/' . $css_file;
		wp_enqueue_style( "opendsid-{$name}", $css_url, $dependencies, OpenSID::version );
	}
	
	public function enqueue_script_opensid( $name, array $dependencies = array(), array $localize_script = array(), $force_minified = false ) {
		$suffix = '';
		$js_file = "assets/{$name}{$suffix}.js";
		$js_url = OPENSID_HOMEURL . '/' . $js_file;
		wp_enqueue_script( "opendsid-{$name}", $js_url, $dependencies, OpenSID::version, true );
		if ( ! empty( $localize_script ) ) {
			foreach ( $localize_script as $var_name => $var_data ) {
				wp_localize_script( "opendsid-{$name}", "opendsid_{$var_name}", $var_data );
			}
		}
	}
	
} // class OpenSID_Frontend_Page
