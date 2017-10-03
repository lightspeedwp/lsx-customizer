<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Footer' ) ) {

	/**
	 * LSX Customizer Colour Footer Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Footer extends LSX_Customizer_Colour {

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

			set_theme_mod( 'lsx_customizer_colour__footer_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__footer_theme_mod' );

			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );

				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__footer_theme_mod', $styles );
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

			return apply_filters( 'lsx_customizer_colours_footer', array(
				'footer_background_color' => get_theme_mod( 'footer_background_color', $colors['footer_background_color'] ),
				'footer_text_color'       => get_theme_mod( 'footer_text_color',       $colors['footer_text_color'] ),
				'footer_link_color'       => get_theme_mod( 'footer_link_color',       $colors['footer_link_color'] ),
				'footer_link_hover_color' => get_theme_mod( 'footer_link_hover_color', $colors['footer_link_hover_color'] ),
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

			if ( empty( $colors['footer_background_color'] )
				|| empty( $colors['footer_text_color'] )
				|| empty( $colors['footer_link_color'] )
				|| empty( $colors['footer_link_hover_color'] ) ) {
				return '';
			}

			$css = '
				@import "' . get_template_directory() . '/assets/css/scss/global/mixins/footer";

				/**
				 * LSX Customizer - Footer
				 */
				@include footer-colours (
					$bg:    ' . $colors['footer_background_color'] . ',
					$color: ' . $colors['footer_text_color'] . ',
					$link:  ' . $colors['footer_link_color'] . ',
					$hover: ' . $colors['footer_link_hover_color'] . '
				);
			';

			$css = apply_filters( 'lsx_customizer_colour_selectors_footer', $css, $colors );
			$css = parent::scss_to_css( $css );

			return $css;
		}

	}

}
