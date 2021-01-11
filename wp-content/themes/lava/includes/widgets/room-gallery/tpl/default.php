<?php
/**
 * @var $items array
 * @var $label
 * @var $label_text
 */

global $hb_room;

$widget_instance = uniqid();

if ( !empty( $items ) ) : ?>
<div class="hotel-room-gallery<?php echo esc_attr( $label ? ' label-on' : '' ); ?>">
	<?php if ( $label ) : ?>
		<div class="room-gallery-label"><h3><?php echo esc_html( $label_text ); ?></h3></div>
	<?php endif; ?>
	<div class="room-gallery-slider slick-slider" data-columns="<?php echo esc_attr( $label ? 3 : 4 ); ?>">
	<?php foreach ( $items as $item ) :
		$full_src = wp_get_attachment_image_src( $item['image'], 'full' );
		$full_src = empty( $full_src ) ? '' : $full_src[0];
		?>
		<div>
			<a class="slide-overlay" data-fancybox="<?php echo esc_attr( 'gallery-' . $widget_instance ); ?>" href="<?php echo sow_esc_url( $full_src ) ?>"></a>
			<?php echo wp_get_attachment_image( $item['image'], 'lava_thumb_gallery', false ); ?>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>