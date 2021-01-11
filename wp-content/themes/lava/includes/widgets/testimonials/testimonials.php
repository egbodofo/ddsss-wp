<?php

/*
Widget Name: Lava Testimonials
Description: Display testimonials from your clients/customers.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Testimonials_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-testimonials',
            esc_html__( 'Lava Testimonials', 'lava' ),
            array(
                'description' => esc_html__( 'Display testimonials in a responsive multi-column grid.', 'lava' ),
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
                        ),
                    )
                ),

                'testimonials' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Testimonials', 'lava' ),
                    'item_name' => esc_html__( 'Testimonial', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='testimonials-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),

                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Name', 'lava' ),
                            'description' => esc_html__( 'The author of the testimonial', 'lava' ),
                        ),

                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Author Details', 'lava' ),
                            'description' => esc_html__( 'The details of the author like company name, position held, company URL etc. HTML accepted.', 'lava' ),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Author Photo', 'lava' ),

                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => esc_html__( 'Text', 'lava' ),
                            'description' => esc_html__( 'What your customer had to say', 'lava' ),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'fields' => array(
                        'columns' => array(
                            'type' => 'slider',
                            'label' => esc_html__( 'Columns', 'lava' ),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 1
                        ),

                        'slider_speed' => array(
                            'type' => 'number',
                            'label' => esc_html__( 'Slideshow Speed', 'lava' ),
                            'description' => esc_html__( 'Slideshow speed in seconds', 'lava' ),
                            'default' => 4
                        ),

                        'slider_autoplay' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Slideshow Auto Play', 'lava' ),
                            'default' => true
                        ),

                        'background_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Background Color', 'lava' ),
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
            ),
            array(
                'material-icons',
                LAVA_THEME_URI . '/assets/css/material-icons.min.css',
                false,
                LAVA_THEME_VERSION
            ),
            array(
                'slick',
                LAVA_THEME_URI . '/assets/css/slick.min.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
        $this->register_frontend_scripts( array(
            array(
                'lava-sliders',
                LAVA_THEME_URI . '/assets/js/sliders'. LAVA_MIN_SUFFIX .'.js',
                array( 'jquery', 'slick' ),
                LAVA_THEME_VERSION,
                true
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'title' => $instance['title'],
            'testimonials' => !empty($instance['testimonials']) ? $instance['testimonials'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register( 'lava-testimonials', __FILE__, 'Lava_Testimonials_Widget' );