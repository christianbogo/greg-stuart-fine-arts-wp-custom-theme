<?php
/**
 * Template Name: Gallery Page
 *
 * This is the template that displays artworks categorized as "Gallery Piece"
 * using custom order.
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
				<div class="gallery-intro">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</div>
			</header>

			<?php
			// WP_Query arguments to fetch "Gallery Piece" artworks.
			$args = array(
				'post_type'      => 'artwork',       
				'posts_per_page' => -1,              
				'tax_query'      => array(
					array(
						'taxonomy' => 'artwork_type',  
						'field'    => 'slug',
						'terms'    => 'gallery-piece', 
					),
				),
				'orderby'        => 'menu_order', // Use custom order
				'order'          => 'ASC',        // Typically ASC for menu_order
			);

			$gallery_query = new WP_Query( $args );

			if ( $gallery_query->have_posts() ) :
				while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
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
					<div class="gallery-item">
						<?php if ( has_post_thumbnail() && $full_image_url ) : ?>
							<a href="<?php echo esc_url( $full_image_url ); ?>"
							   class="glightbox"
							   data-gallery="greg-stuart-gallery"
							   data-title="<?php echo esc_attr( $artwork_title ); ?>"
							   data-description="<?php echo esc_attr( wp_strip_all_tags( $artwork_description ) ); ?>">
								<?php
								the_post_thumbnail('large', ['alt' => esc_attr( $artwork_title )]);
								?>
							</a>
						<?php else : ?>
							<div class="gallery-placeholder"><?php esc_html_e( 'Image unavailable', 'gregstuart-custom-theme' ); ?></div>
						<?php endif; ?>
						<div class="gallery-item-title"><?php echo esc_html( $artwork_title ); ?></div>
						<?php
						/*
						if ( ! empty( $artwork_description ) ) : ?>
							<p class="gallery-item-description"><?php echo nl2br( esc_html( wp_strip_all_tags( $artwork_description ) ) ); ?></p>
						<?php endif;
						*/
						?>
					</div>
					<?php
				endwhile;
				wp_reset_postdata(); 
			elseif (current_user_can('edit_posts')) : 
                ?>
                <div class="gallery-empty">
                    <p><?php esc_html_e( 'No artworks found in the "Gallery Piece" category.', 'gregstuart-custom-theme' ); ?></p>
                    <p><?php
                        printf(
                            wp_kses(
                                __( 'Ready to add some? <a href="%1$s">Add a new artwork</a> and assign it to the "Gallery Piece" type. You can then re-order them using the "Re-order" link under Artworks.', 'gregstuart-custom-theme' ),
                                array( 'a' => array( 'href' => array() ) )
                            ),
                            esc_url( admin_url( 'post-new.php?post_type=artwork' ) )
                        );
                    ?></p>
                </div>
                <?php
			else : 
				?>
				<div class="gallery-empty"><?php esc_html_e( 'No artworks found in the gallery.', 'gregstuart-custom-theme' ); ?></div>
				<?php
			endif;
			?>
		</div>
	</main>
</div>
<?php
get_footer();
?>
