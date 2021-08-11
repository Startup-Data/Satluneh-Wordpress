<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
Website: http://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// COMING SOON (counter)
// ---------------------------------------------------------------

$logo_img  = esc_url( PEsettings::get( 'logo,url' ) );
$logo_text = esc_attr( get_bloginfo( 'name' ) );
$logo_desc = ( ! empty( get_bloginfo( 'description' ) ) ) ? esc_attr( get_bloginfo( 'description' ) ) : false;


if ( $logo_text ) {
	$logo_alt = $logo_text;
} elseif ( $logo_desc ) {
	$logo_alt = $logo_desc;
} else {
	$logo_alt = '';
}

?>
<!DOCTYPE html>

<html <?php language_attributes(); // language attributes ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
	<?php
	$favicon = esc_url( PEsettings::get( 'favicon,url' ) );
	if ( ! has_site_icon() && $favicon ) { ?>
		<link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon"/>
		<link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon"/>
	<?php } ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Begin of main page -->
<div id="pe-main">
	<div id="pe-coming-soon">

		<?php if ( $logo_img ) : ?>
			<div id="pe-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pe-logo-img" title="<?php echo $logo_alt; ?>" rel="home">
					<span class="logo"><img src="<?php echo esc_url( $logo_img ); ?>" alt="<?php echo $logo_alt; ?>"></span>
				</a>
			</div>
		<?php elseif ( $logo_text ) : ?>
			<div id="pe-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pe-logo-text" title="<?php echo $logo_alt; ?>" rel="home"><?php echo $logo_text; ?></a>
				<?php if ( $logo_desc ) : ?>
					<p class="pe-logo-desc"><?php echo $logo_desc; ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="container-fluid">
			<?php if ( is_active_sidebar( 'coming-soon-sidebar' ) ) : ?>
				<div id="pe-widget">
					<?php dynamic_sidebar( 'coming-soon-sidebar' ); ?>
				</div>
			<?php endif; ?>

			<!-- Begin of Count Down -->
			<div id="countdown">
				<p class="d">
					<span class="days">00</span>
					<span class="timeRefDays"><?php esc_html_e( 'days', 'pe-terraclassic' ); ?></span>
				</p>

				<p>
					<span class="hours">00</span>
					<span class="timeRefHours"><?php esc_html_e( 'hours', 'pe-terraclassic' ); ?></span>
				</p>

				<p>
					<span class="minutes">00</span>
					<span class="timeRefMinutes"><?php esc_html_e( 'minutes', 'pe-terraclassic' ); ?></span>
				</p>

				<p>
					<span class="seconds">00</span>
					<span class="timeRefSeconds"><?php esc_html_e( 'seconds', 'pe-terraclassic' ); ?></span>
				</p>
			</div>
			<!-- End of Count Down -->

			<a class="button" href="<?php echo wp_login_url(); ?>" title="<?php _e( 'Login', 'pe-terraclassic' ); ?>"><?php _e( 'Login', 'pe-terraclassic' ); ?></a>

		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>

</html>
