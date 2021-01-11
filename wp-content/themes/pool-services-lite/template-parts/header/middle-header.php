<?php
/**
 * The template part for header
 *
 * @package Pool Services Lite 
 * @subpackage pool-services-lite
 * @since pool-services-lite 1.0
 */
?>

<div class="middle-header">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-5 left-bg">
				<div class="row">
					<?php if( get_theme_mod( 'pool_services_lite_cart_enable',true) != '' ) { ?>
						<div class="col-lg-2 col-md-2 icon-ctr">
							<?php if(class_exists('woocommerce')){ ?>
					          	<div class="cart_no">
					            	<a href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e( 'shopping cart','pool-services-lite' ); ?>"><i class="<?php echo esc_attr(get_theme_mod('pool_services_lite_cart_icon','fas fa-shopping-basket')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'shopping cart','pool-services-lite' );?></span></a>
					            	<span class="cart-value"> <?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
					          	</div>
					        <?php } ?>
					    </div>
					<?php }?>
				    <div class="<?php if(get_theme_mod( 'pool_services_lite_cart_enable',true)) { ?>col-lg-10 col-md-10 " <?php } else { ?>col-lg-12 col-md-12" <?php } ?>>
				    	<div class="row info-ctr">
				    		<?php if( get_theme_mod( 'pool_services_lite_phone_text') != '' || get_theme_mod( 'pool_services_lite_phone_number') != '') { ?>
		          			<div class="col-lg-3 col-md-3 col-3 icon-ctr">
		          				<div class="phone">
				            		<i class="<?php echo esc_attr(get_theme_mod('pool_services_lite_phone_no_icon','fas fa-phone-volume')); ?>"></i>
				            	</div>
				          	</div>
				          	<div class="col-lg-9 col-md-9 col-9">
				            	<h6><?php echo esc_html(get_theme_mod('pool_services_lite_phone_text',''));?></h6>
				            	<p><?php echo esc_html(get_theme_mod('pool_services_lite_phone_number',''));?></p>
				          	</div>
				      		<?php }?>
				    	</div>
				    </div>
		      	</div>
		    </div>
		    <div class="col-lg-2 col-md-2">
		      	<div class="logo">
			        <?php if ( has_custom_logo() ) : ?>
		             	<div class="site-logo"><?php the_custom_logo(); ?></div>
		            <?php endif; ?>
		            <?php $blog_info = get_bloginfo( 'name' ); ?>
		              <?php if ( ! empty( $blog_info ) ) : ?>
		                <?php if ( is_front_page() && is_home() ) : ?>
		                	<?php if( get_theme_mod('pool_services_lite_logo_title_hide_show',true) != ''){ ?>
		                  		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		                  	<?php } ?>
		                <?php else : ?>
		                	<?php if( get_theme_mod('pool_services_lite_logo_title_hide_show',true) != ''){ ?>
		                  		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		                  	<?php } ?>
		                <?php endif; ?>
		              <?php endif; ?>
		              <?php
		                $description = get_bloginfo( 'description', 'display' );
		                if ( $description || is_customize_preview() ) :
		              ?>
		              	<?php if( get_theme_mod('pool_services_lite_tagline_hide_show',true) != ''){ ?>
			              <p class="site-description">
			                <?php echo $description; ?>
			              </p>
			            <?php } ?>
		            <?php endif; ?>
		      	</div>
		    </div>
		    <div class="col-lg-5 col-md-5 right-bg">
		    	<div class="<?php if(get_theme_mod( 'pool_services_lite_search_enable',true)) { ?>row" <?php } else { ?>row m-0" <?php } ?>>
		    		<div class="<?php if(get_theme_mod( 'pool_services_lite_search_enable',true)) { ?>offset-lg-2 col-lg-8 col-md-10" <?php } else { ?>offset-lg-2 col-lg-12 col-md-12 <?php } ?>">
		    			<div class="row info-ctr">
		    				<?php if( get_theme_mod( 'pool_services_lite_email_text') != '' || get_theme_mod( 'pool_services_lite_email_address') != '') { ?>
			          			<div class="col-lg-3 col-md-3 col-3 icon-ctr">
			          				<div class="envelope">
					            		<i class="<?php echo esc_attr(get_theme_mod('pool_services_lite_email_address_icon','fas fa-envelope-open')); ?>"></i>
					            	</div>
					          	</div>
					          	<div class="col-lg-9 col-md-9 col-9">
					            	<h6><?php echo esc_html(get_theme_mod('pool_services_lite_email_text',''));?></h6>
					            	<p><a href="mailto:<?php echo esc_html(get_theme_mod('pool_services_lite_email_address',''));?>"><?php echo esc_html(get_theme_mod('pool_services_lite_email_address',''));?><span class="screen-reader-text"><?php esc_html_e( 'example@gmail.com','pool-services-lite' );?></span></a></p>
					          	</div>
					      	<?php }?>
		    			</div>
		    		</div>
		    		<?php if( get_theme_mod( 'pool_services_lite_search_enable',true) != '' ) { ?>
			    		<div class="col-lg-1 col-md-1">
			    			<div class="search-box">
			    				<button type="button" data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i></button>
			  				</div>
		    			</div>
		    		<?php }?>
		    	</div>
		    </div>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
		      <div class="modal-body">
		        <div class="serach_inner">
		          <?php get_search_form(); ?>
		        </div>
		      </div>
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    </div>
		</div>
	</div>
</div>