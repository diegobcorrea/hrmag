<?php get_header(); ?>

	<div id="single-main">
		<div id="hr-read-progress" style="display: none;">
			<div class="row large-collapse">
				<div class="small-12 medium-10 large-8 medium-centered large-centered columns">
					<div class="hr-text"><span id="hr-read-progress-percent">0</span> Leído</div>
					<div id="hr-progress-bar">
						<div class="progress" style="width: 30%;"><span class="value">30%</span></div>
					</div>
	    		</div>		
			</div>
		</div>
		<div id="hr-next-previous-posts" class="row navigation" style="display: none;">
			<div class="nav-box previous hide-for-small medium-5 large-4 columns">
			<?php $prevPost = get_previous_post(true); if($prevPost): ?>
			<?php $prevthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $prevPost->ID) ); ?>
				<a href="<?php echo get_permalink( $prevPost->ID ); ?>" class="hr-featured-image">
					<img src="<?php echo $prevthumbnail[0] ?>" alt="<?php echo get_the_title( $prevPost->ID ); ?>">
				</a>
				<span class="next-prev-title-span"><a href="<?php echo get_permalink( $prevPost->ID ); ?>">Ver anterior</a></span>
				<a href="<?php echo get_permalink( $prevPost->ID ); ?>" class="next-prev-title"><?php echo get_the_title( $prevPost->ID ); ?></a>
			<?php else: ?>
				<span class="next-prev-title-span">No hay artículos antiguos</span>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="next-prev-title">Volver al inicio</a>
			<?php endif; ?>
			</div>

			<div class="nav-box next small-12 medium-5 large-4 columns">
			<?php $nextPost = get_next_post(true); if($nextPost): ?>
			<?php $nextthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $nextPost->ID) ); ?>
				<a href="<?php echo get_permalink( $nextPost->ID ); ?>" class="hr-featured-image hide-for-small">
					<img src="<?php echo $nextthumbnail[0] ?>" alt="<?php echo get_the_title( $nextPost->ID ); ?>">
				</a>
				<span class="next-prev-title-span"><a href="<?php echo get_permalink( $nextPost->ID ); ?>">Ver siguiente</a></span>
				<a href="<?php echo get_permalink( $nextPost->ID ); ?>" class="next-prev-title"><?php echo get_the_title( $nextPost->ID ); ?></a>
			<?php else: ?>
				<span class="next-prev-title-span">No hay artículos nuevos</span>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="next-prev-title">Volver al inicio</a>
			<?php endif; ?>
			</div>
		</div>

		<div class="row small-collapse medium-collapse large-collapse">
			<div class="small-12 medium-12 large-12 columns">
			<?php while ( have_posts() ) : the_post(); ?>
				<figure class="single-image">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'homepage-featured-full' ); ?>
					<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" class="js-fix">
					<h1 class="single-title"><?php the_title(); ?></h1>
				</figure>
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<div class="single-content">
							<?php the_content(); ?>
						</div>
						<div class="single-social">
						    <div class="fb-box">
						        <iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;width=100&amp;layout=box_count&amp;action=recommend&amp;show_faces=true&amp;share=false&amp;height=65&amp;appId=704086572939854" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:65px; width: 93px;" allowTransparency="true"></iframe>
						    </div>
						    <div class="twitter-box">
						        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								<iframe scrolling="no" frameborder="0" allowtransparency="true" src="https://platform.twitter.com/widgets/tweet_button.1352365724.html#_=1354037601139&amp;count=vertical&amp;id=twitter-widget-3&amp;lang=en&amp;original_referer=https%3A%2F%2Fdev.twitter.com%2Fdocs%2Ftweet-button%2Ffaq%23custom-shortener-count&amp;size=m&amp;text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" class="twitter-share-button twitter-count-vertical" style="width: 55px; height: 62px;" title="Twitter Tweet Button" data-twttr-rendered="true"></iframe>
						    </div>
						    <div class="gplus-box">
								<div class="g-plusone" data-size="tall"></div>
						    </div>
						</div>
						<div class="single-info">
							<div class="single-author-avatar"><?php echo get_wp_user_avatar(); ?></div>
							<div class="single-author-name"><?php the_author(); ?></div>
							<div class="single-post-date"><?php the_time('d \d\e F, Y') ?></div>
						</div>
					</div>
				</div>

				<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
			<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>