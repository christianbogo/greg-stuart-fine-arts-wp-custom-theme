<?php
/**
 * Template Name: Gallery Page
 *
 * This is the template that displays artworks categorized as "Gallery Piece".
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="page gallery">
			<header class="gallery-header">
				<h1 class="gallery-title">Greg's Paintings</h1>
				<div class="gallery-intro"> <?php // Changed <p> to <div> to better accommodate block editor content ?>
    <?php
    // Display content entered in the WP Admin editor for this page.
    // This needs to be within The Loop.
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        // No need to rewind or reset post data here if this is the only loop for page content.
    else :
        // Optionally, handle the case where no content is found for the page.
        // echo '<p>No introductory content has been set for this page.</p>';
    endif;
    ?>
</div>
			</header>

			<?php
			// WP_Query arguments to fetch "Gallery Piece" artworks.
			$args = array(
				'post_type'      => 'artwork',       // Custom post type slug.
				'posts_per_page' => -1,              // Display all matching artworks.
				'tax_query'      => array(
					array(
						'taxonomy' => 'artwork_type',  // Custom taxonomy slug.
						'field'    => 'slug',
						'terms'    => 'gallery-piece', // Slug for "Gallery Piece" term.
					),
				),
				'orderby'        => 'date',          // Order by publication date.
				'order'          => 'DESC',          // Show the latest artworks first.
			);

			$gallery_query = new WP_Query( $args );

			if ( $gallery_query->have_posts() ) :
				while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
					$full_image_url_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$full_image_url = $full_image_url_array ? $full_image_url_array[0] : '';
					$artwork_title = get_the_title();
					?>
					<div class="gallery-item">
						<?php if ( has_post_thumbnail() && $full_image_url ) : ?>
							<a href="<?php echo esc_url( $full_image_url ); ?>"
							   class="glightbox"
							   data-gallery="greg-stuart-gallery"
							   data-title="<?php echo esc_attr( $artwork_title ); // Title for GLightbox caption ?>">
								<?php
								// Displaying 'large' thumbnail size for grid; 'full' is used for lightbox.
								the_post_thumbnail('large', ['alt' => esc_attr( $artwork_title )]);
								?>
							</a>
						<?php else : ?>
							<div class="gallery-placeholder"><?php esc_html_e( 'Image unavailable', 'gregstuart-custom-theme' ); ?></div>
						<?php endif; ?>
						<div class="gallery-item-title"><?php echo esc_html( $artwork_title ); ?></div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata(); // Important: Reset post data after custom WP_Query loops.
			elseif (current_user_can('edit_posts')) : // Show helpful message to users who can edit posts.
                ?>
                <div class="gallery-empty">
                    <p><?php esc_html_e( 'No artworks found in the "Gallery Piece" category.', 'gregstuart-custom-theme' ); ?></p>
                    <p><?php
                        printf(
                            wp_kses(
                                /* translators: 1: Link to Add New Artwork page. */
                                __( 'Ready to add some? <a href="%1$s">Add a new artwork</a> and assign it to the "Gallery Piece" type.', 'gregstuart-custom-theme' ),
                                array( 'a' => array( 'href' => array() ) )
                            ),
                            esc_url( admin_url( 'post-new.php?post_type=artwork' ) )
                        );
                    ?></p>
                </div>
                <?php
			else : // Default message for general visitors if no gallery pieces are found.
				?>
				<div class="gallery-empty"><?php esc_html_e( 'No artworks found in the gallery.', 'gregstuart-custom-theme' ); ?></div>
				<?php
			endif;
			?>
		</div></main></div><?php
get_footer();
