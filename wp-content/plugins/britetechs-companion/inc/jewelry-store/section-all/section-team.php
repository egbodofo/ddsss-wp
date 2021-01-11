<?php
if ( !function_exists( 'bc_js_team' ) ) :
	function bc_js_team(){
		$option = wp_parse_args(  get_option( 'jewelrystore_option', array() ), jewelry_store_reset_data() );
		$teams = array();

		if(!empty($option['team_contents'])){
		    $teams = $option['team_contents'];
		}

		$class = '';
		if($option['team_layout']!=''){
		    $class = $option['team_layout'];
		}

		$containerClass = '';
		if($option['team_container_width']!=''){
		    $containerClass = $option['team_container_width'];
		}

		if($option['team_enable']==true){
		?>
		<div id="team" class="jsgroup-section jsgroup-team <?php echo esc_attr( $class ); ?>">
		        <div class="<?php echo esc_attr( $containerClass ); ?>">
		            <div class="row jsgroup-header">
		                <div class="col-md-12">
		                    <?php if( $option['team_title'] != '' ){ ?>
		                    <h2 class="jsgroup-title"><?php echo wp_kses_post($option['team_title']); ?></h2>
		                    <?php } ?>

		                    <?php if($option['team_subtitle']!=''){ ?>
		                    <p class="jsgroup-subtitle"><?php echo wp_kses_post($option['team_subtitle']); ?></p>
		                    <?php } ?>
		                </div>                    
		            </div>
		            <div class="">
		                <div class="col-md-12">
		                    <div class="team-slider owl-carousel owl-theme">
		                        
		                        <?php foreach ($teams as $team) { ?>
		                        <?php 
		                        $team_m = wp_parse_args($team,array('image'=>''));
		                        $imgurl = jewelry_store_get_media_url( $team_m['image'] , 'medium'); 
		                        ?>
		                        <div class="item">
		                            <div class="jsteam-wrap">
		                                <div class="jsteam-inner">
		                                    <div class="jsteam-thumb">
		                                        <a href="<?php echo esc_url($team['link']); ?>">
		                                            <img src="<?php echo esc_url($imgurl); ?>" alt="<?php echo esc_attr($team['title']); ?>">
		                                        </a>                                        
		                                    </div>

		                                    <div class="jsteam-content">              
		                                        <a class="jsteam-title" href="<?php echo esc_url($team['link']); ?>">
		                                            <h4><?php echo esc_html($team['title']); ?></h4>
		                                        </a>
		                                        <span class="jsteam-pos"><?php echo esc_html($team['position']); ?></span>
		                                    </div>                     
		                                </div>
		                            </div>
		                        </div>
		                        <?php } ?>
		                        
		                    </div>                            
		                </div><!-- end .col-md-12 -->
		            </div>
		        </div>
		</div><!-- end .jsgroup-team -->
		<?php }
	}
endif;
if ( function_exists( 'bc_js_team' ) ) {
	$section_priority = apply_filters( 'jewelry_store_section_priority', 5, 'bc_js_team' );
	add_action( 'jewelry_store_sections', 'bc_js_team', absint( $section_priority ) );
}