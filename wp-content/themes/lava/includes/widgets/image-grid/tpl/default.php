<?php
/**
 * @var $args array
 * @var $items array
 * @var $layouts array
 */

// container start

$classes = array();

if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget content

$widget_instance = uniqid();

?>
<div class="lava-image-grid">
<?php
if ( !empty( $items ) ) :
	$tags = '';

	foreach ( $items as $item ) {
		$tag = $item['tags'];
		if ( !empty( $tag ) ) {
			$tags .= ','. $tag;
		}
	}
	
	if ( !empty( $tags ) ) {
		$tags = substr( $tags, 1 );
		$tags = explode( ',', $tags );
		$tags = array_unique( $tags );
		echo '<div class="lava-image-grid-filters">';
		echo '<button class="lava-image-filter-item active" data-filter="*">'. esc_html__( 'All', 'lava' ) .'</button>';
		foreach ( $tags as $tag ) {
			echo '<button class="lava-image-filter-item" data-filter=".'. esc_attr( strtolower( $tag ) ) .'">'. esc_html( $tag ) .'</button>';
		}
		echo '</div>';
	}
?>
	<div class="lava-image-grid-images" data-layouts="<?php echo esc_attr( json_encode( $layouts ) ) ?>"><?php
		foreach ( $items as $item ) :
			$attachment_size = empty( $item['attachment_size'] ) ? 'full' : $item['attachment_size'];
			$full_src   	 = wp_get_attachment_image_src( $item['image'], 'full' );
			$full_src   	 = empty( $full_src ) ? '' : $full_src[0];
			$title      	 = empty( $item['title'] ) ? '' : $item['title'];
			$url        	 = empty( $item['url'] ) ? '' : $item['url'];
			$tags 			 = empty( $item['tags'] ) ? '' : str_replace( ',', ' ', strtolower( $item['tags'] ) );
			?>
			<div class="lava-image-item <?php echo esc_attr( $tags ); ?>" data-col-span="<?php echo esc_attr( $item['column_span'] ) ?>" data-row-span="<?php echo esc_attr( $item['row_span'] ); ?>">
				<a data-fancybox="<?php echo esc_attr( 'gallery-' . $widget_instance ); ?>" href="<?php echo sow_esc_url( $full_src ); ?>" title="<?php echo esc_html( $title ); ?>">
					<?php echo wp_get_attachment_image( $item['image'], $attachment_size, false, array( 'title' => esc_attr( $title ) ) ); ?>
					<div class="lava-image-item-overlay"></div>
				</a>
				<?php if ( !empty( $title ) ): ?>
					<h3 class="lava-image-title">
					<?php if ( ! empty( $url ) ) : ?>
						<a href="<?php echo sow_esc_url( $url ) ?>"<?php
							foreach ( $item['link_attributes'] as $att => $val ) :
								if ( ! empty( $val ) ) :
									echo esc_attr( $att ) .'="'. esc_attr( $val ) .'" ';
								endif;
							endforeach; ?>>
							<?php echo esc_html( $title ); ?>
						</a>
					<?php else: echo esc_html( $title ); endif; ?>
					</h3>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}