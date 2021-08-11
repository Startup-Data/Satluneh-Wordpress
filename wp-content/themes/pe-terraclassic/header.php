<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
Website: http://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$favicon = PEsettings::get( 'favicon,url' );

$front_page_check = ( ! PEsettings::get( 'front-page-content' ) && is_front_page() && ! is_home() ) ? false : true;

?>
<!DOCTYPE html>

<html <?php language_attributes(); // language attributes ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
	<?php if ( ! has_site_icon() && $favicon ) : ?>
		<link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon"/>
		<link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon"/>
	<?php endif ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="pe-main">

	<?php

	//top bar menu, logo and main menu
	get_template_part( 'tpl/bar' );

	if ( ! $front_page_check ) {
		echo '<span id="pe-content-beginning" class="no-content"></span>';
	}

	//top widgets area
	get_template_part( 'tpl/top' );

	// breadcrumb
	get_template_part( 'tpl/breadcrumbs' );

	if ( $front_page_check ) {
		echo '<span id="pe-content-beginning" class="is-content"></span>';
	}

	?>


