<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$per_row = intval(get_post_meta(get_the_ID(), 'services_per_row',true));
$per_page = intval(get_post_meta(get_the_ID(), 'services_total',true));
$thumbs_width = get_post_meta(get_the_ID(), 'thumbnail_width',true);
$content_width = (12 - $thumbs_width);
$col_number = floor(12 / $per_row);
$categories = get_post_meta(get_the_ID(), 'service_categories',true);
$image_size = get_post_meta(get_the_ID(), 'thumbnails_size',true);

$services_args = array(
    'post_type'       => 'service',
    'posts_per_page'  => $per_page,
    'paged'           => $paged,
    'tax_query'       => array(
    array(
        'taxonomy'  => 'service-category',
        'field'     => 'term_id',
        'terms'     => $categories
        )
    )
);

$services_carousel_query = new WP_Query( $services_args );

if($services_carousel_query->have_posts()): ?>

<!-- Services slider schema left -->
<div id="pe-services-carousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false">
    <div class="row">
        <div class="col-md-<?php echo $thumbs_width ?>">
            <div class="schema-left-right">
                <div class="pe-indicators-wrapper">
                <?php 
                    $i = 0; 
                    $start_row = true;
                    $post_counter = 0;
                ?>
                <?php while ($services_carousel_query->have_posts()): $services_carousel_query->the_post(); ?>
                <?php 
                    if ($start_row) {
                        echo '<div class="row"><!-- start the row -->';
                        echo '<div class="pe-title-block carousel-indicators">';
                    $start_row = false;
                    }
                ?>
                <?php
                    $post_counter += 1; 
                ?>
                <?php $i++;
                if ($i == 1) { ?>
                    <div class="before-col active">
                        <div class="col-md-<?php echo $col_number; ?>">
                            <div class="pe-indicator" data-target="#pe-services-carousel" data-slide-to="0">
                                <?php if(has_post_thumbnail()) { ?>
                                <div class="pe-indicator-img">
                                <?php the_post_thumbnail($image_size); ?>
                                </div>
                                <?php } ?>
                                <div class="pe-indicator-name"><?php the_title(); ?></div>
                                <div class="pe-indicator-details"><?php echo get_post_meta(get_the_ID(), 'service_subtitle',true); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="before-col">
                        <div class="col-md-<?php echo $col_number; ?>">
                            <div class="pe-indicator" data-target="#pe-services-carousel" data-slide-to="<?php echo ($i - 1);?>">
                                <?php if(has_post_thumbnail()) { ?>
                                <div class="pe-indicator-img">
                                <?php the_post_thumbnail($image_size); ?>
                                </div>
                                <?php } ?>
                                <div class="pe-indicator-name"><?php the_title(); ?></div>
                                <div class="pe-indicator-details"><?php echo get_post_meta(get_the_ID(), 'service_subtitle',true); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php 
                    if ( $per_row == $post_counter ) {
                        echo '</div></div><!-- close the row -->';
                        $start_row = true;
                        $post_counter = 0;
                    }
                ?>

                <?php endwhile; 

                    if ($post_counter !== 0 ) {
                        echo '</div></div><!-- close the row -->';
                    }
                ?>
            </div>
            <?php pe_pagination_services( $services_carousel_query->max_num_pages); ?>
        </div>
    </div>

    <?php $count = 0; ?>
    <!-- Wrapper for slides -->
    <div class="col-md-<?php echo $content_width ?>">
    <div class="carousel-inner" role="listbox">
    <?php while ($services_carousel_query->have_posts()): $services_carousel_query->the_post(); 
    $count++;
    if ($count == 1) { ?>
        <div class="item pe-item active">
            <div class="pe-services">
                <div class="pe-services-title">
                    <?php 
                    $service_categories = get_the_terms( $post->ID, 'service-category' );
                        if($service_categories && ! is_wp_error( $service_categories )){
                            foreach($service_categories as $service_category){
                                echo $service_category->name;
                            }
                        } 
                    ?> <span><?php the_title(); ?></span>
                </div>
                <div class="pe-services-item-desc"><?php the_content(); ?></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="item pe-item">
            <div class="pe-services">
                <div class="pe-services-title">
                    <?php 
                    $service_categories = get_the_terms( $post->ID, 'service-category' );
                        if($service_categories && ! is_wp_error( $service_categories )){
                            foreach($service_categories as $service_category){
                                echo $service_category->name;
                            }
                        } 
                    ?> <span><?php the_title(); ?></span>
                </div>
                <div class="pe-services-item-desc"><?php the_content(); ?></div>
            </div>
        </div>
    <?php } ?>
    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
<!-- End of Services slider schema bottom -->

<?php wp_reset_query(); else: ?>
    <div class="pe-article-content" itemprop="articleBody">
        <?php _e('No Services Found!', 'PixelEmu'); ?>
    </div>
<?php endif; ?>