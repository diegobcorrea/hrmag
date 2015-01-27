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

<?php wp_footer(); ?>

<div class="overlay-error"></div>
<div class="overlay-success"></div>

<div class="step-by-step">
	<div class="close-steps"></div>
</div>

<script type="text/javascript">
// AJAX Functions
var jq = jQuery;

jq(window).bind("scroll", function() {
	//if (jq(this).scrollTop() >700) {
		//jq(".navbar").css({"position":"fixed","top":"0px"});
	//};
});
</script>

</body>
</html>