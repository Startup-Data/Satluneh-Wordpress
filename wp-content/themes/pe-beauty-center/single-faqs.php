<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_header(); 
?>

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
                if ( ot_get_option('font_sizer_single') == 'on' ) {
                    get_template_part( 'tpl/fontswitcher' ); 
                }
                ?>

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">

                        <div class="page-header">
                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>
                           <?php if (ot_get_option('post_info_single') == 'on') : ?>
                            <div class="post-meta">
                                <span><?php _e('Posted on', 'PixelEmu'); ?> <span class="date"> <?php the_time('F d, Y'); ?></span></span>
                                <?php edit_post_link(__("Edit Post", "PixelEmu"), '<span> / </span>', ''); ?>
                            </div>
                            <?php endif; ?>

                        </div>

                        <div class="pe-article-content" itemprop="articleBody">

                            <?php the_content(); ?>

                        </div>                        
                        
                        <?php 
                        if ( ot_get_option('comments_single') == 'on' ) {
                            comments_template('',true); 
                        }
                        ?>
                    </div>

                <?php 
                    endwhile; 
                    endif; 
                ?>

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

<?php get_footer(); ?>