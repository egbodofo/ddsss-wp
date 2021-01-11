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

$slider_settings = $temp_settings = '';

if ( isset( $instance['settings']['autoplay'] ) && $instance['settings']['autoplay'] ) {
	$temp_settings .= '"autoplay":true,';
}

if ( !empty( $instance['settings']['speed'] ) ) {
	$temp_settings .= '"autoplaySpeed":'. $instance['settings']['speed']*1000 .',';
}

if ( is_rtl() ) {
	$temp_settings .= '"rtl":true';
}

if ( ! empty( $temp_settings ) ) {
	$slider_settings .= ' data-slick=\'{'. esc_attr( $temp_settings ) .'}\'';
	$slider_settings = str_replace( ',}', '}', $slider_settings );
}

// excerpt length
$excerpt_length = isset( $instance['settings']['excerpt_length'] ) ? absint( $instance['settings']['excerpt_length'] ) : 120;
$show_date = isset( $instance['settings']['date'] ) ? (bool) $instance['settings']['date'] : true;

?>
<div class="lava-post-carousel">
	<div class="slick-slider"<?php echo htmlspecialchars( $slider_settings ); ?>>
		<?php while ( $posts_query->have_posts() ): $posts_query->the_post(); ?>
	  	<div <?php post_class( 'post' ); ?>>
	  		<div class="card">
				<?php if ( has_post_thumbnail() ): ?>
					<div class="post-thumb">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_post_thumbnail( 'lava_thumb_small' ); ?></a>
						<span class="read-more"><i class="material-icons">add</i><?php esc_html_e( 'Read More', 'lava' ); ?></span>
					</div>
				<?php endif; ?>
				<div class="post-info">
					<?php if ( $show_date ) : ?>
					<div class="post-meta">
						<div class="post-date"><?php echo get_the_date( 'F j' ); ?></div>
					</div>
					<?php endif; ?>
					<?php echo lava_get_post_title(); ?>
					<?php echo lava_get_post_excerpt( $excerpt_length ); ?>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
<?php
// container end
if ( !empty( $classes ) ) {
    echo '</div>';
}
