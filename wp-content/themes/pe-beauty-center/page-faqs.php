<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php
/*
* Template Name: FAQs Page
*/

get_header();
?>

<section id="pe-content">
    
    <div id="pe-content-in" class="container-fluid">
        
        <div class="row">
            
            <div id="pe-content-wrapp" class="col-md-<?php echo $GLOBALS[ 'span' ].' '.$GLOBALS[ 'content_offset' ]; ?>">

                <?php if(is_active_sidebar('content-top')) : ?>
                
                <div id="pe-content-top">
                    <div class="row">
                        <?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>
                    </div>
                </div>
                
                <?php endif; ?>

                <!-- Begin of main content area -->
                <div id="pe-maincontent">
                <?php 
                if ( is_front_page() && ot_get_option('font_sizer_front') == 'on' 
                    || !is_front_page() && is_page() && ot_get_option('font_sizer_page') == 'on')
                get_template_part( 'tpl/fontswitcher' ); 
                ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">
                            
                        <div class="page-header">
                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>

                        </div>
                    
                    <?php get_template_part("tpl/faqs-accordion"); ?>
                    
                    </div>

                </div>
                <!-- End of main content area -->

                <?php if(is_active_sidebar('content-bottom')) : ?>
                
                <div id="pe-content-bottom">
                    <div class="row">
                        <?php if ( ! dynamic_sidebar( __('Content Bottom','PixelEmu') )) : endif; ?>
                    </div>
                </div>
                
                <?php endif; ?>

            </div>
            
            <?php get_sidebar(); ?>

        </div>

    </div>

</section>

<?php get_footer(); ?>