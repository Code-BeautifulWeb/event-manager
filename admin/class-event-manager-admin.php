<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Code-BeautifulWeb/event-manager
 * @since      1.0.0
 *
 * @package    Event_Manager
 * @subpackage Event_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Event_Manager
 * @subpackage Event_Manager/admin
 * @author     Amit Rana <freelancer.coder123@gmail.com>
 */
class Event_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-manager-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-manager-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * Add Meta Box for schools post type.
	 */
	public function event_manager_add_meta_boxes(){	
		add_meta_box( 'event-manager-school-details', __( 'School Details', 'event-manager' ), array($this, 'em_school_details_content'), 'schools' );
	}
	
	/**
	 * Creates a form within the meta box with placeholder metadata values for 'schools' post.
	 */
	public function em_school_details_content($post){
		
		$post_id = $post->ID;
		$school_name = get_post_meta( $post_id, 'school_name', true );
		$school_org_id = get_post_meta( $post_id, 'school_org_id', true );
		$school_staff_count = get_post_meta( $post_id, 'school_staff_count', true );
		$school_child_count = get_post_meta( $post_id, 'school_child_count', true );
		$school_address = get_post_meta( $post_id, 'school_address', true );
		
		echo '<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="school-name">School Name</label></th>
						<td>
							<input name="school-name" type="text" value="'.$school_name.'" placeholder="School Name" id="school-name" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="school-org-id">Org ID</label></th>
						<td>
							<input name="school-org-id" type="text" value="'.$school_org_id.'" placeholder="Org ID" id="school-org-id" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="school-staff-count">Staff Count</label></th>
						<td>
							<input name="school-staff-count" type="number" value="'.$school_staff_count.'" placeholder="12" id="school-staff-count" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="school-child-count">Child Count</label></th>
						<td>
							<input name="school-child-count" type="number" value="'.$school_child_count.'" placeholder="123" id="school-child-count" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="school-address">Address</label></th>
						<td>
							<input name="school-address" type="text" value="'.$school_address.'" id="school-address" placeholder="123 Education Street, Austin, TX 55555" class="regular-text">
						</td>
					</tr>
				</tbody>
			</table>';
			
	}
	
	/**
	 * Ensures metadata fields for schools post are updated with the sanitized values from the submitted form fields.
	 */
	public function event_manager_save_post_schools($post_id){
		
		if ( get_post_type( $post_id ) !== 'schools' ) return;
		
		if(isset($_POST['school-name'])){			
			update_post_meta( $post_id, 'school_name', sanitize_text_field($_POST['school-name']) );
		}
		if(isset($_POST['school-org-id'])){			
			update_post_meta( $post_id, 'school_org_id', sanitize_text_field($_POST['school-org-id']) );
		}
		if(isset($_POST['school-staff-count'])){			
			update_post_meta( $post_id, 'school_staff_count', sanitize_text_field($_POST['school-staff-count']) );
		}
		if(isset($_POST['school-child-count'])){			
			update_post_meta( $post_id, 'school_child_count', sanitize_text_field($_POST['school-child-count']) );
		}
		if(isset($_POST['school-address'])){			
			update_post_meta( $post_id, 'school_address', sanitize_text_field($_POST['school-address']) );
		}
		
	}

}
