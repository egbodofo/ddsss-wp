<?php get_header(); ?>
<?php do_action( 'lava_content_start' ); ?>
	<div class="error-page">
		<div class="center-align">
			<div id="error-404">
				<h1 class="error-title"><?php esc_html_e( '404', 'lava' ); ?></h1>
				<h2 class="error-message"><?php esc_html_e( 'Page not found.', 'lava' ); ?></h2>
				<nav><a class="btn-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Homepage', 'lava' ); ?></a></nav>
			</div>
		</div>
	</div>
<?php do_action( 'lava_content_end' ); ?>
<?php get_footer(); ?>