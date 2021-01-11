<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Lava Page
 *
 * Helper class for generating page content
 */

final class Lava_Page {

	private static $_instance = null;
	private $id = 0;
	private $template;
	private $header = 'default';
	private $header_style = '';
	private $header_affix_style = '';
	private $header_shortcode = '';
	private $header_image_style = '';
	private $container;
	private $layout;
	private $title = '';
	private $thumb_size = 'full';
	private $sidebar_id = '';

	/**
	 * Main Lava_Page Instance.
	 *
	 * Ensures only one instance of Lava_Page is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @see Lava()
	 * @return Lava_Page - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 * @since 1.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lava' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * 
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lava' ), '1.0.0' );
	}

	function __construct() {
		$this->set_page();
	}

	public function set_page() {
		$this->id = get_the_ID();
		$this->id = !empty( $this->id ) ? $this->id : 0;
		$is_single = false;
		$use_custom_sidebar = false;
		$this->header_style = Lava_Util::get_option( 'header_style', '2' );
		
		// set header affix class
		$affix_style = Lava_Util::get_option( 'header_affix', false );

		if ( 'smart' === $affix_style ) {
			$this->header_affix_style = ' affix-smart';
		} elseif ( $affix_style ) {
			$this->header_affix_style = ' affix-always';
		}

		// set template name, page header, layout etc

	    if ( is_front_page() ) {
	    	// add your code
	    }

	    if ( lava_is_woocommerce_page() ) {
	    	$this->sidebar_id = 'wc-sidebar';

	    	if ( is_shop() ) {
	    		$this->id = get_option( 'woocommerce_shop_page_id' );
	    		$this->title = woocommerce_page_title( false );
	    		$is_single = true;
	    	}
	    	
	    	elseif ( is_product() ) {
	    		$this->layout = Lava_Util::get_option( 'wc_product_layout', 'sidebar-right' );
	    		$is_single = true;
	    	}

	    	elseif ( is_product_category() || is_product_tag() ) {
	    		$this->title = single_term_title( '', false );
	    	}

	    	else {
	    		$is_single = true;
	    	}

	    	if ( !$is_single ) {
	    		$this->header = Lava_Util::get_option( 'wc_header', 'default' );
	    		$this->layout = Lava_Util::get_option( 'wc_layout', 'full-width' );

	    		if ( 'default' == $this->header || 'image' == $this->header ) {
		    		$image_url = Lava_Util::get_option( 'wc_header_image', '' );
		    		if ( !empty( $image_url ) ) {
		    			$this->header_image_style = ' style="background-image:url('. esc_url( $image_url ) .');"';
		    		}
	    		} elseif ( 'slider' == $this->header ) {
	    			$this->header_shortcode = Lava_Util::get_option( 'wc_header_shortcode', '' );
	    		}
	    	} else {
	    		$use_custom_sidebar = true;
	    	}

	    } else if ( is_home() ) {
	    	$this->template = 'blog';
	    	$show_on_front = get_option( 'show_on_front' );
	    	
	    	if ( isset( $show_on_front ) && 'posts' == $show_on_front ) {
		    	$this->header = Lava_Util::get_option( 'blog_header', 'default' );
		    	$blog_title = Lava_Util::get_option( 'blog_title', '' );
		    	$this->title = empty( $blog_title ) ? esc_html__( 'Blog', 'lava' ) : $blog_title;
		    	$this->layout = Lava_Util::get_option( 'blog_layout', 'sidebar-right' );
		    	$this->sidebar_id = Lava_Util::get_option( 'blog_sidebar', 'default-sidebar' );

	    		if ( 'default' == $this->header || 'image' == $this->header ) {
		    		$image_url = Lava_Util::get_option( 'blog_header_image', '' );
		    		if ( !empty( $image_url ) ) {
		    			$this->header_image_style = ' style="background-image:url('. esc_url( $image_url ) .');"';
		    		}
	    		} elseif ( 'slider' == $this->header ) {
	    			$this->header_shortcode = Lava_Util::get_option( 'blog_header_shortcode', '' );
	    		}

	    	} else {
	    		$blog_page_id = get_option( 'page_for_posts' );
	    		if ( $blog_page_id ) {
	    			$is_single = true;
	    			$use_custom_sidebar = true;
	    			$this->id = $blog_page_id;
	    			$this->title = get_the_title( $this->id );
		        	$this->container = get_post_meta( $this->id, '_lava_page_container', true );
	    		}
	    	}
	    	$this->post_style = Lava_Util::get_option( 'blog_list_style', '1' );
	    	$this->post_meta = Lava_Util::get_option( 'blog_post_meta', array( 'author', 'cats', 'comment' ) );
	    	$this->excerpt_length = Lava_Util::get_option( 'blog_excerpt_length', 120 );

	        if ( '1' == $this->post_style ) {
	        	if ( 'full-width' == $this->layout ) {
	        		$this->thumb_size = 'full';
	        	} else {
	        		$this->thumb_size = 'lava_thumb_large';
	        	}
	        } else {
	        	$this->thumb_size = 'lava_thumb_small';
	        }

	    } elseif ( is_singular() ) {

	        if ( is_singular( array( 'hb_room' ) ) ) {
	        	$is_single = true;
	        	$use_custom_sidebar = true;
	        }

	        elseif ( is_singular( array( 'tribe_events' ) ) ) {
	        	$this->header = 'placeholder';
	        	$this->layout = Lava_Util::get_option( 'event_single_layout', 'sidebar-right' );
	        }

	        elseif ( is_singular( array( 'tribe_venue' ) ) ) {
	        	$this->header = 'placeholder';
	        	$this->layout = 'full-width';
	        }

	        elseif ( is_singular( array( 'tribe_organizer' ) ) ) {
	        	$this->header = 'placeholder';
	        	$this->layout = 'full-width';
	        }

	        elseif ( is_singular( array( 'lava_offer' ) ) ) {
	        	$is_single = true;
	        	$this->title = get_the_title();
	        	$this->layout = get_post_meta( $this->id, '_lava_page_layout', true );
	        	$this->layout = !empty( $this->layout ) ? $this->layout : '1';
	        	$this->container = get_post_meta( $this->id, '_lava_page_container', true );
	        }

	    	elseif ( is_single() ) {
	    		$is_single = true;
	    		$use_custom_sidebar = true;
	    		$this->template = 'blog';
	    		$this->title = '';
				$this->sidebar_id = Lava_Util::get_option( 'single_sidebar', 'default-sidebar' );
				$this->thumb_size = 'full-width' == $this->layout ? 'full' : 'lava_thumb_large';
	    	}

	        elseif ( is_page_template( 'page-builder.php' ) ) {
	        	$is_single = true;
	        	$this->template = 'page-builder';
	        	$this->container = get_post_meta( $this->id, '_lava_page_container', true );
	        	$this->layout = 'full-width';
	        }

	        elseif ( is_page() ) {
	        	$is_single = true;
	        	$use_custom_sidebar = true;
	        	$this->template = 'page';
	        	$this->container = get_post_meta( $this->id, '_lava_page_container', true );

		        if ( is_page_template( 'page-hb-search.php' ) ) {
		        	$this->excerpt_length = Lava_Util::get_option( 'hb_search_excerpt_length', 150 );
		        }
	        }

	        elseif ( is_attachment() ) {
	            $this->template = 'attachment';
	        }
	    }

	    elseif ( is_archive() ) {

	    	if ( class_exists( 'WP_Hotel_Booking' ) && ( is_post_type_archive( 'hb_room' ) || is_tax( get_object_taxonomies( 'hb_room' ) ) ) ) {
	    		$this->header = Lava_Util::get_option( 'hb_archive_header', 'default' );
	    		$this->layout = 'full-width';

	    		if ( is_tax( get_object_taxonomies( 'hb_room' ) ) ) {
	    			$this->title = lava_get_archive_title();
	    		} else {
	    			$this->title = Lava_Util::get_option( 'hb_archive_title', post_type_archive_title( '', false ) );
	    		}

	    		if ( 'default' == $this->header || 'image' == $this->header ) {
		    		$image_url = Lava_Util::get_option( 'hb_archive_header_image', '' );
		    		if ( !empty( $image_url ) ) {
		    			$this->header_image_style = ' style="background-image:url('. esc_url( $image_url ) .');"';
		    		}
	    		} elseif ( 'slider' == $this->header ) {
	    			$this->header_shortcode = Lava_Util::get_option( 'hb_archive_header_shortcode', '' );
	    		}
	    	}

	    	elseif ( is_post_type_archive( 'tribe_events' ) || is_tax( 'tribe_events_cat' ) ) {
				$this->template = 'archive';
				$this->title = lava_get_archive_title();
				$this->header = 'placeholder';
				$this->layout = 'full-width';
	    	}

	    	elseif ( is_post_type_archive( 'lava_offer' ) || is_tax( 'lava_offer_category' )  ) {
				$this->template = 'archive';
				$this->title = Lava_Util::get_option( 'offer_archive_title', post_type_archive_title( '', false ) );
				$this->header = Lava_Util::get_option( 'offer_archive_header', 'default' );
				$this->layout = 'full-width';
				$this->post_style = 'offer';
				$this->container = 'no_container';

	    		if ( 'image' == $this->header ) {
		    		$image_url = Lava_Util::get_option( 'offer_archive_header_image', '' );
		    		if ( !empty( $image_url ) ) {
		    			$this->header_image_style = ' style="background-image:url('. esc_url( $image_url ) .');"';
		    		}
	    		} elseif ( 'slider' == $this->header ) {
	    			$this->header_shortcode = Lava_Util::get_option( 'offer_archive_header_shortcode', '' );
	    		}
	    	}

	    	else {
	    		$this->template = 'archive';
	    		$this->title = lava_get_archive_title();
		        $this->layout = Lava_Util::get_option( 'archive_layout', 'sidebar-right' );
		        $this->sidebar_id = Lava_Util::get_option( 'archive_sidebar', 'default-sidebar' );
		        $this->post_style = Lava_Util::get_option( 'archive_list_style', '1' );
		        $this->excerpt_length = Lava_Util::get_option( 'archive_excerpt_length', 150 );
		        
		        if ( '1' == $this->post_style ) {
		        	if ( 'full-width' == $this->layout ) {
		        		$this->thumb_size = 'full';
		        	} else {
		        		$this->thumb_size = 'lava_thumb_large';
		        	}
		        } else {
		        	$this->thumb_size = 'lava_thumb_small';
		        }
	    	}
	    }

	    elseif ( is_search() ) {
	        $this->template = 'search';

			if ( have_posts() ) {
				$this->title = sprintf( esc_html__( 'Search Results for "%s"', 'lava' ), get_search_query() );
			} else {
				$this->title = sprintf( esc_html__( 'No results found for "%s"', 'lava' ), get_search_query() );
			}
	    }

	    if ( $is_single ) {
        	$this->header = get_post_meta( $this->id, '_lava_page_header', true );
        	$this->header = empty( $this->header ) ? 'default' : $this->header;

    		if ( 'default' == $this->header || 'image' == $this->header ) {
				$header_image = get_post_meta( $this->id, '_lava_page_header_image', true );
				$this->header_image_style = lava_get_background_image_style( $header_image );
    		}

    		if ( empty( $this->layout ) ) {
    			$this->layout = get_post_meta( $this->id, '_lava_page_layout', true );
    		}
	    }

	    if ( $use_custom_sidebar ) {
			$sidebar_id = get_post_meta( $this->id, '_lava_page_sidebar', true );
			if ( !empty( $sidebar_id ) && 'default' != $sidebar_id ) {
				$this->sidebar_id = $sidebar_id;
			}
	    }

	    if ( empty( $this->header ) ) {
	    	$this->header = 'default';
	    }

	    if ( 'slider' == $this->header && empty( $this->header_shortcode ) ) {
	    	$slider_shortcode = get_post_meta( $this->id, '_lava_page_slider_shortcode', true );
			$this->header_shortcode = isset( $slider_shortcode ) ? $slider_shortcode : '';
	    }

	    if ( empty( $this->container ) ) {
	    	$this->container = 'container';
	    }

	    if ( empty( $this->layout ) ) {
	    	$this->layout = Lava_Util::get_option( 'global_layout', 'sidebar-right' );
	    }

	    if ( empty( $this->title ) ) {
	    	$this->title = get_the_title();
	    }

	    if ( $this->header == 'default' ) {
	    	add_filter( 'woocommerce_show_page_title', '__return_false' );
	    }
	}

	public function get_ID() {
		return $this->id;
	}

	public function get_header_style() {
		return $this->header_style;
	}

	public function get_container() {
		return $this->container;
	}

	public function get_layout() {
		return $this->layout;
	}

	public function get_sidebar_id() {
		return $this->sidebar_id;
	}

	public function get_template() {
		return $this->template;
	}

	public function get_header() {
		return $this->header;
	}

	public function get_header_affix_style() {
		return $this->header_affix_style;
	}

	public function get_thumb_size() {
		return $this->thumb_size;
	}

	public function get_title() {
		return $this->title;
	}

	public function get_post_meta() {
		return empty( $this->post_meta ) ? '' : $this->post_meta;
	}

	public function get_header_image_style() {
		return $this->header_image_style;
	}

	public function get_header_shortcode() {
		return $this->header_shortcode;
	}

	public function get_post_style() {
		return empty( $this->post_style ) ? '1' : $this->post_style;
	}

	public function get_excerpt_length() {
		return empty( $this->excerpt_length ) ? 150 : $this->excerpt_length;
	}
}

/**
 * Main instance of Lava_Page.
 *
 * Returns the main instance of Lava_Page to prevent the need to use globals.
 *
 */
function Lava() {
	return Lava_Page::instance();
}