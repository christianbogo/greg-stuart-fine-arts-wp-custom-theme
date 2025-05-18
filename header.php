<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until main content
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Greg_Stuart_Custom_Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); // WordPress hook for scripts, styles, and other head elements ?>
</head>

<body <?php body_class(); // Adds useful classes to the body tag ?>>
<?php wp_body_open(); // Hook for plugins, good practice ?>

<header id="masthead" class="site-header"> <?php // You can use your 'navbar' class here too if you prefer, e.g. class="navbar" ?>
	<nav class="navbar"> <?php // Main navbar container from your React structure ?>
		<div class="navbar-row navbar-row-top">
			<div class="header-container">
				<?php
				// Logic for displaying the logo and site title
				// This makes the logo and title link to the homepage
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center;">
					<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ( $custom_logo_id ) {
						$logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
						if ( $logo_image ) {
							echo '<img src="' . esc_url( $logo_image[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' Logo" class="logo">';
						}
					} else {
						// Fallback if no custom logo is set - you can have a placeholder or just the title
						// echo '<div class="logo-placeholder"></div>'; // Your placeholder div
					}
					?>
					<span class="title">
						GREG STUART
						<span class="fine-arts-desktop"> FINE ARTS</span>
						<span class="fine-arts-mobile">
							<br />
							Fine Arts
						</span>
					</span>
				</a>
			</div>
		</div>
		<div class="navbar-row navbar-row-bottom">
			<?php
			if ( has_nav_menu( 'primary_menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary_menu',
					'menu_class'     => 'nav-links', // Your ul class
					'container'      => false, // Don't wrap in a div
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker'         => new GregStuart_Nav_Walker() // Custom walker to add 'nav-link' class to <a>
				) );
			}
			?>
		</div>
	</nav></header><main id="content" class="site-content"> <?php // Main content area starts here, will be closed in footer.php or individual templates ?>
