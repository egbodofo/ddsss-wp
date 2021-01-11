<?php 
/* =============================================================================
   Demo content
   ============================================================================= */
 
// add categories

$demo_cat_1 = Lava_Demo_Generator::add_category(array(
	'name' => 'Lifestyle',
	'parent_id' => 0,
));
$demo_cat_2 = Lava_Demo_Generator::add_category(array(
	'name' => 'Vacation',
	'parent_id' => 0,
));
$demo_cat_3 = Lava_Demo_Generator::add_category(array(
	'name' => 'Food',
	'parent_id' => 0,
));
$demo_cat_4 = Lava_Demo_Generator::add_category(array(
	'name' => 'Travel',
	'parent_id' => 0,
));
$demo_cat_5 = Lava_Demo_Generator::add_category(array(
	'name' => 'Health & Fitness',
	'parent_id' => 0,
));

// add tags

$demo_tags = array( 'Hotel', 'Resort', 'Event', 'Restaurant', 'Spa' );


// add images to media library

$demo_logo = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/lava_logo.png' );
$demo_r_logo = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/lava_logo@2x.png' );
$demo_small_logo = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/lava_small_logo.png' );
$demo_r_small_logo = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/lava_small_logo@2x.png' );
$demo_favicon = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/favicon.png' );
$demo_image = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/demo_image.jpg' );
$demo_footer_logo = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/lava_logo_light.png' );

// get image srcs
$demo_logo_src = wp_get_attachment_image_src( $demo_logo, 'full' );
$demo_r_logo_src = wp_get_attachment_image_src( $demo_r_logo, 'full' );
$demo_small_logo_src = wp_get_attachment_image_src( $demo_small_logo, 'full' );
$demo_r_small_logo_src = wp_get_attachment_image_src( $demo_r_small_logo, 'full' );
$demo_footer_logo_src = wp_get_attachment_image_src( $demo_footer_logo, 'full' );

// set demo options
Lava_Demo_Generator::update_theme_options(array(
	'logo' => $demo_logo_src[0],
	'logo_retina' => $demo_r_logo_src[0],
	'small_logo' => $demo_small_logo_src[0],
	'small_logo_retina' => $demo_r_small_logo_src[0],
	'logo_width' => 80,
	'logo_height' => 80,
));
update_option( 'site_icon', $demo_favicon );


// set permalink structure
update_option( 'permalink_structure', '/%postname%/' );

// set demo fonts
$lava_fonts = array(
	array(
		'family' => 'Oxygen',
		'source' => 'Google',
		'variants' => '300,regular,700',
	),
	array(
		'family' => 'Muli',
		'source' => 'Google',
		'variants' => 'regular,600,700',
	),
);
update_option( 'lava_fonts', $lava_fonts );


// add posts
Lava_Demo_Generator::add_post(array(
 	'title' => 'Sem Porta Mollis Parturient',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_1, $demo_cat_2 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Nullam Lorem Mattis Purus',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_2, $demo_cat_3 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Nibh Sem Sit Ullamcorper',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_3, $demo_cat_4 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Magna pars studiorum',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_4, $demo_cat_5 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Donec luctus imperdiet',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_5, $demo_cat_1 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Sedial eiusmod tempor',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_1 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Eiusmod tempor incidunt',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_1 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Parturient montes',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_2 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Nihilne te nocturnu',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_2 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Diem certam indicere',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_3 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Quodaut hicamet reiciendis',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_3 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Consectetur adipisicing elit',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_4 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Minima vero tenetur autem',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_4 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Illo quia dolorum sint',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_5 ),
 	'tags' => $demo_tags
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Audio Post Format',
 	'featured' => $demo_image,
 	'post_content' => '[audio mp3="http://localhost/lava/wp-content/uploads/2017/03/tequila_10_seconds.mp3"][/audio]
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.

Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.

Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis.',
 	'post_format' => 'audio',
 	'categories' => array( $demo_cat_1 ),
 	'tags' => $demo_tags,
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Video Post Format',
 	'featured' => $demo_image,
 	'post_content' => 'https://vimeo.com/75188030
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.

Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.

Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis.',
 	'post_format' => 'video',
 	'categories' => array( $demo_cat_2 ),
 	'tags' => $demo_tags,
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Gallery Post Format',
 	'featured' => $demo_image,
 	'post_content' => '[gallery ids="'. $demo_image .','. $demo_image .','. $demo_image .','. $demo_image .'" style="bullet"]
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.

Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.

Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis.',
 	'post_format' => 'gallery',
 	'categories' => array( $demo_cat_3 ),
 	'tags' => $demo_tags,
));

