<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header(); // This will include your header.php file
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format) and that will be used instead.
					 */
					// get_template_part( 'template-parts/content', get_post_format() );
                    // For now, let's just output the title and content directly for testing
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header><div class="entry-content">
                            <?php
                            the_content( sprintf(
                                wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'gregstuart-custom-theme' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                get_the_title()
                            ) );

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gregstuart-custom-theme' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div><footer class="entry-footer">
                           <?php // You can add post meta here later ?>
                        </footer></article><?php

				endwhile;

				// the_posts_navigation(); // You can add navigation later

			else :

				// get_template_part( 'template-parts/content', 'none' ); // For when no content is found
                echo "<p>No content found.</p>";

			endif;
			?>

		</main></div><?php
// get_sidebar(); // If you have a sidebar
get_footer(); // This will include your footer.php file
