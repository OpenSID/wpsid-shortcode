<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
// define( 'OPENSID_OPTION_KEY', 'wpsid_config' );
if(strpos($_SERVER['HTTP_HOST'], '.demo.siini.com') !== false || strpos($_SERVER['HTTP_HOST'], '.devhost') !== false)
	define( 'OPENSID_DEMO_SITE', true );
else define( 'OPENSID_DEMO_SITE', false );
// define( 'OPENSID_ABSPATH', dirname( OPENSID__FILE__ ) . '/' );
// define( 'OPENSID_DIR_URL', plugin_dir_url( OPENSID__FILE__ ) );
// define( 'OPENSID_BASENAME', plugin_basename( OPENSID__FILE__ ) );
function opensid_load_textdomain() {
	load_plugin_textdomain( 'wpsid-shortcode', false, basename( OPENSID_ABSPATH ) . '/locale' );
}
// add_action( 'init', 'opensid_load_textdomain' );
// register_activation_hook( OPENSID__FILE__, 'opensid_init' );
function opensid_init() {
	$options = get_option( OPENSID_OPTION_KEY );
	if ( ! isset( $options['db_name'] ) ) $options['db_name'] = DB_NAME;
	if ( ! isset( $options['db_user'] ) ) $options['db_user'] = DB_USER;
	if ( ! isset( $options['db_host'] ) ) $options['db_host'] = DB_HOST;
	if ( ! isset( $options['sid_path'] ) ) $options['sid_path'] = esc_attr( ABSPATH . 'opensid' );
	if ( ! isset( $options['sid_home'] ) ) $options['sid_home'] = esc_url( site_url() . '/opensid' );
	if ( ! isset( $options['db_pass'] ) ) $options['db_pass'] = DB_PASSWORD;
	update_option( OPENSID_OPTION_KEY, $options );
}
// opensid_init();
function opensid_set_option($key, $value) {
	$options = get_option( OPENSID_OPTION_KEY );
	$options[$key] = $value;
	update_option( OPENSID_OPTION_KEY, $options );
}
function opensid_get_option($key) {
	// $options = get_option( OPENSID_OPTION_KEY );
	// if ( ! isset( $options[$key] ) )
	// 	return false;
	// return $options[$key];
}
defined( 'OPENSID_DB_NAME' ) or define( 'OPENSID_DB_NAME', opensid_get_option( 'db_name' ) );
defined( 'OPENSID_DB_USER' ) or define( 'OPENSID_DB_USER', opensid_get_option( 'db_user' ) );
defined( 'OPENSID_DB_PASS' ) or define( 'OPENSID_DB_PASS', opensid_get_option( 'db_pass' ) );
defined( 'OPENSID_DB_HOST' ) or define( 'OPENSID_DB_HOST', opensid_get_option( 'db_host' ) );
// defined( 'OPENSID_DB_NAME' ) or define( 'OPENSID_DB_NAME', opensid_get_config( 'db_name' ) );
// defined( 'OPENSID_DB_USER' ) or define( 'OPENSID_DB_USER', opensid_get_config( 'db_user' ) );
// defined( 'OPENSID_DB_PASS' ) or define( 'OPENSID_DB_PASS', opensid_get_config( 'db_pass' ) );
// defined( 'OPENSID_DB_HOST' ) or define( 'OPENSID_DB_HOST', opensid_get_config( 'db_host' ) );
// defined( 'OPENSID_APPPATH' ) or define( 'OPENSID_APPPATH', opensid_get_option( 'sid_path' ) );
defined( 'OPENSID_HOMEURL' ) or define( 'OPENSID_HOMEURL', opensid_get_option( 'sid_home' ) );
define( 'OPENSID_CONNECT', 'mysqli://' . OPENSID_DB_USER . ':' . OPENSID_DB_PASS . '@' . OPENSID_DB_HOST . '/' . OPENSID_DB_NAME );
function opensid_check_sid_path() {
	return is_dir( opensid_get_option( 'sid_path' ) . '/donjo-sys' );
}
function opensid_check_database_connection() {
	if ( ! function_exists( 'opensid_ci_load_database' ) )
		return false;
	$connection = opensid_ci_load_database();
	return $connection->initialize();
}
if ( opensid_check_sid_path() ) {
	require_once OPENSID_ABSPATH . 'ci-bootstrap.php';
	if ( opensid_check_database_connection() ) {
		define( 'OPENSID_READY', true );
	} else define( 'OPENSID_READY', false );
} else define( 'OPENSID_READY', false );
// if ( is_dir( OPENSID_APPPATH . '/desa' ) )
// 	define( 'OPENSID_APP_TYPE', 'opensid' );
// else
// 	define( 'OPENSID_APP_TYPE', 'sidcri' );

require __DIR__ .'/functions.php';

add_action( 'init', array('WPSID', 'run') );
