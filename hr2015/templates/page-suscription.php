<?php
/**
 * Template Name: Tpl Suscription
 */
?>
<?php get_header(); ?>

	<div id="page-main">
		<div class="row small-collapse medium-collapse large-collapse ohidden">
			<div id="page-header" class="small-12 medium-12 large-12 columns ohidden">
				<?php while ( have_posts() ) : the_post(); ?>
				<h1 class="hide"><?php the_title(); ?></h1>
				<figure class="page-image">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-full' ); ?>
					<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" class="js-fix">
				</figure>
				<?php endwhile; ?>
				<div class="page-title-caption small-7">Recibe noticias, eventos y lo mejor del patinaje cada semana</div>
			</div>
		</div>
		<form id="suscription" class="row ohidden" action="post">
			<div class="small-12 medium-8 large-8 large-centered columns">
				<label for="username" class="item-box">
					<span class="icon-user input-icon"></span>
					<input type="text" id="username" name="username" placeholder="Nombre" />
				</label>
			</div>
			<div class="small-12 medium-8 large-8 large-centered columns">
				<label for="usermail" class="item-box">
					<span class="icon-mail input-icon"></span>
					<input type="text" id="usermail" name="usermail" placeholder="Correo electrónico" />
				</label>
			</div>

			<div class="small-12 medium-8 large-8 large-centered columns submit-box">
				<input type="submit" id="sendSuscription" value="Quiero estar informado">
			</div>
		</form>
	</div>

<?php get_footer(); ?>