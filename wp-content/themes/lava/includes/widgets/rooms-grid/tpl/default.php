<?php

if ( !class_exists( 'WP_Hotel_Booking' ) ) {
	return;
}

if ( empty( $instance['query'] ) ) {
	return;
}

$query_args = siteorigin_widget_post_selector_process_query( $instance['query'] );

$rooms_query = new WP_Query( $query_args );

$show_excerpt = isset( $instance['excerpt'] ) ? (bool) $instance['excerpt'] : false;

$show_price = isset( $instance['price'] ) ? (bool) $instance['price'] : true;

if ( !$rooms_query->have_posts() ) {
	return;
}

?>
<div class="lava-rooms-grid"><?php

	$counter = 0;
	while ( $rooms_query->have_posts() ) : 
		$rooms_query->the_post(); $counter ++;
		$room_type = get_post_meta( get_the_ID(), '_lava_room_type_title', true );
		$column_class = $counter % 2 == 0 ? ' pull-right' : '';
	
  ?><div class="row no-padding">
		<div class="col x12 m6<?php echo esc_attr( $column_class ); ?>">
			<div class="lava-image-holder lava-room-thumb equal-height">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php the_post_thumbnail( 'lava_thumb_medium' ); ?>
				</a>
			</div>
		</div>
		<div class="col x12 m6">
			<div class="lava-room-info container-half equal-height">
				<h3 class="lava-room-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title() ?>
					<?php if ( !empty( $room_type ) ): ?>
						<span class="lava-room-subtitle"><?php echo esc_html( $room_type ) ?></span>
					<?php endif; ?>
					</a>
				</h3>
				<?php if ( $show_excerpt ): lava_hb_room_excerpt(); endif; ?>
				<?php if ( $show_price ): do_action( 'hotel_booking_loop_room_price' ); endif; ?>
				<a href="<?php echo esc_url( get_the_permalink() ) ?>" class="btn-secondary"><?php esc_html_e( 'Details', 'lava' ); ?></a>
			</div>
		</div>
	</div><?php

	endwhile;
	wp_reset_postdata();

?></div>