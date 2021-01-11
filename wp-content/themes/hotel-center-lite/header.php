<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Hotel Center Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	//wp_body_open hook from WordPress 5.2
	if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	}
?>
<a class="skip-link screen-reader-text" href="#pagelayout_area">
<?php esc_html_e( 'Skip to content', 'hotel-center-lite' ); ?>
</a>
<?php
$show_slider 	  		= get_theme_mod('show_slider', false);
$show_servicesbox 	  	= get_theme_mod('show_servicesbox', false);
$show_welcome_page		= get_theme_mod('show_welcome_page', false);
?>
<div id="site-holder" <?php if( get_theme_mod( 'sitebox_layout' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($show_slider)) {
	 	$inner_cls = '';
	}
	else {
		$inner_cls = 'siteinner';
	}
}
else {
$inner_cls = 'siteinner';
}
?>
 <div class="site-header <?php echo esc_attr($inner_cls);?>">  
       <div class="container">    
          <div class="logo">
				<?php hotel_center_lite_the_custom_logo(); ?>
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr(bloginfo( 'name' )); ?></a></h1>

					<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						 <p><?php echo esc_html($description); ?></p>
					<?php endif; ?>
          </div><!-- logo -->
          <div class="head-rightpart">
          <div class="toggle">
                 <a class="toggleMenu" href="#"><?php esc_html_e('Menu','hotel-center-lite'); ?></a>
               </div><!-- toggle --> 
               <div class="header-menu">                   
                <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>   
               </div><!--.header-menu -->  
         </div><!-- .head-rightpart --> 
     	<div class="clear"></div>  
     
     </div><!-- container -->   
</div><!--.site-header --> 

<?php 
if ( is_front_page() && !is_home() ) {
if($show_slider != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('sliderpage'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('sliderpage'.$i,true));
	  }
	}
?>                
                
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption"> 
       <div class="slide_info">       
    	<h2><?php the_title(); ?></h2>
    	<p><?php echo esc_html( wp_trim_words( get_the_content(), 20, '' ) );  ?></p> 
    <?php
    $slider_readmore = get_theme_mod('slider_readmore');
    if( !empty($slider_readmore) ){ ?>
    	<a class="slide_more" href="<?php the_permalink(); ?>"><?php echo esc_html($slider_readmore); ?></a>
    <?php } ?>       
    </div>
  </div>  
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>  
<div class="clear"></div>        
<?php } ?>
<?php } } ?>
       
        
<?php if ( is_front_page() && ! is_home() ) {
if( $show_welcome_page != ''){ ?> 

	<section id="welcome-section">
            	<div class="container">
                    <div class="welcome-wrap">                            
                        <?php if( get_theme_mod('welcome_page',false)) { ?>          
                            <?php $queryvar = new WP_Query('page_id='.absint(get_theme_mod('welcome_page',true)) ); ?>				
                                    <?php while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>                                     
                                      <?php if(has_post_thumbnail() ) { ?>
                                        <div class="welcome-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></div>
                                      <?php } ?>
                                     <div class="welcome-content">
                                       <h3><?php the_title(); ?></h3>
                                       <p><?php echo esc_html( wp_trim_words( get_the_content(), 160, '...' ) );  ?></p>   
                                       <a class="button" href="<?php the_permalink(); ?>">                                      
                                         <?php esc_html_e('Read More','hotel-center-lite'); ?>
                                      </a>                                                                     
                                    </div>                                      
                                    <?php endwhile;
                                   		 wp_reset_postdata(); ?>                                    
                       				<?php } ?>                                 
                    <div class="clear"></div>  
                </div><!-- .welcome-wrap-->            
            </div><!-- container -->
       </section><!-- #welcome-section -->
<?php } ?>

<?php if( $show_servicesbox != ''){ ?> 
    <section id="section-wrap-2">
            	<div class="container">
                    <div class="page-wrapper"> 
						<?php
                            $services_title = get_theme_mod('services_title');
                            if( !empty($services_title) ){ ?>
                            <h2 class="servicestitle"><?php echo esc_attr($services_title); ?></h2>
                        <?php } ?> 
                                           
                        <?php for($n=4; $n<=7; $n++) { ?>    
                        <?php if( get_theme_mod('services-pagebox'.$n,false)) { ?>          
                            <?php $queryvar = new WP_Query('page_id='.absint(get_theme_mod('services-pagebox'.$n,true)) ); ?>				
                                    <?php while( $queryvar->have_posts() ) : $queryvar->the_post(); ?> 
                                    <div class="fourclmbox">                                    
                                      <?php if(has_post_thumbnail() ) { ?>
                                        <div class="thumbbx"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></div>
                                      <?php } ?>
                                     <div class="pagecontent">
                                     <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>                                     
                                     <p><?php echo esc_html( wp_trim_words( get_the_content(), 22, '...' ) );  ?></p>                                        
                                     </div>                                   
                                    </div>
                                    <?php endwhile;
                                   		 wp_reset_postdata(); ?>                                    
                       				<?php } } ?>                                 
                    <div class="clear"></div>  
               </div><!-- .page-wrapper--> 
               
            </div><!-- .container -->                  
       </section><!-- .section-wrap-2-->                      	      
<?php } ?>
<?php } ?>