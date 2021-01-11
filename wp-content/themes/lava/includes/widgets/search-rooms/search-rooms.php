<?php

/*
Widget Name: Lava Search Rooms
Description: Display the form for search rooms.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Search_Rooms_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-search-rooms',
            esc_html__( 'Lava Search Rooms', 'lava' ),
            array(
                'description' => esc_html__( 'Display the form for search rooms.', 'lava' ),
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

                'show_label' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Labels', 'lava' ),
                    'default' => false
                ),

                'default_dates' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Set Default Check in & Check out date', 'lava' ),
                    'default' => true
                ),

                'show_children' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Children Field', 'lava' ),
                    'default' => true
                ),

                'show_price' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Room Price', 'lava' ),
                    'description' => esc_html__( 'Only shows on single room page.', 'lava' ),
                    'default' => false
                ),

                'show_contact_info' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show Contact Info', 'lava' ),
                    'default' => false
                ),

                'contact_info' => array(
                    'type' => 'tinymce',
                    'label' => esc_html__( 'Contact Info', 'lava' ),
                    'default' => ''
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
        // $this->register_frontend_styles( array(
        //     array(
        //         'lava',
        //         LAVA_THEME_URI . '/assets/css/style'. LAVA_MIN_SUFFIX .'.css',
        //         false,
        //         LAVA_THEME_VERSION
        //     )
        // ));
    }

    function get_template_variables( $instance, $args ) {
        $show_label = isset( $instance['show_label'] ) && $instance['show_label'] ? 'true' : 'false';
        $default_dates = isset( $instance['default_dates'] ) && $instance['default_dates'] ? '1' : '0';
        $show_children = isset( $instance['show_children'] ) && $instance['show_children'] ? '1' : '0';
        $show_price = isset( $instance['show_price'] ) && $instance['show_price'] ? 1 : 0;
        $show_contact_info = isset( $instance['show_contact_info'] ) && $instance['show_contact_info'] ? 1 : 0;
        $contact_info = !empty( $instance['contact_info'] ) ? $instance['contact_info'] : '';

        return array(
            'title' => $instance['title'],
            'show_label' => $show_label,
            'show_children' => $show_children,
            'default_dates' => $default_dates,
            'show_price' => $show_price,
            'show_contact_info' => $show_contact_info,
            'contact_info' => $contact_info,
        );
    }

}

siteorigin_widget_register( 'lava-search-rooms', __FILE__, 'Lava_Search_Rooms_Widget' );