<?php
/**
 * @var $title
 * @var $accordion
 */

$title_style = $title_class = '';
$classes = array();

// container start

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

if ( count( $accordion ) > 0 ) {

	$accordion_content = '';

	foreach ( $accordion as $accordion_item ) :

		$accordion_class = isset( $accordion_item['accordion_active'] ) && $accordion_item['accordion_active'] ? ' lava-accordion-active' : '';

	    $accordion_content .= '<div class="lava-accordion-item' . esc_attr( $accordion_class ) . '">';

	    $accordion_content .= '<a class="lava-accordion-title" href="#">' . esc_html( $accordion_item['accordion_title'] ) . '<i class="material-icons">add</i></a>';

	    $accordion_content .= '<div class="lava-accordion-panel">' . do_shortcode( $accordion_item['accordion_content'] ) . '</div>';

	    $accordion_content .= '</div>';

	endforeach;

	echo '<div class="lava-accordion">'. wp_kses_post( $accordion_content ) .'</div>';
}

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}