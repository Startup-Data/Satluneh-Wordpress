<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// CONTENT TOP (sidebar)
// ---------------------------------------------------------------

$highContrast = PEsettings::get( 'highContrast' );

if ( is_active_sidebar( 'content-top' ) ) : ?>
	<div id="pe-content-top" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'content-top-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'content-top-label' ) ) . '"';
		}
	} ?>>
		<div class="row">
			<?php dynamic_sidebar( 'content-top' ); ?>
		</div>
	</div>
<?php endif; ?>
