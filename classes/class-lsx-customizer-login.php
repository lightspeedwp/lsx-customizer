<?php
if ( ! class_exists( 'LSX_Customizer_Login' ) ) {

	/**
	 * LSX Customizer Login Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2019 LightSpeed
	 */
	class LSX_Customizer_Login extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );

			add_action( 'after_switch_theme', array( $this, 'set_theme_mod' ) );
			add_action( 'customize_save_after', array( $this, 'set_theme_mod' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_css' ), 2999 );

			/*
			Custom logo
			Custom Background Image
			Custom Background Color
			Custom Button Color
			Custom Text Color
			Custom Typography Font and Size
			Add you own Custom CSS 
			 */
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Login
			 */
			$wp_customize->add_panel(
				'login',
				array(
					'title'    => esc_html__( 'Login', 'lsx-customizer' ),
					'priority' => 60,
				)
			);

			/**
			 * Login - Sections
			 */
			$wp_customize->add_section(
				'wp-login',
				array(
					'title'    => esc_html__( 'WP Login', 'lsx-customizer' ),
					'priority' => 1,
					'panel'    => 'login',
				)
			);

			/**
			 * Upload a Logo
			 */
			$wp_customize->add_setting(
				'lsx_login_logo',
				array(
					'default'   => false,
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'lsx_login_logo',
					array(
						'label'    => __( 'Upload a logo', 'lsx-customizer' ),
						'section'  => 'wp-login',
						'settings' => 'lsx_login_logo',
					)
				)
			);

			/**
			 * Upload a background image
			 */
			/*$wp_customize->add_setting(
				'background_image',
				array(
					'default'   => false,
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'background_image',
					array(
						'label'    => __( 'Upload a background', 'lsx-customizer' ),
						'section'  => 'wp-login',
						'settings' => 'background_image',
					)
				)
			);*/

			/**
			 * Color Scheme
			 */
			/*$wp_customize->add_setting(
				'background_colour',
				array(
					'default'   => 'default',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);			

			$wp_customize->add_control(
				new LSX_Customizer_Colour_Control(
					$wp_customize,
					'background_colour',
					array(
						'label'    => esc_html__( 'Background Colour', 'lsx-customizer' ),
						'section'  => 'wp-login',
						'type'     => 'select',
						'priority' => 1,
						'choices'  => array(
							'0' => 'Default',
							'1' => 'Red',
						),
					)
				)
			);*/
			//wp_enqueue_style( 'login-style', get_template_directory_uri() . '/assets/css/lsx-customizer.css' ); 
		}
		/**
		 * Assign CSS to theme mod.
		 *
		 * @since 1.0.0
		 */
		public function set_theme_mod() {
			$theme_mods = $this->get_theme_mods();
			$styles     = $this->get_css( $theme_mods );

			set_theme_mod( 'lsx_customizer_login_styles', $styles );
		}

		/**
		 * Enqueues front-end CSS.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_css() {
			$styles_from_theme_mod = get_theme_mod( 'lsx_customizer_login_styles' );
			if ( is_customize_preview() || false === $styles_from_theme_mod ) {
				$theme_mods = $this->get_theme_mods();
				$styles     = $this->get_css( $theme_mods );

				if ( false === $styles_from_theme_mod ) {
					set_theme_mod( 'lsx_customizer_login_styles', $styles );
				}
			} else {
				$styles = $styles_from_theme_mod;
			}
			echo wp_kses( $styles, array( 'style' => array() ) );
		}

		/**
		 * Get CSS theme mods.
		 *
		 * @since 1.0.0
		 */
		public function get_theme_mods() {
			$mods = apply_filters(
				'lsx_customizer_login_styles',
				array(
					'logo' => get_theme_mod( 'lsx_login_logo', '' ),
				)
			);
			return $mods;
		}

		/**
		 * Returns CSS.
		 *
		 * @since 1.0.0
		 */
		public function get_css( $theme_mods ) {
			$css = '<style>';

			if ( isset( $theme_mods['logo'] ) && '' !== $theme_mods['logo'] ) {
				$css .= "
					#login h1 a, .login h1 a {
						background-image: url('" . $theme_mods['logo'] . "');
						height: 150px;
						width: 150px;
						background-size: 150px 150px;
						background-repeat: no-repeat;
						padding-bottom: 20px;
					}
				";
			}

			$css_new .= "
				.login {background:#fff;background-image:url('')} /* add url to background you want to use */

				.login #backtoblog a, .login #nav a {color:#fff;} /* Change Link Color at bottom */

				.wp-core-ui .button-primary { /* change button colors */
					background: #1f2024;
					border-color: #1f2024;
					color: #fff;
					text-decoration: none;
					text-shadow:none;
					transition:0.4s;
				}
				.wp-core-ui .button-primary:hover {
					background:#151618;
					border-color:#151618;
				}
				</style>
			";
			$css = apply_filters( 'lsx_customizer_login_styles', $css );
			return $css;
		}
	}
	new LSX_Customizer_Login();
}
