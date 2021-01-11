<?php
/**
 * @var $title
 * @var $quote
 * @var $by
 */

// container start

$classes = array();

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

?>
<div class="lava-quote">

	<?php if ( !empty( $quote ) ) : ?>

		<div class="lava-quote-text"><?php echo wp_kses_post( $quote ); ?></div>

	<?php endif; ?>

	<?php if ( !empty( $by ) ) : ?>

		<div class="lava-quote-by"><?php echo esc_html( $by ); ?></div>

	<?php endif; ?>

</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}