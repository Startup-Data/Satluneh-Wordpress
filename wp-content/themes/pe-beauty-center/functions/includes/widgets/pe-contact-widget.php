<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php

if( !class_exists('PE_Contact') ){

    class PE_Contact extends WP_Widget {

        function __construct(){
            $widget_ops = array( 'classname' => 'PE_Contact', 'description' => __('Displays Contact information from Theme Options.','PixelEmu') );
            parent::__construct( 'PE_Contact', __('PE Contact','PixelEmu'), $widget_ops );
        }
	    function PE_Contact()
	    {
	        self::__construct();
	    }

        function widget($args, $instance) {

            extract($args);

            $title = apply_filters('widget_title', $instance['title']);

            if ( empty($title) ) $title = false;

            $email = ( $instance['email'] === 1 ) ? true : false;
            $visit_us = ( $instance['visit_us'] === 1 ) ? true : false;
            $visit_us_text = $instance['visit_us_text'];
            $visit_us_link = $instance['visit_us_link'];

            echo $before_widget;

            if($title):
                echo $before_title;
                echo $title;
                echo $after_title;
            endif;

            $email_address = $GLOBALS['email_address'];
            $contact_address = $GLOBALS['contact_address'];
            ?>
            <div class="pe-company">
                <div class="desc pull-left">
                <?php echo $contact_address; ?>
                    <?php if (!empty($email_address) && $email==1):?>
                    <span class="pull-right">
                        <?php _e('e-mail', 'PixelEmu'); ?>:&nbsp;
                        <a href="mailto:<?php echo antispambot( $email_address ); ?>" >
                            <?php echo antispambot( $email_address ); ?>
                        </a>
                    </span>
                    <br />
                    <?php endif; ?>
                    <?php if (!empty($visit_us_text) && $visit_us==1):?>
                    <span class="link pull-right">
                        <a class="readmore" href="<?php echo $visit_us_link;?>"><?php echo $visit_us_text;?></a>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $after_widget;

        }


        function form($instance)
        {

            $instance = wp_parse_args( (array) $instance, array( 
                'title'             => 'Beauty Center', 
                'email'             => 1, 
                'visit_us'          => 1,
                'visit_us_text'     => 'Visit Us',
                'visit_us_link'     => ''
                ) 
            );

            $title= esc_attr($instance['title']);
            $email = ( $instance['email'] === 1 ) ? true : false;
            $visit_us = ( $instance['visit_us'] === 1 ) ? true : false;
            $visit_us_text = esc_attr($instance['visit_us_text']);
            $visit_us_link = esc_url($instance['visit_us_link']);

            ?>
                       
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'PixelEmu'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <input class="checkbox" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="checkbox" <?php checked( $email, 1 ); ?>/>
                <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Show Email Address.', 'PixelEmu'); ?></label>
            </p>
            <p>
                <input class="checkbox" id="<?php echo $this->get_field_id('visit_us'); ?>" name="<?php echo $this->get_field_name('visit_us'); ?>" type="checkbox" <?php checked( $visit_us, 1 ); ?>/>
                <label for="<?php echo $this->get_field_id('visit_us'); ?>"><?php _e('Show Visit Us link.', 'PixelEmu'); ?></label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('visit_us_text'); ?>"><?php _e('Visit Us Text', 'PixelEmu'); ?></label>
                <input type="text" name="<?php echo $this->get_field_name('visit_us_text'); ?>" id="<?php echo $this->get_field_id('visit_us_text'); ?>"" class="widefat" value="<?php echo $instance['visit_us_text']; ?>"" /></p>
            <p>
            <p>
                <label for="<?php echo $this->get_field_id('visit_us_link'); ?>"><?php _e('Visit Us Link <small class="description">(Example: http://pixelemu.com)</small>', 'PixelEmu'); ?></label>
                <input type="text" name="<?php echo $this->get_field_name('visit_us_link'); ?>" id="<?php echo $this->get_field_id('visit_us_link'); ?>"" class="widefat" value="<?php echo $instance['visit_us_link']; ?>"" /></p>
            <p>
        <?php
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = strip_tags($new_instance['title']);
            $instance['email'] = isset( $new_instance['email'] ) ? 1 : 0;
            $instance['visit_us'] = isset( $new_instance['visit_us'] ) ? 1 : 0;
            $instance['visit_us_text'] = strip_tags($new_instance['visit_us_text']);
            $instance['visit_us_link'] = esc_url( $new_instance['visit_us_link'] );

            return $instance;

        }

    }
}
?>