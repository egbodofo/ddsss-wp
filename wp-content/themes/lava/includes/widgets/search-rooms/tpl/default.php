<?php
/**
 * @var $title
 * @var $show_label
 * @var $default_dates
 * @var $show_children
 * @var $show_contact_info
 * @var $contact_info
 */

// container start

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

if ( empty( $contact_info ) ) {
    $contact_info = Lava_Util::get_option( 'hb_contact_info', '' );
}

?>
<div class="room-search">
    <?php echo do_shortcode('[hotel_booking show_title="false" show_label="'. esc_attr( $show_label ) .'" default_dates="'. esc_attr( $default_dates ) .'" show_children="'. esc_attr( $show_children ) .'"]'); ?>
    <?php if ( $show_price || !empty( $contact_info ) ) : ?>
    <div class="row">
        <?php if ( $show_price && is_singular( array( 'hb_room' ) ) ) : ?>
            <div class="col x12 l6">
                <div class="content-box price">
                    <?php do_action( 'hotel_booking_loop_room_price' ); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ( $show_contact_info && !empty( $contact_info ) ) : ?>
            <div class="col x12 l6">
                <div class="content-box support">
                    <div class="contact-box"><?php echo wp_kses_post( $contact_info ); ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}