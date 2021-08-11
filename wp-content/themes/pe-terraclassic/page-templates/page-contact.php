<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

/*
* Template Name: Contact Page
*/

get_header();

//set layout
PElayout::set( 6 );

$contact_form    = PEsettings::get( 'contact-form' );
$contact_email   = PEsettings::get( 'contact-email-recipients' );
$contact_details = PEsettings::get( 'contact-details' );
$contact_map     = PEsettings::get( 'contact-map' );

if ( ! $contact_form || ! $contact_details && ! $contact_map ) {
	$page_class = 'col-md-12';
} else {
	$page_class = 'col-md-5';
}

if ( $contact_form ) {
	$right_class = 'col-md-7';
} else {
	$right_class = 'col-md-12';
}

$map_lati  = floatval( PEsettings::get( 'contact-map-latitiude' ) );
$map_longi = floatval( PEsettings::get( 'contact-map-longitude' ) );
$map_zoom  = ( PEsettings::get( 'contact-map-zoom' ) ) ? intval( PEsettings::get( 'contact-map-zoom' ) ) : 16;

$contact_address = stripslashes( PEsettings::get( 'contact-address' ) );

$tooltip         = PEsettings::get( 'contact-map-tooltip' );
$tooltip_content = PEsettings::get( 'contact-tooltip-content' );

$reCaptcha = ( PEsettings::get( 'contact-spam-protection' ) && PEsettings::get( 'google-captcha-api' ) && PEsettings::get( 'google-captcha-sitekey' ) && PEsettings::get( 'google-captcha-secretkey' ) ) ? true : false;

$highContrast = PEsettings::get( 'highContrast' );
$main_width   = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';
$post_page_heading = PEsettings::get( 'post-page-heading' );

$consent1 = PEsettings::get('consent1');
$consent1_text = PEsettings::get('consent1-text');
$consent2 = PEsettings::get('consent2');
$consent2_text = PEsettings::get('consent2-text');

// hidden class
$main_hide_mobile = ( PEsettings::get( 'main-hide,mobile' ) == 1 ) ? ' hidden-xs' :'';
$main_hide_tablet = ( PEsettings::get( 'main-hide,tablet' ) == 1 ) ? ' hidden-sm' :'';
$main_hide_desktop = ( PEsettings::get( 'main-hide,desktop' ) == 1 ) ? ' hidden-md' :'';
$main_hide_large = ( PEsettings::get( 'main-hide,large' ) == 1 ) ? ' hidden-lg' :'';
$main_hide = $main_hide_mobile . $main_hide_tablet . $main_hide_desktop . $main_hide_large;
?>

