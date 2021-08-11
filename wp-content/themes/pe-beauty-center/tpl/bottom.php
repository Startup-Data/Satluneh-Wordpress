<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php if(is_active_sidebar('bottom')) : ?>
<div id="pe-bottom">
	<div id="pe-bottom-in" class="container-fluid">
		<div class="row">
			<?php if ( ! dynamic_sidebar( __('Bottom','PixelEmu') )) : endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>