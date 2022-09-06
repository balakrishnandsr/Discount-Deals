<?php
/**
 * This class defines all discount deals settings | options.
 *
 * @package Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Discount_Deals_Settings {
	/**
	 * settings constant
	 *
	 * @var string
	 */
	const DISCOUNT_DEALS_OPTION_KEY = 'discount-deals-settings';
	/**
	 * Contains all the configuration details
	 *
	 * @var array
	 */
	private static $config = array();

	private static $default_config = array(

		//Product
		'calculate_discount_from'          => 'regular_price',
		'apply_product_discount_to'        => 'lowest_matched',
		'apply_discount_subsequently'      => 'no',
		//Cart
		'apply_cart_discount_to'           => 'lowest_with_free_shipping',
		'apply_cart_discount_subsequently' => 'no',
		'apply_cart_discount_as'           => 'fee',
		'apply_coupon_title'               => '',
		'apply_fee_title'                  => 'You discount',
	);

	/**
	 * Save the configuration
	 *
	 * @param $data
	 *
	 * @return boolean
	 */
	public static function save_settings( $data = array() ) {
		return update_option( self::DISCOUNT_DEALS_OPTION_KEY, $data );
	}//end save_settings()


	/**
	 * @param $key - what configuration need to get
	 * @param string $default - default value if config value not found
	 *
	 * @return string - configuration value
	 */
	public static function get_settings( $key, $default = '' ) {
		if ( empty( self::$config ) ) {
			self::saved_settings();
		}

		return discount_deals_get_value_from_array( self::$config, $key, $default );
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

