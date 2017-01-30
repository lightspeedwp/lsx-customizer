<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Button' ) ) {

	/**
	 * LSX Customizer Colour Button Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link      
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Button extends LSX_Customizer_Colour {

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
			
			set_theme_mod( 'lsx_customizer_colour__button_theme_mod', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_colour__button_theme_mod' );
			
			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );
				
				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_colour__button_theme_mod', $styles );
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

			return apply_filters( 'lsx_customizer_colours_button', array(
				'button_background_color' =>       get_theme_mod( 'button_background_color',       $colors['button_background_color'] ),
				'button_background_hover_color' => get_theme_mod( 'button_background_hover_color', $colors['button_background_hover_color'] ),
				'button_text_color' =>             get_theme_mod( 'button_text_color',             $colors['button_text_color'] ),
				'button_text_color_hover' =>       get_theme_mod( 'button_text_color_hover',       $colors['button_text_color_hover'] ),
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
				 * Button
				 *
				 */

				.btn,
				.button,
				input[type="submit"],
				#searchform .input-group span.input-group-btn button.search-submit,
				#respond #submit {
					&,
					&:visited {
						background-color: {$colors['button_background_color']};
						color: {$colors['button_text_color']};
					}

					&:hover,
					&:active,
					&:focus {
						background-color: {$colors['button_background_hover_color']};
						color: {$colors['button_text_color_hover']};
					}
				}

				#infinite-handle span {
					&,
					&:visited {
						background-color: {$colors['button_background_color']} !important;
						color: {$colors['button_text_color']} !important;
					}

					&:hover,
					&:active,
					&:focus {
						background-color: {$colors['button_background_hover_color']} !important;
						color: {$colors['button_text_color_hover']} !important;
					}
				}

				.caldera-grid,
				.caldera-clarity-grid,
				#footer-widgets .widget {
					.btn,
					.button-primary,
					button {
						&,
						&:visited {
							background-color: {$colors['button_background_color']};
							color: {$colors['button_text_color']};
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_background_hover_color']};
							color: {$colors['button_text_color_hover']};
						}
					}
				}

				.give-form {
					.give-btn {
						&,
						&:visited {
							background-color: {$colors['button_background_color']};
							color: {$colors['button_text_color']};
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_background_hover_color']};
							color: {$colors['button_text_color_hover']};
						}
					}
				}

				.field-wrap {
					input[type="submit"],
					input[type="button"],
					button {
						&,
						&:visited {
							background-color: {$colors['button_background_color']} !important;
							color: {$colors['button_text_color']} !important;
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_background_hover_color']} !important;
							color: {$colors['button_text_color_hover']} !important;
						}
					}
				}

				article {
					header.entry-header {
						h1.entry-title {
							a.format-link {
								&,
								&:visited {
									background-color: {$colors['button_background_color']};
									color: {$colors['button_text_color']} !important;
								}
							}
						}
					}
				}

				.button-primary.border-btn,
				.btn.border-btn,
				button.border-btn,
				.button-primary.lsx-border-button,
				.btn.lsx-border-button,
				button.lsx-border-button,
				.wp-pagenavi a,
				.lsx-postnav > a {
					&,
					&:visited {
						border-color: {$colors['button_background_color']} !important;
						color: {$colors['button_background_color']} !important;
					}

					&:hover,
					&:active,
					&:focus {
						background-color: {$colors['button_background_hover_color']} !important;
						border-color: {$colors['button_background_hover_color']} !important;
						color: {$colors['button_text_color_hover']} !important;
					}
				}

				.wp-pagenavi span.current,
				.lsx-postnav > span {
					background-color: {$colors['button_background_color']} !important;
					border-color: {$colors['button_background_color']} !important;
					color: {$colors['button_text_color']} !important;
				}

				input[type="text"],
				input[type="search"],
				input[type="email"],
				input[type="number"],
				input[type="password"],
				textarea,
				select {
					&:focus {
						border-color: {$colors['button_background_color']} !important;
					}
				}

				/*
				 *
				 * Button WooCommerce
				 *
				 */

				.woocommerce {
					a.button,
					button.button,
					input.button,
					input[type="submit"],
					#respond input#submit {
						&,
						&:visited {
							background-color: {$colors['button_background_color']} !important;
							color: {$colors['button_text_color']} !important;
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_background_hover_color']} !important;
							color: {$colors['button_text_color_hover']} !important;
						}
					}

					table.cart {
						td.actions {
							.coupon {
								.input-text {
									&:focus {
										border-color: {$colors['button_background_color']} !important;
									}
								}
							}
						}
					}

					nav.woocommerce-pagination a {
						&,
						&:visited {
							border-color: {$colors['button_background_color']} !important;
							color: {$colors['button_background_color']} !important;
						}

						&:hover,
						&:active,
						&:focus {
							background-color: {$colors['button_background_hover_color']} !important;
							border-color: {$colors['button_background_hover_color']} !important;
							color: {$colors['button_text_color_hover']} !important;
						}
					}

					nav.woocommerce-pagination span.current {
						background-color: {$colors['button_background_color']} !important;
						border-color: {$colors['button_background_color']} !important;
						color: {$colors['button_text_color']} !important;
					}
				}
CSS;

			$css = apply_filters( 'lsx_customizer_colour_selectors_button', $css, $colors );
			$css = parent::scss_to_css( $css );
			return $css;
		}

	}

}
