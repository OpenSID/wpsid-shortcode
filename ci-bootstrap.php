<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
$application_folder = OPENSID_APPPATH . '/donjo-app';
$system_path = OPENSID_APPPATH . '/system/';
if ( ! defined( 'BASEPATH' ) )
	define( 'BASEPATH', str_replace( "\\", "/", OPENSID_APPPATH . '/system/' ) );
if ( ! defined( 'APPPATH' ) ) {
	if ( is_dir( $application_folder ) ) {
		define( 'APPPATH', $application_folder . '/' );
	} else {
		if ( ! is_dir( BASEPATH . $application_folder . '/' ) ) {
			$errmsg = "Your application folder path $application_folder does not appear to be set correctly.";
		}
		define( 'APPPATH', BASEPATH . $application_folder . '/' );
	}
}
include_once OPENSID_APPPATH . '/system/core/Common.php';
include_once OPENSID_APPPATH . '/system/database/DB.php';
function &opensid_ci_load_database($active_record_override = true) {
	$database =& DB( OPENSID_CONNECT, $active_record_override );
	return $database;
}
class OPENSID___FAKE_LOAD {
	function model() {
		return true;
	}
}
global $SEC, $CFG, $UNI;
include OPENSID_APPPATH . '/system/core/Security.php';
include OPENSID_APPPATH . '/system/core/Config.php';
include OPENSID_APPPATH . '/system/core/Utf8.php';

$SEC =new CI_Security;
$CFG =new CI_Config;
$UNI =new CI_Utf8;
function hash_pin($pin=""){
	$pin = strrev($pin);
	$pin = $pin*77;
	$pin .= "!#@$#%";
	$pin = md5($pin);
	return $pin;
}
function unpenetration($str){
	$str = str_replace("-","'", $str);
	return $str;
}
function tgl_indo_out($tgl){
	if($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = substr($tgl,5,2);
		$tahun = substr($tgl,0,4);
		return $tanggal.'-'.$bulan.'-'.$tahun;
	}
}
function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
}
function getBulan($bln){
			switch ($bln){
				case 1:
					return "Januari";
					break;
				case 2:
					return "Februari";
					break;
				case 3:
					return "Maret";
					break;
				case 4:
					return "April";
					break;
				case 5:
					return "Mei";
					break;
				case 6:
					return "Juni";
					break;
				case 7:
					return "Juli";
					break;
				case 8:
					return "Agustus";
					break;
				case 9:
					return "September";
					break;
				case 10:
					return "Oktober";
					break;
				case 11:
					return "November";
					break;
				case 12:
					return "Desember";
					break;
			}
	}
