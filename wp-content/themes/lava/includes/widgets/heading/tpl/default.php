<?php
/**
 * @var $text
 * @var $subtext
 * @var $align
 * @var $top_image
 * @var $bottom_image
 * @var $tag
 * @var $color
 * @var $font_family
 * @var $font_weight
 * @var $font_size
 * @var $font_style
 * @var $letter_spacing
 * @var $line_height
 * @var $text_transform
 * @var $attributes
 */

$heading_style = '';
$classes[] = 'lava-heading';
$classes[] = $align .'-align';

if ( !empty( $attributes['classes'] ) ) {
	$classes[] = $attributes['classes'];
}

if ( !empty( $color ) ) {
	$heading_style .= 'color:'. $color .';';
}

if ( $font_family != 'default' ) {
	$heading_style .= 'font-family:"'. $font_family .'";';
}

if ( !empty( $font_size ) ) {
	$heading_style .= 'font-size:'. $font_size .';';
}

if ( !empty( $font_weight ) ) {
	$heading_style .= 'font-weight:'. $font_weight .';';
}

if ( !empty( $font_style ) ) {
	$heading_style .= 'font-style:'. $font_style .';';
}

if ( !empty( $letter_spacing ) ) {
	$heading_style .= 'letter-spacing:'. $letter_spacing .';';
}

if ( !empty( $line_height ) ) {
	$heading_style .= 'line-height:'. $line_height .';';
}

if ( !empty( $text_transform ) ) {
	$heading_style .= 'text-transform:'. $text_transform .';';
}

if ( !empty( $heading_style ) ) {
	$heading_style = ' style="'. esc_attr( $heading_style ) .'"';
}

echo '<div class="'. esc_attr( trim( implode( ' ', $classes ) ) ) .'">';

if ( !empty( $top_image ) ) {
	echo wp_get_attachment_image( $top_image, 'full', false, array( 'class' => 'lava-top-image' ) );
}

echo '<'. esc_attr( $tag ) .' class="lava-title"'. $heading_style .'>'. wp_kses_post( $text ) .'</'. esc_attr( $tag ) .'>';

if ( !empty( $subtext ) ) {
	$subtext_style = '';
	if ( !empty( $subtext_color ) ) {
		$subtext_style .= ' style="color:' . esc_attr( $subtext_color ) . ';"';
	}
	echo '<div class="lava-subtitle"'. $subtext_style .'>'. esc_attr( $subtext ) .'</div>';
}

if ( !empty( $bottom_image ) ) {
	echo '<div class="cf"></div>';
	echo wp_get_attachment_image( $bottom_image, 'full', false, array( 'class' => 'lava-bottom-image' )  );
}

echo '</div>';
