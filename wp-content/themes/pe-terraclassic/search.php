<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// SEARCH
// ---------------------------------------------------------------

get_header();

$blog_columns = PEsettings::get( 'blog-columns' );
$blog_style   = 'standard';

$highContrast = PEsettings::get( 'highContrast' );
$main_width   = ( PEsettings::get( 'full-screen,main' ) == 1 ) ? 'full' : '';

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

					<div id="pe-search-form">
						<?php get_search_form(); ?>
					</div>

					<?php if ( have_posts() ) : ?>
						<div class="search">
							<header class="page-header">
								<h1>
								<span class="subheading-category"><?php esc_html_e( 'Search Results For:', 'pe-terraclassic' ); ?>
									<strong><?php the_search_query(); ?></strong> <?php echo '(' . $wp_query->found_posts . ')'; ?></span>
								</h1>
							</header>

							<div class="pe-search-content">
								<?php

								//grid class
								if ( $blog_columns == 2 ) {
									$gridclass = 'col-sm-6';
								} elseif ( $blog_columns == 3 ) {
									$gridclass = 'col-sm-4';
								} elseif ( $blog_columns == 4 ) {
									$gridclass = 'col-sm-3';
								} else {
									$gridclass = 'col-sm-12';
								}

								//showtime
								$counter     = 1;
								$count_posts = $wp_query->post_count;

								$blog_column_size = ( $count_posts == 1 ) ? 'col-sm-12' : $gridclass;

								//rows
								$row_start  = '<div class="pe-blog-row style-' . sanitize_html_class( $blog_style ) . '"><div class="pe-row">';
								$row_and    = '</div></div>';
								$row_middle = $row_and . $row_start;

								echo $row_start;

								while ( have_posts() ) : the_post();

									// Col Start
									echo '<div class="blog-col ' . $blog_column_size . '">';

									get_template_part( 'tpl/post', $blog_style );

									echo '</div>';
									// Col End

									if ( $counter % $blog_columns == 0 ) {

										echo $row_middle;

									}

									$counter ++;

								endwhile;

								echo $row_and;

								pe_pagination( $wp_query->max_num_pages );

								?>
							</div>
						</div>
					<?php else :

						get_template_part( 'tpl/content', 'none' );

					endif; ?>
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
