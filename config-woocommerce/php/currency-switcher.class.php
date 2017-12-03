<?php

if (!class_exists('TERMINUS_WC_CURRENCY_SWITCHER')) {

	class TERMINUS_WC_CURRENCY_SWITCHER extends TERMINUS_WOOCOMMERCE_CONFIG {

		public $base;
		public $currency;
		public $rates;
		public $settings;

		function __construct() {

			$this->settings = array(
				array( 'name' => esc_html__( 'Currency Codes', 'terminus' ), 'type' => 'title', 'desc' => '', 'id' => 'wc_currency_code' ),
				array(
					'name' => esc_html__('Codes', 'terminus'),
					'desc' 		=> '',
					'id' 		=> 'wc_currency_codes',
					'css'     => 'width:25%; height: 65px;',
					'type' 		=> 'textarea',
					'std'		=> ''
				),
				array( 'type' => 'sectionend', 'id' => 'wc_currency_code' ),
				array( 'name' => esc_html__( 'Open Exchange Rate API', 'terminus' ), 'type' => 'title', 'desc' => '', 'id' => 'product_enquiry' ),
				array(
					'name' => esc_html__('App Key', 'terminus'),
					'desc' 		=> sprintf( wp_kses(__('(optional) If you have an <a href="%s">Open Exchange Rate API app ID</a>, enter it here.', 'terminus'), array('a' => array('href' => array()))), 'https://openexchangerates.org/signup' ),
					'id' 		=> 'wc_currency_converter_app_id',
					'type' 		=> 'text',
					'std'		=> ''
				),
				array( 'type' => 'sectionend', 'id' => 'product_enquiry')
			);


			if ( false === ( $rates = get_transient( 'woocommerce_currency_converter_rates' ) ) ) {
				$app_id = get_option( 'wc_currency_converter_app_id' ) ? get_option( 'wc_currency_converter_app_id' ) : 'e65018798d4a4585a8e2c41359cc7f3c';
				$rates = wp_remote_retrieve_body( wp_remote_get( 'http://openexchangerates.org/api/latest.json?app_id=' . $app_id ) );

				// Cache for 12 hours
				if ( $rates ) {
					set_transient( 'woocommerce_currency_converter_rates', $rates, 60*60*12 );
				}
			}

			$rates = json_decode( $rates );
			if ( $rates ) {
				$this->base	 = $rates->base;
				$this->rates = $rates->rates;
			}

			// Hooks Actions
			add_action('wp_enqueue_scripts', array( &$this, 'enqueue_currency_js'), 10);
			add_action('woocommerce_checkout_update_order_meta', array( &$this, 'update_order_meta'));

			// Set
			add_action('woocommerce_settings_general_options_after', array(&$this, 'admin_settings'));
			add_action('woocommerce_update_options_general', array(&$this, 'save_admin_settings'));
		}

		function admin_settings() {
			woocommerce_admin_fields( $this->settings );
		}

		function save_admin_settings() {
			woocommerce_update_options( $this->settings );
		}

		public function enqueue_currency_js() {

			if (is_admin()) return;

			$assets_js_url = self::$pathes['BASE_URI'] . self::$pathes['ASSETS_DIR_NAME'] . '/js/';

			wp_enqueue_script( 'terminus_money_js', $assets_js_url . 'money.min.js', array( 'jquery', 'terminus_woocommerce-mod' ), '', true );

			$symbols = array();
			if ( function_exists( 'get_woocommerce_currencies' ) ) {
				$currencies = get_woocommerce_currencies();
				foreach ( $currencies as $code => $name ) {
					$symbols[$code] = get_woocommerce_currency_symbol( $code );
				}
			}

			$zero_replace = '.';
			for ( $i = 0; $i < absint( get_option( 'woocommerce_price_num_decimals' ) ); $i++ ) {
				$zero_replace .= '0';
			}

			wp_localize_script( 'terminus_woocommerce-mod', 'wc_currency_converter_params', array(
				'current_currency' => isset( $_COOKIE['woocommerce_current_currency'] ) ? $_COOKIE['woocommerce_current_currency'] : '',
				'currencies'       => json_encode( $symbols ),
				'rates'            => $this->rates,
				'base'             => $this->base,
				'currency'         => get_option( 'woocommerce_currency' ),
				'currency_pos'     => get_option( 'woocommerce_currency_pos' ),
				'num_decimals'     => absint( get_option( 'woocommerce_price_num_decimals' ) ),
				'trim_zeros'       => get_option( 'woocommerce_price_trim_zeros' ) == 'yes' ? true : false,
				'thousand_sep'     => get_option( 'woocommerce_price_thousand_sep' ),
				'decimal_sep'      => get_option( 'woocommerce_price_decimal_sep' ),
				'i18n_oprice'      => esc_html__( 'Original price:', 'terminus'),
				'zero_replace'     => $zero_replace
			));
		}

		public static function output_switcher_html() {
			$currency = '';

			if (function_exists( 'get_woocommerce_currency' )) {
				$currency = get_woocommerce_currency();
			}

			ob_start() ?>

			<?php if (!empty($currency)): ?>

				<li>

					<div class="dropdown_wrap currency_change">

						<a href="javascript:void(0)" id="currency_btn" class="info_link">
							<?php
								if (isset( $_COOKIE['woocommerce_current_currency'] ) && $_COOKIE['woocommerce_current_currency'] != '') {
									$currency = $_COOKIE['woocommerce_current_currency'];
								}
								echo esc_html($currency);
							?>
						</a>

						<?php if (get_option('wc_currency_codes') !== ''): ?>
							<?php $currencies = array_map('trim', explode("\n", get_option('wc_currency_codes'))); ?>
						<?php else: ?>
							<?php $currencies = array(); ?>
						<?php endif; ?>

						<?php if (!empty($currencies)): ?>

							<div class="dropdown">

								<ul class="sub-list currency-switcher">

									<?php foreach( $currencies as $currency ): $class = ""; ?>

										<?php if ( $currency == get_option('woocommerce_currency')): ?>
											<?php $class = 'default'; ?>
										<?php endif; ?>

										<li>
											<a class="<?php echo esc_attr($class) ?>" href="javascript:void(0)" data-currency-code="<?php echo esc_attr( $currency ) ?>">
												<?php echo esc_html($currency) ?>
											</a>
										</li>

									<?php endforeach; ?>

								</ul><!--/ .submenu-->

							</div><!--/ .dropdown-->

						<?php endif; ?>

					</div><!--/ .dropdown_wrap-->

				</li>

			<?php endif; ?>

			<?php return ob_get_clean();
		}

		function update_order_meta( $order_id ) {
			global $woocommerce;

			if (isset($_COOKIE['woocommerce_current_currency']) && $_COOKIE['woocommerce_current_currency']) {

				update_post_meta( $order_id, 'Viewed Currency', $_COOKIE['woocommerce_current_currency'] );

				$order_total = number_format($woocommerce->cart->total, 2, '.', '');

				$store_currency = get_option('woocommerce_currency');
				$target_currency = $_COOKIE['woocommerce_current_currency'];

				if ($store_currency && $target_currency && $this->rates->$target_currency && $this->rates->$store_currency) {
					$new_order_total = ( $order_total / $this->rates->$store_currency ) * $this->rates->$target_currency;
					$new_order_total = round($new_order_total, 2) . ' ' . $target_currency;
					update_post_meta( $order_id, 'Converted Order Total', $new_order_total );
				}

			}
		}

	}

	new TERMINUS_WC_CURRENCY_SWITCHER();

}
