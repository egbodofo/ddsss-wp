<?php
function jewelry_store_customizer_shop( $wp_customize ){

	$option = jewelry_store_reset_data();

	$wp_customize->add_panel( 'shop_panel',
		array(
			'priority'       => 133,
			'capability'     => 'edit_theme_options',
			'title'          => esc_html__( 'Home Page: Shop', 'jewelry-store' ),
			'description'    => '',
		)
	);
		$wp_customize->add_section( 'shop_settings' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Shop Settings', 'jewelry-store' ),
				'description' => '',
				'panel'       => 'shop_panel',
			)
		);
			$wp_customize->add_setting( 'jewelrystore_option[shop_enable]',
				array(
					'sanitize_callback' => 'jewelry_store_sanitize_checkbox',
					'default'           => $option['shop_enable'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[shop_enable]',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Shop Enable', 'jewelry-store'),
					'section'     => 'shop_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[shop_title]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['shop_title'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[shop_title]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Title', 'jewelry-store'),
					'section'     => 'shop_settings',
					'description' => '',
				)
			);
			$wp_customize->add_setting( 'jewelrystore_option[shop_subtitle]',
				array(
					'sanitize_callback' => 'wp_kses_post',
					'default'           => $option['shop_subtitle'],
					'type' => 'option',
				)
			);
			$wp_customize->add_control( 'jewelrystore_option[shop_subtitle]',
				array(
					'type'        => 'text',
					'label'       => esc_html__('Section Subtitle', 'jewelry-store'),
					'section'     => 'shop_settings',
					'description' => '',
				)
			);

			// container width
            $wp_customize->add_setting( 'jewelrystore_option[shop_container_width]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['shop_container_width'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[shop_container_width]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Container Width', 'jewelry-store'),
                    'section'     => 'shop_settings',
                    'description' => '',
                    'choices' => array(
                    	'container'=> __('Container','jewelry-store'),
                    	'container-fluid'=> __('Container Full','jewelry-store')
                    	),
                )
            );

            // column layout
            $wp_customize->add_setting( 'jewelrystore_option[shop_column]',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => $option['shop_column'],
                    'transport'			=> 'postMessage',
                    'type' => 'option',
                )
            );
            $wp_customize->add_control( 'jewelrystore_option[shop_column]',
                array(
                    'type'        => 'radio',
                    'label'       => esc_html__('Column Layout', 'jewelry-store'),
                    'section'     => 'shop_settings',
                    'description' => '',
                    'choices' => array(
                    	2 => __('2 Column','jewelry-store'),
                    	3 => __('3 Column','jewelry-store'),
                    	4 => __('4 Column','jewelry-store'),
                    	),
                )
            );

}
add_action('customize_register','jewelry_store_customizer_shop');