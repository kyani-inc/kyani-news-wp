<?php

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
		$content .= '<p class="hide-if-no-js"><p>' . esc_html__('Required Size - (1300px x 890px)', 'text-domain') . '</p><a title="' . esc_attr__('Set listing image', 'text-domain') . '" href="javascript:;" id="upload_listing_image_button" id="set-listing-image" data-uploader_title="' . esc_attr__('Choose an image', 'text-domain') . '" data-uploader_button_text="' . esc_attr__('Set Custom Thumbnail Image', 'text-domain') . '">' . esc_html__('Set Custom Thumbnail Image', 'text-domain') . '</a></p>';
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
	$featured = get_post_meta($post->ID);
	$post_featured = get_post_meta($post->ID, 'post_featured', true);
	$backoffice_published = get_post_meta($post->ID, 'backoffice_published', true);
	$backoffice_widget_published = get_post_meta($post->ID, 'backoffice_widget_published', true);
	$backoffice_featured_published = get_post_meta($post->ID, 'backoffice_featured_published', true);


	$html = "";

	//Featured post (radio)
	$html .= '<p>';
	$html .= '<p><strong>Featured Post?</strong></p>';
	$html .= '<label for="post_featured_no">';
	if ($post_featured == 'no' || empty($post_featured)) {
		$html .= '<input type="radio" checked name="post_featured" id="post_featured_no" value="no"/>';
	} else {
		$html .= '<input type="radio" name="post_featured" id="post_featured_no" value="no"/>';
	}
	$html .= ' No</label>';
	$html .= '</br>';
	$html .= '<label for="post_featured_yes">';
	if ($post_featured == 'yes') {
		$html .= '<input type="radio" checked name="post_featured" id="post_featured_yes" value="yes"/>';
	} else {
		$html .= '<input type="radio" name="post_featured" id="post_featured_yes" value="yes"/>';
	}
	$html .= ' Yes</label>';
	$html .= '</p>';

	// Back Office News (radio)
	$html .= '<p>';
	$html .= '<p><strong>Display in BackOffice?</strong></p>';
	$html .= '<label for="backoffice_published_no">';
	if ($backoffice_published == 'no' || empty($backoffice_published)) {
		$html .= '<input type="radio" checked name="backoffice_published" id="backoffice_published_no" value="no"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_published" id="backoffice_published_no" value="no"/>';
	}
	$html .= ' No</label>';
	$html .= '</br>';
	$html .= '<label for="backoffice_published_yes">';
	if ($backoffice_published == 'yes') {
		$html .= '<input type="radio" checked name="backoffice_published" id="backoffice_published_yes" value="yes"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_published" id="backoffice_published_yes" value="yes"/>';
	}
	$html .= ' Yes</label>';
	$html .= '</p>';

	// Back Office Widget (radio)
	$html .= '<p>';
	$html .= '<p><strong>Display in BackOffice Widget?</strong></p>';
	$html .= '<label for="backoffice_widget_published_no">';
	if ($backoffice_widget_published == 'no' || empty($backoffice_widget_published)) {
		$html .= '<input type="radio" checked name="backoffice_widget_published" id="backoffice_widget_published_no" value="no"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_widget_published" id="backoffice_widget_published_no" value="no"/>';
	}
	$html .= ' No</label>';
	$html .= '</br>';
	$html .= '<label for="backoffice_widget_published_yes">';
	if ($backoffice_widget_published == 'yes') {
		$html .= '<input type="radio" checked name="backoffice_widget_published" id="backoffice_widget_published_yes" value="yes"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_widget_published" id="backoffice_widget_published_yes" value="yes"/>';
	}
	$html .= ' Yes</label>';
	$html .= '</p>';

	// Back Office Featured (radio)
	$html .= '<p>';
	$html .= '<p><strong>Feature in BackOffice?</strong></p>';
	$html .= '<label for="backoffice_featured_published_no">';
	if ($backoffice_featured_published == 'no' || empty($backoffice_featured_published)) {
		$html .= '<input type="radio" checked name="backoffice_featured_published" id="backoffice_featured_published_no" value="no"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_featured_published" id="backoffice_featured_published_no" value="no"/>';
	}
	$html .= ' No</label>';
	$html .= '</br>';
	$html .= '<label for="backoffice_featured_published_yes">';
	if ($backoffice_featured_published == 'yes') {
		$html .= '<input type="radio" checked name="backoffice_featured_published" id="backoffice_featured_published_yes" value="yes"/>';
	} else {
		$html .= '<input type="radio" name="backoffice_featured_published" id="backoffice_featured_published_yes" value="yes"/>';
	}
	$html .= ' Yes</label>';
	$html .= '</p>';

	echo $html;

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

	$featured_post = isset($_POST['post_featured']) ? sanitize_text_field($_POST['post_featured']) : '';
	$back_office = isset($_POST['backoffice_published']) ? sanitize_text_field($_POST['backoffice_published']) : '';
	$back_office_widget = isset($_POST['backoffice_widget_published']) ? sanitize_text_field($_POST['backoffice_widget_published']) : '';
	$back_office_featured = isset($_POST['backoffice_featured_published']) ? sanitize_text_field($_POST['backoffice_featured_published']) : '';

	update_post_meta($post_id, 'post_featured', $featured_post);
	update_post_meta($post_id, 'backoffice_published', $back_office);
	update_post_meta($post_id, 'backoffice_widget_published', $back_office_widget);
	update_post_meta($post_id, 'backoffice_featured_published', $back_office_featured);
}
/**
 * End Saves the custom meta input
 */
