<?php
/**
 * Greg Stuart Custom Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Greg_Stuart_Custom_Theme
 */

if ( ! defined( 'GREGSTUART_VERSION' ) ) {
	// Replace with the current version of your theme
	define( 'GREGSTUART_VERSION', '1.0.0' );
}

if ( ! function_exists( 'gregstuart_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function gregstuart_setup() {
		// Make theme available for translation.
		// Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'gregstuart-custom-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		// By adding theme support, we declare that this theme does not use a
		// hard-coded <title> tag in the document head, and expect WordPress to
		// provide it for us.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set up the WordPress core custom background feature.
        // add_theme_support( 'custom-background', apply_filters( 'gregstuart_custom_background_args', array(
        //  'default-color' => 'ffffff',
        //  'default-image' => '',
        // ) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 100, // Adjust as needed, max height
			'width'       => 400, // Adjust as needed, max width
			'flex-height' => true,
			'flex-width'  => true,
			// 'header-text' => array( 'site-title', 'site-description' ), // Un-comment to allow site title/description if no logo
		) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary_menu' => esc_html__( 'Primary Menu', 'gregstuart-custom-theme' ),
			// You can register other menus here if needed, e.g. 'footer_menu'
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
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
	// Enqueue Google Fonts: Bowlby One SC
	wp_enqueue_style( 'gregstuart-google-fonts', 'https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap', array(), null );

	// Enqueue parent theme stylesheet.
    // If you were building a child theme, you would enqueue the parent theme's style first.
    // Example: wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'gregstuart-main-style', get_stylesheet_uri(), array(), GREGSTUART_VERSION );

	// Example of enqueuing a JS file (if you need one later)
	// wp_enqueue_script( 'gregstuart-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), GREGSTUART_VERSION, true );

    // Example for adding threaded comments script
    // if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    //  wp_enqueue_script( 'comment-reply' );
    // }
}
add_action( 'wp_enqueue_scripts', 'gregstuart_scripts_styles' );

?>

<?php
// Add this to the end of your functions.php file

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

        // Add 'nav-link' class to the <a> tag
        $item_classes = 'nav-link';

        // Check if the item is the current page or an ancestor of the current page.
        // This helps in identifying active links for various scenarios (pages, posts, archives).
        $is_current = false;
        if ( in_array( 'current-menu-item', $classes ) ||
             in_array( 'current-menu-ancestor', $classes ) ||
             in_array( 'current_page_item', $classes ) ||
             in_array( 'current_page_ancestor', $classes ) ) {
            $is_current = true;
        }

        if ( $is_current ) {
            $item_classes .= ' nav-link-active'; // Your active class
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
        $atts['class']  = $item_classes; // Apply our custom classes to the <a> tag

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

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    // function end_el( &$output, $item, $depth = 0, $args = null ) {
    //  $output .= "</li>\n"; // WordPress usually adds <li> in the main function
    // }
}
?>