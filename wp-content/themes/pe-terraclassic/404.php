<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// ERROR 404 (with search form and sidebars)
// ---------------------------------------------------------------

get_header();

$allowed_html_array = array(
	'i'      => array(),
	'br'     => array(),
	'strong' => array(),
);

$highContrast = PEsettings::get( 'highContrast' );
$main_width   = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';

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

					<div class="pe-error-page">
						<h1><?php esc_html_e( 'OOPS! Error 404', 'pe-terraclassic' ); ?></h1>
						<h2><?php esc_html_e( 'Page Not found!', 'pe-terraclassic' ); ?></h2>
						<p><?php echo wp_kses( __( '"Sorry, it appears the page you were looking for doesnt exist anymore or might have been moved. <br /> Please try your luck again."', 'pe-terraclassic' ), $allowed_html_array ); ?></p>
						<div class="search">
							<form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
								<input type="search" id="pe-search-searchword" maxlength="200" size="40" placeholder="<?php esc_html_e( 'Search ...', 'pe-terraclassic' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_html_e( 'Search for:', 'pe-terraclassic' ); ?>"/>
								<input type="submit" class="button" value="<?php esc_html_e( 'Search', 'pe-terraclassic' ); ?>"/>
							</form>
						</div>
						<a class="button" href="<?php echo get_site_url(); ?>"><?php esc_html_e( 'Go back home', 'pe-terraclassic' ); ?></a>
					</div>

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
