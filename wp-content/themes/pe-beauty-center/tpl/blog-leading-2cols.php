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

	$firstPost = ($GLOBALS[ 'counter' ] == 1);

	if ( $firstPost ) {

		echo "<div class='blog-row row clearfix'>";

			echo "<div class='blog-col col-sm-12'>";

				get_template_part("tpl/posts-for-listing");

			echo "</div>";

		echo "</div>";

	} else {

		if($GLOBALS[ 'counter' ] % 2 == 0) { // Row Start on Even Article Numbers

			echo "<div class='blog-row row clearfix'>";

		}

		// Col Start
		echo "<div class='blog-col col-sm-6'>";

			get_template_part("tpl/posts-for-listing");

		echo "</div>";
		// Col End

		// Row End on Odd Article Numbers or End of Articles
		if($GLOBALS[ 'counter' ] % 2 == 1 || $GLOBALS[ 'counter' ] == $wp_query->post_count ) {

			echo "</div>";
		}
	}

?>