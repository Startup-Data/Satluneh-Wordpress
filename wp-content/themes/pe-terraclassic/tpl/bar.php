<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// BAR (logo and menu navigation)
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

$mainmenu_header = ( (PEsettings::get( 'vertical-main-menu' ) == true && is_front_page()) || (PEsettings::get( 'vertical-main-menu-homepage' ) == true && is_home() ) ) ? true : false;
$offcanvas_sidebar = PEsettings::get( 'off-canavs-sidebar' );
$top_menu          = ( PEsettings::get( 'main-menu-switch' ) == 'standard' or PEsettings::get( 'main-menu-switch' ) == 'both' ) ? true : false;
$offcanvas_menu = ( PEsettings::get( 'main-menu-switch' ) == 'offcanvas' or PEsettings::get( 'main-menu-switch' ) == 'both' ) ? true : false;

$search_bar = PEsettings::get('search-bar');

$retina_display = PEsettings::get( 'retina-display-support' );
$retina_logo    = PEsettings::get( 'retina-logo,url' );
$retina_attr    = ( $retina_display && $retina_logo ) ? ' data-at2x="' . esc_url( $retina_logo ) . '"' : '';

//wcag
$nightVersion     = PEsettings::get( 'nightVersion' );
$highContrast     = PEsettings::get( 'highContrast' );
$wideSite         = PEsettings::get( 'wideSite' );
$fontSizeSwitcher = PEsettings::get( 'fontSizeSwitcher' );

if ( ( $nightVersion == false ) and ( $highContrast == false ) and ( $wideSite == false ) and ( $fontSizeSwitcher == false ) ) {
	$wcag_off = true;
} else {
	$wcag_off = false;
}

//container
$bar_width         = ( PEsettings::get( 'full-screen,bar' ) == 1 ) ? 'full' : '';
$header_width      = ( PEsettings::get( 'full-screen,header' ) == 1 ) ? 'full' : '';
$header_full_class = ( PEsettings::get( 'full-screen,header' ) == 1 ) ? 'header-full' : 'header-standard';

