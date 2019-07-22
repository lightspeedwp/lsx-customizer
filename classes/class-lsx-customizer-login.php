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
			add_action( 'customize_register', array( $this, 'register_general' ), 20 );
			add_action( 'customize_register', array( $this, 'register_form' ), 30 );
			add_action( 'customize_register', array( $this, 'register_background' ), 40 );

			add_action( 'after_switch_theme', array( $this, 'set_theme_mod' ) );
			add_action( 'customize_save_after', array( $this, 'set_theme_mod' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_css' ), 2999 );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function register_general( $wp_customize ) {
			/**
			 * Register the main panel
			 */
			$wp_customize->add_panel(
				'login',
				array(
					'title'    => esc_html__( 'WP Login', 'lsx-customizer' ),
					'priority' => 60,
				)
			);

			/**
			 * Reigster the Form section
			 */
			$wp_customize->add_section(
				'login-general',
				array(
					'title'    => esc_html__( 'General', 'lsx-customizer' ),
					'priority' => 1,
					'panel'    => 'login',
				)
			);

			/**
			 * Select the background repeat.
			 */
			$wp_customize->add_setting(
				'lsx_login_logo',
				array(
					'default'   => '',
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
						'section'  => 'login-general',
						'settings' => 'lsx_login_logo',
					)
				)
			);

			/**
			 * Link Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_link_colour',
				array(
					'default'   => 'ffffff',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_link_colour',
					array(
						'label'    => __( 'Link Colour', 'lsx-customizer' ),
						'section'  => 'login-general',
						'settings' => 'lsx_login_link_colour',
					)
				)
			);

			/**
			 * Add in the custom CSS.
			 */
			$wp_customize->add_setting(
				'lsx_login_custom_css',
				array(
					'default'   => '',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'lsx_login_custom_css',
					array(
						'label'    => __( 'Custom CSS', 'lsx-customizer' ),
						'section'  => 'login-general',
						'settings' => 'lsx_login_custom_css',
						'type'     => 'textarea',
					)
				)
			);
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function register_form( $wp_customize ) {
			/**
			 * Reigster the Form section
			 */
			$wp_customize->add_section(
				'login-form',
				array(
					'title'    => esc_html__( 'Form', 'lsx-customizer' ),
					'priority' => 1,
					'panel'    => 'login',
				)
			);
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function register_background( $wp_customize ) {
			$wp_customize->add_section(
				'login-background',
				array(
					'title'    => esc_html__( 'Background', 'lsx-customizer' ),
					'priority' => 1,
					'panel'    => 'login',
				)
			);
			/**
			 * Background Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_bg_colour',
				array(
					'default'   => 'inherit',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_bg_colour',
					array(
						'label'    => __( 'Background Colour', 'lsx-customizer' ),
						'section'  => 'login-background',
						'settings' => 'lsx_login_bg_colour',
					)
				)
			);

			/**
			 * Upload a Background Image
			 */
			$wp_customize->add_setting(
				'lsx_login_bg_image',
				array(
					'default'   => '',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'lsx_login_bg_image',
					array(
						'label'    => __( 'Background Image', 'lsx-customizer' ),
						'section'  => 'login-background',
						'settings' => 'lsx_login_bg_image',
					)
				)
			);

			/**
			 * Select the background repeat.
			 */
			$wp_customize->add_setting(
				'lsx_login_bg_repeat',
				array(
					'default'   => 'no-repeat',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'lsx_login_bg_repeat',
					array(
						'label'    => __( 'Background Repeat', 'lsx-customizer' ),
						'section'  => 'login-background',
						'settings' => 'lsx_login_bg_repeat',
						'type'     => 'select',
						'choices'  => array(
							'no-repeat'  => __( 'No Repeat', 'lsx-customizer' ),
							'repeat-x' => __( 'Repeat X', 'lsx-customizer' ),
							'repeat-y' => __( 'Repeat Y', 'lsx-customizer' ),
						),
					)
				)
			);

			/**
			 * Select the background repeat.
			 */
			$wp_customize->add_setting(
				'lsx_login_bg_size',
				array(
					'default'   => 'cover',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'lsx_login_bg_size',
					array(
						'label'    => __( 'Background Size', 'lsx-customizer' ),
						'section'  => 'login-background',
						'settings' => 'lsx_login_bg_size',
						'type'     => 'select',
						'choices'  => array(
							'cover'  => __( 'Cover', 'lsx-customizer' ),
							'contain' => __( 'Contain', 'lsx-customizer' ),
						),
					)
				)
			);
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
					'logo'              => get_theme_mod( 'lsx_login_logo', '' ),
					'link_colour'       => get_theme_mod( 'lsx_login_link_colour', '#ffffff' ),
					'background_colour' => get_theme_mod( 'lsx_login_bg_colour', 'inherit' ),
					'background_image'  => get_theme_mod( 'lsx_login_bg_image', '' ),
					'background_repeat' => get_theme_mod( 'lsx_login_bg_repeat', 'no-repeat' ),
					'background_size'   => get_theme_mod( 'lsx_login_bg_size', 'cover' ),
					'custom_css'        => get_theme_mod( 'lsx_login_custom_css', '' ),
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

			$css .= "body.login #backtoblog a, body.login #nav a { color: {$theme_mods['link_colour']}; }";

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

			// Add in the background image options.
			$background_image = '';
			if ( isset( $theme_mods['background_image'] ) && '' !== $theme_mods['background_image'] ) {
				$background_image = "background-image:url('{$theme_mods['background_image']}');";
			}
			$background_repeat = '';
			if ( isset( $theme_mods['background_repeat'] ) && '' !== $theme_mods['background_repeat'] ) {
				$background_repeat = "background-repeat:{$theme_mods['background_repeat']};";
			}
			$background_size = '';
			if ( isset( $theme_mods['background_size'] ) && '' !== $theme_mods['background_size'] ) {
				$background_size = "background-size:{$theme_mods['background_size']};";
			}
			$css .= "
				.login {
					background:{$theme_mods['background_colour']};
					{$background_image}
					{$background_repeat}
					{$background_size}
				}";

			// Add in the custom css
			if ( isset( $theme_mods['custom_css'] ) && '' !== $theme_mods['custom_css'] ) {
				$css .= $theme_mods['custom_css'];
			}

			$css_new .= "
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
			";

			$css .= '</style>';
			$css = apply_filters( 'lsx_customizer_login_styles', $css );
			return $css;
		}
	}
	new LSX_Customizer_Login();
}
