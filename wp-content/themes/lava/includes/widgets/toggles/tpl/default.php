<?php
/**
 * @var $title
 * @var $toggles
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

if ( count( $toggles ) > 0 ) {

    echo '<div class="lava-toggles">';

    foreach ( $toggles as $toggle ) :

        $toggle_class = isset( $toggle['toggle_active'] ) && $toggle['toggle_active'] ? ' lava-toggle-active' : '';

        echo '<div class="lava-toggle' . esc_attr( $toggle_class ) . '">';

        echo '<a class="lava-toggle-title" href="#">' . esc_html( $toggle['toggle_title'] ) . '<i class="material-icons">add</i></a>';

        echo '<div class="lava-toggle-panel">' . do_shortcode( $toggle['toggle_content'] ) . '</div>';

        echo '</div>';

    endforeach;

    echo '</div>';
}

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}