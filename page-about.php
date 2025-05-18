<?php
/**
 * Template Name: About Page
 *
 * This is the template that displays the custom About page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header(); // Include header.php
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		// Start the WordPress Loop
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'about-page page' ); // Add your React classes here ?>>
				<header class="about-header">
					<?php the_title( '<h1 class="about-title">', '</h1>' ); // Get the page title from WP Admin ?>
					
					<?php // The introductory paragraph will come from the WP editor content ?>
					<div class="about-intro">
						<?php the_content(); // Display content entered in WP Admin editor ?>
					</div>
				</header><section class="about-book-callout">
					<h2 class="book-title">Convergence: Seeking a Publisher</h2>
					<p class="book-description">
						Greg Stuart's upcoming book, "Convergence," explores the
						interconnectedness of art, planning, and urban design. The forward,
						included here, delves into the idea that these disciplines share a
						foundation in the organization of visual and physical elements to
						shape environments and perceptions.
					</p>
					<div class="book-forward">
						<p>
							In the broadest sense, the basis of art, planning and
							urban design is the distribution and integration of visual and
							physical elements to create environments.
						</p>
						<p>
							Similar elements create similar environments; all are works of
							the imagination. Art, planning and design organize materials,
							time and space, to form perceptions, emotions and to create meaning.
						</p>
						<p>
							The three disciplines promote communication. The three
							disciplines shape life on our own terms. Art, planning and
							urban design further creative responses and alter our
							relationship to the world.
						</p>
						<p>
							Ideally, art, planning and urban design can lead to enhanced
							awareness and an understanding of the interdependence of
							natural, man-made and psychological worlds.
						</p>
						<br />
						<p>
							"Convergence is the ability to evolve art, planning and
							urban design based on similar characteristics, conditions,
							purpose and intention;"
							<span class="author">Greg Stuart, 01/06/2025</span>
						</p>
					</div>
					<p class="publisher-note">
						Currently seeking a publisher to bring this insightful work to a wider
						audience.
					</p>
				</section></article><?php
		endwhile; // End of the loop.
		?>
	</main></div><?php
get_footer(); // Include footer.php
