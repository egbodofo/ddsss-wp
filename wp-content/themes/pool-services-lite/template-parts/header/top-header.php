<?php
/**
 * The template part for header
 *
 * @package Pool Services Lite 
 * @subpackage pool-services-lite
 * @since pool-services-lite 1.0
 */
?>

<div class="top-bar">
      <div class="container">
            <div class="row">
                  <div class="col-lg-7 col-md-7">
                  <?php if( get_theme_mod( 'pool_services_lite_location') != '') { ?>
                        <p><i class="<?php echo esc_attr(get_theme_mod('pool_services_lite_location_icon','fas fa-map-marker-alt')); ?>"></i><?php echo esc_html(get_theme_mod('pool_services_lite_location',''));?></p>
                  <?php }?>
                  </div>
                  <div class="col-lg-5 col-md-5">
                        <?php dynamic_sidebar('social-links'); ?>
                  </div>
            </div>
	</div>
</div>