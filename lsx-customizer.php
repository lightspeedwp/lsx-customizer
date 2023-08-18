<?php
/**
 * Plugin Name: LSX Customizer
 * Plugin URI:  https://www.lsdev.biz/product/lsx-site-customizer/
 * Description: The LSX Customizer extension gives you complete control over the appearance of your LSX-powered WordPress site
 * Version:     1.5.4
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
define( 'LSX_CUSTOMIZER_VER', '1.5.4' );

/* ======================= Below is the Plugin Class init ========================= */

require_once LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer.php';

if ( in_array( 'wordpress-seo/wp-seo.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || in_array( 'wordpress-seo-premium/wp-seo-premium.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require LSX_CUSTOMIZER_PATH  . 'includes/yoast/class-lsx-yoast.php';
}

if ( class_exists( 'Tribe__Events__Main' ) ) {
	require LSX_CUSTOMIZER_PATH  . 'includes/the-events-calendar/the-events-calendar.php';
}

if ( class_exists( 'Sensei_Main' ) || class_exists( 'Sensei_WC' ) ) {
	require LSX_CUSTOMIZER_PATH  . 'includes/sensei/class-lsx-sensei.php';
}

if ( class_exists( 'Popup_Maker' ) ) {
	require LSX_CUSTOMIZER_PATH  . 'includes/popup-maker/class-lsx-popup-maker.php';
}

if ( class_exists( 'bbPress' ) ) {
	require LSX_CUSTOMIZER_PATH  . 'includes/bbpress/bbpress.php';
}
