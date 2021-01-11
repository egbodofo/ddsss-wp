<?php

if ( !class_exists('Kirki') ) return;

/* -----------------------------------------------------------------------------
 * Add sections & panels
 * ----------------------------------------------------------------------------- */

$panels = array(
	'page_settings' => array( esc_attr__( 'Page Settings', 'lava' ), '', 23 ),
	'hb' => array( esc_attr__( 'Hotel Booking', 'lava' ), '', 24 ),
	'woocommerce' => array( esc_attr__( 'WooCommerce', 'lava' ), '', 24 ),
	'typography' => array( esc_attr__( 'Typography', 'lava' ), '', 25 ),
);

foreach ( $panels as $panel_id => $panel ) {
	Kirki::add_panel( $panel_id, array(
		'title'       => $panel[0],
		'description' => $panel[1],
		'priority' => $panel[2],
	));
}

$sections = array(
	'general' => array( esc_attr__( 'General', 'lava' ), '', 21 ),
	'header' => array( esc_attr__( 'Header', 'lava' ), '', 22 ),
	'footer' => array( esc_attr__( 'Footer', 'lava' ), '', 22 ),
	'page_header' => array( esc_attr( 'Page Header', 'lava' ), '', 10, 'page_settings' ),
	'page_single' => array( esc_attr( 'Single Post', 'lava' ), '', 10, 'page_settings' ),
	'page_page' => array( esc_attr( 'Single Page', 'lava' ), '', 10, 'page_settings' ),
	'page_archive' => array( esc_attr( 'Archive Page', 'lava' ), '', 10, 'page_settings' ),
	'page_blog' => array( esc_attr( 'Blog Page', 'lava' ), '', 10, 'page_settings' ),
	'page_error' => array( esc_attr( '404 Page', 'lava' ), '', 10, 'page_settings' ),
	'hb_general' => array( esc_attr( 'General', 'lava' ), '', 10, 'hb' ),
	'hb_search' => array( esc_attr( 'Search Room', 'lava' ), '', 10, 'hb' ),
	'hb_archive' => array( esc_attr( 'Archive Rooms', 'lava' ), '', 10, 'hb' ),
	'hb_single' => array( esc_attr( 'Single Room', 'lava' ), '', 10, 'hb' ),
	'wc_shop' => array( esc_attr( 'Shop Page', 'lava' ), '', 10, 'woocommerce' ),
	'wc_product' => array( esc_attr( 'Product Page', 'lava' ), '', 10, 'woocommerce' ),
	'wc_archive' => array( esc_attr( 'Archive Page', 'lava' ), '', 10, 'woocommerce' ),
	'wc_general' => array( esc_attr( 'General', 'lava' ), '', 10, 'woocommerce' ),
	'event' => array( esc_attr__( 'Event', 'lava' ), '', 24 ),
	'offer' => array( esc_attr__( 'Offer', 'lava' ), '', 24 ),
	'color' => array( esc_attr__( 'Color Settings', 'lava' ), '', 26 ),
	'typography_body' => array( esc_attr__( 'Body', 'lava' ), '', 10, 'typography' ),
	'typography_heading' => array( esc_attr__( 'H1 - H6', 'lava' ), '', 10, 'typography' ),
	'typography_nav_menu' => array( esc_attr__( 'Nav Menu', 'lava' ), '', 10, 'typography' ),
	'typography_fullscreen_menu' => array( esc_attr__( 'Fullscreen Menu', 'lava' ), '', 10, 'typography' ),
	'typography_section_heading' => array( esc_attr__( 'Section Heading', 'lava' ), '', 10, 'typography' ),
	'background' => array( esc_attr__( 'Site Background', 'lava' ), '', 27 ),
	'social' => array( esc_attr__( 'Social Links', 'lava' ), esc_attr__( 'Enter URL of your social profile', 'lava' ), 28 ),
	'custom_codes' => array( esc_attr__( 'Custom Codes', 'lava' ), '', 29 ),
);

foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title'       => $section[0],
		'description' => $section[1],
		'priority' => $section[2],
	);
	if ( isset( $section[3] ) ) {
		$section_args['panel'] = $section[3];
	}
	Kirki::add_section( $section_id, $section_args );
}

/* -----------------------------------------------------------------------------
 * Add fields
 * ----------------------------------------------------------------------------- */

