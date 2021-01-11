<?php

/*
Widget Name: Lava Offers
Description: Display offer posts in grids.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Offers_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-offers',
            esc_html__( 'Lava Offers', 'lava' ),
            array(
                'description' => esc_html__( 'Display offer posts in grids.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Title', 'lava' ),
                    'hide' => false,
                    'fields' => array(
                        'text' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Title', 'lava' ),
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Color', 'lava' ),
                        ),

                        'align' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Alignment', 'lava' ),
                            'default' => 'left',
                            'options' => array(
                                'left' => esc_html__( 'Left', 'lava' ),
                                'right' => esc_html__( 'Right', 'lava' ),
                                'center' => esc_html__( 'Center', 'lava' ),
                            ),
                        )
                    )
                ),

                'query' => array(
                    'type' => 'posts',
                    'label' => esc_html__( 'Posts Query', 'lava' ),
                )
            )
        );
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
        );
    }
}

siteorigin_widget_register( 'lava-offers', __FILE__, 'Lava_Offers_Widget' );