<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// POST WITH INTRO EFFECT
// ---------------------------------------------------------------

if ( is_archive() ) {
	$post_info      = PEsettings::get( 'archive-details' );
	$thumbnail      = PEsettings::get( 'archive-thumbnails' );
	$excerpt        = PEsettings::get( 'archive-excerpt' );
	$excerpt_length = ( $excerpt ) ? PEsettings::get( 'archive-excerpt-length' ) : 55;
	$readmore       = PEsettings::get( 'archive-readmore' );
} else {
	$post_info      = PEsettings::get( 'blog-details' );
	$thumbnail      = PEsettings::get( 'blog-thumbnails' );
	$excerpt        = PEsettings::get( 'blog-excerpt' );
	$excerpt_length = ( $excerpt ) ? PEsettings::get( 'blog-excerpt-length' ) : 55;
	$readmore       = PEsettings::get( 'blog-readmore' );
}

$archive_blog_post_page_heading = PEsettings::get( 'archive-blog-post-page-heading' );

//show only posts with images
if ( has_post_thumbnail() && $thumbnail ) :

	?>

	<article <?php post_class(); ?>>

		<header class="page-header">
			
			<?php if($archive_blog_post_page_heading == 7){ ?>
				<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
			<?php } else { ?>
				<h<?php echo $archive_blog_post_page_heading; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h<?php echo $archive_blog_post_page_heading; ?>>
			<?php } ?>
			
			<?php if ( $post_info ) : ?>
				<div class="post-meta standard-meta">
					<span><?php esc_html_e( 'Posted on', 'pe-terraclassic' ); ?>
						<span class="date"><?php the_time( 'F d, Y' ); ?></span></span>
					<span><?php esc_html_e( 'by', 'pe-terraclassic' ); ?>
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

		<figure class="pe-image effect">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
			<figcaption>
				<div class="intro">
					<?php
					if ( $readmore ) {
						pe_excerpt( $excerpt_length, '', true );
					} else {
						pe_excerpt( $excerpt_length );
					}
					?>
				</div>
			</figcaption>
		</figure>

	</article>

<?php else : //if not thumbnails ?>

	<?php get_template_part( 'tpl/post', 'standard' ); ?>

<?php endif; ?>
