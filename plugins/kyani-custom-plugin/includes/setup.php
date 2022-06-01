<?php

/*
 * Function to use the news archive page as the front page
 */
add_action('pre_get_posts', 'archive_page_as_front_page');
function archive_page_as_front_page($query)
{
	if (is_admin()) return;

	if ($query->get('page_id') == get_option('page_on_front')) {
		$query->set('post_type', 'news');
		$query->set('page_id', '');
		$query->is_page = $query->is_singular = 0;
		$query->is_archive = $query->is_post_type_archive = 1;

		if ($query->get('paged')) {
			$paged = $query->get('paged');
		} elseif ($query->get('page')) {
			$paged = $query->get('page');
		} else {
			$paged = 1;
		}
		$query->set('paged', $paged);
		$query->set('meta_query', array(
			array(
				'key' => 'post_featured',
				'value' => 'no'
			),
			array(
				'relation' => 'OR',
				array(
					'key' => 'backoffice_only_published',
					'value' => 'no'
				),
				array(
					'key' => 'backoffice_only_published',
					'compare' => 'NOT EXISTS'
				)
			)
		));
	}
}

/*
 * End Function to use the news archive page as the front page
 */

/*
 * Remove backoffice only posts
 */
add_action('pre_get_posts', 'news_only_update');
function news_only_update($query)
{
	if (!is_admin() && $query->is_main_query()) {
		if (!is_front_page() && !is_single() && !is_tax() && !is_search()) {
			$query->set('meta_query', array(
				array(
					'key' => 'post_featured',
					'value' => 'no'
				),
				array(
					'relation' => 'OR',
					array(
						'key' => 'backoffice_only_published',
						'value' => 'no'
					),
					array(
						'key' => 'backoffice_only_published',
						'compare' => 'NOT EXISTS'
					)
				)
			));
		} else if (is_tax() || is_search()) {
			$query->set('meta_query', array(
				array(
					'relation' => 'OR',
					array(
						'key' => 'backoffice_only_published',
						'value' => 'no'
					),
					array(
						'key' => 'backoffice_only_published',
						'compare' => 'NOT EXISTS'
					)
				)
			));
		}
	}
}

/*
 * Adds column to news post to show which post are featured
 */
add_filter('manage_news_posts_columns', 'set_custom_edit_news_columns');
function set_custom_edit_news_columns($columns)
{
	unset($columns['news_featured_post']);
	$columns['news_featured_post'] = __('Featured Post', 'your_text_domain');

	unset($columns['backoffice_published']);
	$columns['backoffice_published'] = __('Published to Back Office', 'your_text_domain');

	return $columns;
}

// Add the data to the custom columns for the book post type:
add_action('manage_news_posts_custom_column', 'custom_news_column', 10, 2);
function custom_news_column($column, $post_id)
{
	switch ($column) {

		case 'news_featured_post' :
			$meta = get_post_meta($post_id, 'post_featured', true);
			if (is_string($meta))
				if ($meta === "yes") {
					echo '&#9989;';
				} else {
					echo "";
				}
			else
				_e('Unable to get featured post', 'your_text_domain');
			break;
		case 'backoffice_published' :
			$published = get_post_meta($post_id, 'backoffice_published', true);
			if (is_string($published))
				if ($published === "yes") {
					echo '&#9989;';
				} else {
					echo "";
				}
			else
				_e('Unable to get back office setting');
			break;
	}
}

/*
 * End Adds column to news post to show which post are featured
 */

/*
 * CORS policy
 */
add_action('init', 'add_cors_http_header');
function add_cors_http_header()
{
	header('Access-Control-Allow-Origin: *');
}
