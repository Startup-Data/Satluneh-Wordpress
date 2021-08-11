<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// BREADCRUMBS
// ---------------------------------------------------------------

$highContrast = PEsettings::get( 'highContrast' );

// hidden class
$main_hide_mobile = ( PEsettings::get( 'main-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$main_hide_tablet = ( PEsettings::get( 'main-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$main_hide_desktop = ( PEsettings::get( 'main-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$main_hide_large = ( PEsettings::get( 'main-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$main_hide = $main_hide_mobile . $main_hide_tablet . $main_hide_desktop . $main_hide_large;

if (
	( ! is_front_page() && is_home() && PEsettings::get( 'blog-breadcrumb' ) ) //blog
	|| ( is_archive() && PEsettings::get( 'archive-breadcrumb' ) ) //archive
	|| ( is_single() && PEsettings::get( 'blog-breadcrumb' ) ) //single post
	|| ( ! is_front_page() && is_page() && PEsettings::get( 'page-breadcrumb' ) ) //single page
) :
	?>
	<div id="pe-breadcrumbs" class="<?php echo $main_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="navigation" aria-label="' . __( 'Breadcrumbs', 'pe-terraclassic' ) . '"';
	} ?>>
		<div id="pe-breadcrumbs-in" class="pe-container">
			<div id="pe-breadcrumbs-border">
				<?php pe_breadcrumbs(); ?>
			</div>
		</div>
	</div>
	<?php
endif;
?>
