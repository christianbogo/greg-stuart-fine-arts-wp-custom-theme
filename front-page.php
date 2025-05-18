<?php
/**
 * The template for displaying the static front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		// --- Hero Section ---
		// Assumes ACF field 'hero_cover_photo' returns an Image URL.
		$hero_image_url = get_field('hero_cover_photo');
		$hero_image_alt = '';

		if ($hero_image_url) {
			// Attempt to get alt text from the image attachment details.
			// This works best if get_field('hero_cover_photo') returns an image ID or array.
			// If it only returns a URL, attachment_url_to_postid() is a good attempt.
			$hero_image_id = attachment_url_to_postid($hero_image_url);
			if ($hero_image_id) {
				$hero_image_alt = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
			}
		}
		// Fallback alt text if not found or if ACF field is empty.
		if (empty($hero_image_alt)) {
			$hero_image_alt = "Hero graphic for Greg Stuart Fine Arts";
		}
		?>
		<section class="hero">
			<div class="image-container">
				<?php if ( $hero_image_url ) : ?>
					<a href="<?php echo esc_url( $hero_image_url ); ?>" 
					   class="glightbox" 
					   data-gallery="hero-cover" 
					   data-title="<?php echo esc_attr( $hero_image_alt ); ?>">
						<img src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( $hero_image_alt ); ?>" class="hero-image" />
					</a>
				<?php else : ?>
					<div class="hero-image-placeholder"><?php esc_html_e( 'Cover photo not found', 'gregstuart-custom-theme' ); ?></div>
				<?php endif; ?>
			</div>
			<div class="text-container">
				<p class="intro-text"><?php esc_html_e( 'Inner Worlds/Outer Environments', 'gregstuart-custom-theme' ); ?></p>
			</div>
		</section>

		<?php
		// --- Artwork Grid Section ---
		$artwork_grid_images = [];
		for ( $i = 1; $i <= 5; $i++ ) {
			// Assumes ACF field 'artwork_grid_image_X' returns an Image URL.
			$image_url = get_field( 'artwork_grid_image_' . $i );
			$image_alt = 'Artwork Grid Image ' . $i; // Basic fallback alt
			$image_title = 'Artwork ' . $i; // Basic fallback title for lightbox

			if ($image_url) {
				$image_id = attachment_url_to_postid($image_url);
				if ($image_id) {
					$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					if (!empty($alt_text)) {
						$image_alt = $alt_text;
						$image_title = $alt_text; // Use alt for title if available
					} else {
						$attachment_title = get_the_title($image_id);
						if (!empty($attachment_title)) {
							$image_alt = $attachment_title; // Fallback to attachment title for alt
							$image_title = $attachment_title; // Use attachment title for lightbox title
						}
					}
				}
			}
			$artwork_grid_images[] = [
				'url'   => $image_url,
				'alt'   => $image_alt,
				'title' => $image_title,
			];
		}
		$gallery_page_url = get_permalink( get_page_by_path( 'gallery' ) ); // Assumes gallery page slug is 'gallery'
		?>
		<section class="artwork-grid-section">
			<div class="artwork-grid">
				<?php foreach ( $artwork_grid_images as $index => $image_data ) : ?>
					<div class="artwork-item">
						<?php if ( ! empty( $image_data['url'] ) ) : ?>
							<a href="<?php echo esc_url( $image_data['url'] ); ?>" 
							   class="glightbox" 
							   data-gallery="homepage-artwork-grid"
							   data-title="<?php echo esc_attr( $image_data['title'] ); ?>">
								<img src="<?php echo esc_url( $image_data['url'] ); ?>" alt="<?php echo esc_attr( $image_data['alt'] ); ?>" />
							</a>
						<?php else : ?>
							<div class="artwork-placeholder">
								<span><?php printf( esc_html__( 'Image %d unavailable', 'gregstuart-custom-theme' ), $index + 1 ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( $gallery_page_url ) : ?>
			<div class="sketch-highlight-button-container"> <?php // Reusing class for button container styling ?>
				<a href="<?php echo esc_url( $gallery_page_url ); ?>" class="sketch-highlight-button">
					<?php esc_html_e( 'View More Art', 'gregstuart-custom-theme' ); ?>
					<i class="fas fa-arrow-right sketch-highlight-button-icon"></i>
				</a>
			</div>
			<?php endif; ?>
		</section>

		<?php
		// --- Sketch Highlight Section ---
		$sketch_args = array(
			'post_type'      => 'artwork',
			'posts_per_page' => 3,
			'tax_query'      => array(
				array(
					'taxonomy' => 'artwork_type',
					'field'    => 'slug',
					'terms'    => 'sketch',
				),
			),
			'orderby'        => 'date',
			'order'          => 'DESC',
		);
		$sketch_query = new WP_Query( $sketch_args );
		$sketches_page_url = get_permalink( get_page_by_path( 'sketches' ) ); // Assumes sketches page slug is 'sketches'

		if ( $sketch_query->have_posts() ) :
		?>
		<section class="sketch-highlight">
			<h2 class="sketch-highlight-title"><?php esc_html_e( 'Recent Sketches', 'gregstuart-custom-theme' ); // Changed title slightly for variety ?></h2>
			<div class="sketch-highlight-grid">
				<?php
				while ( $sketch_query->have_posts() ) : $sketch_query->the_post();
					$full_image_url_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$full_image_url = $full_image_url_array ? $full_image_url_array[0] : '';
					$artwork_title = get_the_title();
					$artwork_description = get_field('artwork_description'); // ACF field for description
				?>
				<div class="sketch-highlight-item">
					<?php if ( has_post_thumbnail() && $full_image_url ) : ?>
						<div class="sketch-highlight-image-container">
							<a href="<?php echo esc_url( $full_image_url ); ?>" 
							   class="glightbox" 
							   data-gallery="homepage-sketches"
							   data-title="<?php echo esc_attr( $artwork_title ); ?>"
							   data-description="<?php echo esc_attr( wp_strip_all_tags( $artwork_description ) ); // Use custom description if available ?>">
								<?php the_post_thumbnail('medium_large', ['class' => 'sketch-highlight-image', 'alt' => esc_attr($artwork_title)]); ?>
							</a>
						</div>
					<?php endif; ?>
					<h3 class="sketch-highlight-item-title"><?php echo esc_html( $artwork_title ); ?></h3>
					<?php if ( $artwork_description ) : ?>
						<p class="sketch-highlight-item-description"><?php echo nl2br( esc_html( wp_strip_all_tags( $artwork_description ) ) ); ?></p>
					<?php endif; ?>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php if ( $sketches_page_url ) : ?>
			<div class="sketch-highlight-button-container">
				<a href="<?php echo esc_url( $sketches_page_url ); ?>" class="sketch-highlight-button">
					<?php esc_html_e( 'View All Sketches', 'gregstuart-custom-theme' ); ?>
					<i class="fas fa-arrow-right sketch-highlight-button-icon"></i>
				</a>
			</div>
			<?php endif; ?>
		</section>
		<?php endif; // End sketch_query->have_posts() ?>

	</main></div><?php
get_footer();