// hidden class
$logo_nav_hide_mobile = ( PEsettings::get( 'logo-nav-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$logo_nav_hide_tablet = ( PEsettings::get( 'logo-nav-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$logo_nav_hide_desktop = ( PEsettings::get( 'logo-nav-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$logo_nav_hide_large = ( PEsettings::get( 'logo-nav-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$logo_nav_hide = $logo_nav_hide_mobile . $logo_nav_hide_tablet . $logo_nav_hide_desktop . $logo_nav_hide_large;

$header_hide_mobile = ( PEsettings::get( 'header-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$header_hide_tablet = ( PEsettings::get( 'header-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$header_hide_desktop = ( PEsettings::get( 'header-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$header_hide_large = ( PEsettings::get( 'header-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$header_hide = $header_hide_mobile . $header_hide_tablet . $header_hide_desktop . $header_hide_large;

//display title for screen readers
if ( $highContrast ) {
	$wptitle       = wp_title( '-', false );
	$page_title    = ( ! empty( $wptitle ) ) ? $wptitle : get_bloginfo( 'name' );
	$front_content = ( PEsettings::get( 'front-page-content' ) || PEsettings::get( 'front-page-title' ) ) ? true : false;
	echo '<div id="pe-main-header">';
	if ( is_home() || ( is_front_page() && ! $front_content ) ) {
		echo '<h1 id="pe-main-header-title" class="sr-only">' . esc_attr( $page_title ) . '</h1>';
	} else {
		echo '<p id="pe-main-header-title" class="sr-only">' . esc_attr( $page_title ) . '</p>';
	}
	echo '</div>';
} ?>

<nav id="pe-skip-menu" <?php if ( $highContrast ) {
	echo 'role="navigation"';
	if ( PEsettings::get( 'skip-menu-label' ) ) {
		echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'skip-menu-label' ) ) . '"';
	}
} ?>>
	<?php if ( has_nav_menu( 'skip-menu' ) ) {
		wp_nav_menu( array(
			'theme_location'  => 'skip-menu',
			'container_class' => 'pe-skip-menu',
		) );
	} ?>
</nav>

<?php
if ( has_nav_menu( 'main-menu' ) or $logo_img or $logo_text or $logo_desc or is_active_sidebar( 'header' ) ) : ?>

	<header id="pe-header" class="<?php echo $header_full_class; ?>" <?php if ( $highContrast ) {
		echo 'role="banner"';
	} ?>>
		<div id="pe-header-in">
			<?php if ( has_nav_menu( 'main-menu' ) or $logo_img or $logo_text or $logo_desc or $nightVersion or $highContrast or $wideSite or $fontSizeSwitcher or ( $offcanvas_sidebar and is_active_sidebar( 'off-canvas-sidebar' ) ) or $search_bar ) : ?>
				<div id="pe-logo-nav" class="<?php echo $logo_nav_hide; ?>">
					<?php get_template_part( 'tpl/wcag' ); ?>
					<div id="pe-logo-nav-in" class="pe-container <?php echo $bar_width; ?>">

						<?php if ( $logo_img or $logo_text or $logo_desc or $nightVersion or $highContrast or $wideSite or $fontSizeSwitcher ) : ?>
							<div id="pe-bar-left">
								<?php if ( $logo_img ) : ?>
									<div id="pe-logo">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pe-logo-img" title="<?php echo $logo_alt; ?>" rel="home">
											<span class="logo"><img src="<?php echo esc_url( $logo_img ); ?>" alt="<?php echo $logo_alt; ?>" <?php echo $retina_attr; ?>></span>
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
							</div>
						<?php endif; ?>
									
						<?php if ( has_nav_menu( 'main-menu' ) or ( $offcanvas_sidebar and is_active_sidebar( 'off-canvas-sidebar' ) ) || is_active_sidebar( 'top-bar' ) || $search_bar) : ?>
							<div id="pe-bar-right">

								<?php if ( is_active_sidebar( 'top-bar' ) ) : ?>
									<div class="pe-top-bar">
										<?php dynamic_sidebar( 'top-bar' ); ?>
									</div>
								<?php endif; ?>
						
								<nav id="pe-main-menu" <?php if ( $highContrast ) {
									echo 'tabindex="-1"';
									if ( PEsettings::get( 'menu-label' ) ) {
										echo ' aria-label="' . PEsettings::valid( 'sanitize_text_field', 'menu-label' ) . '"';
									}
								} ?>>
									<?php if ( $top_menu and has_nav_menu( 'main-menu' ) ) : ?><?php wp_nav_menu( array(
										'theme_location'  => 'main-menu',
										'container_class' => 'pe-main-menu',
										'menu_class'      => 'nav-menu',
										'walker'          => new PE_Main_Menu(),
									) ); ?><?php endif; ?>
								</nav>
								
								<?php if ( is_active_sidebar( 'top-bar2' ) ) : ?>
									<div class="pe-top-bar2">
										<?php dynamic_sidebar( 'top-bar2' ); ?>
									</div>
								<?php endif; ?>
								
								<?php if( $search_bar && !(is_search() && (is_post_type_archive('classified') || get_post_type() == 'classified')) ) : ?>
								<div id="pe-search" class="clearfix hidden-sm hidden-xs">
									<?php get_search_form(); ?>
								</div>
								<?php endif; ?>

								<?php if (  has_nav_menu( 'main-menu' )  or ( $offcanvas_sidebar and is_active_sidebar( 'off-canvas-sidebar' ) ) ) : ?>
									<div id="pe-offcanvas-button">
										<a href="#" class="toggle-nav open"><span class="fa fa-navicon" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Offcanvas Sidebar', 'pe-terraclassic' ); ?></span></a>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'header' ) || $mainmenu_header ) : ?>
				<div id="pe-header-sidebar" class="pe-container <?php echo $header_width . $header_hide; ?>" <?php if ( $highContrast ) {
					echo 'role="region" tabindex="-1"';
					if ( PEsettings::get( 'header-mod-label' ) ) {
						echo ' aria-label="' . sanitize_text_field( PEsettings::get( 'header-mod-label' ) ) . '"';
					}
					} ?>>
					<?php if($mainmenu_header){ ?>
						<nav id="pe-main-menu-header" <?php if ( $highContrast ) {
							echo 'tabindex="-1"';
							if ( PEsettings::get( 'menu-label' ) ) {
								echo ' aria-label="' . PEsettings::valid( 'sanitize_text_field', 'menu-label' ) . '"';
							}
						} ?>>
							<?php if ( $top_menu and has_nav_menu( 'main-menu' ) ) : ?><?php wp_nav_menu( array(
								'theme_location'  => 'main-menu',
								'container_class' => 'pe-main-menu',
								'menu_class'      => 'nav-menu',
								'walker'          => new PE_Main_Menu(),
							) ); ?><?php endif; ?>
						</nav>
					<?php } ?>
					<?php if(is_active_sidebar( 'header' )){ ?>
						<div class="row">
							<?php dynamic_sidebar( 'header' ); ?>
						</div>
					<?php } ?>
				</div>
			<?php endif; ?>

		</div>
	</header>

<?php endif; ?>
