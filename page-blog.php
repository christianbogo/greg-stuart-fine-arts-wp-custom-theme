<?php
/**
 * Template Name: Blog Page
 *
 * This is the template that displays blog posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header(); // Include header.php
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="blog-page-container page">
			<header class="blog-header">
				<?php
				// Display the page title (e.g., "Blog") as set in the WordPress admin
				// when this template is assigned to a page.
				the_title( '<h1 class="blog-main-title">', '</h1>' );
				?>
				<?php
				// Display content entered in the WP Admin editor for this page (if any).
				// This could be an introductory paragraph for the blog.
				if ( have_posts() ) :
					while ( have_posts() ) : the_post(); // Main page loop
						if ( get_the_content() ) : // Check if there's content for the page itself
				?>
							<div class="blog-intro">
								<?php the_content(); ?>
							</div>
				<?php
						endif;
					endwhile;
					// Rewind posts for the custom query if we used the main loop for page content.
					// However, for a blog page, we'll typically use a new WP_Query for posts.
					rewind_posts(); 
				else :
					// Fallback if the page itself has no content.
				endif;
				?>
			</header>

			<div class="blog-posts-list">
				<?php
				// Custom query to fetch standard blog posts.
				// You can customize the number of posts per page, order, etc.
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(
					'post_type'      => 'post',        // Fetch standard posts.
					'post_status'    => 'publish',     // Fetch only published posts.
					'posts_per_page' => 5,             // Number of posts per page.
					'paged'          => $paged,        // For pagination.
					'orderby'        => 'date',        // Order by publication date.
					'order'          => 'DESC',        // Show the latest posts first.
				);

				$blog_query = new WP_Query( $args );

				if ( $blog_query->have_posts() ) :
					while ( $blog_query->have_posts() ) : $blog_query->the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item'); ?>>
							
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="blog-post-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail('medium_large'); // Or 'large', 'medium', 'thumbnail', or a custom size ?>
									</a>
								</div>
							<?php endif; ?>

							<header class="blog-post-header">
								<?php the_title( sprintf( '<h2 class="blog-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								<div class="blog-post-meta">
									<span class="posted-on"><?php echo get_the_date(); ?></span>
									<?php /* You can add author, categories, etc. here if desired
									<span class="byline"> by <?php the_author_posts_link(); ?></span>
									<span class="cat-links"> in <?php the_category(', '); ?></span>
									*/ ?>
								</div>
							</header>

							<div class="blog-post-excerpt">
								<?php the_excerpt(); // Displays the post excerpt. ?>
							</div>

							<footer class="blog-post-footer">
								<a href="<?php the_permalink(); ?>" class="blog-read-more">
									<?php esc_html_e( 'Read More', 'gregstuart-custom-theme' ); ?>
									<i class="fas fa-arrow-right"></i>
								</a>
							</footer>

						</article><?php
					endwhile;

					// Pagination.
					echo '<nav class="pagination blog-pagination">';
					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $blog_query->max_num_pages,
						'prev_text' => __('<i class="fas fa-chevron-left"></i> Prev'),
						'next_text' => __('Next <i class="fas fa-chevron-right"></i>'),
					) );
					echo '</nav>';

					wp_reset_postdata(); // Important: Reset post data after custom WP_Query loops.
				else :
					// If no posts are found.
					?>
					<section class="no-results not-found">
						<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'gregstuart-custom-theme' ); ?></p>
						<?php get_search_form(); ?>
					</section><?php
				endif;
				?>
			</div></div></main></div><?php
get_footer(); // Include footer.php
?>