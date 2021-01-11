<?php

/*
Widget Name: Lava Services
Description: Capture services in a multi-column grid.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Services_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-services',
            esc_html__( 'Lava Services', 'lava' ),
            array(
                'description' => esc_html__( 'Create services to display in a column grid.', 'lava' ),
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

                'services' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Services', 'lava' ),
                    'item_name' => esc_html__( 'Service', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='services-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),

                    'fields' => array(

                        'name' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Service Name', 'lava' )
                        ),

                        'description' => array(
                            'type' => 'textarea',
                            'label' => esc_html__( 'Short Description', 'lava' )
                        ),

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Choose Icon Type', 'lava' ),
                            'default' => 'icon',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array( 'icon_type' )
                            ),
                            'options' => array(
                                'icon' => esc_html__( 'Icon', 'lava' ),
                                'icon_image' => esc_html__( 'Icon Image', 'lava' ),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Service Image.', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array( 'show' ),
                                'icon_type[icon]' => array( 'hide' ),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => esc_html__( 'Service Icon.', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon]' => array( 'show' ),
                                'icon_type[icon_image]' => array( 'hide' ),
                            ),
                        ),

                        'url' => array(
                            'type' => 'link',
                            'label' => esc_html__( 'Target URL', 'lava' )
                        ),

                        'new_window' => array(
                            'type' => 'checkbox',
                            'default' => false,
                            'label' => __('Open in a new window', 'lava' )
                        )
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'fields' => array(

                        'columns' => array(
                            'type' => 'slider',
                            'label' => esc_html__( 'Columns Per Row', 'lava' ),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 3
                        ),

                        'icon_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Icon Color', 'lava' )
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
            'services' => !empty($instance['services']) ? $instance['services'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register( 'lava-services', __FILE__, 'Lava_Services_Widget' );