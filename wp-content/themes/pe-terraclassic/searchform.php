<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

$inputID = uniqid( 'input-' );

?>
<form method="get" role="search" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="pe-search-box">
		<div class="pe-search-input">
			<label class="sr-only" for="<?php echo $inputID; ?>"><?php esc_html_e( 'Search for:', 'pe-terraclassic' ); ?></label>
			<input type="search" value="<?php echo get_search_query(); ?>" id="<?php echo $inputID; ?>" name="s" class="s" placeholder="<?php esc_html_e( 'Search ...', 'pe-terraclassic' ); ?>"/>
		</div>
		<button class="button" type="submit" value="<?php esc_html_e( 'Search', 'pe-terraclassic' ); ?>">
			<span class="fa fa-search"></span><span class="sr-only"><?php esc_html_e( 'Search', 'pe-terraclassic' ); ?></span>
		</button>
	</div>
</form>
