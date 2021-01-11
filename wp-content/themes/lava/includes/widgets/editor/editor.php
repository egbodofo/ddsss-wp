<?php

/*
Widget Name: Lava Editor
Description: A widget which allows editing of content using the TinyMCE editor.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Editor_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'lava-editor',
			esc_html__( 'Lava Editor', 'lava' ),
			array(
				'description' => esc_html__( 'A rich-text, text editor.', 'lava' ),
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

				'text' => array(
					'type' => 'tinymce',
					'rows' => 20
				),

				'autop' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => esc_html__('Automatically add paragraphs', 'lava'),
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

                        'height' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Content Height', 'lava' ),
                            'description' => esc_html__( 'Set minimum content height', 'lava' ),
                            'default' => '',
                        ),

                        'equal_height' => array(
                            'type' => 'checkbox',
                            'default' => true,
                            'label' => esc_html__( 'Equal Content Height', 'lava' ),
                            'description' => esc_html__( 'This will make the contents in this row have the same height.', 'lava' ),
                        )
                    )
                ),
			)
		);
	}

	function unwpautop( $string ) {
		$string = str_replace( "<p>", "", $string );
		$string = str_replace( array( "<br />", "<br>", "<br/>" ), "\n", $string );
		$string = str_replace( "</p>", "\n\n", $string );

		return $string;
	}

	public function get_template_variables( $instance, $args ) {
		$instance = wp_parse_args(
			$instance,
			array(  'text' => '' )
	    );

		if (
			// Only run these parts if we're rendering for the frontend
			empty( $GLOBALS[ 'SITEORIGIN_PANELS_CACHE_RENDER' ] ) &&
			empty( $GLOBALS[ 'SITEORIGIN_PANELS_POST_CONTENT_RENDER' ] )
		) {
			if ( function_exists( 'wp_filter_content_tags' ) ) {
				$instance['text'] = wp_filter_content_tags( $instance['text'] );
			} else if ( function_exists( 'wp_make_content_images_responsive' ) ) {
				$instance['text'] = wp_make_content_images_responsive( $instance['text'] );
			}

			// Manual support for Jetpack Markdown module.
			if ( class_exists( 'WPCom_Markdown' ) &&
			     Jetpack::is_module_active( 'markdown' ) &&
			     $instance['text_selected_editor'] == 'html'
			) {
				$markdown_parser = WPCom_Markdown::get_instance();
				$instance['text'] = $markdown_parser->transform( $instance['text'] );
			}

			// Run some known stuff
			if ( ! empty( $GLOBALS['wp_embed'] ) ) {
				$instance['text'] = $GLOBALS['wp_embed']->run_shortcode( $instance['text'] );
				$instance['text'] = $GLOBALS['wp_embed']->autoembed( $instance['text'] );
			}

			if ( $instance['autop'] ) {
				$instance['text'] = wpautop( $instance['text'] );
			}

			$instance['text'] = do_shortcode( shortcode_unautop( $instance['text'] ) );
        }
        
		return array(
			'title' => $instance['title'],
			'text' => $instance['text'],
		);
    }

	function get_style_name( $instance ) {
		// We're not using a style
		return false;
	}
}

siteorigin_widget_register( 'lava-editor', __FILE__, 'Lava_Editor_Widget' );
