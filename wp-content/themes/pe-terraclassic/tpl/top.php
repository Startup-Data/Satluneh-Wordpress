<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// TOP (sidebars)
// ---------------------------------------------------------------

$top1_width = ( PEsettings::get( 'full-screen,top1' ) == 1 ) ? 'full' : '';
$top2_width = ( PEsettings::get( 'full-screen,top2' ) == 1 ) ? 'full' : '';

$highContrast = PEsettings::get( 'highContrast' );

// hidden class
$top1_mobile = ( PEsettings::get( 'top1-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$top1_hide_tablet = ( PEsettings::get( 'top1-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$top1_hide_desktop = ( PEsettings::get( 'top1-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$top1_hide_large = ( PEsettings::get( 'top1-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$top1_hide = $top1_mobile . $top1_hide_tablet . $top1_hide_desktop . $top1_hide_large;

$top2_mobile = ( PEsettings::get( 'top2-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$top2_hide_tablet = ( PEsettings::get( 'top2-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$top2_hide_desktop = ( PEsettings::get( 'top2-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$top2_hide_large = ( PEsettings::get( 'top2-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$top2_hide = $top2_mobile . $top2_hide_tablet . $top2_hide_desktop . $top2_hide_large;

$top3_mobile = ( PEsettings::get( 'top3-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$top3_hide_tablet = ( PEsettings::get( 'top3-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$top3_hide_desktop = ( PEsettings::get( 'top3-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$top3_hide_large = ( PEsettings::get( 'top3-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$top3_hide = $top3_mobile . $top3_hide_tablet . $top3_hide_desktop . $top3_hide_large;

if ( is_active_sidebar( 'top1' ) ) : ?>
	<div id="pe-top1" class="<?php echo $top1_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'top1-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'top1-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-top1-in" class="pe-container <?php echo $top1_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'top1' ); ?>
			</div>
		</div>
	</div>
<?php endif;

if ( is_active_sidebar( 'top2' ) ) : ?>
	<div id="pe-top2" class="<?php echo $top2_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'top2-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'top2-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-top2-in" class="pe-container <?php echo $top2_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'top2' ); ?>
			</div>
		</div>
	</div>
<?php endif;

if ( is_active_sidebar( 'top3' ) ) : ?>
	<div id="pe-top3" class="<?php echo $top3_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'top3-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'top3-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-top3-in" class="pe-container <?php echo $top2_width; ?>">
			<div class="row">
				<?php dynamic_sidebar( 'top3' ); ?>
			</div>
		</div>
	</div>
<?php endif;
