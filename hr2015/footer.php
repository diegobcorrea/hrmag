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
		<div class="medium-3 large-3 columns hide-for-small">
			<figure class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/images/hrlogo-sm-md.png" alt="HR MAG" width="95" height="25">
			</figure>
		</div>
		<div id="footer-nav" class="small-8 medium-6 large-7 columns">
			<ul>
				<li class="hide-for-small"><a href="#">Contacto</a></li>
				<li class="hide-for-small"><a href="#">Equipo HRMag</a></li>
				<li class="hide-for-small"><a href="#">Únete al equipo</a></li>
				<li class="hide-for-small"><a href="#">Publicidad</a></li>
				<li><a href="#test">Suscríbete</a></li>
			</ul>
		</div>
		<div id="footer-redes" class="small-4 medium-3 large-3 columns">
			<figure class="twitter right">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-twitter.png" alt="Twitter HRmag" width="35" height="35"></a>
			</figure>
			<figure class="facebook right">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-facebook.png" alt="Facebook HRmag" width="35" height="35"></a>
			</figure>
		</div>
	</footer><!-- End footer -->
</div>

<?php wp_footer(); ?>

<script type="text/javascript">
var jq = jQuery;
jq(document).foundation({
	"magellan-expedition": {
		active_class: 'active',
	}
});
</script>

</body>
</html>