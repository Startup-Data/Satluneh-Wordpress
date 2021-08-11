<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// SINGLE POST (type member)
// ---------------------------------------------------------------

get_header();

$highContrast = PEsettings::get( 'highContrast' );

//get professions
$member_profession = get_post_meta( $post->ID, 'member_profession', true );

//opening
$show_member_hours    = PEsettings::get( 'member-opening-hours' );
$member_opening_hours = get_post_meta( $post->ID, 'opening_hours', true );
$member_phone         = get_post_meta( $post->ID, 'member_phone', true );
$member_email         = get_post_meta( $post->ID, 'member_email', true );

$image_size   = PEsettings::get( 'member-thumbnail-size' );
$social_icon  = PEsettings::get( 'member-social-links' );
$contact_info = PEsettings::get( 'member-contact-info' );

$facebook  = get_post_meta( get_the_ID(), 'member_facebook', true );
$twitter   = get_post_meta( get_the_ID(), 'member_twitter', true );
$google    = get_post_meta( get_the_ID(), 'member_google', true );
$linkedin  = get_post_meta( get_the_ID(), 'member_linkedin', true );
$pinterest = get_post_meta( get_the_ID(), 'member_pinterest', true );
$skype     = get_post_meta( get_the_ID(), 'member_skype', true );
$youtube   = get_post_meta( get_the_ID(), 'member_youtube', true );
$vimeo     = get_post_meta( get_the_ID(), 'member_vimeo', true );
$rss       = get_post_meta( get_the_ID(), 'member_rss', true );

$social = ( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $google ) || ! empty( $linkedin ) || ! empty( $pinterest )
			|| ! empty( $skype ) || ! empty( $youtube ) || ! empty( $vimeo ) || ! empty( $rss ) ) ? true : false;

$opening_hours_label = ( PEsettings::get( 'member-opening-hours-label' ) ) ? PEsettings::get( 'member-opening-hours-label' ) : __( 'Working hours', 'pe-terraclassic' );

