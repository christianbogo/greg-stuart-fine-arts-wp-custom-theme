<?php
/**
 * Template Name: Sketches Page
 *
 * This is the template that displays artworks categorized as "Sketch"
 * using custom order and includes their descriptions from the Media Library.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Greg_Stuart_Custom_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="sketches-page page">
			<header class="sketches-header">
				<h1 class="sketches-title">Greg's Sketches</h1>
				<div class="sketches-intro">
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
			// WP_Query arguments to fetch "Sketch" artworks.
			$args = array(
				'post_type'      => 'artwork',         
				'posts_per_page' => -1,                
				'tax_query'      => array(
					array(
						'taxonomy' => 'artwork_type',  
						'field'    => 'slug',
						'terms'    => 'sketch',        
					),
				),
				'orderby'        => 'menu_order', // Use custom order
				'order'          => 'ASC',        // Typically ASC for menu_order
			);

			$sketches_query = new WP_Query( $args );

			if ( $sketches_query->have_posts() ) :
				echo '<div class="sketches-grid">'; 

				while ( $sketches_query->have_posts() ) : $sketches_query->the_post();
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
					<div class="sketches-item">
						<?php if ( has_post_thumbnail() && $full_image_url ) : ?>
							<div class="sketches-image-container">
								<a href="<?php echo esc_url( $full_image_url ); ?>"
								   class="glightbox"
								   data-gallery="greg-stuart-sketches"
								   data-title="<?php echo esc_attr( $artwork_title ); ?>"
								   data-description="<?php echo esc_attr( wp_strip_all_tags( $artwork_description ) ); ?>">
									<?php
									the_post_thumbnail('medium_large', ['class' => 'sketches-image', 'alt' => esc_attr( $artwork_title )]);
									?>
								</a>
							</div>
						<?php else : ?>
							<div class="sketches-image-placeholder"><?php esc_html_e( 'Image unavailable', 'gregstuart-custom-theme' ); ?></div>
						<?php endif; ?>
						<h2 class="sketches-item-title"><?php echo esc_html( $artwork_title ); ?></h2>
						<?php if ( ! empty( $artwork_description ) ) : ?>
							<p class="sketches-item-description"><?php echo nl2br( esc_html( wp_strip_all_tags( $artwork_description ) ) ); ?></p>
						<?php endif; ?>
					</div>
					<?php
				endwhile;
				echo '</div>'; 
				wp_reset_postdata(); 
            elseif (current_user_can('edit_posts')) : 
                ?>
                <div class="sketches-empty">
                     <p><?php esc_html_e( 'No artworks found in the "Sketch" category.', 'gregstuart-custom-theme' ); ?></p>
                    <p><?php
                        printf(
                            wp_kses(
                                __( 'Ready to add some? <a href="%1$s">Add a new artwork</a> and assign it to the "Sketch" type. You can then re-order them using the "Re-order" link under Artworks.', 'gregstuart-custom-theme' ),
                                array( 'a' => array( 'href' => array() ) )
                            ),
                            esc_url( admin_url( 'post-new.php?post_type=artwork' ) )
                        );
                    ?></p>
                </div>
                <?php
			else : 
				?>
				<div class="sketches-empty"><?php esc_html_e( 'No sketches available at the moment.', 'gregstuart-custom-theme' ); ?></div>
				<?php
			endif;
			?>
		</div>
	</main>
</div>
<?php
get_footer();
?>
