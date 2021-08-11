<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// CONTENT BOTTOM (sidebar)
// ---------------------------------------------------------------

$highContrast = PEsettings::get( 'highContrast' );

if ( is_active_sidebar( 'content-bottom' ) ) : ?>
	<div id="pe-content-bottom" <?php if ( $highContrast ) {
		echo 'role="region" tabindex="-1"';
		if ( PEsettings::get( 'content-bottom-label' ) ) {
			echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'content-bottom-label' ) ) . '"';
		}
	} ?>>
		<div class="row">
			<?php dynamic_sidebar( 'content-bottom' ); ?>
		</div>
	</div>
<?php endif; ?>
