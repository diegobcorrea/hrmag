<?php
/**
 * Template Name: Tpl Contact
 */
?>
<?php get_header(); ?>

	<div id="page-main" class="page-content text-center">
		<div class="row small-collapse medium-collapse large-collapse ohidden">
			<div class="medium-10 large-8 medium-centered large-centered columns">
				<h1>HRmag.la es fácil de contactar</h1>
				<p>Solo tienes que escribirnos mediante alguno de estos canales y te responderemos lo mas rápido posible:</p>
			</div>

			<div class="fb socbox medium-4 large-4 columns">
				<h3>Facebook</h3>
				<div class="socialInfo">
					<a href="https://www.facebook.com/heyroller" target="_blank">
						<span class="icon-facebook contact-icon"></span>
						<p>/heyroller</p>
					</a>
				</div>
			</div>
			<div class="tw socbox medium-4 large-4 columns">
				<h3>Twitter</h3>
				<div class="socialInfo">
					<a href="http://www.twitter.com/hrollermag" target="_blank">
						<span class="icon-twitter contact-icon"></span>
						<p>/hrollermag</p>
					</a>
				</div>
			</div>
			<div class="ml socbox medium-4 large-4 columns">
				<h3>Correo electrónico</h3>
				<div class="socialInfo">
					<a href="mailto:hola@hrmag.la">
						<span class="icon-email contact-icon"></span>
						<p>hola@hrmag.la</p>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div id="post-list">
		<div class="row">
			<h2 class="small-12 medium-12 large-12 columns text-center">Últimas Publicaciones</h2>
			<?php 

			$query = new WP_Query( array( 
				'posts_per_page' => 3, 
				'order' => 'DESC',
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
				<div class="post-content hide-for-small">
					<?php the_excerpt(); ?>
				</div>
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