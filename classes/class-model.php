<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
abstract class OpenSID_Model {
	protected $db;
	public function __construct() {
		
		$this->db =& opensid_ci_load_database();
	}
} // class OpenSID_Model
