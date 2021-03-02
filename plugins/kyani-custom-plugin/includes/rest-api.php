<?php

/*
 * Custom API endpoint
 */
add_action('rest_api_init', 'register_backoffice_rest_route');
function register_backoffice_rest_route() {
	register_rest_route('api', 'backoffice', array(
		'methods' => 'GET',
		'callback' => 'get_backoffice_news',
		'permission_callback' => '__return_true',
		'args' => get_collection_params()
	));

	register_rest_route('api', 'backoffice/widget', array(
		'methods' => 'GET',
		'callback' => 'get_backoffice_widget',
		'permission_callback' => '__return_true'
	));

	register_rest_route('api', 'backoffice/featured', array(
		'method' => 'GET',
		'callback' => 'get_backoffice_featured',
		'permission_callback' => '__return_true'
	));
}

// https://news.kyani.com/us/wp-json/api/backoffice
// this returns posts that are not featured posts in the news report
function get_backoffice_news($request) {
	$args = array(
		'post_type' => 'news',
		'posts_per_page' => $request['per_page'],
		'paged' => $request['page'],
		'meta_query' => array(
			array(
				'key' => 'backoffice_published',
				'value' => 'yes'
			),
			array(
				'key' => 'backoffice_featured_published',
				'value' => 'no'
			)
		),
		'suppress_filters' => 0
	);

	$query = new WP_Query($args);

	if (empty($query->posts)) {
		return new WP_Error('no_posts', __('No post found'), array('status' => 404));
	}

	$resp = array();
	$posts = $query->posts;
	$max_pages = $query->max_num_pages;
	$total = $query->found_posts;

	foreach ($posts as $post) {
		$thumbnail_id = get_post_meta($post->ID, "_listing_image_id", true);
		$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, "full");
		if ($thumbnail_url === false) {
			$thumbnail_url = get_the_post_thumbnail_url($post->ID, "thumbnail");
		}

		$resp[$post->ID]['title'] = $post->post_title;
		$resp[$post->ID]['excerpt'] = get_the_excerpt();
		$resp[$post->ID]['postedDate'] = $post->post_date;
		$resp[$post->ID]['thumbnailUrl'] = $thumbnail_url;
	}

	$response = new WP_REST_Response($resp, 200);
	$response->header('X-WP-Total', $total);
	$response->header('X-WP_TotalPages', $max_pages);

	return $response;
}

function get_backoffice_widget() {
	$args = array(
		'post_type' => 'news',
		'meta_query' => array(
			array(
				'key' => 'backoffice_widget_published',
				'value' => 'yes'
			),
		),
		'suppress_filters' => 0
	);

	$query = new WP_Query($args);

	if (empty($query->posts)) {
		return new WP_Error('no_posts', __('No post found'), array('status' => 404));
	}

	$resp = array();
	$posts = $query->posts;

	foreach ($posts as $post) {
		$thumbnail_id = get_post_meta($post->ID, "_listing_image_id", true);
		$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, "full");
		if ($thumbnail_url === false) {
			$thumbnail_url = get_the_post_thumbnail_url($post->ID, "thumbnail");
		}

		$resp[$post->ID]['title'] = $post->post_title;
		$resp[$post->ID]['postedDate'] = $post->post_date;
		$resp[$post->ID]['thumbnailUrl'] = $thumbnail_url;
	}

	return new WP_REST_Response($resp, 200);
}

function get_backoffice_featured() {
	$args = array(
		'post_type' => 'news',
		'meta_query' => array(
			array(
				'key' => 'backoffice_featured_published',
				'value' => 'yes'
			)
		),
		'suppress_filters' => 0
	);

	$query = new WP_Query($args);

	if (empty($query->posts)) {
		return new WP_Error('no_posts', __('No post found'), array('status' => 404));
	}

	$resp = array();
	$posts = $query->posts;

	foreach ($posts as $post) {
		$banner_url = get_the_post_thumbnail_url($post->ID, "full");
		$thumbnail_id = get_post_meta($post->ID, "_listing_image_id", true);
		$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, "full");

		if ($thumbnail_url === false) {
			$thumbnail_url = get_the_post_thumbnail_url($post->ID, "thumbnail");
		}

		$resp[$post->ID]['title'] = $post->post_title;
		$resp[$post->ID]['postedDate'] = $post->post_date;
		$resp[$post->ID]['bannerURL'] = $banner_url;
		$resp[$post->ID]['thumbnailURL'] = $thumbnail_url;

	}

	return new WP_REST_Response($resp, 200);
}

/*
 * End Custom API endpoint
 */

function get_collection_params(): array {
	return array(
		'page' => array(
			'description' => 'Current page of the collection.',
			'type' => 'integer',
			'default' => 1,
			'sanitize_callback' => 'absint',
		),
		'per_page' => array(
			'description' => 'Maximum number of items to be returned in result set.',
			'type' => 'integer',
			'default' => 20,
			'sanitize_callback' => 'absint',
		),
	);
}
