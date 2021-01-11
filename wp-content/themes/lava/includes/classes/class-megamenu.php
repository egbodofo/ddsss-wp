<?php
/**
 * Lava MegaMenu
 *
 * @author ThemeSpirit
 * @link https://themespirit.com
 * @since 1.2.5
 */
class Lava_Megamenu {

	function __construct() {

        // save menu item custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_nav_fields' ), 10, 3 );

        // add custom nav menu items	
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_nav_fields' ) ); 

        // add custom edit fields
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'add_custom_edit_fields' ), 99 );

        // add media upload js
        add_action( 'admin_enqueue_scripts', array( $this, 'add_custom_scripts' ) );

	}

    function save_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
        $field_name_suffix = array( 'enable', 'icon', 'iconfont', 'width', 'hide-text', 'new-row', 'widget-area', 'column-width' );

        foreach ( $field_name_suffix as $key ) {
            $meta_key = str_replace( '-', '_', $key );
            if ( isset( $_REQUEST['menu-item-lava-megamenu-'. $key][$menu_item_db_id] ) ) {
                update_post_meta( $menu_item_db_id, '_menu_item_lava_megamenu_'. $meta_key, $_REQUEST['menu-item-lava-megamenu-'. $key][$menu_item_db_id] );
            } else {
                delete_post_meta( $menu_item_db_id, '_menu_item_lava_megamenu_'. $meta_key );
            }
        }
    }

    function add_custom_nav_fields( $menu_item ) {
        // all menu items
        $menu_item->lava_megamenu_icon = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_icon', true );
        $menu_item->lava_megamenu_iconfont = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_iconfont', true );

        // root lvl menu items
        $menu_item->lava_megamenu_enable = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_enable', true );
        $menu_item->lava_megamenu_width = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_width', true );

        // 1st, 2nd, 3rd lvl menu items
        $menu_item->lava_megamenu_hide_text = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_hide_text', true );
        $menu_item->lava_megamenu_new_row = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_new_row', true );
        $menu_item->lava_megamenu_widget_area = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_widget_area', true );
		$menu_item->lava_megamenu_column_width = get_post_meta( $menu_item->ID, '_menu_item_lava_megamenu_column_width', true );

        return $menu_item;
    }

    function add_custom_edit_fields() {
    	require_once LAVA_ADMIN_DIR .'/classes/class-megamenu-edit.php';
		return 'Lava_Megamenu_Edit';
	}

    function add_custom_scripts() {
    	if ( function_exists( 'wp_enqueue_media' ) ) {
		    wp_enqueue_media();
		}
        wp_enqueue_script( 'lava-megamenu', LAVA_ADMIN_URI .'/assets/js/megamenu.js', array( 'jquery' ), false, true );
    }

}

new lava_Megamenu();