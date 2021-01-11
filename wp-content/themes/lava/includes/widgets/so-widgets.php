<?php

class Lava_SiteOrigin_Widgets {

    static $theme_widgets = array( 
            'accordion' => true,
            'amenities' => true,
            'amenities-icons' => true,
            'booking-form' => true,
            'button' => true,
            'content-block' => true,
            'divider' => true,
            'editor' => true,
            'event-carousel' => true,
            'heading' => true,
            'image-grid' => true,
            'image' => true,
            'list' => true,
            'offers' => true,
            'post-carousel' => true,
            'post-grid' => true,
            'post-list' => true,
            'quote' => true,
            'rooms-carousel' => true,
            'rooms-slider' => true,
            'room-gallery' => true,
            'rooms-grid' => true,
            'search-rooms' => true,
            'services' => true,
            'social-buttons' => true,
            'tabs' => true,
            'testimonials' => true,
            'toggles' => true,
    );

    function __construct() {
        add_filter( 'siteorigin_widgets_widget_folders', array( $this, 'add_widgets_collection' ) );
        add_filter( 'siteorigin_panels_widget_dialog_tabs', array( $this, 'add_widget_tabs' ), 20 );
        add_filter( 'siteorigin_panels_widgets', array( $this, 'add_bundle_groups' ), 11 );
        add_filter( 'siteorigin_widgets_default_active', array( $this, 'default_active_widgets' ) );

        add_filter( 'siteorigin_panels_row_style_fields', array( $this, 'row_style_fields' ) );
        add_filter( 'siteorigin_panels_row_style_attributes', array( $this, 'row_style_attributes' ), 10, 2 );

        add_filter( 'siteorigin_panels_css_object', array( $this, 'filter_css_object' ), 10, 3 );
        add_filter( 'siteorigin_widgets_widget_banner', array( $this, 'widget_banner' ), 10, 2 );
    }

    function default_active_widgets( $default_widgets ) {
        return wp_parse_args( self::$theme_widgets, $default_widgets );
    } 

    function row_style_fields( $fields ) {

        /* Add design fields */

        $fields['lava_dark_background'] = array( 
            'name' => esc_html__( 'Dark Background?', 'lava' ),
            'type' => 'checkbox',
            'group' => 'design',
            'label' => esc_html__( 'Indicate if this row has a dark background color. Dark color scheme will be applied for all widgets in this row.', 'lava' ),
            'default' => false,
            'priority' => 4,
        );

        $fields['lava_container'] = array( 
            'name' => esc_html__( 'Container', 'lava' ),
            'type' => 'select',
            'group' => 'layout',
            'priority' => 4,
            'options' => array(
                '' => esc_html__( 'Default', 'lava' ),
                'full' => esc_html__( 'Container Full Width', 'lava' ),
                'half' => esc_html__( 'Container Half Width', 'lava' ),
                'fluid' => esc_html__( 'Container Fluid', 'lava' )
            )
        );

        return $fields;
    }

    function row_style_attributes( $attributes, $args ) {

        if ( !empty( $args['lava_dark_background'] ) ) {
            if ( empty( $attributes['class'] ) )
                $attributes['class'] = array();

            $attributes['class'][] = 'lava-dark-background';
        }

        if ( !empty( $args['lava_container'] ) ) {
            if ( empty( $attributes['class'] ) )
                $attributes['class'] = array();

            $attributes['class'][] = 'container-'. $args['lava_container'];
        }

        return $attributes;
    }

    function filter_css_object( $css, $panels_data, $post_id ) {

        foreach ( $panels_data['grids'] as $gi => $grid ) {

            $grid_id = !empty( $grid['style']['id'] ) ? ( string ) sanitize_html_class( $grid['style']['id'] ) : intval( $gi );
        }

        return $css;
    }

    function add_widgets_collection( $folders ) {
        $folders[] = LAVA_THEME_DIR . '/includes/widgets/';
        return $folders;
    }

    // Placing all widgets under the 'SiteOrigin Widgets' Tab
    function add_widget_tabs( $tabs ) {
        $tabs[] = array(
            'title' => esc_html__( 'Lava Widgets', 'lava' ),
            'filter' => array( 
                'groups' => array( 'lava-widgets' )
            )
        );
        return $tabs;
    }

    // Adding group for all Widgets
    function add_bundle_groups( $widgets ) {
        foreach ( $widgets as $class => &$widget ) {
            if ( preg_match( '/Lava_(.*)_Widget/', $class, $matches ) ) {
                $widget['groups'] = array( 'lava-widgets' );
            }
        }
        return $widgets;
    }

    function widget_banner( $banner = '', $widget = array() ) {
        if ( isset( $widget['Author'] ) && $widget['Author'] == 'ThemeSpirit' ) {
            return '';
        }
        return $banner;
    }
}

new Lava_SiteOrigin_Widgets;