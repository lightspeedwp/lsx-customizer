<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Header' ) ) {

	/**
	 * LSX Customizer Colour Header Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Header extends LSX_Customizer_Colour {

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

			set_theme_mod( 'lsx_customizer_colour__header_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__header_theme_mod' );

			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );

				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__header_theme_mod', $styles );
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

			return apply_filters( 'lsx_customizer_colours_header', array(
				'header_background_color'  => get_theme_mod( 'header_background_color',  $colors['header_background_color'] ),
				'header_link_color'        => get_theme_mod( 'header_link_color',        $colors['header_link_color'] ),
				'header_link_hover_color'  => get_theme_mod( 'header_link_hover_color',  $colors['header_link_hover_color'] ),
				'header_description_color' => get_theme_mod( 'header_description_color', $colors['header_description_color'] ),
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

			if ( empty( $colors['header_background_color'] )
				|| empty( $colors['header_link_color'] )
				|| empty( $colors['header_link_hover_color'] )
				|| empty( $colors['header_description_color'] ) ) {
				return '';
			}

			$css = '
				@import "' . get_template_directory() . '/assets/css/scss/global/mixins/header";

				/**
				 * LSX Customizer - Header
				 */
				@include header-colours (
					$bg:          ' . $colors['header_background_color'] . ',
					$link:        ' . $colors['header_link_color'] . ',
					$hover:       ' . $colors['header_link_hover_color'] . ',
					$description: ' . $colors['header_description_color'] . '
				);
			';

			$css = apply_filters( 'lsx_customizer_colour_selectors_header', $css, $colors );
			$css = parent::scss_to_css( $css );

			return $css;
		}

	}

}
