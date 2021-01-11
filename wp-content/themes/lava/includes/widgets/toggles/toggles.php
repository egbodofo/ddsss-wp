<?php

/*
Widget Name: Lava Toggles
Description: Display toggle contents.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Toggles_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-toggles',
            esc_html__( 'Lava Toggles', 'lava' ),
            array(
                'description' => esc_html__( 'Display tabbed content in variety of styles.', 'lava' ),
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

                'toggles' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Toggles', 'lava' ),
                    'item_name' => esc_html__( 'Single Toggle', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='toggles-toggle_title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'toggle_title' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Toggle Title', 'lava' )
                        ),

                        'toggle_content' => array(
                            'type' => 'tinymce',
                            'label' => esc_html__( 'Toggle Content', 'lava' )
                        ),

                        'toggle_active' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Toggle Content', 'lava' ),
                            'default' => false
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
                        )
                    )
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
            ),
            array(
                'material-icons',
                LAVA_THEME_URI . '/assets/css/material-icons.min.css',
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

    function get_template_variables($instance, $args) {
        return array(
            'title' => $instance['title'],
            'toggles' => !empty($instance['toggles']) ? $instance['toggles'] : array()
        );
    }

}

siteorigin_widget_register( 'lava-toggles', __FILE__, 'Lava_Toggles_Widget' );