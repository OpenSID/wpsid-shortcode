<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class CI_Model {
	public $db;
	public $load;
	public $input;
	public $database;
	public function __construct(){
		$this->db =& opensid_ci_load_database();
		$this->load = new OPENSID___FAKE_LOAD;
		include_once OPENSID_APPPATH . '/donjo-sys/core/Input.php';
		$this->input = new CI_Input;
	}
	
	function model($var){
		return $var;
	}
	function database($var){
		return $var;
	}
}	