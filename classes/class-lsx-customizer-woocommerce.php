<?php
if ( ! class_exists( 'LSX_Customizer_WooCommerce' ) ) {

	/**
	 * LSX Customizer WooCommerce Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_WooCommerce extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.1.1
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.1.1
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Sections.
			 */
			$wp_customize->add_section( 'lsx-wc-checkout' , array(
				'title'       => esc_html__( 'Checkout', 'lsx-customizer' ),
				'description' => esc_html__( 'Change the WooCommerce checkout settings.', 'lsx-customizer' ),
				'panel'       => 'lsx-wc',
			) );

			/**
			 * Fields.
			 */
			$wp_customize->add_setting( 'lsx_wc_checkout_steps', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_steps', array(
				'label'       => esc_html__( 'Checkout Steps', 'lsx-customizer' ),
				'description' => esc_html__( 'Enable the checkout steps header.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_steps',
				'type'        => 'checkbox',
			) ) );

			$wp_customize->add_setting( 'lsx_wc_checkout_layout', array(
				'default' => 'default',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_layout', array(
				'label'       => esc_html__( 'Checkout Steps', 'lsx-customizer' ),
				'description' => esc_html__( 'Enable the checkout steps header.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_layout',
				'type'        => 'select',
				'choices'     => array(
					'default' => esc_html__( 'Default', 'lsx-customizer' ),
					'stacked' => esc_html__( 'Stacked', 'lsx-customizer' ),
					'columns' => esc_html__( 'Columns', 'lsx-customizer' ),
				),
			) ) );
		}

	}

	new LSX_Customizer_WooCommerce;

}
