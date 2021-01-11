<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dostart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if ( has_post_thumbnail() && get_post_type() !== 'project' ) : ?>
            <div class="dostart-post-featured-content">
               
                <?php if ( ! is_singular() ) { echo '<a href="'.esc_url( get_the_permalink() ).'">';
                } ?>
                <?php the_post_thumbnail('dostart-thumb'); ?>
                <?php if ( ! is_singular() ) { echo '</a>';
                } ?>
            </div>
        <?php endif; ?>
        <?php

        if ( 'post' === get_post_type() ) :  if ( ! is_singular() ) : ?>
               <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
        <?php endif; ?>
        <div class="entry-meta">
            <?php dostart_posted_on(); ?>
        </div><!-- .entry-meta -->
            <?php
        endif; ?>    

    </header><!-- .entry-header -->

    <div class="entry-content">
    
        <?php
        if ( is_single() ) {
            the_content(
                sprintf(
                /* translators: %s: Name of current post. */
                    wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'dostart'), array( 'span' => array( 'class' => array() ) )),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ) 
            );
            
        } else {
            the_excerpt();
                
            echo '<div style="clear:both"></div><a href="' . esc_url(get_permalink()) . '" class="dostart-btn">'.esc_html__('Read More', 'dostart').'</a>';
        }
            
            
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'dostart'),
                'after'  => '</div>',
            ) 
        );

        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php dostart_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->


