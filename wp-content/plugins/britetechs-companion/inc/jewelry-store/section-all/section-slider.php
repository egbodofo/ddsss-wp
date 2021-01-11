<?php
if ( !function_exists( 'bc_js_slider' ) ) :
	function bc_js_slider(){
		$option = wp_parse_args(  get_option( 'jewelrystore_option', array() ), jewelry_store_reset_data() );

		$_images = $option['slider_images'];

		if (is_string($_images)) {
		    $_images = json_decode($_images, true);
		}

		if ( empty( $_images ) || !is_array( $_images ) ) {
		    $_images = array();
		}

		$slides = array();
		if (!empty($_images) && is_array($_images)) {
		    foreach ($_images as $k => $v) {
		        $slides[] = wp_parse_args($v, array(
		                    'image'=> get_template_directory_uri().'/images/slide1.jpg',
		                    'large_text'=>'',
		                    'small_text' => '',
		                    'btn_text' => '',
		                    'btn_link' => '',
		                    'btn_target' => '',
		                    'content_align' => 'left'
		                ));
		    }
		}else{
		    $slides[] = array(
		                    'image'=> array(
		                        'url' => get_template_directory_uri().'/images/slide1.jpg',
		                        'id' => ''
		                    ),
		                    'large_text'=> __('Welcome To jewelry Store Pro Theme','jewelry-store'),
		                    'small_text'=> __('Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet.','jewelry-store'),
		                    'btn_text'=> __('Buy Now','jewelry-store'),
		                    'btn_link'=> '#',
		                    'btn_target'=> true,
		                );
		}


		$class = '';
		if($option['slider_layout']!=''){
		    $class = $option['slider_layout'];
		}

		$containerClass = '';
		if($option['slider_container_width']!=''){
		    $containerClass = $option['slider_container_width'];
		}

		if( $option['slider_enable'] == true ){
		?>
		<div class="main-slider <?php echo esc_attr( $class ); ?>">
		    <div class="home-slider owl-carousel owl-theme">

		        <?php foreach($slides as $slide){ ?>

		        <?php 
		        $slide_m = wp_parse_args($slide,array('image'=>''));
		        $imgurl = jewelry_store_get_media_url( $slide_m['image'] ); 
		        ?>

		        <div class="item">
		            <div class="slideitem" style="background-image: url('<?php echo esc_url($imgurl ); ?>');">
		                <img src="<?php echo esc_url($imgurl ); ?>" alt="<?php echo esc_attr($slide['large_text']); ?>">
		                <div class="slider-caption">
		                    <div class="<?php echo esc_attr( $containerClass ); ?>">
		                        <div class="caption-content text-<?php echo esc_attr( $slide['content_align'] ); ?>">
		                            <?php if( $slide['large_text'] != '' ){ ?>
		                            <h3><?php echo wp_kses_post($slide['large_text']); ?></h3>
		                            <?php } ?>

		                            <?php if( $slide['small_text'] != '' ){ ?>
		                            <p class="sliderContent"><?php echo wp_kses_post($slide['small_text']); ?></p>
		                            <?php } ?>

		                            <?php if( $slide['btn_link'] != '' ){ ?>
		                            <a class="sliderBtn" href="<?php echo esc_url( $slide['btn_link'] ); ?>" <?php if($slide['btn_target']==true){ echo 'target="_blank"';} ?> ><?php echo wp_kses_post($slide['btn_text']); ?></a>
		                            <?php } ?>
		                        </div>
		                    </div>                            
		                </div>
		            </div>
		        </div>
		        <?php } ?>

		    </div>
		</div><!-- end .main-slider -->
		<?php }
	}
endif;
if ( function_exists( 'bc_js_slider' ) ) {
	$section_priority = apply_filters( 'jewelry_store_section_priority', 1, 'bc_js_slider' );
	add_action( 'jewelry_store_sections', 'bc_js_slider', absint( $section_priority ) );
}