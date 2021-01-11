<?php

// remove widget title if empty
add_filter( 'widget_title', 'lava_widget_empty_title' );

function lava_widget_empty_title( $title = '' ) {
	if ( empty( $title ) || $title == '!' ) {
		return '';
	}
	return $title;
}

// filter widget tag cloud args
add_filter( 'widget_tag_cloud_args', 'lava_tag_cloud_args' );

if ( !function_exists( 'lava_tag_cloud_args' ) ) {
	function lava_tag_cloud_args( $args ) {
		$new_args = array(
			'smallest' => 13,
			'largest' => 13,
			'number' => 25,
			'orderby' => 'name',
			'unit' => 'px'
			);
		$args = wp_parse_args( $args, $new_args );
		return $args;
	}
}

// add wrapper to embeds
add_filter( 'embed_oembed_html', 'lava_embed_oembed_html', 99, 4 );

if ( !function_exists( 'lava_embed_oembed_html' ) ) {
	function lava_embed_oembed_html( $html, $url, $attr, $post_id ) {
		return '<div class="post-media media-embed">'. $html .'</div>';
	}
}
// add wrapper to audio shortcodes
add_filter( 'wp_audio_shortcode', 'lava_audio_shortcode' );

if ( !function_exists( 'lava_audio_shortcode' ) ) {
	function lava_audio_shortcode( $html ) {
		return '<div class="post-media">'. $html .'</div>';
	}
}

// add wrapper to audio shortcodes
add_filter( 'wp_video_shortcode', 'lava_video_shortcode' );

if ( !function_exists( 'lava_video_shortcode' ) ) {
	function lava_video_shortcode( $html ) {
		return '<div class="post-media">'. $html .'</div>';
	}
}

// add page break button to mce toolbar
add_filter( 'mce_buttons', 'lava_page_break_button', 1, 2 );

if ( !function_exists( 'lava_page_break_button' ) ) {
	function lava_page_break_button( $buttons, $id ) {
	    // only add this for content editor
	    if ( 'content' != $id )
	        return $buttons;
	
	    // add next page after more tag button
	    array_splice( $buttons, 13, 0, 'wp_page' );

	    return $buttons;
	}
}


add_filter( 'wp_nav_menu_items', 'lava_add_nav_menu_items', 10, 2 );

if ( !function_exists( 'lava_add_nav_menu_items' ) ) {
	function lava_add_nav_menu_items( $items, $args ) {
		if ( $args->theme_location == 'main' || $args->theme_location == 'right' ) {
			ob_start();
			if ( Lava_Util::get_option( 'nav_show_search', false ) ) :
				?>
				<li class="menu-item-search">
					<a id="nav-search" href="javascript:void(0)" role="button"><i class="material-icons">search</i></a>
					<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="text" class="sf-input input-field-small" name="s" value="<?php echo get_search_query() ?>" placeholder="<?php echo esc_attr_x( 'Search..', 'text input', 'lava' ); ?>">
						<button type="submit" class="sf-submit"><i class="material-icons">search</i></button>
					</form>
				</li>
			<?php endif; ?>
			<?php if ( $args->theme_location == 'main' ) : ?>
				<li class="menu-items-container menu-item-has-children">
					<a class="menu-item-btn-more" href="javascript:void(0)" role="button"><span class="menu-text"><?php esc_html_e( 'More', 'lava' ); ?></span><span class="menu-caret"><i class="material-icons">expand_more</i></span></a>
					<ul class="sub-menu"></ul>
				</li>
			<?php endif; ?>
			<?php $items .= ob_get_clean();
		}
		return $items;
	}
}

if ( !function_exists( 'lava_nav_cta_button' ) ) {
	function lava_nav_cta_button() {
		$button_text = Lava_Util::get_option( 'nav_button_text', esc_html__( 'Book Now', 'lava' ) );
		$button_url = Lava_Util::get_option( 'nav_button_url', '#' );
		?>
		<div class="nav-btn-cta">
			<a href="<?php echo esc_url( $button_url ); ?>" class="btn-primary"><?php echo esc_html( $button_text ); ?></a>
		</div>
		<?php
	}
}

