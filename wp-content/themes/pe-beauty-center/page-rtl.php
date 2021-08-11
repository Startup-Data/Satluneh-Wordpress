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

* Template Name: RTL

*/
get_template_part( 'layout-options' );

// Get info about breadcrumbs
$off_canvas_position = ot_get_option( 'offcanvas_position', 'right' ); ?>

<!DOCTYPE html>

<html dir="rtl">
	
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<![endif]-->
		<?php

		$favicon = ot_get_option( 'favicon' );

		if($favicon) { ?>

			<link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />
			<link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />		
		
		<?php } ?>
		
		<?php get_template_part( 'tpl/google-webmaster' ); ?>
		<?php get_template_part( 'tpl/custom-code' ); ?>
		<?php get_template_part( 'tpl/google-analytics' ); ?>
		
		<?php

			$sticky_topbar = ot_get_option( 'sticky_topbar', 'on' );

			if($sticky_topbar == 'on'){

				$sticky_topbar_val = 'sticky-bar';

			} else{

				$sticky_topbar_val = '';

			}
		?>
		<?php wp_head(); ?>
		<?php wp_enqueue_style( 'rtl', get_template_directory_uri().'/css/rtl.css' ); ?>
	</head>
	
	<body <?php body_class( 'rtl off-canvas-'.$off_canvas_position.' '.$sticky_topbar_val ); ?>>
		
		<div id="pe-main">

		<?php

			//offcanvas
			get_template_part( 'tpl/offcanvas' );
		
			//top bar menu, logo and main menu
			get_template_part( 'tpl/top-bar' );
			
			//header section for slider and custom widgets
			get_template_part( 'tpl/header-section' );
			
			//top widget position
			get_template_part( 'tpl/top' );

			// breadcrumb position
			if (!is_front_page() && !is_home() ) :
				if ( is_page() && ot_get_option( 'breadcrumb_page') == 'on' 
					|| is_singular('post') && ot_get_option( 'breadcrumb_single') == 'on' 
					|| is_singular('service') && ot_get_option( 'breadcrumb_service') == 'on' 
					|| is_singular('member') && ot_get_option( 'breadcrumb_member') == 'on'
					|| is_singular('testimonial') && ot_get_option( 'breadcrumb_testimonial') == 'on'
					|| is_archive() && ot_get_option( 'breadcrumb_archive') == 'on' ) {
					get_template_part( 'tpl/breadcrumbs' );
				}
			endif;
		
		?>

<section id="pe-content">
    
    <div id="pe-content-in" class="container-fluid">
        
        <div class="row">
            
            <div id="pe-content-wrapp" class="col-md-<?php echo $GLOBALS[ 'span' ].' '.$GLOBALS[ 'content_offset' ]; ?>">

                <?php if(is_active_sidebar('content-top')) : ?>
                
                <div id="pe-content-top">
                    <div class="row">
                        <?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>
                    </div>
                </div>
                
                <?php endif; ?>
					<?php if($post->post_content=="") : ?>

					<!-- Leave blank to skip empty posts) -->

					<?php else : ?>
                <!-- Begin of main content area -->
                <div id="pe-maincontent">

                <?php 
                if ( is_front_page() && ot_get_option('font_sizer_front') == 'on' 
                    || !is_front_page() && is_page() && ot_get_option('font_sizer_page') == 'on')
                get_template_part( 'tpl/fontswitcher' ); 
                ?>

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div <?php post_class(array('pe-article','clearfix')); ?> itemscope="" itemtype="http://schema.org/Article">
                        
                    <?php if (is_front_page() && ot_get_option( 'front_page_title') == 'on' || !is_front_page() ) { ?>
                        <div class="page-header">
                            <h1 itemprop="name"><?php the_title(); ?></h1>
                        </div>
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
                <?php endif; ?>

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