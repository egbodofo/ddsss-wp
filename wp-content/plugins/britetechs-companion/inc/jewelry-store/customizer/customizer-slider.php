<?php
function jewelry_store_customizer_slider( $wp_customize ){

	$option = jewelry_store_reset_data();

	$wp_customize->add_panel( 'slider_panel',
		array(
			'priority'       => 131,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Home Page: Slider', 'jewelry-store' ),
			'description'    => '',
		)
	);
		$wp_customize->add_section( 'slider_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Slider Settings', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'slider_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[slider_enable]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['slider_enable'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_enable]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Slider Enable', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
				)
			);

			// layout
            $wp_customize->add_setting( 'jewelrystore_option[slider_layout]',
                array(
                    'sanitize_callback' => 'jewelry_store_sanitize_select',
                    'default'           => $option['slider_layout'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[slider_layout]',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Layout', 'jewelry-store'),
                    'section'     => 'slider_settings',
                    'description' => '',
                    'choices' => array(
                    	'layout1'=> __('Layout 1','jewelry-store'),
                    	),
                )
            );

			$wp_customize->add_setting( 'jewelrystore_option[slider_arrow_show]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['slider_arrow_show'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_arrow_show]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Slider Arrow Hide/Show', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
				)
			);

			$wp_customize->add_setting( 'jewelrystore_option[slider_pagination_show]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['slider_pagination_show'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_pagination_show]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Slider Pagination Hide/Show', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
				)
			);

			$wp_customize->add_setting( 'jewelrystore_option[slider_mouse_drag]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['slider_mouse_drag'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_mouse_drag]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Slider Mouse Drag Enable Feature', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
				)
			);

			$wp_customize->add_setting( 'jewelrystore_option[slider_smart_speed]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_select',
					'default'           => $option['slider_smart_speed'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_smart_speed]',
				array(
					'type'        => 'select',
					'label'       => esc_html__('Slider Smart Speed', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
					'choices' => array(
						100 => 100,
						500 => 500,
						1000 => 1000,
						1500 => 1500,
						2000 => 2000,
						2500 => 2500,
						3000 => 3000,
						3500 => 3500,
						4000 => 4000,
						4500 => 4500,
						5000 => 5000,
						)
				)
			);

			$wp_customize->add_setting( 'jewelrystore_option[slider_scroll_speed]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_select',
					'default'           => $option['slider_scroll_speed'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_scroll_speed]',
				array(
					'type'        => 'select',
					'label'       => esc_html__('Slider Scroll Speed', 'jewelry-store'),
					'section'     => 'slider_settings',
					'description' => '',
					'choices' => array(
						100 => 100,
						500 => 500,
						1000 => 1000,
						1500 => 1500,
						2000 => 2000,
						2500 => 2500,
						3000 => 3000,
						3500 => 3500,
						4000 => 4000,
						4500 => 4500,
						5000 => 5000,
						)
				)
			);

			// container width
            $wp_customize->add_setting( 'jewelrystore_option[slider_container_width]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['slider_container_width'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[slider_container_width]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Container Width', 'jewelry-store'),
                    'section'     => 'slider_settings',
                    'description' => '',
                    'choices' => array(
                    	'container'=> __('Container','jewelry-store'),
                    	'container-fluid'=> __('Container Full','jewelry-store')
                    	),
                )
            );

		$wp_customize->add_section( 'slider_images_section' ,
			array(
				'priority'    => 2,
				'title'       => esc_html__( 'Slider Background Images', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'slider_panel',
			)
		);
			$wp_customize->add_setting(
				'jewelrystore_option[slider_images]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
					'type' => 'option',
					'default' => json_encode( array(
						array(
							'image'=> array(
								'url' => get_template_directory_uri().'/images/slide1.jpg',
								'id' => ''
							),
							'large_text'=> __('Welcome To jewelry Store Pro Theme','jewelry-store'),
							'small_text'=> __('Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet.','jewelry-store'),
							'btn_text'=> __('Buy Now','jewelry-store'),
							'btn_link'=> '#',
							'btn_target'=> true,
						)
					) )
				) );

			$wp_customize->add_control(
				new Jewelry_Store_Customize_Repeatable_Control(
					$wp_customize,
					'jewelrystore_option[slider_images]',
					array(
						'label'     => esc_html__('Background Images', 'jewelry-store'),
						'description'   => '',
						'priority'     => 40,
						'section'       => 'slider_images_section',
						'live_title_id' => 'large_text',
						'title_format'  => esc_html__( '[live_title]', 'jewelry-store'), // [live_title]
						'max_item'      => 2,
						'limited_msg'   => wp_kses_post( __('<a target="_blank" href="'.esc_url('https://britetechs.com/jewelry-store-pro-wordpress-theme/').'">Upgrade to PRO</a>', 'jewelry-store' ) ),
						'fields'    => array(
							'image' => array(
								'title' => esc_html__('Background Image', 'jewelry-store'),
								'type'  =>'media',
								'default' => array(
									'url' => get_template_directory_uri().'/images/slide1.jpg',
									'id' => ''
								)
							),
							'large_text' => array(
								'title' => esc_html__('Large Text', 'jewelry-store'),
								'type'  =>'textarea',
								'default' => __('Welcome To jewelry Store Pro Theme','jewelry-store'),
							),
							'small_text' => array(
								'title' => esc_html__('Small Text', 'jewelry-store'),
								'type'  =>'textarea',
								'default' => __('Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet.','jewelry-store'),
							),
							'btn_text' => array(
								'title' => esc_html__('Read More Button Text', 'jewelry-store'),
								'type'  =>'text',
								'default' => __('Buy Now','jewelry-store'),
							),
							'btn_link' => array(
								'title' => esc_html__('Read More Button Link', 'jewelry-store'),
								'type'  =>'text',
								'default' => '#',
							),
							'btn_target' => array(
								'title' => esc_html__('Open in new tab', 'jewelry-store'),
								'type'  =>'checkbox',
								'default' => true,
							),
							'content_align' => array(
								'title' => esc_html__('Content Text Alignment', 'jewelry-store'),
								'type'  =>'select',
								'default' => 'left',
								'options' => array(
									'left' => __('Left','jewelry-store'),
									'center' => __('Center','jewelry-store'),
									'right' => __('Right','jewelry-store'),
									)
							),

						),

					)
				)
			);

			$wp_customize->add_setting( 'jewelrystore_option[slider_overlay_color]',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default'           => $option['slider_overlay_color'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jewelrystore_option[slider_overlay_color]',
				array(
					'label'       => esc_html__('Overlay Color', 'jewelry-store'),
					'section'     => 'slider_images_section',
					'description' => '',
				)
			) );

			$wp_customize->add_setting( 'jewelrystore_option[slider_overlay_color_opacity]',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $option['slider_overlay_color_opacity'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[slider_overlay_color_opacity]',
				array(
					'type' => 'number',
					'label'       => esc_html__('Overlay Color Opacity', 'jewelry-store'),
					'section'     => 'slider_images_section',
					'description' => '',
					'input_attrs' => array(
			            'min' => '0', 'step' => '0.1', 'max' => '1',
			          ),
				)
			);
}
add_action('customize_register','jewelry_store_customizer_slider');