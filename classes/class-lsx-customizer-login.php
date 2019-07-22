<?php
if ( ! class_exists( 'LSX_Customizer_Login' ) ) {

	/**
	 * LSX Customizer Login Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2019 LightSpeed
	 */
	class LSX_Customizer_Login extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			wp_enqueue_style( 'login-style', get_template_directory_uri() . '/assets/css/lsx-customizer.css' ); 
		}

	}

	new LSX_Customizer_Login;

}
