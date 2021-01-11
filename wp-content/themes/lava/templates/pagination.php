<?php
global $wp_query;

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$next = is_rtl() ? '<i class="material-icons">keyboard_arrow_left</i>' : '<i class="material-icons">keyboard_arrow_right</i>';
$prev = is_rtl() ? '<i class="material-icons">keyboard_arrow_right</i>' : '<i class="material-icons">keyboard_arrow_left</i>';
$total = $wp_query->max_num_pages;
$max = 999999999;

if ( $total <= 1 ) {
	return;
}
?>
<div class="pagination numeric">
	<div class="pagination-wrapper cf"><?php
	 	echo paginate_links( array(
				'base'			=> str_replace( $max, '%#%', esc_url( get_pagenum_link( $max ) ) ),
				'format'		=> '&paged=%#%',
				'current'		=> max( 1, $paged ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'plain',
				'prev_text'		=> $prev,
				'next_text'		=> $next
			));
 	?></div>
</div>