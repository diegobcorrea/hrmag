<?php get_header(); ?>

	<div id="post-promoted">
		<div class="row small-collapse medium-collapse large-collapse">
			<div class="small-12 medium-12 large-12 columns">
				<?php 

				$query = new WP_Query( array( 
					'posts_per_page' => 1, 
					'order' => 'DESC',
				)); 

				?>
				<?php if ($query->have_posts()) : $slide = 1; ?>
		    	<?php while ( $query->have_posts() ) : $query->the_post(); global $post; ?>
				<div class="row small-collapse medium-collapse large-collapse">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'homepage-featured-full' ); ?>
					<figure id="image-promoted" class="small-12 medium-12 large-12" style="background-image: url(<?php echo $image[0] ?>)">
						
						<!-- <a href="<?php the_permalink(); ?>"><img src="<?php // echo $image[0] ?>" alt="<?php the_title(); ?>" /></a> -->
					</figure>
				</div>
				<div id="post-info" class="small-12 medium-7 large-6 columns">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="author-box">
						<figure class="avatar">
							<?php echo get_wp_user_avatar(); ?>
						</figure>
						<div class="author-info">
							<div class="author-name"><?php the_author(); ?></div>
							<div class="date-post"><?php the_time('d \d\e F, Y') ?></div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>	
				<?php endif; ?>	
			</div>
		</div>
	</div><!-- #post-promoted -->
	<div id="post-list">
		<div class="row">
			<?php 

			$query = new WP_Query( array( 
				'posts_per_page' => 6, 
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