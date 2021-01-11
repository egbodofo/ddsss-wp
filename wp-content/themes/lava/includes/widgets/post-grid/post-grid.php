<?php

/*
Widget Name: Lava Post Grid
Description: Display posts in grids.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Post_Grid_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-post-grid',
            esc_html__( 'Lava Post Grid', 'lava' ),
            array(
                'description' => esc_html__( 'Display rooms in grids.', 'lava' ),
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

                        'columns' => array(
                            'type' => 'slider',
                            'label' => esc_html__( 'Columns Per Row', 'lava' ),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 3
                        ),

                        'attachment_size' => array(
                            'label' => esc_html__( 'Image size', 'lava' ),
                            'type' => 'image-size',
                            'default' => 'lava_thumb_small',
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
            'title' => $instance['title']
        );
    }
}

siteorigin_widget_register( 'lava-post-grid', __FILE__, 'Lava_Post_Grid_Widget' );