<?php

switch ( get_post_format() ) {
	
	case 'video':
		echo hybrid_media_grabber( array( 'post_id' => get_the_ID(), 'type' => 'video', 'split_media' => true ) );
		break;
		
	case 'audio':
		echo hybrid_media_grabber( array( 'post_id' => get_the_ID(), 'type' => 'audio', 'split_media' => true ) );
		break;

	case 'gallery':
		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'tiled-gallery' ) ) {
			echo get_post_gallery();

		} else {
			$gallery = get_post_gallery( get_the_ID(), false );
			$gallery_output = '';

			if ( isset( $gallery['ids'] ) ) {
				$image_ids = $gallery['ids'];
				$image_ids = explode( ',', $image_ids );
			}

			if ( !empty( $image_ids ) ) {
				echo '<div class="post-media"><div class="lava-gallery"><div class="slick-slider">';
				foreach ( $image_ids as $image_id ) {
					$image = wp_get_attachment_image_src( $image_id, Lava()->get_thumb_size() );
					$image_info = lava_get_attachment( $image_id );
					
					if ( $image ) {
						echo '<a href="'. esc_url( get_permalink() ) .'">';
						echo '<img width="'. esc_attr( $image[1] ) .'" height="'. esc_attr( $image[2] ) .'" src="'. esc_url( $image[0] ) .'" alt="'. esc_attr( $image_info['alt'] ) .'">';
						echo '</a>';
					}
				}
				echo '</div></div></div>';
			}
		}
		break;

	default:
		get_template_part( 'templates/loop/thumb' );
		break;
}

