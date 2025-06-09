<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Greg_Stuart_Custom_Theme
 */
?>
		</main><footer id="colophon" class="site-footer contact-footer"> <?php // Added 'contact-footer' class ?>
			<div class="contact-footer-info">
				<p class="contact-footer-name"><?php echo esc_html( get_theme_mod( 'gregstuart_contact_name', 'Greg Stuart' ) ); ?></p>
				<p class="contact-footer-email">
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'gregstuart_contact_email', 'greg@stuarturbandesign.com' ) ); ?>">
						<?php echo esc_html( get_theme_mod( 'gregstuart_contact_email', 'greg@stuarturbandesign.com' ) ); ?>
					</a>
				</p>
				<?php
				// Get the URL of the 'About' page.
				// This assumes you have a page with the slug 'about'.
				// If your 'About' page has a different slug, change 'about' accordingly.
				$about_page_url = gregstuart_get_page_url_by_slug( 'about' );
				if ( $about_page_url ) :
				?>
				<p class="contact-footer-about">
					<a href="<?php echo esc_url( $about_page_url ); ?>">
						<?php printf( esc_html__( 'Learn more about %s', 'gregstuart-custom-theme' ), esc_html( get_theme_mod( 'gregstuart_contact_name', 'Greg Stuart' ) ) ); ?>
					</a>
				</p>
				<?php endif; ?>
			</div>
			<div class="contact-footer-credit">
				<p>
					<?php esc_html_e( 'Site Managed by', 'gregstuart-custom-theme' ); ?>
					<a href="<?php echo esc_url( get_theme_mod( 'gregstuart_site_manager_url', 'https://gravatar.com/christianbcutter' ) ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( get_theme_mod( 'gregstuart_site_manager_name', 'Christian Cutter' ) ); ?>
					</a>
				</p>
			</div>
		</footer><?php wp_footer(); ?>
	</body>
</html>
