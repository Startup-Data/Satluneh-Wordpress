<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<div id="pe-breadcrumbs">
	<div id="pe-breadcrumbs-in" class="container-fluid">
		<div class="pe-module">
			<ol class="breadcrumb">
				<li>
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;<a href="<?php echo home_url(); ?>"><?php esc_html_e('Home','PixelEmu') ?></a>
				</li>
				<?php if (is_single() && has_category()) { ?>
					<?php 
						$category = get_the_category();
						$catlink = get_category_link( $category[0]->cat_ID );
							echo ('<li><a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a></li><li class="active"><span>'.get_the_title().'<span class="sr-only">(current)</span></span></li>'); 
					?>
				<?php } elseif (is_single() && ! has_category()) { ?>
					<?php echo '<li class="active"><span>'; wp_title(''); echo '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } elseif (is_page()) { ?>
					<?php echo '<li class="active"><span>'; wp_title(''); echo '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } else if (is_category()) { ?>
					<?php echo '<li class="active"><span>'; single_cat_title(); echo '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } else if (is_author()) { $curauth = $wp_query->get_queried_object(); ?>
					<?php echo '<li class="active"><span>'; echo $curauth->display_name; '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } else if (is_tag()) { ?>
					<?php echo '<li class="active"><span>'; echo single_tag_title('',false); '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } else if (is_month()) { ?>
					<?php echo '<li class="active"><span>'; echo get_the_date('F Y'); '<span class="sr-only">(current)</span></span></li>'; ?>
				<?php } ?>
			</ol>
		</div>
	</div>
</div>