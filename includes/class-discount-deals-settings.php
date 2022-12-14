<?php
/**
 * This class defines all discount deals settings | options.
 *
 * @package Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class for handling Settings
 */
class Discount_Deals_Settings {
	/**
	 * Settings constant
	 *
	 * @var string
	 */
	const DISCOUNT_DEALS_OPTION_KEY = 'discount-deals-settings';
	/**
	 * Contains all the configuration details.
	 *
	 * @var array
	 */
	private static $config = array();

	/**
	 * Contains default configuration details.
	 *
	 * @var array
	 */
	private static $default_config = array(
		// General.
		'show_applied_discounts_message'    => 'yes',
		'combine_applied_discounts_message' => 'yes',
		'applied_discount_message'          => 'Discount <strong>{{workflow_title}}</strong> has been applied to your cart.',
		// Product.
		'calculate_discount_from'           => 'regular_price',
		'apply_product_discount_to'         => 'all_matched',
		'apply_discount_subsequently'       => 'no',
		// Cart.
		'apply_cart_discount_to'            => 'lowest_with_free_shipping',
		'apply_cart_discount_subsequently'  => 'no',
		'show_strikeout_price_in_cart'      => 'yes',
		'you_saved_text'                    => 'You saved {{discount}}',
		'where_display_saving_text'         => 'on_each_line_item',
		'apply_cart_discount_as'            => 'fee',
		'apply_coupon_title'                => '',
		'apply_fee_title'                   => 'Your discount',
		// Free Shipping.
		'free_shipping_title'               => 'free shipping',
		// BOGO.
		'apply_bogo_discount_to'            => 'lowest_matched',
		'bogo_discount_highlight_message'   => 'Free',
	);

	/**
	 * Save the configuration
	 *
	 * @param array $data Data.
	 *
	 * @return boolean
	 */
	public static function save_settings( $data = array() ) {
		$old_settings = get_option( self::DISCOUNT_DEALS_OPTION_KEY, array() );
		$new_settings = wp_parse_args( $data, $old_settings );

		return update_option( self::DISCOUNT_DEALS_OPTION_KEY, $new_settings );
	}//end save_settings()


	/**
	 * Get settings.
	 *
	 * @param string $key     What configuration need to get.
	 * @param string $default Default value if config value not found.
	 *
	 * @return string - Configuration value.
	 */
	public static function get_settings( $key, $default = '' ) {
		if ( empty( self::$config ) ) {
			self::saved_settings();
		}

		return wc_clean( wp_unslash( discount_deals_get_value_from_array( self::$config, $key, $default ) ) );
	}//end get_settings()


	/**
	 * Set rule configuration to static variable
	 *
	 * @return array
	 */
	protected static function saved_settings() {
		$options      = get_option( self::DISCOUNT_DEALS_OPTION_KEY );
		self::$config = wp_parse_args( $options, self::$default_config );

		return self::$config;
	}//end saved_settings()

}//end class

