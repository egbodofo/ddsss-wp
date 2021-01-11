<?php
/*
Widget Name: Lava Image Grid
Description: Display a grid of images.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Image_Grid_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'lava-image-grid',
			esc_html__( 'Lava Image Grid', 'lava' ),
			array(
				'description' => esc_html__( 'Display a grid of images.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
			),
			array(),
			array(
				'items' => array(
					'type' => 'repeater',
					'label' => esc_html__( 'Images', 'lava' ),
					'item_label' => array(
						'selector'     => "[id*='title']"
					),
					'fields' => array(
						'image' => array(
							'type' => 'media',
							'label' => esc_html__( 'Image', 'lava')
						),
						'attachment_size' => array(
							'label' => esc_html__( 'Image size', 'lava' ),
							'type' => 'image-size',
							'default' => 'full',
						),
						'column_span' => array(
							'type' => 'slider',
							'label' => esc_html__( 'Column span', 'lava' ),
							'description' => esc_html__( 'Number of columns this item should span. (Limited to number of columns selected in Layout section below.)', 'lava' ),
							'min' => 1,
							'max' => 10,
							'default' => 1
						),
						'row_span' => array(
							'type' => 'slider',
							'label' => esc_html__( 'Row span', 'lava' ),
							'description' => esc_html__( 'Number of rows this item should span. (Limited to number of columns selected in Layout section below.)', 'lava' ),
							'min' => 1,
							'max' => 10,
							'default' => 1
						),
						'tags' => array(
							'type' => 'text',
							'label' => esc_html__( 'Tags', 'lava' ),
							'description' => esc_html__( 'Enter tags separated by comma. Used for sorting images.', 'lava' )
						),
						'title' => array(
							'type' => 'text',
							'label' => esc_html__( 'Title', 'lava' ),
						),
						'url' => array(
							'type' => 'link',
							'label' => esc_html__( 'Destination URL', 'lava' ),
						),
						'new_window' => array(
							'type' => 'checkbox',
							'default' => false,
							'label' => esc_html__( 'Open in a new window', 'lava' ),
						),
					)
				),
				'desktop_layout' => array(
					'type' => 'section',
					'label' => esc_html__( 'Desktop Layout', 'lava' ),
					'fields' => array(
						'columns' => array(
							'type' => 'slider',
							'label' => esc_html__( 'Number of columns', 'lava' ),
							'min' => 1,
							'max' => 10,
							'default' => 4
						),
						'row_height' => array(
							'type' => 'number',
							'label' => esc_html__( 'Row height', 'lava' ),
							'description' => esc_html__( 'Leave blank to match calculated column width.', 'lava' ),
							'default' => 0
						),
						'gutter' => array(
							'type' => 'number',
							'label' => esc_html__( 'Gutter', 'lava' ),
							'description' => esc_html__( 'Space between masonry items.', 'lava' ),
							'default' => 0
						)
					)
				),
				'tablet_layout' => array(
					'type' => 'section',
					'label' => esc_html__( 'Tablet Layout', 'lava' ),
					'hide' => true,
					'fields' => array(
						'break_point' => array(
							'type' => 'number',
							'lanel' => esc_html__( 'Break point', 'lava' ),
							'default' => 768
						),
						'columns' => array(
							'type' => 'slider',
							'label' => esc_html__( 'Number of columns', 'lava' ),
							'min' => 1,
							'max' => 10,
							'default' => 2
						),
						'row_height' => array(
							'type' => 'number',
							'label' => esc_html__( 'Row height', 'lava' ),
							'description' => esc_html__( 'Leave blank to match calculated column width.', 'lava' ),
							'default' => 0
						),
						'gutter' => array(
							'type' => 'number',
							'label' => esc_html__( 'Gutter', 'lava' ),
							'description' => esc_html__( 'Space between masonry items.', 'lava' ),
							'default' => 0
						)
					)
				),
				'mobile_layout' => array(
					'type' => 'section',
					'label' => esc_html__( 'Mobile Layout', 'lava' ),
					'hide' => true,
					'fields' => array(
						'break_point' => array(
							'type' => 'number',
							'lanel' => esc_html__( 'Break point', 'lava' ),
							'default' => 480
						),
						'columns' => array(
							'type' => 'slider',
							'label' => esc_html__( 'Number of columns', 'lava' ),
							'min' => 1,
							'max' => 10,
							'default' => 1
						),
						'row_height' => array(
							'type' => 'number',
							'label' => esc_html__( 'Row height', 'lava' ),
							'description' => esc_html__( 'Leave blank to match calculated column width.', 'lava' ),
							'default' => 0
						),
						'gutter' => array(
							'type' => 'number',
							'label' => esc_html__( 'Gutter', 'lava' ),
							'description' => esc_html__( 'Space between masonry items.', 'lava' ),
							'default' => 0
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
			),
			array(
				'fancybox',
				LAVA_THEME_URI . '/assets/css/fancybox.min.css'
			)
        ));
        $this->register_frontend_scripts( array(
            array(
                'isotope',
                LAVA_THEME_URI . '/assets/lib/js/isotope.pkgd.min.js',
                array( 'jquery' ),
                '3.0',
                true
            ),
            array(
                'fancybox',
                LAVA_THEME_URI . '/assets/lib/js/jquery.fancybox.min.js',
                array( 'jquery' ),
                LAVA_THEME_VERSION,
                true
            ),
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/js/widgets'. LAVA_MIN_SUFFIX .'.js',
                array( 'jquery' ),
                LAVA_THEME_VERSION,
                true
            )
        ));
    }

	public function get_template_variables( $instance, $args ) {
		$items = isset( $instance['items'] ) ? $instance['items'] : array();
		
		foreach ( $items as &$item ) {
			$link_atts = empty( $item['link_attributes'] ) ? array() : $item['link_attributes'];
			if ( ! empty( $item['new_window'] ) ) {
				$link_atts['target'] = '_blank';
				$link_atts['rel'] = 'noopener noreferrer';
			}
			$item['link_attributes'] = $link_atts;
		}
		
		return array(
			'args' => $args,
			'items' => $items,
			'layouts' => array(
				'desktop' => siteorigin_widgets_underscores_to_camel_case(
					array(
						'num_columns' => $instance['desktop_layout']['columns'],
						'row_height' => empty( $instance['desktop_layout']['row_height'] ) ? 0 : intval( $instance['desktop_layout']['row_height'] ),
						'gutter' => empty( $instance['desktop_layout']['gutter'] ) ? 0 : intval( $instance['desktop_layout']['gutter'] ),
					)
				),
				'tablet' => siteorigin_widgets_underscores_to_camel_case(
					array(
						'break_point' => $instance['tablet_layout']['break_point'],
						'num_columns' => $instance['tablet_layout']['columns'],
						'row_height' => empty( $instance['tablet_layout']['row_height'] ) ? 0 : intval( $instance['tablet_layout']['row_height'] ),
						'gutter' => empty( $instance['tablet_layout']['gutter'] ) ? 0 : intval( $instance['tablet_layout']['gutter'] ),
					)
				),
				'mobile' => siteorigin_widgets_underscores_to_camel_case(
					array(
						'break_point' => $instance['mobile_layout']['break_point'],
						'num_columns' => $instance['mobile_layout']['columns'],
						'row_height' => empty( $instance['mobile_layout']['row_height'] ) ? 0 : intval( $instance['mobile_layout']['row_height'] ),
						'gutter' => empty( $instance['mobile_layout']['gutter'] ) ? 0 : intval( $instance['mobile_layout']['gutter'] ),
					)
				),
			)
		);
	}
}

siteorigin_widget_register( 'lava-image-grid', __FILE__, 'Lava_Image_Grid_Widget');
