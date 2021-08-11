<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php
	if (ot_get_option( 'addthis_code' ) && !is_front_page() ){ ?>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo ot_get_option( 'addthis_code' ); ?>" async="async"></script>
	<?php }
?>