<?php
if ( ! class_exists( 'LSX_Customizer' ) ) {

	/**
	 * LSX Customizer Main Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer {

		/**
		 * Plugin slug.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $plugin_slug = 'lsx-customizer';

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-admin.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-frontend.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-core.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-login.php' );

			add_action( 'plugins_loaded', array( $this, 'woocommerce' ) );
			add_action( 'after_setup_theme', array( $this, 'wysiwyg_editor_control' ), 20 );
			add_filter( 'login_headerurl', array( $this, 'custom_login_url' ) );
		}

		/**
		 * Check if WooCommerce is installed to load the related file.
		 *
		 * @since 1.1.1
		 */
		public function woocommerce() {
			if ( class_exists( 'WooCommerce' ) ) {
				require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-woocommerce.php' );
				require_once( LSX_CUSTOMIZER_PATH . 'includes/woocommerce/woocommerce.php' );
				require_once( LSX_CUSTOMIZER_PATH . 'includes/woocommerce/addons.php' );
			}
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.1.1
		 */
		public function wysiwyg_editor_control() {
			if ( class_exists( 'WP_Customize_Control' ) ) {
				require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-wysiwyg-control.php' );
			}
		}

		/**
		 * Sanitize checkbox.
		 *
		 * @since 1.0.0
		 */
		public function sanitize_checkbox( $input ) {
			return ( 1 === absint( $input ) ) ? 1 : 0;
		}

		/**
		 * Sanitize select.
		 *
		 * @since 1.1.1
		 */
		public function sanitize_select( $input ) {
			if ( is_string( $input ) || is_integer( $input ) || is_bool( $input ) ) {
				return $input;
			} else {
				return '';
			}
		}

		/**
		 * Sanitize textarea.
		 *
		 * @since 1.1.1
		 */
		public function sanitize_textarea( $input ) {
			return wp_kses_post( $input );
		}

		function custom_login_url() {
			return home_url();
		}

	}

	new LSX_Customizer();

}
