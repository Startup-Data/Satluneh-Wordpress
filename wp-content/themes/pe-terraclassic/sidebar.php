<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
 Website: https://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// SIDEBAR (left and right sidebar)
// ---------------------------------------------------------------

$highContrast = PEsettings::get( 'highContrast' );

if ( PElayout::get( 'span-left' ) && is_active_sidebar( 'left-column' ) ) : ?>
	<aside id="pe-left" class="<?php echo PElayout::get( 'left-class' ) ?>" <?php if ( $highContrast ) {
		echo 'role="complementary"';
		if ( PEsettings::get( 'left-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'left-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-left-in">
			<div class="row">
				<?php dynamic_sidebar( 'left-column' ); ?>
			</div>
		</div>
	</aside>
<?php endif;

if ( PElayout::get( 'span-right' ) && is_active_sidebar( 'right-column' ) ) : ?>
	<aside id="pe-right" class="<?php echo PElayout::get( 'right-class' ); ?>" <?php if ( $highContrast ) {
		echo 'role="complementary"';
		if ( PEsettings::get( 'right-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'right-label' ) ) . '"';
		}
	} ?>>
		<div id="pe-right-in">
			<div class="row">
				<?php dynamic_sidebar( 'right-column' ); ?>
			</div>
		</div>
	</aside>
<?php endif; ?>
