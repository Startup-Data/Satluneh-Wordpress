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

* Template Name: Left Content

*/

get_header(); 

$left_column_width = ot_get_option( 'left_column_width', '3' );
$span = '';
$left_widget_offset = '';
$content_offset = '';
$span_left = 12 - $left_column_width;

if (!is_active_sidebar( 'left-column' )){
  $span = "12";
  $content_offset = 'col-md-push-0';
} else if (is_active_sidebar( 'left-column' )){
  $span = 12 - $left_column_width;
	$content_offset = 'col-md-push-'.$left_column_width;
	$left_widget_offset = 'col-md-pull-'.$span_left;
}
?>

<section id="pe-content">
    
    <div id="pe-content-in" class="container-fluid">
        
        <div class="row">
            
            <div id="pe-content-wrapp" class="col-md-<?php echo $span.' '.$content_offset; ?>">

                <?php if(is_active_sidebar('content-top')) : ?>
                
                <div id="pe-content-top">
                    
                    <?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>
                
                </div>
                
                <?php endif; ?>

                <!-- Begin of main content area -->
                <div id="pe-maincontent">
                <?php 
                if ( is_front_page() && ot_get_option('font_sizer_front') == 'on' 
                    || !is_front_page() && is_page() && ot_get_option('font_sizer_page') == 'on')
                get_template_part( 'tpl/fontswitcher' ); 
                ?>

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">

                        <div class="page-header">
                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>

                        </div>

                        <?php
                          if ( has_post_thumbnail() ){
                          $image_id = get_post_thumbnail_id();
                          $image_url = wp_get_attachment_url($image_id);
                        ?>

                        <figure>

                            <div class="pull-left pe-item-image">

                                <?php the_post_thumbnail('post-featured-image'); ?>

                            </div>

                        </figure>

                        <?php } ?>

                        <div class="pe-article-content" itemprop="articleBody">

                            <?php the_content(); ?>
							<?php
								wp_link_pages( array(
									'before'      => '<div class="page-links clearfix"><span class="page-links-title">' . __( 'Pages:', 'PixelEmu' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );
							?>
							<?php if (ot_get_option( 'addthis_code' )){ ?>
								<div class="addthis_sharing_toolbox"></div>
							<?php } ?>
                        </div>
                    <?php 
                    if ( ot_get_option('comments_page') == 'on' ) {
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

            <?php if(is_active_sidebar('left-column')) : ?>
            <aside id="pe-left" class="col-md-<?php echo $left_column_width.' '.$left_widget_offset;?>">
                <?php if ( ! dynamic_sidebar( __('Left Sidebar','PixelEmu') )) : endif; ?>
            </aside>
            <?php endif; ?>

        </div>

    </div>

</section>

<?php get_footer(); ?>