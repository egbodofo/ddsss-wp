<?php
/**
 * @var $title
 */

if ( !class_exists( 'Lava_Custom_Post_Types' ) ) {
	return;
}

$widget_title = $title_style = $title_class = '';

if ( empty( $instance['query'] ) ) {
	return;
}

$query_args = siteorigin_widget_post_selector_process_query( $instance['query'] );

if ( empty( $query_args['post_type'] ) || $query_args['post_type'] != 'lava_offer' ) {
	$query_args['post_type'] = 'lava_offer';
}

$post_query = new WP_Query( $instance['query'] );

if ( !$post_query->have_posts() ) {
	return;
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

?>

<div class="lava-offers">
	<div class="post-list row no-padding">
	<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
		<div <?php post_class( 'post-offer col x12 m6 g4' ); ?>>
			<?php echo lava_get_post_thumb( 'lava_thumb_offer' ); ?>
			<div class="post-info">
				<h3 class="post-title"><?php the_title(); ?></h3>
				<?php lava_offer_price(); ?>
				<?php lava_button( esc_html__( 'Details', 'lava' ), get_permalink(), array( 'btn-secondary' ) ); ?>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>