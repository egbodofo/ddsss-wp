<?php

/*
Widget Name: Lava Heading
Description: Create heading for display on the top of a section.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Heading_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-heading',
            esc_html__( 'Lava Heading', 'lava' ),
            array(
                'description' => esc_html__( 'Create heading for display on the top of a section.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
            ),
            array(),
            array(
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Heading Text', 'lava' )
                ),

                'subtext' => array(
                    'type' => 'textarea',
                    'label' => esc_html__( 'Heading Subtitle', 'lava' )
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
                ),

                'top_image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Top Image', 'lava' )
                ),

                'bottom_image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Bottom Image', 'lava' )
                ),

                'design' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Design', 'lava' ),
                    'hide' => true,
                    'fields' => array(

                        'tag' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Heading HTML Tag', 'lava' ),
                            'default' => 'h3',
                            'options' => array(
                                'h1' => 'H1',
                                'h2' => 'H2',
                                'h3' => 'H3',
                                'h4' => 'H4',
                                'h5' => 'H5',
                                'h6' => 'H6',
                                'p' => esc_html__( 'Paragraph', 'lava' ),
                                'span' => 'span',
                                'div' => 'div',
                            )
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Text Color', 'lava' ),
                            'default' => '',
                        ),

                        'subtext_color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Subtext Color', 'lava' ),
                            'default' => '',
                        ),

                        'font_family' => array(
                            'type' => 'font',
                            'label' => esc_html__( 'Font Family', 'lava' ),
                        ),

                        'font_weight' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Font Weight', 'lava' ),
                            'description' => esc_html__( 'e.g. normal, bold, 600', 'lava' )
                        ),

                        'font_style' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Font Style', 'lava' ),
                            'default' => 'normal',
                            'options' => array(
                                'normal' => esc_html__( 'Normal', 'lava' ),
                                'italic' => esc_html__( 'Italic', 'lava' ),
                                'oblique' => esc_html__( 'Oblique', 'lava' ),
                                'initial' => esc_html__( 'Initial', 'lava' ),
                                'inherit' => esc_html__( 'Inherit', 'lava' ),
                            )
                        ),

                        'font_size' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Font Size', 'lava' ),
                        ),

                        'line_height' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Line height', 'lava' ),
                        ),

                        'letter_spacing' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Letter Spacing', 'lava' ),
                        ),

                        'text_transform' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Text Transform', 'lava' ),
                            'default' => 'none',
                            'options' => array(
                                'none' => esc_html__( 'None', 'lava' ),
                                'capitalize' => esc_html__( 'Capitalize', 'lava' ),
                                'uppercase' => esc_html__( 'Uppercase', 'lava' ),
                                'lowercase' => esc_html__( 'Lowercase', 'lava' )
                            )
                        )
                    ),
                ),

                'attributes' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Attributes', 'lava' ),
                    'hide' => true,
                    'fields' => array(
                        'classes' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Extra CSS Class', 'lava' ),
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
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'text' => $instance['text'],
            'subtext' => $instance['subtext'],
            'align' => $instance['align'],
            'top_image' => isset( $instance['top_image'] ) ? $instance['top_image'] : '',
            'bottom_image' => isset( $instance['bottom_image'] ) ? $instance['bottom_image'] : '',
            'tag' => $instance['design']['tag'],
            'color' => $instance['design']['color'],
            'subtext_color' => $instance['design']['subtext_color'],
            'font_family' => $instance['design']['font_family'],
            'font_weight' => $instance['design']['font_weight'],
            'font_size' => $instance['design']['font_size'],
            'font_style' => $instance['design']['font_style'],
            'letter_spacing' => $instance['design']['letter_spacing'],
            'line_height' => $instance['design']['line_height'],
            'text_transform' => $instance['design']['text_transform'],
            'design' => $instance['design'],
            'attributes' => $instance['attributes']
        );
    }

}

siteorigin_widget_register( 'lava-heading', __FILE__, 'Lava_Heading_Widget' );