add_filter( 'walker_nav_menu_start_el', 'lava_add_back_button_to_fullscreen_menu', 10, 4 );

if ( !function_exists( 'lava_add_back_button_to_fullscreen_menu' ) ) {
	/**
	 * Add back button for sub menus
	 *
	 * @param string   $item_output The menu item's starting HTML output.
	 * @param WP_Post  $item        Menu item data object.
	 * @param int      $depth       Depth of menu item. Used for padding.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	function lava_add_back_button_to_fullscreen_menu( $item_output, $item, $depth, $args ) {
		if ( 'fullscreen' === $args->theme_location ) {
			foreach ( $item->classes as $value ) {
				if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
					$item_output .= '<span class="menu-back"><i class="material-icons">arrow_back</i></span>';
				}
			}
		}
		return $item_output;
	}
}

// gallery shortcode

if ( !class_exists( 'Jetpack' ) || !Jetpack::is_module_active( 'tiled-gallery' ) ) {
	/**
	 * Use jetpack gallery instead of default gallery
	 */
	add_filter( 'post_gallery', 'lava_gallery_shortcode', 10, 3 );
}

if ( ! function_exists( 'lava_gallery_shortcode' ) ) {
	function lava_gallery_shortcode( $output = '', $atts, $instance ) {
		global $post;

		wp_enqueue_style( 'slick' );
		wp_enqueue_script( 'lava-sliders' );

		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
			'id'             => $post ? $post->ID : 0,
			'itemtag'        => $html5 ? 'figure'     : 'dl',
			'icontag'        => $html5 ? 'div'        : 'dt',
			'captiontag'     => $html5 ? 'figcaption' : 'dd',
			'columns'        => 3,
			'size'           => 'thumbnail',
			'include'        => '',
			'exclude'        => '',
			'link'           => '',
			'ids'            => '',
			'style'          => 'wordpress',
			'fill_mode'      => 'contain',
			'autoplay'       => false,
			'autoplay_speed' => '',
			'lazyload'       => '',
		), $atts, 'gallery' );

		$id = intval( $atts['id'] );

		$post_format = get_post_format( $id );
		$post_layout = Lava()->get_layout();
		$post_style = Lava()->get_post_style();
		$img_ids = array();

		if ( !is_array( $atts['ids'] ) ) {
			$img_ids = explode( ',', $atts['ids'] );
		}
		
		if ( empty( $img_ids ) ) {
			return $output;
		}

		$img_count = count( $img_ids );

		// determine the image size
		$size_medium = $atts['size'];

		if ( $atts['style'] != 'wordpress' ) {

			$size_small = 'lava_thumb_x_small';
			$gallery_thumb = '';

			// gallery settings
			$temp_settings = '';
			$slider_settings = '';

			if ( $atts['autoplay'] === 'true' ) {
				$temp_settings .= '"autoplay":true,';
			}

			if ( $atts['style'] == 'bullet' ) {
				$temp_settings .= '"dots":true,';
			}

			if ( !empty( $atts['lazyload'] ) ) {
				$temp_settings .= '"lazyLoad":"'. esc_attr( $atts['lazyload'] ) .'",';
			}

			$autoplay_speed = absint( $atts['autoplay_speed'] );
			if ( $autoplay_speed > 0 ) {
				$temp_settings .= '"autoplaySpeed":' . esc_attr( $autoplay_speed*1000 ) . ',';
			}

			if ( is_rtl() ) {
				$temp_settings .= '"rtl":true';
			}

			if ( ! empty( $temp_settings ) ) {
				$slider_settings .= 'data-slick=\'{' . $temp_settings . '}\'';
				$slider_settings = str_replace( ',}', '}', $slider_settings );
			}

			// main gallery output
			$output .= '<div class="lava-gallery style-' . esc_attr( $atts['style'] ) . '">';
			$output .= '<div class="main-slider slick-slider ' . esc_attr( $atts['fill_mode'] ) . '" ' . $slider_settings . '>';

			foreach ( $img_ids as $img_id ) {
				$img_id = intval( $img_id );
				$img_attachment = lava_get_attachment( $img_id );
				
				if ( $img_attachment ) {
					$img_content = '';
					$size_small_src = wp_get_attachment_image_src( $img_id, $size_small );
					$size_medium_src = wp_get_attachment_image_src( $img_id, $size_medium );
					$size_full_src =  $img_attachment['src'];
					$img_caption = $img_attachment['caption'];
					$img_desc = $img_attachment['description'];
					$img_alt = $img_attachment['alt'];
					$image_src_attr = !empty( $atts['lazyload'] ) ? 'data-lazy' : 'src';
					$output .= '<div class="slick-slide">';
					$output .= "<a class='swipebox' ref='gallery-{$instance}' href='" . esc_url( $size_full_src ) . "'>";
					$output .= '<img width="' . esc_attr( $size_medium_src[1] ) . '" height="' . esc_attr( $size_medium_src[2] ) . '" ' . esc_html( $image_src_attr ) . '="' . esc_url( $size_medium_src[0] ) . '" alt="' . esc_attr( $img_alt ) . '"><span class="spinner"></span>';
					$output .= '</a>';

					if ( !empty( $img_caption ) ) {
						$img_content .= '<div class="slide-caption">' . esc_html( $img_caption ) . '</div>';
					}

					if ( !empty( $img_desc ) ) {
						$img_content .= '<div class="slide-description">' . esc_html( $img_desc ) . '</div>';
					}

					if ( !empty( $img_content ) ) {
						$output .= "<div class='slide-content'>" . $img_content . "</div>";
					}

					if ( $atts['style'] == 'thumbnail' ) {
						$gallery_thumb .= '<div class="slick-slide"><img width="100" height="100" src="' . esc_url( $size_small_src[0] ) . '" alt="' . esc_attr( $img_alt ) . '"></div>';
					}

					$output .= '</div>';
				}
			}
			$output .= '</div>';

			if ( $atts['style'] == 'thumbnail' ) {
				$output .= '<div class="thumb-slider slick-slider">' . $gallery_thumb . '</div>';
			}

			$output .= '</div>';

			return $output;
		}

		// WordPress default gallery

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}

		$columns = intval( $atts['columns'] );
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = '';

		/**
		 * Filters whether to print default gallery styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool $print Whether to print default gallery styles.
		 *                    Defaults to false if the theme supports HTML5 galleries.
		 *                    Otherwise, defaults to true.
		 */
		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
				/* see gallery_shortcode() in wp-includes/media.php */
			</style>\n\t\t";
		}

		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

		/**
		 * Filters the default gallery shortcode CSS styles.
		 *
		 * @since 2.5.0
		 *
		 * @param string $gallery_style Default CSS styles and opening HTML div container
		 *                              for the gallery shortcode output.
		 */
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				// $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
				$image_output = "<a class='swipebox' ref='gallery-{$instance}' href='" . wp_get_attachment_url( $id ) . "'> " . wp_get_attachment_image($id, $atts['size'], false, $attr ) . "</a>";
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				// $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
				$image_output = "<a class='swipebox' ref='gallery-{$instance}' href='" . wp_get_attachment_url( $id ) . "'> " . wp_get_attachment_image($id, $atts['size'], false, $attr ) . "</a>";
			} else {
				// $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
				$image_output = "<a class='swipebox' ref='gallery-{$instance}' href='" . wp_get_attachment_url( $id ) . "'> " . wp_get_attachment_image($id, $atts['size'], false, $attr ) . "</a>";
			}
			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}
			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon {$orientation}'>
					$image_output
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
				$output .= '<br style="clear: both" />';
			}
		}

		if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
			$output .= "
				<br style='clear: both' />";
		}

		$output .= "
			</div>\n";

		return $output;
	}
}

