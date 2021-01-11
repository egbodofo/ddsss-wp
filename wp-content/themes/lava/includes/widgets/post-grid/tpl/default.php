<?php
/**
 * @var $title
 */

if ( empty( $instance['query'] ) ) {
	return;
}

$query_args = siteorigin_widget_post_selector_process_query( $instance['query'] );

$posts_query = new WP_Query( $query_args );

if ( !$posts_query->have_posts() ) {
	return;
}

// container start

$classes = array();

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

$post_type 		 = isset( $query_args['post_type'] ) ? $query_args['post_type'] : 'post';
$column_class 	 = lava_get_column_class( intval( $instance['settings']['columns'] ) );
$show_date 		 = isset( $instance['settings']['date'] ) ? (bool) $instance['settings']['date'] : true;
$excerpt_length  = isset( $instance['settings']['excerpt_length'] ) ? absint( $instance['settings']['excerpt_length'] ) : 120;
$attachment_size = !empty( $instance['settings']['attachment_size'] ) ? $instance['settings']['attachment_size'] : 'lava_thumb_small';

?>
<div class="lava-post-grid">
	<div class="row">
	<?php while ( $posts_query->have_posts() ): $posts_query->the_post(); ?>
	  	<div <?php post_class( 'post '. $column_class ); ?>>
	  		<div class="card equal-height">
				<?php if ( has_post_thumbnail() ): ?>
					<div class="post-thumb">
						<a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php the_post_thumbnail( $attachment_size ); ?></a>
						<span class="read-more"><i class="material-icons">add</i><?php esc_html_e( 'Read More', 'lava' ); ?></span>
					</div>
				<?php endif; ?>
				<div class="post-info">
				<?php if ( $post_type == 'hb_room' && class_exists( 'WP_Hotel_Booking' ) ) {
						lava_hb_room_title();
                		lava_hb_room_excerpt();
                		do_action( 'hotel_booking_loop_room_price' );
                	} else {
						echo lava_get_post_title();
						echo lava_get_post_excerpt( $excerpt_length );
						if ( $show_date ) {
							echo '<div class="post-date">'. get_the_date( 'F j' ) .'</div>';
						}
					}
					if ( $post_type == 'lava_offer' && function_exists( 'lava_offer_price' ) ) {
						echo lava_offer_price();
					}
				?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}