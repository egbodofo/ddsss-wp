<?php
/**
 * @var $title
 * @var $style
 * @var $alignment
 * @var $attributes
 */

// widget title

lava_so_widget_title( $instance, $args );

// widget content

$classes[] = 'lava-social-buttons';

if ( !empty( $attributes['classes'] ) ) {
	$classes[] = $attributes['classes'];
}

if ( !empty( $style ) ) {
	$classes[] = 'style-'. $style;
}

if ( 'left' != $alignment ) {
	$classes[] = $alignment .'-align';
}

$theme_mods = get_theme_mods();

?>
<div class="<?php echo esc_attr( trim( implode( ' ', $classes ) ) ); ?>">
	<div class="social-list cf">
	<?php if ( ! empty( $theme_mods['sm_facebook'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_facebook'] ); ?>" target="_blank" title="Facebook"><i class="lava-icon-facebook"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_twitter'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_twitter'] ); ?>" target="_blank" title="Twitter"><i class="lava-icon-twitter"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_googleplus'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_googleplus'] ); ?>" target="_blank" title="Google +"><i class="lava-icon-gplus"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_instagram'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_instagram'] ); ?>" target="_blank" title="Instagram"><i class="lava-icon-instagram"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_pinterest'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_pinterest'] ); ?>" target="_blank" title="Pinterest"><i class="lava-icon-pinterest"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_behance'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_behance'] ); ?>" target="_blank" title="Behance"><i class="lava-icon-behance"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_delicious'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_delicious'] ); ?>" target="_blank" title="Delicious"><i class="lava-icon-delicious"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_dribbble'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_dribbble'] ); ?>" target="_blank" title="Dribbble"><i class="lava-icon-dribbble"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_skype'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_skype'] ); ?>" target="_blank" title="Skype"><i class="lava-icon-skype"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_wordpress'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_wordpress'] ); ?>" target="_blank" title="WordPress"><i class="lava-icon-wordpress"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_stumbleupon'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_stumbleupon'] ); ?>" target="_blank" title="StumbleUpon"><i class="lava-icon-stumbleupon"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_linkedin'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_linkedin'] ); ?>" target="_blank" title="Linkedin"><i class="lava-icon-linkedin"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_weibo'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_weibo'] ); ?>" target="_blank" title="Weibo"><i class="lava-icon-weibo"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_wechat'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_wechat'] ); ?>" target="_blank" title="Weixin"><i class="lava-icon-wechat"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_vk'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_vk'] ); ?>" target="_blank" title="Vk"><i class="lava-icon-vk"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_vine'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_vine'] ); ?>" target="_blank" title="Vine"><i class="lava-icon-vine"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_reddit'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_reddit'] ); ?>" target="_blank" title="Reddit"><i class="lava-icon-reddit"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_youtube'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_youtube'] ); ?>" target="_blank" title="Youtube"><i class="lava-icon-youtube-play"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_vimeo'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_vimeo'] ); ?>" target="_blank" title="Vimeo"><i class="lava-icon-vimeo"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_soundcloud'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_soundcloud'] ); ?>" target="_blank" title="Soundcloud"><i class="lava-icon-soundcloud"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_flickr'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_flickr'] ); ?>" target="_blank" title="Flickr"><i class="lava-icon-flickr"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_tripadvisor'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_tripadvisor'] ); ?>" target="_blank" title="TripAdvisor"><i class="lava-icon-tripadvisor"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_tumblr'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_tumblr'] ); ?>" target="_blank" title="Tumblr"><i class="lava-icon-tumblr"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_whatsapp'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_whatsapp'] ); ?>" target="_blank" title="WhatsApp"><i class="lava-icon-whatsapp"></i></a><?php endif; ?>
	<?php if ( ! empty( $theme_mods['sm_rss'] ) ): ?>
		<a href="<?php echo esc_url( $theme_mods['sm_rss'] ); ?>" target="_blank" title="RSS"><i class="lava-icon-rss"></i></a><?php endif; ?>
	</div>
</div>