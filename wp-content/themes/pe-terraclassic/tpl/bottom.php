<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// BOTTOM (sidebars)
// ---------------------------------------------------------------

$bottom1_width = ( PEsettings::get( 'full-screen,bottom1' ) == 1 ) ? 'full' : '';
$bottom2_width = ( PEsettings::get( 'full-screen,bottom2' ) == 1 ) ? 'full' : '';

$footer_width = ( PEsettings::get( 'full-screen,footer' ) == 1 ) ? 'full' : '';

$highContrast = PEsettings::get( 'highContrast' );

// hidden class
$bottom1_hide_mobile = ( PEsettings::get( 'bottom1-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$bottom1_hide_tablet = ( PEsettings::get( 'bottom1-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$bottom1_hide_desktop = ( PEsettings::get( 'bottom1-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$bottom1_hide_large = ( PEsettings::get( 'bottom1-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$bottom1_hide = $bottom1_hide_mobile . $bottom1_hide_tablet . $bottom1_hide_desktop . $bottom1_hide_large;

$bottom2_hide_mobile = ( PEsettings::get( 'bottom2-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$bottom2_hide_tablet = ( PEsettings::get( 'bottom2-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$bottom2_hide_desktop = ( PEsettings::get( 'bottom2-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$bottom2_hide_large = ( PEsettings::get( 'bottom2-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$bottom2_hide = $bottom2_hide_mobile . $bottom2_hide_tablet . $bottom2_hide_desktop . $bottom2_hide_large;

$footer_hide_mobile = ( PEsettings::get( 'footer-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$footer_hide_tablet = ( PEsettings::get( 'footer-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$footer_hide_desktop = ( PEsettings::get( 'footer-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$footer_hide_large = ( PEsettings::get( 'footer-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$footer_hide = $footer_hide_mobile . $footer_hide_tablet . $footer_hide_desktop . $footer_hide_large;

if ( is_active_sidebar( 'bottom1' ) ) : ?>
	<div id="pe-bottom1" class="<?php echo $bottom1_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'bottom1-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'bottom1-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-bottom1-in" class="pe-container <?php echo $bottom1_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'bottom1' ); ?>
			</div>
		</div>
	</div>
<?php endif;

if ( is_active_sidebar( 'bottom2' ) ) : ?>
	<div id="pe-bottom2" class="<?php echo $bottom2_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'bottom2-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'bottom2-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-bottom2-in" class="pe-container <?php echo $bottom2_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'bottom2' ); ?>
			</div>
		</div>
	</div>
<?php endif;

if ( is_active_sidebar( 'footer' ) ) : ?>
	<div id="pe-footer" class="<?php echo $footer_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'footer-mod-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'footer-mod-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-footer-in" class="pe-container <?php echo $footer_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
		</div>
	</div>
<?php endif;
