<?php

/*
Widget Name: Lava Rooms Grid
Description: Display room posts in grids.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Rooms_Grid_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-rooms-grid',
            esc_html__( 'Lava Rooms Grid', 'lava' ),
            array(
                'description' => esc_html__( 'Display rooms in grids.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
            ),
            array(),
            array(

                'query' => array(
                    'type' => 'posts',
                    'label' => esc_html__( 'Rooms Query', 'lava' ),
                ),
                'excerpt' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Room Excerpt', 'lava' ),
                    'default' => false
                ),
                'price' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Room Price', 'lava' ),
                    'default' => true
                )
            )
        );
    }

    function initialize() {
        $this->register_frontend_styles( array(
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/css/widgets'. LAVA_MIN_SUFFIX .'.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
    }
}

siteorigin_widget_register( 'lava-rooms-grid', __FILE__, 'Lava_Rooms_Grid_Widget' );