<?php
/*
Plugin Name: CryptoBox
Plugin URI:  https://github.com/wildlatina/cryptobox
Description: Cryptobox is a wordpress plugin that uses a cryptocurrency paywall. Users have to pay in Bitcoin or Dash to unlock the paywall to access the content.
Version:     0.1
Author:
Author URI:
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'CRYPTOBOX_NAME',                 'WordPress Plugin Skeleton' );
define( 'CRYPTOBOX_REQUIRED_PHP_VERSION', '5.3' );                          // because of get_called_class()
define( 'CRYPTOBOX_REQUIRED_WP_VERSION',  '3.1' );                          // because of esc_textarea()

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function cryptobox_requirements_met() {
	global $wp_version;
	//require_once( ABSPATH . '/wp-admin/includes/plugin.php' );		// to get is_plugin_active() early

	if ( version_compare( PHP_VERSION, CRYPTOBOX_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, CRYPTOBOX_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	/*
	if ( ! is_plugin_active( 'plugin-directory/plugin-file.php' ) ) {
		return false;
	}
	*/

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function cryptobox_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( cryptobox_requirements_met() ) {
	require_once( __DIR__ . '/classes/cryptobox-module.php' );
	require_once( __DIR__ . '/classes/cryptobox-plugin.php' );
	require_once( __DIR__ . '/includes/admin-notice-helper/admin-notice-helper.php' );
	require_once( __DIR__ . '/classes/cryptobox-custom-post-type.php' );
	require_once( __DIR__ . '/classes/cryptobox-cpt-example.php' );
	require_once( __DIR__ . '/classes/cryptobox-settings.php' );
	require_once( __DIR__ . '/classes/cryptobox-cron.php' );
	require_once( __DIR__ . '/classes/cryptobox-instance-class.php' );

	if ( class_exists( 'Cryptobox_Plugin' ) ) {
		$GLOBALS['cryptobox'] = Cryptobox_Plugin::get_instance();
		register_activation_hook(   __FILE__, array( $GLOBALS['cryptobox'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['cryptobox'], 'deactivate' ) );
	}
} else {
	add_action( 'admin_notices', 'cryptobox_requirements_error' );
}
