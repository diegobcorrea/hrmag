<?php get_header(); ?>

	<div id="single">
		<div class="row small-collapse medium-collapse large-collapse">
			<div class="small-12 medium-12 large-12 columns">
			<?php while ( have_posts() ) : the_post(); ?>
				<figure class="single-image">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-image' ); ?>
					<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>">
					<h1 class="single-title"><?php the_title(); ?></h1>
				</figure>
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<div class="single-content">
							<?php the_content(); ?>
						</div>
						<div class="single-info">
							<div class="single-author-avatar"></div>
							<div class="single-author-name"><?php the_author(); ?></div>
							<div class="single-post-date"><?php the_time('d \d\e F, Y') ?></div>
						</div>
					</div>
				</div>

				<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
			<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div><!-- #single -->

<?php get_footer(); ?>