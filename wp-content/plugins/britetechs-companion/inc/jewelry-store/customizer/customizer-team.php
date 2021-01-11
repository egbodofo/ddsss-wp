<?php
function jewelry_store_customizer_team( $wp_customize ){

	$option = jewelry_store_reset_data();

	$wp_customize->add_panel( 'team_panel',
		array(
			'priority'       => 137,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Home Page: Team', 'jewelry-store' ),
			'description'    => '',
		)
	);
		$wp_customize->add_section( 'team_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Team Settings', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'team_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[team_enable]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['team_enable'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[team_enable]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Team Enable', 'jewelry-store'),
					'section'     => 'team_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[team_title]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['team_title'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[team_title]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Title', 'jewelry-store'),
					'section'     => 'team_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[team_subtitle]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['team_subtitle'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[team_subtitle]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Subtitle', 'jewelry-store'),
					'section'     => 'team_settings',
					'description' => '',
				)
			);
		$wp_customize->add_section( 'team_content' ,
			array(
				'priority'    => 2,
				'title'       => esc_html__( 'Team Contents', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'team_panel',
			)
		);
			$wp_customize->add_setting(
				'jewelrystore_option[team_contents]',
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
							'title'=> 'Your Team Name',
							'position'=> 'Designation',
							'facebook_url'=> '#',
							'twitter_url'=> '#',
							'linkedin_url'=> '#',
							'googleplus_url'=> '#',
							'link' => '#',
						)
					) )
				) );

			$wp_customize->add_control(
				new Jewelry_Store_Customize_Repeatable_Control(
					$wp_customize,
					'jewelrystore_option[team_contents]',
					array(
						'label'     => esc_html__('Team Content', 'jewelry-store'),
						'description'   => '',
						'priority'     => 40,
						'section'       => 'team_content',
						'live_title_id' => 'title', // apply for unput text and textarea only
						'title_format'  => esc_html__('[live_title]', 'jewelry-store'), // [live_title]
						'max_item'      => 4,
						'limited_msg'   => wp_kses_post( __('<a target="_blank" href="'.esc_url('https://britetechs.com/jewelry-store-pro-wordpress-theme/').'">Upgrade to PRO</a>', 'jewelry-store' ) ),
						'fields'    => array(
							'image' => array(
								'title' => esc_html__('Team Image', 'jewelry-store'),
								'type'  =>'media',
								'default' => array(
									'url' => '',
									'id' => ''
								)
							),
							'title' => array(
								'title' => esc_html__('Team Name', 'jewelry-store'),
								'type'  =>'text',
								'default' => esc_html__('Team Name', 'jewelry-store'),
							),
							'position' => array(
								'title' => esc_html__('Designation', 'jewelry-store'),
								'type'  =>'text',
								'default' => esc_html__('Team Designation', 'jewelry-store'),
							),
						),

					)
				)
			);

			// container width
            $wp_customize->add_setting( 'jewelrystore_option[team_container_width]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['team_container_width'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[team_container_width]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Container Width', 'jewelry-store'),
                    'section'     => 'team_content',
                    'description' => '',
                    'choices' => array(
                    	'container'=> __('Container','jewelry-store'),
                    	'container-fluid'=> __('Container Full','jewelry-store')
                    	),
                )
            );

            // layout
            $wp_customize->add_setting( 'jewelrystore_option[team_layout]',
                array(
                    'sanitize_callback' => 'jewelry_store_sanitize_select',
                    'default'           => $option['team_layout'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[team_layout]',
                array(
                    'type'        => 'select',
                    'label'       => esc_html__('Layout', 'jewelry-store'),
                    'section'     => 'team_content',
                    'description' => '',
                    'choices' => array(
                    	'layout1'=> __('Layout 1','jewelry-store'),
                    	),
                )
            );

            // column layout
            $wp_customize->add_setting( 'jewelrystore_option[team_column]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['team_column'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[team_column]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Column Layout', 'jewelry-store'),
                    'section'     => 'team_content',
                    'description' => '',
                    'choices' => array(
                    	2 => __('2 Column','jewelry-store'),
                    	3 => __('3 Column','jewelry-store'),
                    	4 => __('4 Column','jewelry-store'),
                    	),
                )
            );
}
add_action('customize_register','jewelry_store_customizer_team');