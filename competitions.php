<?php
add_action("init", function () {
	// Set labels for competition
	$labels = array(
		"name" => "Competitions",
		"singular_name" => "Competition",
		"add_new" => "Add Competition",
		"add_new_item" => "Add New Competition",
		"all_items" => "All Competitions",
		"edit_item" => "Edit Competition",
		"new_item" => "New Competition",
		"view_item" => "View Competition",
		"search_items" => "Search Competitions",
	);
	// Set Options for competition
	$args = array(
		"public" => true,
		"label" => "Competitions",
		"labels" => $labels,
		"description" => "Competitions custom post type.",
		"menu_icon" => "dashicons-admin-post",
		"supports" => array("title", "editor", "thumbnail", 'custom_fields',"attachment"),
		"capability_type" => "post",
		"publicly_queryable" => true,
		'show_in_rest' => true,
		"exclude_from_search" => false
	);
	register_post_type("competition", $args);
	$meta_args = array('type' => 'string', 'single' => true, 'object_subtype' => '', 'show_in_rest' => true);
	register_post_meta('competition', 'entries', $meta_args);
	register_post_meta('competition', 'deadling', $meta_args);

});

add_action("add_meta_boxes", function () {
	add_meta_box(
		"post-meta-fields-yic",
		"Post Meta Fields ",
		// Creates Metabox Callback Function
		function () {
			global $post;
			wp_enqueue_script("jquery");
			$meta = get_post_meta($post->ID);
			$data["entries"] = $meta["entries"][0];
			$data["deadline"] = $meta["deadline"][0];
			?>
		<table>
			<tr>
				<td>Entries</td>
				<td><input type="text" name="entries">
				</td>
			</tr>
			<tr>
				<td>Deadline</td>
				<td><input type="date" name="deadline">
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			document.querySelector('input[name=entries]').value = '<?php echo $data["entries"]; ?>';
			document.querySelector('input[name=deadline]').value = '<?php echo $data["deadline"]; ?>';
		</script>
		<?php
		},
		"competition",
		// change "post" to "some other post_type"
		"side",
		"high"
	);

	add_meta_box(
		"post-meta-fields",
		"Post Meta Fields ",
		"list_of_applications",
		"competition",
		// change "post" to "some other post_type"
		"side",
		"high"
	);
});

add_action("save_post", function () {
	if (isset($_POST["post_type"])) {
		if ("competition" == $_POST["post_type"]) { // change "post" to "some other post_type"
			global $post;
			update_post_meta($post->ID, "entries", $_POST["entries"]);
			update_post_meta($post->ID, "deadline", $_POST["deadline"]);
		}
	}
});


function list_of_applications() {
	?>
	<h1>Haysky Computer Coaching</h1>
	<p>saidu gasd			<b>a duhda</b>	</p>
<?php
}