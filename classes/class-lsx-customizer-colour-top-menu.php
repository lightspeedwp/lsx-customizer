<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Top_Menu' ) ) {

	/**
	 * LSX Customizer Colour Top Menu Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link      
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Top_Menu extends LSX_Customizer_Colour {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'after_switch_theme',   array( $this, 'set_theme_mod' ) );
			add_action( 'customize_save_after', array( $this, 'set_theme_mod' ) );
			
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ), 9999 );
		}

		/**
		 * Assign CSS to theme mod.
		 *
		 * @since 1.0.0
		 */
		public function set_theme_mod() {
			$theme_mods = $this->get_theme_mods();
			$styles     = $this->get_css( $theme_mods );
			
			set_theme_mod( 'lsx_customizer_colour__top_menu_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__top_menu_theme_mod' );
			
			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );
				
				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__top_menu_theme_mod', $styles );
				}
			} else {
				$styles = $styles_from_theme_mod;
			}

			wp_add_inline_style( 'lsx_customizer', $styles );
		}

		/**
		 * Get CSS theme mods.
		 *
		 * @since 1.0.0
		 */
		public function get_theme_mods() {
			$colors = parent::get_color_scheme();

			return array(
				'top_menu_background_color' => get_theme_mod( 'top_menu_background_color', $colors['top_menu_background_color'] ),
				'top_menu_text_color' =>       get_theme_mod( 'top_menu_text_color',       $colors['top_menu_text_color'] ),
				'top_menu_text_hover_color' => get_theme_mod( 'top_menu_text_hover_color', $colors['top_menu_text_hover_color'] )
			);
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
				$colors_template[$key] = '';
			}

			$colors = wp_parse_args( $colors, $colors_template );

			$css = <<<CSS
				/*
				 *
				 * Top Menu
				 *
				 */

				#top-menu {
					background-color: {$colors['top_menu_background_color']};

					nav.top-menu {
						ul {
							li {
								a {
									&,
									&:visited {
										color: {$colors['top_menu_text_color']};
									}

									&:before {
										color: {$colors['top_menu_text_hover_color']};
									}

									&:hover,
									&:active,
									&:focus {
										&,
										&:before {
											color: {$colors['top_menu_text_hover_color']};
										}
									}
								}
							}

							&.submenu-languages,
							&.submenu-currency {
								& > li {
									a {
										&,
										&:visited {
											background-color: {$colors['top_menu_background_color']};
											color: {$colors['top_menu_text_color']};
										}

										&:hover,
										&:active,
										&:focus {
											background-color: {$colors['top_menu_background_color']};
											color: {$colors['top_menu_text_hover_color']};
										}
									}
								}
							}
						}
					}
				}
CSS;

			$css = apply_filters( 'lsx_customizer_colour_selectors_top_menu', $css, $colors );
			$css = parent::scss_to_css( $css );
			return $css;
		}

	}

}
