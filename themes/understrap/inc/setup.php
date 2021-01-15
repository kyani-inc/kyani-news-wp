<?php
/**
 * Theme basic setup
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_action( 'after_setup_theme', 'understrap_setup' );

if ( ! function_exists( 'understrap_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function understrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on understrap, use a find and replace
		 * to change 'understrap' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'understrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'understrap' ),
				'secondary' => __('Secondary Menu', 'understrap' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'understrap_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Check and setup theme default settings.
		understrap_setup_theme_default_settings();

		/*
* Creating a function to create our CPT
*/

		function custom_post_type() {

// Set UI labels for Custom Post Type
			$labels = array(
				'name'                => _x( 'News', 'Post Type General Name', 'understrap' ),
				'singular_name'       => _x( 'Story', 'Post Type Singular Name', 'understrap' ),
				'menu_name'           => __( 'News', 'understrap' ),
				'parent_item_colon'   => __( 'Parent Story', 'understrap' ),
				'all_items'           => __( 'All News', 'understrap' ),
				'view_item'           => __( 'View Story', 'understrap' ),
				'add_new_item'        => __( 'Add New Story', 'understrap' ),
				'add_new'             => __( 'Add New', 'understrap' ),
				'edit_item'           => __( 'Edit News Story', 'understrap' ),
				'update_item'         => __( 'Update News Story', 'understrap' ),
				'search_items'        => __( 'Search News', 'understrap' ),
				'not_found'           => __( 'Not Found', 'understrap' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'understrap' ),
			);

// Set other options for Custom Post Type

			$args = array(
				'label'               => __( 'news', 'understrap' ),
				'description'         => __( 'Kyani news', 'understrap' ),
				'labels'              => $labels,
				// Features this CPT supports in Post Editor
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
				// You can associate this CPT with a taxonomy or custom taxonomy.
				'taxonomies'          => array( 'genres' ),
				/* A hierarchical CPT is like Pages and can have
				* Parent and child items. A non-hierarchical CPT
				* is like Posts.
				*/
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest' => true,
				'rewrite' => array('slug' => 'news', 'with_front' => false)
			);

			// Registering your Custom Post Type
			register_post_type( 'news', $args );

		}

		/* Hook into the 'init' action so that the function
		* Containing our post type registration is not
		* unnecessarily executed.
		*/

		add_action( 'init', 'custom_post_type', 0 );

	}
}


add_filter( 'excerpt_more', 'understrap_custom_excerpt_more' );

if ( ! function_exists( 'understrap_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function understrap_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

add_filter( 'wp_trim_excerpt', 'understrap_all_excerpts_get_more_link' );

if ( ! function_exists( 'understrap_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function understrap_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . ' ...';
		}
		return $post_excerpt;
	}
}
