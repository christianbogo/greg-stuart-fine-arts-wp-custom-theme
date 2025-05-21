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

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
	<nav class="navbar">
		<div class="navbar-row navbar-row-top">
			<div class="header-container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center;">
					<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ( $custom_logo_id ) {
						$logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
						if ( $logo_image ) {
							echo '<img src="' . esc_url( $logo_image[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' Logo" class="logo">';
						}
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
					'menu_class'     => 'nav-links',
					'container'      => false,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'walker'         => new GregStuart_Nav_Walker()
				) );
			}
			?>
		</div>
	</nav>
</header>
<main id="content" class="site-content">
