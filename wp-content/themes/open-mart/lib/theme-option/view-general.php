<?php
/**
 * View General
 *
 * @package Themehunk
 * @subpackage  Open Mart
 * @since 1.0.0
 */
?>
<div class="open-mart-container open-mart-welcome">
		<div id="poststuff">
			<div id="post-body" class="columns-1">
				<div id="post-body-content">
					<!-- All WordPress Notices below header -->
					<h1 class="screen-reader-text"><?php esc_html_e( 'Open Mart', 'open-mart' ); ?> </h1>
						<?php do_action( 'open_mart_welcome_page_content_before' ); ?>
                        <div class="open-mart-content">
						<?php do_action( 'open_mart_welcome_page_main_content' ); ?>
                         </div>
						<?php do_action( 'open_mart_welcome_page_content_after' ); ?>
				</div>
			</div>
			<!-- /post-body -->
			<br class="clear">
		</div>


</div>
