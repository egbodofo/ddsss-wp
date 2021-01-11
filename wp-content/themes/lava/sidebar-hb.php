<?php $sidebar_class = Lava_Util::get_option( 'sticky_sidebar', true ) ? ' sticky' : ''; ?>
<aside class="sidebar<?php echo esc_attr( $sidebar_class ); ?>">
	<div class="sidebar-wrapper"><?php
		if ( !empty( Lava()->get_sidebar_id() ) ) {
			dynamic_sidebar( Lava()->get_sidebar_id() );
		} else if ( is_active_sidebar( 'hb-sidebar' ) ) {
			$single_book = get_option( 'tp_hotel_booking_enable_single_book' );
			if ( isset( $single_book ) && $single_book && is_singular( array( 'hb_room' ) ) ) {
				get_template_part( 'wp-hotel-booking-room/single-search-button' );
			}
			dynamic_sidebar( 'hb-sidebar' );
		} else {
			dynamic_sidebar( 'default-sidebar' );
		}
	?></div>
</aside>