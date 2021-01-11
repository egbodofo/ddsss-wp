<div class="footer-bottom">
	<div class="container-fluid">
		<div class="bottom-style-2">
			<?php lava_social_icons( 'footer-social' ); ?>
			<div class="footer-copyright">
				<?php echo wp_kses_post( Lava_Util::get_option( 'footer_copyright', '' ) ); ?>
			</div>
		</div>
	</div>
</div>