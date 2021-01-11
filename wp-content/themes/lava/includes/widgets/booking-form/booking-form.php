<?php

/*
Widget Name: Lava Booking Form
Description: Just a simple booking form
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Booking_Form_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-booking-form',
            esc_html__( 'Lava Booking Form', 'lava' ),
            array(
                'description' => esc_html__( 'Just a simple booking form.', 'lava' ),
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

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'hide' => false,
                    'fields' => array(
                        'popup' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Pop-up form', 'lava' ),
                            'default' => true
                        ),

                        'show_label' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Labels', 'lava' ),
                            'default' => true
                        ),

                        'max_guests' => array(
                            'type' => 'number',
                            'label' => esc_html__( 'Max Guests', 'lava' ),
                            'default' => 5
                        ),

                        'min_booking_days' => array(
                            'type' => 'number',
                            'label' => esc_html__( 'Minimum Booking Days', 'lava' ),
                            'default' => 1
                        ),

                        'room_types' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Room Types', 'lava' ),
                            'description' => esc_html__( 'Enter room names separated by comma. e.g. Single Room,Double Room', 'lava' ),
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

    function initialize() {
        $this->register_frontend_styles( array(
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/css/widgets'. LAVA_MIN_SUFFIX .'.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
    }

    function get_template_variables( $instance, $args ) {
        $popup = isset( $instance['settings']['popup'] ) && $instance['settings']['popup'] ? true : false;
        $show_label = isset( $instance['settings']['show_label'] ) && $instance['settings']['show_label'] ? true : false;
        $max_guests = isset( $instance['settings']['max_guests'] )  ? absint( $instance['settings']['max_guests'] ) : 5;
        $min_booking_days = !empty( $instance['settings']['min_booking_days'] ) ? absint( $instance['settings']['min_booking_days'] ) : 1;
        $room_types = !empty( $instance['settings']['room_types'] ) ? $instance['settings']['room_types'] : '';

        return array(
            'title' => $instance['title'],
            'popup' => $popup,
            'show_label' => $show_label,
            'max_guests' => $max_guests,
            'min_booking_days' => $min_booking_days,
            'room_types' => $room_types
        );
    }

}

siteorigin_widget_register( 'lava-booking-form', __FILE__, 'Lava_Booking_Form_Widget' );