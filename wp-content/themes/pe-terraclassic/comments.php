<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/
?>

<?php if ( post_password_required() ) : ?>

	<div id="comments">
		<p class="pe-warning"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'pe-terraclassic' ); ?></p>
	</div>

	<?php
	return;/* skip */
endif;
?>


<?php if ( have_comments() || comments_open() ) : ?><?php //die('comment'); ?>
	<div class="pe-comments comments-area comments">

		<?php if ( have_comments() ) : ?>

			<h3 class="comments-title">
				<?php
				printf( _n( 'One comment for &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'pe-terraclassic' ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>' );
				?>
			</h3>

			<ul class="comment-list">
				<?php wp_list_comments( array(
					'type'        => 'all',
					'callback'    => 'pe_comment',
					'style'       => 'ul',
					'avatar_size' => get_option( 'thumbnail_size_w' ),
				) ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-below" class="navigation" role="navigation">
					<h3 class="assistive-text section-heading"><?php esc_html_e( 'Comment navigation', 'pe-terraclassic' ); ?></h3>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'pe-terraclassic' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'pe-terraclassic' ) ); ?></div>
				</nav>
			<?php endif; ?>

			<?php if ( ! comments_open() && get_comments_number() ) : ?>
				<p class="pe-warning"><?php esc_html_e( 'Comments are closed.', 'pe-terraclassic' ); ?></p>
			<?php endif; ?>

		<?php endif; // have_comments() ?>

		<?php
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		$pe_comments_args = array(
			/* Title */
			'title_reply'          => esc_html__( 'Leave Comment', 'pe-terraclassic' ),

			/* After Notes */
			'comment_notes_after'  => '',

			/* Before Notes */
			'comment_notes_before' => '',

			/* Submit */
			'label_submit'         => esc_html__( 'Submit Comment', 'pe-terraclassic' ),
			'class_submit'         => 'button ',

			/* Logged In */
			'logged_in_as'         => '<p class="pe-info">' . sprintf( __( 'You are logged in as %1$s. %2$sLog out %3$s', 'pe-terraclassic' ), '<a href="' . get_option( 'siteurl' ) . '/wp-admin/profile.php">' . $user_identity . '</a>', '<a href="' . ( function_exists( 'wp_logout_url' ) ? wp_logout_url( get_permalink() ) : get_option( 'siteurl' ) . '/wp-login.php?action=logout" title="' ) . '" title="' . esc_html__( 'Log Out', 'pe-terraclassic' ) . '">', '</a>' ) . '</p>',

			/* Comment Field */
			'comment_field'        => '<div class="pe-form-group row"><div class="comment-form-content col-sm-12"><label for="comment" class="input-textarea sr-only">' . esc_html__( '<b>Comment</b> ( * )', 'pe-terraclassic' ) . '</label><textarea class="required form-control" name="comment" id="comment" rows="4" placeholder="' . esc_html__( 'Comment', 'pe-terraclassic' ) . '"></textarea></div></div>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

				'author' => '<div class="pe-form-group row">' . '<div class="comment-form-author col-sm-6" >' . '<label for="author" class="sr-only">' . esc_html__( 'Name', 'pe-terraclassic' ) . '</label> ' . '<input class="form-control" id="author" name="author" type="text" ' . $aria_req . ' placeholder="' . esc_html__( 'Name', 'pe-terraclassic' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></div>',

				'email' => '<div class="comment-form-email col-sm-6" ><label for="email" class="sr-only">' . esc_html__( 'Email', 'pe-terraclassic' ) . '</label> ' . '<input class="form-control" id="email" name="email" type="text" ' . $aria_req . ' placeholder="' . esc_html__( 'Email', 'pe-terraclassic' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" /></div></div>',

				'url' => '<div class="pe-form-group row"><div class="comment-form-url col-sm-12"><label for="url" class="sr-only"><strong>' . esc_html__( 'Website', 'pe-terraclassic' ) . '</strong></label>' . '<input class="form-control" id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'pe-terraclassic' ) . '"	value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>'

			) ),
		);
		comment_form( $pe_comments_args );
		?>

	</div>

	<?php
endif;
?>
