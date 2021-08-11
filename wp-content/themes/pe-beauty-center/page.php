<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>

<?php get_header(); ?>

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
