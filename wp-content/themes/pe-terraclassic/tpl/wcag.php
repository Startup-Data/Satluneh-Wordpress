<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

$nightVersion     = PEsettings::get( 'nightVersion' );
$highContrast     = PEsettings::get( 'highContrast' );
$wideSite         = PEsettings::get( 'wideSite' );
$fontSizeSwitcher = PEsettings::get( 'fontSizeSwitcher' );
//container
$bar_width         = ( PEsettings::get( 'full-screen,bar' ) == 1 ) ? 'full' : '';

if ( $nightVersion or $highContrast or $wideSite or $fontSizeSwitcher ) : ?>
	<div id="pe-wcag" class="pe-container <?php echo $bar_width; ?>">
		<ul class="pe-wcag-settings clearfix">
			<?php if ( $nightVersion or $highContrast ) : ?>
				<li class="contrast">
					<ul>
						<li class="separator"><?php _e( 'Contrast', 'pe-terraclassic' ); ?></li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?contrast=normal', 'pe-terraclassic' ) ); ?>" class="pe-normal" title="<?php _e( 'Set default contrast mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-sun-o" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Default contrast', 'pe-terraclassic' ); ?></span></a>
						</li>
						<?php if ( $nightVersion ) : ?>
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?contrast=night', 'pe-terraclassic' ) ); ?>" class="pe-night" title="<?php _e( 'Set night contrast mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-moon-o" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Night contrast', 'pe-terraclassic' ); ?></span></a>
							</li>
						<?php endif; ?>
						<?php if ( $highContrast ) : ?>
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?contrast=highcontrast', 'pe-terraclassic' ) ); ?>" class="pe-highcontrast" title="<?php _e( 'Set black and white contrast mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-eye" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Black and White contrast', 'pe-terraclassic' ); ?></span></a>
							</li>
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?contrast=highcontrast2', 'pe-terraclassic' ) ); ?>" class="pe-highcontrast2" title="<?php _e( 'Set black and yellow contrast mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-eye" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Black and Yellow contrast', 'pe-terraclassic' ); ?></span></a>
							</li>
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?contrast=highcontrast3', 'pe-terraclassic' ) ); ?>" class="pe-highcontrast3" title="<?php _e( 'Set yellow and black contrast mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-eye" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Yellow and Black contrast', 'pe-terraclassic' ); ?></span></a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php if ( $wideSite ) : ?>
				<li class="page-width">
					<ul>
						<li class="separator"><?php _e( 'Layout', 'pe-terraclassic' ); ?></li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?width=fixed', 'pe-terraclassic' ) ); ?>" class="pe-fixed" title="<?php _e( 'Set fixed layout mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-compress" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Fixed layout', 'pe-terraclassic' ); ?></span></a>
						</li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?width=wide', 'pe-terraclassic' ) ); ?>" class="pe-wide" title="<?php _e( 'Set wide layout mode', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-expand" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Wide layout', 'pe-terraclassic' ); ?></span></a>
						</li>
					</ul>
				</li>
			<?php endif; ?>
			<?php if ( $fontSizeSwitcher ) : ?>
				<li class="resizer">
					<ul>
						<li class="separator"><?php _e( 'Font', 'pe-terraclassic' ); ?></li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?fontsize=70', 'pe-terraclassic' ) ); ?>" class="pe-font-smaller" title="<?php _e( 'Set smaller font size', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-minus-circle" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Smaller Font', 'pe-terraclassic' ); ?></span></a>
						</li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?fontsize=100', 'pe-terraclassic' ) ); ?>" class="pe-font-normal" title="<?php _e( 'Set default font size', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-font" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Default Font', 'pe-terraclassic' ); ?></span></a>
						</li>
						<li>
							<a href="<?php echo esc_url( home_url( '/' ) . __( 'index.php?fontsize=130', 'pe-terraclassic' ) ); ?>" class="pe-font-larger" title="<?php _e( 'Set larger font size', 'pe-terraclassic' ); ?>" rel="nofollow"><span class="fa fa-plus-circle" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Larger Font', 'pe-terraclassic' ); ?></span></a>
						</li>
					</ul>
				</li>
			<?php endif; ?>
		</ul>
	</div>
<?php endif; ?>
