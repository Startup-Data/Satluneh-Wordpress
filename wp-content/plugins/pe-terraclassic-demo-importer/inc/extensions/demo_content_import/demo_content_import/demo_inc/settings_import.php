<?php

$demo = ( !empty($_POST['demo']) ) ? substr(rawurldecode($_POST['demo']), 1, -1) : 'demo1';

//update options
$settings_show_on_front  = PE_MainClass::$_settings_show_on_front;
$settings_page_on_front  = PE_MainClass::$_settings_page_on_front;
$settings_page_for_posts = PE_MainClass::$_settings_page_for_posts;
$settings_posts_per_page = PE_MainClass::$_settings_posts_per_page;

//set page as frontpage
update_option ( 'show_on_front', $settings_show_on_front );
PE_ReduxImport::$_log->logInfo ('Setting Front type '. $settings_show_on_front );
//set page's ID for frontpage
update_option ( 'page_on_front', $settings_page_on_front );
PE_ReduxImport::$_log->logInfo ('Setting Front Page ID ' . $settings_page_on_front );
//set page's ID for blog
update_option ( 'page_for_posts', $settings_page_for_posts );
PE_ReduxImport::$_log->logInfo ('Setting Page ID for Posts ' . $settings_page_for_posts );
//set blog posts limit
update_option ( 'posts_per_page', $settings_posts_per_page );
PE_ReduxImport::$_log->logInfo ('Setting Post per Page number ' . $settings_posts_per_page );

PE_ReduxImport::$_log->logInfo ( $demo );

//set thumbnail sizes
update_option( 'thumbnail_size_w', 170 );
update_option( 'thumbnail_size_h', 170 );
update_option( 'thumbnail_crop', 1 );
PE_ReduxImport::$_log->logInfo ('Setting thumbnail size thumbnail');

update_option( 'medium_size_w', 0 );
update_option( 'medium_size_h', 300 );
PE_ReduxImport::$_log->logInfo ('Setting thumbnail size medium');

update_option( 'large_size_w', 1170 );
update_option( 'large_size_h', 780 );
PE_ReduxImport::$_log->logInfo ('Setting thumbnail size large');


$this->add_post++; // count settings which really was imported
$this->tt_post++; // count settings which should be imported

// insert custom termeta (import XML doesnt work for category images)
global $wpdb;
$sql = "INSERT INTO {$wpdb->prefix}termmeta (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(1, 4, 'category_layout', '2'),
(2, 5, 'category_layout', '3'),
(3, 3, 'category_style', 'effect'),
(4, 14, '_tc_cat_image_id', '3354'),
(5, 14, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/agro.png'),
(6, 16, '_tc_cat_image_id', '3356'),
(7, 16, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/bike.png'),
(8, 17, '_tc_cat_image_id', '3355'),
(9, 17, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/ball.png'),
(10, 18, '_tc_cat_image_id', '3357'),
(11, 18, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/cars.png'),
(12, 29, '_tc_cat_image_id', '3364'),
(13, 29, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/mobiles.png'),
(14, 20, '_tc_cat_image_id', '3358'),
(15, 20, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/exchange.png'),
(16, 21, '_tc_cat_image_id', '2925'),
(17, 21, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/05/77_t-shirt-2_ths.png'),
(18, 22, '_tc_cat_image_id', '3359'),
(19, 22, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/fore-free.png'),
(20, 23, '_tc_cat_image_id', '3360'),
(21, 23, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/furniture.png'),
(22, 24, '_tc_cat_image_id', '3361'),
(23, 24, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/house.png'),
(24, 26, '_tc_cat_image_id', '3362'),
(25, 26, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/jobs.png'),
(26, 27, '_tc_cat_image_id', '3363'),
(27, 27, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/kids.png'),
(28, 19, '_tc_cat_image_id', '3364'),
(29, 19, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/mobiles.png'),
(30, 30, '_tc_cat_image_id', '3367'),
(31, 30, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/pets.png'),
(32, 31, '_tc_cat_image_id', '3365'),
(33, 31, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/proporties.png'),
(34, 32, '_tc_cat_image_id', '3366'),
(35, 32, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/services.png'),
(43, 15, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/health.png'),
(42, 15, '_tc_cat_image_id', '3369'),
(45, 25, '_tc_cat_image', 'http://watermark.pixelemu.com/pe-terraclassic/wp-content/uploads/2018/08/household.png'),
(44, 25, '_tc_cat_image_id', '3370');";
$wpdb->query($sql);