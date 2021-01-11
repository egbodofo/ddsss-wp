<?php
/**
 * @var $title
 */

if ( empty( $instance['query'] ) ) {
	return;
}

$query_args = siteorigin_widget_post_selector_process_query( $instance['query'] );

$posts_query = new WP_Query( $query_args );

if ( !$posts_query->have_posts() ) {
	return;
}

// container start

$classes = array();

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( isset( $instance['layout']['equal_height'] ) && $instance['layout']['equal_height'] ) {
	$classes[] = 'equal-height';
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

?>
<div class="lava-post-list">
	<div class="post-list">
	<?php while ( $posts_query->have_posts() ): $posts_query->the_post(); ?>
	  	<div <?php post_class( 'post-style-small' ); ?>>
		<?php echo lava_get_post_thumb( 'lava_thumb_x_small' ); ?>
			<div class="post-info">
				<div class="post-date"><?php echo get_the_date( 'j F' ); ?></div>
				<?php echo lava_get_post_title(); ?>
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
	</div>
	<?php if ( !empty( $instance['more_link'] ) ): ?>
	<?php $more_text = !empty( $instance['more_text'] ) ? $instance['more_text'] : esc_html__( 'Read More', 'lava' ); ?>
		<div class="lava-read-more">
			<a href="<?php echo esc_url( $instance['more_link'] ); ?>" class="btn-secondary"><?php echo esc_html( $more_text ); ?></a>
		</div>
	<?php endif; ?>
</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}