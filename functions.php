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
	wp_enqueue_style( 'gregstuart-google-fonts', 'https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap', array(), null );
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1' );
	wp_enqueue_style( 'gregstuart-main-style', get_stylesheet_uri(), array(), GREGSTUART_VERSION );

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

    // The end_el function is often not needed unless specific <li> closing markup is required.
    // If you had custom logic in end_el, it would be preserved or commented if unused.
    // function end_el( &$output, $item, $depth = 0, $args = null ) {
    //  $output .= "</li>\n";
    // }
}
?>
