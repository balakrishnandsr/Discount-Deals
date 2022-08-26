<?php
/**
 * Cart items rule
 *
 * @package     Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Discount_Deals_Workflow_Rule_Cart_Items
 */
class Discount_Deals_Workflow_Rule_Cart_Items extends Discount_Deals_Workflow_Rule_Product_Select_Abstract {

	/**
	 * What data item should pass in to validate the rule?
	 *
	 * @var string
	 */
	public $data_item = "cart";

	/**
	 * Init the rule
	 */
	function init() {
		$this->title = __( 'Cart - Items', 'discount-deals' );
		parent::init();
	}//end init()



	/**
	 * Validate the cart item has given products
	 *
	 * @param WC_Cart $data_item    data item.
	 * @param string  $compare_type compare operator.
	 * @param array   $value        list of values.
	 *
	 * @return boolean
	 */
	function validate( $data_item, $compare_type, $value ) {
		if ( empty( $value ) || ! is_array( $value ) ) {
			return false;
		}
		$cart_items = $data_item->get_cart_contents();
		if ( empty( $cart_items ) ) {
			return false;
		}
		$all_ids = [];
		foreach ( $cart_items as $item ) {
			array_push( $all_ids, $item['variation_id'], $item['product_id'] );
		}
		$all_ids = array_filter( $all_ids );

		return $this->validate_select( $all_ids, $compare_type, $value );
	}//end validate()

}//end class

