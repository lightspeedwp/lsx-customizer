<?php
if ( ! class_exists( 'LSX_Customizer_Admin' ) ) {

	/**
	 * LSX Customizer Admin Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Admin extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_preview_init', array( $this, 'assets' ), 9999 );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'assets_wysiwyg_editor' ), 9999 );

			if ( is_admin() ) {
				add_filter( 'lsx_customizer_colour_selectors_body', array( $this, 'customizer_body_colours_handler' ), 15, 2 );
			}
		}

		/**
		 * Enques the assets.
		 *
		 * @since 1.0.0
		 */
		public function assets() {
			wp_enqueue_script( 'lsx_customizer_admin', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer-admin.min.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_admin_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx_customizer_admin', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx_customizer_admin', LSX_CUSTOMIZER_URL . 'assets/css/lsx-customizer-admin.css', array(), LSX_CUSTOMIZER_VER );
		}

		/**
		 * Enques the assets for editor.
		 *
		 * @since 1.1.1
		 */
		public function assets_wysiwyg_editor() {
			wp_enqueue_script( 'lsx_customizer_editor', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer-editor.min.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );
		}

		/**
		 * Handle body colours that might be change by LSX Customizer.
		 */
		public function customizer_body_colours_handler( $css, $colors ) {
			$css .= '
				@import "' . LSX_CUSTOMIZER_PATH . '/assets/css/scss/customizer-customizer-body-colours";

				/**
				 * LSX Customizer - Body (LSX Customizer)
				 */
				@include customizer-customizer-body-colours (
					$bg:   		' . $colors['background_color'] . ',
					$breaker:   ' . $colors['body_line_color'] . ',
					$color:    	' . $colors['body_text_color'] . ',
					$link:    	' . $colors['body_link_color'] . ',
					$hover:    	' . $colors['body_link_hover_color'] . ',
					$small:    	' . $colors['body_text_small_color'] . ',
				);
			';

			return $css;
		}

	}

	new LSX_Customizer_Admin();

}