Lava_Demo_Generator::add_post(array(
 	'title' => 'Standard Post Format',
 	'featured' => $demo_image,
 	'categories' => array( $demo_cat_4 ),
 	'tags' => $demo_tags,
 	'sticky' => true
));

// panorama page

$demo_page_panorama = Lava_Demo_Generator::add_page(array(
	'title' => 'Panorama',
	'template' => 'page-builder.php',
	'post_content' => 'https://youtu.be/Y48JsWpfrSY',
	'post_meta' => array(
		'_lava_page_container' => 'no_container',
	)
));

// homepage

$icon_service_1 = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/icon_service_1.png' );
$icon_service_2 = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/icon_service_2.png' );
$icon_service_3 = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/icon_service_3.png' );
$icon_360 = Lava_Demo_Generator::add_media_image( 'http://lava.themespirit.com/demo-3/wp-content/uploads/sites/3/2018/05/icon_360.png' );

$homepage_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/homepage.json' );
$homepage_data = str_replace( '#afa278', '#514947', $homepage_data );
$homepage_data = json_decode( $homepage_data, true );
$homepage_data['widgets'][2]['services'][0]['icon_image'] = $icon_service_1;
$homepage_data['widgets'][2]['services'][1]['icon_image'] = $icon_service_2;
$homepage_data['widgets'][2]['services'][2]['icon_image'] = $icon_service_3;
$homepage_data['widgets'][5]['content']['icon_image'] = $icon_360;
$homepage_data['widgets'][5]['image'] = $demo_image;
$homepage_data['widgets'][5]['url'] = 'post: '.$demo_page_panorama;
$homepage_data['widgets'][5]['content']['icon_image'] = $icon_360;

$demo_page_home = Lava_Demo_Generator::add_page(array(
	'title' => 'Homepage',
	'template' => 'page-builder.php',
	'post_meta' => array(
		'_lava_page_header' => 'image',
		'_lava_page_header_image' => $demo_image,
		'_lava_header_title' => 'Welcome To DDSS-APARTMENTS',
		'_lava_header_button_text' => 'Discover',
		'_lava_header_button_url' => '#',
		'_lava_page_container' => 'no_container',
		'panels_data' => $homepage_data,
	)
));

// about us page

$about_us_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/about-us.json' );
$about_us_data = json_decode( $about_us_data, true );
$about_us_data['widgets'][0]['content']['image'] = $demo_image;
$about_us_data['widgets'][1]['content']['image'] = $demo_image;

$demo_page_about_us = Lava_Demo_Generator::add_page(array(
	'title' => 'About Us',
	'template' => 'page-builder.php',
	'post_meta' => array(
		'_lava_page_container' => 'no_container',
		'panels_data' => $about_us_data,
	)
));

// contact form 7

$contact_form_content = lava_file_get_contents( LAVA_THEME_DEMO_DIR .'/3/contents/contact_form.txt' );

$contact_form_id = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Lava contact form',
 	'post_type' => 'wpcf7_contact_form',
 	'post_meta' => array(
 		'_form' => $contact_form_content,
 		'_mail' => array(
			'subject' =>
				/* translators: 1: blog name, 2: [your-subject] */
				sprintf(
					_x( '%1$s "%2$s"', 'mail subject', 'lava' ),
					get_bloginfo( 'name' ), '[your-subject]' ),
			'sender' => sprintf( '[your-name] <%s>', get_option( 'admin_email' ) ),
			'body' =>
				/* translators: %s: [your-name] <[your-email]> */
				sprintf( __( 'From: %s', 'lava' ),
					'[your-name] <[your-email]>' ) . "\n"
				/* translators: %s: [your-subject] */
				. sprintf( __( 'Subject: %s', 'lava' ),
					'[your-subject]' ) . "\n\n"
				. __( 'Message Body:', 'lava' )
					. "\n" . '[your-message]' . "\n\n"
				. '-- ' . "\n"
				/* translators: 1: blog name, 2: blog URL */
				. sprintf(
					__( 'This e-mail was sent from a contact form on %1$s (%2$s)', 'lava' ),
					get_bloginfo( 'name' ),
					home_url()
				),
			'recipient' => get_option( 'admin_email' ),
			'additional_headers' => 'Reply-To: [your-email]',
			'attachments' => '',
			'use_html' => 0,
			'exclude_blank' => 0,
 		)
 	)
));

// contact us page

