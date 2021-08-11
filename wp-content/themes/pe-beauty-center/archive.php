<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_header();

    /* Page Head */

    $header_title = __('Archives', 'PixelEmu');
    $header_details = "";

    $post = $posts[0]; // Hack. Set $post so that the_date() works.
    if (is_category())
    {
        $header_title = __('All Posts in Category', 'PixelEmu');
        $header_details = single_cat_title('',false);
    }
    elseif( is_tag() )
    {
        $header_title = __('All Posts in Tag', 'PixelEmu');
        $header_details = single_tag_title('',false);
    }
    elseif (is_day())
    {
        $header_title = __('Archives', 'PixelEmu');
        $header_details = get_the_date();
    }
    elseif (is_month())
    {
        $header_title = __('Archives', 'PixelEmu');
        $header_details = get_the_date('F Y');
    }
    elseif (is_year())
    {
        $header_title = __('Archives', 'PixelEmu');
        $header_details = get_the_date('Y');
    }
    elseif (is_author())
    {
        $curauth = $wp_query->get_queried_object();
        $header_title = __('All Posts By', 'PixelEmu');
        $header_details = $curauth->display_name;
    }
    elseif (isset($_GET['paged']) && !empty($_GET['paged']))
    {
        $header_title = __('Archives', 'PixelEmu');
        $header_details = "";
    }
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
                        <div itemscope="" itemtype="http://schema.org/Blog">

                        <?php if (ot_get_option('header_title_archive') == 'on') { ?>
                        <h2 class="subheading-category">
                            <?php echo $header_title; ?> <?php echo $header_details; ?>
                        </h2>
                        <?php } ?>
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