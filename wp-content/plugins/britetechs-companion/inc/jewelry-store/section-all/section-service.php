<?php
if ( !function_exists( 'bc_js_service' ) ) :
	function bc_js_service(){
		$option = wp_parse_args(  get_option( 'jewelrystore_option', array() ), jewelry_store_reset_data() );
		$services = array();

		if(!empty($option['service_contents'])){
		    $services = $option['service_contents'];
		}

		$class = '';
		if($option['service_layout']!=''){
		    $class = $option['service_layout'];
		}

		$containerClass = '';
		if($option['service_container_width']!=''){
		    $containerClass = $option['service_container_width'];
		}

		$columnLayoutClass = '';
		if($option['service_column']==4){
		    $columnLayoutClass = 'col-lg-3 col-md-6 col-sm-6';
		}else if($option['service_column']==3){
		    $columnLayoutClass = 'col-lg-4 col-md-6 col-sm-6';
		}else{
		    $columnLayoutClass = 'col-lg-6 col-md-6 col-sm-6';
		}

		if($option['service_enable']==true){
		?>
		<div id="service" class="jsgroup-section jsgroup-service <?php echo esc_attr( $class ); ?>">
		    <div class="<?php echo esc_attr( $containerClass ); ?>">

		        <?php if( $option['service_title'] != '' || $option['service_subtitle'] != '' ){ ?>
		        <div class="row jsgroup-header">
		            <div class="col-md-12">
		                <?php if( $option['service_title'] != '' ){ ?>
		                <h2 class="jsgroup-title"><?php echo wp_kses_post($option['service_title']); ?></h2>
		                <?php } ?>

		                <?php if($option['service_subtitle']!=''){ ?>
		                <p class="jsgroup-subtitle"><?php echo wp_kses_post($option['service_subtitle']); ?></p>
		                <?php } ?>
		            </div>                    
		        </div>
		        <?php } ?>
		        
		        <div class="row">
		            <?php foreach ($services as $service) { ?>
		            <div class="<?php echo esc_attr( $columnLayoutClass ); ?>">
		                <div class="jsservice">
		                    <div class="jsservice-inner">
		                        <div class="icon">
		                            <a class="service-icon" <?php if(isset($service['link']))echo 'href="'.esc_url($service['link']).'"'; ?>><i class="<?php echo esc_attr($service['icon']); ?>"></i></a>
		                        </div>
		                        <a class="service-title" <?php if(isset($service['link']))echo 'href="'.esc_url($service['link']).'"'; ?>><h3><?php echo wp_kses_post($service['title']); ?></h3></a>
		                        <div class="service-content">
		                            <p class="jsgroup-subtitle"><?php echo wp_kses_post($service['desc']); ?></p>
		                        </div>
		                    </div>
		                </div>                        
		            </div>
		            <?php } ?>           
		        </div>
		    </div>
		</div><!-- end .group-service -->
		<?php }
	}
endif;
if ( function_exists( 'bc_js_service' ) ) {
	$section_priority = apply_filters( 'jewelry_store_section_priority', 2, 'bc_js_service' );
	add_action( 'jewelry_store_sections', 'bc_js_service', absint( $section_priority ) );
}