$main_width = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';
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

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article <?php post_class(); ?>>

							<header class="page-header">

								<?php if($post_page_heading == 7){ ?>
									<p class="page-header-main-title"><?php the_title(); ?></p>
								<?php } else { ?>
									<h<?php echo $post_page_heading; ?> class="page-header-main-title"><?php the_title(); ?></h<?php echo $post_page_heading; ?>>
								<?php } ?>

								<?php if ( ! empty( $member_profession ) ) : ?>
									<div class="post-meta standard-meta">
									<span>
										<?php
										echo esc_attr( $member_profession );
										?>
									</span>
									</div>
								<?php endif; ?>

							</header>

							<?php if ( has_post_thumbnail() ) {

								pe_show_thumbnail( 'medium', false, 'pull-left' );

							} ?>

							<div class="pe-article-content">

								<?php the_content(); ?>

								<?php

								if ( $show_member_hours ) {
									$opening_data = false;
									foreach ( $member_opening_hours as $value ) {
										if ( ! empty( $value ) ) {
											$opening_data = true;
											break;
										}
									}
								} else {
									$opening_data = false;
								}

								if ( ( ( $opening_data ) && is_array( $member_opening_hours ) ) ||
									 ( $contact_info && ! empty( $member_phone ) || ! empty( $member_email ) ) ||
									 ( $social_icon && $social )
								) {
									echo '<div class="pe-row single-member">';
								}

								//opening hours
								if ( ( $opening_data ) && is_array( $member_opening_hours ) ) {
									echo '<div class="pe-opening-hours col-md-4">';
									echo '<h2 class="pe-title">' . sanitize_text_field( $opening_hours_label ) . '</h2>';
									echo '<ul class="pe-hours clearfix">';

									//monday
									if ( ! empty( $member_opening_hours['monday-from'] ) || ! empty( $member_opening_hours['monday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Monday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['monday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['monday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['monday-from'] ) && ! empty( $member_opening_hours['monday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['monday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['monday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//tuesday
									if ( ! empty( $member_opening_hours['tuesday-from'] ) || ! empty( $member_opening_hours['tuesday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Tuesday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['tuesday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['tuesday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['tuesday-from'] ) && ! empty( $member_opening_hours['tuesday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['tuesday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['tuesday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//wednesday
									if ( ! empty( $member_opening_hours['wednesday-from'] ) || ! empty( $member_opening_hours['wednesday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Wednesday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['wednesday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['wednesday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['wednesday-from'] ) && ! empty( $member_opening_hours['wednesday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['wednesday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['wednesday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//thursday
									if ( ! empty( $member_opening_hours['thursday-from'] ) || ! empty( $member_opening_hours['thursday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Thursday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['thursday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['thursday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['thursday-from'] ) && ! empty( $member_opening_hours['thursday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['thursday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['thursday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//friday
									if ( ! empty( $member_opening_hours['friday-from'] ) || ! empty( $member_opening_hours['friday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Friday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['friday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['friday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['friday-from'] ) && ! empty( $member_opening_hours['friday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['friday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['friday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//saturday
									if ( ! empty( $member_opening_hours['saturday-from'] ) || ! empty( $member_opening_hours['saturday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Saturday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['saturday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['saturday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['saturday-from'] ) && ! empty( $member_opening_hours['saturday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['saturday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['saturday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									//sunday
									if ( ! empty( $member_opening_hours['sunday-from'] ) || ! empty( $member_opening_hours['sunday-to'] ) ) {
										echo '<li><div class="pe-oh-day">' . esc_html__( 'Sunday', 'pe-terraclassic' ) . '</div>';
										echo '<div class="pe-oh-hours">';
										//from
										if ( ! empty( $member_opening_hours['sunday-from'] ) ) {
											echo '<span class="pe-oh-from">' . esc_attr( $member_opening_hours['sunday-from'] ) . '</span>';
										}
										//separator
										if ( ! empty( $member_opening_hours['sunday-from'] ) && ! empty( $member_opening_hours['sunday-to'] ) ) {
											echo '<span class="pe-separator"></span>';
										}
										//to
										if ( ! empty( $member_opening_hours['sunday-to'] ) ) {
											echo '<span class="pe-oh-to">' . esc_attr( $member_opening_hours['sunday-to'] ) . '</span>';
										}
										echo '</div></li>';
									}

									echo '</ul>';
									echo '</div>';
								}
								?>

								<?php if ( $contact_info && ( ! empty( $member_phone ) || ! empty( $member_email ) ) ) { ?>
									<div class="pe-member-contact col-md-4">
										<h2 class="pe-title"><?php esc_html_e( 'Contact Details', 'pe-terraclassic' ) ?></h2>
										<?php if ( ! empty( $member_phone ) ) { ?>
											<p class="phone"><?php esc_html_e( 'Phone', 'pe-terraclassic' ); ?>
												: <?php echo esc_attr( $member_phone ); ?></p>
										<?php } ?>
										<?php if ( ! empty( $member_email ) ) { ?>
											<p class="email"><?php esc_html_e( 'E-mail', 'pe-terraclassic' ); ?>:
												<a href="mailto:<?php echo antispambot( $member_email ); ?>"><?php echo antispambot( $member_email ); ?></a>
											</p>
										<?php } ?>
									</div>
								<?php } ?>

								<?php if ( $social_icon && $social ) { ?>
									<div class="pe-socials col-md-4">
										<h2 class="pe-title"><?php esc_html_e( 'Social Media', 'pe-terraclassic' ) ?></h2>
										<ul class="pe-social-icons">
											<?php if ( ! empty( $facebook ) ): ?>
												<li>
													<a class="pe-facebook" href="<?php echo esc_url( $facebook ); ?>" target="_blank"><span class="icon fa fa-facebook" aria-hidden="true"></span><span class="hover fa fa-facebook" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Facebook', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $twitter ) ): ?>
												<li>
													<a class="pe-twitter" href="<?php echo esc_url( $twitter ); ?>" target="_blank"><span class="icon fa fa-twitter" aria-hidden="true"></span><span class="hover fa fa-twitter" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Twitter', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $google ) ): ?>
												<li>
													<a class="pe-google" href="<?php echo esc_url( $google ); ?>" target="_blank"><span class="icon fa fa-google-plus" aria-hidden="true"></span><span class="hover fa fa-google-plus" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Google Plus', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $linkedin ) ): ?>
												<li>
													<a class="pe-linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank"><span class="icon fa fa-linkedin" aria-hidden="true"></span><span class="hover fa fa-linkedin" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Linkedin', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $pinterest ) ): ?>
												<li>
													<a class="pe-pinterest" href="<?php echo esc_url( $pinterest ); ?>" target="_blank"><span class="icon fa fa-pinterest" aria-hidden="true"></span><span class="hover fa fa-pinterest" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Pinterest', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $skype ) ): ?>
												<li>
													<a class="pe-skype" href="<?php echo esc_url( $skype ); ?>" target="_blank"><span class="icon fa fa-skype" aria-hidden="true"></span><span class="hover fa fa-skype" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Skype', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $youtube ) ): ?>
												<li>
													<a class="pe-youtube" href="<?php echo esc_url( $youtube ); ?>" target="_blank"><span class="icon fa fa-youtube" aria-hidden="true"></span><span class="hover fa fa-youtube" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Youtube', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $vimeo ) ): ?>
												<li>
													<a class="pe-vimeo" href="<?php echo esc_url( $vimeo ); ?>" target="_blank"><span class="icon fa fa-vimeo" aria-hidden="true"></span><span class="hover fa fa-vimeo" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'Vimeo', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $rss ) ): ?>
												<li>
													<a class="pe-rss" href="<?php echo esc_url( $rss ); ?>" target="_blank"><span class="icon fa fa-rss" aria-hidden="true"></span><span class="hover fa fa-rss" aria-hidden="true"></span><span class="sr-only"><?php esc_html_e( 'RSS', 'pe-terraclassic' ); ?></span></a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								<?php }

								if ( ( ( $opening_data ) && is_array( $member_opening_hours ) ) ||
									 ( $contact_info && ! empty( $member_phone ) || ! empty( $member_email ) ) ||
									 ( $social_icon && $social )
								) {
									echo '</div>';
								}
								?>
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

			<!-- Sidebars -->
			<?php get_sidebar(); ?>

		</div>

	</div>

</div>

<?php

get_footer();

?>
