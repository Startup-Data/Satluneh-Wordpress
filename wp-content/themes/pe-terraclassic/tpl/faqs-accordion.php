<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

$faqs_args = array(
	'post_type' => 'faqs',
	'paged'     => $paged
);

$faqs_accordion_query = new WP_Query( $faqs_args );

if ( $faqs_accordion_query->have_posts() ): ?>

	<!-- Accordion -->
	<div class="pe-accordion-container" role="tablist" aria-multiselectable="true">
		<?php
		$i = 0;
		while ( $faqs_accordion_query->have_posts() ): $faqs_accordion_query->the_post();
			?>

			<?php

			$headingid     = 'pe-heading-' . $i;
			$panelid       = 'pe-accordion-' . $i;
			$active_class  = ( $i === 0 ) ? 'active' : '';
			$aria_expanded = ( $i === 0 ) ? 'true' : 'false';
			?>

			<div class="pe-accordion">
				<div class="accordion-in">
					<div id="<?php echo $headingid; ?>" class="pe-accordion-heading <?php echo $active_class; ?>" role="tab">
						<a href="#<?php echo $panelid; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $panelid; ?>"><?php the_title(); ?></a>
					</div>
					<div id="<?php echo $panelid; ?>" class="pe-accordion-content <?php echo $active_class; ?>" role="tabpanel" aria-labelledby="<?php echo $headingid; ?>" aria-expanded="<?php echo $aria_expanded; ?>">
						<?php the_content(); ?>
					</div>
				</div>
			</div>

			<?php
			$i ++;
			?>

		<?php endwhile; ?>
	</div>

	<!-- End of FAQs accordion -->
	<?php pe_pagination( $faqs_accordion_query->max_num_pages ); ?>

	<?php wp_reset_query();
else: ?>
	<div class="pe-article-content">
		<?php esc_html_e( 'No FAQs Found!', 'pe-terraclassic' ); ?>
	</div>
<?php endif; ?>
