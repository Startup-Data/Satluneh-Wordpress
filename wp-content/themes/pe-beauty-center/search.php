<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_header(); 

?>

<!-- Begin of main content section/content top/content bottom/left column/right column -->
<section id="pe-content">

	<div id="pe-content-in" class="container-fluid">

	        <div class="row">
            
            	<div id="pe-content-wrapp" class="col-md-<?php echo $GLOBALS[ 'span' ].' '.$GLOBALS[ 'content_offset' ]; ?>">

                <?php if(is_active_sidebar('content-top')) : ?>
                
                	<div id="pe-content-top">
                    
                    	<?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>
                
                	</div>
                
                <?php endif; ?>

                	<!-- Begin of main content area -->
                	<div id="pe-maincontent">
                        <?php 
                        if ( ot_get_option('font_sizer_archive') == 'on' )
                                get_template_part( 'tpl/fontswitcher' ); 
                        ?>
                        <h2>
                        
                            <span class="subheading-category"><?php _e('Search Results For', 'PixelEmu'); ?>
                            <strong><?php the_search_query(); ?></strong></span>
                        
                        </h2>
                        
                        <div itemscope="" itemtype="http://schema.org/Blog">

						  <?php  get_template_part("loop");  ?>

                        </div>
		
                	</div>
                	<!-- End of main content area -->

                <?php if(is_active_sidebar('content-bottom')) : ?>
                
                	<div id="pe-content-bottom">
                    
                    	<?php if ( ! dynamic_sidebar( __('Content Bottom','PixelEmu') )) : endif; ?>
                
                	</div>
                
                <?php endif; ?>

            </div>
            
            <?php get_sidebar(); ?>

        </div>

    </div>

</section>
<!-- End of main content section/content top/content bottom/left column/right column -->

<?php get_footer(); ?>