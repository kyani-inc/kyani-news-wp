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


/*
 * Function to use the news archive page as the front page
 */
add_action('pre_get_posts', 'archive_page_as_front_page');
function archive_page_as_front_page($query) {
	if (is_admin()) return;

	if ($query->get('page_id') == get_option('page_on_front')) {
		$query->set('post_type', 'news');
		$query->set('page_id', '');
		$query->is_page = $query->is_singular = 0;
		$query->is_archive = $query->is_post_type_archive = 1;
	}
}

/*
 * End Function to use the news archive page as the front page
 */




/*
 * Adds column to news post to show which post are featured
 */
add_filter('manage_news_posts_columns', 'set_custom_edit_news_columns');
function set_custom_edit_news_columns($columns) {
	unset($columns['news_featured_post']);
	$columns['news_featured_post'] = __('Featured Post', 'your_text_domain');

	return $columns;
}

// Add the data to the custom columns for the book post type:
add_action('manage_news_posts_custom_column', 'custom_news_column', 10, 2);
function custom_news_column($column, $post_id) {
	switch ($column) {

		case 'news_featured_post' :
			$meta = get_post_meta($post_id, 'meta-checkbox', true);
			if (is_string($meta))
				if ($meta === "yes") {
					echo '&#9989;';
				} else {
					echo $meta;
				}
			else
				_e('Unable to get featured post', 'your_text_domain');
			break;
	}
}

/*
 * End Adds column to news post to show which post are featured
 */


/*
 * Add meta-box for thumbnail image
 */
add_action('add_meta_boxes', 'listing_image_add_metabox');
function listing_image_add_metabox() {
	add_meta_box('listingimagediv', __('Custom Thumbnail Image', 'text-domain'), 'listing_image_metabox', 'news', 'side', 'high');
}

function listing_image_metabox($post) {
	global $content_width, $_wp_additional_image_sizes;

	$image_id = get_post_meta($post->ID, '_listing_image_id', true);

	$old_content_width = $content_width;
	$content_width = 254;

	if ($image_id && get_post($image_id)) {

		if (!isset($_wp_additional_image_sizes['post-thumbnail'])) {
			$thumbnail_html = wp_get_attachment_image($image_id, array($content_width, $content_width));
		} else {
			$thumbnail_html = wp_get_attachment_image($image_id, 'post-thumbnail');
		}

		if (!empty($thumbnail_html)) {
			$content = $thumbnail_html;
			$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_listing_image_button" >' . esc_html__('Remove Custom Thumbnail Image', 'text-domain') . '</a></p>';
			$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="' . esc_attr($image_id) . '" />';
		}

		$content_width = $old_content_width;
	} else {

		$content = '<img src="" style="width:' . esc_attr($content_width) . 'px;height:auto;border:0;display:none;" />';
		$content .= '<p class="hide-if-no-js"><p>' . esc_html__('Recommended Size - (170px x 170px)', 'text-domain') . '</p><a title="' . esc_attr__('Set listing image', 'text-domain') . '" href="javascript:;" id="upload_listing_image_button" id="set-listing-image" data-uploader_title="' . esc_attr__('Choose an image', 'text-domain') . '" data-uploader_button_text="' . esc_attr__('Set Custom Thumbnail Image', 'text-domain') . '">' . esc_html__('Set Custom Thumbnail Image', 'text-domain') . '</a></p>';
		$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="" />';

	}

	echo $content;
}

add_action('save_post', 'listing_image_save', 10, 1);
function listing_image_save($post_id) {
	if (isset($_POST['_listing_cover_image'])) {
		$image_id = (int)$_POST['_listing_cover_image'];
		update_post_meta($post_id, '_listing_image_id', $image_id);
	}
}

function add_admin_scripts($hook) {

	global $post;

	if ($hook == "post-new.php" || $hook == "post.php") {
		if ("news" === $post->post_type) {
			wp_enqueue_script("myscript", get_stylesheet_directory_uri() . "/js/scripts.js");
		}
	}
}

add_action("admin_enqueue_scripts", "add_admin_scripts", 10, 1);

/*
 * End Add meta-box for thumbnail image
 */


/*
 * Custom API endpoint
 */
add_action('rest_api_init','register_backoffice_rest_route');
function register_backoffice_rest_route() {
	register_rest_route('api', 'backoffice', array(
		'methods' => 'GET',
		'callback' => 'get_backoffice_news',
		'permission_callback' => '__return_true'
	));
}

function get_backoffice_news($request){
	$args = array(
		'numberposts' => -1,
		'post_type' => 'news',
		'meta_key' => 'backoffice-checkbox',
		'meta_value' => 'yes',
	);

	$resp = array();
	$posts = get_posts($args);

	if(empty($posts)){
		return new WP_Error('empty_post_type', 'there are no news posts for backoffice');
	}

	foreach ($posts as $post) {
		$thumbnail_id = get_post_meta($post->ID, "_listing_image_id", true);
		$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, "full");

		$banner_url = get_the_post_thumbnail_url($post->ID, "full");

		$resp[$post->ID]['title'] = $post->post_title;
		$resp[$post->ID]['content'] = $post->post_content;
		$resp[$post->ID]['posted-date'] = $post->post_date;
		$resp[$post->ID]['thumbnail-url'] = $thumbnail_url;
		$resp[$post->ID]['banner-url'] = $banner_url;

	}

	wp_reset_postdata();
	return rest_ensure_response( $resp );
}

/*
 * End Custom API endpoint
 */


/*
 * Create custom meta box for featured posts
 */
add_action('add_meta_boxes', 'backoffice_meta_box');
function backoffice_meta_box() {
	add_meta_box('backoffice_meta', __('Additional Options'), 'backoffice_meta_display', 'news', 'side', 'high');
}

/*
 * End Create custom meta box for featured posts
 */


/*
 * Display check box in metabox for featured post
 */
function backoffice_meta_display($post) {
	$featured = get_post_meta($post->ID); ?>

	<p>
	<div class="sm-row-content">
		<label for="backoffice-checkbox">
			<input type="checkbox" name="backoffice-checkbox" id="backoffice-checkbox"
				   value="yes" <?php if (isset ($featured['backoffice-checkbox'])) checked($featured['backoffice-checkbox'][0], 'yes'); ?> />
			<?php _e('Add to Back Office', 'sm-textdomain') ?>
		</label>
	</div>
	</p>

	<p>
	<div class="sm-row-content">
		<label for="meta-checkbox">
			<input type="checkbox" name="meta-checkbox" id="meta-checkbox"
				   value="yes" <?php if (isset ($featured['meta-checkbox'])) checked($featured['meta-checkbox'][0], 'yes'); ?> />
			<?php _e('Featured this post', 'sm-textdomain') ?>
		</label>
	</div>
	</p>

	<?php
}

/*
 * End Display check box in metabox for featured post
 */


/**
 * Saves the custom meta input
 */
add_action('save_post', 'sm_meta_save');
function sm_meta_save($post_id) {

	// Checks save status
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset($_POST['sm_nonce']) && wp_verify_nonce($_POST['sm_nonce'], basename(__FILE__))) ? 'true' : 'false';

	// Exits script depending on save status
	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}

	$featured_post = (isset($_POST['meta-checkbox']) ? 'yes' : '');
	$back_office = (isset($_POST['backoffice-checkbox']) ? 'yes' : '');

	update_post_meta($post_id, 'meta-checkbox', $featured_post);
	update_post_meta($post_id, 'backoffice-checkbox', $back_office);
}

/**
 * End Saves the custom meta input
 */
