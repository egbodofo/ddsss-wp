<?php

/*
Widget Name: Lava Accordion
Description: Display accordion contents.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Accordion_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-accordion',
            esc_html__( 'Lava Accordion', 'lava' ),
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

                'accordion' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Accordion', 'lava' ),
                    'item_name' => esc_html__( 'Single Accordion', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='accordion-accordion_title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'accordion_title' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Accordion Title', 'lava' )
                        ),

                        'accordion_content' => array(
                            'type' => 'tinymce',
                            'label' => esc_html__( 'Accordion Content', 'lava' )
                        ),

                        'accordion_active' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Active Item', 'lava' ),
                            'default' => false
                        )
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
            'accordion' => !empty($instance['accordion']) ? $instance['accordion'] : array()
        );
    }

}

siteorigin_widget_register( 'lava-accordion', __FILE__, 'Lava_Accordion_Widget' );