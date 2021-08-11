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
<!DOCTYPE html>

<html <?php language_attributes(); // language attributes ?>>
    
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
        <![endif]-->
        <?php

        $favicon = ot_get_option( 'favicon' );

        if($favicon) { ?>

            <link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />
            <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />      
        
        <?php } ?>
        
        <?php get_template_part( 'tpl/analyticstracking' ); ?>
        
        <?php

            $sticky_topbar = ot_get_option( 'sticky_topbar', 'on' );

            if($sticky_topbar == 'on'){

                $sticky_topbar_val = 'sticky-bar';

            } else{

                $sticky_topbar_val = '';

            }
        ?>
        <?php wp_head(); ?>
    </head>
    
    <body <?php body_class( 'off-canvas-right '.$sticky_topbar_val ); ?>>
        
        <div id="pe-main">
            
            <?php
            
                //offcanvas
                get_template_part( 'tpl/offcanvas' );
            
                //top bar menu, logo and main menu
                get_template_part( 'tpl/top-bar' );
				        
            ?>

            <section id="pe-content">
                
                <div id="pe-content-in" class="container-fluid">
                    
                    <div class="row">
                        
                        <div id="pe-content-wrapp" class="col-md-12">

                            <!-- Begin of main content area -->
                            <div id="pe-maincontent">

                                <div <?php post_class('pe-article'); ?> itemscope="" itemtype="http://schema.org/Article">


                                    <div class="pe-article-content" itemprop="articleBody">

                                        <div class="pe-error-page">
                                            <h1><?php _e('404 OOPS!', 'PixelEmu'); ?></h1>
                                            <h2><?php _e('page Not found!', 'PixelEmu'); ?></h2>
                                            <p><?php _e('"Sorry, it appears the page you were looking for doesnt exist anymore or might have been moved. <br /> Please try your luck again."', 'PixelEmu'); ?>
                                            </p>
                                            <!-- PE Module -->
                                            <div class="pe-module">
                                                <div class="search">
                                                    <form role="search" method="get" class="form-inline" action="<?php echo home_url( '/' ); ?>">
                                                        <input type="search" id="pe-search-searchword" maxlength="200" size="20" class="form-control" placeholder="<?php _e('Search ...:', 'PixelEmu'); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php _e('Search for:', 'PixelEmu'); ?>" />
                                                        <input type="submit" class="btn" value="<?php _e('Search', 'PixelEmu'); ?>" />
                                                    </form>

                                                </div>
                                            </div>
                                            <a class="btn4" href="<?php echo get_site_url(); ?>"><?php _e( 'Go back home', 'PixelEmu' ); ?></a>
                                            
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- End of main content area -->

                        </div>

                    </div>

                </div>

            </section>

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
                        <div class="<?php echo $col_md ?>">
                            <p class="pull-left">
                                <?php echo $copyrights_info; ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php if($backtotop == 'on') : ?>
                        <div class="<?php echo $col_md ?>">
                            <div id="pe-back-top" class="text-center">
                                <a id="backtotop" href="javascript:void(0);">Back to top</a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($pixelemu_copyright == 'on') : ?>
                        <div class="<?php echo $col_md ?>">
                            <p class="pull-right">
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
    
    </body>

</html>