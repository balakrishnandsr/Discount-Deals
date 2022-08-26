<?php
/**
 * Class to load discounts and rules
 *
 * @package    Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to handle installation of the plugin
 */
class Discount_Deals_Workflows {

	/**
	 * Holds all discount types
	 *
	 * @var array $_discounts discount types.
	 */
	protected static $_discounts = array();

	/**
	 * Holds all rules
	 *
	 * @var array $_rules workflow rules.
	 */
	protected static $_rules = array();

	/**
	 * Holds all active workflows
	 *
	 * @var array $_active_workflows workflows.
	 */
	protected static $_active_workflows = array();

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->load_discounts();
		$this->load_rules();
		$this->load_data_items();
	}//end __construct()


	/**
	 * Function to load discounts
	 *
	 * @return void
	 */
	public function load_discounts() {
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-discount.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-simple-discount.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-bulk-discount.php';
	}//end load_discounts()


	/**
	 * Function to handle load rules
	 *
	 * @return void
	 */
	public function load_rules() {
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-string-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-bool-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-select-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-searchable-select-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-date-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-preloaded-select-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-product-select-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-number-abstract.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/abstracts/class-discount-deals-workflow-rule-meta-abstract.php';

		// Actual rules.
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-shop-date-time.php';

		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-account-created-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-city.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-company.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-country.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-email.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-first-order-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-is-guest.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-last-order-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-last-review-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-meta.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-order-count.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-order-statuses.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-phone.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-postcode.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-purchased-categories.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-purchased-products.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-review-count.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-role.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-state.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-state-text-match.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-tags.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-total-spent.php';

		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-coupons.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-created-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-item-categories.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-item-count.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-item-tags.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-items.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-cart-total.php';

		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-product.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-product-categories.php';
	}//end load_rules()

	/**
	 * Function to load data items
	 *
	 * @return void
	 */
	public function load_data_items() {
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/data_items/class-discount-deals-workflow-data-item-shop.php';
	}//end load_data_items()


	/**
	 * Get discount class by discount name
	 *
	 * @param string $discount_type Discount type name.
	 *
	 * @return Discount_Deals_Workflow_Discount
	 */
	public static function get_discount_type( $discount_type ) {
		$all_discounts   = self::get_all_discounts();
		$discount_class  = $all_discounts[ $discount_type ];
		$discount_object = new $discount_class();
		$discount_object->set_name( $discount_type );

		return $discount_object;
	}//end get_discount_type()


	/**
	 * Get all discounts
	 *
	 * @return array
	 */
	public static function get_all_discounts() {
		return array(
			'simple_discount' => 'Discount_Deals_Workflow_Simple_Discount',
			'bulk_discount'   => 'Discount_Deals_Workflow_Bulk_Discount',
		);
	}//end get_all_discounts()

	/**
	 * Get discount class by discount name
	 *
	 * @param string $rule_type Discount type name.
	 *
	 * @return Discount_Deals_Workflow_Rule_Abstract
	 */
	public static function get_rule_type( $rule_type ) {
		$all_discounts = self::get_all_rules();

		return $all_discounts[ $rule_type ];
	}//end get_rule_type()

	/**
	 * Get all rules
	 *
	 * @return Discount_Deals_Workflow_Rule_Abstract[]
	 */
	public static function get_all_rules() {
		$valid_rules = array(
			// Product.
			'product'                       => 'Discount_Deals_Workflow_Rule_Product',
			'product_categories'            => 'Discount_Deals_Workflow_Rule_Product_Categories',

			// Cart.
			'cart_coupons'                  => 'Discount_Deals_Workflow_Rule_Cart_Coupons',
			'cart_created_date'             => 'Discount_Deals_Workflow_Rule_Cart_Created_Date',
			'cart_item_categories'          => 'Discount_Deals_Workflow_Rule_Cart_Item_Categories',
			'cart_item_count'               => 'Discount_Deals_Workflow_Rule_Cart_Item_Count',
			'cart_item_tags'                => 'Discount_Deals_Workflow_Rule_Cart_Item_Tags',
			'cart_items'                    => 'Discount_Deals_Workflow_Rule_Cart_Items',
			'cart_total'                    => 'Discount_Deals_Workflow_Rule_Cart_Total',

			// Shop.
			'shop_date_time'                => 'Discount_Deals_Workflow_Rule_Shop_Date_Time',

			// Customer.
			'customer_is_guest'             => 'Discount_Deals_Workflow_Rule_Customer_Is_Guest',
			'customer_account_created_date' => 'Discount_Deals_Workflow_Rule_Customer_Account_Created_Date',
			'customer_city'                 => 'Discount_Deals_Workflow_Rule_Customer_City',
			'customer_company'              => 'Discount_Deals_Workflow_Rule_Customer_Company',
			'customer_country'              => 'Discount_Deals_Workflow_Rule_Customer_Country',
			'customer_email'                => 'Discount_Deals_Workflow_Rule_Customer_Email',
			'customer_first_order_date'     => 'Discount_Deals_Workflow_Rule_Customer_First_Order_Date',
			'customer_last_order_date'      => 'Discount_Deals_Workflow_Rule_Customer_Last_Order_Date',
			'customer_last_review_date'     => 'Discount_Deals_Workflow_Rule_Customer_Last_Review_Date',
			'customer_meta'                 => 'Discount_Deals_Workflow_Rule_Customer_Meta',
			'customer_order_count'          => 'Discount_Deals_Workflow_Rule_Customer_Order_Count',
			'customer_order_statuses'       => 'Discount_Deals_Workflow_Rule_Customer_Order_Statuses',
			'customer_phone'                => 'Discount_Deals_Workflow_Rule_Customer_Phone',
			'customer_postcode'             => 'Discount_Deals_Workflow_Rule_Customer_Postcode',
			'customer_purchased_categories' => 'Discount_Deals_Workflow_Rule_Customer_Purchased_Categories',
			'customer_purchased_products'   => 'Discount_Deals_Workflow_Rule_Customer_Purchased_Products',
			'customer_review_count'         => 'Discount_Deals_Workflow_Rule_Customer_Review_Count',
			'customer_role'                 => 'Discount_Deals_Workflow_Rule_Customer_Role',
			'customer_state'                => 'Discount_Deals_Workflow_Rule_Customer_State',
			'customer_state_text_match'     => 'Discount_Deals_Workflow_Rule_Customer_State_Text_Match',
			'customer_tags'                 => 'Discount_Deals_Workflow_Rule_Customer_Tags',
			'customer_total_spent'          => 'Discount_Deals_Workflow_Rule_Customer_Total_Spent',
		);
		if ( count( self::$_rules ) < count( $valid_rules ) ) {
			foreach ( $valid_rules as $rule_name => $class_name ) {
				$rule_class = new $class_name();
				/*
				 * Workflow discount
				 *
				 * @var Discount_Deals_Workflow_Rule_Abstract $rule_class Rule.
				 */
				$rule_class->set_name( $rule_name );
				self::$_rules[ $rule_name ] = $rule_class;
			}
		}

		return self::$_rules;
	}//end get_all_rules()


	/**
	 * Get data for discount
	 *
	 * @param Discount_Deals_Workflow_Discount $discount Discount class.
	 *
	 * @return array|false
	 */
	public static function get_discount_data( $discount ) {
		$data = array();

		if ( ! $discount ) {
			return false;
		}

		$data['title']               = $discount->get_title();
		$data['name']                = $discount->get_name();
		$data['description']         = $discount->get_description();
		$data['supplied_data_items'] = array_values( $discount->get_supplied_data_items() );

		return $data;
	}//end get_discount_data()


	/**
	 * Calculate product discount.
	 *
	 * @param float      $price   Product price.
	 * @param WC_Product $product Product.
	 *
	 * @return integer|void
	 */
	public static function calculate_product_discount( $price, $product ) {

		$active_workflows    = self::get_active_workflows();
		$discounted_price    = 0;
		$exclusive_workflows = $non_exclusive_workflows = array();

		$calculate_discount_from = Discount_Deals_Settings::get_settings( 'calculate_discount_from', 'sale_price' );

		if ( empty( $active_workflows ) ) {
			return $price;
		}

		/*
		 * Hook to apply the exclusive
		 *
		 * @since 1.0.0
		 */
		$apply_as = apply_filters(
			'discount_deals_apply_exclusive_rules_as',
			'lowest_matched',
			array(
				'product'            => $product,
				'active_workflows'   => $active_workflows,
				'workflows_apply_as' => array(
					'all_matched',
					'biggest_matched',
					'lowest_matched',
				),

			)
		);

		if ( ! empty( $active_workflows['exclusive'] ) ) {
			$exclusive_workflows = $active_workflows['exclusive'];
		} else {
			$non_exclusive_workflows = $active_workflows['non_exclusive'];
		}

		if ( 'regular_price' === $calculate_discount_from ) {
			$price = ( is_object( $product ) && is_callable(
					array(
						$product,
						'get_regular_price',
					)
				) ) ? $product->get_regular_price() : 0;
		}

		$discounted_price = self::get_discount( $exclusive_workflows, $product, $price, $apply_as );
		if ( false === $discounted_price ) {
			$apply_as         = Discount_Deals_Settings::get_settings( 'apply_product_discount_to', 'lowest_matched' );
			$discounted_price = self::get_discount( $non_exclusive_workflows, $product, $price, $apply_as );
		}

		if ( false === $discounted_price ) {
			return $price;
		}

		return $discounted_price;

	}//end calculate_product_discount()


	/**
	 * Get_active_workflows.
	 *
	 * @return Discount_Deals_Workflow[]
	 */
	public static function get_active_workflows() {
		if ( ! empty( self::$_active_workflows ) ) {
			return self::$_active_workflows;
		}
		$workflows_db = new Discount_Deals_Workflow_DB();
		$workflows    = $workflows_db->get_by_conditions( 'dd_status = 1', 'object' );
		if ( ! empty( $workflows ) ) {
			$data_items = array(
				'customer' => WC()->customer,
				'cart'     => WC()->cart,
			);

			foreach ( $workflows as $workflow ) {
				$workflow_object = new Discount_Deals_Workflow( $workflow );
				$workflow_object->set_data_layer( $data_items );
				self::$_active_workflows[]               = $workflow_object;
				self::$_active_workflows['all_active'][] = $workflow_object;
				if ( $workflow_object->get_exclusive() ) {
					self::$_active_workflows['exclusive'][] = $workflow_object;
				} else {
					self::$_active_workflows['non_exclusive'][] = $workflow_object;
				}
			}
		}

		return self::$_active_workflows;
	}//end get_active_workflows()

	/**
	 * Get discount details by workflows.
	 *
	 * @param array      $workflows Array of objects.
	 * @param WC_Product $product   Product object.
	 * @param float      $price     Product price.
	 * @param string     $apply_as  Apply Discount as.
	 *
	 * @return array|mixed
	 */
	public static function get_discount( $workflows, $product, $price, $apply_as ) {
		if ( empty( $workflows ) ) {
			return false;
		}
		$valid_discounts  = array();
		$applied_discount = array();
		$subsequent_price = $price;
		foreach ( $workflows as $workflow ) {
			$workflow_id = $workflow->get_id();
			/*
			 * Workflow.
			 *
			 * @var Discount_Deals_Workflow $workflow
			 */
			$workflow->data_layer()->set_item( 'product', $product );
			$apply_subsequently = Discount_Deals_Settings::get_settings( 'apply_discount_subsequently', 'no' );

			if ( 'yes' == $apply_subsequently && 'all_matched' === $apply_as ) {
				$discounts        = array_sum( $valid_discounts );
				$subsequent_price = $subsequent_price - $discounts;
			}

			if ( $workflow->validate_rules() ) {
				$valid_discounts[ $workflow_id ] = $workflow->may_have_product_discount( $product, $subsequent_price );
			}
		}
		$discounted_price = self::get_matched_discount( $valid_discounts );
		if ( 0 >= $discounted_price ) {
			return false;
		}

		return $price - $discounted_price;

	}//end get_discount()


	/**
	 * Get matched Discount
	 *
	 * @param $valid_discounts
	 *
	 * @return float|integer|mixed
	 */
	public static function get_matched_discount( $valid_discounts ) {
		$apply_as             = Discount_Deals_Settings::get_settings( 'apply_product_discount_to', 'lowest_matched' );
		$applied_discount     = array();
		$calculated_discounts = 0;
		if ( ! empty( $valid_discounts ) ) {
			switch ( $apply_as ) {
				case 'biggest_matched':
					$applied_discount     = array_keys( $valid_discounts, max( $valid_discounts ) );
					$calculated_discounts = $valid_discounts[ $applied_discount[0] ];
					break;
				case 'lowest_matched':
					$applied_discount     = array_keys( $valid_discounts, min( $valid_discounts ) );
					$calculated_discounts = $valid_discounts[ $applied_discount[0] ];
					break;
				default:
				case 'all_matched':
					$applied_discount     = $valid_discounts;
					$calculated_discounts = array_sum( $valid_discounts );
					break;
			}
		}

		return $calculated_discounts;
	}//end get_matched_discount()



}//end class
