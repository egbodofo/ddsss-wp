<?php
/**
 * The template for displaying search room results.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/results.php.
 *
 * @author  ThimPress, leehld
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

do_action( 'hb_before_search_result' );

global $hb_search_rooms;

?>
<div id="hotel-booking-results">
<?php if ( $results && !empty( $hb_search_rooms['data'] ) ):
		hb_get_template( 'search/list.php', array( 'results' => $hb_search_rooms['data'], 'atts' => $atts ) );
    	if ( isset( $hb_search_rooms['max_num_pages'] ) && $hb_search_rooms['max_num_pages'] > 1 ): ?>
        <nav class="pagination numeric">
        	<div class="pagination-wrapper cf">
			<?php
				$next = is_rtl() ? '<i class="material-icons">keyboard_arrow_left</i>' : '<i class="material-icons">keyboard_arrow_right</i>';
				$prev = is_rtl() ? '<i class="material-icons">keyboard_arrow_right</i>' : '<i class="material-icons">keyboard_arrow_left</i>';
				echo paginate_links( apply_filters( 'hb_pagination_args', array(
					'base'      => add_query_arg( 'hb_page', '%#%' ),
					'format'    => '',
					'prev_text' => $prev,
					'next_text' => $next,
					'total'     => $hb_search_rooms['max_num_pages'],
					'current'   => $hb_search_rooms['page'],
					'type'      => 'plain',
					'end_size'  => 3,
					'mid_size'  => 3
				) ) );
			?>
			</div>
        </nav>
    <?php endif; ?>
<?php else: ?>
    <p><?php esc_html_e( 'No room found.', 'lava' ); ?></p>
    <p>
        <a href="<?php echo hb_get_url(); ?>"><?php esc_html_e( 'Search again!', 'lava' ); ?></a>
    </p>
<?php endif; ?>
</div>
