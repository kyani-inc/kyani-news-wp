<?php

/*
* Creating a function to create our CPT
*/
add_action('init', 'create_news_post_type', 0);
function create_news_post_type() {
// Set UI labels for Custom Post Type
	$labels = array(
		'name' => _x('News', 'Post Type General Name', 'understrap'),
		'singular_name' => _x('Story', 'Post Type Singular Name', 'understrap'),
		'menu_name' => __('News', 'understrap'),
		'parent_item_colon' => __('Parent Story', 'understrap'),
		'all_items' => __('All News', 'understrap'),
		'view_item' => __('View Story', 'understrap'),
		'add_new_item' => __('Add New Story', 'understrap'),
		'add_new' => __('Add New', 'understrap'),
		'edit_item' => __('Edit News Story', 'understrap'),
		'update_item' => __('Update News Story', 'understrap'),
		'search_items' => __('Search News', 'understrap'),
		'not_found' => __('Not Found', 'understrap'),
		'not_found_in_trash' => __('Not found in Trash', 'understrap'),
	);

	$args = array(
		'label' => __('news', 'understrap'),
		'description' => __('Kyani news', 'understrap'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
		'hierarchical' => true,
		'public' => true,
		'taxonomies' => array('news-categories', 'post_tag'),
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'can_export' => true,
		'has_archive' => 'news',
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'show_in_rest' => true,
		'rewrite' => array('slug' => 'story', 'with_front' => false),
	);

	register_post_type('news', $args);
}

/*
 * End Creating a function to create our CPT
 */


/*
 * Create a function to register CPT Taxonomies
 */
add_action('init', 'create_news_custom_taxonomy', 0);
function create_news_custom_taxonomy() {
	$labels = array(
		'name' => __('News Categories', 'Custom news categories'),
		'singular_name' => __('News Category', 'custom news category'),
		'search_items' => __('Search Categories'),
		'all_items' => __('All Categories'),
		'parent_item' => __('Parent Category'),
		'parent_item_color' => __('Parent Category:'),
		'edit_item' => __('Edit Category'),
		'update_item' => __('Update Category'),
		'add_new_item' => __('Add New Category'),
		'new_item_name' => __('New Category Name'),
		'menu_name' => __('News Categories')
	);

	register_taxonomy('news-categories', array('news'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'show_in_rest' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'news'),
	));
}
/*
 * End Create a function to register CPT Taxonomies
 */
