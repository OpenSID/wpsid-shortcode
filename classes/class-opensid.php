<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
abstract class OpenSID {
	const version = '1.0.9.2';
	public static $model_opensid;
	public static $controller;
	public static function run() {
		
		if(OPENSID_READY){
			
			
			do_action( 'opensid_run' );
			
			add_filter('widget_text', 'do_shortcode');
			
			self::$model_opensid = self::load_model( 'opensid' );
		}
		
		if ( is_admin() ) {
			$controller = 'admin';
			self::$controller = self::load_controller( $controller );
		} else {
			if(OPENSID_READY){
				$controller = 'frontend';
				self::$controller = self::load_controller( $controller );
			}
		}
	}
	
	public static function load_ci_model( $ci_model, array $data = array() ) {
		self::load_file( 'class-ci-model.php', 'classes' );
		$suffix = (strtolower($ci_model) == 'first') ? '_M' : '_Model';
		$ci_model = ( !empty($data['__model_class_name__']) ) ? $data['__model_class_name__'] : $ci_model . $suffix;
		
		$lwrci_model = ucfirst (strtolower( $ci_model ));
		$file = ( !empty($data['__model_class_file__']) ) ? $data['__model_class_file__'] : OPENSID_APPPATH . '/donjo-app/models/' . $lwrci_model . '.php';
		require_once $file;
		$the_class = new $ci_model();
		
		return $the_class;
	}
	public static function load_ci_view( $ci_model, array $data = array() ) {
		self::load_file( 'class-ci-controller.php', 'classes' );
		$ci_model = ( !empty($data['__model_class_name__']) ) ? $data['__model_class_name__'] : $ci_model;
		$lwrci_model = strtolower( $ci_model );
		$file = ( !empty($data['__model_class_file__']) ) ? $data['__model_class_file__'] : OPENSID_APPPATH . '/donjo-app/controllers/' . $lwrci_model . '.php';
		require_once $file;
		$the_class = new $ci_model();
		return $the_class;
	}
	public static function load_ci_controller( $ci_model, array $data = array() ) {
		self::load_file( 'class-ci-controller.php', 'classes' );
		$ci_model = ( !empty($data['__model_class_name__']) ) ? $data['__model_class_name__'] : $ci_model;
		$lwrci_model = strtolower( $ci_model );
		$file = ( !empty($data['__model_class_file__']) ) ? $data['__model_class_file__'] : OPENSID_APPPATH . '/donjo-app/controllers/' . $lwrci_model . '.php';
		require_once $file;
		$the_class = new $ci_model();
		return $the_class;
	}
	public static function load_shortcode( $shortcode, array $data = array() ) {
		self::load_file( 'class-shortcode.php', 'classes' );
		$ucshortcode = ucfirst( $shortcode );
		$the_shortcode = self::load_class( "OpenSID_{$ucshortcode}_Shortcode", "shortcode-{$shortcode}.php", 'shortcodes' );
		return $the_shortcode->setup( $shortcode, $data );
	}
	
	public static function load_file( $file, $folder ) {
		$full_path = OPENSID_ABSPATH . $folder . '/' . $file;
		$full_path = apply_filters( 'opensid_load_file_full_path', $full_path, $file, $folder );
		if ( $full_path ) {
			require_once $full_path;
		}
	}
	public static function load_class( $class, $file, $folder, $params = null ) {
		$class = apply_filters( 'opensid_load_class_name', $class );
		if ( ! class_exists( $class ) ) {
			self::load_file( $file, $folder );
		}
		$the_class = new $class( $params );
		return $the_class;
	}
	public static function load_model( $model ) { //TODO: ganti 'load_model' menjadi 'load_wpsid_model'
		self::load_file( 'class-model.php', 'classes' );
		$ucmodel = ucfirst( $model );
		$the_model = self::load_class( "OpenSID_{$ucmodel}_Model", "model-{$model}.php", 'models' );
		return $the_model;
		
	}
	public static function load_controller( $controller ) {
		self::load_file( 'class-controller.php', 'classes' );
		$uccontroller = ucfirst( $controller );
		$the_controller = self::load_class( "OpenSID_{$uccontroller}_Controller", "controller-{$controller}.php", 'controllers' );
		return $the_controller;
	}
	public static function show_minimum_requirements_error_notice() {
		echo '<div class="notice notice-error form-invalid"><p>' .
			'<strong>Attention:</strong> ' .
			'The installed version of WordPress is too old for the OpenSID plugin! OpenSID requires an up-to-date version! <strong>Please <a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">update your WordPress installation</a></strong>!' .
			"</p></div>\n";
	}
} // class OpenSID
