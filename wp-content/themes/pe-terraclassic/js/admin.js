/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

(function ($) {
	$(window).on("load", function () {
		if($('#customize-controls').length > 0){
			$( '<div class="terraclassifieds-message info pe-message-customize"><p>' + pe_admin_vars.theme_options + '</p></div>' ).insertBefore( '#customize-info' );
		}
	});
})(jQuery);
