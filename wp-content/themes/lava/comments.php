<?php if ( post_password_required() ) : return; endif; ?>

<div id="comments" class="post-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="section-heading"><?php comments_number( esc_html__( 'No Comments', 'lava' ), esc_html__( '1 Comment', 'lava' ), esc_html__( '% Comments', 'lava' ) ); ?></h2>
		<div class="comments-wrapper">
			<ol class="comment-list"><?php wp_list_comments( array( 'callback' => 'lava_comment' ) ); ?></ol>
			<nav class="comments-nav"><?php paginate_comments_links(); ?></nav>
		</div>
	<?php endif; ?>

	<?php if ( !comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'lava' ); ?></p>
	<?php endif; ?>

	<?php 
		$commenter = wp_get_current_commenter();
		$logged_in_as = '';
		$require_name_email = get_option( 'require_name_email' );
		$req_aria = $require_name_email ? " aria-required='true'" : '';
		
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$logged_in_as .= '<p class="logged-in-as">';
			$logged_in_as .= sprintf(
					wp_kses(
						__( 'Logged in as <a href="%1$s">%2$s</a> | <a href="%3$s" title="Log out of this account">Log out?</a>', 'lava' ),
						array(
							'a' => array(
								'href'=> array(),
								'title' => array()
							)
						)
					),
					admin_url( 'profile.php' ),
					$current_user->user_login,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
			);
			$logged_in_as .= '</p>';
		}
		
		if ( comments_open() ) {
			comment_form( 
				array( 
				    'title_reply' => esc_html__( 'Leave a Reply', 'lava' ),
				    'title_reply_to' => '<span>' . esc_html__( 'Leave a Reply to %s', 'lava' ) . '</span>',
				    'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title section-heading">',
				    'cancel_reply_link' => esc_html__( 'Cancel Reply', 'lava' ),
				    'label_submit' => esc_html__( 'Post Comment', 'lava' ),
				    'comment_notes_after' => $logged_in_as,
				    'comment_notes_before' => '',
					'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true" placeholder="' . esc_attr__( 'Write a comment', 'lava' ) . '"></textarea></p>',
				    'logged_in_as' => '',
					'fields' => apply_filters( 'comment_form_default_fields', 
						array( 
					        'author' => '<p class="comment-form-author"><input name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $req_aria . ' placeholder="' . esc_attr__( 'Name', 'lava' ) . ( $require_name_email ? '*' : '' ) . '" /></p>',
					        'email' => '<p class="comment-form-email"><input name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $req_aria . ' placeholder="' . esc_attr__( 'Email', 'lava' ) . ( $require_name_email ? '*' : '' ) . '"/></p>',
					        'url' => '<p class="comment-form-url"><input name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . esc_attr__( 'Website', 'lava' ) . '" /></p>'
					    	)
						)
					)
				);
		}
	?>
</div>

<?php
/**
* Output custom comments
* 
* @param mixed   $comment
* @param array   $args
* @param integer $depth
*/
function lava_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		switch ( $comment->comment_type ) {
			case 'pingback': ?>

			<li class="post pingback">
				<p><?php esc_html_e( 'Pingback', 'lava' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'lava' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php 
				break;
			case 'trackback': ?>

			<li class="post trackback">
				<p><?php esc_html_e( 'Trackback', 'lava' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'lava' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
				break;
			default: ?>

			
			<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<article id="comment-<?php comment_ID(); ?>">
					
					<?php echo get_avatar( $comment, 90 ); ?>
					
					<div class="comment-content">
						<div class="comment-meta">					
							<span class="comment-author"><?php comment_author_link(); ?></span>
							<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
								<?php printf( esc_html__( '%1$s at %2$s', 'lava' ), get_comment_date(),  get_comment_time() ); ?>
							</a>
							<?php edit_comment_link( esc_html__( 'Edit', 'lava' ), '  ', '' ); ?>
						</div>
						
						<?php comment_text(); ?>
						
						<?php if ( $comment->comment_approved == '0' ): ?>
							
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'lava' ); ?></em>
						
						<?php endif; ?>
						
						<div class="reply">
						<?php comment_reply_link(
								array_merge( $args, array(
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
										'reply_text' => esc_html__( 'Reply', 'lava' ),
										'login_text' => esc_html__( 'Log in to leave a comment', 'lava' )
								))); ?>
						</div>
					</div>
				</article>
			</li>

		<?php
		}
}