<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$offcanvas_sidebar = ot_get_option( 'offcanvas-sidebar', 'off' ); ?>

<?php if($offcanvas_sidebar == 'on') : ?>
	<?php if(is_active_sidebar('off-canvas-sidebar')) : ?>
		<div id="pe-offcanvas" class="hidden-xs">
			<div id="pe-offcanvas-toolbar">
				<a class="toggle-nav close-menu"><span class="glyphicon glyphicon-remove"></span></a>
			</div>
			<div id="pe-offcanvas-content" class="pe-offcanvas">
				<?php if ( ! dynamic_sidebar( __('Off-canvas Sidebar','PixelEmu') )) : endif; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>