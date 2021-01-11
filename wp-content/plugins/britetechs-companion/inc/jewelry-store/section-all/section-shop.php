<?php
if ( !function_exists( 'bc_js_shop' ) ) :
	function bc_js_shop(){

		if( !class_exists('woocommerce') ){
			return;
		}

		$option = wp_parse_args(  get_option( 'jewelrystore_option', array() ), jewelry_store_reset_data() );

		$containerClass = '';
		if($option['shop_container_width']!=''){
		    $containerClass = $option['shop_container_width'];
		}

		if($option['shop_enable']==true){
		?>
		<div id="product" class="jsgroup-section jsgroup-product">
		    <div class="">
		        <div class="<?php echo esc_attr( $containerClass ); ?>">
		            <div class="row jsgroup-header">
		                <div class="col-md-12">
		                    <?php if( $option['shop_title'] != '' ){ ?>
		                    <h2 class="jsgroup-title"><?php echo wp_kses_post($option['shop_title']); ?></h2>
		                    <?php } ?>

		                    <?php if($option['shop_subtitle']!=''){ ?>
		                    <p class="jsgroup-subtitle"><?php echo wp_kses_post($option['shop_subtitle']); ?></p>
		                    <?php } ?>
		                </div>                    
		            </div>
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="product-slider owl-carousel owl-theme">
		                        <?php 
		                        $args = array(
		                            'post_type' => 'product',
		                        );

		                        $args['posts_per_page'] = 4;
		                        $loop = new WP_Query( $args );
		                        if ( $loop->have_posts() ) :
		                            while ( $loop->have_posts() ) :
		                                $loop->the_post();

		                            global $product;
		                        ?>
		                        <div class="item">
		                            <div class="jsproduct-wrap">
		                                <div class="jsproduct-inner">

		                                    <?php if ( has_post_thumbnail() ) : ?>
		                                    <div class="jsproduct-image-area">
		                                        <a class="jsproduct-image" href="<?php the_permalink(); ?>">
		                                            <?php the_post_thumbnail(); ?>
		                                        </a>
		                                    </div>
		                                    <?php endif; ?>

		                                    <div class="jsproduct-content">
		                                        <a class="jsproduct-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		                                            <h3><?php the_title(); ?></h3>
		                                        </a>
		                                         <div class="jsproduct-footer">
		                                             <div class="jsproduct_btn_wrap"></div>
		                                             <div class="jsproduct_price">
		                                                <?php
		                                                    $product_price = $product->get_price_html();

		                                                    if ( ! empty( $product_price ) ) {


		                                                        echo wp_kses(
		                                                            $product_price, array(
		                                                                'span' => array(
		                                                                    'class' => array('jsproduct_price'),
		                                                                ),
		                                                                'del' => array(),
		                                                            )
		                                                        );

		                                                    }
		                                                ?>
		                                             </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div><!-- .item -->
		                        <?php 
		                            endwhile;
		                        endif;
		                        ?>
		                    </div>                            
		                </div>
		            </div>
		        </div>
		    </div>
		</div><!-- end .jsgroup-product -->
		<?php }
	}
endif;
if ( function_exists( 'bc_js_shop' ) ) {
	$section_priority = apply_filters( 'jewelry_store_section_priority', 3, 'bc_js_shop' );
	add_action( 'jewelry_store_sections', 'bc_js_shop', absint( $section_priority ) );
}