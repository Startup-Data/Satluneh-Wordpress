<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

get_header(); 

$member_position = get_post_meta($post->ID, 'member_position',true);
$member_phone = get_post_meta($post->ID, 'member_phone',true);
$member_email = get_post_meta($post->ID, 'member_email',true);
$image_size = ot_get_option('avatar_size_single', '1');
$member_fb = get_post_meta($post->ID, 'member_fb',true);
$member_tw = get_post_meta($post->ID, 'member_tw',true);
$member_li = get_post_meta($post->ID, 'member_li',true);
$social_icon = ot_get_option('social_links_member');
?>

<section id="pe-content">
    
    <div id="pe-content-in" class="container-fluid">
        
        <div class="row">
            
            <div id="pe-content-wrapp" class="col-md-<?php echo $GLOBALS[ 'span' ].' '.$GLOBALS[ 'content_offset' ]; ?>">

                <?php if(is_active_sidebar('content-top')) : ?>
                
                <div id="pe-content-top">
                    <div  class="row">
                    	<?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>
                		</div>
                </div>
                
                <?php endif; ?>

                <!-- Begin of main content area -->
                <div id="pe-maincontent">
                <?php 
                if ( ot_get_option('font_sizer_member') == 'on' ) {
                    get_template_part( 'tpl/fontswitcher' ); 
                }
                ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">

                        <div class="page-header">
                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>
                           
                            <div class="post-meta standard-meta thumb-<?php echo has_post_thumbnail()?'exist':'not-exist'; ?>">
                                
                                <span><?php echo $member_position; ?></span>
                            
                            </div>

                        </div>

                        <?php
                          if ( has_post_thumbnail() ){
                          $image_id = get_post_thumbnail_id();
                          $image_url = wp_get_attachment_url($image_id);
                        ?>

                        <figure>

                            <div class="pull-left pe-item-image">

                                <?php if ($image_size == '1') {
                                		the_post_thumbnail('member-carousel-small'); 
																} elseif ($image_size == '2'){
																		the_post_thumbnail('member-carousel-large');
																}
                                ?>

                            </div>

                        </figure>

                        <?php } ?>

                        <div class="pe-article-content" itemprop="articleBody">

                            <?php the_content(); ?>

                            <?php if (ot_get_option('contact_info_member') == 'on' && !empty($member_phone) || !empty($member_email)) { ?>
                          			<div class="pe-member-contact">
                                <?php 
                                if ( !empty($member_phone) ) {
                                    _e('Phone','PixelEmu'); ?>:&nbsp;<?php echo $member_phone; }?>
                                
                                <?php if (!empty($member_email) ) {
                                _e('E-mail', 'PixelEmu'); ?>:&nbsp;<a href="mailto:<?php echo antispambot( $member_email ); ?>" ><?php echo antispambot( $member_email ); ?></a> <?php } ?>
                            		</div>
                            <?php } ?>

                            <?php if ( $social_icon == 'on' && (!empty($member_fb) || ($member_tw) || ($member_li) ) ) { ?>
                            <p class="pe-socials">
                            		<?php if (!empty( $member_fb )) { ?>
                                <a class="pe-Facebook" href="<?php echo $member_fb ?>">&nbsp;</a>
                                <?php } ?>
                                <?php if (!empty( $member_tw )) { ?>
                                <a class="pe-Twitter" href="<?php echo $member_tw ?>">&nbsp;</a>
                                <?php } ?>
                                <?php if (!empty( $member_li )) { ?>
                                <a class="pe-LinkedIn" href="<?php echo $member_li ?>">&nbsp;</a>
                                <?php } ?>
                            </p>
                            <?php } ?>

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