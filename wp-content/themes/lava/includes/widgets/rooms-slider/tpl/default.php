<?php
/**
 * @var $title
 * @var $columns
 * @var $one_line_title
 * @var $excerpt
 * @var $price
 * @var $image_size
 */

if ( empty( $instance['query'] ) ) {
    return;
}

$query_args = siteorigin_widget_post_selector_process_query( $instance['query'] );

$rooms_query = new WP_Query( $query_args );

if ( !$rooms_query->have_posts() ) {
    return;
}

?>
<div class="lava-rooms-slider">
    <div class="slick-slider<?php echo ' column-'. esc_attr( $columns ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
    <?php while ( $rooms_query->have_posts() ) : 
            $rooms_query->the_post();
            $room_type = get_post_meta( get_the_ID(), '_lava_room_type_title', true );
        ?>
        <div class="">
            <?php echo lava_get_post_thumb( $image_size ); ?>
            <div class="post-info">
                <?php lava_hb_room_title( get_the_ID(), $one_line_title ); ?>
                <?php if ( $excerpt ): lava_hb_room_excerpt(); endif; ?>
                <?php if ( $price ): do_action( 'hotel_booking_loop_room_price' ); endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>