<div id="pe-content-part" class="<?php echo $main_hide; ?>">

	<div id="pe-content-part-in" class="pe-container <?php echo $main_width; ?>">
		<div class="pe-row">

			<?php if ( $contact_map && $map_lati && $map_longi ) : ?>
				<div class="pe-widget pe-largespace">
					<div id="map_canvas" class="embed-responsive embed-responsive-custom"></div>
				</div>
			<?php endif; ?>

			<div id="pe-content" class="<?php echo $page_class; ?>">

				<?php get_template_part( 'tpl/content-top' ); ?>

				<!-- Begin of main content area -->
				<main id="pe-maincontent" <?php if ( $highContrast ) {
					echo 'role="main" tabindex="-1"';
				} ?>>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class( array( 'pe-contact-page', 'clearfix' ) ); ?>>

						<header class="page-header">
							<?php if($post_page_heading == 7){ ?>
								<p class="page-header-main-title"><?php the_title(); ?></p>
							<?php } else { ?>
								<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
							<?php } ?>
						</header>

							<!-- Begin of contact form -->
							<?php if ( ! empty( $contact_email ) && ( $contact_form ) ) : ?>

								<form id="pe-contact-form" class="pe-contact-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
									<div class="pe-alert"></div>
									<div class="pe-success"></div>
									<div class="pe-form-group">
										<label for="contactName" title="<?php _e( 'Your name', 'pe-terraclassic' ); ?>"><?php _e( 'Name', 'pe-terraclassic' ); ?>
											<span class="star">*</span></label>
										<input type="text" name="contactName" id="contactName" title="<?php _e( '* Please provide your name', 'pe-terraclassic' ); ?>" required>
									</div>

									<div class="pe-form-group">
										<label for="contactEmail" title="<?php _e( 'Email address for contact', 'pe-terraclassic' ); ?>"><?php _e( 'Email', 'pe-terraclassic' ); ?>
											<span class="star">*</span></label>
										<input type="email" name="contactEmail" id="contactEmail" title="<?php _e( '* Please provide a valid email address', 'pe-terraclassic' ); ?>" required>
									</div>

									<div class="pe-form-group">
										<label for="contactSubject" title="<?php _e( 'Enter the subject of your message here.', 'pe-terraclassic' ); ?>"><?php _e( 'Subject', 'pe-terraclassic' ); ?>
											<span class="star">*</span></label>
										<input type="text" name="contactSubject" id="contactSubject">
									</div>

									<div class="pe-form-group">
										<label for="contactMessage" title="<?php _e( 'Enter your message here.', 'pe-terraclassic' ); ?>"><?php _e( 'Message', 'pe-terraclassic' ); ?>
											<span class="star">*</span></label>
										<textarea name="contactMessage" id="contactMessage" cols="50" rows="10" title="<?php _e( '* Please provide your message', 'pe-terraclassic' ); ?>" required></textarea>
									</div>
									
									<?php if($consent1 || $consent2){ ?>
										<div class="pe-form-group pe-consents">
											<?php if($consent1){ ?>
											<div class="pe-form-group pe-form-group-consent1">
												<input type="checkbox" name="consent1-input" id="consent1-input" value="0" title="<?php _e( '* Please check the consent.', 'pe-school'); ?>" required>                	
											 	<label class="label_terms" for="consent1-input" id="consent1-lbl"><?php echo $consent1_text; ?> <span class="star">*</span></label>
											</div>
											<?php } ?>
											
											<?php if($consent2){ ?>
											<div class="pe-form-group pe-form-group-consent2">
												<input type="checkbox" name="consent2-input" id="consent2-input" value="0" title="<?php _e( '* Please check the consent.', 'pe-school'); ?>" required>                	
											 	<label class="label_terms" for="consent2-input" id="consent2-lbl"><?php echo $consent2_text; ?> <span class="star">*</span></label>
											</div>
											<?php } ?>
										</div>
									<?php } ?>

									<?php
									if ( $reCaptcha ) {
										echo '<div class="pe-form-group">';
										echo '<div class="g-recaptcha" data-sitekey="' . PEsettings::get( 'google-captcha-sitekey' ) . '"></div>';
										echo '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async defer></script>';
										echo '</div>';
									}
									?>

									<div class="pe-form-group">
										<input type="submit" id="submit-button" value="<?php _e( 'Send Email', 'pe-terraclassic' ); ?>" class="btn" name="submit">
										<input type="hidden" name="form_prefix" value="" />
										<input type="hidden" name="action" value="send_email"/>
										<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'send_email_nonce' ); ?>"/>
									</div>
								</form>

							<?php endif; ?>
							<!-- End of contact form -->

							<?php if ( has_post_thumbnail() ) {
								pe_show_thumbnail();
							} ?>

							<div class="pe-article-content">

								<?php the_content(); ?>

							</div>

						</article>

						<?php
					endwhile;
					endif;
					?>

				</main>
				<!-- End of main content area -->

				<?php get_template_part( 'tpl/content-bottom' ); ?>

			</div>

			<!-- Right sidebar -->
			<aside id="pe-right" class="<?php echo $right_class; ?>">
				<?php if ( $contact_details ) : ?>
					<div class="pe-widget clearfix">
						<?php if ( ! empty( $contact_address ) ) {
							echo apply_filters( 'the_content', $contact_address );
						} ?>
					</div>
				<?php endif; ?>
			</aside>

		</div>

	</div>

</div>

<?php get_footer(); ?>
