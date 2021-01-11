<?php
/**
 * The template for displaying room reviews (comment).
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/single-room-reviews.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_room, $hb_settings;

/**
 * @var $hb_room WPHB_Room
 * @var $hb_settings WPHB_Settings
 */

if ( ! comments_open() ) {
	return;
} ?>

<div id="reviews">
    <div id="comments">
        <h3 class="section-heading"><?php esc_html_e( 'Reviews', 'lava' ); ?></h3>

		<?php if ( have_comments() ) { ?>
            <ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'hb_room_review_list_args', array( 'callback' => 'hb_comments' ) ) ); ?>
            </ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
                <nav class="hb-pagination">
					<?php paginate_comments_links( apply_filters( 'hb_comment_pagination_args', array(
						'prev_text' => '&larr;',
						'next_text' => '&rarr;',
						'type'      => 'plain',
					) ) );
					?>
                </nav>
			<?php } ?>

		<?php } else { ?>
            <p class="hb-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'lava' ); ?></p>
		<?php } ?>
    </div>

	<?php if ( hb_customer_booked_room( $hb_room->id ) ) { ?>

        <div id="review_form_wrapper">
            <div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					'title_reply'          => have_comments() ? '<i class="material-icons">mode_edit</i>' . esc_html__( 'Add a review', 'lava' ) : '<i class="material-icons">mode_edit</i>' . esc_html__( 'Be the first to review', 'lava' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
					'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'lava' ),
					'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title widget-title">',
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'fields'               => array(
						'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" placeholder="'. esc_attr__( 'Name', 'lava' ) .'" /></p>',
						'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" placeholder="'. esc_attr__( 'Email', 'lava' ) .'"/></p>',
					),
					'label_submit'         => esc_html__( 'Submit', 'lava' ),
					'class_submit'		   => 'submit btn-primary',
					'logged_in_as'         => '',
					'comment_field'        => ''
				);

				if ( $hb_settings->get( 'enable_review_rating' ) ) {
					$comment_form['comment_field'] = '<div class="hb-rating-input"></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'. esc_attr__( 'Your Review', 'lava' ) .'"></textarea></p>';
				comment_form( apply_filters( 'hb_product_review_comment_form_args', $comment_form ) );
				?>
            </div>
        </div>

	<?php } else { ?>
        <p class="hb-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'lava' ); ?></p>
	<?php }; ?>

    <div class="clear"></div>
</div>
