<?php
/**
 * @var $title
 * @var $amenities
 */

$classes = array();

// container start

if ( !empty( $instance['layout']['container'] ) ) {
	$classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( isset( $instance['layout']['equal_height'] ) && $instance['layout']['equal_height'] ) {
	$classes[] = 'equal-height';
}

if ( !empty( $classes ) ) {
	echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

if ( count( $amenities ) > 0 ) {

    $style_attr = '';

    if ( !empty( $instance['layout']['height'] ) ) {
        $style_attr .= ' style="min-height:'. esc_attr( $instance['layout']['height'] ) .';"';
    }

    echo '<div class="lava-amenities"'. $style_attr .'>';
    
    foreach ( $amenities as $amenity ) {

        echo '<div class="lava-amenity">';
    
        echo '<div class="lava-amenity-holder"><span class="lava-amenity-title">'. esc_html( $amenity['title'] ) .'</span></div>';
    
        echo '<div class="lava-amenity-holder"><span class="lava-amenity-description">'. esc_html( $amenity['description'] ) .'</span></div>';
    
        echo '</div>';
    
    }

    echo '</div>';
}

// container end

if ( !empty( $classes ) ) {
	echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
	echo '</div>';
}
