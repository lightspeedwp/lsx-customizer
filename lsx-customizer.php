<?php
/**
 * Plugin Name: LSX Customizer
 * Plugin URI:  https://www.lsdev.biz/product/lsx-site-customizer/
 * Description: The LSX Customizer extension gives you complete control over the appearance of your LSX-powered WordPress site
 * Version:     1.5.0
 * Author:      LightSpeed
 * Author URI:  https://www.lsdev.biz/
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: lsx-customizer
 * Domain Path: /languages
 *
 * @package lsx-customizer
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_CUSTOMIZER_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_CUSTOMIZER_CORE', __FILE__ );
define( 'LSX_CUSTOMIZER_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_CUSTOMIZER_VER', '1.5.0' );


/* ======================= Below is the Plugin Class init ========================= */

require_once LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer.php';
