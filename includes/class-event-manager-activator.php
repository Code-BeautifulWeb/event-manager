<?php

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Event_Manager
 * @subpackage Event_Manager/includes
 * @author     Amit Rana <freelancer.coder123@gmail.com>
 */
class Event_Manager_Activator {

	public static function activate() {
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'events';
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE $table_name (
			id bigint(9) NOT NULL AUTO_INCREMENT,
			event_name tinytext NOT NULL,
			event_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			event_location tinytext NOT NULL,
			event_school int(10) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		
		
		$page_slug = 'em-dashboard';
		$user_id = get_current_user_id();
		$new_page = array(
			'post_type'     => 'page', 				
			'post_title'    => 'Dashboard',	
			'post_content'  => '[em-dashboard]',	
			'post_status'   => 'publish',			
			'post_author'   => $user_id,					
			'post_name'     => $page_slug			
		);

		if (!get_page_by_path( $page_slug, OBJECT, 'page')) {
			$page_id = wp_insert_post($new_page);
			update_option('em_dashboard_page',$page_id);
		}
		
	}

}