function lava_customizer_settings( $controls ) {
	
	// general

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'loader',
		'label'       => esc_html__( 'Page Loader Style', 'lava' ),
		'section'     => 'general',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'' => esc_html__( 'No Loader', 'lava' ),
			'line' => esc_html__( 'Line', 'lava' ),
			'spinner' => esc_html__( 'Spinner', 'lava' ),
			'square-spin' => esc_html__( 'Square Spin', 'lava' ),
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'loading_bg',
		'label'       => esc_html__( 'Loading Screen Color', 'lava' ),
		'section'     => 'general',
		'default'     => '#FFFFFF',
		'transport'   => 'auto',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => array( '.site-overlay' ),
				'property' => 'background-color',
			)
		)
	);

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'global_layout',
		'label'       => esc_html__( 'Global Layout', 'lava' ),
		'section'     => 'general',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'sticky_sidebar',
		'label'       => esc_html__( 'Sticky Sidebar', 'lava' ),
		'section'     => 'general',
		'default'     => true,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'hide_sidebar_on_xs',
		'label'       => esc_html__( 'Hide Sidebar On Small Screen', 'lava' ),
		'section'     => 'general',
		'default'     => false,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'scroll_top',
		'label'       => esc_html__( 'Show Scroll Top', 'lava' ),
		'section'     => 'general',
		'default'     => true,
		'priority'    => 10
	);

	// footer

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'footer_top',
		'label'       => esc_html__( 'Show Footer Top', 'lava' ),
		'section'     => 'footer',
		'default'     => true,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'footer_bottom_style',
		'label'       => esc_html__( 'Footer Bottom Style', 'lava' ),
		'section'     => 'footer',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => array(
			'1' => esc_html__( 'Style 1', 'lava' ),
			'2'   => esc_html__( 'Style 2', 'lava' ),
		),
	);

	$controls[] = array(
		'type'        => 'textarea',
		'settings'    => 'footer_copyright',
		'label'       => esc_html__( 'Footer Copyright Text', 'lava' ),
		'section'     => 'footer',
		'default'     => esc_html( '&copy; 2017' ),
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_text_color',
		'label'       => esc_html__( 'Text Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#646464',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array( '#footer', '#footer .address' ),
				'property' => 'color',
				'exclude' => array( '#646464' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_link_color',
		'label'       => esc_html__( 'Link Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#898989',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => '#footer a',
				'property' => 'color',
				'exclude' => array( '#898989' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_link_hover_color',
		'label'       => esc_html__( 'Link Hover Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#FFFFFF',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => '#footer a:hover',
				'property' => 'color',
				'exclude' => array( '#FFFFFF' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_title_color',
		'label'       => esc_html__( 'Widget Title Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array( '.footer-top .section-heading' ),
				'property' => 'color',
				'exclude' => array( '#AFA278' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_bg_color',
		'label'       => esc_html__( 'Background Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#141414',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => '#footer',
				'property' => 'background-color',
				'exclude' => array( '#141414' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'footer_bg_img',
		'label'       => esc_html__( 'Background Image', 'lava' ),
		'section'     => 'footer',
		'default'     => '',
		'priority'    => 10,
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => '#footer',
				'property' => 'background-image',
			)
		)
	);

	$controls[] = array(
		'type'        => 'radio',
		'settings'    => 'footer_bg_repeat',
		'label'       => esc_html__( 'Background Repeat', 'lava' ),
		'section'     => 'footer',
		'default'     => 'no-repeat',
		'priority'    => 10,
		'transport'   => 'auto',
		'choices'     => array(
			'no-repeat'   => esc_html__( 'No Repeat', 'lava' ),
			'repeat' => esc_html__( 'Tile', 'lava' ),
			'repeat-x'  => esc_html__( 'Tile Horizontally', 'lava' ),
			'repeat-y'  => esc_html__( 'Tile Vertically', 'lava' ),
		),
		'output' 	  => array(
			array(
				'element' => '#footer',
				'property' => 'background-repeat',
				'exclude' => array( 'no-repeat' )
			)
		),
		'active_callback'  => array(
			array(
				'setting'  => 'footer_bg_img',
				'operator' => '!=',
				'value'    => '',
			),
		)
	);

	$controls[] = array(
		'type'        => 'radio',
		'settings'    => 'footer_bg_position_x',
		'label'       => esc_html__( 'Background Position', 'lava' ),
		'section'     => 'footer',
		'default'     => 'left top',
		'transport'   => 'auto',
		'priority'    => 10,
		'choices'     => array(
			'left top'   => esc_html__( 'Left', 'lava' ),
			'center top' => esc_html__( 'Center', 'lava' ),
			'right top'  => esc_html__( 'Right', 'lava' ),
		),
		'output' 	  => array(
			array(
				'element' => '#footer',
				'property' => 'background-position',
				'exclude' => array( 'left top' )
			)
		),
		'active_callback'  => array(
			array(
				'setting'  => 'footer_bg_img',
				'operator' => '!=',
				'value'    => '',
			),
		)
	);

	$controls[] = array(
		'type'        => 'radio',
		'settings'    => 'footer_bg_size',
		'label'       => esc_html__( 'Background Size', 'lava' ),
		'section'     => 'footer',
		'default'     => 'initial',
		'transport'   => 'auto',
		'priority'    => 10,
		'choices'     => array(
			'initial' => esc_html__( 'Initial', 'lava' ),
			'cover'   => esc_html__( 'Cover', 'lava' ),
			'contain' => esc_html__( 'Contain', 'lava' )
		),
		'output' 	  => array(
			array(
				'element' => '#footer',
				'property' => 'background-size',
				'exclude' => array( 'initial' )
			)
		),
		'active_callback'  => array(
			array(
				'setting'  => 'footer_bg_img',
				'operator' => '!=',
				'value'    => '',
			),
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'footer_top_bg_color',
		'label'       => esc_html__( 'Footer Top Background Color', 'lava' ),
		'section'     => 'footer',
		'default'     => '#191919',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => '.footer-top',
				'property' => 'background-color',
				'exclude' => array( '#191919' )
			)
		)
	);

	// logo
	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'logo',
		'label'       => esc_html__( 'Logo', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'logo_retina',
		'label'       => esc_html__( 'Retina Logo', 'lava' ),
		'description' => esc_html__( '2x size of Logo', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'logo_width',
		'label'       => esc_html__( 'Logo Width (px)', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50,
		'choices'     => array(
			'min'  => 0,
			'max'  => 500,
			'step' => 1,
		)
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'logo_height',
		'label'       => esc_html__( 'Logo Height (px)', 'lava' ),
		'description' => esc_attr__( 'Max height: 120', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50,
		'choices'     => array(
			'min'  => 0,
			'max'  => 120,
			'step' => 1,
		)
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'small_logo',
		'label'       => esc_html__( 'Small Logo', 'lava' ),
		'description' => esc_html__( 'Used on small display and sticky header', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'small_logo_retina',
		'label'       => esc_html__( 'Retina Small Logo', 'lava' ),
		'section'     => 'title_tagline',
		'default'     => '',
		'priority'    => 50
	);

	// page settings

	$controls[] = array(
		'type'        => 'textarea',
		'settings'    => 'blog_title',
		'label'       => esc_html__( 'Blog Title', 'lava' ),
		'section'     => 'page_blog',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'blog_header',
		'label'       => esc_html__( 'Header Option', 'lava' ),
		'section'     => 'page_blog',
		'default'     => 'default',
		'choices' 	  => lava_get_option_page_headers(),
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'blog_header_image',
		'label'       => esc_html__( 'Header Image', 'lava' ),
		'section'     => 'page_blog',
		'default'     => '',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array( '.blog .page-header', '.single-post .page-header' ),
				'property' => 'background-image',
			)
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'blog_header_shortcode',
		'label'       => esc_html__( 'Slider Shortcode', 'lava' ),
		'section'     => 'page_blog',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'blog_layout',
		'label'       => esc_html__( 'Layout', 'lava' ),
		'section'     => 'page_blog',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'blog_sidebar',
		'label'       => esc_html__( 'Sidebar', 'lava' ),
		'section'     => 'page_blog',
		'default'     => '',
		'priority'    => 10,
		'choices'     => lava_get_option_sidebars()
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'blog_list_style',
		'label'       => esc_html__( 'Post List Style', 'lava' ),
		'section'     => 'page_blog',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'1' => esc_html__( 'Style 1', 'lava' ),
			'2' => esc_html__( 'Style 2', 'lava' )
		)
	);

	$controls[] = array(
		'type'        => 'multicheck',
		'settings'    => 'blog_post_meta',
		'label'       => esc_html__( 'Post Meta', 'lava' ),
		'section'     => 'page_blog',
		'default'     => array( 'author', 'cats', 'comment' ),
		'priority'    => 10,
		'choices'     => array(
			'author' => esc_html__( 'Author', 'lava' ),
			'date' => esc_html__( 'Date', 'lava' ),
			'cats' => esc_html__( 'Categories', 'lava' ),
			'comment' => esc_html__( 'Comment Count', 'lava' )
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'blog_excerpt_length',
		'label'       => esc_html__( 'Excerpt Length', 'lava' ),
		'section'     => 'page_blog',
		'default'     => 120,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'archive_layout',
		'label'       => esc_html__( 'Layout', 'lava' ),
		'section'     => 'page_archive',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'archive_sidebar',
		'label'       => esc_html__( 'Sidebar', 'lava' ),
		'section'     => 'page_archive',
		'default'     => '',
		'priority'    => 10,
		'choices'     => lava_get_option_sidebars()
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'archive_list_style',
		'label'       => esc_html__( 'Post List Style', 'lava' ),
		'section'     => 'page_archive',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'1' => esc_html__( 'Style 1', 'lava' ),
			'2' => esc_html__( 'Style 2', 'lava' )
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'archive_excerpt_length',
		'label'       => esc_html__( 'Excerpt Length', 'lava' ),
		'section'     => 'page_archive',
		'default'     => 120,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'error_image',
		'label'       => esc_html__( 'Background Image', 'lava' ),
		'section'     => 'page_error',
		'default'     => '',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array( '.error-page' ),
				'property' => 'background-image',
			)
		)
	);

	// single

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'single_layout',
		'label'       => esc_html__( 'Layout', 'lava' ),
		'section'     => 'page_single',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'single_sidebar',
		'label'       => esc_html__( 'Sidebar', 'lava' ),
		'section'     => 'page_single',
		'default'     => '',
		'priority'    => 10,
		'choices'     => lava_get_option_sidebars()
	);

	$controls[] = array(
		'type'        => 'multicheck',
		'settings'    => 'single_post_meta',
		'label'       => esc_html__( 'Post Meta', 'lava' ),
		'section'     => 'page_single',
		'default'     => array( 'author', 'cats', 'comment' ),
		'priority'    => 10,
		'choices'     => array(
			'author' => esc_html__( 'Author', 'lava' ),
			'cats' => esc_html__( 'Categories', 'lava' ),
			'comment' => esc_html__( 'Comment Count', 'lava' )
		)
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'single_hide_related',
		'label'       => esc_html__( 'Hide Related Posts', 'lava' ),
		'section'     => 'page_single',
		'default'     => 0,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'single_related_type',
		'label'       => esc_html__( 'Related Type', 'lava' ),
		'section'     => 'page_single',
		'default'     => 'cat_or_tag',
		'priority'    => 10,
		'choices'     => array(
			'all' => esc_html__( 'All Posts', 'lava' ),
			'cat' => esc_html__( 'Category', 'lava' ),
			'tag' => esc_html__( 'Tag', 'lava' ),
			'cat_or_tag' => esc_html__( 'Category or Tag', 'lava' ),
			'author' => esc_html__( 'Author', 'lava' )
		)
	);

	$controls[] = array(
		'type'        => 'slider',
		'settings'    => 'single_related_count',
		'label'       => esc_html__( 'Related Post Count', 'lava' ),
		'section'     => 'page_single',
		'default'     => 3,
		'priority'    => 10,
		'choices' 	  => array(
			'min' => 0,
			'max' => 9,
			'step' => 3
			)
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'single_hide_comments',
		'label'       => esc_html__( 'Hide Comments', 'lava' ),
		'section'     => 'page_single',
		'default'     => false,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'page_hide_comments',
		'label'       => esc_html__( 'Hide Comments', 'lava' ),
		'section'     => 'page_page',
		'default'     => true,
		'priority'    => 10
	);

	// typography
	
	$controls[] = array(
		'type'        => 'typography',
		'settings'    => 'typo_body',
		'label'       => esc_html__( 'Body Font', 'lava' ),
		'section'     => 'typography_body',
		'default'     => array(
			'font-family'    => 'Lato',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'line-height'    => '1.625',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
		'priority'    => 10,
		'output'      => array(
			array( 'element' => 'body' )
		)
	);

	$controls[] = array(
		'type'        => 'typography',
		'settings'    => 'typo_heading',
		'label'       => esc_html__( 'H1 - H6', 'lava' ),
		'section'     => 'typography_heading',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => '700',
			'line-height'    => '1.35',
			'letter-spacing' => '0.1em',
			'text-transform' => 'uppercase',
		),
		'priority'    => 10,
		'output'      => array(
			array( 'element' => array( 'h1','h2','h3','h4','h5','h6' ) )
		)
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h1',
		'label'       => esc_html__( 'H1 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h1',
				'property' => 'font-size',
				'exclude' => array( '36px', '1.8rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h2',
		'label'       => esc_html__( 'H2 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h2',
				'property' => 'font-size',
				'exclude' => array( '27px', '1.35rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h3',
		'label'       => esc_html__( 'H3 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h3',
				'property' => 'font-size',
				'exclude' => array( '21px', '1.05rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h4',
		'label'       => esc_html__( 'H4 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h4',
				'property' => 'font-size',
				'exclude' => array( '18px', '0.9rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h5',
		'label'       => esc_html__( 'H5 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h5',
				'property' => 'font-size',
				'exclude' => array( '16px', '0.8rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_h6',
		'label'       => esc_html__( 'H6 Font Size', 'lava' ),
		'section'     => 'typography_heading',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => 'h6',
				'property' => 'font-size',
				'exclude' => array( '14px', '0.7rem' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'typography',
		'settings'    => 'typo_section_heading',
		'label'       => esc_html__( 'Section Heading', 'lava' ),
		'section'     => 'typography_section_heading',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => '700',
			'letter-spacing' => '0.1em',
			'text-transform' => 'uppercase',
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => array( '.section-heading', '.widget-title' ),
				'suffix' => '!important'
			)
		)
	);

	$controls[] = array(
		'type'        => 'typography',
		'settings'    => 'typo_fullscreen_menu',
		'label'       => esc_html__( 'Fullscreen Menu', 'lava' ),
		'section'     => 'typography_fullscreen_menu',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => '500',
			'letter-spacing' => '0.1em',
			'text-transform' => 'uppercase',
		),
		'priority'    => 10,
		'output'      => array(
			array( 'element' => array( '.fullscreen-menu a' ) )
		)
	);

	$controls[] = array(
		'type'        => 'typography',
		'settings'    => 'typo_nav_menu',
		'label'       => esc_html__( 'Navigation Font', 'lava' ),
		'section'     => 'typography_nav_menu',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => '600',
			'letter-spacing' => '0.15em',
			'text-transform' => 'uppercase',
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => array( '.nav-menu a' ),
			),
		)
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_nav_menu_size',
		'label'       => esc_html__( 'Menu Font Size', 'lava' ),
		'description' => esc_html__( 'e.g. 14px', 'lava' ),
		'section'     => 'typography_nav_menu',
		'default'     => '14px',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.nav-menu>li>a',
				'property' => 'font-size',
				'exclude' => array( '14px' )
			)
		),
	);

	$controls[] = array(
		'type'        => 'dimension',
		'settings'    => 'typo_nav_submenu_size',
		'label'       => esc_html__( 'Submenu Font Size', 'lava' ),
		'description' => esc_html__( 'e.g. 14px', 'lava' ),
		'section'     => 'typography_nav_menu',
		'default'     => '12px',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.nav-menu .sub-menu',
				'property' => 'font-size',
				'exclude' => array( '12px' )
			)
		),
	);


	// color

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'primary_color',
		'label'       => esc_html__( 'Primary Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'#loader.line',
					'#loader.square-spin>div',
					'.nav-overlay',
					'.nav-icon-x:before',
					'.nav-icon-x:after',
					'.header-style-1 .header-wrapper',
					'.header-style-1 .logo-wrapper',
					'.header-style-1 .hamburger',
					'.header-style-4 .logo-wrapper',
					'.header-style-2 .header-wrapper.affix-on',
					'.header-style-3 .header-wrapper.affix-on',
					'.header-style-4 .header-wrapper.affix-on',
					'#nav-cart .cart-item-count',
					'#scroll-top:hover',
					'.page-header',
					'.numeric .page-numbers',
					'#swipebox-prev',
					'#swipebox-next',
					'#swipebox-close',
					'.slick-dots li.slick-active button',
					'.lava-testimonial-author:after',
					'.hb-booking-step.hb-booking-completed .step-number',
					'.hb-booking-step.hb-booking-active .step-number',
					'.hb_search_room_item_detail_price_close',
					'.room-gallery-label',
					'.ui-datepicker.ui-widget .ui-datepicker-header',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar .ui-state-default:hover',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar .ui-datepicker-current-day',
					'p.demo_store',
					'.woocommerce span.onsale',
					// event calendar
					'.datepicker table tr td.day:hover',
					'.datepicker table tr td.day.focused',
					'.datepicker table tr td.today',
					'.datepicker table tr td.today:hover',
					'.datepicker table tr td.today.disabled',
					'.datepicker table tr td.today.disabled:hover',
					'.datepicker table tr td.today:hover',
					'.datepicker table tr td.today:hover:hover',
					'.datepicker table tr td.today.disabled:hover',
					'.datepicker table tr td.today.disabled:hover:hover',
					'.datepicker table tr td.today:active',
					'.datepicker table tr td.today:hover:active',
					'.datepicker table tr td.today.disabled:active',
					'.datepicker table tr td.today.disabled:hover:active',
					'.datepicker table tr td.today.active',
					'.datepicker table tr td.today:hover.active',
					'.datepicker table tr td.today.disabled.active',
					'.datepicker table tr td.today.disabled:hover.active',
					'.datepicker table tr td.today.disabled',
					'.datepicker table tr td.today:hover.disabled',
					'.datepicker table tr td.today.disabled.disabled',
					'.datepicker table tr td.today.disabled:hover.disabled',
					'.datepicker table tr td.today[disabled]',
					'.datepicker table tr td.today:hover[disabled]',
					'.datepicker table tr td.today.disabled[disabled]',
					'.datepicker table tr td.today.disabled:hover[disabled]',
					'.datepicker table tr td.range.today:hover',
					'.datepicker table tr td.range.today:hover:hover',
					'.datepicker table tr td.range.today.disabled:hover',
					'.datepicker table tr td.range.today.disabled:hover:hover',
					'.datepicker table tr td.range.today:active',
					'.datepicker table tr td.range.today:hover:active',
					'.datepicker table tr td.range.today.disabled:active',
					'.datepicker table tr td.range.today.disabled:hover:active',
					'.datepicker table tr td.range.today.active',
					'.datepicker table tr td.range.today:hover.active',
					'.datepicker table tr td.range.today.disabled.active',
					'.datepicker table tr td.range.today.disabled:hover.active',
					'.datepicker table tr td.range.today.disabled',
					'.datepicker table tr td.range.today:hover.disabled',
					'.datepicker table tr td.range.today.disabled.disabled',
					'.datepicker table tr td.range.today.disabled:hover.disabled',
					'.datepicker table tr td.range.today[disabled]',
					'.datepicker table tr td.range.today:hover[disabled]',
					'.datepicker table tr td.range.today.disabled[disabled]',
					'.datepicker table tr td.range.today.disabled:hover[disabled]',
					'.datepicker table tr td.selected:hover',
					'.datepicker table tr td.selected:hover:hover',
					'.datepicker table tr td.selected.disabled:hover',
					'.datepicker table tr td.selected.disabled:hover:hover',
					'.datepicker table tr td.selected:active',
					'.datepicker table tr td.selected:hover:active',
					'.datepicker table tr td.selected.disabled:active',
					'.datepicker table tr td.selected.disabled:hover:active',
					'.datepicker table tr td.selected.active',
					'.datepicker table tr td.selected:hover.active',
					'.datepicker table tr td.selected.disabled.active',
					'.datepicker table tr td.selected.disabled:hover.active',
					'.datepicker table tr td.selected.disabled',
					'.datepicker table tr td.selected:hover.disabled',
					'.datepicker table tr td.selected.disabled.disabled',
					'.datepicker table tr td.selected.disabled:hover.disabled',
					'.datepicker table tr td.selected[disabled]',
					'.datepicker table tr td.selected:hover[disabled]',
					'.datepicker table tr td.selected.disabled[disabled]',
					'.datepicker table tr td.selected.disabled:hover[disabled]',
					'.datepicker table tr td.active:hover',
					'.datepicker table tr td.active:hover:hover',
					'.datepicker table tr td.active.disabled:hover',
					'.datepicker table tr td.active.disabled:hover:hover',
					'.datepicker table tr td.active:active',
					'.datepicker table tr td.active:hover:active',
					'.datepicker table tr td.active.disabled:active',
					'.datepicker table tr td.active.disabled:hover:active',
					'.datepicker table tr td.active.active',
					'.datepicker table tr td.active:hover.active',
					'.datepicker table tr td.active.disabled.active',
					'.datepicker table tr td.active.disabled:hover.active',
					'.datepicker table tr td.active.disabled',
					'.datepicker table tr td.active:hover.disabled',
					'.datepicker table tr td.active.disabled.disabled',
					'.datepicker table tr td.active.disabled:hover.disabled',
					'.datepicker table tr td.active[disabled]',
					'.datepicker table tr td.active:hover[disabled]',
					'.datepicker table tr td.active.disabled[disabled]',
					'.datepicker table tr td.active.disabled:hover[disabled]',
					'.datepicker table tr td span:hover',
					'.tribe-events-list-separator-month',
					'.tribe-events-day .tribe-events-day-time-slot h5',
					'table.tribe-events-calendar th',
					'#tribe-events-content .tribe-events-tooltip h4',
					'.datepicker table th',
					'.datepicker table tr td.active.active',
					'.datepicker table tr td span.active.active',
					'.datepicker table tr td.active.active:hover',
					'.datepicker table tr td span.active.active:hover',
					'.tribe-events-calendar td.mobile-active div[id*=\'tribe-events-daynum-\']',
					'.tribe-events-calendar .tribe-events-present div[id*=\'tribe-events-daynum-\']',
					'#tribe-events-content .tribe-events-tooltip .entry-title',
					'#tribe-events-content .tribe-events-tooltip .tribe-event-title',
					// event calendar pro
					'.tribe-grid-header',
					'.tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-]',
					'.tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-]>a',
					'#tribe-events-photo-events .tribe-event-featured .tribe-events-photo-event-wrap',
					// mailchimp
					'.mc4wp-form-send .material-icons',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					// event calendar pro widget
					'.tribe-mini-calendar thead td',
					'.tribe-mini-calendar tbody td:hover',
					'.tribe-mini-calendar-nav.thead',
					'.tribe-mini-calendar .tribe-events-present',
					'.tribe-mini-calendar .tribe-mini-calendar-today',
					'.tribe-mini-calendar-event .list-date',
					'.tribe-mobile-day-date',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			),
			array(
				'element' => array(
					'.spinner',
					'blockquote',
					'.wp-block-quote',
					'.lava-quote',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar th',
					'.hb-booking-room-details table tfoot',
					'.woocommerce-message',
					'.woocommerce-error',
					'.woocommerce-info',
					'.slick-dots li button',
					'.lava-gallery .slick-slider .slick-arrow',
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.woocommerce-MyAccount-navigation li.is-active a',
				),
				'property' => 'border-color',
				'media_query' => '@media (min-width:1020px)',
				'exclude' => array( '#AFA278' )
			),
			array(
				'element' => array(
					'.loop-post .sticky .post-info:before',
					'.rating-input:before',
					'.rating-input.mousedown span:before',
					'.tp-hotel-booking .star-rating:before',
					'.tp-hotel-booking .star-rating span:before',
					'.woocommerce .star-rating span:before',
					'.lava-gallery .slick-slider .slick-arrow .material-icons',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.lava-dark-background .slick-arrow:hover',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'secondary_color',
		'label'       => esc_html__( 'Secondary Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#F8F7F4',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'blockquote',
					'.wp-block-pullquote',
					'.post-type-archive-hb_room',
					'.wp-hotel-booking-rooms',
					'.sidebar #wp-calendar caption',
					'.sidebar #wp-calendar th',
					'.sidebar #wp-calendar td',
					'.lava-tab',
					'.lava-accordion-active',
					'.lava-toggle-active',
					'.lava-quote',
					'.lava-rooms-grid',
					'.hb_single_room_tabs.expanded li a',
					'.hb-booking-room-details',
					'.hb-checkout-payment',
					'.hotel_checkout_errors',
					'.content-box.price',
					'table.hb_room_pricing_plans',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar',
					'.hb-booking-step',
					'.select2-container--default .select2-results__option--highlighted[data-selected]',
					'.select2-container--default .select2-results__option--highlighted[aria-selected]',
					'.select2-container--default .select2-results__option[data-selected=true]',
					'.select2-container--default .select2-results__option[aria-selected=true]',
					'.wp-block-table.is-style-stripes tr:nth-child(odd)',
					// woocommerce
					'.woocommerce-message',
					'.woocommerce-error',
					'.woocommerce-info',
					'.woocommerce div.product .woocommerce-tabs ul.tabs li a',
					'.woocommerce-cart #payment',
					'.woocommerce-checkout #payment',
					'#add_payment_method #payment',
					// event calendar
					'.datepicker table td',
					'.datepicker table td span',
					'.tribe-events-calendar div[id*=\'tribe-events-daynum-\']',
					'table.tribe-events-calendar td div[id*=\'tribe-events-daynum-\']',
					'#tribe-bar-collapse-toggle',
					'.single-tribe_events .tribe-events-event-meta',
					'.tribe-events-notices',
					// event calendar pro
					'.tribe-grid-allday .tribe-events-week-allday-single',
					'.tribe-grid-body .tribe-events-week-hourly-single',
					'.tribe-grid-allday .tribe-events-week-allday-single:hover',
					'.tribe-grid-body .type-tribe_events .tribe-events-week-hourly-single:hover',
					'.tribe-grid-allday',
					'.tribe-week-today',
					'#tribe-geo-map-wrapper',
					'#tribe-bar-views li.tribe-bar-views-option a:hover',
				),
				'property' => 'background-color',
				'exclude' => array( '#F8F7F4' ),
			),
			array(
				'element' => array(
					'.tribe-mini-calendar th',
					'.tribe-mini-calendar td',
				),
				'property' => 'background-color',
				'exclude' => array( '#F8F7F4' ),
				'suffix' => '!important',
			),
			array(
				'element' => array(
					'.lava-toggle-active',
				),
				'property' => 'box-shadow',
				'value_pattern' => '0 0 0 1px $',
				'exclude' => array( '#F8F7F4' ),
			),
			array(
				'element' => array(
					'.woocommerce-MyAccount-navigation li a',
				),
				'property' => 'background-color',
				'media_query' => '@media (min-width: 1200px)',
				'exclude' => array( '#F8F7F4' ),
			),
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'accent_color',
		'label'       => esc_html__( 'Accent Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.dk-select .dk-select-options::-webkit-scrollbar-thumb',
					'.select2-results__options::-webkit-scrollbar-thumb',
					'[type=checkbox].lava-checkbox:checked+label:after',
					'.woocommerce form .form-row .input-checkbox:checked+label:after',
					'.woocommerce .widget_price_filter .ui-slider .ui-slider-range',
					'#rememberme:checked:after',
					'.lava-accordion-title .material-icons',
					'.lava-toggle-title .material-icons',
					'.hb-booking-details::-webkit-scrollbar-thumb',
					'.hb_single_room_tabs.collapsed li a.active',
					'code,kbd,pre,samp'
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'input[type=text]',
					'input[type=email]',
					'input[type=password]',
					'input[type=number]',
					'input[type=tel]',
					'input[type=search]',
					'textarea',
					'select',
					'.dk-selected',
					'.dk-selected:hover',
					'.dk-selected:focus',
					'.dk-option',
					'.dk-select-options',
					'.dk-optgroup',
					'.dk-select-open-up .dk-selected',
					'.dk-select-open-up .dk-select-options',
					'.dk-select-open-down .dk-select-options',
					'.dk-select-multi:focus .dk-select-options',
					'.dk-select-open-down .dk-selected',
					'.select2-container--default .select2-selection--single',
					'.select2-container--default .select2-search--dropdown .select2-search__field',
					'.select2-dropdown',
					'[type=checkbox].lava-checkbox:checked+label:after',
					'[type=checkbox].lava-checkbox:not(:checked)+label:after',
					'.woocommerce form .form-row .input-checkbox:not(:checked)+label:after',
					'.woocommerce form .form-row .input-checkbox:checked+label:after',
					'.woocommerce div.quantity',
					'.woocommerce div.quantity .qty',
					'.woocommerce div.product .woocommerce-tabs ul.tabs li a',
					'.woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
					'#rememberme:not(:checked):after',
					'#rememberme:checked:after',
					'.lava-tab',
					'.lava-tab-panels',
					'.lava-accordion-item',
					'.lava-toggle',
					'.lava-event-carousel .slick-arrow',
					'.hb_single_room_tabs li a',
					'.hb_single_room_tabs_content',
					'.hb_room_carousel .slick-arrow',
					'.post-pagination .page-nav a',
					'#tribe-bar-views .tribe-bar-views-list',
					'#tribe-bar-views-toggle'
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'input[type=text]:focus',
					'.select2-container .select2-choice:focus',
					'input[type=email]:focus',
					'input[type=password]:focus',
					'input[type=number]:focus',
					'input[type=tel]:focus',
					'input[type=search]:focus',
					'textarea:focus',
					'select:focus',
				),
				'property' => 'box-shadow',
				'value_pattern' => '0 0 5px $',
				'exclude' => array( '0 0 5px #AFA278' )
			),
			array(
				'element' => array(
					'.dk-selected:before',
					'.dk-selected:hover:before',
					'.dk-selected:focus:before',
					'.select2-container--default .select2-selection--single .select2-selection__arrow b',
					'.select2-results__option',
				),
				'property' => 'border-top-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.woocommerce div.product .woocommerce-tabs .panel',
				),
				'property' => 'border-top-color',
				'exclude' => array( '#AFA278' ),
				'media_query' => '@media (min-width: 768px)'
			),
			array(
				'element' => array(
					'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
				),
				'property' => 'border-top-color',
				'exclude' => array( '#AFA278' ),
				'media_query' => '@media (max-width: 767px)'
			),
			array(
				'element' => array(
					'.dk-selected:hover:after',
					'.dk-selected:focus:after',
					'.dk-select-open-up .dk-selected:after',
					'.dk-select-open-down .dk-selected:after',
				),
				'property' => 'border-left-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.dk-select-open-up .dk-selected:before',
					'.dk-select-open-down .dk-selected:before',
					'.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b',

				),
				'property' => 'border-bottom-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.widget_archive ul li:before',
					'.widget_categories ul li:before',
					'.widget_nav_menu ul li:before',
					'.widget_meta ul li:before',
					'.widget_pages ul li:before',
					'.widget_recent_entries ul li:before',
					'.hotel-booking-search .hb_input_field:after',
					'.lava-event-carousel .slick-arrow',
					'#footer .material-icons',
					'.sf-submit .material-icons',
					'.hb_room_carousel .slick-arrow .material-icons',
					'.address .material-icons',
					'.woocommerce .widget_product_categories ul li:before',
					'.woocommerce ul.product_list_widget li .star-rating span:before',
					'.woocommerce ul.cart_list li .star-rating span:before',
					'.post-pagination .page-nav .material-icons',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.post-published .month',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			),
			array(
				'element' => array(
					'.post-published',
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'link_color',
		'label'       => esc_html__( 'Link Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'a',
					'.comment-list .comment-author',
					'.comment-list .comment-reply-login',
					'.post-event .post-title',
					'.post-offer:hover .post-title',
					'#error-404 .error-title',
					'.lava-image-content .lava-icon-wrapper',
					'.lava-testimonial-author',
					'.lava-accordion-title',
					'.lava-toggle-title',
					'.hb_package_toggle',
					'.hotel_booking_mini_cart .hb_mini_cart_item',
					'.hb-booking-room-details table td.hb_search_item_price',
					'.hotel_booking_mini_cart>h3',
					'#hb-payment-form>h3',
					'.woocommerce ul.cart_list li a:not(.remove)',
					'.woocommerce ul.product_list_widget li a:not(.remove)',
					'.woocommerce div.product span.price',
					'.woocommerce div.product p.price',
					'.woocommerce div.product .stock',
					'.woocommerce-cart .cart-collaterals .cart_totals .discount td',
					'.woocommerce-checkout .cart-collaterals .cart_totals .discount td',
					'#add_payment_method .cart-collaterals .cart_totals .discount td',
					'.woocommerce ul.cart_list li .woocommerce-Price-amount',
					'.woocommerce ul.product_list_widget li .woocommerce-Price-amount',
					'.woocommerce ul.products li.product .price',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.lava-service:hover',
					'.lava-social-buttons.style-b a',
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			),
			array(
				'element' => array(
					'.post-tags a',
					'.post-share .social-list i',
					'.widget_product_tag_cloud a',
					'.widget_tag_cloud a',
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.post-share .social-list a'
				),
				'property' => 'color',
				'media_query' => '@media (min-width:1020px)',
				'exclude' => array( '#AFA278' )
			),
			array(
				'element' => array(
					'.post-tags a:hover',
					'.post-share .social-list a:hover i',
					'.no-touchevents .lava-social-buttons.style-b a:hover',
					'.widget_tag_cloud a:hover',
					'.widget_product_tag_cloud a:hover',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.post-published .day',
					'.lava-social-buttons.style-a a',
					'.lava-social-buttons.style-b a',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
				'suffix' => '!important',
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'text_color',
		'label'       => esc_html__( 'Text Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#090909',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'body',
					'.hb-booking-step.hb-booking-active .step-text',
					'.woocommerce div.quantity .minus',
					'.woocommerce div.quantity .plus',
					'.lava-amenity-title',
					'.lava-amenity-description',
					'.tribe-events-grid .type-tribe_events a',
				),
				'property' => 'color',
				'exclude' => array( '#090909' ),
			),
			array(
				'element' => array(
					'.woocommerce-MyAccount-navigation li.is-active a'
				),
				'property' => 'color',
				'exclude' => array( '#FFFFFF' ),
				'media_query' => '@media (min-width:1200px)'
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'secondary_text_color',
		'label'       => esc_html__( 'Secondary Text Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#5e5e5e',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.comment-content table',
					'.post-content table',
					'.comment-content table th',
					'.post-content table th',
					'.post-date',
					'.post-event .event-day',
					'.lava-rooms-grid .price',
					'.hb_search_price',
					'.hb_search_price .hb_search_item_price',
					'.hb_search_capacity',
					'.hb_search_max_child',
					'.hb-booking-room-details table td.hb_search_item_day',
					'.hb-booking-room-details table td.hb_search_item_total_bold',
					'.hb_extra_optional_left .hb_package_title label',
					'.hb_extra_detail_price strong',
					'.hotel_booking_mini_cart .hb_mini_cart_number label',
					'.hotel_booking_mini_cart .hb_mini_cart_price label',
					'.hotel_booking_mini_cart .hb_mini_cart_number span',
					'.hotel_booking_mini_cart .hb_mini_cart_price span',
					'.contact-box',
					'#tribe-bar-views-toggle',
					'#tribe-bar-views .tribe-bar-views-option'
				),
				'property' => 'color',
				'exclude' => array( '#5e5e5e' ),
			),
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'section_heading_color',
		'label'       => esc_html__( 'Section Heading Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.widget-title',
					'.section-heading',
					'.entry-content .title-wrapper',
					'.so-panel .title-wrapper',
					'.hotel_booking_mini_cart>h3',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'post_title_color',
		'label'       => esc_html__( 'Post Title Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.post-title',
					'.post-title a',
					'.title',
					'.title a',
					'.hb_single_room .summary .title',
					'.hb_single_room .summary .title a',
					'.hb_room .title',
					'.hb-room-name',
					'.lava-rooms-grid .lava-room-title a',
					'.lava-post-list .post-title',
					'.lava-service-name',
					'.lava-booking-form-modal .modal-header h2',
					// woocommerce
					'.woocommerce ul.products li.product h3',
					'.woocommerce div.product .product_title',
					// event calendar
					'.tribe-events-page-title',
					'.tribe-events-list .tribe-events-event-cost span',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'primary_btn_color',
		'label'       => esc_html__( 'Primary Button Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.btn-primary',
					'.btn-primary .lds-ring',
					'#comments input#submit',
					'.post-password-form input[type=submit]',
					'.wpcf7-submit',
					'.mc4wp-form-fields input[type=submit]',
					'.woocommerce a.button',
					'.woocommerce button.button',
					'.woocommerce input.button',
					'.woocommerce #respond input#submit',
					'.woocommerce a.added_to_cart',
					'#tribe-bar-form .tribe-bar-submit input[type=submit]',
					'.tribe-events-button',
					'#hb-apply-coupon',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.btn-primary',
					'#comments input#submit',
					'.post-password-form input[type=submit]',
					'.wpcf7-submit',
					'.mc4wp-form-fields input[type=submit]',
					'.btn-primary .lds-ring:hover:before',
					'.woocommerce a.button',
					'.woocommerce button.button',
					'.woocommerce input.button',
					'.woocommerce #respond input#submit',
					'.woocommerce a.button.loading:hover:before',
					'.woocommerce button.button.loading:hover:before',
					'.woocommerce input.button.loading:hover:before',
					'.woocommerce #respond input#submit.loading:hover:before',
					'.woocommerce a.added_to_cart',
					'#tribe-bar-form .tribe-bar-submit input[type=submit]',
					'.tribe-events-button',
					'#hb-apply-coupon',
				),
				'property' => 'border-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.no-touchevents .btn-primary:hover',
					'.no-touchevents .no-touchevents #comments input#submit:hover',
					'.no-touchevents .post-password-form input[type=submit]:hover',
					'.no-touchevents .wpcf7-submit:hover',
					'.no-touchevents .mc4wp-form-fields input[type=submit]:hover',
					'.no-touchevents .woocommerce a.button:hover',
					'.no-touchevents .woocommerce button.button:hover',
					'.no-touchevents .woocommerce input.button:hover',
					'.no-touchevents .woocommerce #respond input#submit:hover',
					'.no-touchevents .woocommerce a.added_to_cart:hover',
					'.no-touchevents #tribe-bar-form .tribe-bar-submit input[type=submit]:hover',
					'.no-touchevents .tribe-events-button:hover',
					'.no-touchevents #hb-apply-coupon:hover',
				),
				'property' => 'color',
				'suffix' => '!important',
				'exclude' => array( '#AFA278' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'primary_btn_hover_color',
		'label'       => esc_html__( 'Primary Button Hover Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#FFFFFF',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.no-touchevents .btn-primary:hover',
					'.no-touchevents .btn-primary .lds-ring:hover',
					'.no-touchevents .no-touchevents #comments input#submit:hover',
					'.no-touchevents .post-password-form input[type=submit]:hover',
					'.no-touchevents .wpcf7-submit:hover',
					'.no-touchevents .mc4wp-form-fields input[type=submit]:hover',
					'.no-touchevents .woocommerce a.button:hover',
					'.no-touchevents .woocommerce button.button:hover',
					'.no-touchevents .woocommerce input.button:hover',
					'.no-touchevents .woocommerce #respond input#submit:hover',
					'.no-touchevents .woocommerce a.added_to_cart:hover',
					'.no-touchevents #tribe-bar-form .tribe-bar-submit input[type=submit]:hover',
					'.no-touchevents .tribe-events-button:hover',
					'.no-touchevents #hb-apply-coupon:hover',
				),
				'property' => 'background',
				'suffix' => '!important',
				'exclude' => array( '#FFFFFF' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'secondary_btn_color',
		'label'       => esc_html__( 'Secondary Button Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#AFA278',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.btn-secondary',
				),
				'property' => 'border-top-color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.btn-secondary',
				),
				'property' => 'color',
				'exclude' => array( '#AFA278' ),
			),
			array(
				'element' => array(
					'.no-touchevents .btn-secondary:hover',
				),
				'property' => 'border-bottom-color',
				'exclude' => array( '#AFA278' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'border_color',
		'label'       => esc_html__( 'Border Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#E8E0C8',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.pagination',
					'.border',
					'.border-top',
					'.border-right',
					'.border-bottom',
					'.border-left',
					'.post-comments',
					'.post-related',
					'.post-content table td',
					'.post-content table th',
					'.post-pagination',
					'.post-style-1',
					'.sidebar .widget-title',
					'.sidebar .section-heading',
					'.woocommerce .products > .section-heading',
					'.hotel_booking_mini_cart',
					'.single-room-section .section-heading',
					'ul.hb-search-results .hb-room',
					'ul.hb_addition_packages_ul li',
					'.hb_addition_package_extra',
					'.hb_related_rooms .widget-title',
					'.hb_related_rooms .section-heading',
					'.hb-checkout-row',
					'#booking-customer',
					'.lava-accordion-panel',
					'.lava-toggle-panel',
					'hr.wp-block-separator',
					'hr.wp-block-separator:not(.is-style-wide):not(.is-style-dots)',
					'.modal-header',
					'.modal-header .close',
					// wocommerce
					'.woocommerce.widget_shopping_cart .total',
					'.woocommerce .widget_shopping_cart .total',
					'.woocommerce-customer-details',
					'.woocommerce .order_details',
					'.woocommerce table.shop_table',
					'#customer_login form.login',
					'#customer_login form.register',
					// event calendar
					'.tribe-events-notices',
					'.tribe-events-list .tribe-events-loop .tribe-event-featured',
					'.tribe-events-list .type-tribe_events',
					'.single-tribe_events .tribe-events-event-meta',
					'#tribe-events-content .tribe-events-calendar td',
					// event calendar pro
					'.tribe-events-grid',
					'.tribe-events-grid .tribe-grid-content-wrap .column',
					'.tribe-grid-header',
					'.tribe-grid-allday .tribe-events-week-allday-single, .tribe-grid-body .tribe-events-week-hourly-single',
					'.tribe-grid-allday',
					'.type-tribe_events.tribe-events-photo-event .tribe-events-photo-event-wrap',
				),
				'property' => 'border-color',
				'exclude' => array( '#E8E0C8' ),
			),
			array(
				'element' => '.content-box.support',
				'property' => 'box-shadow',
				'exclude' => array( '#E8E0C8' ),
				'value_pattern' => 'inset 0 0 0 1px $',
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'form_field_bg_color',
		'label'       => esc_html__( 'Form Field Background Color', 'lava' ),
		'section'     => 'color',
		'default'     => '#FFFFFF',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'input[type=email]',
					'input[type=number]',
					'input[type=password]',
					'input[type=search]',
					'input[type=tel]',
					'input[type=text]',
					'select',
					'textarea',
					'.dk-option',
					'.dk-selected',
					'.hotel-booking-search .hb_input_field:after',
					'#tribe-bar-views li.tribe-bar-views-option a',
					'#tribe-bar-views-toggle',
					'#tribe-bar-views .tribe-bar-views-option'
				),
				'property' => 'background-color',
				'exclude' => array( '#FFFFFF' ),
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'active_content_color',
		'label'       => esc_html__( 'Active Content Background Color', 'lava' ),
		'description' => esc_attr__( 'Recommend to set the same color as the site background.', 'lava' ),
		'section'     => 'color',
		'default'     => '#FFFFFF',
		'priority'    => 10,
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'output'	  => array(
			array(
				'element' => array(
					'.card',
					'.modal-content',
					'.hb_single_room_tabs.expanded li a.active',
					'.hb_single_room_tabs.expanded li a.active:before',
					'.hb_room_carousel .slick-arrow',
					'.lava-tab.lava-active',
					'.lava-tab.lava-active .lava-tab-title:before',
					'.woocommerce div.quantity .plus',
					'.woocommerce div.quantity .minus',
					'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:before',
					'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
					'.datepicker table td.new, .datepicker table td.old',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar td.ui-state-disabled',
					'.tribe-week-grid-hours',
					'.lava-gallery .slick-slider .slick-arrow',
					'.select2-dropdown',
					'.select2-container--default .select2-selection--single',
					'#tribe-bar-views-toggle:hover',
					'#tribe-bar-views .tribe-bar-views-option:hover'
				),
				'property' => 'background',
				'exclude' => array( '#FFFFFF' ),
			),
			array(
				'element' => array(
					'.lava-accordion-title .material-icons',
					'.lava-toggle-title .material-icons',
					'table.hb_room_pricing_plans tbody td',
					'table.hb_room_pricing_plans thead th',
					'.ui-datepicker.ui-widget .ui-datepicker-calendar tbody tr',
					'.datepicker table td',
					'.datepicker table tr td span, .datepicker td',
				),
				'property' => 'border-color',
				'exclude' => array( '#FFFFFF' ),
			),
			array(
				'element' => array(
					'.post-tags a:hover',
					'.post-share .social-list a:hover i',
					'.widget_tag_cloud a:hover',
					'.widget_product_tag_cloud a:hover',
				),
				'property' => 'color',
				'exclude' => array( '#FFFFFF' ),
			)
		)
	);

	// social

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_facebook',
		'label'       => 'Facebook',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_twitter',
		'label'       => 'Twitter',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_twitter_at',
		'label'       => 'Twitter @',
		'description' => esc_attr__( 'Used by Twitter Share link', 'lava' ),
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_googleplus',
		'label'       => 'Google +',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_pinterest',
		'label'       => 'Pinterest',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_linkedin',
		'label'       => 'Linkedin',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_instagram',
		'label'       => 'Instagram',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_flickr',
		'label'       => 'Flickr',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_behance',
		'label'       => 'Behance',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_delicious',
		'label'       => 'Delicious',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_dribbble',
		'label'       => 'Dribbble',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_reddit',
		'label'       => 'Reddit',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_rss',
		'label'       => 'RSS',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_soundcloud',
		'label'       => 'Soundcloud',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_skype',
		'label'       => 'Skype',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_stumbleupon',
		'label'       => 'StumbleUpon',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_tripadvisor',
		'label'       => 'TripAdvisor',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_tumblr',
		'label'       => 'Tumblr',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_vimeo',
		'label'       => 'Vimeo',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_vine',
		'label'       => 'Vine',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_vk',
		'label'       => 'VK',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_whatsapp',
		'label'       => 'WhatsApp',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_wordpress',
		'label'       => 'WordPress',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_youtube',
		'label'       => 'Youtube',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_weibo',
		'label'       => 'Weibo',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'sm_wechat',
		'label'       => 'Weichat',
		'section'     => 'social',
		'default'     => '',
		'priority'    => 10
	);

	// background style

	$controls[] = array(
		'type'        => 'background',
		'settings'    => 'background_setting',
		'label'       => esc_attr__( 'Site Background', 'lava' ),
		'section'     => 'background',
		'default'     => array(
			'background-color'      => '#FFFFFF',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center center',
			'background-size'       => 'initial',
			'background-attachment' => 'scroll',
		),
		'output'      => array( array( 'element' => 'body' ) )
	);

	// header style

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'header_style',
		'label'       => esc_html__( 'Header Style', 'lava' ),
		'section'     => 'header',
		'default'     => '2',
		'priority'    => 10,
		'choices'     => array(
			'1' => esc_html__( 'Style 1', 'lava' ),
			'2' => esc_html__( 'Style 2', 'lava' ),
			'3' => esc_html__( 'Style 3', 'lava' ),
			'4' => esc_html__( 'Style 4', 'lava' ),
		)
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'header_affix',
		'label'       => esc_html__( 'Sticky Header', 'lava' ),
		'section'     => 'header',
		'default'     => false,
		'priority'    => 10,
		'choices'     => array(
			false => esc_html__( 'Normal', 'lava' ),
			true => esc_html__( 'Always', 'lava' ),
			'smart' => esc_html__( 'Smart', 'lava' ),
		)
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'nav_show_search',
		'label'       => esc_html__( 'Nav Show Search Button', 'lava' ),
		'section'     => 'header',
		'default'     => 0,
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'nav_show_button',
		'label'       => esc_html__( 'Nav Show CTA Button', 'lava' ),
		'section'     => 'header',
		'default'     => 0,
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'nav_button_text',
		'label'       => esc_html__( 'Nav CTA Button Text', 'lava' ),
		'section'     => 'header',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'nav_button_url',
		'label'       => esc_html__( 'Nav CTA Button URL', 'lava' ),
		'section'     => 'header',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'nav_menu_text_color',
		'label'       => esc_html__( 'Navbar Text Color', 'lava' ),
		'section'     => 'header',
		'default'     => '',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.nav-menu a',
				'property' => 'color',
				'exclude' => array( '#ffffff' )
			),
			array(
				'element' => array(
					'.nav-menu>.current-menu-ancestor>a:after',
					'.nav-menu>.current-menu-ancestor>a:before',
					'.nav-menu>.current-menu-item>a:after',
					'.nav-menu>.current-menu-item>a:before',
					'.nav-menu>.current-menu-parent>a:after',
					'.nav-menu>.current-menu-parent>a:before',
				),
				'property' => 'border-color',
				'exclude' => array( '#ffffff' )
			),
			array(
				'element' => array(
					'.no-touchevents .nav-menu>li:hover>a:after',
					'.no-touchevents .nav-menu>li:hover>a:before',
					'.no-touchevents .megamenu-submenu>li:hover>a:after',
				),
				'property' => 'border-color',
				'exclude' => array( '#ffffff' )
			),
			array(
				'element' => '.menu-icon span',
				'property' => 'background-color',
				'exclude' => array( '#ffffff' ),
			)
		)
	);


	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'nav_menu_bg_color',
		'label'       => esc_html__( 'Navbar Background Color', 'lava' ),
		'section'     => 'header',
		'default'     => '',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => array(
					'.header-style-2 .header-wrapper',
					'.header-style-3 .header-wrapper',
					'.header-style-4 .header-wrapper'
				),
				'property' => 'background-color'
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'header_placeholder_bg_color',
		'label'       => esc_html__( 'Navbar Placeholder Color', 'lava' ),
		'section'     => 'header',
		'default'     => '#000000',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.header-placeholder',
				'property' => 'background-color',
				'exclude' => array( '#000000' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'nav_submenu_bg_color',
		'label'       => esc_html__( 'Nav Submenu Background Color', 'lava' ),
		'section'     => 'header',
		'default'     => '#AFA278',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array(
					'.nav-menu .sub-menu a',
					'.megamenu',
				),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'nav_submenu_bg_hover_color',
		'label'       => esc_html__( 'Nav Submenu Hover/Active Background Color', 'lava' ),
		'section'     => 'header',
		'default'     => '#9B8F69',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array(
					'.no-touchevents .nav-menu .sub-menu>li:hover>a',
					'.nav-menu .sub-menu>li.active>a',
					'.nav-menu .sub-menu .current-menu-parent>a',
					'.nav-menu .sub-menu .current-menu-item>a',
				),
				'property' => 'background-color',
				'exclude' => array( '#9B8F69' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'nav_submenu_divider_color',
		'label'       => esc_html__( 'Nav Submenu Divider Color', 'lava' ),
		'section'     => 'header',
		'default'     => '#9B8F69',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array(
					'.nav-menu .sub-menu a',
					'.megamenu-submenu a',
				),
				'property' => 'border-top-color',
				'exclude' => array( '#9B8F69' )
			),
			array(
				'element' => array(
					'.megamenu-submenu a',
					'.megamenu-title',
					'.megamenu-widget-area .section-heading',
					'.megamenu-widget-area .widget-title',
				),
				'property' => 'border-bottom-color',
				'exclude' => array( '#9B8F69' )
			)
		)
	);


	// page header settings

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'page_header_image',
		'label'       => esc_html__( 'Global Header Image', 'lava' ),
		'description' => esc_html__( 'overridable by individual page settings.', 'lava' ),
		'section'     => 'page_header',
		'default'     => '',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array( '.page-header' ),
				'property' => 'background-image'
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'page_header_bg',
		'label'       => esc_html__( 'Background Color', 'lava' ),
		'section'     => 'page_header',
		'default'     => '#AFA278',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => array( '.page-header', '.header-placeholder' ),
				'property' => 'background-color',
				'exclude' => array( '#AFA278' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'color',
		'settings'    => 'page_header_overlay',
		'label'       => esc_html__( 'Background Overlay', 'lava' ),
		'section'     => 'page_header',
		'default'     => 'rgba(63,63,63,0.7)',
		'choices'     => array( 'alpha' => true ),
		'transport'   => 'auto',
		'priority'    => 10,
		'output'	  => array(
			array(
				'element' => '.page-header-overlay',
				'property' => 'background-color',
				'exclude' => array( 'rgba(63,63,63,0.7)' )
			)
		)
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'page_header_alignment',
		'label'       => esc_html__( 'Title Alignment', 'lava' ),
		'section'     => 'page_header',
		'default'     => 'left',
		'priority'    => 10,
		'choices'     => array(
			'left' => esc_html__( 'Left', 'lava' ),
			'center' => esc_html__( 'Center', 'lava' ),
			'right' => esc_html__( 'Right', 'lava' ),
		),
		'output'	  => array(
			array(
				'element' => '.page-header .page-title',
				'property' => 'text-align',
				'exclude' => array( 'left' )
			)
		)
	);

	// custom codes

	$controls[] = array(
		'type'        => 'code',
		'settings'    => 'header_code',
		'label'       => esc_html__( 'Header Code', 'lava' ),
		'description' => sprintf( esc_html__( 'Add your before %s code here. e.g. Google Analytics', 'lava' ), '&lt;/head&gt;' ),
		'section'     => 'custom_codes',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'language' => 'html',
			'theme'    => 'monokai'
		)
	);

	$controls[] = array(
		'type'        => 'code',
		'settings'    => 'footer_code',
		'label'       => esc_html__( 'Footer Code', 'lava' ),
		'description' => sprintf( esc_html__( 'Add your before %s code here.', 'lava' ), '&lt;/head&gt;' ),
		'section'     => 'custom_codes',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'language' => 'html',
			'theme'    => 'monokai'
		)
	);

	$controls[] = array(
		'type'        => 'code',
		'settings'    => 'custom_css',
		'label'       => esc_html__( 'Custom CSS', 'lava' ),
		'description' => esc_html__( 'Add your Custom CSS code here. Any Custom CSS entered here will override the theme CSS. In some cases, the !important rules may be needed.', 'lava' ),
		'section'     => 'custom_codes',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'language' => 'css',
			'theme'    => 'monokai'
		)
	);

	/* -----------------------------------------------------------------------------
	 * Hotel Booking
	 * ----------------------------------------------------------------------------- */

	// room general

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'hb_price_prefix',
		'label'       => esc_html__( 'Price Prefix', 'lava' ),
		'section'     => 'hb_general',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'room_type_slug',
		'label'       => esc_html__( 'Room Slug', 'lava' ),
		'description' => esc_html__( 'Make sure to save your permalinks again after changing the slug.', 'lava' ),
		'section'     => 'hb_general',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'room_tax_slug',
		'label'       => esc_html__( 'Room Type Slug', 'lava' ),
		'description' => esc_html__( 'Make sure to save your permalinks again after changing the slug.', 'lava' ),
		'section'     => 'hb_general',
		'default'     => '',
		'priority'    => 10
	);

	// search rooms

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'hb_search_oneline_title',
		'label'       => esc_html__( 'One Line Title', 'lava' ),
		'section'     => 'hb_search',
		'default'     => true,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'hb_search_excerpt_length',
		'label'       => esc_html__( 'Excerpt Length', 'lava' ),
		'section'     => 'hb_search',
		'default'     => 150,
		'priority'    => 10
	);

	// archive rooms
	
	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'hb_archive_header',
		'label'       => esc_html__( 'Header Option', 'lava' ),
		'section'     => 'hb_archive',
		'default'     => 'default',
		'choices' 	  => lava_get_option_page_headers(),
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'hb_archive_header_image',
		'label'       => esc_html__( 'Header Image', 'lava' ),
		'section'     => 'hb_archive',
		'default'     => '',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.post-type-archive-hb_room .page-header',
				'property' => 'background-image'
			)
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'hb_archive_header_shortcode',
		'label'       => esc_html__( 'Slider Shortcode', 'lava' ),
		'section'     => 'hb_archive',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'hb_archive_title',
		'label'       => esc_html__( 'Archive Title', 'lava' ),
		'section'     => 'hb_archive',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'hb_archive_excerpt_length',
		'label'       => esc_html__( 'Excerpt Length', 'lava' ),
		'section'     => 'hb_archive',
		'default'     => 150,
		'priority'    => 10
	);

	// single room

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'hb_single_hide_desc',
		'label'       => esc_html__( 'Hide Description', 'lava' ),
		'section'     => 'hb_single',
		'default'     => false,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'hb_single_hide_info',
		'label'       => esc_html__( 'Hide Additional Information', 'lava' ),
		'section'     => 'hb_single',
		'default'     => false,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'hb_single_hide_reviews',
		'label'       => esc_html__( 'Hide Reviews', 'lava' ),
		'section'     => 'hb_single',
		'default'     => false,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'hb_single_gallery_label',
		'label'       => esc_html__( 'Gallery Label', 'lava' ),
		'section'     => 'hb_single',
		'default'     => esc_html__( 'Room Gallery', 'lava' ),
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'textarea',
		'settings'    => 'hb_contact_info',
		'label'       => esc_html__( 'Contact Info', 'lava' ),
		'section'     => 'hb_single',
		'default'     => '',
		'priority'    => 10
	);

	// woocommerce

	$controls[] = array(
		'type'        => 'toggle',
		'settings'    => 'wc_nav_cart',
		'label'       => esc_html__( 'Show Nav Cart', 'lava' ),
		'section'     => 'wc_general',
		'default'     => true,
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'wc_header',
		'label'       => esc_html__( 'Header Option', 'lava' ),
		'section'     => 'wc_general',
		'default'     => 'default',
		'choices' 	  => lava_get_option_page_headers(),
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'wc_header_image',
		'label'       => esc_html__( 'Header Image', 'lava' ),
		'section'     => 'wc_general',
		'default'     => '',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => '.post-type-archive-hb_room .page-header',
				'property' => 'background-image'
			)
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'wc_header_shortcode',
		'label'       => esc_html__( 'Slider Shortcode', 'lava' ),
		'section'     => 'wc_general',
		'default'     => '',
		'priority'    => 10,
		'active_callback'  => array(
			array(
				'setting'  => 'wc_header',
				'operator' => '==',
				'value'    => 'slider',
			)
		)
	);

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'wc_layout',
		'label'       => esc_html__( 'Layout', 'lava' ),
		'section'     => 'wc_general',
		'default'     => 'full-width',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'wc_product_layout',
		'label'       => esc_html__( 'Layout', 'lava' ),
		'section'     => 'wc_product',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => lava_get_option_layouts()
	);

	$controls[] = array(
		'type'        => 'slider',
		'settings'    => 'wc_related_columns',
		'label'       => esc_html__( 'Related Products Columns', 'lava' ),
		'section'     => 'wc_product',
		'default'     => 3,
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'max'  => 6,
			'step' => 1
		)
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'wc_related_count',
		'label'       => esc_html__( 'Related Products Count', 'lava' ),
		'section'     => 'wc_product',
		'default'     => 3,
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'step' => 1
		)
	);

	$controls[] = array(
		'type'        => 'slider',
		'settings'    => 'wc_upsell_columns',
		'label'       => esc_html__( 'Upsell Products Columns', 'lava' ),
		'section'     => 'wc_product',
		'default'     => 3,
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'max'  => 6,
			'step' => 1
		)
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'wc_upsell_count',
		'label'       => esc_html__( 'Upsell Products Count', 'lava' ),
		'section'     => 'wc_product',
		'default'     => 3,
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'step' => 1
		)
	);

	// event calendar

	$controls[] = array(
		'type'        => 'radio-image',
		'settings'    => 'event_single_layout',
		'label'       => esc_html__( 'Single Event Layout', 'lava' ),
		'section'     => 'event',
		'default'     => 'sidebar-right',
		'priority'    => 10,
		'choices'     => array(
			'sidebar-right' => LAVA_ADMIN_URI . '/assets/images/layouts/s1.png',
			'sidebar-left' => LAVA_ADMIN_URI . '/assets/images/layouts/s2.png'
		)
	);


	// offer post type

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'offer_type_slug',
		'label'       => esc_html__( 'Offer Type Slug', 'lava' ),
		'description' => esc_html__( 'Make sure to save your permalinks again after changing the slug.', 'lava' ),
		'section'     => 'offer',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'offer_tax_slug',
		'label'       => esc_html__( 'Offer Category Slug', 'lava' ),
		'description' => esc_html__( 'Make sure to save your permalinks again after changing the slug.', 'lava' ),
		'section'     => 'offer',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'select',
		'settings'    => 'offer_archive_header',
		'label'       => esc_html__( 'Archive Header Option', 'lava' ),
		'section'     => 'offer',
		'default'     => 'default',
		'choices' 	  => lava_get_option_page_headers(),
		'priority'    => 10,
	);

	$controls[] = array(
		'type'        => 'image',
		'settings'    => 'offer_archive_header_image',
		'label'       => esc_html__( 'Archive Header Image', 'lava' ),
		'section'     => 'offer',
		'default'     => '',
		'priority'    => 10,
		'output' 	  => array(
			array(
				'element' => array( '.post-type-archive-lava_offer .page-header' ),
				'property' => 'background-image'
			)
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'offer_archive_header_shortcode',
		'label'       => esc_html__( 'Slider Shortcode', 'lava' ),
		'section'     => 'offer',
		'default'     => '',
		'priority'    => 10,
		'active_callback'  => array(
			array(
				'setting'  => 'offer_archive_header',
				'operator' => '==',
				'value'    => 'slider',
			)
		)
	);

	$controls[] = array(
		'type'        => 'text',
		'settings'    => 'offer_archive_title',
		'label'       => esc_html__( 'Archive Title', 'lava' ),
		'section'     => 'offer',
		'default'     => '',
		'priority'    => 10
	);

	$controls[] = array(
		'type'        => 'number',
		'settings'    => 'offer_archive_ppp',
		'label'       => esc_html__( 'Archive Posts Per Page', 'lava' ),
		'section'     => 'offer',
		'default'     => 9,
		'priority'    => 10,
		'choices'     => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		)
	);

	return $controls;
}
add_filter( 'kirki_controls', 'lava_customizer_settings' );

