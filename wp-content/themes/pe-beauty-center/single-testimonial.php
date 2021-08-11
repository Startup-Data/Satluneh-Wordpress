<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_header(); 

$testimonial_occupation = get_post_meta($post->ID, 'testimonial_occupation',true);
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
                if ( ot_get_option('font_sizer_testimonial') == 'on' ) {
                    get_template_part( 'tpl/fontswitcher' ); 
                }
                ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">

                        <div class="page-header">
                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>
                           
                            <div class="post-meta standard-meta thumb-<?php echo has_post_thumbnail()?'exist':'not-exist'; ?>">
                                
                                <span><?php echo $testimonial_occupation; ?></span>
                            
                            </div>

                        </div>

                        <?php
                          if ( has_post_thumbnail() ){
                          $image_id = get_post_thumbnail_id();
                          $image_url = wp_get_attachment_url($image_id);
                        ?>

                        <figure>

                            <div class="pull-left pe-item-image">

                                <?php the_post_thumbnail('member-small-image'); ?>

                            </div>

                        </figure>

                        <?php } ?>

                        <div class="pe-article-content" itemprop="articleBody">

                            <?php the_content(); ?>

                        </div>

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