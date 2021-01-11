<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dostart
 */

get_header(); ?>
    
    <div class="dostart-breadcrumb-bg">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-inner">
                        <div class="breadcrumb-inner-content">
                            <h1><?php the_title();  ?></h1>
                            <?php if ( function_exists('bcn_display') ) {
                                bcn_display();
                            } ?> 
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>       
    
    <div class="dostart-page-content dostart-internal-area dostart-v-composer-disabled">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <?php woocommerce_content(); ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
