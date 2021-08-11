<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

/*
* Template Name: Login Page
*/

get_header();

$highContrast = PEsettings::get( 'highContrast' );
$main_width   = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';
$post_page_heading = PEsettings::get( 'post-page-heading' );

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

			<div id="pe-content" class="<?php echo PElayout::get( 'content-class' ); ?>">

				<?php get_template_part( 'tpl/content-top' ); ?>

				<!-- Begin of main content area -->
				<main id="pe-maincontent" <?php if ( $highContrast ) {
					echo 'role="main" tabindex="-1"';
				} ?>>

					<article <?php post_class(); ?>>

						<?php if ( has_post_thumbnail() ) {
							pe_show_thumbnail();
						} ?>

						<header class="page-header">
							<?php if($post_page_heading == 7){ ?>
								<p class="page-header-main-title"><?php the_title(); ?></p>
							<?php } else { ?>
								<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
							<?php } ?>
						</header>

						<?php if ( is_user_logged_in() ) : // logged-in ?>
							<div id="pe-login-register-forgot">
								<p class="pe-info"><?php esc_html_e( 'You are already logged in.', 'pe-terraclassic' ); ?></p>
								<a class="button" href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php esc_html_e( 'Logout', 'pe-terraclassic' ); ?></a>
							</div>
						<?php else : // not logged-in ?>
							<div id="pe-login-register-forgot" class="pe-tabs">
								<ul class="pe-tab-links" role="tablist" tabindex="0">
									<li class="active" role="presentation">
										<a href="#pe-tab-login" aria-controls="pe-tab-login" role="tab"><?php esc_html_e( 'Login', 'pe-terraclassic' ); ?></a>
									</li>
									<?php if ( get_option( 'users_can_register' ) ) : // register form ?>
										<li role="presentation">
											<a href="#pe-tab-register" aria-controls="pe-tab-register" role="tab"><?php esc_html_e( 'Register', 'pe-terraclassic' ); ?></a>
										</li>
									<?php endif; ?>
									<li role="presentation">
										<a href="#pe-tab-forgot-password" aria-controls="pe-tab-forgot-password" role="tab"><?php esc_html_e( 'Lost your password?', 'pe-terraclassic' ); ?></a>
									</li>
								</ul>
								<div class="pe-tabs-content">
									<div id="pe-tab-login" class="pe-tab active" role="tabpanel">
										<?php // login form
										$args = array(
											'redirect'    => home_url(),
											'remember'    => true,
											'id_username' => 'user',
											'id_password' => 'pass',
										);

										wp_login_form( $args );

										?>
									</div>

									<?php if ( get_option( 'users_can_register' ) ) : // register form ?>
										<div id="pe-tab-register" class="pe-tab" role="tabpanel">

											<form action="<?php echo site_url( 'wp-login.php?action=register', 'login_post' ) ?>" id="signup-form" method="post">

												<p class="register-username">
													<label class="sr-only" for="userName"><?php esc_html_e( 'Username', 'pe-terraclassic' ) ?></label>
													<input size="30" type="text" id="userName" name="user_login" placeholder="<?php esc_html_e( 'Username', 'pe-terraclassic' ); ?>"/>
												</p>

												<p class="register-email">
													<label class="sr-only" for="user_email"><?php esc_html_e( 'Email', 'pe-terraclassic' ) ?></label>
													<input size="30" type="text" id="user_email" name="user_email" placeholder="<?php esc_html_e( 'Email', 'pe-terraclassic' ); ?>"/>
												</p>

												<p class="register-submit">
													<input type="submit" class="button" name="user-submit" value="<?php esc_html_e( 'Register', 'pe-terraclassic' ); ?>"/>
													<input type="hidden" name="user-cookie" value="1"/>
												</p>

											</form>

										</div>
									<?php endif; ?>

									<div id="pe-tab-forgot-password" class="pe-tab" role="tabpanel">

										<form action="<?php echo site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ?>" id="forgot-form" method="post">

											<p class="pe-info"><?php esc_html_e( 'Please enter your username or email address for your account. A verification e-mail will be sent to you and you will be able to reset your password.', 'pe-terraclassic' ); ?></p>

											<p class="forgot-email">
												<label class="sr-only" for="user_login"><?php esc_html_e( 'Username or Email', 'pe-terraclassic' ) ?></label>
												<input size="30" type="text" name="user_login" value="" id="user_login" placeholder="<?php esc_html_e( 'Username or Email', 'pe-terraclassic' ); ?>"/>
											</p>

											<p class="forgot-submit">
												<input type="submit" class="button" name="user-submit" value="<?php esc_html_e( 'Submit', 'pe-terraclassic' ); ?>"/>
												<input type="hidden" name="redirect_to" value="<?php get_permalink(); ?>"/>
												<input type="hidden" name="user-cookie" value="1"/>
											</p>

										</form>

									</div>

								</div>
							</div>

							<?php
						endif;

						$content = apply_filters( 'the_content', $post->post_content );
						echo $content;

						?>

					</article>

				</main>
				<!-- End of main content area -->

				<?php get_template_part( 'tpl/content-bottom' ); ?>

			</div>

			<!-- Sidebars -->
			<?php get_sidebar(); ?>

		</div>

	</div>

</div>

<?php

get_footer();

?>
