<?php
/**
 * The template for displaying new customer form in checkout page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/checkout/customer-new.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

/**
 * @var $customer
 */
?>
<div class="hb-order-new-customer" id="hb-order-new-customer">
    <h4><?php esc_html_e( 'New Customer', 'lava' ); ?></h4>
    <div class="hb-form-table">
        <div class="row">
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Title', 'lava' ); ?>
                    <span class="hb-required">*</span> </label>

                <div class="hb-form-field-input">
					<?php lava_hb_dropdown_titles( array( 'selected' => $customer->title ) ); ?>
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'First name', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="first_name" value="<?php echo esc_attr( $customer->first_name ); ?>" placeholder="<?php esc_attr_e( 'First name', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Last name', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="last_name" value="<?php echo esc_attr( $customer->last_name ); ?>" placeholder="<?php esc_attr_e( 'Last name', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Address', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="address" value="<?php echo esc_attr( $customer->address ); ?>" placeholder="<?php esc_attr_e( 'Address', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'City', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="city" value="<?php echo esc_attr( $customer->city ); ?>" placeholder="<?php esc_attr_e( 'City', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'State', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="state" value="<?php echo esc_attr( $customer->state ); ?>" placeholder="<?php esc_attr_e( 'State', 'lava' ); ?>" />
                </div>
            </div>
        </div>
    </div>
    <div class="hb-form-table">
        <div class="row">
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Postal Code', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="postal_code" value="<?php echo esc_attr( $customer->postal_code ); ?>" placeholder="<?php esc_attr_e( 'Postal code', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Country', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
					<?php hb_dropdown_countries( array(
                        'name' => 'country',
                        'show_option_none' => esc_attr__( 'Country', 'lava' ),
                        'selected' => $customer->country,
                    ) ); ?>
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Phone', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="text" name="phone" value="<?php echo esc_attr( $customer->phone ); ?>" placeholder="<?php esc_attr_e( 'Phone Number', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-form-field col x12 s6">
                <label class="hb-form-field-label"><?php esc_html_e( 'Email', 'lava' ); ?>
                    <span class="hb-required">*</span></label>

                <div class="hb-form-field-input">
                    <input type="email" name="email" value="<?php echo esc_attr( $customer->email ); ?>" placeholder="<?php esc_attr_e( 'Email address', 'lava' ); ?>" />
                </div>
            </div>
        </div>
        <input type="hidden" name="existing-customer-id" value="" />
    </div>
</div>