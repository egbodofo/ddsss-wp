<?php
/* =============================================================================
   Lava Demo Generator v1.0
   ============================================================================= */
class Lava_Demo_Generator {

    static $widget_instance = 100;
    static $post_content = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.

Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.

Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis.';

    static function set_static_homepage( $page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_id );
    }

    static function set_blog_page( $page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_for_posts', $page_id );
    }

    /* -----------------------------------------------------------------------------
     * Add posts & pages
     * ----------------------------------------------------------------------------- */

    static function add_post( $args ) {
        $new_post = array( 
            'post_title' => $args['title'],
            'post_status' => 'publish',
            'post_type' => 'post',
            'comment_status' => 'open',
            'post_category' => isset( $args['categories'] ) ? $args['categories'] : array(),
            'tags_input' => isset( $args['tags'] ) ? $args['tags'] : array(),
            'guid' => uniqid()
        );

        if ( !empty( $args['post_content'] ) ) {
            $new_post['post_content'] = $args['post_content'];
        } else {
            $new_post['post_content'] = self::get_post_content();
        }

        $post_id = wp_insert_post( $new_post );

        // add our demo custom meta field, using this field we will delete all the pages
        update_post_meta( $post_id, '_lava_demo_content', true );

        if ( !empty( $args['post_format'] ) ) {
            set_post_format( $post_id, $args['post_format'] );
        }

        if ( !empty( $args['featured'] ) ) {
            set_post_thumbnail( $post_id, $args['featured'] );
        }

        if ( isset( $args['sticky'] ) && $args['sticky'] ) {
            stick_post( $post_id );
        }
        
        if ( !empty( $args['post_meta'] ) ) {
            foreach ( $args['post_meta'] as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }
        }

        return $post_id;
    }

    static function add_page( $args ) {
        $new_page = array( 
            'post_title' => $args['title'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
            'guid' => uniqid()
        );

        if ( ! empty( $args['post_content'] ) ) {
            $new_page['post_content'] = $args['post_content'];
        } else {
            $new_page['post_content'] = '';
        }

        $page_id = wp_insert_post( $new_page );

        update_post_meta( $page_id, '_lava_demo_content', true );

        if ( !empty( $args['post_meta'] ) ) {
            foreach ( $args['post_meta'] as $key => $value ) {
                update_post_meta( $page_id, $key, $value );
            }
        }

        if ( !empty( $args['template'] ) ) {
            update_post_meta( $page_id, '_wp_page_template', $args['template'] );
        }

        return $page_id;
    }


    static function add_custom_post_type( $args ) {
        $new_post = array( 
            'post_title' => $args['title'],
            'post_type' => $args['post_type'],
            'post_status' => 'publish',
            'ping_status' => 'closed',
            'comment_status' => 'closed',
            'post_category' => isset( $args['categories'] ) ? isset( $args['categories'] ) : array(),
            'tags_input' => isset( $args['tags'] ) ? isset( $args['tags'] ) : array(),
            'guid' => uniqid()
        );

        if ( !empty( $args['post_content'] ) ) {
            $new_post['post_content'] = $args['post_content'];
        }

        $post_id = wp_insert_post( $new_post );

        if ( !empty( $args['featured'] ) ) {
            set_post_thumbnail( $post_id, $args['featured'] );
        }

        if ( !empty( $args['post_meta'] ) ) {
            foreach ( $args['post_meta'] as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }
        }

        if ( !empty( $args['room_type'] ) ) {
            wp_set_object_terms( $post_id, $args['room_type'], 'hb_room_type' );
        }

        // add our demo custom meta field, using this field we will delete all the pages
        update_post_meta( $post_id, '_lava_demo_content', true );

        return $post_id;
    }

    /* -----------------------------------------------------------------------------
     * Add term
     * ----------------------------------------------------------------------------- */
    static function add_term( $term_name, $taxonomy, $args = array(), $term_meta = array() ) {
        $term = term_exists( $term_name, $taxonomy );
        if ( $term !== 0 && $term !==  null ) {
            if ( is_array( $term ) ) {
                return $term['term_id'];
            } else {
                wp_update_term( $term, $taxonomy );
                return $term;
            }
        }

        $term = wp_insert_term( $term_name, $taxonomy );
        $term_id = 0;

        if ( !is_wp_error( $term ) ) {
            $term_id = $term['term_id'];
            $demo_option = get_option( 'lava_demo' );

            if ( !empty( $demo_option['taxonomies'] ) ) {
                if ( !in_array( $taxonomy, $demo_option['taxonomies'] ) ) {
                    $demo_option['taxonomies'][] = $taxonomy;
                }
            } else {
                $demo_option['taxonomies'][] = $taxonomy;
            }

            $demo_option[$taxonomy][] = $term_id;
            update_option( 'lava_demo', $demo_option );

            if ( !empty( $args['description'] ) ) {
                wp_update_term( $term_id, $taxonomy, array( 'description' => $args['description'] ) );
            }

            if ( !empty( $term_meta ) && is_array( $term_meta ) ) {
                foreach ( $term_meta as $key => $value ) {
                    add_term_meta( $term_id, $key, $value, true );
                }
            }
        }

        return $term_id;
    }

    /* -----------------------------------------------------------------------------
     * Add category
     * ----------------------------------------------------------------------------- */

    static function add_category( $args ) {
        // check if the category exist
        $term = term_exists( $args['name'], 'category', $args['parent_id'] );
        if ( $term !== 0 && $term !==  null ) {
            if ( is_array( $term ) ) {
                return $term['term_id'];
            } else {
                wp_update_term( $term, 'category' );
                return $term;
            }
        }

        // create new category
        $cat_id = wp_create_category( $args['name'], $args['parent_id'] );

        // if a new category is created, update ts demo
        if ( $cat_id !== 0 ) {
            $demo_option = get_option( 'lava_demo' );
            $demo_option['categories'][] = $cat_id;
            update_option( 'lava_demo', $demo_option );
            if ( !empty( $args['description'] ) ) {
                wp_update_term( $cat_id, 'category', array( 'description' => $args['description'] ) );
            }
        }
        return $cat_id;
    }

    static function add_tag( $args ) {
        // check if the tag exist
        $term = term_exists( $args['name'], 'post_tag', $args['parent_id'] );
        if ( $term !== 0 && $term !==  null ) {
            if ( is_array( $term ) ) {
                return $term['term_id'];
            } else {
                wp_update_term( $term, 'post_tag' );
                return $term;
            }
        }

        // create new category
        $term_id = wp_insert_term( $args['name'], 'post_tag', array( 'parent' => 0 ) );

        // if a new tag is created, update ts demo
        if ( $term_id !== 0 ) {
            $demo_option = get_option( 'lava_demo' );
            $demo_option['tags'][] = $tag_id;
            update_option( 'lava_demo', $demo_option );
            if ( !empty( $args['description'] ) ) {
                wp_update_term( $tag_id, 'post_tag', array( 'description' => $args['description'] ) );
            }
        }
        return $term_id;
    }

    /* -----------------------------------------------------------------------------
     * Post content
     * ----------------------------------------------------------------------------- */

    static function get_post_content() {
        return self::$post_content;
    }

    /* -----------------------------------------------------------------------------
     * Add sidebar & assign widgets to sidebar
     * ----------------------------------------------------------------------------- */

    static function add_sidebar( $name, $desc = '' ) {

        if ( empty( $name ) ) return;

        $sidebar_id = Lava_Widget_Areas::name_to_id( $name );
        $widget_areas = get_option( 'lava_widget_areas' );

        // if a sidebar already exist return id
        if ( !empty( $widget_areas ) && array_key_exists( $sidebar_id, $widget_areas ) ) {
            return $sidebar_id;
        }

        // update widget areas to theme option
        $widget_areas[$sidebar_id] = array( 'name' => $name, 'desc' => $desc );
        update_option( 'lava_widget_areas', $widget_areas );
        
        // update to lava_demo
        $demo_option = get_option( 'lava_demo' );
        $demo_option['widget_areas'][] = $sidebar_id;
        update_option( 'lava_demo', $demo_option );

        // update sidebar to active sidebar list
        $active_sidebars = get_option( 'sidebars_widgets' );
        $active_sidebars[$sidebar_id] = array();
        update_option( 'sidebars_widgets', $active_sidebars );

        return $sidebar_id;
    }

    static function add_widget_to_sidebar( $sidebar_id, $widget_name, $args ) {
        $active_sidebars = get_option( 'sidebars_widgets' );
        $demo_option = get_option( 'lava_demo' );

        if ( !isset( $demo_option['sidebars_history'] ) ) {
            // save current sidebars
            $demo_option['sidebars_history'] = $active_sidebars;
            // remove widgets from current sidebars
            $active_sidebars['default-sidebar'] = array();
            $active_sidebars['footer-1'] = array();
            $active_sidebars['footer-2'] = array();
            $active_sidebars['footer-3'] = array();
            $active_sidebars['footer-4'] = array();
            $active_sidebars['hb-sidebar'] = array();
        }

        // update widget to active sidebar list
        $active_sidebars[$sidebar_id][] = $widget_name . '-' . self::$widget_instance;
        update_option( 'sidebars_widgets', $active_sidebars );

        // update widget instance
        $widget = get_option( 'widget_' . $widget_name );
        $widget[self::$widget_instance] = $args;
        update_option( 'widget_' . $widget_name, $widget );

        // save widget instance
        $demo_option['widgets'][] = array( 'widget_' . $widget_name, self::$widget_instance );

        // update demo info
        update_option( 'lava_demo', $demo_option );

        self::$widget_instance ++;
    }
 

    /* -----------------------------------------------------------------------------
     * Add menu & menu items
     * ----------------------------------------------------------------------------- */

    static function add_menu( $menu_name = '', $locations = array() ) {
        
        $menu_obj = wp_get_nav_menu_object( $menu_name );
        $menu_id = 0;

        // check if menu exists if not we create one.
        if ( $menu_obj === false ) {
            $menu_id = wp_create_nav_menu( $menu_name );
            if ( is_wp_error( $menu_id ) ) {
                return false;
            }
        } else {
            $menu_id = $menu_obj->term_id;
        }

        $demo_option = get_option( 'lava_demo' );
        // save menu name
        $demo_option['menus'][] = $menu_name;

        if ( empty( $locations ) ) {
            update_option( 'lava_demo', $demo_option );
            return $menu_id;
        }

        $menus = get_theme_mod( 'nav_menu_locations' );

        // save menu location
        if ( !empty( $menus ) ) {
            if ( empty( $demo_option['nav_locations'] ) ) {
                $demo_option['nav_locations'] = $menus;
            }
        }
        update_option( 'lava_demo', $demo_option );

        // set new menu location
        if ( !empty( $locations ) && is_array( $locations ) ) {
            foreach ( $locations as $location ) {
                $menus[$location] = $menu_id;
            }
            set_theme_mod( 'nav_menu_locations', $menus );
        }

        return $menu_id;
    }

    static function add_menu_link( $menu_id, $args ) {
        $menu_item_data = array( 
            'menu-item-object' => '',
            'menu-item-parent-id' => isset( $args['parent_id'] ) ? $args['parent_id'] : 0,
            'menu-item-type' => 'custom',
            'menu-item-title' => isset( $args['title'] ) ? $args['title'] : 'title',
            'menu-item-url' => isset( $args['url'] ) ? $args['url'] : '#',
            'menu-item-status' => 'publish',
        );
        $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );

        self::add_custom_nav_fields( $menu_item_id, $args );

        return $menu_item_id;
    }

    static function add_menu_category( $menu_id, $args ) {
        $menu_item_data = array( 
            'menu-item-parent-id' => $args['parent_id'],
            'menu-item-title' => $args['title'],
            'menu-item-object-id' => $args['category_id'],
            'menu-item-url' => get_category_link( $args['category_id'] ),
            'menu-item-object' => 'category',
            'menu-item-type' => 'taxonomy',
            'menu-item-status' => 'publish'
        );
        $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );

        self::add_custom_nav_fields( $menu_item_id, $args );

        return $menu_item_id;
    }

    static function add_menu_page( $menu_id, $args ) {
        $menu_item_data = array( 
            'menu-item-parent-id' => $args['parent_id'],
            'menu-item-title' => isset( $args['title'] ) ? $args['title'] : '',
            'menu-item-object-id' => $args['page_id'],
            'menu-item-object' => 'page',
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish'
        );
        $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );

        self::add_custom_nav_fields( $menu_item_id, $args );

        return $menu_item_id;
    }

    static function add_menu_post( $menu_id, $args ) {
        $menu_item_data = array( 
            'menu-item-parent-id' => $args['parent_id'],
            'menu-item-title' => $args['title'],
            'menu-item-object-id' => $args['post_id'],
            'menu-item-object' => 'post',
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish'
        );
        $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );

        self::add_custom_nav_fields( $menu_item_id, $args );

        return $menu_item_id;
    }

    static function add_menu_post_format( $menu_id, $args ) {
        $term = get_term_by( 'slug', 'post-format-' . $args['post_format'], 'post_format' );

        $menu_item_data = array( 
            'menu-item-parent-id' => $args['parent_id'],
            'menu-item-title' => $args['title'],
            'menu-item-object-id' => $term->term_id,
            'menu-item-object' => 'post_format',
            'menu-item-type' => 'taxonomy',
            'menu-item-status' => 'publish'
        );
        $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );

        self::add_custom_nav_fields( $menu_item_id, $args );

        return $menu_item_id;
    }

    static function add_custom_nav_fields( $menu_item_id, $args = array() ) {
        update_post_meta( $menu_item_id, '_lava_demo_content', true );
    }

    /* -----------------------------------------------------------------------------
     * Add images to media library
     * ----------------------------------------------------------------------------- */

    static function add_media_image( $url ) {

        if ( !function_exists( 'media_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
        }

        $tmp = download_url( $url );
        $desc = LAVA_THEME_NAME .' Demo Image';
        $file_array = array();

        // Set variables for storage
        // fix file filename for query strings
        preg_match( '/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches );
        $file_array['name'] = basename( $matches[0] );
        $file_array['tmp_name'] = $tmp;

        // If error storing temporarily, unlink
        if ( is_wp_error( $tmp ) ) {
            @unlink( $file_array['tmp_name'] );
            $file_array['tmp_name'] = array();
            // $tmp->get_error_message();
            return;
        }

        // do the validation and storage stuff
        $id = media_handle_sideload( $file_array, 0, $desc );

        // If error storing permanently, unlink
        if ( is_wp_error( $id ) ) {
            @unlink( $file_array['tmp_name'] );
            // $id->get_error_message();
            return;
        } else {
            update_post_meta( $id, '_lava_demo_content', true );
        }

        return $id;
    }

    /* -----------------------------------------------------------------------------
     * Delete contents
     * ----------------------------------------------------------------------------- */

    static function delete_posts() {
        $query = new WP_Query( 
            array( 
            'post_type' => array(
                'page',
                'post',
                'attachment',
                'nav_menu_item',
                'tribe_events',
                'tribe_venue',
                'tribe_organizer',
                'lava_offer',
                'hb_room',
                'hb_extra_room',
                'wpcf7_contact_form',
            ),
            'meta_key'  => '_lava_demo_content',
            'posts_per_page' => '-1'
         ) );
        if ( !empty( $query->posts ) ) {
            foreach ( $query->posts as $post ) {
                $response = wp_delete_post( $post->ID, true );
                if ( $response === false ) {
                    echo 'Fail to delete post: ' . $post->ID;
                }
            }
        }
    }

    static function delete_media() {
        $query = new WP_Query( 
            array( 
            'post_type' => array( 'attachment' ),
            'post_status' => 'inherit',
            'meta_key'  => '_lava_demo_content',
            'posts_per_page' => '-1'
        ) );
        if ( !empty( $query->posts ) ) {
            foreach ( $query->posts as $post ) {
                $response = wp_delete_attachment( $post->ID, true );
                if ( $response === false ) {
                    echo 'Fail to delete attachment: ' . $post->ID;
                }
            }
        }
    }

    static function delete_menus() {
        $demo_option = get_option( 'lava_demo' );

        // delete demo menus
        if ( !empty( $demo_option['menus'] ) ) {
            foreach ( $demo_option['menus'] as $menu ) {
                wp_delete_nav_menu( $menu );
            }
            unset( $demo_option['menus'] );
        }

        // restore nav locations
        if ( isset( $demo_option['nav_locations'] ) ) {
            set_theme_mod( 'nav_menu_locations', $demo_option['nav_locations'] );
            unset( $demo_option['nav_locations'] );
        }

        update_option( 'lava_demo', $demo_option );
    }

    static function delete_terms() {
        $demo_option = get_option( 'lava_demo' );
        $categories = isset( $demo_option['categories'] ) ? $demo_option['categories'] : false;
        $tags = isset( $demo_option['tags'] ) ? $demo_option['tags'] : false;

        // delete demo categories
        if ( $categories ) {
            foreach ( $categories as $id ) {
                $response = wp_delete_category( $id );
                if ( $response === false ) {
                    echo 'Fail to delete category: ' . $id;
                }
            }
            unset( $demo_option['categories'] );
        }

        // delete demo tags
        if ( $tags ) {
            foreach ( $tags as $id ) {
                $response = wp_delete_term( $id, 'post_tag' );
                if ( $response === false ) {
                    echo 'Fail to delete tag: ' . $id;
                }
            }
            unset( $demo_option['tags'] );
        }

        // delete demo taxonomies
        if ( !empty( $demo_option['taxonomies'] ) ) {
            foreach ( $demo_option['taxonomies'] as $taxonomy ) {
                if ( !empty( $demo_option[$taxonomy] ) ) {
                    foreach ( $demo_option[$taxonomy] as $term_id ) {
                        $response = wp_delete_term( $term_id, $taxonomy );
                        if ( $response === false ) {
                            echo 'Fail to delete '. $taxonomy .': ' . $term_id;
                        }
                    }
                    unset( $demo_option[$taxonomy] );
                }
            }
            unset( $demo_option['taxonomies'] );
        }

        update_option( 'lava_demo', $demo_option );
    }

    static function delete_sidebars() {
        $demo_option = get_option( 'lava_demo' );
        $widget_areas = get_option( 'lava_widget_areas' );

        // restore sidebars before demo installation
        if ( isset( $demo_option['sidebars_history'] ) ) {
            update_option( 'sidebars_widgets', $demo_option['sidebars_history'] );
            unset( $demo_option['sidebars_history'] );
        }

        // remove all demo widget areas
        if ( isset( $demo_option['widget_areas'] ) ) {
            foreach ( $demo_option['widget_areas'] as $id ) {
                unset( $widget_areas[$id] );
            }
            unset( $demo_option['widget_areas'] );
        }

        // remove all demo widget instances
        if ( isset( $demo_option['widgets'] ) ) {
            foreach ( $demo_option['widgets'] as $widget ) {
                $widget_option = get_option( $widget[0] );
                if ( isset( $widget_option[$widget[1]] ) ) {
                    unset( $widget_option[$widget[1]] );
                }
            }
            unset( $demo_option['widgets'] );
        }

        // update options
        update_option( 'lava_demo', $demo_option );
        update_option( 'lava_widget_areas', $widget_areas );
    }

    static function delete_content() {
        self::delete_posts();
        self::delete_media();
        self::delete_menus();
        self::delete_terms();
        self::delete_sidebars();
    }

    /* -----------------------------------------------------------------------------
     * Load & restore theme options
     * ----------------------------------------------------------------------------- */

    static function load_theme_options( $path, $save_options = true ) {
        // save current theme options
        if ( $save_options == true ) {
            $current_options = get_theme_mods();
            $demo_option = get_option( 'lava_demo' );
            $demo_option['theme_options'] = $current_options;

            $site_icon = get_option( 'site_icon' );
            if ( !empty( $site_icon ) ) {
                $demo_option['site_icon'] = get_option( 'site_icon' );
            }
            update_option( 'lava_demo', $demo_option );

            // tp hotel booking
            update_option( 'tp_hotel_booking_catalog_image_width', 400 );
            update_option( 'tp_hotel_booking_catalog_image_height', 300 );
            update_option( 'tp_hotel_booking_room_thumbnail_width', 120 );
            update_option( 'tp_hotel_booking_room_thumbnail_height', 80 );
            update_option( 'tp_hotel_booking_room_image_gallery_width', 1200 );
            update_option( 'tp_hotel_booking_room_image_gallery_height', 675 );
            update_option( 'tp_hotel_booking_price_number_of_decimal', '' );
            update_option( 'tp_hotel_booking_enable_single_book', true );

            $page_builder_options = get_option( 'siteorigin_panels_settings' );

            if ( isset( $page_builder_options ) ) {
                $page_builder_options['tablet-width'] = '1200';
                $page_builder_options['mobile-width'] = '1020';

                if ( isset( $page_builder_options['post-types'] ) ) {
                    if ( !in_array( 'lava_offer', $page_builder_options['post-types'] ) ) {
                        $page_builder_options['post-types'][] = 'lava_offer';
                    }

                    if ( !in_array( 'hb_room', $page_builder_options['post-types'] ) ) {
                        $page_builder_options['post-types'][] = 'hb_room';
                    }
                } else {
                    $page_builder_options['post-types'] = array( 'page', 'post', 'lava_offer', 'hb_room' );
                }

                update_option( 'siteorigin_panels_settings', $page_builder_options );
            }
        }

        // load demo settings
        $options_json = lava_file_get_contents( $path );
        $mods = json_decode( $options_json, true );
        $theme_slug = get_option( 'stylesheet' );
        update_option( "theme_mods_$theme_slug", $mods );
    }

    static function restore_theme_options() {
        // restore previous settingss
        $demo_option = get_option( 'lava_demo' );

        if ( isset( $demo_option['theme_options'] ) ) {
            $theme_slug = get_option( 'stylesheet' );
            update_option( "theme_mods_$theme_slug", $demo_option['theme_options'] );
            unset( $demo_option['theme_options'] );
        }

        if ( isset( $demo_option['site_icon'] ) ) {
            update_option( 'site_icon', $demo_option['site_icon'] );
            unset( $demo_option['site_icon'] );
        }
        update_option( 'lava_demo', $demo_option );
    }

    static function update_theme_options( $options = array() ) {
        $mods = get_theme_mods();
        if ( !empty( $options ) ) {
            foreach ( $options as $option => $value ) {
                $mods[$option] = $value;
            }
        }
        $theme_slug = get_option( 'stylesheet' );
        update_option( "theme_mods_$theme_slug", $mods );
    }
}