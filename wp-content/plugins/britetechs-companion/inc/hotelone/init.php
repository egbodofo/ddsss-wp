<?php

function bc_jewelry_store_theme_init(){
	/*-------------------------------------------
	***** Main Theme Functions File Includes
	---------------------------------------------*/
	include('theme-functions.php');

	/*-------------------------------------------
	***** Includes Customizer Testimonial File
	---------------------------------------------*/
	include('customizer/sections/customizer-testimonial.php');

	/*-------------------------------------------
	***** Testimonial Section File Includes
	---------------------------------------------*/
	include('section-all/section-testimonial.php');

	/*-------------------------------------------
	***** Includes Customizer Team File
	---------------------------------------------*/
	include('customizer/sections/customizer-team.php');

	/*-------------------------------------------
	***** Team Section File Includes
	---------------------------------------------*/
	include('section-all/section-team.php');
}
add_action('init','bc_jewelry_store_theme_init');