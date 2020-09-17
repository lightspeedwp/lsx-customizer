<?php
if ( ! class_exists( 'LSX_Customizer_Core' ) ) {

	/**
	 * LSX Customizer Core Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Core extends LSX_Customizer {

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
			/**
			 * Core section: Theme Credit
			 */
			$wp_customize->add_setting( 'lsx_theme_credit_status', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_theme_credit_status', array(
				'label'         => esc_html__( 'Theme Credit', 'lsx-customizer' ),
				// 'description'   => esc_html__( 'Displays theme credit in footer.', 'lsx-customizer' ),
				'section'       => 'lsx-layout',
				'settings'      => 'lsx_theme_credit_status',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );
		}

	}

	new LSX_Customizer_Core();

}
