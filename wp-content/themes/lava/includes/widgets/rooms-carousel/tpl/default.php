<?php
/**
 * @var $title
 * @var $rooms
 * @var $number
 * @var $nav
 * @var $pagination
 * @var $text_link
 * @var $card_style
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

echo do_shortcode('[hotel_booking_slider rooms="'. esc_attr( $rooms ) .'" number="'. esc_attr( $number ) .'" nav="'. esc_attr( $nav ) .'" pagination="'. esc_attr( $pagination ) .'" text_link="'. esc_attr( $text_link ) .'" card_style="'. esc_attr( $card_style ) .'"]');

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}
