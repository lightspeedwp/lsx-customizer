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

/* ======================= The API Classes ========================= */
if(!class_exists('LSX_API_Manager')){
	require_once('classes/class-lsx-api-manager.php');
}

/**
 * Runs once when the plugin is activated.
 */
function lsx_customizer_activate_plugin() {
	$lsx_to_password = get_option('lsx_api_instance',false);
	if(false === $lsx_to_password){
		update_option('lsx_api_instance',LSX_API_Manager::generatePassword());
	}
}
register_activation_hook( __FILE__, 'lsx_customizer_activate_plugin' );

/**
 *	Grabs the email and api key from the LSX Customizer Settings.
 */
function lsx_customizer_options_pages_filter($pages){
	$pages[] = 'lsx-settings';
	$pages[] = 'to-settings';
	return $pages;
}
add_filter('lsx_api_manager_options_pages','lsx_customizer_options_pages_filter',10,1);

function lsx_customizer_api_admin_init(){
	global $lsx_customizer_api_manager;
	if(class_exists('Tour_Operator')) {
		$options = get_option('_to_settings', false);
	}else{
		$options = get_option('_lsx_settings', false);
		if (false === $options) {
			$options = get_option('_lsx_lsx-settings', false);
		}
	}

	$data = array('api_key'=>'','email'=>'');

	if(false !== $options && isset($options['api'])){
		if(isset($options['api']['lsx-customizer_api_key']) && '' !== $options['api']['lsx-customizer_api_key']){
			$data['api_key'] = $options['api']['lsx-customizer_api_key'];
		}
		if(isset($options['api']['lsx-customizer_email']) && '' !== $options['api']['lsx-customizer_email']){
			$data['email'] = $options['api']['lsx-customizer_email'];
		}
	}

	$instance = get_option( 'lsx_api_instance', false );
	if(false === $instance){
		$instance = LSX_API_Manager::generatePassword();
	}

	$api_array = array(
		'product_id'	=>		'LSX Customizer',
		'version'		=>		'1.0.0',
		'instance'		=>		$instance,
		'email'			=>		$data['email'],
		'api_key'		=>		$data['api_key'],
		'file'			=>		'lsx-customizer.php'
	);
	$lsx_customizer_api_manager = new LSX_API_Manager($api_array);
}
add_action('admin_init','lsx_customizer_api_admin_init');

/* ======================= Below is the Plugin Class init ========================= */

require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer.php' );
