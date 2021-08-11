<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// ATTACHMENT
// ---------------------------------------------------------------

get_header();

$post_info_single = PEsettings::get( 'blog-details' ); //from blog settings
$highContrast     = PEsettings::get( 'highContrast' );
$main_width       = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';
$post_page_heading = PEsettings::get( 'post-page-heading' );

// hidden class
$main_hide_mobile = ( PEsettings::get( 'main-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$main_hide_tablet = ( PEsettings::get( 'main-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$main_hide_desktop = ( PEsettings::get( 'main-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$main_hide_large = ( PEsettings::get( 'main-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$main_hide = $main_hide_mobile . $main_hide_tablet . $main_hide_desktop . $main_hide_large;
?>

<div id="pe-content-part" class="<?php echo $main_hide; ?>">

	<div id="pe-content-part-in" class="pe-container <?php echo $main_width; ?>">
		<div class="pe-row">

			<div id="pe-content" class="<?php echo PElayout::get( 'content-class' ); ?>">

				<?php get_template_part( 'tpl/content-top' ); ?>

				<!-- Begin of main content area -->
				<main id="pe-maincontent" <?php if ( $highContrast ) {
					echo 'role="main" tabindex="-1"';
				} ?>>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class( array( 'pe-article', 'clearfix' ) ); ?>>

							<header class="page-header">

								<?php if($post_page_heading == 7){ ?>
									<p class="page-header-main-title"><?php the_title(); ?></p>
								<?php } else { ?>
									<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
								<?php } ?>

								<?php if ( $post_info_single ) : ?>
									<div class="post-meta standard-meta">

										<span><?php esc_html_e( 'Posted on', 'pe-terraclassic' ); ?>
											<span class="date"> <?php the_time( 'F d, Y' ); ?></span></span>

										<span><?php esc_html_e( 'by', 'pe-terraclassic' ); ?>
											<span class="author-link">
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( esc_html__( 'View all posts by %s', 'pe-terraclassic' ), get_the_author_meta( 'display_name' ) ); ?>">
											<?php echo get_the_author_meta( 'display_name' ); ?>
										</a>
									</span>
											<?php esc_html_e( 'in', 'pe-terraclassic' ); ?> <?php the_category( ', ' ); ?>
								</span>

									</div>
								<?php endif; ?>

							</header>

							<?php echo wp_get_attachment_image( get_the_ID(), 'large' ); ?>

							<div class="pe-article-content">

								<?php the_content(); ?>

								<div class="pe-download">
									<h3 class="pe-title"><?php esc_html_e( 'Downloads', 'pe-terraclassic' ) ?></h3>
									<?php
									$images      = array();
									$image_sizes = get_intermediate_image_sizes();
									array_unshift( $image_sizes, 'full' );
									foreach ( $image_sizes as $image_size ) {
										$image    = wp_get_attachment_image_src( get_the_ID(), $image_size );
										$name     = $image_size . ' (' . $image[1] . 'x' . $image[2] . ')';
										$images[] = '<a href="' . $image[0] . '">' . $name . '</a>';
									}
									echo '<ul><li>' . implode( '</li><li>', $images ) . '</li></ul>';
									?>
								</div>

							</div>

						</article>


						<?php
					endwhile;
					endif;
					?>

				</main>
				<!-- End of main content area -->

				<?php get_template_part( 'tpl/content-bottom' ); ?>

			</div>

		</div>

	</div>

</div>

<?php

get_footer();

?>
