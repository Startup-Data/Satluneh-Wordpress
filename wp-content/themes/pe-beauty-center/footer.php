<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

//get information about 'back to top' button
$backtotop = ot_get_option('back_to_top', '1');
//get information about copyright
$copyrights = ot_get_option('copyright_info_on_off', 'on');
$copyrights_info = ot_get_option('copyright_info', '');
$pixelemu_copyright = ot_get_option('pixelemu_copyright', 'on'); 

//add bootstrap class based on active section
$col_md = 'col-md-12';
if ( ($copyrights == 'on') AND ($pixelemu_copyright == 'on') AND ($backtotop != 'on') ) {
	$col_md = 'col-md-6';
} elseif ( ($copyrights == 'on') AND ($pixelemu_copyright != 'on') AND ($backtotop == 'on') ) {
	$col_md = 'col-md-6';
} elseif ( ($copyrights != 'on') AND ($pixelemu_copyright == 'on') AND ($backtotop == 'on') ) {
	$col_md = 'col-md-6';
} elseif ( ($copyrights == 'on') AND ($pixelemu_copyright == 'on') AND ($backtotop == 'on') ) {
	$col_md = 'col-md-4';
}

?>

		<?php get_template_part( 'tpl/bottom' ); ?>
		
		<footer id="pe-footer">

			<?php if(is_active_sidebar('footer-mod')) : ?>
			<div id="pe-footer-mod" class="container-fluid">
				<div class="row">
					<?php if ( ! dynamic_sidebar( __('Footer','PixelEmu') )) : endif; ?>
				</div>
			</div>
			<?php endif; ?>
			
			<!-- Copyright/ powered by / back to top -->
			<?php if ( ($copyrights == 'on') or ($backtotop == 'on') or ($pixelemu_copyright == 'on') ) :?>
			<div id="pe-copyright" class="container-fluid">
				<div class="row">
					<?php if($copyrights == 'on') : ?>
					<div class="pull-left <?php echo $col_md ?>">
						<p>
							<?php echo $copyrights_info; ?>
						</p>
					</div>
					<?php endif; ?>

					<?php if($backtotop == 'on') : ?>
					<div class="pull-left <?php echo $col_md ?>">
						<div id="pe-back-top" class="text-center">
							<a id="backtotop" href="javascript:void(0);">Back to top</a>
						</div>
					</div>
					<?php endif; ?>

					<?php if($pixelemu_copyright == 'on') : ?>
					<div class="pull-right <?php echo $col_md ?>">
						<p>
							<a href="//www.pixelemu.com/" target="_blank"><?php _e('WordPress Theme','PixelEmu'); ?></a> <?php _e('by Pixelemu.com','PixelEmu'); ?>
						</p>
					</div>
					<?php endif; ?>

				</div>
			</div>
			<?php endif; ?>
			<!-- End of Copyright/ powered by / back to top -->	
		
		</footer>

		<?php wp_footer(); ?>
	
	</div><!-- .pe-main -->
	<?php get_template_part( 'tpl/javascript_before_end_body' ); ?>
	<?php if(is_singular()) {
		get_template_part( 'tpl/addthis' );
	} ?>
</body>

</html>