<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php if ( post_password_required() ) return; ?>
<div class="comments">
  <?php if ( have_comments() ) : ?>
    <h3 class="comments-title">
        <?php
            printf( _n( 'One comment for &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'PixelEmu' ),
                    number_format_i18n( get_comments_number() ), 
                    '<span>' . get_the_title() . '</span>' );
        ?>
    </h3>
    <ul class="comment-list">
        <?php wp_list_comments( array( 'style' => 'ul', 'avatar_size' => 52, ) ); ?>
    </ul>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav id="comment-nav-below" class="navigation" role="navigation">
        <h3 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'PixelEmu' ); ?></h3>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'PixelEmu' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'PixelEmu' ) ); ?></div>
    </nav>
    <?php endif; 
  
    if ( ! comments_open() && get_comments_number() ) : ?>
    <p class="nocomments"><?php _e( 'Comments are closed.' , 'PixelEmu' ); ?></p>
    
    <?php endif; endif; 
  
  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  
  $pe_comments_args = array(
        /*:: Title*/
        'title_reply' => __('Leave Comment','PixelEmu'),
        /*:: After Notes*/
        'comment_notes_after'  => '',
        /*:: Before Notes*/
        'comment_notes_before' => '',
        /*:: Submit*/
        'label_submit' => __( 'Submit Comment' , 'PixelEmu'),
        'class_submit' => 'btn btn-default',
        /*:: Logged In*/
        'logged_in_as' => '<p>'. sprintf(__('You are logged in as %1$s. %2$sLog out %3$s', 'PixelEmu'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>', '<a href="'.(function_exists('wp_logout_url') ? wp_logout_url(get_permalink()) : get_option('siteurl').'/wp-login.php?action=logout" title="').'" title="'.__('Log Out', 'PixelEmu').'">', '</a>') . '</p>',
        /*:: Comment Field*/
        'comment_field' => '<div class="form-group row"><div class="comment-form-content col-sm-12"><label for="comment" class="input-textarea sr-only">' . __('<b>Comment</b> ( * )','PixelEmu'). '</label>
    <textarea class="required form-control" name="comment" id="comment" rows="4" placeholder="'.__( 'Comment', 'PixelEmu' ).'"></textarea></div></div>',
    
    'fields' => apply_filters( 'comment_form_default_fields', array(
    
        'author' =>
          '<div class="form-group row">' .
          '<div class="comment-form-author col-sm-6" >'.
          '<label for="author" class="sr-only">'.__( 'Name', 'PixelEmu' ).'</label> ' .
          '<input class="form-control" id="author" name="author" type="text" '. $aria_req .' placeholder="'.__( 'Name', 'PixelEmu' ).'" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30" /></div>',
    
        'email' =>
          '<div class="comment-form-email col-sm-6" ><label for="email" class="sr-only">'.__( 'Email', 'PixelEmu' ).'</label> ' .
          '<input class="form-control" id="email" name="email" type="text" '. $aria_req .' placeholder="'.__( 'Email', 'PixelEmu' ).'" value="'. esc_attr(  $commenter['comment_author_email'] ) .
          '" size="30" /></div></div>',
    
        'url' =>
          '<div class="form-group row"><div class="comment-form-url col-sm-12"><label for="url" class="sr-only"><strong>' .
          __( 'Website', 'PixelEmu' ) . '</strong></label>' .
          '<input class="form-control" id="url" name="url" type="text" placeholder="'.__( 'Website', 'PixelEmu' ).'"  value="' . esc_attr( $commenter['comment_author_url'] ) .
          '" size="30" /></div></div>'
        )
      ),
    );
    
  comment_form( $pe_comments_args );
  
  ?>  
</div>
