<?php

/*
Widget Name: Lava Tabs
Description: Display tabbed content in variety of styles.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Tabs_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-tabs',
            esc_html__( 'Lava Tabs', 'lava' ),
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

                'nav_style' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Nav Style', 'lava' ),
                    'default' => 'horizontal',
                    'options' => array(
                        'horizontal' => esc_html__( 'Horizontal', 'lava' ),
                        'vertical' => esc_html__( 'Vertical', 'lava' )
                    )
                ),

                'tabs' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Tabs', 'lava' ),
                    'item_name' => esc_html__( 'Single Tab', 'lava' ),
                    'item_label' => array(
                        'selector' => "[id*='tabs-tab_title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'tab_title' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Tab Title', 'lava' ),
                            'description' => esc_html__( 'The title for the tab shown as name for tab navigation.', 'lava' ),
                        ),

                        'tab_content' => array(
                            'type' => 'tinymce',
                            'label' => esc_html__( 'Tab Content', 'lava' ),
                            'description' => esc_html__( 'The content of the tab.', 'lava' ),
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
            'title' => $instance['title'],
            'nav_style' => $instance['nav_style'],
            'tabs' => !empty($instance['tabs']) ? $instance['tabs'] : array()
        );
    }

}

siteorigin_widget_register( 'lava-tabs', __FILE__, 'Lava_Tabs_Widget' );