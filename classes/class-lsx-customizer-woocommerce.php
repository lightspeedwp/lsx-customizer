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

			$wp_customize->add_section( 'lsx-wc-cart' , array(
				'title'       => esc_html__( 'Cart', 'lsx-customizer' ),
				'description' => esc_html__( 'Change the WooCommerce cart settings.', 'lsx-customizer' ),
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
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_layout', array(
				'label'       => esc_html__( 'Checkout Layout', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce checkout layout.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_layout',
				'type'        => 'select',
				'choices'     => array(
					'default' => esc_html__( 'Default', 'lsx-customizer' ),
					'stacked' => esc_html__( 'Stacked', 'lsx-customizer' ),
					'columns' => esc_html__( 'Columns', 'lsx-customizer' ),
				),
			) ) );

			$wp_customize->add_setting( 'lsx_wc_checkout_thankyou_page', array(
				'default' => '0',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$choices = array(
				'0' => esc_html__( 'Default', 'lsx-customizer' ),
			);

			$pages = get_pages();

			foreach ( $pages as $key => $page ) {
				$choices[ $page->ID ] = $page->post_title;
			}

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_thankyou_page', array(
				'label'       => esc_html__( 'Checkout Thank You', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce checkout thank you page.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_thankyou_page',
				'type'        => 'select',
				'choices'     => $choices,
			) ) );

			$wp_customize->add_setting( 'lsx_wc_checkout_extra_html', array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'sanitize_textarea' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_extra_html', array(
				'label'       => esc_html__( 'Extra Checkout HTML', 'lsx-customizer' ),
				'description' => esc_html__( 'Extra HTML to display at checkout page (bottom/right).', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_extra_html',
				'type'        => 'textarea',
			) ) );

			$wp_customize->add_setting( 'lsx_wc_cart_extra_html', array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'sanitize_textarea' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_cart_extra_html', array(
				'label'       => esc_html__( 'Extra Cart HTML', 'lsx-customizer' ),
				'description' => esc_html__( 'Extra HTML to display at cart page (bottom/left).', 'lsx-customizer' ),
				'section'     => 'lsx-wc-cart',
				'settings'    => 'lsx_wc_cart_extra_html',
				'type'        => 'textarea',
			) ) );
		}

	}

	new LSX_Customizer_WooCommerce;

}
