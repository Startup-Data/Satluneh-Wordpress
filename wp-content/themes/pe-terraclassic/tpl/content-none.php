<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// ---------------------------------------------------------------
// NO CONTENT
// ---------------------------------------------------------------

?>

<div class="no-results not-found">
	<header class="page-header">
		<h1><?php esc_html_e( 'Nothing Found', 'pe-terraclassic' ); ?></h1>
	</header>

	<div class="page-content">

		<?php if ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pe-terraclassic' ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pe-terraclassic' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div>
</div>
