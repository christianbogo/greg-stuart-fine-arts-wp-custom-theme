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
		$hero_image_data = gregstuart_get_image_alt_title( 
			$hero_image_url, 
			'Hero graphic for Greg Stuart Fine Arts', 
			'Hero Cover Photo' 
		);
		?>
		<section class="hero">
			<div class="image-container">
				<?php if ( $hero_image_url ) : ?>
					<a href="<?php echo esc_url( $hero_image_url ); ?>"
					   class="glightbox"
					   data-gallery="hero-cover"
					   data-title="<?php echo esc_attr( $hero_image_data['title'] ); ?>">
						<img src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( $hero_image_data['alt'] ); ?>" class="hero-image" />
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
			$image_url = get_field( 'artwork_grid_image_' . $i );
			$image_data = gregstuart_get_image_alt_title( 
				$image_url, 
				'Artwork Grid Image ' . $i, 
				'Artwork ' . $i 
			);
			
			$artwork_grid_images[] = [
				'url'   => $image_url,
				'alt'   => $image_data['alt'],
				'title' => $image_data['title'],
			];
		}
		$gallery_page_url = gregstuart_get_page_url_by_slug( 'gallery' );
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
			<div class="sketch-highlight-button-container">
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
			'posts_per_page' => 3, // Show 3 most recently ordered sketches
			'tax_query'      => array(
				array(
					'taxonomy' => 'artwork_type',
					'field'    => 'slug',
					'terms'    => 'sketch',
				),
			),
			'orderby'        => 'menu_order date', // Added fallback ordering
			'order'          => 'ASC',        // Typically ASC for menu_order
		);
		$sketch_query = new WP_Query( $sketch_args );
		$sketches_page_url = gregstuart_get_page_url_by_slug( 'sketches' );

		if ( $sketch_query->have_posts() ) :
		?>
		<section class="sketch-highlight">
			<h2 class="sketch-highlight-title"><?php esc_html_e( 'Recent Sketches', 'gregstuart-custom-theme' ); ?></h2>
			<div class="sketch-highlight-grid">
				<?php
				while ( $sketch_query->have_posts() ) : $sketch_query->the_post();
					$full_image_url_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$full_image_url = $full_image_url_array ? $full_image_url_array[0] : '';
					$artwork_title = get_the_title();
					
					$artwork_description = ''; 
					if ( has_post_thumbnail() ) {
						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						if ( $thumbnail_id ) {
							$attachment_post = get_post( $thumbnail_id );
							if ( $attachment_post && ! empty( $attachment_post->post_content ) ) {
								$artwork_description = $attachment_post->post_content;
							}
						}
					}
				?>
				<div class="sketch-highlight-item">
					<?php if ( has_post_thumbnail() && $full_image_url ) : ?>
						<div class="sketch-highlight-image-container">
							<a href="<?php echo esc_url( $full_image_url ); ?>"
							   class="glightbox"
							   data-gallery="homepage-sketches"
							   data-title="<?php echo esc_attr( $artwork_title ); ?>"
							   data-description="<?php echo esc_attr( wp_strip_all_tags( $artwork_description ) ); ?>">
								<?php the_post_thumbnail('medium_large', ['class' => 'sketch-highlight-image', 'alt' => esc_attr($artwork_title)]); ?>
							</a>
						</div>
					<?php endif; ?>
					<h3 class="sketch-highlight-item-title"><?php echo esc_html( $artwork_title ); ?></h3>
					<?php if ( ! empty( $artwork_description ) ) : ?>
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
		<?php endif; ?>

	</main>
</div>
<?php
get_footer();
?>
