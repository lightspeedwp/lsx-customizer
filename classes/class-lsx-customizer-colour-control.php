<?php
if ( ! class_exists( 'LSX_Customizer_Colour_Control' ) ) {

	/**
	 * LSX Customizer Colour Control Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Colour_Control extends WP_Customize_Control {

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue() {
			wp_enqueue_script( 'lsx_customizer_colour_admin', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer-colour-admin.min.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), LSX_CUSTOMIZER_VER, true );
			//wp_localize_script( 'lsx_customizer_colour_admin', 'color_scheme', $this->choices );

			global $customizer_colour_names;
			$colors = array();
			foreach ( $customizer_colour_names as $key => $value ) {
				$colors[] = $key;
			}
			wp_localize_script( 'lsx_customizer_colour_admin', 'color_scheme_keys', $colors );
		}

		/**
		 * Render the control's content.
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}

			?>
			<label>
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php
}
if ( ! empty( $this->description ) ) {
					?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<select <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $value => $label ) {
							echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label['label'] ) . '</option>';
					}
					?>
				</select>
			</label>
		<?php
		}

	}

}

