<?php

/*
Widget Name: Lava Amenities
Description: Display amenity list.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Amenities_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-amenities',
            esc_html__( 'Lava Amenities', 'lava' ),
            array(
                'description' => esc_html__( 'Display amenity list.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus',
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

                'amenities' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Amenities', 'lava' ),
                    'item_name' => esc_html__( 'Amenity', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='amenities-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),

                    'fields' => array(

                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Title', 'lava' )
                        ),

                        'description' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Description', 'lava' )
                        ),
                    )
                ),

                'layout' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Layout', 'lava' ),
                    'hide' => true,
                    'fields' => array(

                        'container' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Container', 'lava' ),
                            'options' => array(
                                '' => esc_html__( 'Default', 'lava' ),
                                'full' => esc_html__( 'Container Full Width', 'lava' ),
                                'half' => esc_html__( 'Container Half Width', 'lava' ),
                                'fluid' => esc_html__( 'Container Full Without Top & Bottom Padding', 'lava' )
                            )
                        ),

                        'height' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Content Height', 'lava' ),
                            'description' => esc_html__( 'Set minimum content height', 'lava' ),
                            'default' => '',
                        ),

                        'equal_height' => array(
                            'type' => 'checkbox',
                            'default' => true,
                            'label' => esc_html__( 'Equal Content Height', 'lava' ),
                            'description' => esc_html__( 'This will make the contents in this row have the same height.', 'lava' ),
                        )
                    )
                ),
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
        $this->register_frontend_scripts( array(
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/js/widgets'. LAVA_MIN_SUFFIX .'.js',
                array( 'jquery' ),
                LAVA_THEME_VERSION,
                true
            )
        ));
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
            'amenities' => !empty( $instance['amenities'] ) ? $instance['amenities'] : array()
        );
    }

}

siteorigin_widget_register( 'lava-amenities', __FILE__, 'Lava_Amenities_Widget' );