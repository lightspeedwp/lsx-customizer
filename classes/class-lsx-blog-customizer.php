<?php
/**
 * LSX_Blog_Customizer
 *
 * @package   lsx-blog-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Blog_Customizer' ) ) {

	/**
	 * Main plugin class.
	 *
	 * @package LSX_Blog_Customizer
	 * @author  LightSpeed
	 */	
	class LSX_Blog_Customizer {

		/**
		 * Plugin slug
		 *
		 * @var string
		 */
		public $plugin_slug = 'lsx-blog-customizer';

		/**
		 * Constructor
		 */
		public function __construct() {
			require_once( LSX_BLOG_CUSTOMIZER_PATH . '/classes/class-lsx-blog-customizer-admin.php' );
			require_once( LSX_BLOG_CUSTOMIZER_PATH . '/classes/class-lsx-blog-customizer-frontend.php' );
		}

	}

	new LSX_Blog_Customizer();

}
