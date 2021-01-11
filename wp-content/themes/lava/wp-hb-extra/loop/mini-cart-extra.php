<?php
/**
 * mini cart extra package
 *
 * @package    wp-hotel-booking/templates
 * @version    1.0
 */

?>

<?php if ( $packages ) : ?>

    <div class="hb_mini_cart_price_packages">
        <label><?php esc_html_e( 'Addition Services:', 'lava' ) ?></label>
        <ul>
			<?php foreach ( $packages as $cart ) : ?>
                <li>
                    <div class="hb_package_title">
                        <a href="#"><?php printf( '%s (%s)', $cart->product_data->title, hb_format_price( $cart->amount_singular ) ) ?></a>
						<?php if ( ! get_post_meta( $cart->product_id, 'tp_hb_extra_room_required' ) ) { ?>
                            <span>(<?php printf( 'x%s', $cart->quantity ) ?>)
							<a href="#" class="hb_package_remove"
                               data-cart-id="<?php echo esc_attr( $cart->cart_id ) ?>"><i class="material-icons">close</i></a>
						</span>
						<?php } ?>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>
