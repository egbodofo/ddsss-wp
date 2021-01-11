<?php
/**
 * @var $title
 * @var $display
 * @var $start_date
 * @var $end_date
 * @var $featured
 * @var $number
 */

if ( !defined( 'TRIBE_EVENTS_FILE' ) ) {
	return;
}

$query_args = array(
    'eventDisplay' => $display,
    'posts_per_page' => $number,
    'start_date' => current_time( 'timestamp' ),
);

if ( !empty( $start_date ) ) {
    $query_args['start_date'] = $start_date;
}

if ( !empty( $end_date ) ) {
    $query_args['end_date'] = $end_date;
}

if ( $featured ) {
    $query_args['featured'] = 1;
}

$events = tribe_get_events( $query_args );

if ( empty( $events ) ) {
	return;
}

$slider_settings = $temp_settings = '';

if ( isset( $instance['autoplay'] ) && $instance['autoplay'] ) {
	$temp_settings .= '"autoplay":true,';
}

if ( !empty( $instance['speed'] ) ) {
	$temp_settings .= '"autoplaySpeed":'. $instance['speed']*1000 .',';
}

if ( is_rtl() ) {
	$temp_settings .= '"rtl":true';
}

if ( ! empty( $temp_settings ) ) {
	$slider_settings .= ' data-slick=\'{'. esc_attr( $temp_settings ) .'}\'';
	$slider_settings = str_replace( ',}', '}', $slider_settings );
}

// container start

$classes = array();

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. $instance['layout']['container'];
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content
?>
<div class="lava-event-carousel">
	<div class="slick-slider"<?php echo htmlspecialchars( $slider_settings ); ?>>
	<?php
		foreach( $events as $event ) :
			$event_link = tribe_get_event_link( $event );
		?>
		<div <?php post_class( 'post-event post', $event->ID ); ?>>
			<div class="card">
				<?php if ( has_post_thumbnail( $event ) ): ?>
					<div class="post-thumb">
						<a href="<?php echo esc_url( $event_link ) ?>"><?php echo get_the_post_thumbnail( $event, 'lava_thumb_small' ); ?></a>
						<span class="read-more"><i class="material-icons">add</i><?php esc_html_e( 'Read More', 'lava' ); ?></span>
					</div>
				<?php endif; ?>
				<div class="post-info">
					<div class="event-meta">
						<div class="event-day"><?php echo tribe_get_start_date( get_the_ID(), false, 'l' ); ?></div>
						<div class="event-date post-date"><?php echo tribe_get_start_date( get_the_ID(), false ); ?></div>
					</div>
					<h3 class="post-title"><a href="<?php echo esc_url( $event_link ); ?>"><?php echo esc_html( $event->post_title ); ?></a></h3>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>
<?php

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}
