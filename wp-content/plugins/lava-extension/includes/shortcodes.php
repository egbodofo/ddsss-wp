<?php

add_shortcode( 'lava_social_buttons', 'lava_sc_social_buttons' );

if ( !function_exists( 'lava_sc_social_buttons' ) ) {
	/**
	 * Lava Social Buttons
	 * 
	 */
	function lava_sc_social_buttons( $atts ) {
		extract( shortcode_atts( array(
			'style' => 'a',
			'alignment' => 'left'
		), $atts ) );
		$classes = 'style-'. $style .' '. $alignment .'-align';
		$theme_mods = get_theme_mods();
		ob_start();
		
		?>
		<div class="lava-social-buttons <?php echo esc_attr( $classes ); ?>">
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
		<?php
		
		return ob_get_clean();
	}
}

add_shortcode( 'lava_spacer', 'lava_sc_spacer' );

if ( !function_exists( 'lava_sc_spacer' ) ) {
	/**
	 * Lava Social Buttons
	 * 
	 */
	function lava_sc_spacer( $atts ) {
		$style = '';
        if ( isset( $atts['height'] ) && $atts['height'] != 20 ) {
        	$style = ' style="height:'. esc_attr( $atts['height'] ) .'px;"';
        }
        return '<div class="lava-spacer"'. $style .'></div>';
	}
}

add_shortcode( 'lava_button', 'lava_sc_button' );

if ( !function_exists( 'lava_sc_button' ) ) {
	/**
	 * Lava Button
	 * 
	 */
	function lava_sc_button( $atts ) {

		extract( shortcode_atts( array(
			'title' => '',
			'text' => esc_html__( 'Button', 'lava' ),
			'url' => '#',
			'new_window' => '',
			'style' => 'flat',
			'size' => 'medium',
			'width' => '',
			'text_color' => '',
			'button_color' => '',
			'hover_text_color' => '',
			'hover_button_color' => '',
			'border_color' => '',
			'icon' => '',
			'align' => 'left',
			'id' => '',
			'classes' => '',
			'onclick' => '',
		), $atts ) );

		// button attributess
		$button_attrs = $button_style = $button_hover_style = '';
		$button_unique_class = 'lava-button-'. uniqid();
		$attributes = array();

		$button_style_class = !empty( $style ) ? 'lava-button-'. $style : 'lava-button-flat';

		if ( empty( $classes ) ) {
			$attributes['class'] = esc_attr( $button_style_class );
		} else {
			$attributes['class'] = esc_attr( $button_style_class .' '. trim( $classes ) );
		}

		if ( !empty( $size ) && 'medium' != $size ) {
			$attributes['class'] .= ' lava-button-'. $size;
		}

		$attributes['class'] .= ' '. $button_unique_class;

		if ( !empty( $url ) ) {
			$attributes['href'] = esc_url( $url );
		}

		if ( !empty( $id ) ) {
			$attributes['id'] = esc_attr( $id );
		}

		if ( !empty( $title ) ) {
			$attributes['title'] = esc_attr( $title );
		}

		if ( !empty( $onclick ) ) {
			$attributes['onclick'] = esc_attr( $onclick );
		}

		if ( $new_window ) {
			$attributes['target'] = '_blank';
		}

		if ( !empty( $attributes ) ) {
			foreach ( $attributes as $key => $value ) {
				$button_attrs .= ' '. esc_attr( $key ) .'="'. $value .'"';
			}
		}

		if ( !empty( $width ) ) {
			$button_style .= 'width:'. esc_attr( $width ) .';';
		}

		if ( !empty( $text_color ) ) {
			$button_style .= 'color:'. esc_attr( $text_color ) .'!important;';
		}

		if ( !empty( $button_color ) ) {
			$button_style .= 'background-color:'. esc_attr( $button_color ) .'!important;';
		}

		if ( !empty( $border_color ) ) {
			if ( 'linetop' == $style ) {
				$button_style .= 'border-top-color:'. esc_attr( $border_color ) .'!important;';
				$button_hover_style .= 'border-bottom-color:'. esc_attr( $border_color ) .'!important;';
			} else {
				$button_style .= 'border-color:'. esc_attr( $border_color ) .'!important;';
			}
		}

		if ( !empty( $button_style ) ) {
			$button_style = '.'. $button_unique_class .'{'. $button_style .'!important}';
		}

		if ( !empty( $hover_text_color ) ) {
			$button_hover_style .= 'color:'. esc_attr( $hover_text_color ) .'!important;';
		}

		if ( !empty( $hover_button_color ) ) {
			$button_hover_style .= 'background-color:'. esc_attr( $hover_button_color ) .'!important;';
		}

		if ( !empty( $button_hover_style ) ) {
			$button_hover_style = '.'. $button_unique_class .':hover,.'. $button_unique_class .':active{'. $button_hover_style .'}';
		}

		// button icon
		$icon_html = '';

		if ( !empty( $icon ) ) {
			if ( strpos( $icon, 'lava-icon-' ) !== false ) {
				$icon_html .= '<span><i class="' . esc_attr( $icon ) . '"></i></span>';
			} else {
				$icon_html .= '<span><i class="material-icons">'. $icon .'</i></span>';
			}
		}

		$button_output = '';
		
		if ( !empty( $button_style ) || !empty( $button_hover_style ) ) {
			$button_output .= '<style type="text/css">'. $button_style . $button_hover_style .'</style>';
		}

		$button_output .= '<a'. $button_attrs .'>'. $icon_html . esc_html( $text ) .'</a>';

		if ( !empty( $align ) && $align != 'inline' ) {
			$button_output = '<div class="lava-button-wrapper '. esc_attr( $align ) .'-align">'. $button_output .'</div>';
		}

		return $button_output;
	}
}