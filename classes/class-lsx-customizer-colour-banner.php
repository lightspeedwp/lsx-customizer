<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Banner' ) ) {

	/**
	 * LSX Customizer Colour Banner Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Banner extends LSX_Customizer_Colour {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'after_switch_theme',   array( $this, 'set_theme_mod' ) );
			add_action( 'customize_save_after', array( $this, 'set_theme_mod' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ), 2999 );
		}

		/**
		 * Assign CSS to theme mod.
		 *
		 * @since 1.0.0
		 */
		public function set_theme_mod() {
			$theme_mods = $this->get_theme_mods();
			$styles     = $this->get_css( $theme_mods );

			set_theme_mod( 'lsx_customizer_colour__banner_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__banner_theme_mod' );

			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );

				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__banner_theme_mod', $styles );
				}
			} else {
				$styles = $styles_from_theme_mod;
			}

			wp_add_inline_style( 'lsx-customizer', $styles );
		}

		/**
		 * Get CSS theme mods.
		 *
		 * @since 1.0.0
		 */
		public function get_theme_mods() {
			$colors = parent::get_color_scheme();

			return apply_filters( 'lsx_customizer_colours_banner', array(
				'banner_background_color'               => get_theme_mod( 'banner_background_color',               $colors['banner_background_color'] ),
				'banner_text_color'                     => get_theme_mod( 'banner_text_color',                     $colors['banner_text_color'] ),
				'banner_text_image_color'               => get_theme_mod( 'banner_text_image_color',               $colors['banner_text_image_color'] ),
				'banner_breadcrumb_background_color'    => get_theme_mod( 'banner_breadcrumb_background_color',    $colors['banner_breadcrumb_background_color'] ),
				'banner_breadcrumb_text_color'          => get_theme_mod( 'banner_breadcrumb_text_color',          $colors['banner_breadcrumb_text_color'] ),
				'banner_breadcrumb_text_selected_color' => get_theme_mod( 'banner_breadcrumb_text_selected_color', $colors['banner_breadcrumb_text_selected_color'] ),
			) );
		}

		/**
		 * Returns CSS.
		 *
		 * @since 1.0.0
		 */
		function get_css( $colors ) {
			global $customizer_colour_names;

			$colors_template = array();

			foreach ( $customizer_colour_names as $key => $value ) {
				$colors_template[ $key ] = '';
			}

			$colors = wp_parse_args( $colors, $colors_template );

			if ( empty( $colors['banner_background_color'] )
				|| empty( $colors['banner_text_color'] )
				|| empty( $colors['banner_text_image_color'] )
				|| empty( $colors['banner_breadcrumb_background_color'] )
				|| empty( $colors['banner_breadcrumb_text_color'] )
				|| empty( $colors['banner_breadcrumb_text_selected_color'] ) ) {
				return '';
			}

			$css = '
				@import "' . get_template_directory() . '/assets/css/scss/global/mixins/banner";

				/**
				 * LSX Customizer - Banner
				 */
				@include banner-colours (
					$bg:                 ' . $colors['banner_background_color'] . ',
					$color:              ' . $colors['banner_text_color'] . ',
					$color-image:        ' . $colors['banner_text_image_color'] . ',
					$breadcrumb-bg:      ' . $colors['banner_breadcrumb_background_color'] . ',
					$breadcrumb-color:   ' . $colors['banner_breadcrumb_text_color'] . ',
					$breadcrumb-current: ' . $colors['banner_breadcrumb_text_selected_color'] . '
				);

				.lsx:not(.single-post) .archive-header .archive-title, .lsx:not(.single-post) .archive-header .page-title, .lsx:not(.single-post) .archive-header *, .lsx:not(.single-post) .archive-header *, .lsx:not(.single-post) .archive-header >p, .lsx:not(.single-post) .archive-header >p, .lsx:not(.single-post):not(.page-has-banner) .archive-header-wrapper .archive-header .archive-title, .lsx:not(.single-post):not(.page-has-banner) .archive-header-wrapper .archive-header>p, .lsx-layout-switcher .lsx-layout-switcher-option {
					color: ' . $colors['banner_text_color'] . ';
				}

				.lsx:not(.single-post) .archive-header.banner-has-custom-bg .archive-title, .lsx:not(.single-post) .archive-header.banner-has-custom-bg .page-title, .lsx:not(.single-post) .archive-header.banner-has-custom-bg *, .lsx:not(.single-post) .archive-header.banner-has-custom-bg *, .lsx:not(.single-post) .archive-header.banner-has-custom-bg >p, .lsx:not(.single-post) .archive-header.banner-has-custom-bg >p, .lsx:not(.single-post):not(.page-has-banner) .archive-header-wrapper .archive-header.banner-has-custom-bg .archive-title, .lsx:not(.single-post):not(.page-has-banner) .archive-header-wrapper .archive-header.banner-has-custom-bg>p, .banner-has-custom-bg .lsx-layout-switcher .lsx-layout-switcher-option {
					color: ' . $colors['banner_text_image_color'] . ';
				}
				.lsx-hero-banner-block {
					background-color: ' . $colors['banner_background_color'] . ';
					.lsx-title-block {
						h1 {
							color: ' . $colors['banner_text_color'] . ';
						}
					}
				}
			';

			$css = apply_filters( 'lsx_customizer_colour_selectors_banner', $css, $colors );
			$css = parent::scss_to_css( $css );

			return $css;
		}

	}

}
