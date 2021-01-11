<?php
/**
 * @var $title
 * @var $settings
 * @var $services
 */

// container start

$classes = array();
if ( !empty( $instance['layout']['container'] ) ) {
    $classes[] = 'container-'. esc_attr( $instance['layout']['container'] );
}

if ( !empty( $instance['attributes']['classes'] ) ) {
    $classes[] = $instance['attributes']['classes'];
}

if ( !empty( $classes ) ) {
    echo '<div class="'. esc_attr( implode( ' ', $classes ) ) .'">';
}

// widget title

lava_so_widget_title( $instance, $args );

// widget content

$column_class = lava_get_column_class( intval( $settings['columns'] ) );

?>
<div class="lava-services">

    <div class="row<?php echo ( intval( $settings['columns'] ) < 4 ? ' large' : '' ); ?>">

    <?php foreach ( $services as $service ):

        $icon_type = !empty( $service['icon_type'] ) ? $service['icon_type'] : 'icon'; 

        $url = !empty( $service['url'] ) ? $service['url'] : '';

        $link_attributes = array( 'class' => 'lava-service-link' );

        if ( isset( $service['new_window'] ) && $service['new_window'] ) {
            $link_attributes['target'] = '_blank';
            $link_attributes['rel'] = 'noopener noreferrer';
        }

        ?>

        <div class="lava-service-wrapper <?php echo esc_attr( $column_class ); ?>">

            <div class="lava-service equal-height">

                <?php if ( !empty( $url ) ) : ?>

                    <a href="<?php echo sow_esc_url( $url ); ?>" <?php foreach( $link_attributes as $name => $val ) echo esc_attr( $name ) . '="' . esc_attr( $val ) . '" ' ?>></a>

                <?php endif; ?>

                <?php if ( $icon_type == 'icon_image' ) : ?>

                    <div class="lava-image-wrapper">

                        <?php echo wp_get_attachment_image( $service['icon_image'], 'full', false, array( 'class' => 'lava-icon-image' ) ); ?>

                    </div>

                <?php else : ?>

                    <div class="lava-icon-wrapper" <?php if ( !empty( $settings['icon_color'] ) ) { echo ' style="color:' . esc_attr( $settings['icon_color'] ) . ';"'; } ?>>

                        <?php echo siteorigin_widget_get_icon( $service['icon'] ); ?>

                    </div>

                <?php endif; ?>

                <div class="lava-service-text">

                    <h3 class="lava-service-name"><?php echo esc_html( $service['name'] ) ?></h3>

                    <div class="lava-service-description"><?php echo wp_kses_post( $service['description'] ) ?></div>

                </div>
            </div>
        </div>

    <?php endforeach; ?>

    </div>
</div>
<?php
// container end

if ( !empty( $classes ) ) {
    echo '</div>';
}