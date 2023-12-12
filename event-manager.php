<?php

/**
 * Plugin Name:       Event Manager
 * Plugin URI:        https://github.com/Code-BeautifulWeb/event-manager
 * Description:       An Event Management Plugin for Schools.
 * Version:           1.0.0
 * Author:            Amit Rana
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       event-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'EVENT_MANAGER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-event-manager-activator.php
 */
function activate_event_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-manager-activator.php';
	Event_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-event-manager-deactivator.php
 */
function deactivate_event_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-manager-deactivator.php';
	Event_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_event_manager' );
register_deactivation_hook( __FILE__, 'deactivate_event_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event-manager.php';

/**
 * Begins execution of the plugin.
 */
function run_event_manager() {

	$plugin = new Event_Manager();
	$plugin->run();

}
run_event_manager();
