<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php

if( !class_exists('PE_Testimonial_Carousel') ){

    class PE_Testimonial_Carousel extends WP_Widget {

        function __construct(){
            $widget_ops = array( 'classname' => 'PE_Testimonial_Carousel', 'description' => __('Display Team Members carousel.','PixelEmu') );
            parent::__construct( 'PE_Testimonial_Carousel', __('PE Testimonial Carousel','PixelEmu'), $widget_ops );
        }
	    function PE_Testimonial_Carousel()
	    {
	        self::__construct();
	    }

        function widget($args, $instance) {

            extract($args);

            $title = apply_filters('widget_title', $instance['title']);

            if ( empty($title) ) $title = false;

            $desc_limit =  intval($instance['desc_limit']);
            $occupation =  ( $instance['occupation'] === 1 ) ? true : false;
            $number_of_posts = intval( $instance['number_of_posts'] );

            $member_args = array(
                'post_type' => 'testimonial',
                'posts_per_page' => $number_of_posts
            );
            
            $member_query = new WP_Query($member_args);

            echo $before_widget;

            if($title):
                echo $before_title;
                echo $title;
                echo $after_title;
            endif;

            if($member_query->have_posts()): ?>

            <!-- Begin of testimonials slider -->
            <div id="pe-testimonial-carousel" class="carousel slide" data-ride="carousel">
                
                <!-- Indicators -->
                <ol class="carousel-indicators">

                <?php $i = 0;

                while($member_query->have_posts()): 

                    $member_query->the_post();
                    
                    if($i++ == 0) {
                        echo "<li data-target='#pe-testimonial-carousel' data-slide-to='0' class='active'></li>";
                    } else {
                    echo "<li data-target='#pe-testimonial-carousel' data-slide-to='".($i - 1)."'></li>";
                    }

                endwhile; ?>
                
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                <?php

                    $counter = 0;

                    while($member_query->have_posts()):
                        
                        $member_query->the_post();
                    
                    $counter++;
                ?>
                    <?php if ($counter == 1 ) { ?>
                        <div class="item pe-item active">
                    <?php } else { ?>
                        <div class="item pe-item">
                    <?php } ?>
                            <div class="pe-testimonials">
                                <div class="pe-custom-text">
                                    <p>
                                        <?php pe_excerpt( $desc_limit ); ?>
                                    </p>
                                </div>
                                <div class="pe-custom-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>
                               <?php if ( $occupation ) : ?>
                                <div class="pe-custom-subtitle">
                                    <?php echo get_post_meta(get_the_ID(), 'testimonial_occupation',true); ?>
                                </div>
                                <?php endif ;?>

                            </div>
                        </div>

                <?php endwhile; ?>

                    </div>
                </div>
                <!-- End of testimonials slider -->

                <?php wp_reset_query(); else: ?>
                <ul class="testimonial-not-found">
                    <?php
                    echo '<li>';
                    _e('No Testimonials Found!', 'PixelEmu');
                    echo '</li>';
                    ?>
                </ul>
            <?php endif;

            echo $after_widget;
        }


        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, array(

                'title'             => 'Testimonials',

                'desc_limit'        => 15,

                'number_of_posts'   => 10,

                'occupation'        => 1

                )

            ); 

            $title= esc_attr($instance['title']);
            $desc_limit =  $instance['desc_limit'];
            $occupation =  ( $instance['occupation'] === 1 ) ? true : false;
            $number_of_posts = $instance['number_of_posts'];

        ?>
                       
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'PixelEmu'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('number_of_posts'); ?>"><?php _e('Number of testimonials to show', 'PixelEmu'); ?></label>
                <input id="<?php echo $this->get_field_id('number_of_posts'); ?>" name="<?php echo $this->get_field_name('number_of_posts'); ?>" type="text" value="<?php echo $number_of_posts; ?>" size="3" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('desc_limit'); ?>"><?php _e('Testimonial opinion limit', 'PixelEmu'); ?></label>
                <input id="<?php echo $this->get_field_id('desc_limit'); ?>" name="<?php echo $this->get_field_name('desc_limit'); ?>" type="text" value="<?php echo $desc_limit; ?>" size="3" />
            </p>

            <p>
                <input class="checkbox" id="<?php echo $this->get_field_id('occupation'); ?>" name="<?php echo $this->get_field_name('occupation'); ?>" type="checkbox" <?php checked($occupation, 1); ?>/>
                <label for="<?php echo $this->get_field_id('occupation'); ?>"><?php _e('Show/Hide Testimonial Occupation.', 'PixelEmu'); ?></label>
            </p>

        <?php
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['desc_limit'] = $new_instance['desc_limit'];
            $instance['occupation'] = isset( $new_instance['occupation'] ) ? 1 : 0;
            $instance['number_of_posts'] = $new_instance['number_of_posts'];

            return $instance;

        }

    }
}
?>