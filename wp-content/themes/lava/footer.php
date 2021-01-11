			<footer id="footer">
			<?php if ( Lava_Util::get_option( 'footer_top', true ) ): ?>
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
						<?php for ( $i = 1; $i < 5; $i ++ ): ?>
							<div class="col x12 s6 m3 <?php echo 'footer-'. $i; ?>">
								<?php if ( is_active_sidebar( 'footer-'. $i ) ) : ?>
									<?php dynamic_sidebar( 'footer-'. $i ); ?>
								<?php endif; ?>
							</div>
						<?php endfor; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php get_template_part( 'templates/footer/bottom', Lava_Util::get_option( 'footer_bottom_style', '1' ) ); ?>
			</footer>
			<?php if ( Lava_Util::get_option( 'scroll_top', true ) ) : ?>
				<a id="scroll-top" href="javascript:void(0)"><i class="material-icons">keyboard_arrow_up</i></a>
			<?php endif; ?>
		</div>
	</div>
	<?php echo Lava_Util::get_option( 'footer_code', '' ); ?>
	<?php wp_footer(); ?>
</body>
</html>