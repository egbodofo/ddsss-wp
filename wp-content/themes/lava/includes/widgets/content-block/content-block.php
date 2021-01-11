<?php

/*
Widget Name: Lava Content Block
Description: Content block widget.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Content_Block_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-content-block',
            esc_html__( 'Lava Content Block', 'lava' ),
            array(
                'description' => esc_html__( 'Content block widget.', 'lava' ),
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

                'content' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Content', 'lava' ),
                    'hide' => false,
                    'fields' => array(
                        'style' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Content Style', 'lava' ),
                            'default' => 'content',
                            'options' => array(
                                'left_text' => esc_html__( 'Image with left content', 'lava' ),
                                'right_text' => esc_html__( 'Image with right content', 'lava' ),
                                'text' => esc_html__( 'Only content', 'lava' ),
                            )
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'rows' => 12,
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Image', 'lava' ),
                        ),

                        'image_size' => array(
                            'type' => 'image-size',
                            'label' => esc_html__( 'Image size', 'lava'),
                        ),
                    )
                ),

                'attributes' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Attributes', 'lava' ),
                    'hide' => true,
                    'fields' => array(
                        'classes' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Extra CSS Class', 'lava' )
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
            'style' => $instance['content']['style'],
            'text' => $instance['content']['text'],
            'image' => $instance['content']['image'],
            'image_size' => $instance['content']['image_size'],
            'classes' => $instance['attributes']['classes'],
        );
    }

}

siteorigin_widget_register( 'lava-content-block', __FILE__, 'Lava_Content_Block_Widget' );