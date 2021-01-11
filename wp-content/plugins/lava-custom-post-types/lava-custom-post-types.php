<?php
/*
Plugin Name: Lava Custom Post Types
Plugin URI: https://themespirit.com
Description: Offer Post Type for Lava WordPress Theme
Author: ThemeSpirit
Version: 1.0.0
Author URI: https://themespirit.com
License: GPL
License URI: -
*/

include_once( 'includes/functions.php' );

class Lava_Custom_Post_Types {

	function __construct() {
		add_action( 'init', array( $this, 'register_custom_posts' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ), 1 );
		add_action( 'manage_edit-offer_columns', array( $this, 'add_offer_columns' ) );
		add_action( 'manage_offer_posts_custom_column', array( $this, 'render_offer_columns' ), 10, 2 );

		add_image_size( 'lava_thumb_offer', 640, 420, true );
	}

	/**
	 * Register Event & Offer post type
	 *
	 */
	function register_custom_posts() {

		$offer_labels = array(
			'name'                  => _x( 'Offers', 'Offers', 'lava_cpt' ),
			'singular_name'         => _x( 'Offer', 'Offer', 'lava_cpt' ),
			'menu_name'             => __( 'Offers', 'lava_cpt' ),
			'name_admin_bar'        => __( 'Offer', 'lava_cpt' ),
			'archives'              => __( 'Offer Archives', 'lava_cpt' ),
			'attributes'            => __( 'Offer Attributes', 'lava_cpt' ),
			'parent_item_colon'     => __( 'Parent Offers:', 'lava_cpt' ),
			'all_items'             => __( 'All Offers', 'lava_cpt' ),
			'add_new_item'          => __( 'Add New Offer', 'lava_cpt' ),
			'add_new'               => __( 'Add New', 'lava_cpt' ),
			'new_item'              => __( 'Add New Offer', 'lava_cpt' ),
			'edit_item'             => __( 'Edit Offer', 'lava_cpt' ),
			'update_item'           => __( 'Update Offer', 'lava_cpt' ),
			'view_item'             => __( 'View Offer', 'lava_cpt' ),
			'view_items'            => __( 'View Offers', 'lava_cpt' ),
			'search_items'          => __( 'Search Offer', 'lava_cpt' ),
			'not_found'             => __( 'Not offers found', 'lava_cpt' ),
			'not_found_in_trash'    => __( 'Not offers found in Trash', 'lava_cpt' ),
		);

		$offer_args = array(
			'label'                 => __( 'Offer', 'lava_cpt' ),
			'description'           => __( 'Offer Post Type', 'lava_cpt' ),
			'labels'                => $offer_labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'has_archive'           => true,
			'rewrite' 				=> array( 'slug' => _x( 'offer', 'slug', 'lava_cpt' ), 'with_front' => true ),
			'query_var' 			=> true,
			'map_meta_cap'			=> true,
			'capability_type'       => 'post',
		);
	
		register_post_type( 'lava_offer', apply_filters( 'lava_filter_post_type_offer', $offer_args ) );
			
		$offer_tax_args = array(
			'labels'            => array(
				'name'              => __( 'Offer Categories', 'lava_cpt' ),
				'singular_name'     => __( 'Offer Categories', 'lava_cpt' ),
				'search_items'      => __( 'Search Offer Categories', 'lava_cpt' ),
				'popular_items'     => __( 'Popular Offer Categories', 'lava_cpt' ),
				'all_items'         => __( 'All Offer Categories', 'lava_cpt' ),
				'parent_item'       => __( 'Parent Offer Category', 'lava_cpt' ),
				'parent_item_colon' => __( 'Parent Offer Category:', 'lava_cpt' ),
				'edit_item'         => __( 'Edit Offer Category', 'lava_cpt' ),
				'update_item'       => __( 'Update Offer Category', 'lava_cpt' ),
				'add_new_item'      => __( 'Add New Offer Category', 'lava_cpt' ),
				'new_item_name'     => __( 'New Offer Category', 'lava_cpt' ),
			 ),
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => _x( 'offer-category', 'slug', 'lava_cpt' ), 'with_front' => true ),
			'show_tagcloud'     => false,
			'show_in_nav_menus' => false,
			'public'            => true
		);

		register_taxonomy( 'lava_offer_category', 'lava_offer', apply_filters( 'lava_filter_taxonomy_offer', $offer_tax_args ) );
	}

	/**
	 * Add price column to admin UI
	 *
	 * @param array $columns
	 * @return array
	 */
	function add_offer_columns( $columns ) {
		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['offer_price'] = __( 'Price', 'lava_cpt' );
		$columns['date'] = $date;
		return $columns;
	}

	/**
	 * Render the price column in admin UI
	 *
	 * @param string $column_name
	 * @param int $post_id
	 */
	function render_offer_columns( $column_name, $post_id ) {
		if ( $column_name == 'offer_price' ) {
			echo ( get_post_meta( $post_id, '_lava_offer_price', TRUE ) );
		}
	}

	function load_plugin_textdomain() {
		load_plugin_textdomain( 'lava_cpt', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
	}
}

new Lava_Custom_Post_Types();