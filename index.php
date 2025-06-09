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

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<!-- This is the blog page with consistent styling -->
				<div class="blog-page-container page">
					<header class="blog-header">
						<h1 class="blog-title"><?php single_post_title(); ?></h1>
						<div class="blog-intro">
							<?php
							// Get the blog page content if it exists
							$blog_page_id = get_option( 'page_for_posts' );
							if ( $blog_page_id ) {
								$blog_page = get_post( $blog_page_id );
								if ( $blog_page && ! empty( $blog_page->post_content ) ) {
									echo apply_filters( 'the_content', $blog_page->post_content );
								}
							}
							?>
						</div>
					</header>

					<div class="blog-posts-list">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item'); ?>>
									
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="blog-post-thumbnail">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_post_thumbnail('medium_large'); ?>
											</a>
										</div>
									<?php endif; ?>

									<header class="blog-post-header">
										<?php the_title( sprintf( '<h2 class="blog-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
										<div class="blog-post-meta">
											<span class="posted-on"><?php echo get_the_date(); ?></span>
										</div>
									</header>

									<div class="blog-post-excerpt">
										<?php the_excerpt(); ?>
									</div>

									<footer class="blog-post-footer">
										<a href="<?php the_permalink(); ?>" class="blog-read-more">
											<?php esc_html_e( 'Read More', 'gregstuart-custom-theme' ); ?>
											<i class="fas fa-arrow-right"></i>
										</a>
									</footer>

								</article>
								<?php
							endwhile;

							// Pagination
							echo '<nav class="pagination blog-pagination">';
							the_posts_pagination( array(
								'prev_text' => __('<i class="fas fa-chevron-left"></i> Prev'),
								'next_text' => __('Next <i class="fas fa-chevron-right"></i>'),
							) );
							echo '</nav>';

						else :
							?>
							<section class="no-results not-found">
								<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'gregstuart-custom-theme' ); ?></p>
								<?php get_search_form(); ?>
							</section>
							<?php
						endif;
						?>
					</div>
				</div>

			<?php else : ?>
				<!-- Default content for other pages -->
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header>
							<div class="entry-content">
								<?php
								the_content( sprintf(
									wp_kses(
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
							</div>
							<footer class="entry-footer">
								<?php // Space for post meta if needed in the future ?>
							</footer>
						</article>
						<?php
					endwhile;
				else :
					echo "<p>No content found.</p>";
				endif;
			endif;
			?>

		</main>
	</div>

<?php
get_footer();
