<?php
/*
 * Plugin Name:	LSX Customizer
 * Plugin URI:	https://www.lsdev.biz/product/
 * Description:	The LSX Customizer gives you additional layout options on your LSX powered web site.
 * Author:		LightSpeed
 * Version: 	1.1.0
 * Author URI: 	https://www.lsdev.biz/products/
 * License: 	GPL2+
 * Text Domain: lsx-customizer
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_CUSTOMIZER_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_CUSTOMIZER_CORE', __FILE__ );
define( 'LSX_CUSTOMIZER_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_CUSTOMIZER_VER', '1.1.0' );

/**
 * Runs once when the plugin is activated.
 */
function lsx_customizer_activate_plugin() {
	// Insert code here
}
register_activation_hook( __FILE__, 'lsx_customizer_activate_plugin' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer.php' );
