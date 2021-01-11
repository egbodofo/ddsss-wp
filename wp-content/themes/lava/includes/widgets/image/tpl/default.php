<?php
/**
 * @var $title
 * @var $image
 * @var $overlay
 * @var $overlay_opacity
 * @var $size
 * @var $url
 * @var $new_window
 */

$image_html = wp_get_attachment_image( $image, $size, $icon = false, array( 'class' => 'lava-image' ) );

if ( empty( $image_html ) ) {
	return;
}

$icon_type = !empty( $instance['content']['icon_type'] ) ? $instance['content']['icon_type'] : 'icon';
$icon_html = '';

if ( $icon_type == 'icon_image' ) {

    if ( !empty( $instance['content']['icon_image'] ) ) {
        $icon_html .= '<div class="lava-image-wrapper">'. wp_get_attachment_image( $instance['content']['icon_image'], 'full', false, array( 'class' => 'lava-icon-image' ) ) .'</div>';
    }

} else if ( $icon_type == 'icon' ) {

	if ( !empty( $instance['content']['icon'] ) ) {
		$icon_html .= '<div class="lava-icon-wrapper">'. siteorigin_widget_get_icon( $instance['content']['icon'] ) .'</div>';
	}
}

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

// widget content

$style_attr = '';

if ( !empty( $instance['layout']['height'] ) ) {
	$style_attr .= ' style="min-height:'. esc_attr( $instance['layout']['height'] ) .';"';
}

echo '<div class="lava-image"'. $style_attr .'>';

if ( !empty( $overlay ) ) {
	echo '<div class="lava-image-overlay" style="background-color:'. esc_attr( $overlay ) .';opacity:'. esc_attr( $overlay_opacity*0.01 ) .'"></div>';
}

if ( !empty( $instance['content']['text'] ) || !empty( $icon_html ) ) {
	echo '<div class="lava-image-content">'. $icon_html .'<h3 class="lava-image-text">'. esc_html( $instance['content']['text'] ) .'</h3></div>';
}

echo '<div class="lava-image-holder">';

if ( !empty( $url ) ) {
	echo '<a href="'. sow_esc_url( $url ) .'"'. ( $new_window ? ' target="_blank"' : '' ) .'>';
}

echo wp_get_attachment_image( $image, $size, $icon = false, array( 'class' => 'lava-image' ) );

if ( !empty( $url ) ) {
	echo '</a>';
}

echo '</div>';
echo '</div>';

// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}