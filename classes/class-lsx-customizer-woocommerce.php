<?php
if ( ! class_exists( 'LSX_Customizer_WooCommerce' ) ) {

	/**
	 * LSX Customizer WooCommerce Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_WooCommerce extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.1.1
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );

			add_filter( 'body_class', array( $this, 'body_class' ), 2999 );

			add_action( 'template_redirect', array( $this, 'thankyou_page' ), 2999 );

			if ( empty( get_theme_mod( 'lsx_two_step_checkout', false ) ) ) {
				add_action( 'lsx_entry_inside_top', array( $this, 'checkout_steps' ), 15 );
			}

			add_action( 'wp', array( $this, 'cart_extra_html' ), 2999 );
			add_action( 'wp', array( $this, 'checkout_extra_html' ), 2999 );
			add_action( 'lsx_wc_cart_menu_item_position', array( $this, 'cart_menu_item_position' ) );
			add_action( 'lsx_wc_cart_menu_item_class', array( $this, 'cart_menu_item_class' ) );

			add_filter( 'wp_nav_menu_items', array( $this, 'my_account_menu_item' ), 9, 2 );
			add_action( 'lsx_wc_my_account_menu_item_position', array( $this, 'my_account_menu_item_position' ) );
			add_action( 'lsx_wc_my_account_menu_item_class', array( $this, 'my_account_menu_item_class' ) );

			// Shop Layout Switcher.
			//add_action( 'wp_head', array( $this, 'show_layout_switcher' ), 1 );
			//add_filter( 'gridlist_toggle_button_output', array( $this, 'gridlist_toggle_button_output' ), 10, 3 );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.1.1
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Checkout.
			 */

			$wp_customize->add_section( 'lsx-wc-checkout', array(
				'title'       => esc_html__( 'LSX Checkout', 'lsx-customizer' ),
				'description' => esc_html__( 'Change the WooCommerce checkout settings.', 'lsx-customizer' ),
				'panel'       => 'woocommerce',
				'priority'    => 3,
			) );

			$wp_customize->add_setting( 'lsx_checkout_steps', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_checkout_steps', array(
				'label'       => esc_html__( 'Steps', 'lsx-customizer' ),
				'description' => esc_html__( 'Enable the checkout steps header.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_checkout_steps',
				'type'        => 'checkbox',
				'priority'    => 1,
			) ) );

			/**
			 * Checkout Layout
			 */
			$wp_customize->add_setting( 'lsx_wc_checkout_layout', array(
				'default' => 'default',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_layout', array(
				'label'       => esc_html__( 'Layout', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce checkout layout.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_layout',
				'type'        => 'select',
				'priority'    => 2,
				'choices'     => array(
					'default' => esc_html__( 'Default', 'lsx-customizer' ),
					'stacked' => esc_html__( 'Stacked', 'lsx-customizer' ),
					'columns' => esc_html__( 'Columns', 'lsx-customizer' ),
				),
			) ) );

			$wp_customize->add_setting( 'lsx_wc_checkout_thankyou_page', array(
				'default' => '0',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$choices = array(
				'0' => esc_html__( 'Default', 'lsx-customizer' ),
			);

			/**
			 * Distraction Free Checkout
			 */
			$wp_customize->add_setting( 'lsx_distraction_free_checkout', array(
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'lsx_distraction_free_checkout',
				array(
					'label'       => esc_html__( 'Distraction Free Checkout', 'lsx-customizer' ),
					'description' => esc_html__( 'Removes all clutter from the checkout, allowing the customer to focus entirely on that procedure. Removes the stepped cart and checkout.', 'lsx-customizer' ),
					'section'     => 'lsx-wc-checkout',
					'settings'    => 'lsx_distraction_free_checkout',
					'type'        => 'checkbox',
					'priority'    => 3,
				)
			) );

			/**
			 * Two Step Checkout
			 */
			$wp_customize->add_setting( 'lsx_two_step_checkout', array(
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'lsx_two_step_checkout',
				array(
					'label'       => esc_html__( 'Two Step Checkout', 'lsx-customizer' ),
					'description' => esc_html__( 'Separates the customer details collection form, and the order summary / payment details form in to two separate pages. Removes the stepped cart and checkout.', 'lsx-customizer' ),
					'section'     => 'lsx-wc-checkout',
					'settings'    => 'lsx_two_step_checkout',
					'type'        => 'checkbox',
					'priority'    => 4,
				)
			) );

			/**
			 * Thank you page options
			 */
			$pages = get_pages();

			foreach ( $pages as $key => $page ) {
				$choices[ $page->ID ] = $page->post_title;
			}

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_checkout_thankyou_page', array(
				'label'       => esc_html__( 'Thank You Page', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce checkout thank you page.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_thankyou_page',
				'type'        => 'select',
				'priority'    => 5,
				'choices'     => $choices,
			) ) );

			$wp_customize->add_setting( 'lsx_wc_checkout_extra_html', array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses_post',
			) );

			$wp_customize->add_control( new LSX_Customizer_Wysiwyg_Control( $wp_customize, 'lsx_wc_checkout_extra_html', array(
				'label'       => esc_html__( 'Extra HTML', 'lsx-customizer' ),
				'description' => esc_html__( 'Extra HTML to display at checkout page (bottom/right).', 'lsx-customizer' ),
				'section'     => 'lsx-wc-checkout',
				'settings'    => 'lsx_wc_checkout_extra_html',
				'priority'    => 6,
				'type'        => 'wysiwyg',
			) ) );

			/**
			 * Cart.
			 */

			$wp_customize->add_setting( 'lsx_wc_cart_menu_item_style', array(
				'default' => 'extended',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_cart_menu_item_style', array(
				'label'       => esc_html__( 'Menu Item Style', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce menu item cart style.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-cart',
				'settings'    => 'lsx_wc_cart_menu_item_style',
				'type'        => 'select',
				'priority'    => 2,
				'choices'     => array(
					'simple'   => esc_html__( 'Simple', 'lsx-customizer' ),
					'extended' => esc_html__( 'Extended', 'lsx-customizer' ),
				),
			) ) );

			$wp_customize->add_setting( 'lsx_wc_cart_menu_item_position', array(
				'default' => 'main-menu-in',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_cart_menu_item_position', array(
				'label'       => esc_html__( 'Menu Item Position', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce menu item cart position.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-cart',
				'settings'    => 'lsx_wc_cart_menu_item_position',
				'type'        => 'select',
				'priority'    => 3,
				'choices'     => array(
					'main-menu-in'   => esc_html__( 'Main Menu (as last item)', 'lsx-customizer' ),
					'main-menu-out'  => esc_html__( 'Main Menu (as last item, right aligned)', 'lsx-customizer' ),
					'top-menu-left'  => esc_html__( 'Top Menu (left)', 'lsx-customizer' ),
					'top-menu-right' => esc_html__( 'Top Menu (right)', 'lsx-customizer' ),
				),
			) ) );

			$wp_customize->add_setting( 'lsx_wc_cart_extra_html', array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses_post',
			) );

			$wp_customize->add_control( new LSX_Customizer_Wysiwyg_Control( $wp_customize, 'lsx_wc_cart_extra_html', array(
				'label'       => esc_html__( 'Extra HTML', 'lsx-customizer' ),
				'description' => esc_html__( 'Extra HTML to display at cart page (bottom/left).', 'lsx-customizer' ),
				'section'     => 'lsx-wc-cart',
				'settings'    => 'lsx_wc_cart_extra_html',
				'priority'    => 4,
				'type'        => 'wysiwyg',
			) ) );

			/**
			 * My Account.
			 */

			$wp_customize->add_section( 'lsx-wc-my-account', array(
				'title'       => esc_html__( 'LSX My Account', 'lsx-customizer' ),
				'description' => esc_html__( 'Change the WooCommerce My Account settings.', 'lsx-customizer' ),
				'panel'       => 'woocommerce',
				'priority'    => 4,
			) );

			$wp_customize->add_setting( 'lsx_wc_my_account_menu_item', array(
				'default'           => false,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_my_account_menu_item', array(
				'label'       => esc_html__( 'Menu Item', 'lsx-customizer' ),
				'description' => esc_html__( 'Enable the My Account menu item.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-my-account',
				'settings'    => 'lsx_wc_my_account_menu_item',
				'type'        => 'checkbox',
				'priority'    => 1,
			) ) );

			$wp_customize->add_setting( 'lsx_wc_my_account_menu_item_style', array(
				'default' => 'extended',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_my_account_menu_item_style', array(
				'label'       => esc_html__( 'Menu Item Style', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce menu item My Account style.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-my-account',
				'settings'    => 'lsx_wc_my_account_menu_item_style',
				'type'        => 'select',
				'priority'    => 2,
				'choices'     => array(
					'simple'   => esc_html__( 'Simple', 'lsx-customizer' ),
					'extended' => esc_html__( 'Extended', 'lsx-customizer' ),
				),
			) ) );

			$wp_customize->add_setting( 'lsx_wc_my_account_menu_item_position', array(
				'default' => 'main-menu-in',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_wc_my_account_menu_item_position', array(
				'label'       => esc_html__( 'Menu Item Position', 'lsx-customizer' ),
				'description' => esc_html__( 'WooCommerce menu item My Account position.', 'lsx-customizer' ),
				'section'     => 'lsx-wc-my-account',
				'settings'    => 'lsx_wc_my_account_menu_item_position',
				'type'        => 'select',
				'priority'    => 3,
				'choices'     => array(
					'main-menu-in'   => esc_html__( 'Main Menu (as last item)', 'lsx-customizer' ),
					'main-menu-out'  => esc_html__( 'Main Menu (as last item, right aligned)', 'lsx-customizer' ),
					'top-menu-left'  => esc_html__( 'Top Menu (left)', 'lsx-customizer' ),
					'top-menu-right' => esc_html__( 'Top Menu (right)', 'lsx-customizer' ),
				),
			) ) );
		}

		/**
		 * Add and remove WC body_class() classes.
		 *
		 * @since 1.1.1
		 */
		public function body_class( $classes ) {
			$distraction_free = get_theme_mod( 'lsx_distraction_free_checkout', false );
			$two_step_checkout = get_theme_mod( 'lsx_two_step_checkout', false );
			if ( is_checkout() ) {
				$layout = get_theme_mod( 'lsx_wc_checkout_layout', 'default' );

				if ( 'default' === $layout ) {
					$classes[] = 'lsx-wc-checkout-layout-default';
				} elseif ( 'stacked' === $layout ) {
					$classes[] = 'lsx-wc-checkout-layout-stacked';
				} elseif ( 'columns' === $layout ) {
					$classes[] = 'lsx-wc-checkout-layout-two-column-addreses';
				}
				if ( ! empty( $distraction_free ) ) {
					$classes[] = 'lsx-wc-checkout-distraction-free';
				}
				if ( ! empty( $two_step_checkout ) ) {
					$classes[] = 'lsx-wc-checkout-two-steps';
				}
			}

			return $classes;
		}

		/**
		 * WC thank you page.
		 *
		 * @since 1.1.1
		 */
		public function thankyou_page() {
			global $wp;

			if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
				$thankyou_page = get_theme_mod( 'lsx_wc_checkout_thankyou_page', '0' );

				if ( ! empty( $thankyou_page ) && ! is_page( $thankyou_page ) ) {
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
		public function checkout_steps() {
			$cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
			if ( ( is_checkout() || is_cart() ) && ! empty( get_theme_mod( 'lsx_checkout_steps', '1' ) ) ) :
				global $wp;
				?>
				<div class="lsx-wc-checkout-steps">
					<ul class="lsx-wc-checkout-steps-items">

						<?php if ( is_cart() ) : ?>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done">
								<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><span><?php esc_html_e( 'Shop', 'lsx-customizer' ); ?></span></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current lsx-wc-checkout-steps-item-cart">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '2', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled lsx-wc-checkout-steps-item-payment">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '3', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'Billing details', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled lsx-wc-checkout-steps-item-thankyou">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'Payment', 'lsx-customizer' ); ?></span></span>
							</li>

						<?php elseif ( is_checkout() && empty( $wp->query_vars['order-received'] ) ) : ?>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done">
								<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><span><?php esc_html_e( 'Shop', 'lsx-customizer' ); ?></span></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done lsx-wc-checkout-steps-item-cart">
								<a href="<?php echo esc_url( $cart_url ); ?>" class="lsx-wc-checkout-steps-link">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span><span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span></span>
								</a>

								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current lsx-wc-checkout-steps-item-payment">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '3', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'Billing details', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-disabled lsx-wc-checkout-steps-item-thankyou">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'Payment', 'lsx-customizer' ); ?></span></span>
							</li>

						<?php elseif ( is_checkout() ) : ?>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><span><?php esc_html_e( 'Shop', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done lsx-wc-checkout-steps-item-cart">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><span><?php esc_html_e( 'My Cart', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-done lsx-wc-checkout-steps-item-payment">
								<i class="fa fa-check-circle" aria-hidden="true"></i>
								<span><span><?php esc_html_e( 'Billing details', 'lsx-customizer' ); ?></span></span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</li>

							<li class="lsx-wc-checkout-steps-item lsx-wc-checkout-steps-item-current lsx-wc-checkout-steps-item-thankyou">
								<i class="lsx-wc-checkout-steps-counter" aria-hidden="true"><?php esc_html_e( '4', 'lsx-customizer' ); ?></i>
								<span><span><?php esc_html_e( 'Payment', 'lsx-customizer' ); ?></span></span>
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
		public function checkout_extra_html() {
			if ( is_checkout() ) {
				$checkout_extra_html = get_theme_mod( 'lsx_wc_checkout_extra_html', '' );

				if ( ! empty( $checkout_extra_html ) ) {
					add_action( 'woocommerce_review_order_after_payment', array( $this, 'checkout_extra_html_echo' ), 9 );
				}
			}
		}

		/**
		 * Display extra HTML on checkout.
		 *
		 * @since 1.1.1
		 */
		public function checkout_extra_html_echo() {
			if ( is_checkout() ) {
				$checkout_extra_html = get_theme_mod( 'lsx_wc_checkout_extra_html', '' );

				if ( ! empty( $checkout_extra_html ) ) {
					?>
					<div class="lsx-wc-checkout-extra-html">
						<?php echo wp_kses_post( $checkout_extra_html ); ?>
					</div>
				<?php
				}
			}
		}

		/**
		 * Display extra HTML on cart.
		 *
		 * @since 1.1.1
		 */
		public function cart_extra_html() {
			if ( is_cart() ) {
				$cart_extra_html = get_theme_mod( 'lsx_wc_cart_extra_html', '' );

				if ( ! empty( $cart_extra_html ) ) {
					remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
					add_action( 'woocommerce_cart_collaterals', array( $this, 'cart_extra_html_echo' ), 9 );
				}
			}
		}

		/**
		 * Display extra HTML on cart.
		 *
		 * @since 1.1.1
		 */
		public function cart_extra_html_echo() {
			if ( is_cart() ) {
				$cart_extra_html = get_theme_mod( 'lsx_wc_cart_extra_html', '' );

				if ( ! empty( $cart_extra_html ) ) {
                ?>
					<div class="lsx-wc-cart-extra-html">
						<?php echo wp_kses_post( $cart_extra_html ); ?>
					</div>
				<?php
                }
			}
		}

		/**
		 * The place (menu) to display the cart menu item position.
		 *
		 * @since 1.1.1
		 */
		public function cart_menu_item_position( $menu_position ) {
			$position = get_theme_mod( 'lsx_wc_cart_menu_item_position', '' );

			if ( ! empty( $position ) ) {
				switch ( $position ) {
					case 'main-menu-in':
					case 'main-menu-out':
						$menu_position = 'primary';
						break;

					case 'top-menu-right':
						$menu_position = 'top-menu';
						break;

					case 'top-menu-left':
						$menu_position = 'top-menu-left';
						break;
				}
			}

			return $menu_position;
		}

		/**
		 * The place (menu) to display the cart menu item position.
		 *
		 * @since 1.1.1
		 */
		public function cart_menu_item_class( $item_class ) {
			$position = get_theme_mod( 'lsx_wc_cart_menu_item_position', '' );

			if ( 'main-menu-out' === $position ) {
				$item_class .= ' lsx-wc-cart-menu-item-right-aligned';
			}

			$style = get_theme_mod( 'lsx_wc_cart_menu_item_style', '' );

			if ( 'simple' === $style ) {
				$item_class .= ' lsx-wc-cart-menu-item-simple';
			}

			return $item_class;
		}

		/**
		 * Adds WC My Account to the header.
		 *
		 * @since 1.1.1
		 */
		public function my_account_menu_item( $items, $args ) {
			$my_account_menu_item_position = apply_filters( 'lsx_wc_my_account_menu_item_position', 'primary' );

			if ( $my_account_menu_item_position === $args->theme_location || ( 'primary_logged_out' === $args->theme_location && 'primary' === $my_account_menu_item_position ) ) {
				$customizer_option  = get_theme_mod( 'lsx_wc_my_account_menu_item', false );

				if ( ! empty( $customizer_option ) ) {
					if ( is_account_page() ) {
						$class = 'current-menu-item';
					} else {
						$class = '';
					}

					$item_class = 'menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children dropdown lsx-wc-my-account-menu-item ' . $class;
					$item_class = apply_filters( 'lsx_wc_my_account_menu_item_class', $item_class );

					$endpoints = WC()->query->get_query_vars();

					if ( is_user_logged_in() ) {
						$item  = '<li class="' . $item_class . '">';
						$item .= '<a title="' . esc_attr__( 'View your account', 'lsx-customizer' ) . '" href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true"><span>' . esc_attr__( 'My Account', 'lsx-customizer' ) . '</span></a>';
						$item .= '<ul role="menu" class=" dropdown-menu lsx-wc-my-account-sub-menu">';
							foreach ( wc_get_account_menu_items() as $endpoint => $label ) {
								$slug = $endpoint;
								if ( isset( $endpoints[ $endpoint ] ) && '' !== $endpoints[ $endpoint ] ) {
									$slug = $endpoints[ $endpoint ];
								}
								if ( 'dashboard' === $slug ) {
									$slug = '';
								}
								$item .= '<li class="menu-item"><a title="" href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) . $slug ) . '">' . $label . '</a></li>';
							}
						$item .= '</ul></li>';

					} else {
						$item = '<li class="' . $item_class . '">' .
									'<a title="' . esc_attr__( 'View your account', 'lsx-customizer' ) . '" href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '"><span>' . esc_attr__( 'Login', 'lsx-customizer' ) . '</span></a>' .
								'</li>';
					}

					$item = apply_filters( 'lsx_wc_my_account_menu_item', $item );

					if ( 'top-menu' === $args->theme_location ) {
						$items = $item . $items;
					} else {
						$items = $items . $item;
					}
				}
			}

			return $items;
		}

		/**
		 * The place (menu) to display the My Account menu item position.
		 *
		 * @since 1.1.1
		 */
		public function my_account_menu_item_position( $menu_position ) {
			$position = get_theme_mod( 'lsx_wc_my_account_menu_item_position', '' );

			if ( ! empty( $position ) ) {
				switch ( $position ) {
					case 'main-menu-in':
					case 'main-menu-out':
						$menu_position = 'primary';
						break;

					case 'top-menu-right':
						$menu_position = 'top-menu';
						break;

					case 'top-menu-left':
						$menu_position = 'top-menu-left';
						break;
				}
			}

			return $menu_position;
		}

		/**
		 * The place (menu) to display the My Account menu item position.
		 *
		 * @since 1.1.1
		 */
		public function my_account_menu_item_class( $item_class ) {
			$position = get_theme_mod( 'lsx_wc_my_account_menu_item_position', '' );

			if ( 'main-menu-out' === $position ) {
				$item_class .= ' lsx-wc-my-account-menu-item-right-aligned';
			}

			if ( ! is_user_logged_in() ) {
				$item_class .= ' lsx-wc-my-account-login';
			}

			$style = get_theme_mod( 'lsx_wc_my_account_menu_item_style', '' );

			if ( 'simple' === $style ) {
				$item_class .= ' lsx-wc-my-account-menu-item-simple';
			}

			return $item_class;
		}
		/**
		 * Display the woocommerce archive swticher.
		 */
		public function show_layout_switcher() {
			$body_classes = get_body_class();
			if ( in_array( 'post-type-archive-product', $body_classes ) ) {
				global $WC_List_Grid;
				if ( null !== $WC_List_Grid ) {
					remove_action( 'woocommerce_before_shop_loop', array( $WC_List_Grid, 'gridlist_toggle_button' ), 30 );
					add_action( 'lsx_banner_inner_bottom', array( $this, 'shop_gridlist_toggle_button' ), 90 );
					add_action( 'lsx_global_header_inner_bottom', array( $this, 'shop_gridlist_toggle_button' ), 90 );
					wp_deregister_style( 'grid-list-button' );
				}
			}
		}
		/**
		 * Display the woocommerce archive swticher.
		 */
		public function shop_gridlist_toggle_button() {
			global $WC_List_Grid;
			?>
			<div class="lsx-layout-switcher">
				<span class="lsx-layout-switcher-label"><?php esc_html_e( 'Select view:', 'lsx-blog-customizer' ); ?></span>
				<?php $WC_List_Grid->gridlist_toggle_button(); ?>
			</div>
			<?php
		}
		public function gridlist_toggle_button_output( $output, $grid_view, $list_view ) {
			$output = sprintf( '<div class="gridlist-toggle lsx-layout-switcher-options"><a href="#" class="lsx-layout-switcher-option" id="grid" title="%1$s"><span class="fa fa fa-th"></span></a><a href="#" class="lsx-layout-switcher-option" id="list" title="%2$s"><span class="fa fa-bars"></span></a></div>', $grid_view, $list_view );
			return $output;
		}
	}

	new LSX_Customizer_WooCommerce();

}
