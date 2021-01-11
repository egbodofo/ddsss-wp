<?php
function jewelry_store_customizer_service( $wp_customize ){

	$option = jewelry_store_reset_data();

	$wp_customize->add_panel( 'service_panel',
		array(
			'priority'       => 132,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Home Page: Service', 'jewelry-store' ),
			'description'    => '',
		)
	);
		$wp_customize->add_section( 'service_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Service Settings', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'service_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[service_enable]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['service_enable'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[service_enable]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Service Enable', 'jewelry-store'),
					'section'     => 'service_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[service_title]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['service_title'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[service_title]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Title', 'jewelry-store'),
					'section'     => 'service_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[service_subtitle]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['service_subtitle'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[service_subtitle]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Subtitle', 'jewelry-store'),
					'section'     => 'service_settings',
					'description' => '',
				)
			);

		$wp_customize->add_section( 'service_content' ,
			array(
				'priority'    => 2,
				'title'       => esc_html__( 'Service Contents', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'service_panel',
			)
		);
			$wp_customize->add_setting(
				'jewelrystore_option[service_contents]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
					'type' => 'option',
					'default' => json_encode( array(
						array(
							'icon'=> 'fa fa-mobile',
							'title'=> esc_html__('Your service title', 'jewelry-store'),
							'desc'=> esc_html__('Your service description', 'jewelry-store'),
						)
					) )
				) );

			$wp_customize->add_control(
				new Jewelry_Store_Customize_Repeatable_Control(
					$wp_customize,
					'jewelrystore_option[service_contents]',
					array(
						'label'     => esc_html__('Service Content', 'jewelry-store'),
						'description'   => '',
						'priority'     => 40,
						'section'       => 'service_content',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__('[live_title]', 'jewelry-store'), // [live_title]
						'limited_msg'   => wp_kses_post( __('<a target="_blank" href="'.esc_url('https://britetechs.com/jewelry-store-pro-wordpress-theme/').'">Upgrade to PRO</a>', 'jewelry-store' ) ),
						'max_item'      => 4,
						'fields'    => array(
							'icon' => array(
								'title' => esc_html__('Icon', 'jewelry-store'),
								'type'  =>'icon',
								'default' => 'fa-mobile',
							),
							'title' => array(
								'title' => esc_html__('title', 'jewelry-store'),
								'type'  =>'text',
								'default' => esc_html__('Your service title', 'jewelry-store'),
							),
							'desc' => array(
								'title' => esc_html__('Description', 'jewelry-store'),
								'type'  =>'editor',
								'default' => esc_html__('Your service description', 'jewelry-store'),
							),
					
						),

					)
				)
			);

			// container width
            $wp_customize->add_setting( 'jewelrystore_option[service_container_width]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['service_container_width'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[service_container_width]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Container Width', 'jewelry-store'),
                    'section'     => 'service_content',
                    'description' => '',
                    'choices' => array(
                    	'container'=> __('Container','jewelry-store'),
                    	'container-fluid'=> __('Container Full','jewelry-store')
                    	),
                )
            );

            // layout
            $wp_customize->add_setting( 'jewelrystore_option[service_layout]',
                array(
                    'sanitize_callback' => 'jewelry_store_sanitize_select',
                    'default'           => $option['service_layout'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[service_layout]',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Layout', 'jewelry-store'),
                    'section'     => 'service_content',
                    'description' => '',
                    'choices' => array(
                    	'layout1'=> __('Layout 1','jewelry-store'),
                    	),
                )
            );

            // column layout
            $wp_customize->add_setting( 'jewelrystore_option[service_column]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['service_column'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[service_column]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Column Layout', 'jewelry-store'),
                    'section'     => 'service_content',
                    'description' => '',
                    'choices' => array(
                    	2 => __('2 Column','jewelry-store'),
                    	3 => __('3 Column','jewelry-store'),
                    	4 => __('4 Column','jewelry-store'),
                    	),
                )
            );
}
add_action('customize_register','jewelry_store_customizer_service');