$contact_us_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/contact-2.json' );
$contact_us_data = str_replace( '[contact-form-7 id="1"', '[contact-form-7 id="'. $contact_form_id .'"', $contact_us_data );
$contact_us_data = str_replace( '#f8f7f4', '#191919', $contact_us_data );
$contact_us_data = str_replace( '#afa278', '#b7e0ea', $contact_us_data );
$contact_us_data = json_decode( $contact_us_data, true );

$demo_page_contact_us = Lava_Demo_Generator::add_page(array(
	'title' => 'Contact Us',
	'template' => 'page-builder.php',
	'post_meta' => array(
		'_lava_page_container' => 'no_container',
		'panels_data' => $contact_us_data,
	)
));

// reservation page

$reservation_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/reservation.json' );
$reservation_data = str_replace( '#afa278', '#b7e0ea', $reservation_data );
$reservation_data = json_decode( $reservation_data, true );

$demo_page_reservation = Lava_Demo_Generator::add_page(array(
	'title' => 'Reservation',
	'template' => 'page-builder.php',
	'post_meta' => array(
		'_lava_page_container' => 'no_container',
		'panels_data' => $reservation_data,
	)
));

// elements page


$elements_data = lava_file_get_contents( LAVA_THEME_DEMO_DIR .'/3/contents/elements.json' );
$elements_data = json_decode( $elements_data, true );

$demo_page_elements = Lava_Demo_Generator::add_page(array(
	'title' => 'Elements',
	'template' => 'page-builder.php',
	'post_meta' => array(
		'_lava_page_layout' => 'full-width',
		'_lava_page_container' => 'container',
		'panels_data' => $elements_data,
	)
));

// blog page

$demo_page_blog = Lava_Demo_Generator::add_page(array(
	'title' => 'Blog',
	'post_meta' => array(
		'_lava_page_layout' => 'sidebar-right',
	)
));

// set blog page

Lava_Demo_Generator::set_static_homepage( $demo_page_home );
Lava_Demo_Generator::set_blog_page( $demo_page_blog );


// room types

$hb_type_single_room = Lava_Demo_Generator::add_term( 'Single Room', 'hb_room_type' );
$hb_type_double_room = Lava_Demo_Generator::add_term( 'Double Room', 'hb_room_type' );
$hb_type_twin_room = Lava_Demo_Generator::add_term( 'Twin Room', 'hb_room_type' );
$hb_type_family_room = Lava_Demo_Generator::add_term( 'Family Room', 'hb_room_type' );
$hb_type_suite = Lava_Demo_Generator::add_term( 'Suite', 'hb_room_type' );

// room capacity

$hb_cap_single = Lava_Demo_Generator::add_term(
	'Single',
	'hb_room_capacity',
	array(),
	array(
		'hb_max_number_of_adults' => 1,
		'alias_of' => 2
	)
);

$hb_cap_double = Lava_Demo_Generator::add_term(
	'Double',
	'hb_room_capacity',
	array(),
	array(
		'hb_max_number_of_adults' => 2,
	)
);

$hb_cap_family = Lava_Demo_Generator::add_term(
	'Family',
	'hb_room_capacity',
	array(),
	array(
		'hb_max_number_of_adults' => 3,
	)
);

$hb_cap_twin = Lava_Demo_Generator::add_term(
	'Twin',
	'hb_room_capacity',
	array(),
	array(
		'hb_max_number_of_adults' => 2,
	)
);

$hb_cap_suite = Lava_Demo_Generator::add_term(
	'Suite',
	'hb_room_capacity',
	array(),
	array(
		'hb_max_number_of_adults' => 3,
	)
);

// additional packages

$hb_extra_1 = Lava_Demo_Generator::add_custom_post_type(array(
	'title' => 'Car Park',
	'post_type' => 'hb_extra_room',
	'post_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
	'post_meta' => array(
		'tp_hb_extra_room_price' => 15,
		'tp_hb_extra_room_respondent_name' => 'Car / Night',
		'tp_hb_extra_room_respondent' => 'number',
		'tp_hb_extra_room_selected' => 1,
	)
));

$hb_extra_2 = Lava_Demo_Generator::add_custom_post_type(array(
	'title' => 'Wifi',
	'post_type' => 'hb_extra_room',
	'post_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
	'post_meta' => array(
		'tp_hb_extra_room_price' => 10,
		'tp_hb_extra_room_respondent_name' => 'Room / Night',
		'tp_hb_extra_room_respondent' => 'number',
		'tp_hb_extra_room_selected' => 1,
	)
));

