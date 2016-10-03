<?php
/*
 * Plugin Name:	LSX Blog Customizer
 * Plugin URI:	https://www.lsdev.biz/product/
 * Description:	This extension gives you control over the appearance of the blog on your LSX-powered WordPress site.
 * Author:		LightSpeed
 * Version: 	1.0.0
 * Author URI: 	https://www.lsdev.biz/products/
 * License: 	GPL2+
 * Text Domain: lsx-blog-customizer
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LSX_BLOG_CUSTOMIZER_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSX_BLOG_CUSTOMIZER_CORE', __FILE__ );
define( 'LSX_BLOG_CUSTOMIZER_URL', plugin_dir_url( __FILE__ ) );
define( 'LSX_BLOG_CUSTOMIZER_VER', '1.0.0' );

/**
 * Runs once when the plugin is activated.
 */
function lsx_blog_customizer_activate_plugin() {
	// Insert code here
}
register_activation_hook( __FILE__, 'lsx_blog_customizer_activate_plugin' );

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_BLOG_CUSTOMIZER_PATH . '/classes/class-lsx-blog-customizer.php' );
