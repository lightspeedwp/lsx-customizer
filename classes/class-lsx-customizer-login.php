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
					'title'    => esc_html__( 'WP Login Screen', 'lsx-customizer' ),
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
					'default'   => '0085ba',
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
			 * Link Hover Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_link_hover_colour',
				array(
					'default'   => '000000',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_link_hover_colour',
					array(
						'label'    => __( 'Link Hover Colour', 'lsx-customizer' ),
						'section'  => 'login-general',
						'settings' => 'lsx_login_link_hover_colour',
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

			/**
			 * Form Background Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_form_colour',
				array(
					'default'   => 'ffffff',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_form_colour',
					array(
						'label'    => __( 'Form Background Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_form_colour',
					)
				)
			);

			/**
			 * Form Label Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_form_label_colour',
				array(
					'default'   => 'ffffff',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_form_label_colour',
					array(
						'label'    => __( 'Form Label Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_form_label_colour',
					)
				)
			);

			/**
			 * Button Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_button_colour',
				array(
					'default'   => '000000',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_button_colour',
					array(
						'label'    => __( 'Button Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_button_colour',
					)
				)
			);

			/**
			 * Button Shadow Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_button_shadow_colour',
				array(
					'default'   => '015d82',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_button_shadow_colour',
					array(
						'label'    => __( 'Button Shadow Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_button_shadow_colour',
					)
				)
			);

			/**
			 * Button Hover Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_button_hover_colour',
				array(
					'default'   => '000000',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_button_hover_colour',
					array(
						'label'    => __( 'Button Hover Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_button_hover_colour',
					)
				)
			);

			/**
			 * Button Text Colour
			 */
			$wp_customize->add_setting(
				'lsx_login_button_text_colour',
				array(
					'default'   => '0085ba',
					'type'      => 'theme_mod',
					'transport' => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'lsx_login_button_text_colour',
					array(
						'label'    => __( 'Button Text Colour', 'lsx-customizer' ),
						'section'  => 'login-form',
						'settings' => 'lsx_login_button_text_colour',
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
					'default'   => 'ffffff',
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
							'repeat'  => __( 'Repeat', 'lsx-customizer' ),
							'repeat-x' => __( 'Repeat Horizontally', 'lsx-customizer' ),
							'repeat-y' => __( 'Repeat Vertically', 'lsx-customizer' ),
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
					'default'   => 'none',
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
							'initial'  => __( 'None', 'lsx-customizer' ),
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
			echo wp_kses(
				$styles,
				array(
					'style' => array(),
				)
			);
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
					'logo'                    => get_theme_mod( 'lsx_login_logo', '' ),
					'link_colour'             => get_theme_mod( 'lsx_login_link_colour', '#0085ba' ),
					'link_hover_colour'       => get_theme_mod( 'lsx_login_link_hover_colour', '#0085ba' ),
					'button_colour'           => get_theme_mod( 'lsx_login_button_colour', '#0085ba' ),
					'button_shadow_colour'    => get_theme_mod( 'lsx_login_button_shadow_colour', '#015d82' ),
					'button_hover_colour'     => get_theme_mod( 'lsx_login_button_hover_colour', '#015d82' ),
					'button_text_colour'      => get_theme_mod( 'lsx_login_button_text_colour', '#ffffff' ),
					'login_form_colour'       => get_theme_mod( 'lsx_login_form_colour', '#ffffff' ),
					'login_form_label_colour' => get_theme_mod( 'lsx_login_form_label_colour', '#333333' ),
					'background_colour'       => get_theme_mod( 'lsx_login_bg_colour', '#f2f2f2' ),
					'background_image'        => get_theme_mod( 'lsx_login_bg_image', '' ),
					'background_repeat'       => get_theme_mod( 'lsx_login_bg_repeat', 'no-repeat' ),
					'background_size'         => get_theme_mod( 'lsx_login_bg_size', 'initial' ),
					'custom_css'              => get_theme_mod( 'lsx_login_custom_css', '' ),
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
			$css .= "body.login #nav a:hover, .login h1 a:hover, body.login #backtoblog a:hover { color: {$theme_mods['link_hover_colour']}; }";
			$css .= "body.login.wp-core-ui .button-primary { background-color: {$theme_mods['button_colour']}; }";
			$css .= "body.login.wp-core-ui .button-primary { border-color: {$theme_mods['button_colour']}; }";
			$css .= "body.login.wp-core-ui .button-primary:hover { background-color: {$theme_mods['button_hover_colour']}; }";
			$css .= "body.login.wp-core-ui .button-primary:hover { border-color: {$theme_mods['button_hover_colour']}; }";
			$css .= "body.login .button-primary { box-shadow: 0 1px 0 {$theme_mods['button_shadow_colour']}; }";
			$css .= "body.login .button-primary:active { box-shadow: 0 2px 0 {$theme_mods['button_shadow_colour']}; }";
			$css .= "body.login .button-primary { color: {$theme_mods['button_text_colour']} ; }";
			$css .= 'body.login .button-primary { text-shadow: none; }';
			$css .= "body.login form { background: {$theme_mods['login_form_colour']}; }";
			$css .= "body.login label { color: {$theme_mods['login_form_label_colour']}; }";

			if ( isset( $theme_mods['logo'] ) && '' !== $theme_mods['logo'] ) {
				$css .= "
					#login h1 a, .login h1 a {
						background-image: url('" . $theme_mods['logo'] . "');
						max-height: 150px;
						width: 100%;
						background-size: contain;
						background-repeat: no-repeat;
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
				}
				.wp-core-ui .button-primary, body.login #backtoblog a, body.login #nav a  {
					transition:0.4s;
				}";

			// Add in the custom css
			if ( isset( $theme_mods['custom_css'] ) && '' !== $theme_mods['custom_css'] ) {
				$css .= $theme_mods['custom_css'];
			}

			$css .= '</style>';
			$css  = apply_filters( 'lsx_customizer_login_styles', $css );
			return $css;
		}
	}
	new LSX_Customizer_Login();
}
