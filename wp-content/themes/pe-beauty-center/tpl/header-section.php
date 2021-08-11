<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php if(is_active_sidebar('header')) : ?>
	<header id="pe-header">
		<?php if ( ! dynamic_sidebar( __('Header','PixelEmu') )) : endif; ?>
	</header>
<?php endif; ?>