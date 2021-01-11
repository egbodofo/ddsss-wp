<?php
/**
 * @var $style
 * @var $color
 * @var $height
 * @var $attributes
 */

$divider_style = '';
$classes[] = 'lava-divider';

if ( !empty( $attributes['classes'] ) ) {
	$classes[] = $attributes['classes'];
}

if ( !empty( $style ) ) {
	$classes[] = $style;
}

if ( !empty( $color ) ) {

	if ( !empty( $style ) && $style == 'gradient' ) {
		$divider_style .= 'background:'. $color .';';
		$divider_style .= '-webkit-linear-gradient(left,transparent,'. $color .',transparent);';
		$divider_style .= 'background:linear-gradient(to right,rgba(0,0,0,0),'. $color .',rgba(0,0,0,0));';
	} else {
		$divider_style .= 'border-color:'. $color .';';
	}
}

if ( !empty( $height) ) {
	if ( !empty( $style ) && $style == 'gradient' ) {
		$divider_style .= 'height:'. $height .';';
	} else {
		$divider_style .= 'border-top-width:'. $height .';';
	}
}

if ( !empty( $divider_style ) ) {
	$divider_style = ' style="'. esc_attr( $divider_style ) .'"';
}

echo '<hr class="'. esc_attr( trim( implode( ' ', $classes ) ) ) .'"'. $divider_style .'>';

