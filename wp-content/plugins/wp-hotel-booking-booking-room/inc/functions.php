<?php
/**
 * WP Hotel Booking Room Functions
 *
 * Define common functions for both front-end and back-end
 *
 * @author   ThimPress
 * @package  WP-Hotel-Booking/Booking/Functions
 * @version  1.7.9
 */

if(!function_exists('wp_hote_booking_blocked_days')){
	function wp_hote_booking_blocked_days(){
		global $wpdb, $post;
		$unavailable_days = array();
		if ( !$post || !is_single( $post->ID ) || get_post_type( $post->ID ) !== 'hb_room' ) {

			return $unavailable_days;
		}
		$title = $wpdb->prepare( "
				SELECT room.post_title
				FROM $wpdb->posts AS room
				WHERE
					room.post_status = %s
					AND room.post_type = %s
					AND room.ID = room_meta.post_id
				GROUP BY room.ID
			", 'publish', 'hb_room' );

		$query = $wpdb->prepare( "
				SELECT calendar.ID as calendarID, blocked.meta_value AS selected, room_meta.post_id AS ID, ( $title ) AS post_title
				FROM $wpdb->posts AS calendar
				INNER JOIN $wpdb->postmeta AS blocked ON calendar.ID = blocked.post_id
				INNER JOIN $wpdb->postmeta AS room_meta ON room_meta.meta_value = calendar.ID
				WHERE
					calendar.post_type = %s
					AND calendar.post_status = %s
					AND blocked.meta_key = %s
					AND room_meta.meta_key = %s
					AND room_meta.post_id = %s
				ORDER BY calendarID
			", 'hb_blocked', 'publish', 'hb_blocked_time', 'hb_blocked_id', $post->ID );

		$results = $wpdb->get_results( $query, OBJECT );
		if(is_array($results) && count($results) > 0){
			foreach ($results as $calendar){
				$unavailable_days[] = date_i18n( 'Y-m-d', $calendar->selected );
			}
		}

		return $unavailable_days;
	}
}