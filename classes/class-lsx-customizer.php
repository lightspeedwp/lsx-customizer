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

			add_action( 'plugins_loaded', array( $this, 'woocommerce' ) );
		}

		/**
		 * Check if WooCommerce is installed to load the related file.
		 *
		 * @since 1.1.1
		 */
		public function woocommerce() {
			if ( class_exists( 'WooCommerce' ) ) {
				require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-woocommerce.php' );
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

	}

	new LSX_Customizer();

}