$hb_extra_3 = Lava_Demo_Generator::add_custom_post_type(array(
	'title' => 'Airport Transfers',
	'post_type' => 'hb_extra_room',
	'post_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
	'post_meta' => array(
		'tp_hb_extra_room_price' => 50,
		'tp_hb_extra_room_respondent_name' => 'Group / Trip',
		'tp_hb_extra_room_respondent' => 'trip',
		'tp_hb_extra_room_selected' => 1,
	)
));


// rooms

$hb_room_content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Curabitur blandit tempus porttitor. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus nibh Curabitur blandit tempus porttitor.
Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac blandit Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac blandit tempus.';

$hb_room_addition_information = 'Lorem ipsum dolor sit amet, tollit contentiones nec ne, ad has dicta voluptaria, eos cu regione scribentur suscipiantur. Quo homero expetenda ei. Idque maiorum quo ut. Ex debitis adversarium theophrastus vel.
';

$room_excerpt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua, ut enim ad minim veniam.';

$single_room_1_panels_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-room-1.json' );
$single_room_1_panels_data = str_replace( '#f8f7f4', '#191919', $single_room_1_panels_data );
$single_room_1_panels_data = json_decode( $single_room_1_panels_data, true );
$single_room_2_panels_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-room-2.json' );
$single_room_2_panels_data = str_replace( '#f8f7f4', '#191919', $single_room_2_panels_data );
$single_room_2_panels_data = str_replace(
	'{"image":1000},{"image":1000},{"image":1000},{"image":1000},{"image":1000}',
	'{"image":'. $demo_image .'},{"image":'. $demo_image .'},{"image":'. $demo_image .'},{"image":'. $demo_image .'},{"image":'. $demo_image .'}',
	$single_room_2_panels_data
);
$single_room_2_panels_data = json_decode( $single_room_2_panels_data, true );

$hb_room_standard_single = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Standard Single',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_single_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_single,
	 	'_hb_max_child_per_room' => 1,
	 	'_hb_max_adults_per_room' => 1,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_superior_single = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Superior Single',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_single_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_single,
	 	'_hb_max_child_per_room' => 1,
	 	'_hb_max_adults_per_room' => 1,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_deluxe_single = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Deluxe Single',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_single_room,
 	'post_meta' => array(
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'custom',
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_single,
	 	'_hb_max_child_per_room' => 1,
	 	'_hb_max_adults_per_room' => 1,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_1_panels_data,
 	)
));

$hb_room_standard_double = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Standard Double',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_double_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => false,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_double,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_superior_double = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Superior Double',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_double_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_double,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_deluxe_double = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Deluxe Double',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_double_room,
 	'post_meta' => array(
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'custom',
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_double,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_1_panels_data,
 	)
));

$hb_room_standard_twin = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Standard Twin',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_twin_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_twin,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_superior_twin = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Superior Twin',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_twin_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_twin,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_deluxe_twin = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Deluxe Twin',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_twin_room,
 	'post_meta' => array(
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'custom',
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_twin,
	 	'_hb_max_child_per_room' => 2,
	 	'_hb_max_adults_per_room' => 2,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_1_panels_data,
 	)
));

$hb_room_standard_family = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Standard Family',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_family_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_family,
	 	'_hb_max_child_per_room' => 4,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_superior_family = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Superior Family',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_family_room,
 	'post_meta' => array(
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
 		'_lava_room_tabs' => true,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_family,
	 	'_hb_max_child_per_room' => 4,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
 	)
));

$hb_room_deluxe_family = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Deluxe Family',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'post_content' => $hb_room_content,
 	'room_type' => $hb_type_family_room,
 	'post_meta' => array(
 		'_lava_page_header' => 'placeholder',
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'blank',
 		'_lava_room_type_title' => esc_html__( 'Room', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_family,
	 	'_hb_max_child_per_room' => 4,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_2_panels_data,
 	)
));

$hb_room_junior_suite = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Junior',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'room_type' => $hb_type_suite,
 	'post_meta' => array(
 		'_lava_page_header' => 'placeholder',
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'blank',
 		'_lava_room_type_title' => esc_html__( 'Suite', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_suite,
	 	'_hb_max_child_per_room' => 5,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_2_panels_data,
 	)
));

$hb_room_executive_suite = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Executive',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'room_type' => $hb_type_suite,
 	'post_meta' => array(
 		'_lava_page_header' => 'placeholder',
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'blank',
 		'_lava_room_type_title' => esc_html__( 'Suite', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_suite,
	 	'_hb_max_child_per_room' => 5,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_2_panels_data,
 	)
));

