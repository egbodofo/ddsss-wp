<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $hb_room;
$galleries = $hb_room->get_galleries( false );
$widget_instance = uniqid();
?>

<?php if ( $galleries ): ?>
    <div class="hotel-room-gallery label-on">
        <div class="room-gallery-label"><h3><?php echo Lava_Util::get_option( 'hb_single_gallery_label', esc_html__( 'Room Gallery', 'lava' ) ); ?></h3></div>
        <div class="room-gallery-slider slick-slider" data-columns="3">
        <?php foreach ( $galleries as $gallery => $image ): ?>
        <?php $full_image = wp_get_attachment_image_src( $image['id'], 'full' ); ?>
        <?php $gallery_thumb = wp_get_attachment_image_src( $image['id'], 'lava_thumb_gallery' ); ?>
            <div >
            	<a class="slide-overlay" data-fancybox="<?php echo esc_attr( 'gallery-' . $widget_instance ); ?>" href="<?php echo esc_url( $full_image[0] ); ?>"></a>
                <img width="<?php echo esc_attr( $gallery_thumb[1] ); ?>" height="<?php echo esc_attr( $gallery_thumb[2] ); ?>" src="<?php echo esc_url( $gallery_thumb[0] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>