<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

$backtotop          = PEsettings::get( 'back-to-top' );
$copyrights         = PEsettings::get( 'copyright-info' );
$copyrights_info    = PEsettings::get( 'copyright-info-text' );

$copyrights_width = ( PEsettings::get( 'full-screen,copyrights' ) == 1 ) ? 'full' : '';
$highContrast     = PEsettings::get( 'highContrast' );

// hidden class
$copyrights_hide_mobile = ( PEsettings::get( 'copyrights-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$copyrights_hide_tablet = ( PEsettings::get( 'copyrights-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$copyrights_hide_desktop = ( PEsettings::get( 'copyrights-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$copyrights_hide_large = ( PEsettings::get( 'copyrights-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$copyrights_hide = $copyrights_hide_mobile . $copyrights_hide_tablet . $copyrights_hide_desktop . $copyrights_hide_large;

?>

<?php get_template_part( 'tpl/bottom' ); ?>

<!-- Copyright / powered by / back to top -->
<?php if ( ( $copyrights ) or ( $pixelemu_copyright ) ) : ?>
	<footer id="pe-copyrights" class="<?php echo $copyrights_hide; ?>" <?php if ( $highContrast ) {
		echo 'role="contentinfo" tabindex="-1"';
		if ( PEsettings::get( 'footer-label' ) ) {
			echo ' aria-label="' . PEsettings::valid( 'sanitize_text_field', PEsettings::get( 'footer-label' ) ) . '"';
		}
	} ?>>

		<div id="pe-copyrights-in" class="pe-container <?php echo $copyrights_width; ?>">
			<?php if ( $copyrights ) : ?>
				<div id="pe-copyrights-info" class="col-md-12">
					<?php echo esc_attr( $copyrights_info ); ?>
				</div>
			<?php endif; ?>
		</div>

	</footer>
<?php endif; ?>

<?php if ( $backtotop ) : ?>
	<div id="pe-back-top">
		<a id="backtotop" href="#" <?php if ( $highContrast ) {
			echo 'role="button"';
		} ?>><span class="fa fa-angle-up"></span><span class="sr-only"><?php esc_html_e( 'Back to top', 'pe-terraclassic' ); ?></span></a>
	</div>
<?php endif; ?>

</div> <!-- end of pe-main wrapper -->

<?php get_template_part( 'tpl/offcanvas' ); ?>

<?php wp_footer(); ?>

</body> <!-- end of body -->

</html> <!-- end of html -->