$hb_room_presidential_suite = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Presidential',
 	'featured' => $demo_image,
 	'post_type' => 'hb_room',
 	'room_type' => $hb_type_suite,
 	'post_meta' => array(
 		'_lava_page_container' => 'no_container',
 		'_lava_page_layout' => 'custom',
 		'_lava_room_type_title' => esc_html__( 'Suite', 'lava' ),
 		'_lava_room_excerpt' => $room_excerpt,
	 	'_hb_num_of_rooms' => 50,
	 	'_hb_room_capacity' => $hb_cap_suite,
	 	'_hb_max_child_per_room' => 5,
	 	'_hb_max_adults_per_room' => 3,
	 	'_hb_room_addition_information' => $hb_room_addition_information,
	 	'_hb_room_extra' => array( $hb_extra_1, $hb_extra_2, $hb_extra_3 ),
	 	'_hb_gallery' => array( $demo_image ),
	 	'panels_data' => $single_room_1_panels_data,
 	)
));


// set pricing plans

// single
hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_standard_single,
	'pricing' => array( 120, 100, 100, 100, 100, 100, 120 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_superior_single,
	'pricing' => array( 180, 150, 150, 150, 150, 150, 180 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_deluxe_single,
	'pricing' => array( 240, 200, 200, 200, 200, 200, 240 )
));

// double
hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_standard_double,
	'pricing' => array( 200, 180, 180, 180, 180, 180, 200 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_superior_double,
	'pricing' => array( 260, 230, 230, 230, 230, 230, 260 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_deluxe_double,
	'pricing' => array( 320, 280, 280, 280, 280, 280, 320 )
));

// twin
hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_standard_twin,
	'pricing' => array( 220, 200, 200, 200, 200, 200, 220 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_superior_twin,
	'pricing' => array( 280, 250, 250, 250, 250, 250, 280 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_deluxe_twin,
	'pricing' => array( 340, 300, 300, 300, 300, 300, 340 )
));

// twin
hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_standard_family,
	'pricing' => array( 270, 250, 250, 250, 250, 250, 270 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_superior_family,
	'pricing' => array( 320, 300, 300, 300, 300, 300, 320 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_deluxe_family,
	'pricing' => array( 420, 400, 400, 400, 400, 400, 420 )
));

// suite
hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_junior_suite,
	'pricing' => array( 500, 400, 400, 400, 400, 400, 500 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_executive_suite,
	'pricing' => array( 700, 600, 600, 600, 600, 600, 700 )
));

hb_room_set_pricing_plan(array(
	'room_id' => $hb_room_presidential_suite,
	'pricing' => array( 1000, 800, 800, 800, 800, 800, 1000 )
));

// booking pages

$demo_page_hb_search = Lava_Demo_Generator::add_page(array(
	'title' => 'Check Availability',
	'template' => 'page-hb-search.php',
	'post_content' => '[hotel_booking]',
	'post_meta' => array(
		'_lava_page_sidebar' => 'hb-sidebar',
	)
));

$demo_page_hb_cart = Lava_Demo_Generator::add_page(array(
	'title' => 'View Cart',
	'template' => 'page-hb-cart.php',
	'post_content' => '[hotel_booking_cart]',
	'post_meta' => array(
		'_lava_page_sidebar' => 'hb-sidebar',
	)
));

$demo_page_hb_checkout = Lava_Demo_Generator::add_page(array(
	'title' => 'Checkout',
	'template' => 'page-hb-checkout.php',
	'post_content' => '[hotel_booking_checkout]',
	'post_meta' => array(
		'_lava_page_sidebar' => 'hb-sidebar',
	)
));

$demo_page_hb_account = Lava_Demo_Generator::add_page(array(
	'title' => 'My Account',
	'post_content' => '[hotel_booking_account]',
	'post_meta' => array(
		'_lava_page_header' => 'placeholder',
		'_lava_page_layout' => 'full-width'
	)
));

$demo_page_hb_terms = Lava_Demo_Generator::add_page(array(
	'title' => 'Terms and Conditions',
	'post_content' => $hb_room_content,
	'post_meta' => array(
		'_lava_page_header' => 'placeholder',
		'_lava_page_layout' => 'full-width'
	)
));

$demo_page_hb_thank_you = Lava_Demo_Generator::add_page(array(
	'title' => 'Thank You!',
	'post_content' => '[hotel_booking_thankyou]',
	'post_meta' => array(
		'_lava_page_header' => 'placeholder',
		'_lava_page_layout' => 'full-width'
	)
));

