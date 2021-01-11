<?php
/**
 * @var $title
 * @var $nav_style
 * @var $tabs
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

?>
<div class="lava-tabs <?php echo esc_attr( $nav_style ); ?>">

    <div class="lava-tab-nav">

        <?php
            $tab_ids = array();
            foreach ( $tabs as $tab ) :
                $tab_id    = strip_tags( $tab['tab_title'] );
                $tab_id    = preg_replace( '/&.+?;/', '', $tab_id ); // kill entities
                $tab_id    = str_replace( '.', '-', $tab_id );
                $tab_id    = preg_replace( '/\s+/', '-', $tab_id );
                $tab_id    = preg_replace( '|-+|', '-', $tab_id );
                $tab_id    = strtolower( $tab_id ) .'-'. uniqid();
                $tab_ids[] = $tab_id;
 
                echo '<a class="lava-tab" href="#'. esc_attr( $tab_id ) .'">';
                echo '<span class="lava-tab-title">'. esc_html( $tab['tab_title'] ) .'</span>';
                echo '</a>';
                
            endforeach;
        
        ?>

    </div>

    <div class="lava-tab-panels">

        <?php
        
            $tab_index = 0;
            foreach ( $tabs as $tab ) : 
                
                $tab_id = strip_tags( $tab['tab_title'] );
                $tab_id = preg_replace( '/&.+?;/', '', $tab_id ); // kill entities
                $tab_id = str_replace( '.', '-', $tab_id );
                $tab_id = preg_replace( '/\s+/', '-', $tab_id );
                $tab_id = preg_replace( '|-+|', '-', $tab_id );
                $tab_id = $tab_ids[ $tab_index ];

                echo  '<div id="'. esc_attr( $tab_id ) .'" class="lava-tab-panel">'. do_shortcode( $tab['tab_content'] ) .'</div>';
                
                $tab_index ++;

            endforeach;

        ?>

    </div>

</div>
<?php

if ( !empty( $classes ) ) {
    echo '</div>';
}