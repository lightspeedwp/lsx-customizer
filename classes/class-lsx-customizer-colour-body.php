<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Body' ) ) {

	/**
	 * LSX Customizer Colour Body Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Body extends LSX_Customizer_Colour {

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

			set_theme_mod( 'lsx_customizer_colour__body_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__body_theme_mod' );

			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );

				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__body_theme_mod', $styles );
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

			$background_color = get_theme_mod( 'background_color', $colors['background_color'] );

			if ( '#' !== substr( $background_color, 0, 1 ) ) {
				$background_color = '#' . $background_color;
			}

			return apply_filters( 'lsx_customizer_colours_body', array(
				'background_color'                       => $background_color,
				'body_line_color'                        => get_theme_mod( 'body_line_color',                        $colors['body_line_color'] ),
				'body_text_heading_color'                => get_theme_mod( 'body_text_heading_color',                $colors['body_text_heading_color'] ),
				'body_text_small_color'                  => get_theme_mod( 'body_text_small_color',                  $colors['body_text_small_color'] ),
				'body_text_color'                        => get_theme_mod( 'body_text_color',                        $colors['body_text_color'] ),
				'body_link_color'                        => get_theme_mod( 'body_link_color',                        $colors['body_link_color'] ),
				'body_link_hover_color'                  => get_theme_mod( 'body_link_hover_color',                  $colors['body_link_hover_color'] ),
				'body_section_full_background_color'     => get_theme_mod( 'body_section_full_background_color',     $colors['body_section_full_background_color'] ),
				'body_section_full_text_color'           => get_theme_mod( 'body_section_full_text_color',           $colors['body_section_full_text_color'] ),
				'body_section_full_link_color'           => get_theme_mod( 'body_section_full_link_color',           $colors['body_section_full_link_color'] ),
				'body_section_full_link_hover_color'     => get_theme_mod( 'body_section_full_link_hover_color',     $colors['body_section_full_link_hover_color'] ),
				'body_section_full_cta_background_color' => get_theme_mod( 'body_section_full_cta_background_color', $colors['body_section_full_cta_background_color'] ),
				'body_section_full_cta_text_color'       => get_theme_mod( 'body_section_full_cta_text_color',       $colors['body_section_full_cta_text_color'] ),
				'body_section_full_cta_link_color'       => get_theme_mod( 'body_section_full_cta_link_color',       $colors['body_section_full_cta_link_color'] ),
				'body_section_full_cta_link_hover_color' => get_theme_mod( 'body_section_full_cta_link_hover_color', $colors['body_section_full_cta_link_hover_color'] ),
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

			if ( empty( $colors['background_color'] )
				|| empty( $colors['body_line_color'] )
				|| empty( $colors['body_text_heading_color'] )
				|| empty( $colors['body_text_color'] )
				|| empty( $colors['body_link_color'] )
				|| empty( $colors['body_link_hover_color'] )
				|| empty( $colors['body_text_small_color'] )
				|| empty( $colors['body_section_full_background_color'] )
				|| empty( $colors['body_section_full_text_color'] )
				|| empty( $colors['body_section_full_link_color'] )
				|| empty( $colors['body_section_full_link_hover_color'] )
				|| empty( $colors['body_section_full_cta_background_color'] )
				|| empty( $colors['body_section_full_cta_text_color'] )
				|| empty( $colors['body_section_full_cta_link_color'] )
				|| empty( $colors['body_section_full_cta_link_hover_color'] ) ) {
				return '';
			}

			$css = '
				@import "' . get_template_directory() . '/assets/css/scss/global/mixins/content";

				/**
				 * LSX Customizer - Body
				 */
				@include content-colours (
					$bg:             ' . $colors['background_color'] . ',
					$breaker:        ' . $colors['body_line_color'] . ',
					$header:         ' . $colors['body_text_heading_color'] . ',
					$color:          ' . $colors['body_text_color'] . ',
					$link:           ' . $colors['body_link_color'] . ',
					$hover:          ' . $colors['body_link_hover_color'] . ',
					$small:          ' . $colors['body_text_small_color'] . ',
					$full-bg:        ' . $colors['body_section_full_background_color'] . ',
					$full-color:     ' . $colors['body_section_full_text_color'] . ',
					$full-link:      ' . $colors['body_section_full_link_color'] . ',
					$full-hover:     ' . $colors['body_section_full_link_hover_color'] . ',
					$full-cta-bg:    ' . $colors['body_section_full_cta_background_color'] . ',
					$full-cta-color: ' . $colors['body_section_full_cta_text_color'] . ',
					$full-cta-link:  ' . $colors['body_section_full_cta_link_color'] . ',
					$full-cta-hover: ' . $colors['body_section_full_cta_link_hover_color'] . '
				);
			';

			$css = apply_filters( 'lsx_customizer_colour_selectors_body', $css, $colors );
			$css = parent::scss_to_css( $css );

			return $css;
		}

	}

}
