<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Button_CTA' ) ) {

	/**
	 * LSX Customizer Colour Button CTA Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link      
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Button_CTA extends LSX_Customizer_Colour {

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
			
			set_theme_mod( 'lsx_customizer_colour__button_cta_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__button_cta_theme_mod' );
			
			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );
				
				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__button_cta_theme_mod', $styles );
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
				'button_cta_background_color' =>       get_theme_mod( 'button_cta_background_color',       $colors['button_cta_background_color'] ),
				'button_cta_background_hover_color' => get_theme_mod( 'button_cta_background_hover_color', $colors['button_cta_background_hover_color'] ),
				'button_cta_text_color' =>             get_theme_mod( 'button_cta_text_color',             $colors['button_cta_text_color'] ),
				'button_cta_text_color_hover' =>       get_theme_mod( 'button_cta_text_color_hover',       $colors['button_cta_text_color_hover'] )
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
				 * Button CTA
				 *
				 */

				.btn {
					&.cta-btn {
						&,
						&:visited {
							background-color: {$colors['button_cta_background_color']} !important;
							color: {$colors['button_cta_text_color']} !important;
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_cta_background_hover_color']} !important;
							color: {$colors['button_cta_text_color_hover']} !important;
						}
					}

					&.cta-border-btn {
						&,
						&:visited {
							border-color: {$colors['button_cta_background_color']} !important;
							color: {$colors['button_cta_background_color']} !important;
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_cta_background_hover_color']} !important;
							border-color: {$colors['button_cta_background_hover_color']} !important;
							color: {$colors['button_cta_text_color_hover']} !important;
						}
					}
				}

				#top-menu {
					nav.top-menu {
						ul {
							li.cta {
								a {
									&,
									&:visited {
										background-color: {$colors['button_cta_background_color']} !important;
										color: {$colors['button_cta_text_color']} !important;
									}

									&:hover,
									&:active,
									&:focus {
										background-color: {$colors['button_cta_background_hover_color']} !important;
										color: {$colors['button_cta_text_color_hover']} !important;
									}
								}
							}
						}
					}
				}

				nav.primary-navbar {
					.nav.navbar-nav {
						& > li,
						ul.dropdown-menu > li {
							&.menu-highlight {
								a {
									background-color: {$colors['button_cta_background_color']} !important;
									color: {$colors['button_cta_text_color']} !important;

									.caret {
										border-top-color: {$colors['button_cta_text_color']} !important;
										border-bottom-color: {$colors['button_cta_text_color']} !important;
									}
								}

								&:hover {
									& > a {
										background-color: {$colors['button_cta_background_color']} !important;
										color: {$colors['button_cta_text_color']} !important;
									}
								}

								ul.dropdown-menu {
									& > li {
										& > a {
											background-color: {$colors['button_cta_background_color']} !important;
											color: {$colors['button_cta_text_color']} !important;

											&:hover {
												background-color: {$colors['button_cta_background_hover_color']} !important;
												color: {$colors['button_cta_text_color_hover']} !important;
											}
										}
									}
								}
							}
						}
					}
				}

				/*
				 *
				 * Button CTA WooCommerce
				 *
				 */

				.woocommerce {
					a.button,
					button.button,
					input.button,
					input[type="submit"],
					#respond input#submit {
						&.alt {
							&,
							&:visited {
								background-color: {$colors['button_cta_background_color']} !important;
								color: {$colors['button_cta_text_color']} !important;
							}

							&:hover,
							&:active,
							&:focus {
								background-color: {$colors['button_cta_background_hover_color']} !important;
								color: {$colors['button_cta_text_color_hover']} !important;
							}
						}
					}
				}
CSS;

			$css = apply_filters( 'lsx_customizer_colour_selectors_button_cta', $css, $colors );
			$css = parent::scss_to_css( $css );
			return $css;
		}

	}

}
