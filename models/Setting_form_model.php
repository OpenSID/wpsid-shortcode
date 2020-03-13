<?php
namespace wpsid;

use WPSID;

class Setting_form_model
{
	function filter_input($input) {
		$new_input = array();

		if( isset($input['sid_path']) )
			$new_input['sid_path'] = realpath((sanitize_text_field($input['sid_path']) != '') ? sanitize_text_field($input['sid_path']) : ABSPATH . 'opensid');

		if( isset($input['sid_home']) )
			$new_input['sid_home'] = $this->remove_end_slash(((sanitize_text_field($input['sid_home']) != '') ? sanitize_text_field($input['sid_home']) : esc_url(site_url() . '/opensid')));

		if( isset($input['mandiri_page']) )
			$new_input['mandiri_page'] = ((sanitize_text_field($input['mandiri_page']) != '') ? sanitize_text_field($input['mandiri_page']) : 2);

		return $new_input;
	}

	function remove_end_slash($string) {
		return rtrim($string, '/\\');
	}

	function get_section($name) {
		return __('Set path for Opensid / SID.', 'wpsid-shortcode');
	}

	function get_field($name) {
		switch($name) {
			case 'sid_path':
				return sprintf(
					'<input type="text" id="sid_path" name="%s[sid_path]" value="%s" style="%s" /><p class="description">%s</p>',
					WPSID::OPTION_KEY,
					esc_attr(WPSID::config('sid_path')),
					esc_attr('width: 60%'),
					esc_attr(__('Default', 'wpsid-shortcode') .': '.  ABSPATH . 'opensid') // whithout trailing slashes
				);

			case 'sid_home':
				return sprintf(
					'<input type="text" id="sid_home" name="%s[sid_home]" value="%s" style="%s" /><p class="description">%s</p>',
					WPSID::OPTION_KEY,
					esc_attr(WPSID::config('sid_home')),
					esc_attr('width: 60%'),
					esc_attr(__('Default', 'wpsid-shortcode') . ': ' .  esc_url( site_url() . '/opensid' ) ) // whithout trailing slashes
				);

			case 'mandiri_page':
				return sprintf(
					'%s<p class="description">%s</p>',
					wp_dropdown_pages(
						array(
							'id' => 'mandiri_page',
							'name' => WPSID::OPTION_KEY . '[mandiri_page]',
							'echo' => 0,
							'show_option_none' => __('&mdash; Select &mdash;'),
							'option_none_value' => '0',
							'selected' => WPSID::config('mandiri_page')
						)
					),
					esc_attr( __('Page for Layanan Mandiri. Use shortcode `[wpsid_layanan_mandiri_detail]` in this page.', 'wpsid-shortcode') )
				);
		}
	}
}
