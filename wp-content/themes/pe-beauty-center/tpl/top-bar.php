<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$logo = ot_get_option( 'logo' );
$logotext = ot_get_option( 'logo-text' );
$sitedescription = ot_get_option( 'site-decription' );
$offcanvas_sidebar = ot_get_option( 'offcanvas-sidebar', 'off' );

if (has_nav_menu( 'main-menu' ) or is_active_sidebar('top-bar-menu') or ($logo != '') or ($logotext != '') or ($sitedescription != '')) : ?>
<div id="pe-bar-wrapp">
	
	<?php if(is_active_sidebar('top-bar-menu')) : ?>
	<div id="pe-top-bar">
		<div id="pe-top-bar-in" class="container-fluid">
			<div class="pe-module-raw">
				<?php if ( ! dynamic_sidebar( __('Top Bar','PixelEmu') )) : endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if (has_nav_menu( 'main-menu' ) or ($logo != '') or ($logotext != '') or ($sitedescription != '')) : ?>
	<div id="pe-menu-bar">
		<div id="pe-menu-bar-in">
			<nav id="pe-main-menu" class="navbar">
				<div class="container-fluid">
					
					<?php if (($logo != '') or ($logotext != '') or ($sitedescription != '')) : ?>
						<div id="pe-bar-left" class="pull-left clearfix">
							<div class="navbar-brand">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pe-logo" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( ot_get_option( 'logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
							</div>
						</div>
					<?php endif; ?>
					
					<?php if(($offcanvas_sidebar == 'on') or has_nav_menu( 'main-menu' )) : ?>
					<div id="pe-bar-right" class="pull-right clearfix">
						<?php if($offcanvas_sidebar == 'on') : ?>
							<?php if(is_active_sidebar('off-canvas-sidebar')) : ?>
								<div class="pe-module-raw visible-lg">
									<a class="toggle-nav menu"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					
					<?php 
						if ( has_nav_menu( 'main-menu' ) ) {
								echo '<div class="pe-module-raw">';
								if ( is_plugin_active( 'megamenu/megamenu.php' ) ) {
									wp_nav_menu( array( 'theme_location' => 'main-menu' ) );
								} else { ?>
						      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-pe-navbar-collapse-1">
						        <span class="sr-only"><?php _e('Toggle navigation', 'PixelEmu') ?></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						      </button>
									
					        <?php
					            wp_nav_menu( array(
					                'menu'              => 'main-menu',
					                'theme_location'    => 'main-menu',
					                'depth'             => 2,
					                'container'         => 'div',
					                'container_class'   => 'collapse navbar-collapse',
					        				'container_id'      => 'bs-pe-navbar-collapse-1',
					                'menu_class'        => 'nav navbar-nav',
					                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					                'walker'            => new wp_bootstrap_navwalker())
					            );
					        ?>
								<?php }
								echo '</div>';
						}
					?>
					</div>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</div>
	<?php endif; ?>
	
</div>
<?php endif; ?>