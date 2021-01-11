<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

do_action( 'lava_content_start' ); ?>

<div class="<?php echo esc_attr( Lava()->get_layout() ); ?>">

	<?php do_action( 'lava_page_header' ); ?>

	<div class="container-full"><?php

	 	if ( have_posts() ) {

			do_action( 'lava_before_main_content' );

			woocommerce_content();

			do_action( 'lava_after_main_content' );

			do_action( 'lava_sidebar_content' );

			do_action( 'lava_after_sidebar_content' );
	
		} else {

			get_template_part( 'templates/content', 'none' );
		}

	?></div>
</div><?php

do_action( 'lava_content_end' );

get_footer();
