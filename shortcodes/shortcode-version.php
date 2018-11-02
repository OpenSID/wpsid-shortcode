<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Version_Shortcode extends OpenSID_Shortcode {
	public function setup($action, array $data) {
		parent::setup( $action, $data );
		$data['type'] = ( ! empty( $data['type'] ) ) ? $data['type'] : 'plain';
		$data['wp_version'] = get_bloginfo( 'version' );
		$data['opensid_version'] = self::get_opensid_version( $data );
		$data['plugin_version'] = OpenSID::version;
		ob_start();
		echo self::render( $data );
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	private static function get_opensid_version($data) {
		if ( file_exists( OPENSID_APPPATH . '/donjo-app/helpers/opensid_helper.php' ) ) {
			include_once ( OPENSID_APPPATH . '/donjo-app/helpers/opensid_helper.php' );
			return VERSION;
		} else {
			return __( 'Unknown version', 'wpsid-shortcode' );
		}
	}
	private static function render($data) {
		extract( $data );
		switch($type) {
			case 'plain':
			default:
				printf( __( 'Using Wordpress %s, ' . strtoupper( OPENSID_APP_TYPE ) . ' %s and WPSID Shortcode Plugin %s', 'wpsid-shortcode' ),
					$wp_version, $opensid_version, $plugin_version );
				break;
			case 'html':
				?>
				<ul>
					<li><?php echo __( 'Wordpress', 'wpsid-shortcode' ) . ': ' . $wp_version;?></li>
					<li><?php echo strtoupper( OPENSID_APP_TYPE ) . ': ' . $opensid_version;?></li>
					<li><?php echo __( 'WPSID Shortcode Plugin', 'wpsid-shortcode' ) . ': ' . $plugin_version;?></li>
				</ul>
				<?php
				break;
		}
	}
} // class OpenSID_Version_Shortcode