/* -----------------------------------------------------------------------------
 * Config customizer
 * ----------------------------------------------------------------------------- */

Kirki::add_config( 'lava', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
));

function lava_kirki_configuration( $config ) {
	return wp_parse_args(array(
		'logo_image'   => '',
		'description'  => 'Lava',
		'color_accent' => '#006799',
		'color_back'   => '#FFFFFF',
		'disable_loader' => true,
		'disable_output' => false,
	));
}
add_filter( 'kirki_config', 'lava_kirki_configuration' );

// add custom css
function lava_dynamic_css( $css ) {
    return Lava_Fonts::get_frontend_style() . $css . get_theme_mod( 'custom_css', '' );
}
add_filter( 'kirki_lava_dynamic_css', 'lava_dynamic_css' );

// add custom fonts
function lava_custom_fonts( $fonts ) {
    $custom_fonts = get_option( 'lava_custom_fonts' );
    if ( !empty( $custom_fonts ) ) {
    	foreach( $custom_fonts as $font ) {
    		if ( isset( $font['family'] ) ) {
    			$font_family = $font['family'];
	    		$fonts[ $font_family ] = array(
	    			'label' => $font_family,
	    			'stack' => $font_family,
	    		);
    		}
    	}
    }
	return $fonts;
}
add_filter( 'kirki_fonts_standard_fonts', 'lava_custom_fonts' );

