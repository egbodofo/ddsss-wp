<?php

/*
Widget Name: Lava Post Carousel
Description: Display your posts as a carousel.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Post_Carousel_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-post-carousel',
            esc_html__( 'Lava Post Carousel', 'lava' ),
            array(
                'description' => esc_html__( 'Display your posts as a carousel.', 'lava' ),
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
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'fields' => array(
                        'autoplay' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Autoplay', 'lava' ),
                        ),

                        'speed' => array(
                            'type' => 'number',
                            'label' => esc_html__( 'Autoplay Speed ( Seconds )', 'lava' ),
                        ),

                        'date' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Post Date', 'lava' ),
                            'default' => 1
                        ),

                        'excerpt_length' => array(
                            'type' => 'number',
                            'label' => esc_html__( 'Excerpt Length ( Number of characters )', 'lava' ),
                            'description' => esc_html__( 'Leave empty to hide the excerpt.', 'lava' ),
                            'default' => 100
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
        );
    }
}

siteorigin_widget_register( 'lava-post-carousel', __FILE__, 'Lava_Post_Carousel_Widget' );