<?php
$theme_fonts = Lava_Fonts::get_fonts();
$custom_fonts = get_option( 'lava_custom_fonts' );
?>
<div id="lava-admin-wrap" class="about-wrap lava-fonts">
	<?php require_once 'header.php'; ?>
	<div id="lava-font-panel" class="lava-card">
		<h2><?php esc_html_e( 'Theme Font List', 'lava' ); ?></h2>
		<ul id="lava-font-preview">
		<?php if ( !empty( $theme_fonts ) ) : ?>
			<?php foreach ( $theme_fonts as $font ) : ?>
				<li>
					<?php if ( $font['source'] == 'Custom' ) : ?>
					<?php echo '<style>' . Lava_Fonts::get_custom_font_css( $font['family'] ) . '</style>'; ?>
					<?php endif; ?>
					<span class="lava-font-specimen" style="font-family:'<?php echo esc_attr( $font['family'] ); ?>'">Grumpy wizards make toxic brew for the evil Queen and Jack.</span>
					<span class="lava-font-family" data-source="<?php echo esc_attr( $font['source'] ); ?>"><?php echo esc_html( $font['family'] ); ?></span>
					<a href="javascript:void(0)" class="lava-remove-font" title="<?php esc_attr_e( 'Remove Font', 'lava' ); ?>">X</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
		</ul>
		<ul id="lava-font-details">
		<?php if ( !empty( $theme_fonts ) ):
				foreach ( $theme_fonts as $font ):
					$variants = Lava_Fonts::get_variants( $font['family'] );
					$font_family = !empty( $font['family'] ) ? $font['family'] : 'Unknown';
					$font_variants = !empty( $font['variants'] ) ? $font['variants'] : '';
					$checked_variants = explode( ',', $font_variants );
					$variant_disabled = count( $variants ) > 1 ? '' : ' disabled';
				?>
				<li>
					<h2 class="lava-font-family"><?php echo esc_html( $font_family ); ?></h2>
					<div class="lava-font-source"><?php printf( esc_html__( 'Source: %s', 'lava' ), esc_html( $font['source'] ) ); ?></div>
					<?php if ( $font['source'] == 'Google'): ?>
						<div class="lava-font-variant-subset">
							<div class="lava-font-variants">
								<h3><?php esc_html_e( 'Variants', 'lava' ); ?>:</h3>
								<ul><?php foreach( $variants as $variant ):
									$attr = '';
									if ( ! empty( $checked_variants ) && in_array( $variant, $checked_variants ) || !empty( $variant_disabled ) ) {
										$attr = ' checked';
									} ?>
									<li>
										<label>
											<input type="checkbox" data-variant="<?php echo esc_attr( $variant ); ?>" class="lava-check-variant"<?php echo esc_attr( $attr . $variant_disabled ); ?>>
											<?php echo esc_html( $variant ); ?>
										</label>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
							<div class="clear"></div>
						</div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
		</ul>
		<div id="lava-save-fonts">
			<a class="lava-button-submit button-primary" href="javascript:void(0)"><?php esc_html_e( 'Save Fonts', 'lava' ); ?></a>
			<span class="lava-form-message"></span>
			<span class="spinner"></span>
		</div>
	</div>
	<div id="lava-font-library" class="row">
		<div class="col">
			<div id="lava-custom-fonts" class="lava-card">
				<h2><?php esc_html_e( 'Custom Fonts', 'lava' ); ?></h2>
				<ul class="lava-font-list">
				<?php if ( !empty( $custom_fonts ) ) : ?>
					<?php foreach ( $custom_fonts as $font ): ?>
						<li>
							<span><?php echo esc_html( $font['family'] ); ?></span>
							<div class="lava-font-actions">
								<a href="javascript:void(0)" class="lava-add-font" title="<?php esc_attr_e( 'Add Font', 'lava' ); ?>">+</a>
								<a href="javascript:void(0)" class="lava-remove-custom-font" title="<?php esc_attr_e( 'Remove Font', 'lava' ); ?>">&ndash;</a>
							</div>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
				</ul>
			</div>
			<div id="lava-google-fonts" class="lava-card">
				<h2><?php esc_html_e( 'Google Web Fonts', 'lava' ); ?></h2>
				<div id="lava-font-filter">
				<?php $letters = range( 'A', 'Z' );
					foreach ( $letters as $letter ):
						if ( $letter !== 'X' ): ?>
						<a href="javascript:void(0)"><?php echo esc_html( $letter ); ?></a><?php
						endif;
					endforeach; ?>
				</div>
				<ul class="lava-font-list">
					<?php $google_web_fonts = Lava_Fonts::get_google_fonts();
						if ( !empty( $google_web_fonts ) ) :
							foreach ( $google_web_fonts as $font ) :
								$font_family = $font['family'];
								$ff = preg_replace( '/\s/', '+', $font_family );
								$preview_link = 'https://www.google.com/fonts/specimen/' . $ff;
							?>
							<li class="lava-fi-<?php echo esc_attr( $font_family[0] ); ?>">
								<span><?php echo esc_html( $font_family ); ?></span>
								<div class="lava-font-actions">
									<a href="<?php echo esc_url( $preview_link ); ?>" target="_blank" class="lava-preview-font"><?php esc_html_e( 'Preview', 'lava' ) ?></a>
									<a href="javascript:void(0)" class="lava-add-font" title="<?php esc_attr_e( 'Add Font', 'lava' ); ?>">+</a>
								</div>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="col">
			<div class="lava-card">
				<h2><?php esc_html_e( 'Add Custom Font', 'lava' ); ?></h2>
				<p class="lava-form-message"></p>
				<form id="lava-form-custom-font" method="POST" action="<?php echo esc_url( admin_url( 'admin.php?page=lava_fonts', Lava_Util::$http_or_https ) ); ?>" enctype="multipart/form-data">
					<div>
						<label for="lava-file-woff"><?php esc_html_e( 'Custom Fonts', 'lava' ); ?>.woff</label>
						<div class="lava-file-input">
							<span class="lava-file-name"></span>
							<div class="lava-upload-buttons">
								<input type="file" name="lava-ff-woff" id="lava-ff-woff" class="lava-ff">
								<input type="button" class="lava-upload-submit" value="<?php esc_attr_e( 'Upload', 'lava' ); ?>">
								<input type="button" class="lava-upload-remove" value="X">
							</div>
						</div>
					</div>
					<div>
						<label for="lava-file-ttf"><?php esc_html_e( 'Custom Fonts', 'lava' ); ?>.ttf</label>
						<div class="lava-file-input">
							<span class="lava-file-name"></span>
							<div class="lava-upload-buttons">
								<input type="file" id="lava-ff-ttf" class="lava-ff">
								<input type="button" class="lava-upload-submit" value="<?php esc_attr_e( 'Upload', 'lava' ); ?>">
								<input type="button" class="lava-upload-remove" value="X">
							</div>
						</div>
					</div>
					<div>
						<label for="lava-file-eot"><?php esc_html_e( 'Custom Fonts', 'lava' ); ?>.eot</label>
						<div class="lava-file-input">
							<span class="lava-file-name"></span>
							<div class="lava-upload-buttons">
								<input type="file" id="lava-ff-eot" class="lava-ff">
								<input type="button" class="lava-upload-submit" value="<?php esc_attr_e( 'Upload', 'lava' ); ?>">
								<input type="button" class="lava-upload-remove" value="X">
							</div>
						</div>
					</div>
					<div>
						<label for="lava-file-svg"><?php esc_html_e( 'Custom Fonts', 'lava' ); ?>.svg</label>
						<div class="lava-file-input">
							<span class="lava-file-name"></span>
							<div class="lava-upload-buttons">
								<input type="file" id="lava-ff-svg" class="lava-ff">
								<input type="button" class="lava-upload-submit" value="<?php esc_attr_e( 'Upload', 'lava' ); ?>">
								<input type="button" class="lava-upload-remove" value="X">
							</div>
						</div>
					</div>
					<div>
						<label for="lava-file-woff2"><?php esc_html_e( 'Custom Fonts', 'lava' ); ?>.woff2</label>
						<div class="lava-file-input">
							<span class="lava-file-name"></span>
							<div class="lava-upload-buttons">
								<input type="file" id="lava-ff-woff2" class="lava-ff">
								<input type="button" class="lava-upload-submit" value="<?php esc_attr_e( 'Upload', 'lava' ); ?>">
								<input type="button" class="lava-upload-remove" value="X">
							</div>
						</div>
					</div>
					<div>
						<label for="lava-custom-font-name"><?php esc_html_e( 'Font Name', 'lava' ); ?></label>
						<input type="text" id="lava-custom-font-name">
					</div>
					<div>
						<input type="submit" class="lava-font-submit button-primary" value="<?php esc_attr_e( 'Add Custom Font', 'lava' ); ?>">
						<?php wp_nonce_field( 'save-cf-nonce', 'lava-save-cf-nonce' ); ?>
						<div class="spinner"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>