// add custom google fonts
function lava_custom_google_fonts( $fonts ) {
	$theme_fonts = get_option( 'lava_fonts' );
	if ( !empty( $theme_fonts ) ) {
		foreach ( $theme_fonts as $font ) {
			if ( empty( $font['source'] ) || 'Google' !== $font['source'] ) {
				continue;
			}
			$font_family = $font['family'];

			if ( !empty( $font_family ) ) {
				if ( isset( $fonts[$font_family] ) ) {
					if ( !empty( $font['variants'] ) ) {
						$variants = explode( ',',  $font['variants'] );
						foreach ( $variants as $variant ) {
							if ( in_array( $variant, $fonts[$font_family] ) ) {
								continue;
							} else {
								$fonts[$font_family][] = $variant;
							}
						}
					}
				} else {
					$fonts[$font_family] = explode( ',', $font['variants'] );
				}
			}
		}
	}
	return $fonts;
}
add_filter( 'kirki_enqueue_google_fonts', 'lava_custom_google_fonts' );

function lava_get_option_sidebars() {
    global $wp_registered_sidebars, $lava_option_sidebars;

    if ( isset( $lava_option_sidebars ) ) {
        return $lava_option_sidebars;
    }

    $sidebars = array();

    if ( !empty( $wp_registered_sidebars ) ) {
        foreach ( $wp_registered_sidebars as $sidebar ) {
            if ( $sidebar['id'] == 'footer-1'
                || $sidebar['id'] == 'footer-2'
                || $sidebar['id'] == 'footer-3'
                || $sidebar['id'] == 'footer-4' ) {
            	continue;
            }
            $sidebars[$sidebar['id']] = $sidebar['name'];
        }
    } else {
        $sidebars['default-sidebar'] = esc_html__( 'Default Sidebar', 'lava' );
    }
    $lava_option_sidebars = $sidebars;

    return $sidebars;
}

function lava_get_cat_options() {
	$cats = get_categories( 'hide_empty=0' );
	$cats_array = array();
	foreach ( $cats as $cat ) {
		$cats_array[$cat->term_id] = wp_specialchars_decode( $cat->cat_name );
	}
	return $cats_array;
}

function lava_get_cat_count() {
	$cats = get_categories( 'hide_empty=0' );
	return count( $cats );
}

function lava_get_option_layouts() {
    return array(
        'sidebar-right' => LAVA_ADMIN_URI . '/assets/images/layouts/s1.png',
        'sidebar-left' => LAVA_ADMIN_URI . '/assets/images/layouts/s2.png',
        'full-width' => LAVA_ADMIN_URI . '/assets/images/layouts/s3.png'
    );
}

function lava_get_option_page_headers() {
    return array(
	    'default' => esc_html__( 'Default Header', 'lava' ),
	    'slider' => esc_html__( 'Master Slider', 'lava' ),
	    'image' => esc_html__( 'Fullscreen Image', 'lava' ),
	    'placeholder' => esc_html__( 'Placeholder', 'lava' ),
	    'hide' => esc_html__( 'Hide Header', 'lava' ),
    );
}