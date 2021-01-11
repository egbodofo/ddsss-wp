<?php
/* -----------------------------------------------------------------------------
 * Post Metaboxes
 * ----------------------------------------------------------------------------- */
function lava_meta_boxes( $meta_boxes ) {
    $common_metabox_fields = array(
        array(
            'id' => '_lava_page_header',
            'name' => esc_html__( 'Header Option', 'lava' ),
            'type' => 'select',
            'std' => 'default',
            'options' => lava_get_option_page_headers()
        ),
        array(
            'id' => '_lava_page_header_image',
            'name' => esc_html__( 'Header Image', 'lava' ),
            'type' => 'image_advanced',
            'max_file_uploads' => 1,
            'max_status' => false,
            'visible' => array( '_lava_page_header', 'in', array( 'default', 'image' ) )
        ),
        array(
            'id'   => '_lava_page_slider_shortcode',
            'name' => esc_html__( 'Slider Shortcode', 'lava' ),
            'type' => 'text',
            'size' => 100,
            'visible' => array( '_lava_page_header', '=', 'slider' )
        ),
        array(
            'id'   => '_lava_header_title',
            'name' => esc_html__( 'Header Title', 'lava' ),
            'type' => 'text',
            'visible' => array( '_lava_page_header', '=', 'image' ),
            'size' => 100,
        ),
        array(
            'id'   => '_lava_header_subtitle',
            'name' => esc_html__( 'Header Subtitle', 'lava' ),
            'type' => 'text',
            'visible' => array( '_lava_page_header', '=', 'image' ),
            'size' => 100,
        ),
        array(
            'id'   => '_lava_header_text',
            'name' => esc_html__( 'Header Text', 'lava' ),
            'type' => 'textarea',
            'visible' => array( '_lava_page_header', '=', 'image' ),
            'size' => 100,
        ),
        array(
            'id'   => '_lava_header_button_text',
            'name' => esc_html__( 'Header Button Text', 'lava' ),
            'type' => 'text',
            'visible' => array( '_lava_page_header', '=', 'image' ),
            'size' => 100,
        ),
        array(
            'id'   => '_lava_header_button_url',
            'name' => esc_html__( 'Header Button URL', 'lava' ),
            'type' => 'text',
            'visible' => array( '_lava_page_header', '=', 'image' ),
            'size' => 100,
        )
    );

    // post metaboxes
    $post_metabox_fields = $common_metabox_fields;

    $post_metabox_fields[] = array(
        'id'   => '_lava_page_layout',
        'name' => esc_html__( 'Page Layout', 'lava' ),
        'class' => 'lava_page_layout',
        'type' => 'image_select',
        'std' => 'sidebar-right',
        'options' => lava_get_option_layouts()
    );

    $post_metabox_fields[] = array(
        'id'   => '_lava_page_sidebar',
        'name' => esc_html__( 'Sidebar', 'lava' ),
        'class' => 'lava_page_sidebar',
        'type' => 'select',
        'std' => 'default',
        'options' => lava_get_metabox_sidebars()
    );

    $meta_boxes[] = array(
        'title'      => esc_html__( 'Page Settings', 'lava' ),
        'post_types' => 'post',
        'fields'     => $post_metabox_fields
    );

    // page metaboxes
    $page_metabox_fields = $post_metabox_fields;

    $page_metabox_fields[] = array(
        'id' => '_lava_page_container',
        'name' => esc_html__( 'Page Container', 'lava' ),
        'type' => 'select',
        'class' => 'lava_page_container',
        'std' => 'container',
        'options' => array(
            'container' => esc_html__( 'Container', 'lava' ),
            'no_container' => esc_html__( 'No Container', 'lava' ),
        )
    );

    $meta_boxes[] = array(
        'title'      => esc_html__( 'Page Settings', 'lava' ),
        'post_types' => array( 'page' ),
        'fields'     => $page_metabox_fields
    );

    if ( class_exists( 'WooCommerce' ) ) {
        $meta_boxes[] = array(
            'title'      => esc_html__( 'Page Settings', 'lava' ),
            'post_types' => array( 'product' ),
            'fields'     => $common_metabox_fields
        );
    }

    // room metaboxes
    if ( class_exists( 'WP_Hotel_Booking' ) ) {

        $room_metabox_fields = $common_metabox_fields;
        $room_metabox_fields[] = array(
            'id'   => '_lava_page_layout',
            'name' => esc_html__( 'Page Layout', 'lava' ),
            'type' => 'image_select',
            'std' => 'sidebar-right',
            'options' => array(
                'sidebar-right' => LAVA_ADMIN_URI . '/assets/images/layouts/s1.png',
                'sidebar-left' => LAVA_ADMIN_URI . '/assets/images/layouts/s2.png',
                'custom' => LAVA_ADMIN_URI . '/assets/images/layouts/s3.png',
                'blank' => LAVA_ADMIN_URI . '/assets/images/layouts/blank.png',
            )
        );

        $room_metabox_fields[] = array(
            'id'   => '_lava_page_sidebar',
            'name' => esc_html__( 'Sidebar', 'lava' ),
            'class' => 'lava_page_sidebar',
            'type' => 'select',
            'std' => 'default',
            'options' => lava_get_metabox_sidebars()
        );

        $room_metabox_fields[] = array(
            'id'   => '_lava_room_tabs',
            'name' => esc_html__( 'Tab Layout', 'lava' ),
            'type' => 'checkbox',
            'std' => 1,
        );

        $room_metabox_fields[] = array(
            'id'   => '_lava_room_type_title',
            'name' => esc_html__( 'Room Type', 'lava' ),
            'description' => esc_html__( 'Optional subtitle', 'lava' ),
            'type' => 'text',
        );

        $room_metabox_fields[] = array(
            'id'   => '_lava_room_excerpt',
            'name' => esc_html__( 'Room Excerpt', 'lava' ),
            'type' => 'wysiwyg',
            'options' => array(
                'textarea_rows' => 5,
                'teeny' => true
            ),
        );

        $meta_boxes[] = array(
            'title'      => esc_html__( 'Page Settings', 'lava' ),
            'post_types' => 'hb_room',
            'fields'     => $room_metabox_fields
        );
    }

    // offer metaboxes
    if ( class_exists( 'Lava_Custom_Post_Types' ) ) {

        $offer_metabox_fields = $common_metabox_fields;
        $offer_metabox_fields[] = array(
            'id'   => '_lava_page_layout',
            'name' => esc_html__( 'Page Layout', 'lava' ),
            'type' => 'image_select',
            'std' => 'half-width',
            'options' => array(
                '1' => LAVA_ADMIN_URI . '/assets/images/layouts/o1.png',
                '2' => LAVA_ADMIN_URI . '/assets/images/layouts/o2.png'
            )
        );
        
        $offer_metabox_fields[] = array(
            'id' => '_lava_page_container',
            'name' => esc_html__( 'Page Container', 'lava' ),
            'type' => 'select',
            'class' => 'lava_page_container',
            'std' => 'no_container',
            'options' => array(
                'container' => esc_html__( 'Container', 'lava' ),
                'no_container' => esc_html__( 'No Container', 'lava' ),
            )
        );

        $meta_boxes[] = array(
            'title' => esc_html__( 'Page Settings', 'lava' ),
            'post_types' => 'lava_offer',
            'fields' => $offer_metabox_fields
        );

        $meta_boxes[] = array(
            'title' => esc_html__( 'Offer Info', 'lava' ),
            'post_types' => 'lava_offer',
            'fields' => array(
                array(
                    'id' => '_lava_offer_price',
                    'name' => esc_html__( 'Offer Price', 'lava' ),
                    'type' => 'text',
                    'size' => 30,
                ),
                array(
                    'id' => '_lava_offer_price_unit',
                    'name' => esc_html__( 'Offer Price Unit', 'lava' ),
                    'description' => esc_html__( 'e.g. Per Person', 'lava' ),
                    'type' => 'text',
                    'size' => 30,
                )
            )
        );
    }

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'lava_meta_boxes' );


function lava_get_metabox_sidebars() {
    global $wp_registered_sidebars, $lava_metabox_sidebars;

    if ( isset( $lava_metabox_sidebars ) ) {
        return $lava_metabox_sidebars;
    }

    $sidebars['default'] = esc_html__( 'Default', 'lava' );

    if ( !empty( $wp_registered_sidebars ) ) {
        foreach ( $wp_registered_sidebars as $sidebar ) {
            if ( $sidebar['id'] == 'footer-1'
                || $sidebar['id'] == 'footer-2'
                || $sidebar['id'] == 'footer-3'
                || $sidebar['id'] == 'footer-4' ) {
                continue;
            }
            $sidebars[$sidebar['id']] = $sidebar['name'];
        }
    } else {
        $sidebars['default-sidebar'] = esc_html__( 'Default Sidebar', 'lava' );
    }
    $lava_metabox_sidebars = $sidebars;

    return $sidebars;
}
