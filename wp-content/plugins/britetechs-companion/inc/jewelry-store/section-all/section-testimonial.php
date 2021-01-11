<?php
if ( !function_exists( 'bc_js_testimonial' ) ) :
	function bc_js_testimonial(){
		$option = wp_parse_args(  get_option( 'jewelrystore_option', array() ), jewelry_store_reset_data() );

		$testimonials = array();

		if(!empty($option['testimonial_contents'])){
		    $testimonials = $option['testimonial_contents'];
		}

		$sectionClass = '';
		if($option['testimonial_bg_image']!=''){
		    $sectionClass = 'has_bg_image';
		}

		if($option['testimonial_layout']!=''){
		    $sectionClass .= ' '.$option['testimonial_layout'];
		}

		$sectionClass = trim($sectionClass);

		$containerClass = '';
		if($option['testimonial_container_width']!=''){
		    $containerClass = $option['testimonial_container_width'];
		}

		if($option['testimonial_enable']==true){
		?>
		<div id="testimonial" class="jsgroup-section jsgroup-testimonial <?php echo esc_attr( $sectionClass ); ?>">

		  <?php if($option['testimonial_bg_image']!=''){ ?>
		  <div class="jsgroup-bg">
		      <img src="<?php echo esc_url($option['testimonial_bg_image']); ?>">
		  </div>
		  <div class="section-overlay">
		  <?php } ?>

		      <div class="<?php echo esc_attr( $containerClass ); ?>">
		          <div class="row jsgroup-header">
		              <div class="col-md-12">
		                <?php if( $option['testimonial_title'] != '' ){ ?>
		                <h2 class="jsgroup-title"><?php echo wp_kses_post($option['testimonial_title']); ?></h2>
		                <?php } ?>

		                <?php if($option['testimonial_subtitle']!=''){ ?>
		                <p class="jsgroup-subtitle"><?php echo wp_kses_post($option['testimonial_subtitle']); ?></p>
		                <?php } ?>
		              </div>                    
		          </div>
		          <div class="row">
		            <div class="col-md-12">
		                <div class="testimonial-slider  owl-carousel owl-theme">
		                    <?php foreach ($testimonials as $testimonial) { ?>

		                    <?php 
		                    $testimonial_m = wp_parse_args($testimonial,array('image'=>''));
		                    $imgurl = jewelry_store_get_media_url( $testimonial_m['image'] , 'thumbnail' ); 
		                    ?>
		                    <div class="item">
		                      <div class="jstesti-wrap">
		                        <div class="jstesti-inner">
		                            <div class="media">
		                              <a class="jstesti-thumb mr-3" href="<?php echo esc_url($testimonial['link']); ?>">
		                                <img class="align-self-start " src="<?php echo esc_url($imgurl); ?>" alt="<?php echo esc_attr($testimonial['title']); ?>">
		                              </a>
		                              <div class="media-body">
		                                <div class="jstesti-content">"
		                                  <?php echo wp_kses_post($testimonial['desc']); ?>"
		                                </div>
		                                <a class="jstesti-title" href="<?php echo esc_url($testimonial['link']); ?>"><h5 class="mt-0"><?php echo esc_html($testimonial['title']); ?></h5></a>
		                                <span class="jstesti-pos"><?php echo esc_html($testimonial['position']); ?></span>
		                              </div>
		                            </div>
		                        </div>
		                      </div>
		                    </div>
		                    <?php } ?>
		              </div>                            
		            </div><!-- end .col-md-12 -->
		          </div>
		      </div>

		  <?php if($option['testimonial_bg_image']!=''){ ?>
		  </div>
		  <?php } ?>

		</div><!-- end .jsgroup-testimonial -->
		<?php }
	}
endif;
if ( function_exists( 'bc_js_testimonial' ) ) {
	$section_priority = apply_filters( 'jewelry_store_section_priority', 4, 'bc_js_testimonial' );
	add_action( 'jewelry_store_sections', 'bc_js_testimonial', absint( $section_priority ) );
}