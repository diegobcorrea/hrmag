<?php
/**
 * Template Name: Tpl Suscription
 */
?>
<?php get_header(); ?>

	<div id="page-main" class="page-content">
		<div class="row small-collapse medium-collapse large-collapse ohidden">
			<div id="page-header" class="small-12 medium-12 large-12 columns ohidden">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'page-full' ); ?>
				<div class="page-image" style="background-image: url(<?php echo $image[0] ?>)">
					<h1 class="page-title-caption">Recibe noticias, eventos y lo mejor del patinaje cada semana</h1>
				</div>
				<?php endwhile; ?>
			</div>
		</div>
		<div class="row small-collapse medium-collapse large-collapse ohidden">
			<h2 class="text-center small-12 medium-6 large-6 medium-centered large-centered columns">Ingresa tus datos</h2>
		</div>
		<form id="suscription" class="row ohidden" action="post" validate >
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="username" class="item-box">
					<span class="icon-user input-icon"></span>
					<input type="text" id="username" name="username" placeholder="Nombre completo" required />
				</label>
			</div>
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="usermail" class="item-box">
					<span class="icon-mail input-icon"></span>
					<input type="email" id="usermail" name="usermail" placeholder="Correo electrónico" required />
				</label>
			</div>

			<div class="small-12 medium-6 large-8 medium-centered large-centered columns submit-box">
				<input type="submit" id="sendSuscription" value="Quiero estar informado">
			</div>
		</form>
	</div>

	<div id="post-list">
		<div class="row">
			<h2 class="small-12 medium-12 large-12 columns text-center">Últimas Publicaciones</h2>
			<?php 

			$query = new WP_Query( array( 
				'posts_per_page' => 3, 
				'order' => 'DESC',
				'offset' => 1
			)); 

			?>
			<?php if ($query->have_posts()) : $slide = 1; ?>
	    	<?php while ( $query->have_posts() ) : $query->the_post(); global $post; ?>
			<article id="post-<?php the_ID(); ?>" class="post small-12 medium-6 large-4 columns">
				<figure class="post-image">
					<div class="count-comments">
						<span class="icon-comment"></span>
						<fb:comments-count href="<?php the_permalink(); ?>"></fb:comments-count>
					</div>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-image' ); ?>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" height="180" width="290"></a>
				</figure>
				<h2 class="post-title border-bottom"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="post-footer">
					<div class="author-name left"><?php the_author(); ?></div>
					<div class="date-post right"><?php the_time('d \d\e F, Y') ?></div>
				</div>
			</article>
			<?php endwhile; ?>	
			<?php endif; ?>
			</div>
		</div>
	</div><!-- #post-list -->

<?php get_footer(); ?>