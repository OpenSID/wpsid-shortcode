<?php

class WPSID
{
	const VERSION = '2.0';
	const OPTION_KEY = 'wpsid_config';
	static $config;
	static $CI;

	static function run() {
		self::$config = get_option(self::OPTION_KEY);

		if (is_admin()) {
			self::run_admin();
		} elseif (self::sid_path_ready()) {
			self::run_front();
		}
	}

	static function init() {
	}

	static function run_admin() {
		add_action('admin_menu', array(__CLASS__, 'set_admin_menu'));
		add_action('admin_init', array(__CLASS__, 'register_wpsid_setting'));
	}

	static function set_admin_menu() {
		$page_cb = array(__CLASS__, 'run_admin_controller');
		$perms = 'manage_options';
		add_menu_page( __( 'WPSID', 'wpsid-shortcode'), __( 'WPSID', 'wpsid-shortcode'), $perms, 'wpsid', $page_cb );
		add_submenu_page( 'wpsid', __( 'Config', 'wpsid-shortcode'), __( 'Config', 'wpsid-shortcode'), $perms, 'wpsid', $page_cb );
		add_submenu_page( 'wpsid', __( 'Shortcodes', 'wpsid-shortcode'), __( 'Shortcodes', 'wpsid-shortcode'), $perms, 'wpsid-shortcode', $page_cb );
		add_submenu_page( 'wpsid', __( 'About', 'wpsid-shortcode'), __( 'About', 'wpsid-shortcode'), $perms, 'wpsid-about', $page_cb );
	}

	static $setting_form;
	static function register_wpsid_setting() {
		self::$setting_form = new wpsid\Setting_form_model();

		register_setting(
			'wpsid_option_group', // Option group
			WPSID::OPTION_KEY, // Option name
			array(self::$setting_form, 'filter_input') // Sanitize
		);

		$section = 'path-setting';
		add_settings_section($section, __('Path', 'wpsid-shortcode'), array(__CLASS__, 'settings_section_callback'), 'wpsid-setting-admin');
		add_settings_field('sid_path', __('SID Full Path', 'wpsid-shortcode'), array(__CLASS__, 'settings_field_contents'), 'wpsid-setting-admin', $section, 'sid_path');
		add_settings_field('sid_home', __('SID Home Url', 'wpsid-shortcode'), array(__CLASS__, 'settings_field_contents'), 'wpsid-setting-admin', $section, 'sid_home');
		add_settings_field('mandiri_page', __('Mandiri Page', 'wpsid-shortcode'), array(__CLASS__, 'settings_field_contents'), 'wpsid-setting-admin', $section, 'mandiri_page');
	}

	static function settings_section_callback($name) {
		echo self::$setting_form->get_section($name);
	}

	static function settings_field_contents($name) {
		echo self::$setting_form->get_field($name);
	}

	static function run_admin_controller() {
		$action = str_replace(array('wpsid-', 'wpsid'), array('', 'index'), $_GET['page']);
		call_user_func(array(new wpsid\Admin(), $action));
	}

	static function run_front() {
		chdir(self::$config['sid_path']);
		self::$config['ci_sys_path'] = realpath(self::get_ci_sys_path()) .'/';
		self::$config['ci_app_path'] = realpath(self::get_ci_app_path()) .'/';

		require WPSID_DIR .'constants.php';
		require self::$config['ci_sys_path'] .'core/Common.php';

		self::load_ci_cores();

		load_class('Hooks', 'core')->call_hook('pre_controller');

		self::$CI = new wpsid\Shortcode();

		self::$CI->hooks->call_hook('post_controller_constructor');

		self::register_shortcodes();
	}

	protected static function load_ci_cores() {
		$classes = array('Config', 'Utf8', 'Input', 'Output');

		foreach ($classes as $class) {
			load_class($class, 'core');
		}
	}

	protected static function register_shortcodes() {
		$refobj = new \ReflectionObject(self::$CI);
		$methods = $refobj->getMethods();
		$cb = array(__CLASS__, 'shortcode_callback');

		foreach ($methods as $method) {
			$code = $method->getName();
			add_shortcode($code, $cb);
			add_shortcode('wpsid_'. $code, $cb);
		}
	}

	static function shortcode_callback($attrs, $arg1, $code) {
		$code = str_replace('wpsid_', '', $code);
		call_user_func(array(self::$CI, $code), $attrs);

		self::$CI->hooks->call_hook('post_controller');

		self::$CI->output->_display();
	}

	static function config($key, $value='') {
		return isset(self::$config[$key]) ? self::$config[$key] : $value;
	}

	protected static function get_ci_sys_path() {
		$script = self::sid_index_script();
		preg_match('/\n\s*\$system_path\s*=\s*[\'"]([-\w]+)[\'"];\s*/', $script, $matches);
		return $matches[1];
	}

	protected static function get_ci_app_path() {
		$script = self::sid_index_script();
		preg_match('/\n\s*\$application_folder\s*=\s*[\'"]([-\w]+)[\'"];\s*/', $script, $matches);
		return $matches[1];
	}

	protected static function sid_index_script() {
		static $contents;

		if (!$contents) {
			$index_file = self::$config['sid_path'] . '/index.php';
			$contents = file_get_contents($index_file);
		}

		return $contents;
	}

	static function sid_path_ready() {
		return is_file(self::$config['sid_path'] .'/index.php');
	}
}
