<?php
/**
 * Custom wp_nav_menu walker.
 *
 * @package Dostart WordPress theme
 * @since 1.0.6
 */

if ( ! class_exists('Dostart_Nav_Walker') ) {
	class Dostart_Nav_Walker extends Walker_Nav_Menu {

		/**
		 * Middle logo menu breaking point
		 *
		 * @access  private
		 * @var init
		 */
		private $break_point = null;

		/**
		 * Middle logo menu number of top level items displayed
		 *
		 * @access  private
		 * @var init
		 */
		private $displayed = 0;

		/**
		 * Starts the list before the elements are added.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
	        $indent = str_repeat("\t", $depth);

	        // Megamenu columns
	        $col = ! empty($this->megamenu_col) ? ('menu-col-'. $this->megamenu_col .'') : 'menu-col-2';

	        if ( 0 === $depth && '' !== $this->megamenu ) {
	        	$output .= "\n$indent<ul class=\"megamenu ". $col ." sub-menu\">\n";
	         } else {
	         	$output .= "\n$indent<ul class=\"sub-menu \">\n";
	         }
	    }

		/**
		 * Modified the menu output.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;
			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			// Set some vars
			if ( 0 === $depth ) {
				$this->megamenu             = get_post_meta($item->ID, '_menu_item_megamenu', true);
				$this->megamenu_auto_width  = get_post_meta($item->ID, '_menu_item_megamenu_auto_width', true);
				$this->megamenu_col         = get_post_meta($item->ID, '_menu_item_megamenu_col', true);
				$this->megamenu_heading     = get_post_meta($item->ID, '_menu_item_megamenu_heading', true);
			}

			// Set up empty variable.
			$class_names = '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			// Mega menu and Hide headings
		    if ( 0 === $depth && $this->has_children ) {
				if ( '' !== $this->megamenu && '' === $this->megamenu_auto_width ) {
					$classes[] = 'megamenu-li full-mega';
				} elseif ( '' !== $this->megamenu && '' !== $this->megamenu_auto_width ) {
					$classes[] = 'megamenu-li auto-mega';
				}

				if ( '' !== $this->megamenu && '' !== $this->megamenu_heading ) {
					$classes[] = 'hide-headings';
				}
			}

			// Latest post for menu item categories
			if ( '' !== $item->category_post && 'category' === $item->object ) {
				$classes[] = 'menu-item-has-children megamenu-li full-mega mega-cat';
			}

		    // Nav no click
		    if ( '' !== $item->nolink ) {
		    	$classes[] = 'nav-no-click';
		    }

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since 1.0.6
			 *
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param WP_Post  $item  Menu item data object.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 1.0.6
			 *
			 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post  $item    The current menu item.
			 * @param stdClass $args    An object of wp_nav_menu() arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since 1.0.6
			 *
			 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Post  $item    The current menu item.
			 * @param stdClass $args    An object of wp_nav_menu() arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
			$atts['target'] = ! empty($item->target) ? $item->target : '';
			$atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';
			$atts['href']   = ! empty($item->url) ? $item->url : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 1.0.6
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty($value) ) {
					$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters('the_title', $item->title, $item->ID);

			/**
			 * Filters a menu item's title.
			 *
			 * @since 1.0.6
			 *
			 * @param string   $title The menu item's title.
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

		    // Description
		    $description = '';
		    if ( '' !== $item->description ) {
		    	$description = '<span class="nav-content">'. $item->description .'</span>';
		    }

		    // Output
		    $item_output = $args->before;

			$item_output .= '<a'. $attributes .' class="menu-link">';

			$item_output .= $args->link_before . $title . $args->link_after;

	    	if ( 0 !== $depth ) {
		    	$item_output .= $description;
		    }

			$item_output .= '</a>';

			if ( ($item->template || $item->mega_template) && '' !== $this->megamenu ) {
				ob_start();
				    include(DOSTART_THEME_DIR . 'inc/walker/template.php');
					// get_template_part('inc/walker/template.php');
					$template_content = ob_get_contents();
				ob_end_clean();
				$item_output .= $template_content;
			}

			if ( $item->megamenu_widgetarea && '' !== $this->megamenu ) {
				ob_start();
					dynamic_sidebar($item->megamenu_widgetarea);
					$sidebar_content = ob_get_contents();
				ob_end_clean();
				$item_output .= $sidebar_content;
			}

		    $item_output .= $args->after;

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

		}

		/**
		 * Modified the menu end.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			// Header style

			if ( 0 === $depth && '' !== $item->category_post ) {
				global $post;

				$output .= "\n<ul class=\"megamenu menu-col-4 sub-menu\">\n";

					// Sub Categories ===============================================================
					if ( '' !== $item->category_post && 'category' === $item->object ) {
						$no_sub_categories = $sub_categories_exists = $sub_categories = '';

						$query_args = array(
							'child_of' => $item->object_id,
						);
						$sub_categories = get_categories($query_args);

						//Check if the category doesn't contain any sub categories.
						if ( count($sub_categories) === 0 ) {
							$sub_categories = array( $item->object_id ) ;
							$no_sub_categories = true ;
						}

						foreach ( $sub_categories as $category ) {

							if ( ! $no_sub_categories ) {
								$cat_id = $category->term_id;
							} else {
								$cat_id = $category;
							}

							$original_post  = $post;
							$count          = 0;

							$args = array(
								'posts_per_page'      => 4,
								'cat'                 => $cat_id,
								'no_found_rows'       => true,
								'ignore_sticky_posts' => true,
							);
							$cat_query = new WP_Query($args);

							// Title
							$output .= '<h3 class="mega-cat-title">'. esc_html__('Latest in', 'dostart') .' '. get_cat_name($cat_id) .'</h3>';

							while ( $cat_query->have_posts() ) {

								// first post
								$count++;

								if ( 1 === $count ) {
									$classes = 'mega-cat-post first';
								} else {
									$classes = 'mega-cat-post';
								}

								$cat_query->the_post();

								$output .= '<li class="'. $classes .'">';

								if ( has_post_thumbnail() ) {

									// Image args
									$img_args = array(
									    'alt' => get_the_title(),
									);
									if ( dostart_get_schema_markup('image') ) {
										$img_args['itemprop'] = 'image';
									}

									$output .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="mega-post-link">';

										$output .= get_the_post_thumbnail(get_the_ID(), 'medium', $img_args);

									$output .= '<span class="overlay"></span>';
									$output .= '</a>';

									$output .= '<h3 class="mega-post-title"><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3><div class="mega-post-date"><i class="icon-clock"></i>'. get_the_date() .'</div>';

								}

								$output .= '</li>';
							}

							wp_reset_postdata();

						}

					$output .= '</ul>';
				}
			}

			// </li> output.
			$output .= '</li>';

		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		/**
		 * Icon if sub menu.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

			// Define vars
			$id_field     = $this->db_fields['id'];
			
			if (is_object($args[0]))
			   $args[0]->has_children = ! empty($children_elements[ $element->$id_field ]);

			// Down Arrows
			if ( ! empty($children_elements[ $element->$id_field ]) && (0 === $depth)
				|| '' !== $element->category_post ) {
				$element->classes[] = 'dropdown';
				if ( 1 == get_theme_mod('dostart_menu_arrow_down', true) ) {
					$element->title .= '<i class="fas fa-chevron-down"></i>';
				}
			}

			// Right/Left Arrows
			if ( ! empty($children_elements[ $element->$id_field ]) && ($depth > 0) ) {
				$element->classes[] = 'dropdown';
				if ( 1 == get_theme_mod('dostart_menu_arrow_side', true) ) {
					if ( is_rtl() ) {
					//	$element->title .= '<span class="nav-arrow fa fa-angle-right"></span>';
					} else {
					//	$element->title .= '<span class="nav-arrow fa fa-angle-left"></span>';
					}
				}
			}

			// Define walker
			Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

		}

	}
}