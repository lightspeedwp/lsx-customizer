<?php
if ( ! class_exists( 'LSX_Customizer_Wysiwyg_Control' ) ) {

	/**
	 * LSX Customizer Wysiwyg Control Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Wysiwyg_Control extends WP_Customize_Control {

		public $type = 'wysiwyg';

		/**
		 * Render the control's content.
		 *
		 * @since 1.1.1
		 */
		public function render_content() {
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php
					$settings = array(
						'media_buttons' => false,
						'teeny' => true,
					);

					$this->filter_editor_setting_link();
					wp_editor( $this->value(), $this->id, $settings );
				?>
			</label>
			<?php
			do_action( 'admin_footer' );
			do_action( 'admin_print_footer_scripts' );
		}

		/**
		 * Filter editor setting link.
		 *
		 * @since 1.1.1
		 */
		private function filter_editor_setting_link() {
			add_filter( 'the_editor', function( $output ) {
				return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 );
			} );
		}

	}

}

