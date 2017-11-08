<?php
if ( ! class_exists( 'LSX_Customizer_Frontend' ) ) {

	/**
	 * LSX Customizer Frontend Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Frontend extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ), 2999 );
			add_action( 'wp', array( $this, 'layout' ), 2999 );

			add_filter( 'body_class', array( $this, 'wc_body_class' ), 2999 );
			add_action( 'template_redirect', array( $this, 'wc_thankyou_page' ), 2999 );
			add_action( 'lsx_content_top', array( $this, 'wc_checkout_steps' ), 15 );

			add_action( 'wp', array( $this, 'wp_cart_extra_html' ), 2999 );
			add_action( 'wp', array( $this, 'wp_checkout_extra_html' ), 2999 );
		}

		/**
		 * Enques the assets.
		 *
		 * @since 1.0.0
		 */
		public function assets() {
			wp_enqueue_script( 'lsx-customizer', LSX_CUSTOMIZER_URL . 'assets/js/lsx-customizer.min.js', array( 'jquery' ), LSX_CUSTOMIZER_VER, true );

			$params = apply_filters( 'lsx_customizer_js_params', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			));

			wp_localize_script( 'lsx-customizer', 'lsx_customizer_params', $params );

			wp_enqueue_style( 'lsx-customizer', LSX_CUSTOMIZER_URL . 'assets/css/lsx-customizer.css', array(), LSX_CUSTOMIZER_VER );
			wp_style_add_data( 'lsx-customizer', 'rtl', 'replace' );
		}

		/**
		 * Layout.
		 *
		 * @since 1.0.0
		 */
		public function layout() {
			$theme_credit = get_theme_mod( 'lsx_theme_credit_status', true );

			if ( false == $theme_credit ) {
				add_filter( 'lsx_credit_link', '__return_false' );
			}
		}

		/**
		 * Add and remove WC body_class() classes.
		 *
		 * @since 1.1.1
		 */
		public function wc_body_class( $classes ) {
			if ( class_exists( 'WooCommerce' ) && is_checkout() ) {
				$layout = get_theme_mod( 'lsx_wc_checkout_layout', 'default' );

				if ( 'stacked' === $layout ) {
					$classes[] = 'lsx-wc-checkout-layout-stacked';
				} elseif ( 'columns' === $layout ) {
					$classes[] = 'lsx-wc-checkout-layout-two-column-addreses';
				}
			}

			return $classes;
		}

		/**
		 * WC thank you page.
		 *
		 * @since 1.1.1
		 */
		public function wc_thankyou_page() {
			global $wp;

			if ( class_exists( 'WooCommerce' ) && is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
				$thankyou_page = get_theme_mod( 'lsx_wc_checkout_thankyou_page', '0' );

				if ( ! empty( $thankyou_page ) ) {
					$order_id  = apply_filters( 'woocommerce_thankyou_order_id', absint( $wp->query_vars['order-received'] ) );
					$order_key = apply_filters( 'woocommerce_thankyou_order_key', empty( $_GET['key'] ) ? '' : wc_clean( $_GET['key'] ) );

					if ( $order_id > 0 ) {
						wp_safe_redirect( get_permalink( $thankyou_page ) . '?order-received=' . $order_id . '&key=' . $order_key, 302 );
						exit;
					}
				}
			}
		}

		/**
		 * Display WC checkout steps.
		 *
		 * @since 1.1.1
		 */
		public function wc_checkout_steps() {
			if ( class_exists( 'WooCommerce' ) && ( is_checkout() || is_cart() ) && ! empty( get_theme_mod( 'lsx_wc_checkout_steps', '1' ) ) ) :
				global $wp;
				?>
				<div class="lsx-wc-checkout-steps">
					<ul class="lsx-wc-checkout-steps-items">

						<?php if ( is_cart() ) : ?>

							<li class="lsx-wc-checkout-steps-item">
								<a href="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><?php esc_html_e( 'Choose your product', 'lsx-customizer' ); ?></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '2', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '3', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'Payment details', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'Thank you!', 'lsx-customizer' ); ?></span>
							</li>

						<?php elseif ( is_checkout() && empty( $wp->query_vars['order-received'] ) ) : ?>

							<li class="lsx-wc-checkout-steps-item">
								<a href="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><?php esc_html_e( 'Choose your product', 'lsx-customizer' ); ?></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item">
								<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '3', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'Payment details', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'Thank you!', 'lsx-customizer' ); ?></span>
							</li>

						<?php elseif ( is_checkout() ) : ?>

							<li class="lsx-wc-checkout-steps-item">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><?php esc_html_e( 'Choose your product', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><?php esc_html_e( 'Payment details', 'lsx-customizer' ); ?></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><?php esc_html_e( 'Thank you!', 'lsx-customizer' ); ?></span>
							</li>

						<?php endif; ?>

					</ul>
				</div>
				<?php
			endif;
		}

		/**
		 * Display extra HTML on checkout.
		 *
		 * @since 1.1.1
		 */
		public function wp_checkout_extra_html() {
			if ( class_exists( 'WooCommerce' ) && is_checkout() ) {
				$checkout_extra_html = get_theme_mod( 'lsx_wc_checkout_extra_html', '' );

				if ( ! empty( $checkout_extra_html ) ) {
					add_action( 'woocommerce_review_order_after_payment', array( $this, 'wp_checkout_extra_html_echo' ), 9 );
				}
			}
		}

		/**
		 * Display extra HTML on checkout.
		 *
		 * @since 1.1.1
		 */
		public function wp_checkout_extra_html_echo() {
			if ( class_exists( 'WooCommerce' ) && is_checkout() ) {
				$checkout_extra_html = get_theme_mod( 'lsx_wc_checkout_extra_html', '' );

				if ( ! empty( $checkout_extra_html ) ) { ?>
					<div class="lsx-wc-checkout-extra-html">
						<?php echo wp_kses_post( $checkout_extra_html ); ?>
					</div>
				<?php }
			}
		}

		/**
		 * Display extra HTML on cart.
		 *
		 * @since 1.1.1
		 */
		public function wp_cart_extra_html() {
			if ( class_exists( 'WooCommerce' ) && is_cart() ) {
				$cart_extra_html = get_theme_mod( 'lsx_wc_cart_extra_html', '' );

				if ( ! empty( $cart_extra_html ) ) {
					remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
					add_action( 'woocommerce_cart_collaterals', array( $this, 'wp_cart_extra_html_echo' ), 9 );
				}
			}
		}

		/**
		 * Display extra HTML on cart.
		 *
		 * @since 1.1.1
		 */
		public function wp_cart_extra_html_echo() {
			if ( class_exists( 'WooCommerce' ) && is_cart() ) {
				$cart_extra_html = get_theme_mod( 'lsx_wc_cart_extra_html', '' );

				if ( ! empty( $cart_extra_html ) ) { ?>
					<div class="lsx-wc-cart-extra-html">
						<?php echo wp_kses_post( $cart_extra_html ); ?>
					</div>
				<?php }
			}
		}

	}

	new LSX_Customizer_Frontend;

}
