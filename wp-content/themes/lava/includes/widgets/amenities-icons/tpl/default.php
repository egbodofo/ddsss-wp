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

    echo '<div class="lava-amenities-icons"'. $style_attr .'>';

    foreach ( $amenities as $amenity ) :

        echo '<div class="lava-amenity">';
    
        $icon_type = !empty( $amenity['icon_type'] ) ? $amenity['icon_type'] : 'icon';
        $icon_html = $icon_style = '';
    
        if ( $icon_type == 'icon_image' ) {
    
            if ( !empty( $amenity['icon_image'] ) ) {
                $icon_html .= wp_get_attachment_image( $amenity['icon_image'], 'full', false, array( 'class' => 'lava-icon-image' ) );
            }
    
        } elseif ( $icon_type == 'icon' ) {
    
            if ( !empty( $amenity['icon'] ) ) {
                if ( !empty( $amenity['icon_color'] ) ) {
                    $icon_style = ' style="color:'. esc_attr( $amenity['icon_color'] ) . ';"';
                }
                $icon_html .= siteorigin_widget_get_icon( $amenity['icon'] );
            }
        }
    
        echo '<span class="lava-amenity-icon"'. $icon_style .'>'. $icon_html .'</span>';
    
        echo '<span class="lava-amenity-description">'. esc_html( $amenity['description'] ) .'</span>';
    
        echo '</div>';
    
    endforeach;

    echo '</div>';
}

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}