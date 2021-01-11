<?php
/**
 * The template for displaying archive room pagination.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/pagination.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $wp_query;

if ( $wp_query->max_num_pages < 2 ) {
	return;
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

?>

<nav class="pagination numeric">
	<div class="pagination-wrapper cf">
	<?php
	
	$next = is_rtl() ? '<i class="material-icons">keyboard_arrow_left</i>' : '<i class="material-icons">keyboard_arrow_right</i>';
	$prev = is_rtl() ? '<i class="material-icons">keyboard_arrow_right</i>' : '<i class="material-icons">keyboard_arrow_left</i>';

	echo paginate_links( apply_filters( 'hb_pagination_args', array(
		'base'      => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
		'format'    => '',
		'add_args'  => '',
		'prev_text' => $prev,
		'next_text' => $next,
		'total'     => $wp_query->max_num_pages,
		'current'   => max( 1, $paged ),
		'type'      => 'plain',
		'end_size'  => 3,
		'mid_size'  => 3
	)));
	
	?>
	</div>
</nav>