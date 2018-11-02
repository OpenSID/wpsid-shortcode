<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
abstract class OpenSID_Shortcode {
	public $db;
	
	public $model_opensid;
	public $setting;
	
	public function __construct() {
		$this->db =& opensid_ci_load_database();
	
		$setting = array();
		foreach( $this->db->order_by('key')->get("setting_aplikasi")->result() as $p )
			$setting[addslashes($p->key)] = addslashes($p->value);
		$this->setting = (object)$setting;
		
	}
	public function setup( $action, array $data ) {
		
		$this->frontend_page = OpenSID::load_class( 'OpenSID_Frontend_Page', 'class-frontend-page.php', 'classes' );
		
		$this->frontend_page->enqueue_style_opensid( 'front/css/first' );
		
	}
} // class OpenSID_Shortcode
