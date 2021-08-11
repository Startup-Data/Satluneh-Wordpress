<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$faqs_args = array(
	'post_type'       => 'faqs',
	'paged'           => $paged
);

$faqs_accordion_query = new WP_Query( $faqs_args );

if($faqs_accordion_query->have_posts()): ?>

	<!-- Accordion -->
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php
			$i = 0; 
			while ($faqs_accordion_query->have_posts()): $faqs_accordion_query->the_post(); 
		?>

		<?php $i++;
			if ($i == 1) { ?>
				<div class="panel pe-panel">
					<div class="panel-heading" role="tab" id="heading0">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0"><?php the_title(); ?></a>
						</h4>
					</div>
					<div id="collapse0" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading0">
						<div class="panel-body"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } else { ?>
				<div class="panel pe-panel">
					<div class="panel-heading" role="tab" id="heading<?php echo ($i - 1);?>">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo ($i - 1);?>" aria-expanded="false" aria-controls="collapse<?php echo ($i - 1);?>"><?php the_title(); ?></a>
						</h4>
					</div>
					<div id="collapse<?php echo ($i - 1);?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo ($i - 1);?>">
						<div class="panel-body"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile; ?>
	</div>
	
	<!-- End of FAQs accordion -->
	<?php pe_pagination( $faqs_accordion_query->max_num_pages); ?>
	
<?php wp_reset_query(); else: ?>
<div class="pe-article-content" itemprop="articleBody">
	<?php _e('No FAQs Found!', 'PixelEmu'); ?>
</div>
<?php endif; ?>