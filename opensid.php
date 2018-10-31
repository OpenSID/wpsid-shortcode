<?php
/**
 * @package WPSID
 */
/**
 * Plugin Name: WPSID Shortcode
 * Plugin URI: http://www.siini.com/wordpress/plugins/wpsid-shortcode/
 * Description: Integrate OpenSID and SID to Wrodpress.
 * Author: Simasta
 * Author URI: http://simasta.siini.com
 * Version: 1.0.9.2
 * Text Domain: wpsid-shortcode
 * Domain Path: /locale/
 * Network: false
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0
 */

/**
 *	Copyright (C) 2017 Simasta (email: masta@siini.com)
 *
 *	This program is free software; you can redistribute it and/or
 *	modify it under the terms of the GNU General Public License
 *	as published by the Free Software Foundation; either version 2
 *	of the License, or (at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

// Define certain plugin variables as constants.
define( 'OPENSID__FILE__', __FILE__ );
define('WPSID_DIR', __DIR__ .'/');

require __DIR__ .'/functions.php';
add_action( 'init', array('WPSID', 'run') );
