<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// POST STANDARD (used in blog layout)
// ---------------------------------------------------------------

if ( is_archive() ) {
	$post_info      = PEsettings::get( 'archive-details' );
	$thumbnail      = PEsettings::get( 'archive-thumbnails' );
	$excerpt        = PEsettings::get( 'archive-excerpt' );
	$excerpt_length = ( $excerpt ) ? PEsettings::get( 'archive-excerpt-length' ) : 'full';
	$readmore       = PEsettings::get( 'archive-readmore' );
} else {
	$post_info      = PEsettings::get( 'blog-details' );
	$thumbnail      = PEsettings::get( 'blog-thumbnails' );
	$excerpt        = PEsettings::get( 'blog-excerpt' );
	$excerpt_length = ( $excerpt ) ? PEsettings::get( 'blog-excerpt-length' ) : 'full';
	$readmore       = PEsettings::get( 'blog-readmore' );
}

$post_tags_single   = PEsettings::get( 'post-tags' );

$archive_blog_post_page_heading = PEsettings::get( 'archive-blog-post-page-heading' );
?>

<article <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && $thumbnail ) {

		pe_show_thumbnail( 'large', false );

	} ?>

	<header class="page-header">
	
		<?php if($archive_blog_post_page_heading == 7){ ?>
			<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
		<?php } else { ?>
			<h<?php echo $archive_blog_post_page_heading; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h<?php echo $archive_blog_post_page_heading; ?>>
		<?php } ?>
		
		<?php if ( $post_info ) : ?>
			<div class="post-meta standard-meta">
				<span class="date-wrap"><?php esc_html_e( 'Posted on', 'pe-terraclassic' ); ?>
					<span class="date"><?php the_time( 'F d, Y' ); ?></span></span><span class="separator">|</span>
				<span class="author-wrap"><?php esc_html_e( 'By', 'pe-terraclassic' ); ?>
					<span class="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( __( 'View all posts by %s', 'pe-terraclassic' ), get_the_author_meta( 'display_name' ) ); ?>">
						<?php echo get_the_author_meta( 'display_name' ); ?>
					</a>
				</span>
					<?php if ( has_category() ) : ?>
						<span class="separator">|</span>
						<?php esc_html_e( 'In', 'pe-terraclassic' ); ?> <?php the_category( ', ' ); ?><?php endif; ?>
					<?php edit_post_link( esc_html__( 'Edit Post', 'pe-terraclassic' ), '<span class="separator">|</span>', '' ); ?>
			</span>
			</div>
		<?php endif; ?>


			
	</header>
	
	<div class="pe-article-content">
		<?php
		if ( $readmore ) {
			pe_excerpt( $excerpt_length, '', true );
		} else {
			pe_excerpt( $excerpt_length );
		}
		?>
	</div>
	<?php //TAGS
	if ( has_tag() && $post_tags_single ) { ?>
		<div class='pe-post-tags'>
			<?php
			$tags = get_the_tags();
			$html = '<ul class="pe-tags">';
			foreach ( $tags as $tag ) {
				$html .= '<li><a href="' . get_tag_link( $tag->term_id ) . '" title="' . $tag->name . ' ' . esc_html__( 'Tag', 'pe-terraclassic' ) . '" class="pe-tag ' . $tag->slug . '" rel="tag">' . $tag->name . '</a></li>';
			}
			$html .= '</ul>';
			echo $html;
			?>
		</div>
	<?php } ?>
</article>