if ( !function_exists( 'lava_add_image_sizes_settings' ) ) {
	/**
	 * Add additional size to gallery settings
	 * @param  array $sizes image sizes
	 * @return array        image sizes
	 */
	function lava_add_image_sizes_settings( $sizes ) {
		$custom_sizes = array(
		    'lava_thumb_x_small' => 'lava_thumb_x_small [ 100x100 ]',
		    'lava_thumb_small' => 'lava_thumb_small [ 540x360 ]',
		    'lava_thumb_gallery' => 'lava_thumb_gallery [ 480x400 ]',
		    'lava_thumb_medium_s' => 'lava_thumb_medium_s [ 640x640 ]',
		    'lava_thumb_medium' => 'lava_thumb_medium [ 960x600 ]',
		    'lava_thumb_large' => 'lava_thumb_large [ 1200x675 ]',
		);
		$sizes = array_merge( $sizes, $custom_sizes );
       	return $sizes;
	}
}
add_filter( 'image_size_names_choose', 'lava_add_image_sizes_settings' );

// remove unwanted tags from the content
if ( !function_exists( 'lava_shortcode_formatter' ) ) {
	function lava_shortcode_formatter( $content ) {
	    $block = join( "|", array( "masterslider", "contact-form-7", "mc4wp_form" ) );
	    $rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]", $content );
	    $rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]", $rep );
	    return $rep;
	}
}
add_filter( 'the_content', 'lava_shortcode_formatter' );

