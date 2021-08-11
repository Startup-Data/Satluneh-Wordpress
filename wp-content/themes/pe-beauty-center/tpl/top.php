<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php if(is_active_sidebar('top')) : ?>
<div id="pe-top">
	<div id="pe-top-in" class="container-fluid">
		<div class="row">
			<?php if ( ! dynamic_sidebar( __('Top','PixelEmu') )) : endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>