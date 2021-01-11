<?php if ( 'default' == Lava()->get_header() ) : ?>
	<div class="page-header"<?php echo Lava()->get_header_image_style(); ?>>
		<div class="page-header-overlay"></div>
		<h1 class="page-title">
			<?php echo esc_html( Lava()->get_title() ); ?>
			<?php $subtitle = get_post_meta( get_the_ID(), '_lava_room_type_title', true ); ?>
			<?php if ( !empty( $subtitle ) ) : ?>
				<span class="page-subtitle"><?php echo esc_html( $subtitle ); ?></span>
			<?php endif; ?>
		</h1>
	</div>
<?php

elseif ( 'slider' == Lava()->get_header() ) :

	$slider_shortcode = lava()->get_header_shortcode();
	if ( empty( $slider_shortcode ) ) {
		if ( '2' == Lava()->get_header_style() ) {
			echo '<div class="header-placeholder"></div>';
		}
		echo '<div class="content-box center-align">'. esc_html__( 'Slider shortcode empty!', 'lava' ) .'</div>';
	} else {
		echo do_shortcode( html_entity_decode( $slider_shortcode ) );
	}

elseif ( 'image' == Lava()->get_header() ) : ?>
	<div class="fullscreen-image"<?php echo Lava()->get_header_image_style(); ?>>
		<div class="header-content">
		<?php
			$header_title = get_post_meta( Lava()->get_ID(), '_lava_header_title', true );
			$header_subtitle = get_post_meta( Lava()->get_ID(), '_lava_header_subtitle', true );
			$header_text = get_post_meta( Lava()->get_ID(), '_lava_header_text', true );
			$button_text = get_post_meta( Lava()->get_ID(), '_lava_header_button_text', true );
			$button_url = get_post_meta( Lava()->get_ID(), '_lava_header_button_url', true ); ?>
			<?php if ( !empty( $header_title ) ): ?>
				<h1 class="header-title"><?php echo esc_html( $header_title ); ?></h1>
			<?php endif; ?>
			<?php if ( !empty( $header_subtitle ) ): ?>
				<h2 class="header-subtitle"><?php echo esc_html( $header_subtitle ); ?></h2>
			<?php endif; ?>
			<?php if ( !empty( $header_text ) ): ?>
				<p class="header-text"><?php echo esc_html( $header_text ); ?></p>
			<?php endif; ?>
			<?php if ( !empty( $button_text ) ): ?>
			<?php $button_class = ( !empty( $button_url ) && '#' == $button_url ) ? ' to-content' : ''; ?>
				<a href="<?php echo esc_url( $button_url ); ?>" class="btn-stroke-light<?php echo esc_attr( $button_class ); ?>"><?php echo esc_html( $button_text ); ?></a>
			<?php endif; ?>
		</div>
		<button type="button" id="to-content"><i class="material-icons">keyboard_arrow_down</i></button>
		<div class="page-header-overlay"></div>
	</div>
<?php

elseif ( 'placeholder' == Lava()->get_header() ) :

	echo '<div class="header-placeholder"></div>';

endif;