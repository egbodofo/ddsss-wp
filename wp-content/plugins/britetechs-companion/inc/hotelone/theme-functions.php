<?php 
function bc_testimonial_default_data(){
	return array(
		array(
			'photo' => 
			array(
               'url' => bc_plugin_url . '/inc/hotelone/img/testi-1.jpg',
                'id' => 51,
             ),
			'name' => 'Kely Wathson',
			'designation' => 'Founder',
			'review' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi … ',
			'link' => '',
		),
	);
}
if( !function_exists('bc_get_section_testimonial_data') ){
	function bc_get_section_testimonial_data(){
		$testimonials = get_theme_mod('hotelone_testimonial_items');
		if (is_string($testimonials)) {
            $testimonials = json_decode($testimonials, true);
        }
		
		$testi_data = array();
		if (!empty($testimonials) && is_array($testimonials)) {
            foreach ($testimonials as $k => $v) {
               $testi_data[] = wp_parse_args($v, array(
                            'photo' => '',
                            'name' => '',
                            'review' => '',
                            'designation' => '',
                            'link' => 0,
                        ));
            }
        }
		return $testi_data;
	}
}

function bc_team_default_data(){
	return array(
		array(
			'image' => 
			array(
               'url' => bc_plugin_url . '/inc/hotelone/img/team1.jpg',
                'id' => 51,
             ),
			'name' => 'Kely Wathson',
			'designation' => 'Founder',
		),
		array(
			'image' => 
			array(
               'url' => bc_plugin_url . '/inc/hotelone/img/team2.jpg',
                'id' => 51,
             ),
			'name' => 'Kely Wathson',
			'designation' => 'Founder',
		),
		array(
			'image' => 
			array(
               'url' => bc_plugin_url . '/inc/hotelone/img/team3.jpg',
                'id' => 51,
             ),
			'name' => 'Kely Wathson',
			'designation' => 'Founder',
		),
	);
}

if( !function_exists('bc_get_section_team_data') ){
	function bc_get_section_team_data(){
		$team = get_theme_mod('hotelone_team_members');
		if (is_string($team)) {
            $team = json_decode($team, true);
        }
		
		$team_data = array();
		if (!empty($team) && is_array($team)) {
            foreach ($team as $k => $v) {
               $team_data[] = wp_parse_args($v, array(
                            'image' => '',
                            'name' => '',
                            'designation' => '',
                            'facebook' => '',
                            'twitter' => '',
                            'google-plus' => '',
                            'linkedin' => '',
                            'link' => '#',
                        ));
            }
        }
		return $team_data;
	}
}

// Demo importing
function bc_hotelone_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Hotelone Data' , 'bc' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'bc' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pt-one-click-demo-import';
	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'bc_hotelone_plugin_page_setup' );

// Set home page and blog page
function bc_hotelone_after_import_setup() {
	$bc_menus = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	set_theme_mod( 'nav_menu_locations', array(
		'primary' => $bc_menus->term_id,
		)
	);

	$frontpage_id = get_page_by_title( 'Home' );
	$blogpage_id  = get_page_by_title( 'Blog' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $frontpage_id->ID );
	update_option( 'page_for_posts', $blogpage_id->ID );
}
add_action( 'pt-ocdi/after_import', 'bc_hotelone_after_import_setup' );

// Demo import file links
function bc_hotelone_demo_content_files() {
	return array(
		array(
			'import_file_name' => 'Default Data',
			'import_file_url' => bc_plugin_url.'inc/hotelone/demo/theme-contents.xml',
			'import_widget_file_url' => bc_plugin_url.'inc/hotelone/demo/theme-widgets.wie',
			'import_customizer_file_url' => bc_plugin_url.'inc/hotelone/demo/theme-customizer.dat',

			'import_preview_image_url' => bc_plugin_url. 'inc/hotelone/demo/screenshot.png',
			'import_notice'              => __( 'Now click on the bottom button to import theme data, After you import this demo, Enjoy the theme.', 'bc' ),
			'preview_url' => '//www.britetechs.com/demo/themes/hotelone-pro/',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'bc_hotelone_demo_content_files' );