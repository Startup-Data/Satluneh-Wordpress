<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<div <?php post_class(array('pe-article','clearfix')); ?> itemprop="blogPost" itemscope="" itemtype="http://schema.org/BlogPosting">
    <div class="page-header">
        <h2 itemprop="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( is_home() && ot_get_option('post_info_blog') == 'on' 
            || is_archive() && ot_get_option('post_info_archive') == 'on' ) { ?>
        <div class="post-meta standard-meta thumb-<?php echo has_post_thumbnail()?'exist':'not-exist'; ?>">
            <span><?php _e('Posted on', 'PixelEmu'); ?> <span class="date"> <?php the_time('F d, Y'); ?></span></span>
            <span><?php _e('by', 'PixelEmu'); ?> 
                <span class="author-link">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( __( 'View all posts by %s', 'PixelEmu' ), get_the_author_meta('display_name') ); ?>" >
                        <?php echo get_the_author_meta('display_name'); ?>
                    </a>
                </span> 
                <?php _e('in', 'PixelEmu'); ?> <?php the_category(', '); ?> 
                <?php edit_post_link(__("Edit", "PixelEmu"), '<span> / </span>', ''); ?>
            </span>
        </div>
        <?php } ?>
    </div>
    <?php if ( is_home() && ot_get_option('thumbnail_blog') == 'on' 
    || is_archive() && ot_get_option('thumbnail_archive') == 'on' ) { ?>
        <?php
            if ( has_post_thumbnail() ){
                $image_id = get_post_thumbnail_id();
                $image_url = wp_get_attachment_url($image_id);
        ?>
        <figure>
            <div class="pull-left pe-item-image">
                <a href="<?php the_permalink(); ?>" class="" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail('post-featured-image'); ?>
                </a>
            </div>
        </figure>
        <?php } ?>
    <?php } ?>
    <div class="pe-article-content" itemprop="articleBody">
    <?php if ( is_home() && ot_get_option('readmore_blog') == 'on' 
    || is_archive() && ot_get_option('readmore_archive') == 'on' ) {
    		    
    	if( strpos( $post->post_content, '<!--more-->' ) ) {
				the_content();
			} else {
			blog_excerpt(55);
			}
			
    } else {
        the_content('',FALSE,''); 
    } ?>
    </div>
</div>
