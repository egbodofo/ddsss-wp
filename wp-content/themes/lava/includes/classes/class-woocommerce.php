<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lava_WooCommerce {

	function __construct() {

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// remove breadcrumbs
		add_action( 'init', array( $this, 'remove_breadcrumbs' ) );

		// hide tab heading
		add_filter( 'woocommerce_product_additional_information_heading', array( $this, 'remove_additional_information_heading') );
		add_filter( 'woocommerce_product_description_heading', array( $this, 'remove_description_heading') );

		// show nav cart on nav menu
		if ( Lava_Util::get_option( 'wc_nav_cart', false ) ) {
			add_filter( 'wp_nav_menu_items', array( $this, 'add_nav_cart' ), 11, 2 );
		}

		add_action( 'woocommerce_before_quantity_input_field', array( $this, 'before_quantity_input_field' ) );
		add_action( 'woocommerce_after_quantity_input_field', array( $this, 'after_quantity_input_field' ) );

		// related & upsell products per page & columns
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'upsell_products_args' ) );

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_item_count_fragment' ), 10, 1 );
		add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
			return 'thumbnail';
		} );
	}

	function related_products_args( $args ) {
	  	$args['posts_per_page'] = Lava_Util::get_option( 'wc_related_count', 3 );
	  	$args['columns'] = Lava_Util::get_option( 'wc_related_columns', 3 );
		return $args;
	}

	function upsell_products_args( $args ) {
	  	$args['posts_per_page'] = Lava_Util::get_option( 'wc_upsell_count', 3 );
	  	$args['columns'] = Lava_Util::get_option( 'wc_upsell_columns', 3 );
		return $args;
	}

	function remove_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	function remove_description_heading() {
		return '';
	}

	function remove_additional_information_heading() {
		return '';
	}

	/**
	 * Before quantity input field
	 */
	public function before_quantity_input_field() {
		echo '<input class="minus" type="button" value="-">';
	}

	/**
	 * After quantity input field
	 */
	public function after_quantity_input_field() {
		echo '<input class="plus" type="button" value="+">';
	}

	/**
	 * Updates cart item count
	 * 
	 * @param  array $fragments AJAX fragments handled by WooCommerce.
	 * @return array
	 */
	function cart_item_count_fragment( $fragments ) {
		$item_count = WC()->cart->get_cart_contents_count();
	    $fragments['span.cart-item-count'] = '<span class="cart-item-count" style="' . esc_attr( $item_count == '0' ? 'display:none;' : '' ) . '">' . esc_html( $item_count ) . '</span>';
	    return $fragments;
	}

	function add_nav_cart( $items, $args ) {
		global $woocommerce;

		if ( $args->theme_location == 'main' || $args->theme_location == 'right' ) {

			$cart_link = wc_get_cart_url();
			$item_count = $woocommerce->cart->cart_contents_count;
			ob_start();

			?><li class="menu-item-cart">
				<a id="nav-cart" href="<?php echo esc_url( $cart_link ); ?>" title="<?php esc_attr_e( 'View Shopping Cart', 'lava' ); ?>">
					<i class="material-icons">shopping_cart</i>
					<span class="cart-item-count" style="<?php echo esc_attr( $item_count == '0' ? 'display:none;' : '' ); ?>"><?php echo esc_html( $item_count ); ?></span>
				</a>
				<div id="nav-cart-widget" class="widget_shopping_cart woocommerce">
					<div class="widget_shopping_cart_content">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</li><?php

			$output = ob_get_clean();
			return $items .= $output;
		}
		return $items;
	}

	function enqueue_scripts() {
		
		wp_register_style(
			'woocommerce',
			LAVA_THEME_URI . '/assets/css/woocommerce' . LAVA_MIN_SUFFIX . '.css',
			false,
			LAVA_THEME_VERSION
		);

		wp_enqueue_style( 'woocommerce' );
		wp_style_add_data( 'woocommerce', 'rtl', 'replace' );

		wp_dequeue_style( 'select2' );
	}
}

if ( class_exists( 'WooCommerce' ) ) {
	new Lava_WooCommerce();
}


function lava_is_woocommerce_page () {
	if ( function_exists( 'is_woocommerce') && is_woocommerce() ) {
		return true;
	} else {
		return false;
	}

    $woocommerce_keys = array(
    	'woocommerce_shop_page_id',
        'woocommerce_terms_page_id',
        'woocommerce_cart_page_id',
        'woocommerce_checkout_page_id',
        'woocommerce_pay_page_id',
        'woocommerce_thanks_page_id',
        'woocommerce_myaccount_page_id',
        'woocommerce_edit_address_page_id',
        'woocommerce_view_order_page_id',
        'woocommerce_change_password_page_id',
        'woocommerce_logout_page_id',
        'woocommerce_lost_password_page_id' );

    $page_id = get_the_ID();

    if ( $page_id ) {
	    foreach ( $woocommerce_keys as $wc_page_id ) {
	        if ( $page_id == get_option ( $wc_page_id, 0 ) ) {
	            return true;
	        }
	    }
    }

    return false;
}