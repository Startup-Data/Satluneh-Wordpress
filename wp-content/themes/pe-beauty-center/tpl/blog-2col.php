<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>

<?php

	$GLOBALS[ 'counter' ]++;

	global $wp_query; 

	if($GLOBALS[ 'counter' ] % 2 == 1) { // Row Start on Even Article Numbers

		echo "<div class='blog-row row clearfix'>";

	}

	// Col Start
	echo "<div class='blog-col col-sm-6'>";
	
		get_template_part("tpl/posts-for-listing");
	
	echo "</div>";
	// Col End

	// Row End on Odd Article Numbers or End of Articles
	if($GLOBALS[ 'counter' ] % 2 == 0 || $GLOBALS[ 'counter' ] == $wp_query->post_count && $wp_query->post_count % 2 ) {
	
		echo "</div>";
	
	}

?>