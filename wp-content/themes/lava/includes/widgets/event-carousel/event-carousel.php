<?php

/*
Widget Name: Lava Event Carousel
Description: Display events in carousel.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Event_Carousel_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-event-carousel',
            esc_html__( 'Lava Event Carousel', 'lava' ),
            array(
                'description' => esc_html__( 'Display event posts in carousel.', 'lava' ),
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

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'hide' => true,
                    'fields' => array(
                       'display' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Display', 'lava' ),
                            'default' => 'list',
                            'options' => array(
                                'list' => esc_html__( 'Upcoming Events', 'lava' ),
                                'past' => esc_html__( 'Past Events', 'lava' ),
                                'future' => esc_html__( 'Future Events', 'lava' ),
                                'custom' => esc_html__( 'Custom', 'lava' )
                            )
                        ),
                        
                        'start_date' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Start Date', 'lava' ),
                            'description' => 'e.g. 2018-01-01 00:00'
                        ),
                        
                        'end_date' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'End Date', 'lava' ),
                            'description' => 'e.g. 2018-12-31 23:00'
                        ),
                        
                        'featured' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Featured Events Only', 'lava' )
                        ),

                        'number' => array(
                            'type' => 'slider',
                            'label' => esc_html__( 'Number of events to show', 'lava' ),
                            'min' => 1,
                            'max' => 20,
                            'integer' => true,
                            'default' => 4
                        )
                    )
                ),

                'autoplay' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Autoplay', 'lava' ),
                ),

                'speed' => array(
                    'type' => 'number',
                    'label' => esc_html__( 'Autoplay Speed ( Seconds )', 'lava' ),
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

    function initialize(){
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

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
            'display' => !empty( $instance['settings']['display'] ) ? $instance['settings']['display'] : 'list',
            'start_date' => !empty( $instance['settings']['start_date'] ) ? $instance['settings']['start_date'] : '',
            'end_date' => !empty( $instance['settings']['end_date'] ) ? $instance['settings']['end_date'] : '',
            'featured' => !empty( $instance['settings']['featured'] ) ? (bool)$instance['settings']['featured'] : false,
            'number' => !empty( $instance['settings']['number'] ) ? $instance['settings']['number'] : 4,
        );
    }
}

siteorigin_widget_register( 'lava-event-carousel', __FILE__, 'Lava_Event_Carousel_Widget' );