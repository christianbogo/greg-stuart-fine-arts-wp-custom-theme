<?php
/**
 * Greg Stuart Custom Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Greg_Stuart_Custom_Theme
 */

if ( ! defined( 'GREGSTUART_VERSION' ) ) {
	define( 'GREGSTUART_VERSION', '1.0.0' );
}

if ( ! function_exists( 'gregstuart_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function gregstuart_setup() {
		load_theme_textdomain( 'gregstuart-custom-theme', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		register_nav_menus( array(
			'primary_menu' => esc_html__( 'Primary Menu', 'gregstuart-custom-theme' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );
	}
endif;
add_action( 'after_setup_theme', 'gregstuart_setup' );

/**
 * Enqueue scripts and styles.
 */
function gregstuart_scripts_styles() {
	// Enqueue Google Fonts: Anton (for site title), Fira Sans Condensed (for artwork titles/captions), Inter Tight (for body text)
	wp_enqueue_style(
		'gregstuart-google-fonts',
		'https://fonts.googleapis.com/css2?family=Anton&family=Fira+Sans+Condensed:wght@400&family=Inter+Tight:wght@400&display=swap',
		array(),
		null
	);

    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1' );
	wp_enqueue_style( 'gregstuart-main-style', get_stylesheet_uri(), array('gregstuart-google-fonts'), GREGSTUART_VERSION ); // Added 'gregstuart-google-fonts' as a dependency

	// GLightbox Integration
	wp_enqueue_style( 'glightbox-css', get_template_directory_uri() . '/assets/css/glightbox.min.css', array(), '3.3.1' );
	wp_enqueue_script( 'glightbox-js', get_template_directory_uri() . '/assets/js/glightbox.min.js', array(), '3.3.1', true );
	wp_enqueue_script( 'gregstuart-lightbox-init', get_template_directory_uri() . '/assets/js/lightbox-init.js', array('glightbox-js'), GREGSTUART_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'gregstuart_scripts_styles' );

/**
 * Custom Nav Walker to add 'nav-link' class to <a> tags
 * and 'nav-link-active' to current menu item's <a> tag.
 */
class GregStuart_Nav_Walker extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     *
     * @see Walker::start_el()
     *
     * @param string   $output            Used to append additional content (passed by reference).
     * @param WP_Post  $item              Menu item data object.
     * @param int      $depth             Depth of menu item. Used for padding.
     * @param stdClass $args              An object of wp_nav_menu() arguments.
     * @param int      $id                Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $item_classes = 'nav-link';

        $is_current = false;
        if ( in_array( 'current-menu-item', $classes ) ||
             in_array( 'current-menu-ancestor', $classes ) ||
             in_array( 'current_page_item', $classes ) ||
             in_array( 'current_page_ancestor', $classes ) ) {
            $is_current = true;
        }

        if ( $is_current ) {
            $item_classes .= ' nav-link-active';
        }

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener noreferrer';
        } else {
            $atts['rel'] = $item->xfn;
        }
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';
        $atts['class']  = $item_classes;

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= $indent . apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

// --- CPT UI Post Type and Taxonomy Registration Code (from your existing functions.php) ---
// It's assumed this block of code is already present in your functions.php
// If not, ensure it is. For brevity, I'm not repeating the full CPT UI export here.
// Make sure the `cptui_register_my_cpts_artwork()` and `cptui_register_my_taxes()` functions
// are called as they were before.

function cptui_register_my_cpts_artwork() {

	/**
	 * Post Type: Artworks.
	 */

	$labels = [
		"name" => esc_html__( "Artworks", "gregstuart-custom-theme" ),
		"singular_name" => esc_html__( "Artwork", "gregstuart-custom-theme" ),
		"menu_name" => esc_html__( "My Artworks", "gregstuart-custom-theme" ),
		"all_items" => esc_html__( "All Artworks", "gregstuart-custom-theme" ),
		"add_new" => esc_html__( "Add new", "gregstuart-custom-theme" ),
		"add_new_item" => esc_html__( "Add new Artwork", "gregstuart-custom-theme" ),
		"edit_item" => esc_html__( "Edit Artwork", "gregstuart-custom-theme" ),
		"new_item" => esc_html__( "New Artwork", "gregstuart-custom-theme" ),
		"view_item" => esc_html__( "View Artwork", "gregstuart-custom-theme" ),
		"view_items" => esc_html__( "View Artworks", "gregstuart-custom-theme" ),
		"search_items" => esc_html__( "Search Artworks", "gregstuart-custom-theme" ),
		"not_found" => esc_html__( "No Artworks found", "gregstuart-custom-theme" ),
		"not_found_in_trash" => esc_html__( "No Artworks found in trash", "gregstuart-custom-theme" ),
		"parent" => esc_html__( "Parent Artwork:", "gregstuart-custom-theme" ),
		"featured_image" => esc_html__( "Featured image for this Artwork", "gregstuart-custom-theme" ),
		"set_featured_image" => esc_html__( "Set featured image for this Artwork", "gregstuart-custom-theme" ),
		"remove_featured_image" => esc_html__( "Remove featured image for this Artwork", "gregstuart-custom-theme" ),
		"use_featured_image" => esc_html__( "Use as featured image for this Artwork", "gregstuart-custom-theme" ),
		"archives" => esc_html__( "Artwork archives", "gregstuart-custom-theme" ),
		"insert_into_item" => esc_html__( "Insert into Artwork", "gregstuart-custom-theme" ),
		"uploaded_to_this_item" => esc_html__( "Upload to this Artwork", "gregstuart-custom-theme" ),
		"filter_items_list" => esc_html__( "Filter Artworks list", "gregstuart-custom-theme" ),
		"items_list_navigation" => esc_html__( "Artworks list navigation", "gregstuart-custom-theme" ),
		"items_list" => esc_html__( "Artworks list", "gregstuart-custom-theme" ),
		"attributes" => esc_html__( "Artworks attributes", "gregstuart-custom-theme" ),
		"name_admin_bar" => esc_html__( "Artwork", "gregstuart-custom-theme" ),
		"item_published" => esc_html__( "Artwork published", "gregstuart-custom-theme" ),
		"item_published_privately" => esc_html__( "Artwork published privately.", "gregstuart-custom-theme" ),
		"item_reverted_to_draft" => esc_html__( "Artwork reverted to draft.", "gregstuart-custom-theme" ),
		"item_trashed" => esc_html__( "Artwork trashed.", "gregstuart-custom-theme" ),
		"item_scheduled" => esc_html__( "Artwork scheduled", "gregstuart-custom-theme" ),
		"item_updated" => esc_html__( "Artwork updated.", "gregstuart-custom-theme" ),
		"parent_item_colon" => esc_html__( "Parent Artwork:", "gregstuart-custom-theme" ),
	];

    // IMPORTANT: Ensure you have made the change to 'supports' within the CPT UI plugin interface
    // to remove 'editor'. The array below reflects that change. If you haven't done it in CPT UI,
    // this code might be overwritten if you re-save the CPT via the plugin.
	$args = [
		"label" => esc_html__( "Artworks", "gregstuart-custom-theme" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "artwork", "with_front" => true ],
		"query_var" => true,
		// Ensure 'editor' is removed here if you are not managing 'supports' via CPT UI plugin.
        // Best practice is to manage 'supports' via the CPT UI plugin settings.
		"supports" => [ "title", "thumbnail", "revisions" ], // 'editor' removed
		"show_in_graphql" => false,
	];

	register_post_type( "artwork", $args );
}
add_action( 'init', 'cptui_register_my_cpts_artwork' );


function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Artwork Types.
	 */

	$labels = [
		"name" => esc_html__( "Artwork Types", "gregstuart-custom-theme" ),
		"singular_name" => esc_html__( "Artwork Type", "gregstuart-custom-theme" ),
		"menu_name" => esc_html__( "Artwork Types", "gregstuart-custom-theme" ),
		"all_items" => esc_html__( "All Artwork Types", "gregstuart-custom-theme" ),
		"edit_item" => esc_html__( "Edit Artwork Type", "gregstuart-custom-theme" ),
		"view_item" => esc_html__( "View Artwork Type", "gregstuart-custom-theme" ),
		"update_item" => esc_html__( "Update Artwork Type name", "gregstuart-custom-theme" ),
		"add_new_item" => esc_html__( "Add new Artwork Type", "gregstuart-custom-theme" ),
		"new_item_name" => esc_html__( "New Artwork Type name", "gregstuart-custom-theme" ),
		"parent_item" => esc_html__( "Parent Artwork Type", "gregstuart-custom-theme" ),
		"parent_item_colon" => esc_html__( "Parent Artwork Type:", "gregstuart-custom-theme" ),
		"search_items" => esc_html__( "Search Artwork Types", "gregstuart-custom-theme" ),
		"popular_items" => esc_html__( "Popular Artwork Types", "gregstuart-custom-theme" ),
		"separate_items_with_commas" => esc_html__( "Separate Artwork Types with commas", "gregstuart-custom-theme" ),
		"add_or_remove_items" => esc_html__( "Add or remove Artwork Types", "gregstuart-custom-theme" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Artwork Types", "gregstuart-custom-theme" ),
		"not_found" => esc_html__( "No Artwork Types found", "gregstuart-custom-theme" ),
		"no_terms" => esc_html__( "No Artwork Types", "gregstuart-custom-theme" ),
		"items_list_navigation" => esc_html__( "Artwork Types list navigation", "gregstuart-custom-theme" ),
		"items_list" => esc_html__( "Artwork Types list", "gregstuart-custom-theme" ),
		"back_to_items" => esc_html__( "Back to Artwork Types", "gregstuart-custom-theme" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "gregstuart-custom-theme" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "gregstuart-custom-theme" ),
		"slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "gregstuart-custom-theme" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "gregstuart-custom-theme" ),
	];


	$args = [
		"label" => esc_html__( "Artwork Types", "gregstuart-custom-theme" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'artwork_type', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "artwork_type",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "artwork_type", [ "artwork" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );

// ---- NEW FUNCTION TO AUTO-POPULATE ARTWORK TITLE ----
/**
 * Auto-populate the Artwork CPT title from its featured image title.
 *
 * @param int     $post_id The ID of the post being saved.
 * @param WP_Post $post    The post object.
 * @param bool    $update  Whether this is an existing post being updated or not.
 */
function gregstuart_set_artwork_title_from_featured_image( $post_id, $post, $update ) {
    // Only run for the 'artwork' post type.
    if ( 'artwork' !== $post->post_type ) {
        return;
    }

    // Check if it's an autosave, a revision, or if the user doesn't have permissions.
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Check if a featured image is set.
    if ( has_post_thumbnail( $post_id ) ) {
        $thumbnail_id = get_post_thumbnail_id( $post_id );
        if ( $thumbnail_id ) {
            $image_title = get_the_title( $thumbnail_id );

            // If the image has a title and it's different from the post's current title,
            // or if the post title is currently empty (e.g., for a new post).
            if ( ! empty( $image_title ) && ( $post->post_title !== $image_title || empty( $post->post_title ) ) ) {
                // Unhook this function to prevent infinite loops.
                remove_action( 'save_post_artwork', 'gregstuart_set_artwork_title_from_featured_image', 10, 3 );

                // Update the post title.
                wp_update_post( array(
                    'ID'         => $post_id,
                    'post_title' => $image_title,
                ) );

                // Re-hook this function.
                add_action( 'save_post_artwork', 'gregstuart_set_artwork_title_from_featured_image', 10, 3 );
            }
        }
    }
}
// The '10' is the priority, '3' is the number of arguments the function accepts.
add_action( 'save_post_artwork', 'gregstuart_set_artwork_title_from_featured_image', 10, 3 );

// ---- NEW FUNCTION TO ENQUEUE ADMIN SCRIPT FOR ARTWORK CPT ----
/**
 * Enqueues admin scripts for the 'artwork' CPT edit screen.
 *
 * @param string $hook The current admin page hook.
 */
function gregstuart_enqueue_artwork_admin_scripts( $hook ) {
    global $post;

    // Only load on the 'artwork' post type edit screens (new or existing).
    if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && isset( $post->post_type ) && 'artwork' === $post->post_type ) {
        wp_enqueue_script(
            'gregstuart-artwork-admin-js', // Handle for the script
            get_template_directory_uri() . '/assets/js/artwork-admin.js', // Path to the JS file
            array( 'jquery' ), // Dependencies (jQuery is a good default)
            GREGSTUART_VERSION, // Version number
            true // Load in footer
        );
    }
}
add_action( 'admin_enqueue_scripts', 'gregstuart_enqueue_artwork_admin_scripts' );

?>
