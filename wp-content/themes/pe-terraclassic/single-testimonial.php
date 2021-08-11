<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// SINGLE POST (type testimonial)
// ---------------------------------------------------------------

get_header();

$testimonial_occupation = get_post_meta( $post->ID, 'testimonial_occupation', true );

$highContrast = PEsettings::get( 'highContrast' );
$main_width   = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';
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

						<article <?php post_class(); ?>>

							<header class="page-header">

								<?php if($post_page_heading == 7){ ?>
									<p class="page-header-main-title"><?php the_title(); ?></p>
								<?php } else { ?>
									<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
								<?php } ?>

								<?php if ( ! empty( $testimonial_occupation ) ) : ?>

									<div class="post-meta standard-meta">

										<span><?php echo sanitize_text_field( $testimonial_occupation ); ?></span>

									</div>

								<?php endif; ?>

							</header>

							<?php
							if ( has_post_thumbnail() ) :
								?>

								<figure>

									<div class="pull-left pe-item-image">

										<?php
										the_post_thumbnail( 'medium' );
										?>

									</div>

								</figure>

							<?php endif; ?>

							<div class="pe-article-content">

								<?php the_content(); ?>

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

			<!-- Sidebars -->
			<?php get_sidebar(); ?>

		</div>

	</div>

</div>

<?php

get_footer();

?>
