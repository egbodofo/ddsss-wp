<?php

function lava_child_enqueue_styles() {
    wp_enqueue_style( 'lava-child', get_stylesheet_directory_uri() . '/style.css', array( 'lava' ) );
}
add_action( 'wp_enqueue_scripts', 'lava_child_enqueue_styles', 100 );
