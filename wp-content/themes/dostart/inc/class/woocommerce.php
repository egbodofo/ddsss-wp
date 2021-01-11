<?php

if ( ! function_exists('dostart_cart_link') ) {

    function dostart_cart_link() {
        ?>	
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'dostart'); ?>">
            <i class="fa fa-shopping-bag"><span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span></i>
            <!-- <div class="amount-cart"><?php// echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></div>  -->
        </a>
        <?php
    }
}

if ( ! function_exists('dostart_header_cart') ) {

    function dostart_header_cart() { ?>
            <div class="header-cart">
                <div class="header-cart-block">
                    <div class="header-cart-inner">
                        <?php dostart_cart_link(); ?>
                       <!--  <ul class="site-header-cart menu list-unstyled text-center">
                            <li>
                                <?php // the_widget('WC_Widget_Cart', 'title='); ?> 
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
    <?php }
}

if ( ! function_exists('dostart_header_add_to_cart_fragment') ) {
    add_filter('woocommerce_add_to_cart_fragments', 'dostart_header_add_to_cart_fragment');

    function dostart_header_add_to_cart_fragment( $fragments ) {
        ob_start();

        dostart_cart_link();

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}