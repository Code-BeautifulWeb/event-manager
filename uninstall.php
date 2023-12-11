<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/Code-BeautifulWeb/event-manager
 * @since      1.0.0
 *
 * @package    Event Manager
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
