<?php
/**
 * This class defines all code necessary to workflow discount
 *
 * @package    Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to handle all the discounts of products and cart
 */
abstract class Discount_Deals_Workflow_Discount {
	/**
	 * Title for the discount type
	 *
	 * @var string $title discount title
	 */
	public $title = '';
	/**
	 * Description for the discount type
	 *
	 * @var string $title discount description
	 */
	public $description = '';
	/**
	 * Name for the discount type
	 *
	 * @var string $name discount type slug
	 */
	public $name = '';
	/**
	 * Discount details
	 *
	 * @var array $discount_details Discount details
	 */
	public $discount_details = array();
	public $promotion_details = array();
	/**
	 * Data items of the discount
	 *
	 * @var array $supplied_data_items valid data items
	 */
	protected $supplied_data_items = array();

	/**
	 * Class constructor
	 */
	public function __construct() {
	}//end __construct()

	/**
	 * Get discount details
	 *
	 * @return array
	 */
	public function get_discount_details() {
		return $this->discount_details;
	}

	/**
	 * Set discount details to the class
	 *
	 * @param array $discount_details Discount details.
	 */
	public function set_discount_details( $discount_details ) {
		$this->discount_details = $discount_details;
	}

	/**
	 * Get tile of the discount
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}//end get_discount_details()

	/**
	 * Set title for the discount
	 *
	 * @param string $title Title for the discount type.
	 *
	 * @return void
	 */
	public function set_title( $title ) {
		$this->title = $title;
	}//end set_discount_details()

	/**
	 * Get description of the discount
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}//end get_title()

	/**
	 * Discount description
	 *
	 * @param string $description Description of the discount.
	 */
	public function set_description( $description ) {
		$this->description = $description;
	}//end set_title()

	/**
	 * Get the name of the discount
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}//end get_description()

	/**
	 * Set name for the discount
	 *
	 * @param string $name Name for the discount type.
	 *
	 * @return void
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}//end set_description()

	/**
	 * Valid data items for discount
	 *
	 * @return array
	 */
	public function get_supplied_data_items() {
		return $this->supplied_data_items;
	}//end get_name()

	/**
	 * Set supplied data items for discount
	 *
	 * @return void
	 */
	abstract public function set_supplied_data_items();//end set_name()

	/**
	 * Admin discount fields
	 *
	 * @return false|string|void
	 */
	public function load_fields() {
	}//end get_supplied_data_items()

	/**
	 * Load promotional message fields
	 *
	 * @return string
	 */
	public function load_promotion_fields() {
		$discount_details = $this->get_promotion_details();
		ob_start();
		discount_deals_radio(
			array(
				'wrapper_class' => 'discount-options-field-container',
				'id'            => 'discount_deals_workflow_toggle_promotion',
				'name'          => 'discount_deals_workflow[dd_promotion][enable]',
				'value'         => discount_deals_get_value_from_array( $discount_details, 'enable', 'no' ),
				'label'         => __( 'Do you want to display promotional messages in store front?', 'discount-deals' ),
				'options'       => array(
					'yes' => __( 'Yes', 'discount-deals' ),
					'no'  => __( 'No', 'discount-deals' ),
				),
				'required'      => true,
			)
		);
		discount_deals_select(
			array(
				'id'       => 'discount_deals_workflow_promotion_when',
				'name'     => 'discount_deals_workflow[dd_promotion][when_to_show]',
				'value'    => discount_deals_get_value_from_array( $discount_details, 'when_to_show', 'all_time' ),
				'label'    => __( 'When to show this promotional message?', 'discount-deals' ),
				'options'  => array(
					'before_rule' => __( 'Before all rules are passed', 'discount-deals' ),
					'after_rule'  => __( 'After all rules are passed', 'discount-deals' ),
					'all_time'    => __( 'All time', 'discount-deals' ),
				),
				'required' => true,
			)
		);

		discount_deals_select(
			array(
				'id'       => 'discount_deals_workflow_promotion_where',
				'name'     => 'discount_deals_workflow[dd_promotion][where_to_show]',
				'value'    => discount_deals_get_value_from_array( $discount_details, 'where_to_show', 'all_time' ),
				'label'    => __( 'Where to show this promotional message?', 'discount-deals' ),
				'options'  => array(
					'before_add_to_cart_button'    => __( 'Before "Add to cart" button', 'discount-deals' ),
					'after_add_to_cart_button'     => __( 'After "Add to cart" button', 'discount-deals' ),
					'after_single_product_summary' => __( 'Before product additional information', 'discount-deals' ),
				),
				'required' => true,
			)
		);

		discount_deals_editor(
			array(
				'id'       => 'discount_deals_workflow_promotion_message',
				'name'     => 'discount_deals_workflow[dd_promotion][message]',
				'value'    => discount_deals_get_value_from_array( $discount_details, 'message', '<p><b>Special Price</b> Purchase above 500$ and get extra 5% off. </p>' ),
				'label'    => __( 'Message to show in the product details page?', 'discount-deals' ),
				'required' => true,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Get promotion details
	 *
	 * @return array
	 */
	public function get_promotion_details() {
		return $this->promotion_details;
	}//end load_fields()

	/**
	 * Set promotion details for the discount
	 *
	 * @param array $promotion_details promotion details.
	 */
	public function set_promotion_details( $promotion_details ) {
		$this->promotion_details = $promotion_details;
	}

	/**
	 * Calculate discount for given data item
	 *
	 * @param mixed $data_item Calculate for which data item.
	 * @param mixed $price Price.
	 *
	 * @return mixed
	 */
	abstract public function calculate_discount( $data_item, $price, $extra = array() );

	/**
	 * Calculate discount amount.
	 *
	 * @param string $type Discount type.
	 * @param float $price Price.
	 * @param float $discount_value discount value.
	 *
	 * @return float|int|mixed
	 */
	public function calculate_discount_amount( $type = '', $price = 0, $discount_value = 0 ) {

		$discount = 0;
		if ( empty( $type ) ) {
			return $discount;
		}
		switch ( $type ) {
			case 'free':
				return $price;
			case 'fixed_price':
				return min( $price, $discount_value );
			case 'percent':
				if ( 100 < $discount_value ) {
					return 0;
				}

				return $price * ( $discount_value / 100 );
			default:
			case 'flat':
				return $discount_value;
		}
	}

}//end class

