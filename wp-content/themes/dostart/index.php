<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dostart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header(); ?>

    <div class="dostart-breadcrumb-area blog-breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php esc_html_e('Latest News', 'dostart'); ?></h1>
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'dostart'); ?></a>
                        &nbsp; / &nbsp; 
                    <span class="current"><?php esc_html_e('Blog', 'dostart'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="dostart-internal-area dostart-v-composer-disabled">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-page-padding">
                    <?php
                    if ( have_posts() ) :
                        if ( is_home() && ! is_front_page() ) : ?>
                                <header>
                                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                </header>

                            <?php
                        endif;

                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('template-parts/content', get_post_format());
                        endwhile;

                        the_posts_navigation();
                    else :
                            get_template_part( 'template-parts/content', 'none' );
                    endif; ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

<?php
get_footer();
