<?php

/*
Widget Name: Lava Button
Description: Button widget.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Button_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-button',
            esc_html__( 'Lava Button', 'lava' ),
            array(
                'description' => esc_html__( 'Button widget.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Title', 'lava' ),
                ),
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Button Text', 'lava' ),
                    'default' => esc_html__( 'Button', 'lava' ),
                ),

                'url' => array(
                    'type' => 'link',
                    'description' => esc_html__( 'The URL to which button should point to.', 'lava' ),
                    'label' => esc_html__( 'Target URL', 'lava' ),
                    'default' => 'http://',
                ),
                'new_window' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Open the link in new window', 'lava' ),
                    'default' => false,
                ),

                'align' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Alignment', 'lava' ),
                    'options' => array(
                        'inline' => esc_html__( 'Inline', 'lava' ),
                        'left' => esc_html__( 'Left', 'lava' ),
                        'right' => esc_html__( 'Right', 'lava' ),
                        'center' => esc_html__( 'Center', 'lava' ),
                    ),
                    'default' => 'inline'
                ),

                'design' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Design', 'lava' ),
                    'hide' => true,
                    'fields' => array(

                        'style' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Button Style', 'lava' ),
                            'options' => array(
                                'flat' => esc_html__( 'Flat', 'lava' ),
                                'linetop' => esc_html__( 'Line Top', 'lava' ),
                            )
                        ),

                        'size' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Button Size', 'lava' ),
                            'default' => 'medium',
                            'options' => array(
                                'small' => esc_html__( 'Small', 'lava' ),
                                'medium' => esc_html__( 'Medium', 'lava' ),
                                'large' => esc_html__( 'Large', 'lava' )
                            ),
                        ),

                        'width' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Width', 'lava' ),
                            'description' => esc_html__( 'Leave blank to let the button resize according to content.', 'lava' )
                        ),

                        'text_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Button Text Color', 'lava' ),
                        ),

                        'button_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Button Color', 'lava' ),
                        ),

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Icon Type', 'lava' ),
                            'default' => 'none',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array( 'icon_type' )
                            ),
                            'options' => array(
                                'none' => esc_html__( 'None', 'lava' ),
                                'icon' => esc_html__( 'Icon', 'lava' ),
                                'icon_image' => esc_html__( 'Icon Image', 'lava' ),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Image Icon', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array( 'show' ),
                                '_else[icon_type]' => array( 'hide' ),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => esc_html__( 'Icon', 'lava' ),
                            'state_handler' => array(
                                'icon_type[icon]' => array( 'show' ),
                                '_else[icon_type]' => array( 'hide' ),
                            )
                        )
                    ),
                ),

                'attributes' => array(
                    'type' => 'section',
                    'label' => esc_html__('Attributes', 'lava'),
                    'hide' => true,
                    'fields' => array(
                        'id' => array(
                            'type' => 'text',
                            'label' => esc_html__('Button ID', 'lava'),
                            'description' => esc_html__('An ID attribute allows you to target this button in Javascript.', 'lava'),
                        ),

                        'classes' => array(
                            'type' => 'text',
                            'label' => esc_html__('Button Classes', 'lava'),
                            'description' => esc_html__('Additional CSS classes added to the button link.', 'lava'),
                        ),

                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__('Title attribute', 'lava'),
                            'description' => esc_html__('Adds a title attribute to the button link.', 'lava'),
                        ),

                        'onclick' => array(
                            'type' => 'text',
                            'label' => esc_html__('Onclick', 'lava'),
                            'description' => esc_html__('Run this Javascript when the button is clicked. Ideal for tracking.', 'lava'),
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
            )
        ));
    }

    function get_style_name( $instance ) {
        if ( empty($instance['design']['style'] ) ) {
            return 'flat';
        }
        return $instance['design']['style'];
    }

    /**
     * Get the variables that we'll be injecting into the less stylesheet.
     *
     * @param $instance
     *
     * @return array
     */
    function get_less_variables( $instance ) {
        if ( empty( $instance ) || empty( $instance['design'] ) ) {
            return array();
        }

        $less_vars = array(
            'button_width' => isset( $instance['design']['width'] ) ? $instance['design']['width'] : '',
            'button_size' => isset( $instance['design']['size'] ) ? $instance['design']['size'] : 'medium',
            'button_color' => $instance['design']['button_color'],
            'text_color' => $instance['design']['text_color'],
        );

        return $less_vars;
    }
}

siteorigin_widget_register( 'lava-button', __FILE__, 'Lava_Button_Widget' );