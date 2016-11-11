<?php
/**
 * LSX_Customizer_Admin
 *
 * @package   lsx-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Customizer_Admin' ) ) {

	/**
	 * Admin plugin class.
	 *
	 * @package LSX_Customizer_Admin
	 * @author  LightSpeed
	 */
	class LSX_Customizer_Admin extends LSX_Customizer {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		}

		/**
		 * Enques the assets
		 */
		public function assets() {
			if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
				$min = '';
			} else {
				$min = '.min';
			}

			wp_enqueue_script( 'lsx_customizer_admin', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer-admin' . $min . '.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_admin_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx_customizer_admin', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx_customizer_admin', LSX_CUSTOMIZER_URL . 'assets/css/lsx-customizer-admin.css', array(), LSX_CUSTOMIZER_VER );
		}

	}

	new LSX_Customizer_Admin();

}
