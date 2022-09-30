<?php
if ( ! class_exists( 'LSX_Customizer_Colour' ) ) {

	/**
	 * LSX Customizer Colour Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour extends LSX_Customizer {

		/**
		 * Button customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $button;

		/**
		 * Button CTA customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $button_cta;

		/**
		 * Button secondary customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $button_secondary;

		/**
		 * Button tertiary customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $button_tertiary;

		/**
		 * Top Menu customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $top_menu;

		/**
		 * Header customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $header;

		/**
		 * Main menu customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $main_menu;

		/**
		 * Banner customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $banner;

		/**
		 * Body customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $body;

		/**
		 * Footer CTA customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $footer_cta;

		/**
		 * Footer Widgets customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $footer_widgets;

		/**
		 * Footer customizer instance.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $footer;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme',                       array( $this, 'after_setup_theme' ), 20 );
			add_action( 'customize_register',                      array( $this, 'customize_register' ), 20 );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'colour_scheme_css_template' ) );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function after_setup_theme() {
			require_once( LSX_CUSTOMIZER_PATH . 'includes/lsx-customizer-colour-options.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'includes/lsx-customizer-colour-deprecated.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'includes/lsx-customizer-templates.php' );

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button.php' );
			$this->button = new LSX_Customizer_Colour_Button();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button-cta.php' );
			$this->button_cta = new LSX_Customizer_Colour_Button_CTA();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button-secondary.php' );
			$this->button_secondary = new LSX_Customizer_Colour_Button_Secondary();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button-tertiary.php' );
			$this->button_tertiary = new LSX_Customizer_Colour_Button_Tertiary();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-top-menu.php' );
			$this->top_menu = new LSX_Customizer_Colour_Top_Menu();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-header.php' );
			$this->header = new LSX_Customizer_Colour_Header();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-main-menu.php' );
			$this->main_menu = new LSX_Customizer_Colour_Main_Menu();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-banner.php' );
			$this->banner = new LSX_Customizer_Colour_Banner();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-body.php' );
			$this->body = new LSX_Customizer_Colour_Body();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer-cta.php' );
			$this->footer_cta = new LSX_Customizer_Colour_Footer_CTA();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer-widgets.php' );
			$this->footer_widgets = new LSX_Customizer_Colour_Footer_Widgets();

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer.php' );
			$this->footer = new LSX_Customizer_Colour_Footer();
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			global $customizer_colour_names;
			global $customizer_colour_choices;

			/**
			 * Colors
			 */
			$wp_customize->add_panel( 'colors', array(
				'title'             => esc_html__( 'Site Design', 'lsx-customizer' ),
				'priority'          => 60,
			) );

			$wp_customize->add_section( 'colors-palette', array(
				'title'             => esc_html__( 'Block Editor', 'lsx-customizer' ),
				'description' => esc_html__( 'Define the block editor colour pallette.', 'lsx-customizer' ),
				'priority'          => 2,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-button', array(
				'title'             => esc_html__( 'Button', 'lsx-customizer' ),
				'priority'          => 3,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-button-cta', array(
				'title'             => esc_html__( 'Button CTA', 'lsx-customizer' ),
				'priority'          => 4,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-button-secondary', array(
				'title'             => esc_html__( 'Button Secondary', 'lsx-customizer' ),
				'priority'          => 5,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-button-tertiary', array(
				'title'             => esc_html__( 'Button Tertiary', 'lsx-customizer' ),
				'priority'          => 6,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-top-menu', array(
				'title'             => esc_html__( 'Top Menu', 'lsx-customizer' ),
				'priority'          => 7,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-header', array(
				'title'             => esc_html__( 'Header', 'lsx-customizer' ),
				'priority'          => 8,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-main-menu', array(
				'title'             => esc_html__( 'Main Menu', 'lsx-customizer' ),
				'priority'          => 9,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-banner', array(
				'title'             => esc_html__( 'Banner', 'lsx-customizer' ),
				'priority'          => 10,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-body', array(
				'title'             => esc_html__( 'Body', 'lsx-customizer' ),
				'priority'          => 11,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-footer-cta', array(
				'title'             => esc_html__( 'Footer CTA', 'lsx-customizer' ),
				'priority'          => 12,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-footer-widgets', array(
				'title'             => esc_html__( 'Footer Widgets', 'lsx-customizer' ),
				'priority'          => 13,
				'panel'             => 'colors',
			) );

			$wp_customize->add_section( 'colors-footer', array(
				'title'             => esc_html__( 'Footer', 'lsx-customizer' ),
				'priority'          => 14,
				'panel'             => 'colors',
			) );

			/**
			 * Colour Palette
			 */
			$colors = $this->get_color_scheme();

			$customizer_colour_defaults = array(
				__( 'Primary Colour', 'lsx-customizer' )   => get_theme_mod( 'primary_colour', $colors['button_background_color'] ),
				__( 'Strong Primary Colour', 'lsx-button_shadow' ) => get_theme_mod( 'strong_primary_colour', $colors['button_background_hover_color'] ),
				__( 'Call To Action Colour', 'lsx-customizer' ) => get_theme_mod( 'call_to_action_colour', $colors['button_cta_background_color'] ),
				__( 'Strong CTA Colour', 'lsx-button_shadow' ) => get_theme_mod( 'strong_cta_colour', $colors['button_cta_shadow'] ),
				__( 'Secondary Colour', 'lsx-customizer' ) => get_theme_mod( 'secondary_colour', $colors['button_secondary_background_color'] ),
				__( 'Strong Secondary Colour', 'lsx-button_shadow' ) => get_theme_mod( 'strong_secondary_colour', $colors['button_secondary_shadow'] ),
				__( 'Tertiary Colour', 'lsx-customizer' )  => get_theme_mod( 'tertiary_colour', $colors['button_tertiary_background_color'] ),
				__( 'Strong Tertiary Colour', 'lsx-button_shadow' ) => get_theme_mod( 'strong_tertiary_colour', $colors['button_tertiary_shadow'] ),
			);
			foreach ( $customizer_colour_defaults as $key => $value ) {

				$color_name = strtolower( str_replace( ' ', '_', $key ) );
				$color_name = $color_name;

				$wp_customize->add_setting( $color_name, array(
					'default'           => $value,
					'type'              => 'theme_mod',
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				) );
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$color_name,
						array(
							'label'    => $key,
							'section'  => 'colors-palette',
							'settings' => $color_name,
						)
					)
				);
			}

			/**
			 * Colors
			 */
			foreach ( $customizer_colour_names as $key => $value ) {
				$sanitize_callback = 'sanitize_hex_color';

				if ( 'background_color' === $key ) {
					$sanitize_callback = 'sanitize_hex_color_no_hash';
				}

				$section = 'colors-core';

				if ( preg_match( '/^button_cta_.*/', $key ) ) {
					$section = 'colors-button-cta';
				} elseif ( preg_match( '/^button_secondary_.*/', $key ) ) {
					$section = 'colors-button-secondary';
				} elseif ( preg_match( '/^button_tertiary_.*/', $key ) ) {
					$section = 'colors-button-tertiary';
				} elseif ( preg_match( '/^button_.*/', $key ) ) {
					$section = 'colors-button';
				} elseif ( preg_match( '/^top_menu_.*/', $key ) ) {
					$section = 'colors-top-menu';
				} elseif ( preg_match( '/^header_.*/', $key ) ) {
					$section = 'colors-header';
				} elseif ( preg_match( '/^main_menu_.*/', $key ) ) {
					$section = 'colors-main-menu';
				} elseif ( preg_match( '/^banner_.*/', $key ) ) {
					$section = 'colors-banner';
				} elseif ( preg_match( '/^body_.*/', $key ) || 'background_color' === $key ) {
					$section = 'colors-body';
				} elseif ( preg_match( '/^footer_cta_.*/', $key ) ) {
					$section = 'colors-footer-cta';
				} elseif ( preg_match( '/^footer_widgets_.*/', $key ) ) {
					$section = 'colors-footer-widgets';
				} elseif ( preg_match( '/^footer_.*/', $key ) ) {
					$section = 'colors-footer';
				}

				$wp_customize->add_setting( $key, array(
					'default'           => $customizer_colour_choices['default']['colors'][ $key ],
					'type'              => 'theme_mod',
					'transport'         => 'postMessage',
					'sanitize_callback' => $sanitize_callback,
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
					'label'             => $value,
					'section'           => $section,
					'settings'          => $key,
				) ) );
			}
		}

		/**
		 * Outputs an Underscore template for generating CSS for the color scheme.
		 *
		 * @since 1.0.0
		 */
		public function colour_scheme_css_template() {
			global $customizer_colour_names;

			$colors = array();

			foreach ( $customizer_colour_names as $key => $value ) {
				$colors[ $key ] = 'unquote("{{ data.' . $key . ' }}")';
			}
			?>
			<script type="text/html" id="tmpl-lsx-color-scheme">
				<?php echo esc_attr( $this->top_menu->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->header->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->main_menu->get_css( $colors ) ); ?>

				<?php echo esc_attr( $this->banner->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->body->get_css( $colors ) ); ?>

				<?php echo esc_attr( $this->footer_cta->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->footer_widgets->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->footer->get_css( $colors ) ); ?>

				<?php echo esc_attr( $this->button->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->button_cta->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->button_secondary->get_css( $colors ) ); ?>
				<?php echo esc_attr( $this->button_tertiary->get_css( $colors ) ); ?>
			</script>
			<?php
		}

		/**
		 * Transform SCSS to CSS.
		 *
		 * @since 1.0.0
		 */
		public function scss_to_css( $scss ) {
			$css                 = '';
			$scss_php_file       = LSX_CUSTOMIZER_PATH . 'vendor/leafo/scssphp/scss.inc.php';
			$lsx_theme_sass_file = get_template_directory() . '/assets/css/scss/lsx.scss';

			if ( ! empty( $scss ) && file_exists( $scss_php_file ) && file_exists( $lsx_theme_sass_file ) ) {
				require_once $scss_php_file;

				$compiler = new \Leafo\ScssPhp\Compiler();
				$compiler->setFormatter( 'Leafo\ScssPhp\Formatter\Compact' );

				try {
					$scss = '
						@import "' . LSX_CUSTOMIZER_PATH . '/assets/css/scss/include-media";
						@import "' . get_template_directory() . '/assets/css/scss/global/lsx-variables";
						@import "' . get_template_directory() . '/assets/css/scss/global/mixins/colours-helper";
						' . $scss . '
					';

					$css = $compiler->compile( $scss );
				} catch ( \Exception $e ) {
					$error = $e->getMessage();
					return "/*\n\n\$error:\n\n{$error}\n\n\$scss:\n\n{$scss} */";
				}
			}

			return $css;
		}

		/**
		 * Converts a HEX value to RGB.
		 *
		 * @since 1.0.0
		 */
		public static function hex2rgb( $color ) {
			$color = trim( $color, '#' );

			if ( strlen( $color ) === 3 ) {
				$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
				$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
				$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
			} elseif ( strlen( $color ) === 6 ) {
				$r = hexdec( substr( $color, 0, 2 ) );
				$g = hexdec( substr( $color, 2, 2 ) );
				$b = hexdec( substr( $color, 4, 2 ) );
			} else {
				return array();
			}

			return array(
				'red'   => $r,
				'green' => $g,
				'blue'  => $b,
			);
		}

		/**
		 * Retrieves the current color scheme.
		 *
		 * @since 1.0.0
		 */
		public function get_color_scheme() {
			global $customizer_colour_choices;

			//$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
			$color_schemes = $customizer_colour_choices;

			// if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
			// 	return $color_schemes[ $color_scheme_option ]['colors'];
			// }

			return $color_schemes['default']['colors'];
		}

	}

	new LSX_Customizer_Colour();

}
