<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Event_Manager
 * @subpackage Event_Manager/public
 * @author     Amit Rana <freelancer.coder123@gmail.com>
 */
class Event_Manager_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-manager-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-manager-public.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	* Register school custom post type.
	*/
	public function event_manager_init() {	
		$labels = array(
			'name'                  => _x( 'Schools', 'Post type general name', 'event-manager' ),
			'singular_name'         => _x( 'School', 'Post type singular name', 'event-manager' ),
			'menu_name'             => _x( 'Schools', 'Admin Menu text', 'event-manager' ),
			'name_admin_bar'        => _x( 'School', 'Add New on Toolbar', 'event-manager' ),
			'add_new'               => __( 'Add New', 'event-manager' ),
			'add_new_item'          => __( 'Add New School', 'event-manager' ),
			'new_item'              => __( 'New School', 'event-manager' ),
			'edit_item'             => __( 'Edit School', 'event-manager' ),
			'view_item'             => __( 'View School', 'event-manager' ),
			'all_items'             => __( 'All Schools', 'event-manager' ),
			'search_items'          => __( 'Search Schools', 'event-manager' ),
			'parent_item_colon'     => __( 'Parent Schools:', 'event-manager' ),
			'not_found'             => __( 'No Schools found.', 'event-manager' ),
			'not_found_in_trash'    => __( 'No Schools found in Trash.', 'event-manager' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'schools' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-admin-multisite',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'show_in_rest'       => false,
		);
		
		register_post_type( 'schools', $args );
	

	}
	
	/**
	* Generate a field for selecting a school at registration form populated in the dropdown from 'schools' post type.
	*/
	public function event_manager_register_form(){
		
		$school_field = ! empty( $_POST['school_field'] ) ? intval( $_POST['school_field'] ) : '';
		$schools = get_posts( 
					array(	'post_type'=> 'schools', 
							'post_status'=> 'publish', 
							'suppress_filters' => false, 
							'posts_per_page'=>-1
						)
				);
		?>
		<p>
			<label for="school_field"><?php esc_html_e( 'Choose a School', 'event-manager' ) ?></label><br/>
			<select name="school_field" id="school_field">
				<option value = "" ><?php esc_html_e( 'Choose a School', 'event-manager' ) ?></option>
				<?php
				  foreach($schools as $school) {
					$selected = ($school_field == $school->ID) ? ' selected="selected"' : '';
					echo '<option value="'.$school->ID.'" '.$selected.'>'.$school->post_title.'</option>';
				  }
				?>
			</select>
			
		</p>
		<style>
		#registerform #school_field{
			line-height: 1.33333333;
			width: 100%;
			border-width: 0.0625rem;
			padding: 0.1875rem 0.3125rem;
			margin: 0 6px 16px 0;
			min-height: 40px;
			max-height: none;
		 }
		</style>
		<?php
		
	}
	
	/**
	* Generate validation error on registration page.
	*/
	public function event_manager_registration_errors($errors, $sanitized_user_login, $user_email){
		if ( empty( $_POST['school_field'] ) ) {
			$errors->add( 'school_field_error', __( '<strong>Error</strong>: Please choose a school.', 'event-manager' ) );
		}
		return $errors;
	}
	
	/**
	* Set account status 'pending; upon registration.
	*/
	public function save_user_register( $user_id ) {
		if ( ! empty( $_POST['school_field'] ) ) {
			update_user_meta( $user_id, 'school_id', intval( $_POST['school_field'] ) );
			update_user_meta( $user_id, 'account_status', 'pending' );
		}
	}
	
	/**
	* Set account status 'active' after successful login.
	*/
	public function event_manager_active_status( $user_login, $user ) {
		$account_status = get_user_meta( $user->ID, 'account_status', true );
		if($account_status == 'pending'){		
			update_user_meta( $user->ID, 'account_status', 'active');
		}
	}
	
	/**
	* Set page template for Dashboard Page.
	*/
	public function event_manager_page_template( $page_template ){
		if ( is_page( 'em-dashboard' ) ) {
			$page_template = dirname( __FILE__ ) . '/partials/event-manager-public-display.php';
		}
		return $page_template;
	}

	/**
	* Callback shortcode.
	*/
	public function event_manager_shortcode_content( ){
		ob_start();
		include dirname( __FILE__ ) . '/partials/event-manager-public-display.php';
		return ob_get_clean();
	}

}
