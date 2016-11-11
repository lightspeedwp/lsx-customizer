<?php
/**
 * LSX_Customizer
 *
 * @package   lsx-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Customizer' ) ) {

	/**
	 * Main plugin class.
	 *
	 * @package LSX_Customizer
	 * @author  LightSpeed
	 */	
	class LSX_Customizer {

		/**
		 * Plugin slug
		 *
		 * @var string
		 */
		public $plugin_slug = 'lsx-customizer';

		/**
		 * Constructor
		 */
		public function __construct() {
			require_once( LSX_CUSTOMIZER_PATH . '/classes/class-lsx-customizer-admin.php' );
			require_once( LSX_CUSTOMIZER_PATH . '/classes/class-lsx-customizer-frontend.php' );
			require_once( LSX_CUSTOMIZER_PATH . '/classes/class-lsx-customizer-customizer.php' );
		}

		/**
		 * Sanitize checkbox
		 */
		public function sanitize_checkbox( $input ) {
			return ( 1 === absint( $input ) ) ? 1 : 0;
		}

	}

	new LSX_Customizer();

}
