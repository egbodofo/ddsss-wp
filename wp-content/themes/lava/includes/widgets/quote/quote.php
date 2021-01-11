<?php

/*
Widget Name: Lava Quote
Description: Quote widget.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Quote_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-quote',
            esc_html__( 'Lava Quote', 'lava' ),
            array(
                'description' => esc_html__( 'Quote widget.', 'lava' ),
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

                'quote' => array(
                    'type' => 'tinymce',
                    'rows' => 12,
                ),

                'by' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Quote by', 'lava' ),
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
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
            'quote' => $instance['quote'],
            'by' => $instance['by'],
        );
    }

}

siteorigin_widget_register( 'lava-quote', __FILE__, 'Lava_Quote_Widget' );