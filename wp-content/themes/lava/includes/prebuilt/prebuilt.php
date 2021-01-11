<?php
function lava_prebuilt_layouts( $layouts ) {

    $homepage_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/homepage.json' );
    $homepage = json_decode( $homepage_json, true );

    $layouts['homepage'] = array(
        'name' => esc_html__( 'Default Homepage', 'lava' ),
        'widgets' => $homepage['widgets'],
        'grids' => $homepage['grids'],
        'grid_cells' => $homepage['grid_cells'],
    );

    $homepage_2_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/homepage-2.json' );
    $homepage_2 = json_decode( $homepage_2_json, true );

    $layouts['homepage-2'] = array(
        'name' => esc_html__( 'Homepage 2', 'lava' ),
        'widgets' => $homepage_2['widgets'],
        'grids' => $homepage_2['grids'],
        'grid_cells' => $homepage_2['grid_cells'],
    );

    $about_us_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/about-us.json' );
    $about_us_page = json_decode( $about_us_json, true );

    $layouts['about-us'] = array(
        'name' => esc_html__( 'About Us', 'lava' ),
        'widgets' => $about_us_page['widgets'],
        'grids' => $about_us_page['grids'],
        'grid_cells' => $about_us_page['grid_cells']
    );

    $contact_1_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/contact-1.json' );
    $contact_1_page = json_decode( $contact_1_json, true );

    $layouts['contact-1'] = array(
        'name' => esc_html__( 'Contact 1', 'lava' ),
        'widgets' => $contact_1_page['widgets'],
        'grids' => $contact_1_page['grids'],
        'grid_cells' => $contact_1_page['grid_cells']
    );

    $contact_2_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/contact-2.json' );
    $contact_2_page = json_decode( $contact_2_json, true );

    $layouts['contact-2'] = array(
        'name' => esc_html__( 'Contact 2', 'lava' ),
        'widgets' => $contact_2_page['widgets'],
        'grids' => $contact_2_page['grids'],
        'grid_cells' => $contact_2_page['grid_cells']
    );

    $reservation_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/reservation.json' );
    $reservation_page = json_decode( $reservation_json, true );

    $layouts['reservation'] = array(
        'name' => esc_html__( 'Reservation', 'lava' ),
        'widgets' => $reservation_page['widgets'],
        'grids' => $reservation_page['grids'],
        'grid_cells' => $reservation_page['grid_cells']
    );

    $single_room_1_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-room-1.json' );
    $single_room_1_page = json_decode( $single_room_1_json, true );

    $layouts['single-room-1'] = array(
        'name' => esc_html__( 'Single Room 1', 'lava' ),
        'widgets' => $single_room_1_page['widgets'],
        'grids' => $single_room_1_page['grids'],
        'grid_cells' => $single_room_1_page['grid_cells']
    );

    $single_room_2_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-room-2.json' );
    $single_room_2_page = json_decode( $single_room_2_json, true );

    $layouts['single-room-2'] = array(
        'name' => esc_html__( 'Single Room 2', 'lava' ),
        'widgets' => $single_room_2_page['widgets'],
        'grids' => $single_room_2_page['grids'],
        'grid_cells' => $single_room_2_page['grid_cells']
    );

    $single_offer_json = lava_file_get_contents( LAVA_THEME_DIR .'/includes/prebuilt/layouts/single-offer.json' );
    $single_offer_page = json_decode( $single_offer_json, true );

    $layouts['single-offer'] = array(
        'name' => esc_html__( 'Single Offer', 'lava' ),
        'widgets' => $single_offer_page['widgets'],
        'grids' => $single_offer_page['grids'],
        'grid_cells' => $single_offer_page['grid_cells']
    );

    return $layouts;
}
add_filter( 'siteorigin_panels_prebuilt_layouts','lava_prebuilt_layouts' );

