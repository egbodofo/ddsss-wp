<div class="logo-wrapper">
<?php
	$site_title = esc_attr( get_bloginfo( 'name' ) );
	$logo_url = Lava_Util::get_option( 'logo', '' );
	$logo_r_url = Lava_Util::get_option( 'logo_retina', '' );
	$logo_width = Lava_Util::get_option( 'logo_width', '' );
	$logo_height = Lava_Util::get_option( 'logo_height', '' );
	$small_logo_url = Lava_Util::get_option( 'small_logo', '' );
	$small_logo_r_url = Lava_Util::get_option( 'small_logo_retina', '' );
	$attr_data = $logo_class = $small_attr_data = $small_logo_class = '';

	// logo width and height attribute
	if ( !empty( $logo_width ) ) {
		$logo_width = filter_var( $logo_width, FILTER_SANITIZE_NUMBER_INT );
	}

	if ( !empty( $logo_height ) ) {
		$logo_height = filter_var( $logo_height, FILTER_SANITIZE_NUMBER_INT );
	}

	// retina logo url
	if ( !empty( $logo_r_url ) ) {
		$attr_data = ' data-retina="'. esc_url( $logo_r_url ) .'"';

		if ( empty( $logo_url ) ) {
			$logo_url = $logo_r_url;

		} else {
			$logo_class = 'logo-retina';
		}
	}

	if ( empty( $small_logo_url ) ) {
		$small_logo_url = $logo_url;
	}

	// small retina logo url
	if ( !empty( $small_logo_r_url ) ) {

		if ( empty( $small_logo_url ) ) {
			$small_logo_url = $small_logo_r_url;

		} else {
			$small_logo_class = 'logo-retina';
		}
	}

	// output logo
	if ( !empty( $logo_url ) ): ?>
	
	<a itemprop="url" class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<img class="<?php echo esc_attr( $logo_class ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" data-retina="<?php echo esc_url( $logo_r_url ); ?>" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_title ); ?>">
	</a>

<?php else: ?>
	
	<a itemprop="url" class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $site_title );?>"><?php echo esc_html( $site_title ); ?></a>

<?php endif; ?>

<?php 
	// output small logo
	if ( !empty( $small_logo_url ) ): ?>

	<a itemprop="url" class="small-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<img class="<?php echo esc_attr( $small_logo_class ); ?>" src="<?php echo esc_url( $small_logo_url ); ?>" alt="<?php echo esc_attr( $site_title ); ?>">
	</a>

<?php endif; ?>

	<meta itemprop="name" content="<?php echo esc_attr( $site_title ); ?>">
</div>