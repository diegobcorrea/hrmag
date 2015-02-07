<?php get_header(); ?>

	<div id="post-promoted">
		<?php if ( have_posts() ) : ?>
		<div id="category-title" class="row small-collapse medium-collapse large-collapse">
			<h1><?php printf( __( '%s', 'twentytwelve' ), single_cat_title( '', false ) ); ?></h1>
		</div>
		<?php endif; ?>
		<div class="row small-collapse medium-collapse large-collapse">
			<div class="small-12 medium-12 large-12 columns">
				<div class="row small-collapse medium-collapse large-collapse">
					<figure id="image-promoted" class="small-12 medium-12 large-12">
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/temp/featured-1000x400.jpg" alt="Esto es un post patrocinado" class="hide-for-small-only"></a>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/temp/featured-640x360.jpg" alt="Esto es un post patrocinado" class="show-for-small-only"></a>
					</figure>
				</div>
				<div id="post-info" class="small-12 medium-7 large-6 columns">
					<h2><a href="#">Este es un post patrocinado por alguna marca o tienda</a></h2>
					<div class="author-box">
						<figure class="avatar">
							<img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/temp/avatar-mr-roller.png" alt="Mr.Roller" height="50" width="50">
						</figure>
						<div class="author-info">
							<div class="author-name">Mr. Roller</div>
							<div class="date-post">8 de Febrero 2015</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- #post-promoted -->
	<div id="post-list">
		<div class="row">
			<?php if ( have_posts() ) : ?>
	    	<?php while ( have_posts() ) : the_post(); global $post; ?>
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
	</div><!-- #post-list -->

<?php get_footer(); ?>