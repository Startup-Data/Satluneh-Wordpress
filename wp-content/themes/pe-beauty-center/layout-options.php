<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php

  global $theme_layout_frontpage;
  global $theme_layout;
  global $span;
  global $content_offset;
  global $left_widget_offset;
  global $right_widget_offset;
  global $page_suffix;
  global $counter;
  $counter = 0;
  $left_column_width = 0;
  $right_column_width = 0;
  if (is_front_page() ) {
    $theme_layout = ot_get_option( 'frontpage_layout','left-sidebar' );
  } else{
    $theme_layout = ot_get_option( 'subpage_layout','right-sidebar' );
  }

  if(is_active_sidebar( 'left-column')){
    $left_column_width = ot_get_option( 'left_column_width', '3' );
  }
  if(is_active_sidebar( 'right-column')){
    $right_column_width = ot_get_option( 'right_column_width', '3' );
  }
  $span_left = 12 - $left_column_width;
  $span_right = 12 - $right_column_width;
  $span_left_right = 12 - $left_column_width - $right_column_width;
  $span_left_right_minus = 12 - $span_left_right;
  $span_left_right_ammount = $left_column_width + $right_column_width;

  if (($theme_layout=='full-width') || (!is_active_sidebar( 'left-column' ) && !is_active_sidebar( 'right-column' )) || (!is_active_sidebar( 'left-column' ) && $theme_layout=='left-sidebar') || (!is_active_sidebar( 'right-column' ) && $theme_layout=='right-sidebar')){
    $span = "12";
  } else if ((is_active_sidebar( 'left-column' )) && ($theme_layout=='left-sidebar')){
    $span = 12 - $left_column_width;
  } else if((is_active_sidebar( 'right-column' )) && ($theme_layout=='right-sidebar')){
    $span = 12 - $right_column_width;
  } else if((is_active_sidebar( 'left-column' ) && is_active_sidebar( 'right-column' )) && (($theme_layout=='right-dual-sidebar')) || ($theme_layout=='left-dual-sidebar') || ($theme_layout=='dual-sidebar')){
    $span = 12 - $left_column_width - $right_column_width;
  }
  
  if($theme_layout=='right-sidebar'){
    $content_offset = 'col-md-push-0';
    $left_widget_offset = 'col-md-pull-0';
  }
  if($theme_layout=='left-sidebar'){
    $content_offset = 'col-md-push-'.$left_column_width;
    $left_widget_offset = 'col-md-pull-'.$span_left;
  }
  if($theme_layout=='dual-sidebar'){
    $content_offset = 'col-md-push-'.$left_column_width;
    $left_widget_offset = 'col-sm-6 col-md-pull-'.$span_left_right;
    $right_widget_offset = 'col-sm-6';
  }
  if($theme_layout=='right-dual-sidebar'){
    $content_offset = 'col-xs-offset-0';
    $left_widget_offset = 'col-sm-6';
    $right_widget_offset = 'col-sm-6';
  }
  if($theme_layout=='left-dual-sidebar'){
    $content_offset = 'col-md-push-'.$span_left_right_minus;
    $left_widget_offset = 'col-sm-6 col-md-pull-'.$span_left_right;
    $right_widget_offset = 'col-sm-6 col-md-pull-'.$span_left_right;
  }

?>