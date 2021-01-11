<?php
function jewelry_store_customizer_testimonial( $wp_customize ){

	$option = jewelry_store_reset_data();

	$wp_customize->add_panel( 'testimonial_panel',
		array(
			'priority'       => 136,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Home Page: Testimonial', 'jewelry-store' ),
			'description'    => '',
		)
	);
		$wp_customize->add_section( 'testimonial_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Testimonial Settings', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'testimonial_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[testimonial_enable]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['testimonial_enable'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[testimonial_enable]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Testimonial Enable', 'jewelry-store'),
					'section'     => 'testimonial_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[testimonial_title]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['testimonial_title'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[testimonial_title]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Title', 'jewelry-store'),
					'section'     => 'testimonial_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[testimonial_subtitle]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['testimonial_subtitle'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[testimonial_subtitle]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Subtitle', 'jewelry-store'),
					'section'     => 'testimonial_settings',
					'description' => '',
				)
			);
		$wp_customize->add_section( 'testimonial_content' ,
			array(
				'priority'    => 2,
				'title'       => esc_html__( 'Testimonial Contents', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'testimonial_panel',
			)
		);
			$wp_customize->add_setting(
				'jewelrystore_option[testimonial_contents]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
					'type' => 'option',
					'default' => json_encode( array(
						array(
							'image'=> array(
									'url' => '',
									'id' => ''
								),
							'title'=> '',
							'position'=> '',
							'desc'=> '',
							'link'=> '',
						)
					) )
				) );

			$wp_customize->add_control(
				new Jewelry_Store_Customize_Repeatable_Control(
					$wp_customize,
					'jewelrystore_option[testimonial_contents]',
					array(
						'label'     => esc_html__('Testimonial Content', 'jewelry-store'),
						'description'   => '',
						'priority'     => 40,
						'section'       => 'testimonial_content',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__('[live_title]', 'jewelry-store'), // [live_title]
						'max_item'      => 1,
						'limited_msg'   => wp_kses_post( __('<a target="_blank" href="'.esc_url('https://britetechs.com/jewelry-store-pro-wordpress-theme/').'">Upgrade to PRO</a>', 'jewelry-store' ) ),
						'fields'    => array(
							'image' => array(
								'title' => esc_html__('Client Image', 'jewelry-store'),
								'type'  =>'media',
								'default' => array(
									'url' => '',
									'id' => ''
								)
							),
							'title' => array(
								'title' => esc_html__('Client Name', 'jewelry-store'),
								'type'  =>'text',
								'default' => esc_html__('Client Name', 'jewelry-store'),
							),
							'position' => array(
								'title' => esc_html__('Designation', 'jewelry-store'),
								'type'  =>'text',
								'default' => esc_html__('Client Designation', 'jewelry-store'),
							),
							'desc' => array(
								'title' => esc_html__('Testimonial Content', 'jewelry-store'),
								'type'  =>'editor',
								'default' => esc_html__('Client Review Content', 'jewelry-store'),
							),
							'link' => array(
								'title' => esc_html__('Custom Link', 'jewelry-store'),
								'type'  =>'text',
								'default' => '#',
							),
					
						),

					)
				)
			);

			// container width
            $wp_customize->add_setting( 'jewelrystore_option[testimonial_container_width]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['testimonial_container_width'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[testimonial_container_width]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Container Width', 'jewelry-store'),
                    'section'     => 'testimonial_content',
                    'description' => '',
                    'choices' => array(
                    	'container'=> __('Container','jewelry-store'),
                    	'container-fluid'=> __('Container Full','jewelry-store')
                    	),
                )
            );

            // layout
            $wp_customize->add_setting( 'jewelrystore_option[testimonial_layout]',
                array(
                    'sanitize_callback' => 'jewelry_store_sanitize_select',
                    'default'           => $option['testimonial_layout'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[testimonial_layout]',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Layout', 'jewelry-store'),
                    'section'     => 'testimonial_content',
                    'description' => '',
                    'choices' => array(
                    	'layout1'=> __('Layout 1','jewelry-store'),
                    	),
                )
            );

            // column layout
            $wp_customize->add_setting( 'jewelrystore_option[testimonial_column]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['testimonial_column'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[testimonial_column]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Column Layout', 'jewelry-store'),
                    'section'     => 'testimonial_content',
                    'description' => '',
                    'choices' => array(
                    	2 => __('2 Column','jewelry-store'),
                    	3 => __('3 Column','jewelry-store'),
                    	4 => __('4 Column','jewelry-store'),
                    	),
                )
            );

        $wp_customize->add_section( 'testimonial_background' ,
			array(
				'priority'    => 2,
				'title'       => esc_html__( 'Testimonial Section Background', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'testimonial_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[testimonial_bg_image]',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $option['testimonial_bg_image'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( new wp_Customize_Image_Control( $wp_customize,'jewelrystore_option[testimonial_bg_image]',
				array(
					'label'       => esc_html__('Section Background Image', 'jewelry-store'),
					'section'     => 'testimonial_background',
					'description' => '',
				) )
			);
}
add_action('customize_register','jewelry_store_customizer_testimonial');