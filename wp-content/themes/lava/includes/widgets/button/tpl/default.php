<?php

$button_style = !empty( $instance['design']['style'] ) ? 'lava-button-'. $instance['design']['style'] : 'lava-button-flat';

// button attributess
$button_attrs = '';
$attributes = array();

if ( !empty( $instance['url'] ) ) {
	$attributes['href'] = sow_esc_url( $instance['url'] );
}

if ( !empty( $instance['attributes']['id'] ) ) {
	$attributes['id'] = esc_attr( $instance['attributes']['id'] );
}

if ( empty( $instance['attributes']['classes'] ) ) {
	$attributes['class'] = esc_attr( $button_style );
} else {
	$attributes['class'] = esc_attr( $button_style .' '. trim( $instance['attributes']['classes'] ) );
}

if ( !empty( $instance['attributes']['title'] ) ) {
	$attributes['title'] = esc_attr( $instance['attributes']['title'] );
}

if ( !empty( $instance['attributes']['onclick'] ) ) {
	$attributes['onclick'] = esc_attr( $instance['attributes']['onclick'] );
}

if ( !empty( $instance['new_window'] ) && $instance['new_window'] ) {
	$attributes['target'] = '_blank';
}

if ( !empty( $attributes ) ) {
	foreach ( $attributes as $key => $value ) {
		$button_attrs .= ' '. esc_attr( $key ) .'="'. $value .'"';
	}
}

// button icon
$icon_type = !empty( $instance['design']['icon_type'] ) ? $instance['design']['icon_type'] : 'icon';
$icon_html = '';

if ( $icon_type == 'icon_image' ) {

    if ( !empty( $instance['design']['icon_image'] ) ) {
        $icon_html .= wp_get_attachment_image( $instance['design']['icon_image'], 'full', false, array( 'class' => 'lava-icon-image' ) );
    }

} elseif ( $icon_type == 'icon' ) {

	if ( !empty( $instance['design']['icon'] ) ) {
		$icon_html .= siteorigin_widget_get_icon( $instance['design']['icon'] );
	}
}

// button output
$button_text = !empty( $instance['text'] ) ? $instance['text'] : esc_html__( 'Button', 'lava' );

// button alignment

if ( !empty( $instance['align'] ) && $instance['align'] != 'inline' ) {
    echo '<div class="lava-button-wrapper ' . esc_attr( $instance['align'] ) . '-align"><a'. $button_attrs .'>'. $icon_html . esc_html( $button_text ) . '</a></div>';
} else {
	echo '<a'. $button_attrs .'>'. $icon_html . esc_html( $button_text ) . '</a>';
}