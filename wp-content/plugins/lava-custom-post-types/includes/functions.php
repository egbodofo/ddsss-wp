<?php

/**
 * Output offer price
 */
function lava_offer_price( $post_id = '' ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	if ( !$post_id ) {
		return;
	}

	$offer_price = get_post_meta( $post_id, '_lava_offer_price', true );

	if ( !empty( $offer_price ) ) {
		$offer_unit = get_post_meta( $post_id, '_lava_offer_price_unit', true );

		$output = '<div class="offer-price">';
		$output .= '<strong>'. esc_html( $offer_price ) .'</strong>';
		
		if ( !empty( $offer_unit ) ) {
			$output .= '/<span class="offer-unit">'. esc_html( $offer_unit ) .'</span>';
		}

		$output .= '</div>';

		echo $output;
	}
}