<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class CI_Views {
	public $load;
		
	public function __construct(){
		$this->load = new OPENSID___FAKE_LOAD;
	}
	
	function view($var){
		return $var;
	}
}	