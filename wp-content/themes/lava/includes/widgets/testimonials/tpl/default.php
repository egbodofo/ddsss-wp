<?php
/**
 * @var $title
 * @var $settings
 * @var $testimonials
 */

// container start
$classes = array();
if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

$columns = !empty( $settings['columns'] ) ? $settings['columns'] : 1;

?>
<div class="lava-testimonials column-<?php echo esc_attr( $columns ); ?>">

    <?php
    $data_settings = array(
        'slidesToShow' => (int) $columns,
        'dots' => true,
        'arrows' => false
    );

    if ( is_rtl() ) {
        $data_settings['rtl'] = 'true';
    }

    if ( !empty($settings['slider_speed'] ) ) {
        $data_settings['autoplaySpeed'] = ( (int) $settings['slider_speed'] ) * 1000;
    }

    if ( isset($settings['slider_autoplay'] ) && $settings['slider_autoplay'] ) {
        $data_settings['autoplay'] = 'true';
    }

    $data_settings = json_encode( $data_settings );

    ?>
    <div class="slick-slider" data-slick="<?php echo htmlspecialchars( $data_settings, ENT_QUOTES, 'UTF-8' ); ?>">

        <?php foreach ( $testimonials as $testimonial ) : ?>

            <div class="lava-testimonial slick-slide">

                <div class="lava-testimonial-text"<?php if ( !empty( $settings['background_color'] ) ) { echo ' style="background-color:'. esc_attr( $settings['background_color'] ) .';"'; } ?>>
                    
                    <div class="lava-author-image">
                        <?php echo wp_get_attachment_image( $testimonial['image'], 'thumbnail', false, array( 'class' => 'lava-image' ) ); ?>
                    </div>
                    <?php echo wp_kses_post( $testimonial['text'] ) ?>

                </div>

                <div class="lava-testimonial-author">

                    <h4 class="lava-author-info">

                        <span class="lava-author-name"><?php echo wp_kses_post( $testimonial['name'] ); ?></span>

                    <?php if ( !empty( $testimonial['title'] ) ): ?>
                        
                        <span class="lava-author-title">&middot; <?php echo wp_kses_post( $testimonial['title'] ); ?></span>

                    <?php endif; ?>
                    
                    </h4>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>
<?php

if ( !empty( $classes ) ) {
    echo '</div>';
}