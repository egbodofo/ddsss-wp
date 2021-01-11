<?php
/**
 * @var $title
 * @var $text
 */

$classes = array();

// container start

if ( !empty( $instance['layout']['container'] ) ) {
	$classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( isset( $instance['layout']['equal_height'] ) && $instance['layout']['equal_height'] ) {
	$classes[] = 'equal-height';
}

if ( !empty( $instance['attributes']['classes'] ) ) {
    $classes[] = $instance['attributes']['classes'];
}

if ( !empty( $classes ) ) {
	echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

$style_attr ='';

if ( !empty( $instance['layout']['height'] ) ) {
	$style_attr = ' style="min-height:'. esc_attr( $instance['layout']['height'] ) .';"';
}

echo '<div class="lava-text post-content"'. $style_attr .'>'. $text .'</div>';

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}