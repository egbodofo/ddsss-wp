<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>>

	<?php do_action( 'lava_page_header' ); ?>

	<div class="container-full"><?php

		do_action( 'lava_before_main_content' );

		woocommerce_breadcrumb();

		wc_get_template_part( 'content', 'single-product' );

		do_action( 'lava_after_main_content' );

		do_action( 'lava_sidebar_content' );

		do_action( 'lava_after_sidebar_content' );

	?></div>

</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();