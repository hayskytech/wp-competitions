<?php

add_action("init", function () {
	// Set labels for Application
	$labels = array(
		"name" => "Applications",
		"singular_name" => "Application",
		"add_new" => "Add Application",
		"add_new_item" => "Add New Application",
		"all_items" => "All Applications",
		"edit_item" => "Edit Application",
		"new_item" => "New Application",
		"view_item" => "View Application",
		"search_items" => "Search Applications",
	);
	// Set Options for Application
	$args = array(
		"public" => true,
		"label" => "Applications",
		"labels" => $labels,
		"description" => "Applications custom post type.",
		"menu_icon" => "dashicons-admin-post",
		"supports" => array("title", "editor", "thumbnail", "author", "custom-fields"),
		"capability_type" => "post",
		"publicly_queryable" => false,
		"show_in_rest" => true,
		"exclude_from_search" => true
	);
	register_post_type("application", $args);
	$meta_args = array('type' => 'string', 'single' => true, 'object_subtype' => '', 'show_in_rest' => true);
	register_post_meta('application', 'competition', $meta_args);

});