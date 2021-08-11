<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// FRONT PAGE (static page or blog loop, no sidebars)
// ---------------------------------------------------------------

get_header();

//set layout
PElayout::set( 4 );

//check front content
$front_page_check = ( ! PEsettings::get( 'front-page-content' ) && is_front_page() ) ? false : true;


// hidden class
$main_hide_mobile = ( PEsettings::get( 'main-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$main_hide_tablet = ( PEsettings::get( 'main-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$main_hide_desktop = ( PEsettings::get( 'main-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$main_hide_large = ( PEsettings::get( 'main-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$main_hide = $main_hide_mobile . $main_hide_tablet . $main_hide_desktop . $main_hide_large;

//check sidebars
$sidebars = ( is_active_sidebar( 'content-top' ) || is_active_sidebar( 'content-bottom' ) || is_active_sidebar( 'left-column' ) || is_active_sidebar( 'right-column' ) ) ? true : false;

$highContrast = PEsettings::get( 'highContrast' );

$main_width = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';

if ( $sidebars || is_home() || $front_page_check ) :

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

						<?php

						if ( have_posts() ) :

							// Get appropriate template part for loop if Latest Post option
							if ( is_home() ) {

								get_template_part( 'tpl/blog' );

							} else { // display sigle page if Static Page option

								if ( $front_page_check ) { //display content if enabled and is static page

									while ( have_posts() ) : the_post(); ?>

										<?php get_template_part( 'tpl/content', 'page' ); ?>

										<?php

									endwhile;

								}

							}

						else : ?>

							<?php get_template_part( 'tpl/content', 'none' ); ?>

						<?php endif; ?>

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

endif;

get_footer();

?>
