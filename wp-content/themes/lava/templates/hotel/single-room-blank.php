<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$search = hb_get_page_permalink( 'search' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

the_content();