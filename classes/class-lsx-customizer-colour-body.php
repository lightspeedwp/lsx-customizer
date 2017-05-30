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

			wp_add_inline_style( 'lsx_customizer', $styles );
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
				'background_color' =>                       $background_color,
				'body_line_color' =>                        get_theme_mod( 'body_line_color',                        $colors['body_line_color'] ),
				'body_text_heading_color' =>                get_theme_mod( 'body_text_heading_color',                $colors['body_text_heading_color'] ),
				'body_text_color' =>                        get_theme_mod( 'body_text_color',                        $colors['body_text_color'] ),
				'body_link_color' =>                        get_theme_mod( 'body_link_color',                        $colors['body_link_color'] ),
				'body_link_hover_color' =>                  get_theme_mod( 'body_link_hover_color',                  $colors['body_link_hover_color'] ),
				'body_section_full_background_color' =>     get_theme_mod( 'body_section_full_background_color',     $colors['body_section_full_background_color'] ),
				'body_section_full_text_color' =>           get_theme_mod( 'body_section_full_text_color',           $colors['body_section_full_text_color'] ),
				'body_section_full_cta_background_color' => get_theme_mod( 'body_section_full_cta_background_color', $colors['body_section_full_cta_background_color'] ),
				'body_section_full_cta_text_color' =>       get_theme_mod( 'body_section_full_cta_text_color',       $colors['body_section_full_cta_text_color'] ),
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

			$rgb = parent::hex2rgb( $colors['body_line_color'] );
			$colors['body_line_color_rgba'] = "rgba({$rgb['red']}, {$rgb['green']}, {$rgb['blue']}, 0.5)";

			$css = <<<CSS
				/*
				 *
				 * Body
				 *
				 */

				body {
					color: {$colors['body_text_color']};
					
					&.archive.author,
					&.archive.category,
					&.archive.date,
					&.archive.tag,
					&.archive.tax-post_format,
					&.blog,
					&.search {
						.wrap {
							#primary {
								#main {
									& > article {
										-webkit-box-shadow: 1px 1px 3px 0 {$colors['body_line_color_rgba']};
										box-shadow: 1px 1px 3px 0 {$colors['body_line_color_rgba']};
										border-color: {$colors['body_line_color']};
									}
								}
							}
						}
					}

					&.single-post {
						.wrap {
							#primary {
								#main {
									& > article {
										.post-tags-wrapper {
											border-top-color: {$colors['body_line_color']};
											border-bottom-color: {$colors['body_line_color']};
										}
									}
								}

								.post-navigation {
									.pager {
										div {
											a {
												&,
												&:active,
												&:visited {
													h3 {
														color: {$colors['body_text_heading_color']};
													}
												}

												&:hover,
												&:hover:active,
												&:focus {
													h3 {
														color: {$colors['body_link_hover_color']};
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}

				.wrap {
					background-color: {$colors['background_color']};
				}

				h1, h2, h3, h4, h5, h6 {
					color: {$colors['body_text_heading_color']};

					a {
						&,
						&:active,
						&:visited {
							color: {$colors['body_text_heading_color']};
						}

						&:hover,
						&:hover:active,
						&:focus {
							color: {$colors['body_link_hover_color']};
						}
					}
				}

				article {
					header.entry-header {
						h1.entry-title {
							a {
								&,
								&:active,
								&:visited {
									color: {$colors['body_text_heading_color']} !important;
								}

								&:hover,
								&:hover:active,
								&:focus {
									color: {$colors['body_link_hover_color']} !important;
								}
							}
						}
					}

					.entry-content,
					.entry-summary {
						color: {$colors['body_text_color']} !important;
					}
				}

				.sharedaddy {
					.sd-sharing {
						border-top-color: {$colors['body_line_color']};

						.sd-title {
							&,
							&:before {
								color: {$colors['body_text_color']} !important;
							}
						}
					}
				}

				.lsx-sharing-content {
					.lsx-sharing-label {
						&,
						&:before {
							color: {$colors['body_text_color']} !important;
						}
					}
				}

				.entry-meta {
					.post-meta {
						color: {$colors['body_text_color']} !important;
					}
				}

				.nav-links-description {
					color: {$colors['body_text_color']} !important;
					
					&:after,
					&:before {
						color: {$colors['body_text_color']} !important;
					}
				}

				.post-meta-author,
				.post-meta-categories,
				.post-meta-time,
				.post-comments {
					&:before {
						color: {$colors['body_text_color']} !important;
					}

					a {
						&,
						&:active,
						&:visited {
							color: {$colors['body_link_color']} !important;
						}

						&:hover,
						&:hover:active,
						&:focus {
							color: {$colors['body_link_hover_color']} !important;
						}
					}
				}

				.post-meta-link {
					&:before {
						color: {$colors['body_text_color']} !important;
					}

					&,
					&:active,
					&:visited {
						color: {$colors['body_link_color']} !important;
					}

					&:hover,
					&:hover:active,
					&:focus {
						color: {$colors['body_link_hover_color']} !important;
					}
				}
				
				.post-tags,
				#reply-title {
					&:before {
						color: {$colors['body_text_color']} !important;
					}
				}

				a {
					&,
					.entry-content &:not(.btn):not(.button),
					.entry-summary &:not(.btn):not(.button) {
						&,
						&:active,
						&:visited {
							color: {$colors['body_link_color']};
						}

						&:hover,
						&:hover:active,
						&:focus {
							color: {$colors['body_link_hover_color']};
						}
					}
				}

				.facetwp-alpha {
					&.available,
					&.selected {
						color: {$colors['body_link_color']} !important;

						&:hover {
							color: {$colors['body_link_hover_color']} !important;
						}
					}
				}

				figure.wp-caption {
					border-color: {$colors['body_line_color']};

					figcaption.wp-caption-text {
						border-top-color: {$colors['body_line_color']};
					}
				}

				.page-header {
					border-bottom-color: {$colors['body_line_color']};
				}

				#main {
					.lsx-full-width {
						background-color: {$colors['body_section_full_background_color']};
						color: {$colors['body_section_full_text_color']};

						h1, h2, h3, h4, h5, h6,
						a, .lsx-hero-unit {
							color: {$colors['body_section_full_text_color']};
						}

						.lsx-border-button {
							color: {$colors['body_section_full_text_color']} !important;
							border-color: {$colors['body_section_full_text_color']} !important;

							&:hover,
							&:hover:active,
							&:focus {
								color: {$colors['body_section_full_background_color']} !important;
								background-color: {$colors['body_section_full_text_color']} !important;
							}
						}
					}

					.lsx-full-width-alt {
						background-color: {$colors['body_section_full_cta_background_color']};
						color: {$colors['body_section_full_cta_text_color']};

						h1, h2, h3, h4, h5, h6,
						a, .lsx-hero-unit {
							color: {$colors['body_section_full_cta_text_color']};
						}

						.lsx-border-button {
							color: {$colors['body_section_full_cta_text_color']} !important;
							border-color: {$colors['body_section_full_cta_text_color']} !important;

							&:hover,
							&:hover:active,
							&:focus {
								color: {$colors['body_section_full_cta_background_color']} !important;
								background-color: {$colors['body_section_full_cta_text_color']} !important;
							}
						}
					}
				}
CSS;

			$css = apply_filters( 'lsx_customizer_colour_selectors_body', $css, $colors );
			$css = parent::scss_to_css( $css );
			return $css;
		}

	}

}
