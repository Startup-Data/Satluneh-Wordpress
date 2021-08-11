<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('PE_ReduxImport')) {
    
    class PE_ReduxImport {
        static public $_source_upload_url;
        static public $_source_site_url;
        static public $_log;
        
        static private $upload_dir;
        
        public static function init(){
            self::$upload_dir = ReduxFramework::$_upload_dir . 'demo_content_import';
        }
        
        public static function init_log(){
            include_once 'log.php';

            self::$_log = new KLogger(self::$upload_dir, KLogger::INFO);
        }
        
        public static function delete_everything() {
            $files = glob(self::$upload_dir . '/*.txt');
            
            foreach($files as $file){
                if(is_file($file) && file_exists($file)) {
                    unlink($file);
                }
            }            
        }
    }
}