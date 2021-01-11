<?php
/**
 * @var $title
 * @var $items
 */

// container start

$classes = array();

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

$style_attr = '';

if ( !empty( $instance['layout']['height'] ) ) {
    $style_attr = ' style="min-height:'. esc_attr( $instance['layout']['height'] ) .';"';
}

$content = '';

if ( count( $items ) > 0 ) {

    echo '<ul class="lava-list"'. $style_attr .'>';

    foreach ( $items as $item ) :

        echo '<li class="lava-list-item">';
    
        $icon_type = !empty( $item['icon_type'] ) ? $item['icon_type'] : 'icon';
        $icon_html = $icon_style = '';
    
        if ( $icon_type == 'icon_image' ) {
    
            if ( !empty( $item['icon_image'] ) ) {
                $icon_html .= wp_get_attachment_image( $item['icon_image'], 'full', false, array( 'class' => 'lava-icon-image' ) );
            }
    
        } elseif ( $icon_type == 'icon' ) {
    
            if ( !empty( $item['icon'] ) ) {
                if ( !empty( $item['icon_color'] ) ) {
                    $icon_style = ' style="color:'. esc_attr( $item['icon_color'] ) . ';"';
                }
                $icon_html .= siteorigin_widget_get_icon( $item['icon'] );
            }
        }
    
        if ( !empty( $icon_html ) ) {
            echo '<span class="lava-list-icon"'. $icon_style .'>'. $icon_html .'</span>';
        }
    
        echo '<span class="lava-list-text">'. esc_html( $item['text'] ) .'</span>';
    
        echo '</li>';
    
    endforeach;

    echo '</ul>';
}

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}