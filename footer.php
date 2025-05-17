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
    </main><footer id="colophon" class="site-footer">
        <?php // Your ContactFooter equivalent will go here eventually ?>
        <div class="site-info" style="text-align:center; padding: 20px; background-color: #f0f0f0;">
            &copy; <?php echo date_i18n( 'Y' ); ?> <?php bloginfo( 'name' ); ?>.
            <?php /* <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'gregstuart-custom-theme' ) ); ?>">
                <?php printf( esc_html__( 'Proudly powered by %s', 'gregstuart-custom-theme' ), 'WordPress' ); ?>
            </a> */ ?>
        </div></footer><?php wp_footer(); ?>
</body>
</html>