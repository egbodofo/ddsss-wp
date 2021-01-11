<?php 
add_action( 'wp_enqueue_scripts', 'bizmart_theme_css',20);
function bizmart_theme_css() {
	wp_enqueue_style( 'bizmart-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'bizmart-style',get_stylesheet_directory_uri() . '/css/bizmart.css');
  
}