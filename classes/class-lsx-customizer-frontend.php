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
			add_action( 'wp_enqueue_scripts', array( $this, 'lsx_customizer_color_palette_css' ), 2999 );
			add_action( 'wp', array( $this, 'layout' ), 2999 );
			add_action( 'wp', array( $this, 'lsx_distraction_free_checkout' ), 2999 );
			add_action( 'wp', array( $this, 'lsx_customizer_two_step_checkout' ) );
			add_action( 'after_setup_theme', array( $this, 'lsx_customizer_color_palette_setup' ), 100 );
		}

		/**
		 * Enques the assets.
		 *
		 * @since 1.0.0
		 */
		public function assets() {
			wp_enqueue_script( 'lsx-customizer', LSX_CUSTOMIZER_URL  . 'assets/js/lsx-customizer.min.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx-customizer', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx-customizer', LSX_CUSTOMIZER_URL  . 'assets/css/lsx-customizer.css', array(), LSX_CUSTOMIZER_VER );
			wp_style_add_data( 'lsx-customizer', 'rtl', 'replace' );

			$two_step_checkout = get_theme_mod( 'lsx_two_step_checkout', false );
			if ( class_exists( 'WooCommerce' ) && function_exists( 'is_checkout' ) && is_checkout() && ! empty( $two_step_checkout ) ) {

				wp_enqueue_script( 'flexslider', LSX_CUSTOMIZER_URL  . 'assets/js/jquery.flexslider.min.js', array( 'jquery' ), '2.5.0' );
			}

		}

		/**
		 * Enqueues front-end colour palette CSS.
		 *
		 * @since 1.0.0
		 */
		public function lsx_customizer_color_palette_css() {
			$styles = '
			.container #primary.content-area .has-primary-color-background-color {
				background-color:' . get_theme_mod( 'primary_colour', '#428bca' ) . ';
			}
			.container #primary.content-area .has-primary-color-color {
				color: ' . get_theme_mod( 'primary_colour', '#428bca' ) . ';
			}

			.container #primary.content-area .has-strong-primary-color-background-color {
				background-color:' . get_theme_mod( 'strong_primary_colour', '#2a6496' ) . ';
			}
			.container #primary.content-area .has-strong-primary-color-color {
				color: ' . get_theme_mod( 'strong_primary_colour', '#2a6496' ) . ';
			}

			.container #primary.content-area .has-cta-color-background-color {
				background-color:' . get_theme_mod( 'call_to_action_colour', '#f7941d' ) . ';
			}
			.container #primary.content-area .has-cta-color-color {
				color: ' . get_theme_mod( 'call_to_action_colour', '#f7941d' ) . ';
			}

			.container #primary.content-area .has-strong-cta-color-background-color {
				background-color:' . get_theme_mod( 'strong_cta_colour', '#f7741d' ) . ';
			}
			.container #primary.content-area .has-strong-cta-color-color {
				color: ' . get_theme_mod( 'strong_cta_colour', '#f7741d' ) . ';
			}

			.container #primary.content-area .has-strong-cta-color-background-color {
				background-color:' . get_theme_mod( 'strong_cta_colour', '#f7741d' ) . ';
			}
			.container #primary.content-area .has-strong-cta-color-color {
				color: ' . get_theme_mod( 'strong_cta_colour', '#f7741d' ) . ';
			}

			.container #primary.content-area .has-secondary-color-background-color {
				background-color:' . get_theme_mod( 'secondary_colour', '#eaeaea' ) . ';
			}
			.container #primary.content-area .has-secondary-color-color {
				color: ' . get_theme_mod( 'secondary_colour', '#eaeaea' ) . ';
			}

			.container #primary.content-area .has-strong-secondary-color-background-color {
				background-color:' . get_theme_mod( 'strong_secondary_colour', '#c4c4c4' ) . ';
			}
			.container #primary.content-area .has-strong-secondary-color-color {
				color: ' . get_theme_mod( 'strong_secondary_colour', '#c4c4c4' ) . ';
			}

			.container #primary.content-area .has-tertiary-color-background-color {
				background-color:' . get_theme_mod( 'tertiary_colour', '#6BA913' ) . ';
			}
			.container #primary.content-area .has-tertiary-color-color {
				color: ' . get_theme_mod( 'tertiary_colour', '#6BA913' ) . ';
			}

			.container #primary.content-area .has-strong-tertiary-color-background-color {
				background-color:' . get_theme_mod( 'strong_tertiary_colour', '#3F640B' ) . ';
			}
			.container #primary.content-area .has-strong-tertiary-color-color {
				color: ' . get_theme_mod( 'strong_tertiary_colour', '#3F640B' ) . ';
			}

			.container #primary.content-area .has-heading-color-background-color {
				background-color:' . get_theme_mod( 'heading_colour', '#4a4a4a' ) . ';
			}
			.container #primary.content-area .has-heading-color-color {
				color: ' . get_theme_mod( 'heading_colour', '#4a4a4a' ) . ';
			}

			.container #primary.content-area .has-body-color-background-color {
				background-color:' . get_theme_mod( 'body_text_color_colour', '#444444' ) . ';
			}
			.container #primary.content-area .has-body-color-color {
				color: ' . get_theme_mod( 'body_text_color_colour', '#444444' ) . ';
			}

			';
			wp_add_inline_style( 'lsx-customizer', $styles );
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

			if ( class_exists( 'WooCommerce' ) && function_exists( 'is_checkout' ) && is_checkout() && ! empty( $distraction_free ) ) {
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

			if ( class_exists( 'WooCommerce' ) && function_exists( 'is_checkout' ) && is_checkout() && ! empty( $two_step_checkout ) ) {
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

		/**
		 * Editor color palette.
		 *
		 * @return void
		 */
		public function lsx_customizer_color_palette_setup() {
			add_theme_support( 'editor-color-palette', array(
				array(
					'name'  => esc_html__( 'Primary Colour', 'lsx-customizer' ),
					'slug'  => 'primary-color',
					'color' => get_theme_mod( 'primary_colour', '#428bca' ),
				),
				array(
					'name'  => esc_html__( 'Strong Primary Colour', 'lsx-customizer' ),
					'slug'  => 'strong-primary-color',
					'color' => get_theme_mod( 'strong_primary_colour', '#2a6496' ),
				),
				array(
					'name'  => esc_html__( 'CTA Colour', 'lsx-customizer' ),
					'slug'  => 'cta-color',
					'color' => get_theme_mod( 'call_to_action_colour', '#f7941d' ),
				),
				array(
					'name'  => esc_html__( 'Strong CTA Colour', 'lsx-customizer' ),
					'slug'  => 'strong-cta-color',
					'color' => get_theme_mod( 'strong_cta_colour', '#f7741d' ),
				),
				array(
					'name'  => esc_html__( 'Secondary Colour', 'lsx-customizer' ),
					'slug'  => 'secondary-color',
					'color' => get_theme_mod( 'secondary_colour', '#eaeaea' ),
				),
				array(
					'name'  => esc_html__( 'Strong Secondary Colour', 'lsx-customizer' ),
					'slug'  => 'strong-secondary-color',
					'color' => get_theme_mod( 'strong_secondary_colour', '#c4c4c4' ),
				),
				array(
					'name'  => esc_html__( 'Tertiary Colour', 'lsx-customizer' ),
					'slug'  => 'tertiary-color',
					'color' => get_theme_mod( 'tertiary_colour', '#6BA913' ),
				),
				array(
					'name'  => esc_html__( 'Strong Tertiary Colour', 'lsx-customizer' ),
					'slug'  => 'strong-tertiary-color',
					'color' => get_theme_mod( 'strong_tertiary_colour', '#3F640B' ),
				),
				array(
					'name'  => esc_html__( 'White', 'lsx-customizer' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				),
				array(
					'name'  => esc_html__( 'Black', 'lsx-customizer' ),
					'slug'  => 'black',
					'color' => '#000000',
				),
			));
		}

	}

	new LSX_Customizer_Frontend();

}
