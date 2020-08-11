<?php
/**
 * Customizer template functions.
 *
 * @package   LSX Customizer
 */

if ( ! function_exists( 'lsx_customizer_checkout_form_wrapper_div' ) ) {
	/**
	 * Used to wrap the checkout form in a div and include navigation links
	 *
	 * @return void
	 */
	function lsx_customizer_checkout_form_wrapper_div() {
		echo '<div class="lsx-checkout-slides">'; ?>
			<ul class="lsx-checkout-control-nav">
				<li><a href="#"><?php esc_html_e( 'Your Details', 'lsx-customizer' ); ?></a></li>
				<li><a href="#"><?php esc_html_e( 'Your Order', 'lsx-customizer' ); ?></a></li>
			</ul>
			<?php
	}
}

if ( ! function_exists( 'lsx_customizer_close_div' ) ) {
	/**
	 * Close a div
	 *
	 * @return void
	 */
	function lsx_customizer_close_div() {
		echo '</div>';
	}
}

if ( ! function_exists( 'lsx_customizer_checkout_form_wrapper' ) ) {
	/**
	 * Used to wrap the checkout form in a ul
	 *
	 * @return void
	 */
	function lsx_customizer_checkout_form_wrapper() {
		echo '<ul class="lsx-two-step-checkout">';
	}
}

if ( ! function_exists( 'lsx_customizer_close_ul' ) ) {
	/**
	 * Close the ul that wraps the checkout form
	 *
	 * @return void
	 */
	function lsx_customizer_close_ul() {
		echo '</ul>';
	}
}


if ( ! function_exists( 'lsx_customizer_address_wrapper' ) ) {
	/**
	 * Used to wrap the address fields on the ckecout in an li
	 *
	 * @return void
	 */
	function lsx_customizer_address_wrapper() {
		echo '<li class="lsx-customizer-addresses">';
	}
}

if ( ! function_exists( 'lsx_customizer_close_li' ) ) {
	/**
	 * Close an li
	 *
	 * @return void
	 */
	function lsx_customizer_close_li() {
		echo '</li>';
	}
}

if ( ! function_exists( 'lsx_customizer_order_review_wrap' ) ) {
	/**
	 * Used to wrap the order review in an li
	 *
	 * @return void
	 */
	function lsx_customizer_order_review_wrap() {
		echo '<li class="order-review">';
		echo '<h3 id="order_review_heading">' . esc_html__( 'Your order', 'lsx-customizer' ) . '</h3>';
	}
}

if ( ! function_exists( 'lsx_customizer_fire_flexslider' ) ) {
	/**
	 * Fire FlexSlider
	 *
	 * @return void
	 */
	function lsx_customizer_fire_flexslider() {
		?>
		<script>
		jQuery( window ).load(function() {
			jQuery( '.lsx-checkout-slides' ).flexslider({
				selector:       '.lsx-two-step-checkout > li',
				slideshow:      false,
				prevText:       '<?php esc_html_e( 'Back to my details', 'lsx-customizer' ); ?>',
				nextText:       '<?php esc_html_e( 'Proceed to payment', 'lsx-customizer' ); ?>',
				animationLoop:  false,
				manualControls: '.lsx-checkout-control-nav li a',
				keyboard:       false,
				smoothHeight: true,
			});


			jQuery( '.flex-direction-nav a' ).removeAttr( 'href' ).addClass( 'button' );

			jQuery( '.flex-direction-nav a' ).click(function() {
				jQuery( 'html, body' ).animate( {
					scrollTop: jQuery( 'form.checkout' ).offset().top
				}, 400 );
			});

			jQuery( '.flex-direction-nav a' ).on( 'touchstart', function() {
				jQuery( 'body' ).animate( {
					scrollTop: jQuery( 'form.checkout' ).offset().top
				}, 400 );
			});
		});
		</script>
		<?php
	}
}
