<?php

/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

// Check for Redux Framework

if ( !defined ( 'ABSPATH' ) ) {
	die;
}

if ( !class_exists ( 'PE_ReduxCheck' ) ) {

	class PE_ReduxCheck {

		function __construct() {
			$this->do_check();
		}

		public function do_check() {
			PE_MainClass::$_redux_installed = true;

			if ( !$this->is_plugin_exist ( 'redux-framework/redux-framework.php' ) && !class_exists ( 'ReduxFramework' ) ) {
				$this->not_installed();
				PE_MainClass::$_redux_installed = false;
			} elseif ( $this->is_plugin_exist ( 'redux-framework/redux-framework.php' ) && !class_exists ( 'ReduxFramework' ) ) {
				$this->not_active();
				PE_MainClass::$_redux_installed = false;
			}
		}

		private function not_installed() {
			if ( ! isset ( $_GET['page'] ) || ( isset ( $_GET['page'] ) && $_GET['page'] != 'install-required-plugins' ) ) {
				add_action ( 'admin_notices', array( $this, 'notice_not_exists' ) );
			}
		}

		private function not_active() {
			if ( ! isset ( $_GET['page'] ) || ( isset ( $_GET['page'] ) && $_GET['page'] != 'install-required-plugins' ) ) {
				add_action ( 'admin_notices', array( $this, 'notice_inactive' ) );
			}
		}

		private function is_network() {
			$network = '';

			if ( is_multisite() ) {
				$network = 'network/';
			}

			return $network;
		}

		public function notice_not_exists () {
			echo '<div class="notice notice-error is-dismissible"><p><strong>';
			echo __( 'Redux Framework installation required by ' . PE_MainClass::$_name, 'pe-simple-demo-importer' );
			echo '</strong></p><p>';
			echo sprintf( "<a class='button-primary' href='%s'>%s</a>", admin_url( $this->is_network() . 'plugin-install.php?tab=search&type=term&s=redux+framework' ), __( 'Click here to search for the plugin.', 'pe-simple-demo-importer' ) );
			echo '</p></div>';
		}

		public function notice_inactive () {
			echo '<div class="notice notice-error is-dismissible"><p><strong>';
			echo __( 'Redux Framework activation required by ' . PE_MainClass::$_name, 'pe-simple-demo-importer' );
			echo '</strong></p><p>';
			echo sprintf( "<a class='button-primary' href='%s'>%s</a>", admin_url( $this->is_network() . 'plugins.php?plugin_status=inactive' ), __( 'Click here to go to the plugins page and activate it.', 'pe-simple-demo-importer' ) );
			echo '</p></div>';
		}

		public function is_plugin_exist ( $needle ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			$all_plugins = get_plugins ();

			if ( isset ( $all_plugins[ $needle ] ) ) {
				return true;
			} else {
				return false;
			}
		}
	}

	new PE_ReduxCheck();
}