update_option( 'tp_hotel_booking_search_page_id', $demo_page_hb_search );
update_option( 'tp_hotel_booking_cart_page_id', $demo_page_hb_cart );
update_option( 'tp_hotel_booking_checkout_page_id', $demo_page_hb_checkout );
update_option( 'tp_hotel_booking_account_page_id', $demo_page_hb_account );
update_option( 'tp_hotel_booking_terms_page_id', $demo_page_hb_terms );
update_option( 'tp_hotel_booking_thankyou_page_id', $demo_page_hb_thank_you );

// add menus

$demo_main_menu_id = Lava_Demo_Generator::add_menu( 'lava-demo-main', array( 'main', 'fullscreen' ) );
$demo_left_menu_id = Lava_Demo_Generator::add_menu( 'lava-demo-left', array( 'left' ) );
$demo_right_menu_id = Lava_Demo_Generator::add_menu( 'lava-demo-right', array( 'right' ) );
$demo_footer_menu_id = Lava_Demo_Generator::add_menu( 'lava-demo-footer' );

// add main menu items

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Home',
		'url' => home_url( '/', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_pages = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Pages',
		'url' => '#',
	)
);

$demo_menu_item_reservation = Lava_Demo_Generator::add_menu_page(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_reservation,
	)
);

$demo_menu_item_about_us = Lava_Demo_Generator::add_menu_page(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_about_us,
	)
);

$demo_menu_item_elements = Lava_Demo_Generator::add_menu_page(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_elements,
	)
);

