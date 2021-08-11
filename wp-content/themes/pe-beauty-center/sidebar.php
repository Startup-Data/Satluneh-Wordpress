<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$left_column_width = ot_get_option( 'left_column_width', '3' );
$right_column_width = ot_get_option( 'right_column_width', '3' );
?>

<?php if ($GLOBALS['theme_layout']=='left-sidebar' || $GLOBALS['theme_layout']=='right-dual-sidebar' || $GLOBALS['theme_layout']=='left-dual-sidebar' || $GLOBALS['theme_layout']=='dual-sidebar') { ?>
  <?php if(is_active_sidebar('left-column')) : ?>
  <aside id="pe-left" class="col-md-<?php echo $left_column_width.' '.$GLOBALS[ 'left_widget_offset' ]; ?>">
    <?php if ( ! dynamic_sidebar( __('Left Sidebar','PixelEmu') )) : endif; ?>
  </aside>
  <?php endif; ?>
<?php } ?>

<?php if ($GLOBALS['theme_layout']=='right-sidebar' || $GLOBALS['theme_layout']=='right-dual-sidebar' || $GLOBALS['theme_layout']=='left-dual-sidebar' || $GLOBALS['theme_layout']=='dual-sidebar') { ?>
  <?php if(is_active_sidebar('right-column')) : ?>
  <aside id="pe-right" class="col-md-<?php echo $right_column_width.' '.$GLOBALS[ 'right_widget_offset' ]; ?>">
    <?php if ( ! dynamic_sidebar( __('Right Sidebar','PixelEmu') )) : endif; ?>
  </aside>
  <?php endif; ?>
<?php } ?>