// change offer post slug
if ( !function_exists( 'lava_change_offer_type_slug' ) ) {
    function lava_change_offer_type_slug( $args ) {
		$slug = Lava_Util::get_option( 'offer_type_slug', '' );

		if ( !empty( $slug ) ) {
			$args['rewrite'] = array( 'slug' => $slug, 'with_front' => true  );
		}

		return $args;
    }
}

// change offer taxonomy slug
if ( !function_exists( 'lava_change_offer_taxonomy_slug' ) ) {
    function lava_change_offer_taxonomy_slug( $args ) {
		$slug = Lava_Util::get_option( 'offer_tax_slug', '' );

		if ( !empty( $slug ) ) {
			$args['rewrite'] = array( 'slug' => $slug, 'with_front' => true  );
		}

		return $args;
    }
}

if ( class_exists( 'Lava_Custom_Post_Types' ) ) {
	add_filter( 'lava_filter_post_type_offer', 'lava_change_offer_type_slug' );
	add_filter( 'lava_filter_taxonomy_offer', 'lava_change_offer_taxonomy_slug' );
}

// change wp hotel booking room slug
if ( !function_exists( 'lava_change_room_type_slug' ) ) {
	function lava_change_room_type_slug( $args ) {
		$slug = Lava_Util::get_option( 'room_type_slug', '' );

		if ( !empty( $slug ) ) {
			$args['rewrite'] = array( 'slug' => $slug, 'with_front' => false, 'feeds' => true  );
		}

		return $args;
	}
}

// change wp hotel booking room taxonomy slug
if ( !function_exists( 'lava_change_room_taxonomy_slug' ) ) {
	function lava_change_room_taxonomy_slug( $args ) {
		$slug = Lava_Util::get_option( 'room_tax_slug', '' );

		if ( !empty( $slug ) ) {
			$args['rewrite'] = array( 'slug' => $slug );
		}

		return $args;	
	}
}

if ( class_exists( 'WP_Hotel_Booking' ) ) {
	add_filter( 'hotel_booking_register_post_type_room_arg', 'lava_change_room_type_slug' );
	add_filter( 'hotel_booking_register_tax_room_type_arg', 'lava_change_room_taxonomy_slug' );
}

// add custom skin to masterslider
if ( !function_exists( 'lava_masterslider_skins' ) ) {
	function lava_masterslider_skins( $slider_skins ) {
	    $slider_skins[] = array( 'class' => 'ms-skin-lava', 'label' => 'Lava' );
	    $slider_skins[] = array( 'class' => 'ms-skin-lava-2', 'label' => 'Lava-2' );
	    return $slider_skins;
	}
}
add_filter( 'masterslider_skins', 'lava_masterslider_skins' );

// disable masterslider auto update
add_filter( 'masterslider_disable_auto_update', '__return_true', 99 );

// do not load contact form 7 css
add_filter( 'wpcf7_load_css', '__return_false' );