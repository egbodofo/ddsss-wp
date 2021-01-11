<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();
do_action( 'lava_content_start' );
do_action( 'lava_page_header' );
?>
	<div class="container-full">
		<div class="<?php echo esc_attr( Lava()->get_layout() ); ?>">
			<?php do_action( 'lava_before_main_content' ); ?>
			<div id="tribe-events-pg-template" class="main">
				<?php tribe_events_before_html(); ?>
				<?php tribe_get_view(); ?>
				<?php tribe_events_after_html(); ?>
			</div> <!-- #tribe-events-pg-template -->
			<?php do_action( 'lava_after_main_content' ); ?>
			<?php do_action( 'lava_ec_sidebar_content' ); ?>
			<?php do_action( 'lava_after_sidebar_content' ); ?>
		</div>
	</div>
</div><?php
do_action( 'lava_content_end' );
get_footer();
