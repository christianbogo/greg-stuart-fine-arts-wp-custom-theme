<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header();
?>

<div id="primary" class="content-area single-post-page">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-container'); ?>>
				<header class="single-post-header">
					<?php the_title( '<h1 class="single-post-title">', '</h1>' ); ?>

					<div class="single-post-meta">
						<span class="posted-on">
							<?php esc_html_e( 'Posted on', 'gregstuart-custom-theme' ); ?> <?php echo get_the_date(); ?>
						</span>
						<span class="byline">
							<?php esc_html_e( 'by', 'gregstuart-custom-theme' ); ?> <?php the_author_posts_link(); ?>
						</span>
						<?php if ( has_category() ) : ?>
							<span class="cat-links">
								<?php esc_html_e( 'in', 'gregstuart-custom-theme' ); ?> <?php the_category( ', ' ); ?>
							</span>
						<?php endif; ?>
					</div></header><?php if ( has_post_thumbnail() ) : ?>
					<div class="single-post-thumbnail">
						<?php the_post_thumbnail('large'); // Use 'large' or 'full' or a custom size ?>
					</div>
				<?php endif; ?>

				<div class="single-post-content entry-content">
					<?php
					the_content(
						sprintf(
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
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gregstuart-custom-theme' ),
							'after'  => '</div>',
						)
					);
					?>
				</div><footer class="single-post-footer">
					<?php if ( has_tag() ) : ?>
						<span class="tags-links">
							<?php esc_html_e( 'Tagged: ', 'gregstuart-custom-theme' ); ?><?php the_tags( '', ', ', '' ); ?>
						</span>
					<?php endif; ?>

					<?php
                    // --- Comments Section Removed ---
					// The following lines that load the comments template have been commented out.
					/*
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					*/
					?>
				</footer></article><?php
			// Previous/next post navigation.
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'gregstuart-custom-theme' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'gregstuart-custom-theme' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

		endwhile; // End of the loop.
		?>

	</main></div><?php
get_footer();
?>
