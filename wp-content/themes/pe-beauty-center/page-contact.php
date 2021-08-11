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
* Template Name: Contact Page
*/

get_header();

$contact_email = ot_get_option('contact_email');
$contact_form = ot_get_option('contact_form', 'on');
$contact_details = ot_get_option( 'contact_details', 'on' );
$contact_map = ot_get_option( 'google_map', 'on' );
$main_col = 5;
if ($contact_form != 'on' || $contact_details != 'on' && $contact_map != 'on') {
	$main_col = 12;
}
?>

<section id="pe-content">

		<div id="pe-content-in" class="container-fluid">

				<div class="row">

						<div id="pe-content-wrapp" class="col-md-<?php echo $main_col ?>">

								<?php if(is_active_sidebar('content-top')) : ?>

								<div id="pe-content-top">

										<?php if ( ! dynamic_sidebar( __('Content Top','PixelEmu') )) : endif; ?>

								</div>

								<?php endif; ?>

								<!-- Begin of main content area -->
								<div id="pe-maincontent">

								<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

										<div <?php post_class(array('pe-contact','clearfix')); ?> itemscope="" itemtype="http://schema.org/Person">

						<div class="page-header">
							<h1><?php the_title(); ?></h1>
						</div>
												<!-- Begin of contact form -->

												<?php if(!empty($contact_email) && ($contact_form == 'on')) : ?>

												<form id="pe-contact-form" class="pe-contact-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
														<div class="form-group">
																<label for="contactName" class="pe-tooltip" data-toggle="tooltip" data-placement="top" title="<strong><?php _e('Name', 'PixelEmu'); ?></strong><br /><?php _e('Your name', 'PixelEmu'); ?>"><?php _e('Name', 'PixelEmu'); ?><span class="star">&nbsp;*</span></label>
																<input type="text" name="contactName" id="contactName" class="form-control" title="<?php _e( '* Please provide your name', 'PixelEmu'); ?>" required>
														</div>

														<div class="form-group">
																<label for="contactEmail" class="pe-tooltip" data-toggle="tooltip" data-placement="top" title="<strong><?php _e('Email', 'PixelEmu'); ?></strong><br /><?php _e('Email address for contact', 'PixelEmu'); ?>"><?php _e('Email', 'PixelEmu'); ?><span class="star">&nbsp;*</span></label>
																<input type="text" name="contactEmail" id="contactEmail" class="form-control" title="<?php _e( '* Please provide a valid email address', 'PixelEmu'); ?>" required>
														</div>

														<div class="form-group">
																<label for="contactSubject" class="pe-tooltip" data-toggle="tooltip" data-placement="top" title="<strong><?php _e('Subject', 'PixelEmu'); ?></strong><br /><?php _e('Enter the subject of your message here.', 'PixelEmu'); ?>"><?php _e('Subject', 'PixelEmu'); ?><span class="star">&nbsp;*</span></label>
																<input type="text" name="contactSubject" class="form-control" id="contactSubject">
														</div>

														<div class="form-group">
																<label for="contactMessage" class="pe-tooltip" data-toggle="tooltip" data-placement="top" title="<strong><?php _e('Message', 'PixelEmu'); ?></strong><br /><?php _e('Enter your message here.', 'PixelEmu'); ?>"><?php _e('Message', 'PixelEmu'); ?><span class="star">&nbsp;*</span></label>
																<textarea  name="contactMessage" id="contactMessage" class="form-control" cols="50" rows="10" title="<?php _e( '* Please provide your message', 'PixelEmu'); ?>" required></textarea>
														</div>

														<div class="form-group">
																<input type="submit" id="submit-button" value="<?php _e('Send Email', 'PixelEmu'); ?>" class="btn" name="submit">
																<input type="hidden" name="action" value="send_email" />
																<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_email_nonce'); ?>"/>
														</div>
														<div id="pe-error-container"></div>
														<div id="pe-email-report">&nbsp;</div>
												</form>

												<?php endif; ?>
												<!-- End of contact form -->

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
						<?php if ($contact_details == 'on' || $contact_map == 'on') {
								get_sidebar('contact');
						} ?>

				</div>

		</div>

</section>

<?php get_footer(); ?>
