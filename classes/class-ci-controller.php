<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class Web_Controller {
	public $load;
		
	public function __construct(){
		$this->load = new OPENSID___FAKE_LOAD;
	}
	
	function controller($var){
		return $var;
	}
}	