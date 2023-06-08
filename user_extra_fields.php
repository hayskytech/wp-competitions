<?php
/* -- ADMIN can edit all user profiles from dashboard with these lines. -- */
add_action('edit_user_profile_update', 'save_extra_user_profile_fields_ylf');
add_action('edit_user_profile', 'extra_user_profile_fields_ylf');

/* -- Actual Code starts here -- */
function save_extra_user_profile_fields_ylf($user_id) {
	if (!current_user_can('edit_user', $user_id)) {
		return false;
	}
	update_user_meta($user_id, 'com_membership_expiry', $_POST["com_membership_expiry"]);
}

function extra_user_profile_fields_ylf($user) {
	$user_id = $user->ID;
	?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
	<h3>Extra profile information</h3>
	<table class="form-table">
		<tr>
			<td>Com Membership Expiry</td>
			<td><input type="date" name="com_membership_expiry" class="regular-text"
					value="<?php echo get_the_author_meta('com_membership_expiry', $user->ID); ?>">
			</td>
		</tr>
	</table>
	<?php
}

/* -- Add extra columns to "Users Lists" in Admin Dashboard -- */
add_filter('manage_users_columns', 'new_modify_user_table_ylf');
add_filter('manage_users_custom_column', 'new_modify_user_table_row_ylf', 10, 3);

function new_modify_user_table_ylf($column) {
	$column['com_membership_expiry'] = 'Com Membership Expiry';
	return $column;
}
function new_modify_user_table_row_ylf($val, $column_name, $user_id) {
	$meta = get_user_meta($user_id);
	switch ($column_name) {
		case 'com_membership_expiry':
			return $meta['com_membership_expiry'][0];
		default:
	}
	return $val;
}
?>