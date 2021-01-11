<?php $output = '';

switch ( get_post_format() ) {
	
	case 'video':
		echo hybrid_media_grabber( array( 'post_id' => get_the_ID(), 'type' => 'video', 'split_media' => true ) );
		break;
		
	case 'audio':
		echo hybrid_media_grabber( array( 'post_id' => get_the_ID(), 'type' => 'audio', 'split_media' => true ) );
		break;

	case 'gallery':
		echo hybrid_media_grabber( array( 'post_id' => get_the_ID(), 'type' => 'gallery', 'split_media' => true ) );
		break;

	default:
		if ( has_post_thumbnail( get_the_ID() ) ) :
			$img_id = get_post_thumbnail_id( get_the_ID() );
			$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			$img = wp_get_attachment_image_src( $img_id, Lava()->get_thumb_size() );
			?>
			<figure class="post-image">
				<img width="<?php echo esc_attr( $img[1] ); ?>" height="<?php echo esc_attr( $img[2] ); ?>" src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
			</figure>
			<?php
		endif;
		break;
}

