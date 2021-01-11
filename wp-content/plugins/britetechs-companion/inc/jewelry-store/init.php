<?php
include('section-all/section-slider.php');
include('section-all/section-service.php');
include('section-all/section-shop.php');
include('section-all/section-testimonial.php');
include('section-all/section-team.php');

function bc_jewelry_store_theme_init(){
	include('customizer/customizer-slider.php');
	include('customizer/customizer-service.php');
	include('customizer/customizer-shop.php');
	include('customizer/customizer-testimonial.php');
	include('customizer/customizer-team.php');
}
add_action('init','bc_jewelry_store_theme_init');