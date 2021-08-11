<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// CONTENT PAGE (single page)
// ---------------------------------------------------------------

$comments_page = PEsettings::get( 'page-comments' );
$post_page_heading = PEsettings::get( 'post-page-heading' );
$front_page_title = PEsettings::get( 'front-page-title' );
?>

<article <?php post_class(); ?>>

	<?php if ( !(is_front_page() && !$front_page_title) ) { ?>
	<header class="page-header">
		<?php if($post_page_heading == 7){ ?>
			<p class="page-header-main-title"><?php the_title(); ?></p>
		<?php } else { ?>
			<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
		<?php } ?>
	</header>
	<?php } ?>

	<?php if ( has_post_thumbnail() ) {

		pe_show_thumbnail();

	} ?>
	
	<?php if ( !empty( get_the_content() ) ) { ?>
	<div class="pe-article-content">

		<?php the_content(); ?>

	</div>
	<?php } ?>

	<?php
	// show comments
	if ( $comments_page ) {
		comments_template( '', true );
	}
	?>

</article>
