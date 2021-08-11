<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php

// get global category layout

$blog_layout = ot_get_option( 'blog_layout','blog-1col' );
$archive_layout = ot_get_option( 'archive_layout','archive-1col' );

if ( have_posts() ) :

	while ( have_posts() ) :

		the_post();

		// Get appropriate template part for front page
		if( is_home() ) {

			if ($blog_layout == 'blog-1col') {

				get_template_part("tpl/blog-1col");

			} elseif ($blog_layout == 'blog-2cols') {
				
				get_template_part("tpl/blog-2col");

			} elseif ($blog_layout == 'blog-leading-2cols') {

				get_template_part("tpl/blog-leading-2cols");
			}

		} else {

		// Get appropriate template part for archive / search / category / tag etc

			if ($archive_layout == 'archive-1col') {

				get_template_part("tpl/blog-1col");

			} elseif ($archive_layout == 'archive-2cols') {
			
				get_template_part("tpl/blog-2col");

			} elseif ($archive_layout == 'archive-leading-2cols') {

				get_template_part("tpl/blog-leading-2cols");
			}
		}

	endwhile;

	pe_pagination( $wp_query->max_num_pages);

else : ?>

	<p class="nothing-found"><?php _e('No Posts Found!', 'PixelEmu'); ?></p>

<?php endif; ?>