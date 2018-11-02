<?php
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class OpenSID_Admin_Controller extends OpenSID_Controller {
	private $options;
	function __construct() {
		parent::__construct();
		
		add_action( 'admin_menu', array( &$this, 'set_admin_menu' ) );
		add_action( 'admin_init', array( &$this, 'set_page_main' ) );
	}
	function set_admin_menu() {
		add_menu_page( __( 'WPSID', 'wpsid-shortcode'), __( 'WPSID', 'wpsid-shortcode'), 'manage_options', 'wpsid', array( &$this, 'page_main' ) );
		add_submenu_page( 'wpsid', __( 'Config', 'wpsid-shortcode'), __( 'Config', 'wpsid-shortcode'), 'manage_options', 'wpsid', array( &$this, 'page_main' ) );
		add_submenu_page( 'wpsid', __( 'Shortcodes', 'wpsid-shortcode'), __( 'Shortcodes', 'wpsid-shortcode'), 'manage_options', 'wpsid-shortcode', array( &$this, 'page_shortcode' ) );
		add_submenu_page( 'wpsid', __( 'About', 'wpsid-shortcode'), __( 'About', 'wpsid-shortcode'), 'manage_options', 'wpsid-about', array( &$this, 'page_about' ) );
	}
	function page_shortcode() {
		echo '<div class="wrap">
			<div id="icon-tools" class="icon32"><br /></div>
			<h1>' .  __( 'Shortcodes List', 'wpsid-shortcode') . '</h1>
			<p>
			<br> [wpsid_data_wilayah]
			<br> [wpsid_version[ type="plain|html"]]
			<br> [wpsid_data_pendidikan[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_pekerjaan[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_perkawinan[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_agama[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_jenis_kelamin[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_warga_negara[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_status_penduduk[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_golongan_darah[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_cacat[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_menahun[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_umur[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_pendidikan_sedang_ditempuh[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_cara_kb[ type="tabel|grafik|pie"]]
			<br> [wpsid_data_akta_kelahiran[ type="tabel|grafik|pie"]]
			<br> [wpsid_layanan_mandiri_widget] *New
			<br> [wpsid_layanan_mandiri_detail] *New
			</p>
		</div><!-- .wrap -->';
	}
	
	function page_about() {
		echo '<div class="wrap">
			<div id="icon-tools" class="icon32"><br /></div>
			<h1>' .  __( 'About WPSID', 'wpsid-shortcode') . '</h1>
			<p>WPSID Shortcode integrate OpenSID and SID to Wrodpress with shortcodes. </p>
			<p>You can display statistics data from OpenSID and SID into wordpress. Visit <a href="http://wpsid-shortcode.plugin.demo.siini.com/"><b>http://wpsid-shortcode.plugin.demo.siini.com</b></a>.</p>
			<p>If you find this useful, <a href="http://www.siini.com/wordpress/plugins/wpsid-shortcode/"><b>please consider donating</b></a> whatever sum you choose, <b>even just 10 cents</b></p>
			<p>For report issue or request feature, please visit:</p>
			<ul>
				<ol><a target="_blank" href="http://github.com/simasta/wpsid-shortcode/">Github repository</a></ol>
				<ol><a target="_blank" href="https://wordpress.org/support/plugin/wpsid-shortcode">Support plugin</a></ol>
			</ul>
			
		</div><!-- .wrap -->';
	}
	public function page_main() {
		global $current_user;
		
		if( opensid_check_database_connection() == false )
			add_settings_error('opensid_error_sid_path', '', __('DB connection filed', 'wpsid-shortcode'), 'error');
		
		if( opensid_check_sid_path() == false )
			add_settings_error('opensid_error_sid_path', '', __('SID Path is not directory', 'wpsid-shortcode'), 'error');
			
		settings_errors();
		
		echo '
		<div class="wrap">
			<div id="icon-tools" class="icon32"><br /></div>
			<h1>' .  __( 'WPSID Config', 'wpsid-shortcode') . '</h1>
			<form method="post" action="options.php">';
			$this->options = get_option( OPENSID_OPTION_KEY );
			
			
			 settings_fields( 'wpsid_option_group' );
			 do_settings_sections( 'wpsid-setting-admin' );
			 submit_button();
		echo '
			</form>
		</div><!-- .wrap -->';
	}
	public function set_page_main() {
		register_setting(
			'wpsid_option_group', // Option group
			OPENSID_OPTION_KEY, // Option name
			array( $this, 'callback_sanitize' ) // Sanitize
		);
		add_settings_section(
			'setting_section_id', // ID
			__( 'Database and Path', 'wpsid-shortcode' ), // Title
			array( $this, 'callback_section_info' ), // Callback
			'wpsid-setting-admin' // Page
		);  
		add_settings_field('db_name', __( 'DB Name', 'wpsid-shortcode'), array( $this, 'callback_db_name' ), 'wpsid-setting-admin', 'setting_section_id');
		add_settings_field('db_user', __( 'DB User', 'wpsid-shortcode'), array( $this, 'callback_db_user' ), 'wpsid-setting-admin', 'setting_section_id');
		add_settings_field('db_pass', __( 'DB Password', 'wpsid-shortcode'), array( $this, 'callback_db_pass' ), 'wpsid-setting-admin', 'setting_section_id');
		add_settings_field('db_host', __( 'DB Host', 'wpsid-shortcode'), array( $this, 'callback_db_host' ), 'wpsid-setting-admin', 'setting_section_id');
		
		add_settings_field('sid_path', __( 'SID Full Path', 'wpsid-shortcode'), array( $this, 'callback_sid_path' ), 'wpsid-setting-admin', 'setting_section_id');
		add_settings_field('sid_home', __( 'SID Home Url', 'wpsid-shortcode'), array( $this, 'callback_sid_home' ), 'wpsid-setting-admin', 'setting_section_id');
		add_settings_field('mandiri_page', __( 'Mandiri Page', 'wpsid-shortcode'), array( $this, 'callback_mandiri_page' ), 'wpsid-setting-admin', 'setting_section_id');
	}
	public function callback_sanitize( $input ) {
		$new_input = array();
		
		if( isset($input['db_name']) )
			$new_input['db_name'] = ((sanitize_text_field($input['db_name']) != '') ? sanitize_text_field($input['db_name']) : DB_NAME);
		if( isset($input['db_user']) )
			$new_input['db_user'] = ((sanitize_text_field($input['db_user']) != '') ? sanitize_text_field($input['db_user']) : DB_USER);
		if( isset($input['db_pass']) )
			$new_input['db_pass'] = ((sanitize_text_field($input['db_pass']) != '') ? sanitize_text_field($input['db_pass']) : DB_PASSWORD);
		if( isset($input['db_host']) )
			$new_input['db_host'] = ((sanitize_text_field($input['db_host']) != '') ? sanitize_text_field($input['db_host']) : DB_HOST);
		if( isset($input['sid_path']) )
			$new_input['sid_path'] = $this->remove_end_slash(((sanitize_text_field($input['sid_path']) != '') ? sanitize_text_field($input['sid_path']) : esc_attr(ABSPATH . 'opensid')));
		if( isset($input['sid_home']) )
			$new_input['sid_home'] = $this->remove_end_slash(((sanitize_text_field($input['sid_home']) != '') ? sanitize_text_field($input['sid_home']) : esc_url(site_url() . '/opensid')));
		if( isset($input['mandiri_page']) )
			$new_input['mandiri_page'] = ((sanitize_text_field($input['mandiri_page']) != '') ? sanitize_text_field($input['mandiri_page']) : 2);
		return $new_input;
	}
	public function remove_end_slash($string) {
		return rtrim($string, '/\\');
	}
	public function callback_section_info() {
	  print __( 'Set database connection and path for Opensid / SID.', 'wpsid-shortcode') . '<br />' . __('Status', 'wpsid-shortcode') . ': <b>' . ((OPENSID_READY) ? __('Ready', 'wpsid-shortcode') : __('Not ready', 'wpsid-shortcode')) . '</b>';
	}
	public function callback_id_number() {
		printf('<input type="text" id="id_number" name="%s[id_number]" value="%s" />',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['id_number'])
		);
	}
	public function callback_db_name() {
		printf('<input type="text" id="db_name" name="%s[db_name]" value="%s" />',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['db_name'])
		);
	}
	public function callback_db_user() {
		printf('<input type="text" id="db_user" name="%s[db_user]" value="%s" />',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['db_user'])
		);
	}
	public function callback_db_pass() {
		printf('<input type="text" id="db_pass" name="%s[db_pass]" value="%s" />',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['db_pass'])
		);
	}
	public function callback_db_host() {
		printf('<input type="text" id="db_host" name="%s[db_host]" value="%s" />',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['db_host'])
		);
	}
	public function callback_sid_path() {
		printf('<input type="text" id="sid_path" name="%s[sid_path]" value="%s" style="%s" /><p class="description">%s</p>',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['sid_path']), 
			esc_attr( 'width: 60%' ),
			esc_attr( __('Default', 'wpsid-shortcode') . ': ' .  ABSPATH . 'opensid') // whithout trailing slashes
		);
	}
	
	public function callback_sid_home() {
		printf('<input type="text" id="sid_home" name="%s[sid_home]" value="%s" style="%s" /><p class="description">%s</p>',
			OPENSID_OPTION_KEY,
			esc_attr( $this->options['sid_home']),
			esc_attr( 'width: 60%' ),
			esc_attr( __('Default', 'wpsid-shortcode') . ': ' .  esc_url( site_url() . '/opensid' ) ) // whithout trailing slashes
		);
	}
	public function callback_mandiri_page() {
		printf(('%s<p class="description">%s</p>' ),
			wp_dropdown_pages(
				array(
					'id' => 'mandiri_page',
					'name' => OPENSID_OPTION_KEY . '[mandiri_page]',
					'echo' => 0,
					'show_option_none' => __('&mdash; Select &mdash;'),
					'option_none_value' => '0',
					'selected' =>$this->options['mandiri_page']
				)
			),
			esc_attr( __('Page for Layanan Mandiri. Use shortcode `[wpsid_layanan_mandiri_detail]` in this page.', 'wpsid-shortcode') )
		);
	}
} // class OpenSID_Admin_Controller
