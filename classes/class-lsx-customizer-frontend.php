<?php
/**
 * LSX_Customizer_Frontend
 *
 * @package   lsx-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Customizer_Frontend' ) ) {

	/**
	 * Front-end class.
	 *
	 * @package LSX_Customizer_Frontend
	 * @author  LightSpeed
	 */
	class LSX_Customizer_Frontend extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ), 9999 );
		}

		/**
		 * Enques the assets.
		 *
		 * @since 1.0.0
		 */
		public function assets() {
			if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
				$min = '';
			} else {
				$min = '.min';
			}

			wp_enqueue_script( 'lsx_customizer', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer' . $min . '.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx_customizer', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx_customizer', LSX_CUSTOMIZER_URL . 'assets/css/lsx-customizer.css', array(), LSX_CUSTOMIZER_VER );
		}

	}

	new LSX_Customizer_Frontend;

}
