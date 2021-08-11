<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// BLOG (multiple columns, styles)
// ---------------------------------------------------------------

// get individual category layout
if ( is_category() ) {
	$category            = get_category( $cat ); //current category
	$category_column_opt = get_term_meta( $category->term_id, 'category_layout' ); //tax-meta-class setting
	$category_style_opt  = get_term_meta( $category->term_id, 'category_style' ); //tax-meta-class setting
}
$category_columns = ( ! empty( $category_column_opt[0] ) ) ? $category_column_opt[0] : false;
$category_style   = ( ! empty( $category_style_opt[0] ) ) ? $category_style_opt[0] : false;

if ( is_category() && ( $category_columns || $category_style ) ) {
	$blog_columns = ( $category_columns ) ? $category_columns : PEsettings::get( 'archive-columns' );
	$blog_style   = ( $category_style ) ? $category_style : PEsettings::get( 'archive-style' );
} elseif ( is_archive() ) {
	$blog_columns = PEsettings::get( 'archive-columns' );
	$blog_style   = PEsettings::get( 'archive-style' );
} else {
	$blog_columns = PEsettings::get( 'blog-columns' );
	$blog_style   = ( PEsettings::get( 'blog-style' ) ) ? PEsettings::get( 'blog-style' ) : 'standard';
}

//grid class
if ( $blog_columns == 2 ) {
	$gridclass = 'col-sm-6';
} elseif ( $blog_columns == 3 ) {
	$gridclass = 'col-sm-4';
} elseif ( $blog_columns == 4 ) {
	$gridclass = 'col-sm-3';
} else {
	$gridclass = 'col-sm-12';
}

//showtime
$counter     = 0;
$count_posts = $wp_query->post_count;

$blog_column_size = ( $count_posts == 1 ) ? 'col-sm-12' : $gridclass;

//rows
$row_start = '<div class="pe-blog-row style-' . sanitize_html_class( $blog_style ) . ' cols-' . $blog_columns . '"><div class="pe-row">';
$row_and   = '</div></div>';

while ( have_posts() ) : the_post();

	if ( $counter % $blog_columns == 0 ) { // if counter is multiple of $blog_columns
		echo $row_start;
	}

	// Col Start
	echo '<div class="blog-col ' . $blog_column_size . '">';

	get_template_part( 'tpl/post', $blog_style );

	echo '</div>';
	// Col End

	$counter ++;

	if ( $counter % $blog_columns == 0 ) { // if counter is multiple of $blog_columns
		echo $row_and;
	}

endwhile;

if ( $counter % $blog_columns != 0 ) { // put closing div if loop is not exactly a multiple of $blog_columns
	echo $row_and;
}

pe_pagination( $wp_query->max_num_pages );

?>
