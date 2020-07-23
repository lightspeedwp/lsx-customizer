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
			add_action( 'after_setup_theme', array( $this, 'lsx_customizer_color_palette_setup' ), 100 );
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
		}

		/**
		 * Enqueues front-end colour palette CSS.
		 *
		 * @since 1.0.0
		 */
		public function lsx_customizer_color_palette_css() {
			$styles = '
			.container #primary.content-area .has-primary-color-background-color {
				background-color:' . get_theme_mod( 'primary_color', '#428bca' ) . ';
			}
			.container #primary.content-area .has-primary-color-color {
				color: ' . get_theme_mod( 'primary_color', '#428bca' ) . ';
			}

			.container #primary.content-area .has-strong-primary-color-background-color {
				background-color:' . get_theme_mod( 'strong_primary_color', '#2a6496' ) . ';
			}
			.container #primary.content-area .has-strong-primary-color-color {
				color: ' . get_theme_mod( 'strong_primary_color', '#2a6496' ) . ';
			}

			.container #primary.content-area .has-cta-color-background-color {
				background-color:' . get_theme_mod( 'call_to_action_color', '#f7941d' ) . ';
			}
			.container #primary.content-area .has-cta-color-color {
				color: ' . get_theme_mod( 'call_to_action_color', '#f7941d' ) . ';
			}

			.container #primary.content-area .has-strong-cta-color-background-color {
				background-color:' . get_theme_mod( 'strong_cta_color', '#f7741d' ) . ';
			}
			.container #primary.content-area .has-strong-cta-color-color {
				color: ' . get_theme_mod( 'strong_cta_color', '#f7741d' ) . ';
			}

			.container #primary.content-area .has-strong-cta-color-background-color {
				background-color:' . get_theme_mod( 'strong_cta_color', '#f7741d' ) . ';
			}
			.container #primary.content-area .has-strong-cta-color-color {
				color: ' . get_theme_mod( 'strong_cta_color', '#f7741d' ) . ';
			}

			.container #primary.content-area .has-secondary-color-background-color {
				background-color:' . get_theme_mod( 'secondary_color', '#eaeaea' ) . ';
			}
			.container #primary.content-area .has-secondary-color-color {
				color: ' . get_theme_mod( 'secondary_color', '#eaeaea' ) . ';
			}

			.container #primary.content-area .has-strong-secondary-color-background-color {
				background-color:' . get_theme_mod( 'strong_secondary_color', '#c4c4c4' ) . ';
			}
			.container #primary.content-area .has-strong-secondary-color-color {
				color: ' . get_theme_mod( 'strong_secondary_color', '#c4c4c4' ) . ';
			}

			.container #primary.content-area .has-tertiary-color-background-color {
				background-color:' . get_theme_mod( 'tertiary_color', '#6BA913' ) . ';
			}
			.container #primary.content-area .has-tertiary-color-color {
				color: ' . get_theme_mod( 'tertiary_color', '#6BA913' ) . ';
			}

			.container #primary.content-area .has-strong-tertiary-color-background-color {
				background-color:' . get_theme_mod( 'strong_tertiary_color', '#3F640B' ) . ';
			}
			.container #primary.content-area .has-strong-tertiary-color-color {
				color: ' . get_theme_mod( 'strong_tertiary_color', '#3F640B' ) . ';
			}

			.container #primary.content-area .has-heading-color-background-color {
				background-color:' . get_theme_mod( 'heading_color', '#4a4a4a' ) . ';
			}
			.container #primary.content-area .has-heading-color-color {
				color: ' . get_theme_mod( 'heading_color', '#4a4a4a' ) . ';
			}

			.container #primary.content-area .has-body-color-background-color {
				background-color:' . get_theme_mod( 'body_text_color_color', '#444444' ) . ';
			}
			.container #primary.content-area .has-body-color-color {
				color: ' . get_theme_mod( 'body_text_color_color', '#444444' ) . ';
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
		 * Editor color palette.
		 *
		 * @return void
		 */
		public function lsx_customizer_color_palette_setup() {
			add_theme_support( 'editor-color-palette', array(
				array(
					'name'  => esc_html__( 'Primary Color', 'lsx-customizer' ),
					'slug'  => 'primary-color',
					'color' => get_theme_mod( 'primary_color', '#428bca' ),
				),
				array(
					'name'  => esc_html__( 'Strong Primary Color', 'lsx-customizer' ),
					'slug'  => 'strong-primary-color',
					'color' => get_theme_mod( 'strong_primary_color', '#2a6496' ),
				),
				array(
					'name'  => esc_html__( 'CTA Color', 'lsx-customizer' ),
					'slug'  => 'cta-color',
					'color' => get_theme_mod( 'call_to_action_color', '#f7941d' ),
				),
				array(
					'name'  => esc_html__( 'Strong CTA Color', 'lsx-customizer' ),
					'slug'  => 'strong-cta-color',
					'color' => get_theme_mod( 'strong_cta_color', '#f7741d' ),
				),
				array(
					'name'  => esc_html__( 'Secondary Color', 'lsx-customizer' ),
					'slug'  => 'secondary-color',
					'color' => get_theme_mod( 'secondary_color', '#eaeaea' ),
				),
				array(
					'name'  => esc_html__( 'Strong Secondary Color', 'lsx-customizer' ),
					'slug'  => 'strong-secondary-color',
					'color' => get_theme_mod( 'strong_secondary_color', '#c4c4c4' ),
				),
				array(
					'name'  => esc_html__( 'Tertiary Color', 'lsx-customizer' ),
					'slug'  => 'tertiary-color',
					'color' => get_theme_mod( 'tertiary_color', '#6BA913' ),
				),
				array(
					'name'  => esc_html__( 'Strong Tertiary Color', 'lsx-customizer' ),
					'slug'  => 'strong-tertiary-color',
					'color' => get_theme_mod( 'strong_tertiary_color', '#3F640B' ),
				),
				array(
					'name'  => esc_html__( 'Heading Color', 'lsx-customizer' ),
					'slug'  => 'heading-color',
					'color' => get_theme_mod( 'heading_color_color', '#4a4a4a' ),
				),
				array(
					'name'  => esc_html__( 'Body Color', 'lsx-customizer' ),
					'slug'  => 'body-color',
					'color' => get_theme_mod( 'body_text_color_color', '#444444' ),
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

	new LSX_Customizer_Frontend;

}
