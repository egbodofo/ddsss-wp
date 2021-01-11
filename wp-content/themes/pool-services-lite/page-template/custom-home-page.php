<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'pool_services_lite_before_slider' ); ?>

  <?php if( get_theme_mod( 'pool_services_lite_slider_arrows') != '') { ?>

  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod( 'pool_services_lite_slider_speed',3000)) ?>"> 
      <?php $pool_services_lite_pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'pool_services_lite_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $pool_services_lite_pages[] = $mod;
          }
        }
        if( !empty($pool_services_lite_pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $pool_services_lite_pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <?php the_post_thumbnail(); ?>
            <div class="carousel-caption">
              <div class="inner_carousel">
                <h1><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( pool_services_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('pool_services_lite_slider_excerpt_number','20')))); ?></p>
                <?php if( get_theme_mod('pool_services_lite_slider_button_text','Read More') != ''){ ?>
                  <div class="more-btn">
                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('pool_services_lite_slider_button_text',__('Read More','pool-services-lite')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('pool_services_lite_slider_button_text',__('Read More','pool-services-lite')));?></span></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
          <div class="no-postfound"></div>
      <?php endif;
      endif;?>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Previous','pool-services-lite' );?></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Next','pool-services-lite' );?></span>
      </a>
    </div>
  </section>

  <?php } ?>

  <?php do_action( 'pool_services_lite_after_slider' ); ?>

  <section id="about-section">
    <div class="container">
      <?php if( get_theme_mod( 'pool_services_lite_section_title') != '') { ?>
        <h2><?php echo esc_html( get_theme_mod( 'pool_services_lite_section_title','pool-services-lite') ); ?></h2>
      <?php }?>
      <div class="row about-box">
        <?php $pool_services_about_pages = array();
          $mod = absint( get_theme_mod( 'pool_services_lite_about','pool-services-lite'));
          if ( 'page-none-selected' != $mod ) {
            $pool_services_about_pages[] = $mod;
          }
          if( !empty($pool_services_about_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $pool_services_about_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $count = 0;
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-lg-7 col-md-7">
                  <h3><?php the_title(); ?></h3>
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( pool_services_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('pool_services_lite_about_excerpt_number','20')))); ?></p>
                  <?php if( get_theme_mod('pool_services_lite_about_button_text','Discover More') != ''){ ?>
                    <div class="more-btn">
                      <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('pool_services_lite_about_button_text',__('Discover More','pool-services-lite')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('pool_services_lite_about_button_text',__('Discover More','pool-services-lite')));?></span></a>
                    </div>
                  <?php } ?>
                </div>
                <div class="col-lg-5 col-md-5">
                  <?php the_post_thumbnail(); ?>
                </div>
              <?php $count++; endwhile; ?>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php endif;
          endif;
          wp_reset_postdata();
        ?>
      </div>
    </div>  
  </section>

  <?php do_action( 'pool_services_lite_after_services_section' ); ?>

  </div>

  <div id="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>