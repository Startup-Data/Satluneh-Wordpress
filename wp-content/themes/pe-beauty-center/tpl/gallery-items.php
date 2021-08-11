<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
print_r (get_post_meta($post->ID, 'gallery_images', true));

if ( function_exists( 'ot_get_option' ) ) {
  $images = explode( ',', get_post_meta($post->ID, 'gallery_images', true) );
  if ( ! empty( $images ) ) {
    foreach( $images as $id ) {
      if ( ! empty( $id ) ) {
        $full_img_src = wp_get_attachment_image_src( $id, '' );
        $thumb_img_src = wp_get_attachment_image_src( $id, '' );
        echo '<li><img src="'.$full_img_src[0].'"</li>';
      }
    }
  }
}
?>