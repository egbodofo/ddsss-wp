<?php
/**
 * @var $title
 * @var $style
 * @var $text
 * @var $image
 * @var $image_size
 * @var $classes
 */

$classes = ( !empty( $classes ) ) ? ' ' . trim( $classes ) : '';
$column_class = $style == 'left_text' ? ' pull-right' : '';

?>
<div class="lava-content-block<?php echo esc_attr( $classes ); ?>">

	<?php if ( $style == 'text' ): ?>
		
		<div class="container-full">
			<?php lava_so_widget_title( $instance, $args ); ?>
			<div class="lava-text"><?php echo do_shortcode( $text ); ?></div>
		</div>

	<?php else: ?>

		<div class="row no-padding">
			<div class="col x12 m6<?php echo esc_attr( $column_class ); ?>">
				<div class="lava-image-holder equal-height">
					<?php echo wp_get_attachment_image( $image, $image_size, false, array( 'class' => 'lava-image' ) ); ?>
				</div>
			</div>
			<div class="col x12 m6">
				<div class="lava-text container-half equal-height">
					<?php lava_so_widget_title( $instance, $args ); ?>
					<div class="post-content"><?php echo do_shortcode( $text ); ?></div>
				</div>
			</div>
		</div>

	<?php endif; ?>

</div>