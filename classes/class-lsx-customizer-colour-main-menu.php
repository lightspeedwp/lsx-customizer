<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Main_Menu' ) ) {

	/**
	 * LSX Customizer Colour Main Menu Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link      
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Main_Menu extends LSX_Customizer_Colour {

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
			
			set_theme_mod( 'lsx_customizer_colour__main_menu_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__main_menu_theme_mod' );
			
			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );
				
				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__main_menu_theme_mod', $styles );
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

			return apply_filters( 'lsx_customizer_colours_main_menu', array(
				'main_menu_background_hover1_color' => get_theme_mod( 'main_menu_background_hover1_color', $colors['main_menu_background_hover1_color'] ),
				'main_menu_background_hover2_color' => get_theme_mod( 'main_menu_background_hover2_color', $colors['main_menu_background_hover2_color'] ),
				'main_menu_text_color' =>              get_theme_mod( 'main_menu_text_color',              $colors['main_menu_text_color'] ),
				'main_menu_text_hover1_color' =>       get_theme_mod( 'main_menu_text_hover1_color',       $colors['main_menu_text_hover1_color'] ),
				'main_menu_text_hover2_color' =>       get_theme_mod( 'main_menu_text_hover2_color',       $colors['main_menu_text_hover2_color'] ),
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
				$colors_template[$key] = '';
			}

			$colors = wp_parse_args( $colors, $colors_template );

			$css = <<<CSS
				/*
				 *
				 * Main Menu
				 *
				 */

				nav.primary-navbar {
					.nav.navbar-nav {
						& > li,
						ul.dropdown-menu > li {
							& > a,
							ul.dropdown-menu > li > a {
								color: {$colors['main_menu_text_color']};
							}
							
							&:hover,
							&.open,
							&.active,
							&.active:hover {
								& > a {
									background-color: {$colors['main_menu_background_hover1_color']};
									color: {$colors['main_menu_text_hover1_color']};

									.caret {
										border-top-color: {$colors['main_menu_text_hover1_color']};
										border-bottom-color: {$colors['main_menu_text_hover1_color']};
									}
								}
							}

							ul.dropdown-menu {
								background-color: {$colors['main_menu_background_hover1_color']};

								& > li {
									& > a {
										color: {$colors['main_menu_text_hover1_color']};

										&:hover {
											background-color: {$colors['main_menu_background_hover2_color']};
											color: {$colors['main_menu_text_hover2_color']};
										}
									}
								}
							}

							&.active {
								& li.active a {
									background-color: {$colors['main_menu_background_hover2_color']} !important;
									color: {$colors['main_menu_text_hover2_color']};
								}
							}
						}
					}
				}

				.navbar-default {
					.navbar-toggle {
						&,
						&:visited,
						&:focus,
						&:hover,
						&:active {
							border-color: {$colors['main_menu_background_hover1_color']};
							background-color: {$colors['main_menu_background_hover1_color']};
						}

						.icon-bar {
							background-color: {$colors['main_menu_text_hover1_color']};
						}
					}
				}

				header.banner {
					.search-submit {
						&,
						&:active,
						&:visited {
							color: {$colors['main_menu_text_color']} !important;
						}

						&:hover,
						&:hover:active,
						&:focus {
							color: #333 !important; /* @TODO */
						}
					}
				}
CSS;

			$css = apply_filters( 'lsx_customizer_colour_selectors_main_menu', $css, $colors );
			$css = parent::scss_to_css( $css );
			return $css;
		}

	}

}
