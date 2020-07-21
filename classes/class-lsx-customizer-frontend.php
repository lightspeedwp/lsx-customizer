<?php
if ( ! class_exists( 'LSX_Customizer_Frontend' ) ) {

	/**
	 * LSX Customizer Frontend Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Frontend extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ), 2999 );
			add_action( 'wp', array( $this, 'layout' ), 2999 );
			add_action( 'wp', array( $this, 'lsx_distraction_free_checkout' ), 2999 );
			add_action( 'wp', array( $this, 'lsx_customizer_two_step_checkout' ) );
		}

		/**
		 * Enques the assets.
		 *
		 * @since 1.0.0
		 */
		public function assets() {
			wp_enqueue_script( 'lsx-customizer', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer.min.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx-customizer', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx-customizer', LSX_CUSTOMIZER_URL . 'assets/css/lsx-customizer.css', array(), LSX_CUSTOMIZER_VER );
			wp_style_add_data( 'lsx-customizer', 'rtl', 'replace' );

			$two_step_checkout = get_theme_mod( 'lsx_two_step_checkout', false );
			if ( is_checkout() && ! empty( $two_step_checkout ) ) {

				wp_enqueue_script( 'flexslider', LSX_CUSTOMIZER_URL . 'assets/js/jquery.flexslider.min.js', array( 'jquery' ), '2.5.0' );
			}

		}

		/**
		 * Layout.
		 *
		 * @since 1.0.0
		 */
		public function layout() {
			$theme_credit = get_theme_mod( 'lsx_theme_credit_status', true );

			if ( false == $theme_credit ) {
				add_filter( 'lsx_credit_link', '__return_false' );
			}
		}

		/**
		 * Create the distraction free checkout.
		 *
		 * @since 1.0.0
		 * @return  void
		 */
		public function lsx_distraction_free_checkout() {

			$distraction_free = get_theme_mod( 'lsx_distraction_free_checkout', false );

			if ( is_checkout() && ! empty( $distraction_free ) ) {
				remove_action( 'lsx_body_bottom', 'lsx_wc_footer_bar', 15 );

			}
		}

		/**
		 * Create the two step checkout.
		 *
		 * @since   1.0.0
		 * @return  void
		 */
		public function lsx_customizer_two_step_checkout() {
			$two_step_checkout = get_theme_mod( 'lsx_two_step_checkout', false );

			if ( is_checkout() && ! empty( $two_step_checkout ) ) {
				add_action( 'woocommerce_checkout_before_customer_details', 'lsx_customizer_checkout_form_wrapper_div', 1 );
				add_action( 'woocommerce_checkout_before_customer_details', 'lsx_customizer_checkout_form_wrapper', 2 );
				add_action( 'woocommerce_checkout_order_review', 'lsx_customizer_close_div', 30 );
				add_action( 'woocommerce_checkout_order_review', 'lsx_customizer_close_ul', 30 );
				add_action( 'woocommerce_checkout_before_customer_details', 'lsx_customizer_address_wrapper', 5 );
				add_action( 'woocommerce_checkout_after_customer_details', 'lsx_customizer_close_li' );
				add_action( 'wp_footer', 'lsx_customizer_fire_flexslider' );
				add_action( 'woocommerce_checkout_before_order_review', 'lsx_customizer_order_review_wrap', 1 );
				add_action( 'woocommerce_checkout_after_order_review', 'lsx_customizer_close_li', 40 );
			}
		}

	}

	new LSX_Customizer_Frontend;

}
