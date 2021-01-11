<?php
/* =============================================================================
   Helper Functions
   ============================================================================= */
if ( !function_exists( 'lava_social_populate' ) ) {

	function lava_social_populate() {
		$social_list = array();
		
		if ( ( $facebook_url = Lava_Util::get_option( 'sm_facebook' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-facebook',
				'class' => 's-facebook',
				'url'	=> $facebook_url,
				'title'	=> 'Facebook'
			);
		}

		if ( ( $twitter_url = Lava_Util::get_option( 'sm_twitter' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-twitter',
				'class' => 's-twitter',
				'url'	=> $twitter_url,
				'title'	=> 'Twitter'
			);
		}

		if ( ( $googleplus_url = Lava_Util::get_option( 'sm_googleplus' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-gplus',
				'class' => 's-google-plus',
				'url'	=> $googleplus_url,
				'title'	=> 'Google plus'
			);
		}

		if ( ( $pinterest_url = Lava_Util::get_option( 'sm_pinterest' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-pinterest',
				'class' => 's-pinterest',
				'url'	=> $pinterest_url,
				'title'	=> 'Pinterest'
			);
		}

		if ( ( $linkedin_url = Lava_Util::get_option( 'sm_linkedin' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-linkedin',
				'class' => 's-linkedin',
				'url'	=> $linkedin_url,
				'title'	=> 'Linkedin'
			);
		}

		if ( ( $instagram_url = Lava_Util::get_option( 'sm_instagram' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-instagram',
				'class' => 's-instagram',
				'url'	=> $instagram_url,
				'title'	=> 'Instagram'
			);
		}

		if ( ( $flickr_url = Lava_Util::get_option( 'sm_flickr' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-flickr',
				'class' => 's-flickr',
				'url'	=> $flickr_url,
				'title'	=> 'Flickr'
			);
		}
		
		if ( ( $behance_url = Lava_Util::get_option( 'sm_behance' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-behance',
				'class' => 's-behance',
				'url'	=> $behance_url,
				'title'	=> 'Behance'
			);
		}
		
		if ( ( $delicious_url = Lava_Util::get_option( 'sm_delicious' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-delicious',
				'class' => 's-delicious',
				'url'	=> $delicious_url,
				'title'	=> 'Delicious'
			);
		}
		
		if ( ( $dribbble_url = Lava_Util::get_option( 'sm_dribbble' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-dribbble',
				'class' => 's-dribbble',
				'url'	=> $dribbble_url,
				'title'	=> 'Dribbble'
			);
		}

		
		if ( ( $reddit_url = Lava_Util::get_option( 'sm_reddit' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-reddit',
				'class' => 's-reddit',
				'url'	=> $reddit_url,
				'title'	=> 'Reddit'
			);
		}
		
		if ( ( $rss_url = Lava_Util::get_option( 'sm_rss' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-rss',
				'class' => 's-rss',
				'url'	=> $rss_url,
				'title'	=> 'RSS'
			);
		}
		
		if ( ( $soundcloud_url = Lava_Util::get_option( 'sm_soundcloud' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-soundcloud',
				'class' => 's-soundcloud',
				'url'	=> $soundcloud_url,
				'title'	=> 'SoundCloud'
			);
		}
		
		if ( ( $skype_url = Lava_Util::get_option( 'sm_skype' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-skype',
				'class' => 's-skype',
				'url'	=> $skype_url,
				'title'	=> 'Skype'
			);
		}

		if ( ( $stumbleupon_url = Lava_Util::get_option( 'sm_stumbleupon' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-stumbleupon',
				'class' => 's-stumbleupon',
				'url'	=> $stumbleupon_url,
				'title'	=> 'StumbleUpon'
			);
		}
		
		if ( ( $tumblr_url = Lava_Util::get_option( 'sm_tumblr' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-tumblr',
				'class' => 's-tumblr',
				'url'	=> $tumblr_url,
				'title'	=> 'Tumblr'
			);
		}
		
		if ( ( $vimeo_url = Lava_Util::get_option( 'sm_vimeo' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-vimeo',
				'class' => 's-vimeo',
				'url'	=> $vimeo_url,
				'title'	=> 'Vimeo'
			);
		}
		
		if ( ( $vine_url = Lava_Util::get_option( 'sm_vine' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-vine',
				'class' => 's-vine',
				'url'	=> $vine_url,
				'title'	=> 'Vine'
			);
		}
		
		if ( ( $vk_url = Lava_Util::get_option( 'sm_vk' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-vk',
				'class' => 's-vk',
				'url'	=> $vk_url,
				'title'	=> 'VK'
			);
		}
		
		if ( ( $wordpress_url = Lava_Util::get_option( 'sm_wordpress' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-wordpress',
				'class' => 's-wordpress',
				'url'	=> $wordpress_url,
				'title'	=> 'WordPress'
			);
		}

		if ( ( $youtube_url = Lava_Util::get_option( 'sm_youtube' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-youtube-play',
				'class' => 's-youtube',
				'url'	=> $youtube_url,
				'title'	=> 'Youtube'
			);
		}

		if ( ( $weibo_url = Lava_Util::get_option( 'sm_weibo' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-weibo',
				'class' => 's-weibo',
				'url'	=> $weibo_url,
				'title'	=> 'Weibo'
			);
		}

		if ( ( $weichat_url = Lava_Util::get_option( 'sm_weichat' ) ) ) {
			$social_list[] = array( 
				'icon'	=> 'lava-icon-weichat',
				'class' => 's-weichat',
				'url'	=> $weichat_url,
				'title'	=> 'Weichat'
			);
		}

		return $social_list;
	}
}

// output social links
if ( !function_exists( 'lava_social_icons' ) ) {
	function lava_social_icons( $class = '' ) {
		echo '<div class="'. esc_attr( $class ) . '">';
			echo '<div class="social-list">';
			$social_list = lava_social_populate();
			foreach( $social_list as $soc ) {
				echo '<a href="' . esc_url( $soc['url'] ) . '" class="' . esc_attr( $soc['class'] ) . '" title="' . esc_attr( $soc['title'] ) . '" target="_blank"><i class="' . esc_attr( $soc['icon'] ) . '"></i></a>';
			}
			echo '</div>';
		echo '</div>';
	}
}

if ( !function_exists( 'lava_main_menu' ) ) {
	function lava_main_menu() {
		wp_nav_menu( array(
			'theme_location' => 'main',
			'container' => '',
			'menu_class' => 'nav-menu pre-compress',
			'depth' => 4,
			'walker' => new Lava_Walker_Main_Menu(),
			'fallback_cb' => 'lava_nav_menu_fb'
		) );
	}
}

if ( !function_exists( 'lava_fullscreen_menu' ) ) {
	function lava_fullscreen_menu() {
		wp_nav_menu( array(
			'theme_location' => 'fullscreen',
			'container' => '',
			'menu_class' => 'fullscreen-menu',
			'depth' => 4,
			'fallback_cb' => 'lava_fullscreen_menu_fb'
		) );
	}
}

if ( !function_exists( 'lava_left_menu' ) ) {
	function lava_left_menu() {
		wp_nav_menu( array(
			'theme_location' => 'left',
			'container' => '',
			'menu_class' => 'left-menu nav-menu',
			'depth' => 4,
			'walker' => new Lava_Walker_Main_Menu(),
			'fallback_cb' => 'lava_left_menu_fb'
		) );
	}
}

if ( !function_exists( 'lava_right_menu' ) ) {
	function lava_right_menu() {
		wp_nav_menu( array(
			'theme_location' => 'right',
			'container' => '',
			'menu_class' => 'right-menu nav-menu',
			'depth' => 4,
			'walker' => new Lava_Walker_Main_Menu(),
			'fallback_cb' => 'lava_right_menu_fb'
		) );
	}
}

if ( !function_exists( 'lava_nav_menu_fb' ) ) {
	function lava_nav_menu_fb() {
	    echo '<ul class="nav-menu">';
	    echo '<li class="menu-item-first"><a href="'. esc_url( network_admin_url( 'nav-menus.php' ) ) .'?action=locations">'. esc_html__( 'Click here - to select or create a menu', 'lava' ) .'</a></li>';
	    echo '</ul>';
	}
}

if ( !function_exists( 'lava_fullscreen_menu_fb' ) ) {
	function lava_fullscreen_menu_fb() {
	    echo '<ul class="fullscreen-menu">';
	    echo '<li class="menu-item-first"><a href="'. esc_url( network_admin_url( 'nav-menus.php' ) ) .'?action=locations">'. esc_html__( 'Click here - to select or create a menu', 'lava' ) .'</a></li>';
	    echo '</ul>';
	}
}

if ( !function_exists( 'lava_left_menu_fb' ) ) {
	function lava_left_menu_fb() {
	    echo '<ul class="left-menu">';
	    echo '<li class="menu-item-first"><a href="'. esc_url( network_admin_url( 'nav-menus.php' ) ) .'?action=locations">'. esc_html__( 'Click here - to select or create a menu', 'lava' ) .'</a></li>';
	    echo '</ul>';
	}
}

if ( !function_exists( 'lava_right_menu_fb' ) ) {
	function lava_right_menu_fb() {
	    echo '<ul class="right-menu">';
	    echo '<li class="menu-item-first"><a href="'. esc_url( network_admin_url( 'nav-menus.php' ) ) .'?action=locations">'. esc_html__( 'Click here - to select or create a menu', 'lava' ) .'</a></li>';
	    echo '</ul>';
	}
}

if ( !function_exists( 'lava_link_pages' ) ) {
	function lava_link_pages() {
		global $page, $numpages, $multipage;
		
		$next = is_rtl() ? '<i class="material-icons">arrow_back</i>' : '<i class="material-icons">arrow_forward</i>';
		$prev = is_rtl() ? '<i class="material-icons">arrow_forward</i>' : '<i class="material-icons">arrow_back</i>';

        if ( $multipage ) : ?>
			<div class="post-pagination cf">
				<div class="page-num"><?php printf( '<span>%1$u</span> / %2$u', $page, $numpages ); ?></div>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-nav">',
						'after' => '</div>',
						'next_or_number' => 'next',
						'nextpagelink' => $next,
						'previouspagelink' => $prev,
						'echo' => 1
					)); ?>
			</div><?php
        endif;
	}
}

if ( !function_exists( 'lava_get_attachment' ) ) {
	function lava_get_attachment( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		
		if ( $attachment ) {
			return array( 
				'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'href' => get_permalink( $attachment->ID ),
				'src' => $attachment->guid,
				'title' => $attachment->post_title
			 );
		} 
		return false;
	}
}

if ( !function_exists( 'lava_image_sizes' ) ) {
	function lava_image_sizes( $size = '' ) {
	    global $_wp_additional_image_sizes;
	    $sizes = array();
	    $image_sizes = get_intermediate_image_sizes();
	    // Create the full array with sizes and crop info
	    foreach( $image_sizes as $_size ) {
	        
	        if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $sizes[$_size]['width'] = get_option( $_size . '_size_w' );
                $sizes[$_size]['height'] = get_option( $_size . '_size_h' );
                $sizes[$_size]['crop'] = (bool) get_option( $_size . '_crop' );

	        } elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {
              	$sizes[$_size] = array( 
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' =>  $_wp_additional_image_sizes[$_size]['crop']
	            );
	        }
	    }
	    // Get only 1 size if found
	    if ( $size ) {
	        if ( isset( $sizes[$size] ) ) return $sizes[$size];
	        else return false;
	    }
	    return $sizes;
	}
}

if ( !function_exists( 'lava_button' ) ) {
	function lava_button( $button_text = '', $button_link = '', $button_classes = array() ) {
		echo '<a href="'. esc_url( $button_link ) .'" class="'. esc_attr( implode( ' ', $button_classes ) ) .'">'. esc_html( $button_text ) .'</a>';
	}
}

if ( !function_exists( 'lava_title_post_format' ) ) {
	function lava_title_post_format() {
		switch( get_post_format() ) {
			case 'gallery': esc_html_e( 'Gallery', 'lava' ); break;
			case 'video': esc_html_e( 'Video', 'lava' ); break;
			case 'audio': esc_html_e( 'Audio', 'lava' ); break;
		}
	}
}

if ( !function_exists( 'lava_get_background_style' ) ) {
	function lava_get_background_style( $post_id = '' ) {
		global $post;
		$style = $img_url = '';

		if ( empty( $post_id ) ) {
			$post_id = $post->ID;
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			$img_url = $img[0];
		}

		if ( !empty( $img_url ) ) {
			$style = ' style="background-image:url(' . esc_url( $img_url ) . ');"';
		}

		return $style;
	}
}

if ( !function_exists( 'lava_get_background_image_style' ) ) {
	function lava_get_background_image_style( $image_id = '' ) {
		if ( empty( $image_id ) ) {
			return '';
		}

		$image_url = wp_get_attachment_url( $image_id );
		$image_style = '';

		if ( !empty( $image_url ) ) {
			$image_style = ' style="background-image:url('. esc_url( $image_url ) .');"';
		}

		return $image_style;
	}
}

if ( !function_exists( 'lava_get_post_title' ) ) {
	function lava_get_post_title() {
		return '<h3 class="post-title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
	}
}

if ( !function_exists( 'lava_get_post_excerpt' ) ) {
	function lava_get_post_excerpt( $limit = 200 ) {
		$excerpt = '';
		$limit = intval( $limit );

		if ( $limit == 0 ) {
			return '';
		}

		if ( has_excerpt() ) {
		    $excerpt = get_the_excerpt();
		} else {
		    $content = get_the_content();
		    $content = strip_shortcodes( $content );
		    $excerpt = apply_filters( 'the_content', $content );
		    $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
		}
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = strip_tags( $excerpt );

		if ( strlen( $excerpt ) > $limit ) {
		    $excerpt = substr( $excerpt, 0, $limit );
		    $excerpt .= '...';
		}

		if ( !empty( $excerpt ) ) {
			return '<div class="post-excerpt">'. $excerpt .'</div>';
		}
		return '';
	}
}

if ( !function_exists( 'lava_get_post_meta' ) ) {
	function lava_get_post_meta( $post_meta = array() ) {
		$output = '';

		if ( !empty( $post_meta ) ) {

			if ( in_array( 'author', $post_meta ) ) {
				$output .= '<li class="meta-author"><a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ) .'"><i class="material-icons">person</i>'. get_the_author() .'</a></li>';
			}

			if ( in_array( 'date', $post_meta ) ) {
				$archive_year  = get_the_time('Y');
				$archive_month = get_the_time('m');
				$archive_day   = get_the_time('d');
				$output .= '<li class="meta-date"><a href="'. esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) .'"><i class="material-icons">date_range</i>'. date_i18n( get_option( 'date_format' ),  strtotime( get_the_time( "Y-m-d" ) ) ) .'</a></li>';
			}

			if ( in_array( 'cats', $post_meta ) ) {
				$output .= '<li class="meta-cats"><i class="material-icons">local_offer</i>' . get_the_category_list( ', ' ) . '</li>';
			}

			if ( in_array( 'comment', $post_meta ) ) {
				$output .= '<li class="meta-comments"><a href="' . esc_url( get_permalink() ) . '#comments"><i class="material-icons">mode_comment</i>' . get_comments_number() . '</a></li>';
			}
		}
		return !empty( $output ) ? '<ul class="post-meta">'. $output .'</ul>' : '';
	}
}

if ( !function_exists( 'lava_get_post_thumb' ) ) {
	function lava_get_post_thumb( $size = 'thumbnail' ) {
		$output = '';
		
		if ( has_post_thumbnail() ) {
			$output .= '<div class="post-thumb">';
				$output .= '<a href="' . esc_url( get_the_permalink() ) . '">';
					$output .= get_the_post_thumbnail( get_the_ID(), $size );
					$output .= '<div class="lava-image-item-overlay"></div>';
				$output .= '</a>';
			$output .= '</div>';
		}
		return $output;
	}
}

if ( !function_exists( 'lava_get_column_class' ) ) {
	function lava_get_column_class( $column_size = 3 ) {

	    $style_class = 'col x12';

	    $column_styles = array(
	        1 => 'col x12',
	        2 => 'col x12 s6',
	        3 => 'col x12 s6 m4',
	        4 => 'col x12 s6 l3',
	        6 => 'col x12 s6 m2',
	    );

	    if ( array_key_exists( $column_size, $column_styles ) && !empty( $column_styles[$column_size] ) ) {
	        $style_class = $column_styles[$column_size];
	    }

	    return $style_class;
	}
}

if ( !function_exists( 'lava_get_archive_title' ) ) {
	/**
	 * File: wp-includes/general-template.php
	 */
	function lava_get_archive_title() {
		$title = '';
	    if ( is_category() ) {
	        /* translators: Category archive title. 1: Category name */
	        $title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
	        /* translators: Tag archive title. 1: Tag name */
	        $title = single_tag_title( '', false );
	    } elseif ( is_author() ) {
	        /* translators: Author archive title. 1: Author name */
	        $title = get_the_author();
	    } elseif ( is_year() ) {
	        /* translators: Yearly archive title. 1: Year */
	        $title = sprintf( esc_html__( 'Year: %s', 'lava' ), get_the_date( _x( 'Y', 'yearly archives date format', 'lava' ) ) );
	    } elseif ( is_month() ) {
	        /* translators: Monthly archive title. 1: Month name and year */
	        $title = sprintf( esc_html__( 'Month: %s', 'lava' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'lava' ) ) );
	    } elseif ( is_day() ) {
	        /* translators: Daily archive title. 1: Date */
	        $title = sprintf( esc_html__( 'Day: %s', 'lava' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'lava' ) ) );
	    } elseif ( is_tax( 'post_format' ) ) {
	        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
	            $title = _x( 'Asides', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
	            $title = _x( 'Galleries', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
	            $title = _x( 'Images', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
	            $title = _x( 'Videos', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
	            $title = _x( 'Quotes', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
	            $title = _x( 'Links', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
	            $title = _x( 'Statuses', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
	            $title = _x( 'Audio', 'post format archive title', 'lava' );
	        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
	            $title = _x( 'Chats', 'post format archive title', 'lava' );
	        }
	    } elseif ( is_post_type_archive() ) {
	        $title = post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	    	if ( is_tax( 'product_cat' ) || is_tax( 'lava_offer_category' ) ) {
	    		$title = single_term_title( '', false );
	    	} else {
		        $tax = get_taxonomy( get_queried_object()->taxonomy );
		        /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
		        $title = sprintf( '%1$s: %2$s', $tax->labels->singular_name, single_term_title( '', false ) );
	    	}
    	} else {
	        $title = esc_html__( 'Archives', 'lava' );
	    }
	    return $title;
	}
}

// hb booking
if ( !function_exists( 'lava_hb_archive_title' ) ) {
	function lava_hb_archive_title() {
		$title = Lava_Util::get_option( 'hb_archive_title', '' );
		if ( !empty( $title ) ) {
			echo esc_html( $title );
			return;
		}
		post_type_archive_title();
	}
}

if ( !function_exists( 'lava_hb_room_title' ) ) {
	/**
	 * Print room title
	 * @param  int  $post_id        post ID
	 * @param  boolean $one_line    whether to show title in one line
	 * @param  boolean $raw_title   whether to print title text without html
	 * @param  string  $title_class title class
	 */
	function lava_hb_room_title( $post_id = null, $one_line = false, $raw_title = false, $title_class = 'title' ) {
		
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$title = '';
		$subtitle = get_post_meta( $post_id, '_lava_room_type_title', true );

		if ( $raw_title ) {
			$title .= get_the_title( $post_id ) .' '. $subtitle;
		} else {
			$title = '<h3 class="'. esc_attr( $title_class ) .'"><a href="'. esc_url( get_the_permalink( $post_id ) ) .'">';
			$title .= get_the_title( $post_id );

			if ( !empty( $subtitle ) ) {
				if ( $one_line ) {
					$title .= ' '. $subtitle;
				} else {
					$title .= '<span class="subtitle">'. $subtitle .'</span>';
				}
			}

			$title .= '</a></h3>';
		}

		echo wp_kses_post( $title );
	}
}

if ( !function_exists( 'lava_hb_room_excerpt' ) ) {
	function lava_hb_room_excerpt( $post_id = null, $limit = 200  ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$excerpt = get_post_meta( $post_id, '_lava_room_excerpt', true );

		if ( !empty( $excerpt ) ) {
			$limit = absint( $limit );

			if ( strlen( $excerpt ) > $limit ) {
				$excerpt = substr( $excerpt, 0, $limit );
				$excerpt .= '...';
			}

			echo '<div class="excerpt">'. wp_kses_post( $excerpt ) .'</div>';
		}
	}
}

if ( !function_exists( 'lava_hb_additional_info' ) ) {
	function lava_hb_additional_info( $post_id = null, $limit = 200 ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$output = get_post_meta( $post_id, '_hb_room_addition_information', true );
		
		if ( !empty( $output ) ) {
			$limit = absint( $limit );
			
			if ( strlen( $output ) > $limit ) {
				$output = substr( $output, 0, $limit );
				$output .= '...';
			}
			echo wp_kses_post( $output );
		}
	}
}

if ( !function_exists( 'lava_hb_dropdown_titles' ) ) {
	function lava_hb_dropdown_titles( $args = array() ) {
		$args              = wp_parse_args(
			$args, array(
				'name'              => 'title',
				'selected'          => '',
				'show_option_none'  => esc_html__( 'Title', 'lava' ),
				'option_none_value' => - 1,
				'echo'              => true
			)
		);
		$name              = '';
		$selected          = '';
		$echo              = false;
		$show_option_none  = false;
		$option_none_value = - 1;
		extract( $args );
		$titles = hb_get_common_titles();
		$output = '<select name="' . $name . '">';
		if ( $show_option_none ) {
			$output .= sprintf( '<option value="%s">%s</option>', $option_none_value, $show_option_none );
		}
		if ( $titles )
			foreach ( $titles as $slug => $title ) {
				$output .= sprintf( '<option value="%s"%s>%s</option>', $slug, $slug == $selected ? ' selected="selected"' : '', $title );
			}
		$output .= '</select>';
		if ( $echo ) {
			echo sprintf( '%s', $output );
		}
		return $output;
	}
}

if ( !function_exists( 'lava_file_get_contents' ) ) {
	/**
	 * Get file content
	 * 
	 */
	function lava_file_get_contents( $path ) {
		ob_start();
		include( $path );
		return ob_get_clean();
	}
}

if ( !function_exists( 'lava_so_widget_title' ) ) {
	/**
	 * Output widget title
	 */
	function lava_so_widget_title( $instance, $args ) {
		$title = !empty( $instance['title'] ) ? (array) $instance['title'] : '';

		if ( !empty( $title['text'] ) ) {

			$title_style = $title_class = '';
		
			if ( !empty( $title['align'] ) ) {
				$title_class .= ' '. $title['align'] .'-align';
			}
		
			if ( !empty( $title['color'] ) ) {
				$title_style .= ' style="color:'. esc_attr( $title['color'] ) .'"';
			}
		
			echo '<div class="title-wrapper'. esc_attr( $title_class ) .'"'. $title_style .'>'. $args['before_title'] . esc_html( $title['text'] ) . $args['after_title'] .'</div>';
		}
	}
}