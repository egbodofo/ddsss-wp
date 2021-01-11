<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dostart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

    <div class="dostart-breadcrumb-area dostart-single-blog-breadcrumb" <?php if ( has_post_thumbnail() ) :
        ?> style="background-image:url(<?php echo esc_url(the_post_thumbnail_url('large'));?>)"<?php
                                                                        endif;?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php the_title(); ?></h1>
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'dostart'); ?></a>
                        &nbsp; / &nbsp; 
                    <span class="current"><?php the_title(); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="dostart-internal-area dostart-v-composer-disabled">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part(
                            'template-parts/content',
                            get_post_format()
                        );

                        the_post_navigation();
                            
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile; // End of the loop.
                    ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

<?php
get_footer();
