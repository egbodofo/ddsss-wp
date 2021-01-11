<?php
/**
 * @var $title
 * @var $popup
 * @var $show_label
 * @var $max_guests
 * @var $min_booking_days
 * @var $room_types
 */

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

echo do_shortcode('[lava_booking_form popup="'. $popup .'" show_label="'. $show_label .'" max_guests="'. $max_guests .'" min_booking_days="'. $min_booking_days .'" room_types="'. $room_types .'"]');

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}