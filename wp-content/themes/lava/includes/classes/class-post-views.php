<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Lava_Post_Views {
    
    static $count_key = '_lava_post_views_count';

    // function to get views
    static function get_post_views( $post_id ) {
        $count = get_post_meta( $post_id, self::$count_key, true );
        if ( $count == '' ) {
            delete_post_meta( $post_id, self::$count_key );
            add_post_meta( $post_id, self::$count_key, '0' );
            return 0;
        }
        return $count;
    }

    // function to count views
    static function set_post_view( $post_id ) {
        $count = get_post_meta( $post_id, self::$count_key, true );
        if ( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, self::$count_key );
            add_post_meta( $post_id, self::$count_key, '0' );
        } else {
            $count++;
            update_post_meta( $post_id, self::$count_key, $count );
        }
    }
    
    static function posts_column_views( $columns ) {
        $date = $columns['date'];
        unset( $columns['date'] );
        $columns['views'] = esc_html__( 'Views', 'lava' );
        $columns['date'] = $date;
        return $columns;
    }
    
    static function posts_column_views_count( $column_name, $id ) {
        if ( $column_name === 'views' ) {
            echo self::get_post_views( get_the_ID() );
        }
    }
    // add post view column to all posts admin page
    static function add_post_view_column() {
        add_filter( 'manage_post_posts_columns', array( __CLASS__, 'posts_column_views' ) );
        add_action( 'manage_post_posts_custom_column', array( __CLASS__, 'posts_column_views_count' ), 10, 2 );
    }
}

Lava_Post_Views::add_post_view_column();