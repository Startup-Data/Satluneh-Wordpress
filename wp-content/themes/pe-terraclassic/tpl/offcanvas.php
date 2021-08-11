<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

$offcanvas_sidebar = PEsettings::get( 'off-canavs-sidebar' );
$offcanvas_side    = ( PEsettings::get( 'off-canavs-position' ) ) ? 'off-canvas-' . sanitize_html_class( PEsettings::get( 'off-canavs-position' ) ) : '';

if ( ( $offcanvas_sidebar and is_active_sidebar( 'off-canvas-sidebar' ) ) or has_nav_menu( 'main-menu' ) ) : ?>

	<div id="pe-offcanvas" class="<?php echo $offcanvas_side; ?>">
		<div id="pe-offcanvas-toolbar">
			<a class="toggle-nav close" href="#"><span class="x-icon" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Close Offcanvas Sidebar', 'pe-terraclassic' ); ?></span></a>
		</div>

		<div id="pe-offcanvas-content" class="pe-offcanvas">
			<div class="row">
				<?php
				if ( has_nav_menu( 'main-menu' ) ) {
					wp_nav_menu( array(
						'theme_location'  => 'main-menu',
						'container_class' => 'pe-offcanvas-menu pe-widget',
						'menu_class'      => 'nav-menu',
						'walker'          => new PE_Main_Menu(),
					) );
				}

				dynamic_sidebar( 'off-canvas-sidebar' );

				?>
			</div>
		</div>
	</div>


<?php endif; ?>
