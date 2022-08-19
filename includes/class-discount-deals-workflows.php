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
	}

	/**
	 * Function to load discounts
	 *
	 * @return void
	 */
	public function load_discounts() {
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-discount.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-simple-discount.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/discounts/class-discount-deals-workflow-bulk-discount.php';
	}

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

		// Actual rules.
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-shop-date-time.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-account-created-date.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-city.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-company.php';
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/rules/class-discount-deals-workflow-rule-customer-is-guest.php';
	}//end load_rules()

	/**
	 * Function to load data items
	 *
	 * @return void
	 */
	public function load_data_items() {
		require_once DISCOUNT_DEALS_ABSPATH . 'includes/workflows/data_items/class-discount-deals-workflow-data-item-shop.php';
	}

	/**
	 * Get discount class by discount name
	 *
	 * @param string $discount_type Discount type name.
	 *
	 * @return Discount_Deals_Workflow_Discount
	 */
	public static function get_discount_type( $discount_type ) {
		$all_discounts = self::get_all_discounts();

		return $all_discounts[ $discount_type ];
	}

	/**
	 * Get all discounts
	 *
	 * @return Discount_Deals_Workflow_Discount[]
	 */
	public static function get_all_discounts() {
		$valid_discounts = array(
			'simple_discount' => 'Discount_Deals_Workflow_Simple_Discount',
			'bulk_discount'   => 'Discount_Deals_Workflow_Bulk_Discount',
		);
		if ( count( self::$_discounts ) < count( $valid_discounts ) ) {
			foreach ( $valid_discounts as $discount_name => $class_name ) {
				$discount_class = new $class_name();

				/*
				 * Workflow discount
				 * @var Discount_Deals_Workflow_Discount $discount_class Discount.
				 */

				$discount_class->set_name( $discount_name );
				self::$_discounts[ $discount_name ] = $discount_class;
			}
		}

		return self::$_discounts;
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
			// Customer.
			'customer_is_guest'             => 'Discount_Deals_Workflow_Rule_Customer_Is_Guest',
			'customer_account_created_date' => 'Discount_Deals_Workflow_Rule_Customer_Account_Created_Date',
			'customer_city'                 => 'Discount_Deals_Workflow_Rule_Customer_City',
			'customer_company'              => 'Discount_Deals_Workflow_Rule_Customer_Company',

			// Shop.
			'shop_date_time'                => 'Discount_Deals_Workflow_Rule_Shop_Date_Time',
		);
		if ( count( self::$_rules ) < count( $valid_rules ) ) {
			foreach ( $valid_rules as $rule_name => $class_name ) {
				$rule_class = new $class_name();
				/**
				 * Workflow discount
				 * @var Discount_Deals_Workflow_Rule_Abstract $rule_class Rule.
				 */
				$rule_class->set_name( $rule_name );
				self::$_rules[ $rule_name ] = $rule_class;
			}
		}

		return self::$_rules;
	}

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
	}

	/**
	 * Calculate product discount.
	 *
	 * @param float $price Product price.
	 * @param WC_Product $product Product.
	 *
	 * @return integer|void
	 */
	public static function calculate_product_discount( $price, $product ) {

		$active_workflows = self::get_active_workflows();

		$discounts = $exclusive_workflows = $non_exclusive_workflows = array();

        $calculate_discount_from = Discount_Deals_Settings::get_settings('calculate_discount_from', 'sale_price');


		$cart_items = ( is_object( WC()->cart ) && is_callable(
			array(
				WC()->cart,
				'get_cart',
			)
		) ) ? WC()->cart->get_cart() : array();

		if ( empty( $active_workflows ) ) {
			return 0;
		}

		// echo "<pre>"; print_r(); echo "</pre>";.

		/*
		&& apply_filters('is_product_eligible_for_dd_exclusive_workflows', true, array(
				'product'  => $product,
				'active_workflows' => $active_workflows,
				'cart_items' => $cart_items
			)
		)
		*/

		if ( ! empty( $active_workflows['exclusive'] ) ) {
			$exclusive_apply_as  = apply_filters(
				'apply_dd_exclusive_rules_as',
				'first_matched',
				array(
					'product'            => $product,
					'active_workflows'   => $active_workflows,
					'cart_items'         => $cart_items,
					'workflows_apply_as' => array(
						'first_matched',
						'last_matched',
						'highest_discount',
						'smallest_discount',
					),

				)
			);
			$exclusive_workflows = $active_workflows['exclusive'];

		} else {
			$non_exclusive_workflows = $active_workflows['non_exclusive'];
		}

        if ( 'regular_price' === $calculate_discount_from ) {
            $price = ( is_object( $product ) && is_callable( array( $product, 'get_regular_price' ) ) ) ? $product->get_regular_price() : 0;
        }

        $discounts  = 0;

        $discounts = self::get_discount($exclusive_workflows, $product, $price);
		if (  empty( $discounts ) || 0 == $discounts )  {
            $discounts = self::get_discount($exclusive_workflows, $product, $price);
		}

       return $discounts;

	}

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
     * @param array $workflows Array of objects.
     * @param WC_Product $product Product object.
     * @param float $price Product price.
     * @return array|mixed
     */
    public static function get_discount( $workflows, $product, $price){
        if ( ! empty( $workflows ) ) {
            $apply_as  = Discount_Deals_Settings::get_settings('apply_discount_to', 'biggest_discount');
            $valid_discounts = array();
            $applied_discount = array();
            foreach ( $workflows as $workflow ) {
                $workflow_id = $workflow->get_id();
                /**
                 * Workflow.
                 * @var Discount_Deals_Workflow $workflow
                 */

                 $apply_subsequently   = Discount_Deals_Settings::get_settings('apply_discount_subsequently', 'no');
                 if ( 'yes' == $apply_subsequently ) {
                     $discounts = array_sum($valid_discounts);
                     $price = $price - $discounts;
                 }
               
                if ( $workflow->validate_rules() ) {
                    $valid_discounts[$workflow_id] = $workflow->may_have_product_discount( $product, $price );
                    if( 'first_matched' === $apply_as ){
                        $applied_discount = $valid_discounts;
                        return  $valid_discounts[$workflow_id];
                    }
                }

            }

            if(!empty($valid_discounts)){
                switch ($apply_as){
                    case 'biggest_matched':
                        $applied_discount = array_keys ( $valid_discounts, max( $valid_discounts ) );
                        $valid_discounts  = $valid_discounts[$applied_discount[0]];
                        break;
                    case 'lowest_matched':
                        $applied_discount = array_keys ( $valid_discounts, min( $valid_discounts ) );
                        $valid_discounts  = $valid_discounts[$applied_discount[0]];
                        break;
                    default:
                    case 'all_matched':
                        $applied_discount = $valid_discounts;
                        $valid_discounts  = array_sum($valid_discounts);
                        break;
                }
            }
            $discount = $price - $valid_discounts;

            if($discount <= 0){
                $discount = 0;
            }
            return $discount;
        }
        return $price;
    }


}//end class
