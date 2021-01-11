<?php

/*
Widget Name: Lava List
Description: Display list items.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_List_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-list',
            esc_html__( 'Lava List', 'lava' ),
            array(
                'description' => esc_html__( 'Display list items.', 'lava' ),
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
                
                'items' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'List Items', 'lava' ),
                    'item_name' => esc_html__( 'Item', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='list-text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),

                    'fields' => array(

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Icon Type', 'lava' ),
                            'default' => 'none',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array( 'icon_type' )
                            ),
                            'options' => array(
                                'none' => esc_html__( 'None', 'lava' ),
                                'icon' => esc_html__( 'Icon', 'lava' ),
                                'icon_image' => esc_html__( 'Icon Image', 'lava' ),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Image Icon', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array( 'show' ),
                                '_else[icon_type]' => array( 'hide' ),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => esc_html__( 'Icon', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon]' => array( 'show' ),
                                '_else[icon_type]' => array( 'hide' ),
                            )
                        ),

                        'icon_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Icon Color', 'lava' ),
                        ),

                        'text' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Text', 'lava' )
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
                            'default' => 0,
                            'label' => esc_html__( 'Equal Content Height', 'lava' ),
                            'description' => esc_html__( 'This will make the contents in this row have the same height.', 'lava' ),
                        )
                    )
                ),
            )
        );
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
            'items' => !empty( $instance['items'] ) ? $instance['items'] : array()
        );
    }

}

siteorigin_widget_register( 'lava-list', __FILE__, 'Lava_List_Widget' );