$demo_menu_item_404 = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'title' => '404 Page',
		'url' => home_url( '/404', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_rooms = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Rooms',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 1',
		'url' => get_permalink( get_post( $hb_room_presidential_suite ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 2',
		'url' => get_permalink( get_post( $hb_room_executive_suite ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 3',
		'url' => get_permalink( get_post( $hb_room_standard_single ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 4',
		'url' => get_permalink( get_post( $hb_room_standard_double ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Rooms Archive',
		'url' => home_url( '/rooms', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_events = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Events',
		'url' => home_url( '/event', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_offers = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Offers',
		'url' => home_url( '/offer', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_blog = Lava_Demo_Generator::add_menu_page(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'page_id' => $demo_page_blog,
	)
);

$demo_menu_item_contact_us = Lava_Demo_Generator::add_menu_page(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Contact',
		'page_id' => $demo_page_contact_us,
	)
);

$demo_menu_item_lang_en = Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'EN',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'DE',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'FR',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_main_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'IT',
		'url' => '#',
	)
);

// add left menu items

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Home',
		'url' => home_url( '/', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_pages = Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Pages',
		'url' => '#',
	)
);

$demo_menu_item_reservation = Lava_Demo_Generator::add_menu_page(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_reservation,
	)
);

$demo_menu_item_about_us = Lava_Demo_Generator::add_menu_page(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_about_us,
	)
);

$demo_menu_item_elements = Lava_Demo_Generator::add_menu_page(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'page_id' => $demo_page_elements,
	)
);

$demo_menu_item_404 = Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_pages,
		'title' => '404 Page',
		'url' => home_url( '/404', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_rooms = Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Rooms',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 1',
		'url' => get_permalink( get_post( $hb_room_presidential_suite ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 2',
		'url' => get_permalink( get_post( $hb_room_executive_suite ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 3',
		'url' => get_permalink( get_post( $hb_room_standard_single ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Single Room 4',
		'url' => get_permalink( get_post( $hb_room_standard_double ) ),
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => $demo_menu_item_rooms,
		'title' => 'Rooms Archive',
		'url' => home_url( '/rooms', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_events = Lava_Demo_Generator::add_menu_link(
	$demo_left_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Events',
		'url' => home_url( '/events/month', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_offers = Lava_Demo_Generator::add_menu_link(
	$demo_right_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Offers',
		'url' => home_url( '/offer', Lava_Util::$http_or_https ),
	)
);

$demo_menu_item_blog = Lava_Demo_Generator::add_menu_page(
	$demo_right_menu_id,
	array(
		'parent_id' => 0,
		'page_id' => $demo_page_blog,
	)
);

$demo_menu_item_contact_us = Lava_Demo_Generator::add_menu_page(
	$demo_right_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Contact',
		'page_id' => $demo_page_contact_us,
	)
);

$demo_menu_item_lang_en = Lava_Demo_Generator::add_menu_link(
	$demo_right_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'EN',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_right_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'DE',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_right_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'FR',
		'url' => '#',
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_right_menu_id,
	array(
		'parent_id' => $demo_menu_item_lang_en,
		'title' => 'IT',
		'url' => '#',
	)
);


// add footer menu items

Lava_Demo_Generator::add_menu_page(
	$demo_footer_menu_id,
	array(
		'parent_id' => 0,
		'page_id' => $demo_page_reservation,
	)
);

Lava_Demo_Generator::add_menu_link(
	$demo_footer_menu_id,
	array(
		'parent_id' => 0,
		'title' => 'Rooms',
		'url' => home_url( '/rooms', Lava_Util::$http_or_https ),
	)
);

Lava_Demo_Generator::add_menu_page(
	$demo_footer_menu_id,
	array(
		'parent_id' => 0,
		'page_id' => $demo_page_about_us,
	)
);


// add widgets to default sidebar

Lava_Demo_Generator::add_widget_to_sidebar(
	'default-sidebar',
	'search',
	array(
		'title' => '',
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'default-sidebar',
	'recent-posts',
	array(
		'title' => 'Recent Posts',
		'number' => 5,
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'default-sidebar',
	'categories',
	array(
		'title' => 'Categories',
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'default-sidebar',
	'tag_cloud',
	array(
		'title' => 'Tags',
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'default-sidebar',
	'archives',
	array(
		'title' => 'Archives',
	)
);


// wp hotel booking widgets

Lava_Demo_Generator::add_widget_to_sidebar(
	'hb-sidebar',
	'hb_widget_cart',
	array(
		'title' => ''
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'hb-sidebar',
	'hb_widget_search',
	array(
		'title' => 'Check Availability',
		'show_title' => 0,
		'show_label' => 0,
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'hb-sidebar',
	'text',
	array(
		'title' => '',
		'text' => '<div class="content-box border"><div class="contact-box"><p>RESERVATION SUPPORT</p><p><b>+855 123 456 78</b></p></div></div>',
	)
);

// add widgets to footer

Lava_Demo_Generator::add_widget_to_sidebar(
	'footer-1',
	'text',
	array(
		'title' => '',
		'text' => '<div class="center-align"><img width="102" height="68" src="'. $demo_footer_logo_src[0] .'" alt="Lava Logo"></div>',
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'footer-1',
	'lava-social-buttons',
	array(
		'alignment' => 'center'
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'footer-2',
	'text',
	array(
		'title' => 'Get In Touch',
		'text' => '<p class="address"><i class="material-icons">near_me</i>205 West 21th Street, MIAMI FL</p><p class="address"><i class="material-icons">call</i>+855 123 456 789</p><p class="address"><i class="material-icons">email</i>info@lavahotel.com</p>',
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'footer-3',
	'nav_menu',
	array(
		'title' => 'About Us',
		'nav_menu' => $demo_footer_menu_id,
	)
);

Lava_Demo_Generator::add_widget_to_sidebar(
	'footer-4',
	'mc4wp_form_widget',
	array(
		'title' => 'Newsletter',
	)
);


// offers

if ( class_exists( 'Lava_Custom_Post_Types' ) ) {
	$offer_panels_data = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-offer.json' );
	$offer_panels_data = str_replace( '#afa278', '#b7e0ea', $offer_panels_data );
	$offer_panels_data = json_decode( $offer_panels_data, true );

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Friday Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
	 		'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$50',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Drinks Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
	 		'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$50',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Kids Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
		 	'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$100',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Birthday Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
		 	'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$100',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Spa Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
		 	'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$50',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));

	Lava_Demo_Generator::add_custom_post_type(array(
	 	'title' => 'Wedding Package',
	 	'featured' => $demo_image,
	 	'post_type' => 'lava_offer',
	 	'post_meta' => array(
		 	'_lava_page_container' => 'no_container',
		 	'_lava_offer_price' => '$200',
		 	'_lava_offer_price_unit' => '/ Per Person',
		 	'panels_data' => $offer_panels_data,
	 	)
	));
}


// events

if ( !defined( 'TRIBE_EVENTS_FILE' ) ) {
	return;
}

$tribe_options = get_option( 'tribe_events_calendar_options' );

if ( isset( $tribe_options ) && is_array( $tribe_options ) ) {
	$tribe_options['stylesheetOption'] = 'skeleton';
	$tribe_options['hideSubsequentRecurrencesDefault'] = true;
	$tribe_options['tribeEventsTemplate'] = '';
}

update_option( 'tribe_events_calendar_options', $tribe_options );

$event_content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';

$event_year = date( 'Y' );

$event_venue_1 = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Lava Hotel',
 	'post_type' => 'tribe_venue',
 	'post_content' => $event_content,
 	'post_meta' => array(
	 	'_VenueOrigin' => 'events-calendar',
	 	'_VenueAddress' => '1234 Apple Avenue',
	 	'_VenueCity' => 'New York',
	 	'_VenueCountry' => 'United States',
	 	'_VenueState' => 'NY',
	 	'_VenueZip' => '111111',
	 	'_VenuePhone' => '800-123-4567',
	 	'_VenueURL' => 'https://lava.themespirit.com',
	 	'_VenueShowMap' => 'true',
 	),
));

$event_organizer_1 = Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Lava Hotel',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_organizer',
 	'post_content' => $event_content,
 	'post_meta' => array(
	 	'_OrganizerOrigin' => 'events-calendar',
	 	'_OrganizerOrganizerID' => '1001',
	 	'_OrganizerPhone' => '800-123-4567',
	 	'_OrganizerWebsite' => 'http://lava.themespirit.com',
	 	'_OrganizerEmail' => 'support@themespirit.com',
 	),
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Gentle Party',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-03-18 08:00:00',
	 	'_EventEndDate' => $event_year .'-03-18 11:00:00',
	 	'_EventCurrencySymbol' => '$',
	 	'_EventCost' => '20',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-05-18 08:00:00',
	 				'EventEndDate' => $event_year .'-05-18 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	),
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Kids Festival',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-04-01 08:00:00',
	 	'_EventEndDate' => $event_year .'-04-01 11:00:00',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-06-01 08:00:00',
	 				'EventEndDate' => $event_year .'-06-01 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Sky At Night',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-04-20 08:00:00',
	 	'_EventEndDate' => $event_year .'-04-20 11:00:00',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-07-20 08:00:00',
	 				'EventEndDate' => $event_year .'-07-20 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Cocktail Jam',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-04-23 08:00:00',
	 	'_EventEndDate' => $event_year .'-04-23 11:00:00',
	 	'_EventCurrencySymbol' => '$',
	 	'_EventCost' => '100',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-09-23 08:00:00',
	 				'EventEndDate' => $event_year .'-09-23 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Italian Love',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-05-20 08:00:00',
	 	'_EventEndDate' => $event_year .'-05-20 11:00:00',
	 	'_EventCurrencySymbol' => '$',
	 	'_EventCost' => '80',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-05-20 08:00:00',
	 				'EventEndDate' => $event_year .'-05-20 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Music Concert',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-05-10 19:00:00',
	 	'_EventEndDate' => $event_year .'-05-10 23:00:00',
	 	'_EventCurrencySymbol' => '$',
	 	'_EventCost' => '50',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'montly' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-05-10 19:00:00',
	 				'EventEndDate' => $event_year .'-05-10 23:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));


Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Yoga Day',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-06-21 00:00:00',
	 	'_EventEndDate' => $event_year .'-06-21 23:59:59',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'year' => array(
	 						'month' => '6',
	 						'filter' => ''
	 					),
	 					'same-time' => 'yes',
	 					'type' => 'Yearly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-06-21 00:00:00',
	 				'EventEndDate' => $event_year .'-06-21 23:59:59'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));

Lava_Demo_Generator::add_custom_post_type(array(
 	'title' => 'Guided Tour',
 	'featured' => $demo_image,
 	'post_type' => 'tribe_events',
 	'post_content' => $event_content,
 	'post_category' => array( $demo_cat_2, $demo_cat_3 ),
 	'post_meta' => array(
	 	'_EventOrigin' => 'events-calendar',
	 	'_EventShowMapLink' => '1',
	 	'_EventShowMap' => '1',
	 	'_EventStartDate' => $event_year .'-03-03 08:00:00',
	 	'_EventEndDate' => $event_year .'-03-03 11:00:00',
	 	'_EventURL' => 'http://lava.themespirit.com',
	 	'_EventTimezone' => '',
	 	'_EventOrganizerID' => $event_organizer_1,
	 	'_EventVenueID' => $event_venue_1,
	 	'_EventRecurrence' => array(
	 		'rules' => array(
	 			array(
	 				'type' => 'Custom',
	 				'custom' => array(
	 					'interval' => 1,
	 					'month' => array(),
	 					'same-time' => 'yes',
	 					'type' => 'Monthly',
	 				),
	 				'end-type' => 'Never',
	 				'EventStartDate' => $event_year .'-03-03 08:00:00',
	 				'EventEndDate' => $event_year .'-03-03 11:00:00'
	 			)
	 		),
	 		'exclusions' => array(),
	 		'description' => ''
	 	),
 	)
));