<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// CONTENT SINGLE (single post)
// ---------------------------------------------------------------

$comments_single    = PEsettings::get( 'post-comments' );
$post_tags_single   = PEsettings::get( 'post-tags' );
$post_info_single   = PEsettings::get( 'blog-details' ); //from blog settings
$author_info_single = PEsettings::get( 'post-author-info' );
$single_post_thumb  = get_post_meta( $post->ID, 'feature_img_archive', true );
$post_page_heading = PEsettings::get( 'post-page-heading' );
?>

<article <?php post_class(); ?>>

	<header class="page-header">

		<?php if($post_page_heading == 7){ ?>
			<p class="page-header-main-title"><?php the_title(); ?></p>
		<?php } else { ?>
			<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
		<?php } ?>

		<?php if ( $post_info_single ) : ?>
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

	<?php if ( has_post_thumbnail() ) {

		pe_show_thumbnail();

	} ?>

	<?php if ( !empty( get_the_content() ) ) { ?>
	<div class="pe-article-content">

		<?php the_content(); ?>

	</div>
	<?php } ?>

	<?php
	wp_link_pages( array(
		'before'      => '<div class="pe-page-links clearfix">',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
	) );
	?>

	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<div class="addthis_sharing_toolbox"></div>

	<?php //TAGS
	if ( has_tag() && $post_tags_single ) { ?>
		<div class='pe-post-tags'>
			<span class='title'><?php esc_html_e( 'Tags', 'pe-terraclassic' ); ?></span>

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

	<?php
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'pe-terraclassic' ) . '</span> ' .
					   '<span class="screen-reader-text">' . __( 'Next post:', 'pe-terraclassic' ) . '</span> ' .
					   '<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'pe-terraclassic' ) . '</span> ' .
					   '<span class="screen-reader-text">' . __( 'Previous post:', 'pe-terraclassic' ) . '</span> ' .
					   '<span class="post-title">%title</span>',
	) );
	?>

	<?php
	$author_desc = get_the_author_meta( 'description' );
	$author_url  = get_the_author_meta( 'user_url' );

	if ( $author_info_single and ! empty( $author_desc ) ) { ?>
		<div class="pe-author-info clearfix">
			<h3 class="pe-title"><?php esc_html_e( 'About Author', 'pe-terraclassic' ); ?></h3>
			<div class="pe-author-in">
				<div class="pe-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?></div>
				<div class="pe-author-details">
					<div class="pe-author-name">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( __( 'View all posts by %s', 'pe-terraclassic' ), get_the_author_meta( 'display_name' ) ); ?>">
							<span class="name"><?php echo get_the_author_meta( 'display_name' ); ?></span>
						</a>
						<?php if ( ! empty( $author_url ) ) : ?>
							<a href="<?php echo $author_url; ?>" rel="external nofollow" class="url" target="_blank"><?php echo $author_url; ?></a>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $author_desc ) ) : ?>
						<div class="pe-author-desc"><?php echo $author_desc; ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php
	if ( $comments_single ) {
		comments_template( '', true );
	}
	?>

</article>
