<?php

$hide_related = Lava_Util::get_option( 'single_hide_related', false );

if ( $hide_related ) {
	return;
}

$post_count = Lava_Util::get_option( 'single_related_count', 3 );
$post_count = 'full-width' == Lava()->get_layout() ? $post_count + 1 : $post_count;
$query_args['posts_per_page'] = $post_count;
$type = Lava_Util::get_option( 'single_related_type', 'all' );

switch( $type ) {

	case 'cat': 
		$cats = wp_get_post_categories( Lava()->get_id(), array( 'fields' => 'ids' ) );
		if ( !empty( $cats ) ) {
			$query_args['category__in'] = $cats;
		}
		break;

	case 'tag':
		$tags = wp_get_post_tags( Lava()->get_id(), array( 'fields' => 'ids' ) );
		if ( !empty( $tags ) ) {
			$query_args['tag__in'] = $tags;
		}
		break;

	case 'author':
		$query_args['author__in'] = get_the_author_meta( 'ID' );
		break;

	case 'cat_or_tag':
		$cats = wp_get_post_categories( Lava()->get_id() );
		$tags = wp_get_post_tags( Lava()->get_id(), array( 'fields' => 'ids' ) );
		$query_args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $cats,
			),
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'id',
				'terms'    => $tags,
			)
		);
		break;
}
$query_args['post_type'] = 'post';
$query_args['post__not_in'] = array( Lava()->get_id() );
$query_args['ignore_sticky_posts'] = 1;
$qyery_args['not_found_rows'] = 1;
$query = new WP_Query( $query_args );

if ( $query->have_posts() ): ?>
	<div class="post-related">
		<h2 class="section-heading"><?php esc_html_e( 'Related Posts', 'lava' ); ?></h2>
		<div class="post-list row">
		<?php while ( $query->have_posts() ): $query->the_post(); ?>
			<div class="col x12 s6 m4 loop-related-post">
				<?php echo lava_get_post_thumb( 'lava_thumb_small' ); ?>
				<div class="post-info">
					<?php echo lava_get_post_title(); ?>
					<?php echo lava_get_post_meta( array( 'date' ) ); ?>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
<?php
endif;
wp_reset_postdata();