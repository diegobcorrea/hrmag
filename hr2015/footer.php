<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<footer class="row">
		<div class="medium-2 large-3 columns hide-for-small">
			<figure class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/hrlogo-sm-md.png" alt="HR MAG" width="95" height="25">
			</figure>
		</div>
		<div class="footer-nav small-8 medium-8 large-7 columns">
			<?php wp_nav_menu( array( 'menu' => '1', 'container_class' => '' )); ?>
		</div>
		<div class="footer-redes small-4 medium-2 large-2 columns">
			<figure class="twitter right">
				<a href="https://www.facebook.com/heyroller" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/icon-twitter.png" alt="Twitter HRmag" width="35" height="35"></a>
			</figure>
			<figure class="facebook right">
				<a href="https://twitter.com/hrollermag" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/icon-facebook.png" alt="Facebook HRmag" width="35" height="35"></a>
			</figure>
		</div>
	</footer><!-- End footer -->
</div>

<?php wp_footer(); ?>
<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'es-419'}</script>

</body>
</html>