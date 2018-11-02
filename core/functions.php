<?php

spl_autoload_register('class_autoloader');

function class_autoloader($class) {
	$filename = strtr($class, array(
		'wpsid\\' => '',
	));

	$paths = array(
		WPSID_DIR,
		WPSID_DIR .'classes',
		WPSID_DIR .'controllers',
	);

	foreach ($paths as $path) {
		$file = "$path/$filename.php";

		if (file_exists($file)) {
			return include $file;
		}
	}

	if (strpos($class, 'CI_') === 0) {
		$file = WPSID::config('ci_sys_path') .'/core/'. substr($class, 3) .'.php';
		return include $file;
	}

	if (preg_match('/_m(odel)?$/', $class)) {
		$paths = array(WPSID::config('ci_app_path'), WPSID_DIR);

		foreach ($paths as $path) {
			$file = "$path/models/$filename.php";

			if (is_file($file)) {
				return include $file;
			}
		}
	}
}

/**
 * Reference to the CI_Controller method.
 *
 * Returns current CI instance object
 *
 * @return CI_Controller
 */
function &get_instance() {
	return CI_Controller::get_instance();
}

function is_wplogin() {
	foreach (get_included_files() as $file) {
		if (strpos($file, 'wp-login.php') !== false)
			return true;
	}
}

//
// function opensid_load_textdomain() {
// 	load_plugin_textdomain('wpsid-shortcode', false, basename(WPSID_DIR) . '/locale');
// }
//
// function opensid_init() {
// 	$options			 = get_option(WPSID_OPTION_KEY);
// 	if (!isset($options['db_name'])) $options['db_name']	 = DB_NAME;
// 	if (!isset($options['db_user'])) $options['db_user']	 = DB_USER;
// 	if (!isset($options['db_host'])) $options['db_host']	 = DB_HOST;
// 	if (!isset($options['sid_path'])) $options['sid_path'] = esc_attr(ABSPATH . 'opensid');
// 	if (!isset($options['sid_home'])) $options['sid_home'] = esc_url(site_url() . '/opensid');
// 	if (!isset($options['db_pass'])) $options['db_pass']	 = DB_PASSWORD;
// 	update_option(WPSID_OPTION_KEY, $options);
// }
//
// function opensid_set_option($key, $value) {
// 	$options		 = get_option(WPSID_OPTION_KEY);
// 	$options[$key]	 = $value;
// 	update_option(WPSID_OPTION_KEY, $options);
// }
//
// function opensid_get_option($key) {
// 	$options = get_option(WPSID_OPTION_KEY);
// 	if (!isset($options[$key])) return false;
// 	return $options[$key];
// }
//
// function get_ci_param($key) {
// 	static $ci_params;
//
// 	if (empty($ci_params)) {
// 		$index_file = OPENSID_DIR . 'index.php';
//
// 		if (file_exists($index_file)) {
// 			$script = file_get_contents($index_file);
// 			preg_replace_callback('~\$system_path\s+=\s+[\'"]([^\'"]+)~', function($match) use (&$ci_params) {
// 				$ci_params['system_path'] = $match[1];
// 			}, $script);
// 			preg_replace_callback('~\$application_folder\s+=\s+[\'"]([^\'"]+)~', function($match) use (&$ci_params) {
// 				$ci_params['application_folder'] = $match[1];
// 			}, $script);
// 		}
// 	}
//
// 	return isset($ci_params[$key]) ? $ci_params[$key] : null;
// }
//
// function opensid_check_database_connection() {
// 	if (!function_exists('opensid_ci_load_database')) return false;
// 	$connection = opensid_ci_load_database();
// 	return $connection->initialize();
// }
//
// function &opensid_ci_load_database($active_record_override = true) {
// 	$database = & DB(OPENSID_CONNECT, $active_record_override);
// 	return $database;
// }
//
// class OPENSID___FAKE_LOAD
// {
// 	function model() {
// 		return true;
// 	}
//
// }
//
// //function hash_pin($pin = "") {
// //	$pin = strrev($pin);
// //	$pin = $pin * 77;
// //	$pin .= "!#@$#%";
// //	$pin = md5($pin);
// //	return $pin;
// //}
//
// //function unpenetration($str) {
// //	$str = str_replace("-", "'", $str);
// //	return $str;
// //}
// //
// //function tgl_indo_out($tgl) {
// //	if ($tgl) {
// //		$tanggal = substr($tgl, 8, 2);
// //		$bulan	 = substr($tgl, 5, 2);
// //		$tahun	 = substr($tgl, 0, 4);
// //		return $tanggal . '-' . $bulan . '-' . $tahun;
// //	}
// //}
// //
// //function tgl_indo($tgl) {
// //	$tanggal = substr($tgl, 8, 2);
// //	$bulan	 = getBulan(substr($tgl, 5, 2));
// //	$tahun	 = substr($tgl, 0, 4);
// //	return $tanggal . ' ' . $bulan . ' ' . $tahun;
// //}
// ////
// ////function getBulan($bln) {
// ////	switch($bln) {
// ////		case 1:
// ////			return "Januari";
// ////			break;
// ////		case 2:
// ////			return "Februari";
// ////			break;
// ////		case 3:
// ////			return "Maret";
// ////			break;
// ////		case 4:
// ////			return "April";
// ////			break;
// ////		case 5:
// ////			return "Mei";
// ////			break;
// ////		case 6:
// ////			return "Juni";
// ////			break;
// ////		case 7:
// ////			return "Juli";
// ////			break;
// ////		case 8:
// //			return "Agustus";
// //			break;
// //		case 9:
// //			return "September";
// //			break;
// //		case 10:
// //			return "Oktober";
// //			break;
// //		case 11:
// //			return "November";
// //			break;
// //		case 12:
// //			return "Desember";
// //			break;
// //	}
// //}
//
// function register_ci_pre_view_hook() {
// 	load_class('Hooks', 'core')->hooks['pre_view'][] = function ($hook) {
// 		$hook->vars;
// 	};
// }

function opensid_get_config($key) {
	static $config;

	if (!$config) {
		$config = opensid_get_db_config();
	}

	return isset($config[$key]) ? $config[$key] : null;
}

function opensid_get_db_config() {
	static $config;

	if (!isset($config['db_database'])) {
		$app_path = opensid_app_path();
		$db_config_file = opensid_get_option('sid_path') . opensid_local_config_path() . 'database.php';

		if (file_exists($db_config_file)) {
			$db['default'] = array();
			require $db_config_file;

			foreach ($db['default'] as $key => $val) {
				$config["db_$key"] = $val;
			}
		}
	}
	return $config;
}
