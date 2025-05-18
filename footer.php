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
				<p class="contact-footer-name">Greg Stuart</p>
				<p class="contact-footer-email">
					<a href="mailto:greg@stuarturbandesign.com">greg@stuarturbandesign.com</a>
				</p>
				<?php
				// Get the URL of the 'About' page.
				// This assumes you have a page with the slug 'about'.
				// If your 'About' page has a different slug, change 'about' accordingly.
				$about_page = get_page_by_path( 'about' );
				if ( $about_page ) :
				?>
				<p class="contact-footer-about">
					<a href="<?php echo esc_url( get_permalink( $about_page->ID ) ); ?>">Learn more about Greg Stuart</a>
				</p>
				<?php endif; ?>
			</div>
			<div class="contact-footer-credit">
				<p>
					Site Managed by
					<a href="https://gravatar.com/christianbcutter" target="_blank" rel="noopener noreferrer">
						Christian Cutter
					</a>
				</p>
			</div>
		</footer><?php wp_footer(); ?>
	</body>
</html>
