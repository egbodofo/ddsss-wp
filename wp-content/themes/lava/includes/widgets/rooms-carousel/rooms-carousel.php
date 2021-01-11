<?php

/*
Widget Name: Lava Rooms Carousel
Description: Display rooms slider.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Rooms_Carousel_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-rooms-carousel',
            esc_html__( 'Lava Rooms Carousel', 'lava' ),
            array(
                'description' => esc_html__( 'Display rooms slider.', 'lava' ),
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

                'rooms' => array(
                    'type' => 'number',
                    'label' => esc_html__( 'Number of rooms to show', 'lava' ),
                    'default' => 10,
                ),

                'number' => array(
                    'type' => 'number',
                    'label' => esc_html__( 'Number of items', 'lava' ),
                    'default' => 4
                ),

                'nav' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Navigation', 'lava' ),
                    'default' => false
                ),

                'pagination' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Pagination', 'lava' ),
                    'default' => true
                ),

                'card_style' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Card Style', 'lava' ),
                    'default' => false,
                ),

                'text_link' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Text link', 'lava' ),
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
        $nav = isset( $instance['nav'] ) && $instance['nav'] ? 'true' : 'false';
        $pagination = isset( $instance['pagination'] ) && $instance['pagination'] ? 'true' : 'false';
        $card_style = isset( $instance['card_style'] ) && $instance['card_style'] ? 'true' : 'false';

        return array(
            'title' => $instance['title'],
            'rooms' => isset( $instance['rooms'] ) ? (int) $instance['rooms'] : 10,
            'number' => isset( $instance['number'] ) ? (int) $instance['number'] : 4,
            'nav' => $nav,
            'pagination' => $pagination,
            'text_link' => $instance['text_link'],
            'card_style' => $card_style,
        );
    }

}

siteorigin_widget_register( 'lava-rooms-carousel', __FILE__, 'Lava_Rooms_Carousel_Widget' );