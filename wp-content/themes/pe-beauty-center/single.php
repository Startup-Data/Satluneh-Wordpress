<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
get_header(); 
$single_post_thumb = get_post_meta($post->ID, 'feature_img_archive',true);
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
                            <div class="post-meta standard-meta thumb-<?php echo has_post_thumbnail()?'exist':'not-exist'; ?>">
                                
                                <span><?php _e('Posted on', 'PixelEmu'); ?> <span class="date"> <?php the_time('F d, Y'); ?></span></span>
                                
                                <span><?php _e('by', 'PixelEmu'); ?> 
                                    <span class="author-link">
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( __( 'View all posts by %s', 'PixelEmu' ), get_the_author_meta('display_name') ); ?>" >
                                            <?php echo get_the_author_meta('display_name'); ?>
                                        </a>
                                    </span> 
                                    <?php _e('in', 'PixelEmu'); ?> <?php the_category(', '); ?> 
                                    <?php edit_post_link(__("Edit Post", "PixelEmu"), '<span> / </span>', ''); ?>
                                </span>
                            
                            </div>
                            <?php endif; ?>

                        </div>
						<?php if (!empty($single_post_thumb)) {?>
				        <figure>
							<div class="pull-left pe-item-image">
								<img src="<?php echo esc_url( $single_post_thumb); ?>" alt="<?php bloginfo( 'name' ); ?>">
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
                        <?php if (ot_get_option('author_info_single') == 'on') { ?> 
                        <div class="pe-author-info clearfix">
                        <h3 class="pe-title"><?php _e('About Author', 'PixelEmu'); ?></h3>
                        <div class="pull-left pe-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 92 ); ?></div>
                        <div class="pe-author-name">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php printf( __( 'View all posts by %s', 'PixelEmu' ), get_the_author_meta('display_name') ); ?>" >
                                <span class="name"><?php echo get_the_author_meta('display_name'); ?></span>
                            </a>
                            <a href="<?php echo get_the_author_meta('user_url'); ?>" rel="external nofollow" class="url" target="_blank"><?php echo get_the_author_meta('user_url'); ?></a>
                        </div>
                        <div class="pe-author-desc"><?php echo get_the_author_meta('description'); ?></div>
                        </div>
                        <?php } ?>
                        
                        <?php //TAGS
                        if ( has_tag() && ot_get_option('post_tags_single') == 'on' ) { ?>
                        <div class='pe-post-tags'>
                            <span class='title'><?php _e('Tags:', 'PixelEmu'); ?></span>
                        
                        <?php    
                            $tags = get_the_tags();
                            $html = '<ul class="tags list-inline">';
                            foreach ($tags as $tag){
                                $tag_link = get_tag_link($tag->term_id);
                                $html .= "<li itemprop='keywords'><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug} label label-info' rel='tag'>";
                                $html .= "{$tag->name}</a></li>";
                            }
                            $html .= '</ul>';
                            echo $html;
                        ?>
                        </div>
                        <?php } ?>
                        
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