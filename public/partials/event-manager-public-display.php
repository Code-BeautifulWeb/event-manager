<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/Code-BeautifulWeb/event-manager
 * @since      1.0.0
 *
 * @package    Event_Manager
 * @subpackage Event_Manager/public/partials
 */
 
$user_id = get_current_user_id();
$school_id = get_user_meta( $user_id, 'school_id', true );
$school_name = get_post_meta( $school_id, 'school_name', true );
$school_org_id = get_post_meta( $school_id, 'school_org_id', true );
$school_staff_count = get_post_meta( $school_id, 'school_staff_count', true );
$school_child_count = get_post_meta( $school_id, 'school_child_count', true );
$school_address = get_post_meta( $school_id, 'school_address', true );
?>
<div class="em-dashboard">
	<div class="em-dashboard-nav">
		<ul>
			<li class="active"><?php esc_html_e( 'School Details', 'event-manager' ) ?></li>
			<li><a href="<?php echo wp_logout_url( home_url()); ?>" title="Logout"><?php esc_html_e( 'Logout', 'event-manager' ) ?></a></li>
		</ul>
	</div>
	<div class="em-dashboard-content">
		<table class="form-school-details">
			<tbody>
				<tr>
					<td class="label"><?php esc_html_e( 'School Name', 'event-manager' ) ?></td>
					<td><?php echo $school_name; ?></td>
				</tr>
				<tr>
					<td class="label"><?php esc_html_e( 'Org ID', 'event-manager' ) ?></td>
					<td><?php echo $school_org_id; ?></td>
				</tr>
				<tr>
					<td class="label"><?php esc_html_e( 'Staff Count', 'event-manager' ) ?></td>
					<td><?php echo $school_staff_count; ?></td>
				</tr>
				<tr>
					<td class="label"><?php esc_html_e( 'Child Count', 'event-manager' ) ?></td>
					<td><?php echo $school_child_count; ?></td>
				</tr>
				<tr>
					<td class="label"><?php esc_html_e( 'Address', 'event-manager' ) ?></td>
					<td><?php echo $school_address; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>