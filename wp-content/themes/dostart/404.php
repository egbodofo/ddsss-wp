<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
                    <h1 class="page-title"><?php esc_html_e('Error Page', 'dostart'); ?></h1>
                    <?php if ( function_exists('bcn_display') ) { bcn_display();
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="dostart-internal-area dostart-v-composer-disabled">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="error-title">
                        <h1><?php esc_html_e('404', 'dostart'); ?></h1>
                    </div>
                    <h2><?php esc_html_e('PAGE NOT FOUND', 'dostart'); ?></h2>
                    <h3><?php esc_html_e('UNFORTUNATELY THE PAGE YOU WERE LOOKING FOR DOES NOT EXIST. MAYBE SEARCH CAN HELP.', 'dostart'); ?></h3>

                    <?php
                    get_search_form();
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
