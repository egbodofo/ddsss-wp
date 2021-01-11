<?php
/**
 * Pool Services Lite Theme Customizer
 *
 * @package Pool Services Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function pool_services_lite_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'pool_services_lite_custom_controls' );

function pool_services_lite_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'pool_services_lite_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'pool_services_lite_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$PoolServicesLiteParentPanel = new Pool_Services_Lite_WP_Customize_Panel( $wp_customize, 'pool_services_lite_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'pool-services-lite' ),
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'pool_services_lite_left_right', array(
    	'title'      => esc_html__( 'General Settings', 'pool-services-lite' ),
		'panel' => 'pool_services_lite_panel_id'
	) );

	$wp_customize->add_setting('pool_services_lite_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Pool_Services_Lite_Image_Radio_Control($wp_customize, 'pool_services_lite_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','pool-services-lite'),
        'description' => __('Here you can change the width layout of Website.','pool-services-lite'),
        'section' => 'pool_services_lite_left_right',
        'choices' => array(
            'Full Width' => get_template_directory_uri().'/assets/images/full-width.png',
            'Wide Width' => get_template_directory_uri().'/assets/images/wide-width.png',
            'Boxed' => get_template_directory_uri().'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('pool_services_lite_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control('pool_services_lite_theme_options',array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','pool-services-lite'),
        'description' => __('Here you can change the sidebar layout for posts. ','pool-services-lite'),
        'section' => 'pool_services_lite_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','pool-services-lite'),
            'Right Sidebar' => __('Right Sidebar','pool-services-lite'),
            'One Column' => __('One Column','pool-services-lite'),
            'Three Columns' => __('Three Columns','pool-services-lite'),
            'Four Columns' => __('Four Columns','pool-services-lite'),
            'Grid Layout' => __('Grid Layout','pool-services-lite')
        ),
	) );

	$wp_customize->add_setting('pool_services_lite_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control('pool_services_lite_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','pool-services-lite'),
        'description' => __('Here you can change the sidebar layout for pages. ','pool-services-lite'),
        'section' => 'pool_services_lite_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','pool-services-lite'),
            'Right Sidebar' => __('Right Sidebar','pool-services-lite'),
            'One Column' => __('One Column','pool-services-lite')
        ),
	) );

	//Pre-Loader
	$wp_customize->add_setting( 'pool_services_lite_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','pool-services-lite' ),
        'section' => 'pool_services_lite_left_right'
    )));

	$wp_customize->add_setting('pool_services_lite_loader_icon',array(
        'default' => 'Two Way',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control('pool_services_lite_loader_icon',array(
        'type' => 'select',
        'label' => __('Pre-Loader Type','pool-services-lite'),
        'section' => 'pool_services_lite_left_right',
        'choices' => array(
            'Two Way' => __('Two Way','pool-services-lite'),
            'Dots' => __('Dots','pool-services-lite'),
            'Rotate' => __('Rotate','pool-services-lite')
        ),
	) );

	//Top Bar
	$wp_customize->add_section( 'pool_services_lite_topbar', array(
    	'title'      => __( 'Top Bar Settings', 'pool-services-lite' ),
		'panel' => 'pool_services_lite_panel_id'
	) );

	//Sticky Header
	$wp_customize->add_setting( 'pool_services_lite_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','pool-services-lite' ),
        'section' => 'pool_services_lite_topbar'
    )));

    $wp_customize->add_setting('pool_services_lite_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_search_enable',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_search_enable',array(
      	'label' => esc_html__( 'Show / Hide Search','pool-services-lite' ),
      	'section' => 'pool_services_lite_topbar'
    )));

    $wp_customize->add_setting('pool_services_lite_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_search_font_size',array(
		'label'	=> __('Search Font Size','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

    $wp_customize->add_setting( 'pool_services_lite_cart_enable',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_cart_enable',array(
      	'label' => esc_html__( 'Show / Hide Cart','pool-services-lite' ),
      	'section' => 'pool_services_lite_topbar'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_location', array( 
		'selector' => '.top-bar p', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_location', 
	));

    $wp_customize->add_setting('pool_services_lite_location_icon',array(
		'default'	=> 'fas fa-map-marker-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_location_icon',array(
		'label'	=> __('Add Location Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_topbar',
		'setting'	=> 'pool_services_lite_location_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('pool_services_lite_location',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_location',array(
		'label'	=> __('Add Location','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '123 lorem ipsum is a dummy text, USA', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_phone_text', array( 
		'selector' => '.info-ctr h6', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_phone_text', 
	));

	$wp_customize->add_setting('pool_services_lite_phone_no_icon',array(
		'default'	=> 'fas fa-phone-volume',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_phone_no_icon',array(
		'label'	=> __('Add Phone Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_topbar',
		'setting'	=> 'pool_services_lite_phone_no_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('pool_services_lite_phone_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_phone_text',array(
		'label'	=> __('Add Phone Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Please Make a Call', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'pool_services_lite_sanitize_phone_number'
	));
	$wp_customize->add_control('pool_services_lite_phone_number',array(
		'label'	=> __('Add Phone Number','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '+00 1234 567 890', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_email_address_icon',array(
		'default'	=> 'fas fa-envelope-open',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_email_address_icon',array(
		'label'	=> __('Add Email Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_topbar',
		'setting'	=> 'pool_services_lite_email_address_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('pool_services_lite_email_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_email_text',array(
		'label'	=> __('Add Email text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Drop us an Email', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'pool_services_lite_sanitize_email'
	));
	$wp_customize->add_control('pool_services_lite_email_address',array(
		'label'	=> __('Add Email Address','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'example@gmail.com', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_cart_icon',array(
		'default'	=> 'fas fa-shopping-basket',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_cart_icon',array(
		'label'	=> __('Add Cart Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_topbar',
		'setting'	=> 'pool_services_lite_cart_icon',
		'type'		=> 'icon'
	)));
    
	//Slider
	$wp_customize->add_section( 'pool_services_lite_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'pool-services-lite' ),
		'panel' => 'pool_services_lite_panel_id'
	) );

	$wp_customize->add_setting( 'pool_services_lite_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','pool-services-lite' ),
      	'section' => 'pool_services_lite_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('pool_services_lite_slider_arrows',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_slider_arrows',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'pool_services_lite_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'pool_services_lite_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'pool_services_lite_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'pool-services-lite' ),
			'description' => __('Slider image size (1600 x 800)','pool-services-lite'),
			'section'  => 'pool_services_lite_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('pool_services_lite_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_slidersettings',
		'type'=> 'text'
	));

	//content layout
	$wp_customize->add_setting('pool_services_lite_slider_content_option',array(
        'default' => 'Center',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Pool_Services_Lite_Image_Radio_Control($wp_customize, 'pool_services_lite_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','pool-services-lite'),
        'section' => 'pool_services_lite_slidersettings',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/slider-content1.png',
            'Center' => get_template_directory_uri().'/assets/images/slider-content2.png',
            'Right' => get_template_directory_uri().'/assets/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'pool_services_lite_slider_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','pool-services-lite' ),
		'section'     => 'pool_services_lite_slidersettings',
		'type'        => 'range',
		'settings'    => 'pool_services_lite_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('pool_services_lite_slider_opacity_color',array(
      'default'              => 0.4,
      'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));

	$wp_customize->add_control( 'pool_services_lite_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','pool-services-lite' ),
	'section'     => 'pool_services_lite_slidersettings',
	'type'        => 'select',
	'settings'    => 'pool_services_lite_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','pool-services-lite'),
      '0.1' =>  esc_attr('0.1','pool-services-lite'),
      '0.2' =>  esc_attr('0.2','pool-services-lite'),
      '0.3' =>  esc_attr('0.3','pool-services-lite'),
      '0.4' =>  esc_attr('0.4','pool-services-lite'),
      '0.5' =>  esc_attr('0.5','pool-services-lite'),
      '0.6' =>  esc_attr('0.6','pool-services-lite'),
      '0.7' =>  esc_attr('0.7','pool-services-lite'),
      '0.8' =>  esc_attr('0.8','pool-services-lite'),
      '0.9' =>  esc_attr('0.9','pool-services-lite')
	),
	));

	//Slider height
	$wp_customize->add_setting('pool_services_lite_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_slider_height',array(
		'label'	=> __('Slider Height','pool-services-lite'),
		'description'	=> __('Specify the slider height (px).','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_slider_speed', array(
		'default'  => 3000,
		'sanitize_callback'	=> 'pool_services_lite_sanitize_float'
	) );
	$wp_customize->add_control( 'pool_services_lite_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','pool-services-lite'),
		'section' => 'pool_services_lite_slidersettings',
		'type'  => 'number',
	) );
 
	//About Section
	$wp_customize->add_section( 'pool_services_lite_about_section' , array(
    	'title'      => __( 'About Settings', 'pool-services-lite' ),
		'priority'   => null,
		'panel' => 'pool_services_lite_panel_id'
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'pool_services_lite_section_title', array( 
		'selector' => '#about-section h2', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_section_title',
	));

	$wp_customize->add_setting('pool_services_lite_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_section_title',array(
		'label'	=> __('Add Section Title','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Welcome to the Pool Services Lite', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_about_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_about', array(
		'default'           => '',
		'sanitize_callback' => 'pool_services_lite_sanitize_dropdown_pages'
	) );
	$wp_customize->add_control( 'pool_services_lite_about', array(
		'label'    => __( 'Select About Page', 'pool-services-lite' ),
		'description' => __('About image size (640 x 480)','pool-services-lite'),
		'section'  => 'pool_services_lite_about_section',
		'type'     => 'dropdown-pages'
	) );

	//About excerpt
	$wp_customize->add_setting( 'pool_services_lite_about_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_about_excerpt_number', array(
		'label'       => esc_html__( 'About Excerpt length','pool-services-lite' ),
		'section'     => 'pool_services_lite_about_section',
		'type'        => 'range',
		'settings'    => 'pool_services_lite_about_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('pool_services_lite_about_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_about_button_text',array(
		'label'	=> __('Add About Button Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Discover More', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_about_section',
		'type'=> 'text'
	));

	//Blog Post
	$wp_customize->add_panel( $PoolServicesLiteParentPanel );

	$BlogPostParentPanel = new Pool_Services_Lite_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'pool-services-lite' ),
		'panel' => 'pool_services_lite_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'pool_services_lite_post_settings', array(
		'title' => __( 'Post Settings', 'pool-services-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_toggle_postdate', 
	));

	$wp_customize->add_setting( 'pool_services_lite_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','pool-services-lite' ),
        'section' => 'pool_services_lite_post_settings'
    )));

    $wp_customize->add_setting( 'pool_services_lite_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_toggle_author',array(
		'label' => esc_html__( 'Author','pool-services-lite' ),
		'section' => 'pool_services_lite_post_settings'
    )));

    $wp_customize->add_setting( 'pool_services_lite_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_toggle_comments',array(
		'label' => esc_html__( 'Comments','pool-services-lite' ),
		'section' => 'pool_services_lite_post_settings'
    )));

    $wp_customize->add_setting( 'pool_services_lite_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
	));
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_toggle_tags', array(
		'label' => esc_html__( 'Tags','pool-services-lite' ),
		'section' => 'pool_services_lite_post_settings'
    )));

    $wp_customize->add_setting( 'pool_services_lite_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','pool-services-lite' ),
		'section'     => 'pool_services_lite_post_settings',
		'type'        => 'range',
		'settings'    => 'pool_services_lite_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('pool_services_lite_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
    ));
    $wp_customize->add_control(new Pool_Services_Lite_Image_Radio_Control($wp_customize, 'pool_services_lite_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','pool-services-lite'),
        'section' => 'pool_services_lite_post_settings',
        'choices' => array(
            'Default' => get_template_directory_uri().'/assets/images/blog-layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/blog-layout2.png',
            'Left' => get_template_directory_uri().'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('pool_services_lite_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control('pool_services_lite_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','pool-services-lite'),
        'section' => 'pool_services_lite_post_settings',
        'choices' => array(
        	'Content' => __('Content','pool-services-lite'),
            'Excerpt' => __('Excerpt','pool-services-lite'),
            'No Content' => __('No Content','pool-services-lite')
        ),
	) );

	$wp_customize->add_setting('pool_services_lite_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','pool-services-lite' ),
      'section' => 'pool_services_lite_post_settings'
    )));

	$wp_customize->add_setting( 'pool_services_lite_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'pool_services_lite_sanitize_choices'
    ));
    $wp_customize->add_control( 'pool_services_lite_blog_pagination_type', array(
        'section' => 'pool_services_lite_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'pool-services-lite' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'pool-services-lite' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'pool-services-lite' ),
    )));

    // Button Settings
	$wp_customize->add_section( 'pool_services_lite_button_settings', array(
		'title' => __( 'Button Settings', 'pool-services-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_button_text', 
	));

    $wp_customize->add_setting('pool_services_lite_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_button_text',array(
		'label'	=> __('Add Button Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'pool_services_lite_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'pool-services-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_related_post_title', 
	));

    $wp_customize->add_setting( 'pool_services_lite_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_related_post',array(
		'label' => esc_html__( 'Related Post','pool-services-lite' ),
		'section' => 'pool_services_lite_related_posts_settings'
    )));

    $wp_customize->add_setting('pool_services_lite_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_related_post_title',array(
		'label'	=> __('Add Related Post Title','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('pool_services_lite_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'pool_services_lite_sanitize_float'
	));
	$wp_customize->add_control('pool_services_lite_related_posts_count',array(
		'label'	=> __('Add Related Post Count','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_related_posts_settings',
		'type'=> 'number'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'pool_services_lite_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'pool-services-lite' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting( 'pool_services_lite_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
	));
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Post Navigation','pool-services-lite' ),
		'section' => 'pool_services_lite_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('pool_services_lite_single_blog_prev_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_single_blog_next_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_single_blog_settings',
		'type'=> 'text'
	));

    //404 Page Setting
	$wp_customize->add_section('pool_services_lite_404_page',array(
		'title'	=> __('404 Page Settings','pool-services-lite'),
		'panel' => 'pool_services_lite_panel_id',
	));	

	$wp_customize->add_setting('pool_services_lite_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('pool_services_lite_404_page_title',array(
		'label'	=> __('Add Title','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('pool_services_lite_404_page_content',array(
		'label'	=> __('Add Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_404_page_button_text',array(
		'label'	=> __('Add Button Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_404_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('pool_services_lite_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','pool-services-lite'),
		'panel' => 'pool_services_lite_panel_id',
	));	

	$wp_customize->add_setting('pool_services_lite_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_social_icon_padding',array(
		'label'	=> __('Icon Padding','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_social_icon_width',array(
		'label'	=> __('Icon Width','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_social_icon_height',array(
		'label'	=> __('Icon Height','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','pool-services-lite' ),
		'section'     => 'pool_services_lite_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('pool_services_lite_responsive_media',array(
		'title'	=> __('Responsive Media','pool-services-lite'),
		'panel' => 'pool_services_lite_panel_id',
	));

    $wp_customize->add_setting( 'pool_services_lite_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','pool-services-lite' ),
      'section' => 'pool_services_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'pool_services_lite_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','pool-services-lite' ),
      'section' => 'pool_services_lite_responsive_media'
    )));

	$wp_customize->add_setting( 'pool_services_lite_metabox_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_metabox_hide_show',array(
      'label' => esc_html__( 'Show / Hide Metabox','pool-services-lite' ),
      'section' => 'pool_services_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'pool_services_lite_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','pool-services-lite' ),
      'section' => 'pool_services_lite_responsive_media'
    )));

    $wp_customize->add_setting( 'pool_services_lite_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','pool-services-lite' ),
      'section' => 'pool_services_lite_responsive_media'
    )));

    $wp_customize->add_setting('pool_services_lite_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_responsive_media',
		'setting'	=> 'pool_services_lite_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('pool_services_lite_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_responsive_media',
		'setting'	=> 'pool_services_lite_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	//Footer Text
	$wp_customize->add_section('pool_services_lite_footer',array(
		'title'	=> __('Footer Settings','pool-services-lite'),
		'panel' => 'pool_services_lite_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_footer_text', 
	));
	
	$wp_customize->add_setting('pool_services_lite_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('pool_services_lite_footer_text',array(
		'label'	=> __('Copyright Text','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('pool_services_lite_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Pool_Services_Lite_Image_Radio_Control($wp_customize, 'pool_services_lite_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','pool-services-lite'),
        'section' => 'pool_services_lite_footer',
        'settings' => 'pool_services_lite_copyright_alingment',
        'choices' => array(
            'left' => get_template_directory_uri().'/assets/images/copyright1.png',
            'center' => get_template_directory_uri().'/assets/images/copyright2.png',
            'right' => get_template_directory_uri().'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('pool_services_lite_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));

    $wp_customize->add_setting( 'pool_services_lite_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ));  
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','pool-services-lite' ),
      	'section' => 'pool_services_lite_footer'
    )));

     //Selective Refresh
	$wp_customize->selective_refresh->add_partial('pool_services_lite_scroll_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'pool_services_lite_customize_partial_pool_services_lite_scroll_top_icon', 
	));

    $wp_customize->add_setting('pool_services_lite_scroll_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Pool_Services_Lite_Fontawesome_Icon_Chooser(
        $wp_customize,'pool_services_lite_scroll_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','pool-services-lite'),
		'transport' => 'refresh',
		'section'	=> 'pool_services_lite_footer',
		'setting'	=> 'pool_services_lite_scroll_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('pool_services_lite_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_scroll_to_top_width',array(
		'label'	=> __('Icon Width','pool-services-lite'),
		'description'	=> __('Enter a value in pixels Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_scroll_to_top_height',array(
		'label'	=> __('Icon Height','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pool_services_lite_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','pool-services-lite' ),
		'section'     => 'pool_services_lite_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('pool_services_lite_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control(new Pool_Services_Lite_Image_Radio_Control($wp_customize, 'pool_services_lite_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','pool-services-lite'),
        'section' => 'pool_services_lite_footer',
        'settings' => 'pool_services_lite_scroll_top_alignment',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/layout2.png',
            'Right' => get_template_directory_uri().'/assets/images/layout3.png'
    ))));

    //Woocommerce settings
	$wp_customize->add_section('pool_services_lite_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'pool-services-lite'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'pool_services_lite_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','pool-services-lite' ),
		'section' => 'pool_services_lite_woocommerce_section'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'pool_services_lite_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'pool_services_lite_switch_sanitization'
    ) );
    $wp_customize->add_control( new Pool_Services_Lite_Toggle_Switch_Custom_Control( $wp_customize, 'pool_services_lite_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','pool-services-lite' ),
		'section' => 'pool_services_lite_woocommerce_section'
    )));

    //Products per page
    $wp_customize->add_setting('pool_services_lite_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'pool_services_lite_sanitize_float'
	));
	$wp_customize->add_control('pool_services_lite_products_per_page',array(
		'label'	=> __('Products Per Page','pool-services-lite'),
		'description' => __('Display on shop page','pool-services-lite'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'pool_services_lite_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('pool_services_lite_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'pool_services_lite_sanitize_choices'
	));
	$wp_customize->add_control('pool_services_lite_products_per_row',array(
		'label'	=> __('Products Per Row','pool-services-lite'),
		'description' => __('Display on shop page','pool-services-lite'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'pool_services_lite_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('pool_services_lite_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pool_services_lite_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pool_services_lite_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','pool-services-lite'),
		'description'	=> __('Enter a value in pixels. Example:20px','pool-services-lite'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'pool-services-lite' ),
        ),
		'section'=> 'pool_services_lite_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'pool_services_lite_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','pool-services-lite' ),
		'section'     => 'pool_services_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'pool_services_lite_products_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pool_services_lite_sanitize_number_range'
	) );
	$wp_customize->add_control( 'pool_services_lite_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','pool-services-lite' ),
		'section'     => 'pool_services_lite_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

     // Has to be at the top
	$wp_customize->register_panel_type( 'Pool_Services_Lite_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'Pool_Services_Lite_WP_Customize_Section' );
}

add_action( 'customize_register', 'pool_services_lite_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class Pool_Services_Lite_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'pool_services_lite_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class Pool_Services_Lite_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'pool_services_lite_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function pool_services_lite_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'pool_services_lite_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Pool_Services_Lite_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Pool_Services_Lite_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Pool_Services_Lite_Customize_Section_Pro( $manager,'pool_services_lite_upgrade_pro_link', array(
			'priority'   => 1,
			'title'    => esc_html__( 'POOL SERVIES PRO', 'pool-services-lite' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'pool-services-lite' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/swimming-pool-wordpress-theme/'),
		) )	);

		$manager->add_section(new Pool_Services_Lite_Customize_Section_Pro($manager,'pool_services_lite_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'pool-services-lite' ),
			'pro_text' => esc_html__( 'DOCS', 'pool-services-lite' ),
			'pro_url'  => admin_url('themes.php?page=pool_services_lite_guide'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'pool-services-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'pool-services-lite-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Pool_Services_Lite_Customize::get_instance();