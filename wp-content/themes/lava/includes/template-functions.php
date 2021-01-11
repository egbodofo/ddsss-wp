<?php

if ( ! function_exists( 'wp_body_open' ) ) {
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' );
    }
}

if ( ! function_exists( 'lava_body_class' ) ) {
    /**
     * Add extra body class
     *
     */
    function lava_body_class( $classes ) {
        $loader_style = Lava_Util::get_option( 'loader' );
        if ( !empty( $loader_style ) ) {
            $classes[] = 'page-loading';
        }
        $classes[] = 'header-' . Lava_Util::get_option( 'header_style', '2' );
        return $classes;
    }
}

if ( ! function_exists( 'lava_output_content_wrapper_start' ) ) {
    /**
     * Output the start of the page wrapper.
     *
     */
    function lava_output_content_wrapper_start() {
        Lava(); // set page
        get_template_part( 'templates/global/wrapper-start' );
    }
}

if ( ! function_exists( 'lava_output_content_wrapper_end' ) ) {
    /**
     * Output the end of the page wrapper.
     *
     */
    function lava_output_content_wrapper_end() {
        get_template_part( 'templates/global/wrapper-end' );
    }
}

if ( ! function_exists( 'lava_output_container_start' ) ) {
    /**
     * Output the start of the page wrapper.
     *
     */
    function lava_output_container_start() {
        if ( Lava()->get_container() == 'container' ) {
            echo '<div class="container-full">';
        }
    }
}

if ( ! function_exists( 'lava_output_container_end' ) ) {
    /**
     * Output the end of the page wrapper.
     *
     */
    function lava_output_container_end() {
        if ( Lava()->get_container() == 'container' ) {
            echo '</div>';
        }
    }
}

if ( ! function_exists( 'lava_output_before_main_content' ) ) {
    /**
     * Output before the main content.
     *
     */
    function lava_output_before_main_content() {

        if ( Lava()->get_layout() != 'full-width' ) {
            echo '<div class="row">';
            echo '<div class="col x12 m8'. ( Lava()->get_layout() == 'sidebar-left' ? ' pull-right' : '' ) .'">';
        }
    }
}

if ( ! function_exists( 'lava_output_after_main_content' ) ) {
    /**
     * Output before the main content.
     *
     */
    function lava_output_after_main_content() {
        if ( Lava()->get_layout() != 'full-width' ) {
            echo '</div>';
        }
    }
}

if ( ! function_exists( 'lava_output_sidebar_content' ) ) {
    /**
     * Output the sidebar content.
     *
     */
    function lava_output_sidebar_content() {
        if ( Lava()->get_layout() != 'full-width' ) {
            get_template_part( 'templates/content-sidebar' );
        }
    }
}

if ( ! function_exists( 'lava_output_hb_sidebar_content' ) ) {
    /**
     * Output the hotel booking sidebar content.
     *
     */
    function lava_output_hb_sidebar_content() {
        if ( Lava()->get_layout() != 'full-width' ) {
            ?><div class="col x12 m4"><?php get_sidebar( 'hb' ); ?></div><?php
        }
    }
}

if ( ! function_exists( 'lava_output_ec_sidebar_content' ) ) {
    /**
     * Output the hotel booking sidebar content.
     *
     */
    function lava_output_ec_sidebar_content() {
        if ( Lava()->get_layout() != 'full-width' ) {
            ?><div class="col x12 m4"><?php get_sidebar( 'ec' ); ?></div><?php
        }
    }
}

if ( ! function_exists( 'lava_output_page_header' ) ) {
    /**
     * Output the page header content.
     *
     */
    function lava_output_page_header() {
        get_template_part( 'templates/page-header' );
    }
}

if ( ! function_exists( 'lava_output_hb_page_header' ) ) {
    /**
     * Output the hotel booking page header content.
     *
     */
    function lava_output_hb_page_header() {
        get_template_part( 'templates/hotel/page-header' );
    }
}


if ( ! function_exists( 'lava_output_single_room_details' ) ) {
    /**
     * Output the hotel booking single room details.
     *
     */
    function lava_output_single_room_details() {
        $single_room_tabs = get_post_meta( get_the_ID(), '_lava_room_tabs', true );
        $single_room_tabs = isset( $single_room_tabs ) ? (bool) $single_room_tabs : true;

        if ( $single_room_tabs ) {
            get_template_part( 'wp-hotel-booking/single-room/details' );
        } else {
            get_template_part( 'templates/hotel/single-room-details' );
        }
    }
}

if ( ! function_exists( 'lava_output_before_content_loop' ) ) {
    /**
     * Output before the content loop.
     *
     */
    function lava_output_before_content_loop() {
        if ( 'package' == Lava()->get_post_style() ) {
            echo '<div class="post-list row no-padding">';
        } else {
            echo '<div class="post-list row large">';
        }
    }
}

if ( ! function_exists( 'lava_output_after_content_loop' ) ) {
    /**
     * Output after the content loop.
     *
     */
    function lava_output_after_content_loop() {
        echo '</div><!-- post-list -->';
        get_template_part( 'templates/pagination' );
    }
}

if ( ! function_exists( 'lava_output_content_loop_start' ) ) {
    /**
     * Output loop start.
     *
     */
    function lava_output_content_loop_start() {
        get_template_part( 'templates/loop/loop-start' );
    }
}

if ( ! function_exists( 'lava_output_content_loop_end' ) ) {
    /**
     * Output loop end.
     *
     */
    function lava_output_content_loop_end() {
        get_template_part( 'templates/loop/loop-end' );
    }
}

if ( ! function_exists( 'lava_output_content_loop_thumb' ) ) {
    /**
     * Output loop thumb.
     *
     */
    function lava_output_content_loop_thumb() {
        get_template_part( 'templates/loop/thumb' );
    }
}

if ( ! function_exists( 'lava_output_content_loop_media' ) ) {
    /**
     * Output loop media.
     *
     */
    function lava_output_content_loop_media() {
        get_template_part( 'templates/loop/media' );
    }
}