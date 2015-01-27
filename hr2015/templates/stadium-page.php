<?php
/**
 * Template Name: Estadio Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('estadio'); ?>

	<script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script>
	<div id="box" class="block-stadium slide" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="wideScreen">
				<div class="loading"></div>
			</div>
			<div id="people-mainSlider">
				<ul class="wrapper">
					<li id="people" class="slide-1">
					<?php 

					global $wpdb, $fichaID, $name, $lastname, $team, $video_type, $video_id, $imageShare, $votes;
					$people = 1;

					$querystr = "SELECT  SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
					INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND wp_posts.post_type = 'fichas' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') AND ( (wp_postmeta.meta_key = 'video_active_value' AND CAST(wp_postmeta.meta_value AS SIGNED) = '1')
					AND  (mt1.meta_key = 'slide_value' AND CAST(mt1.meta_value AS SIGNED) = '1') ) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 10";

					$fichas = $wpdb->get_results($querystr); ?>
					<script type="text/javascript">
					var jq =jQuery.noConflict();

		            jq(document).ready(function() {
					<?php

					if( !empty($fichas) ):
					foreach ($fichas as $ficha) :
						$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
						$fichaID 		= $ficha->ID;

						$name 			= get_post_meta($fichaID, 'name_value', true);
						$lastname 		= get_post_meta($fichaID, 'lastname_value', true);
						$team 			= get_post_meta($fichaID, 'team_value', true);
						$video_type 	= get_post_meta($fichaID, 'video_type_value', true);
						$video_id 		= get_post_meta($fichaID, 'video_id_value', true);
						$imageShare 	= get_post_meta($fichaID, 'video_image_value', true);
						$votes 			= get_post_meta($fichaID, 'votes_value', true);
						$position 		= get_post_meta($fichaID, 'position_value', true);

						if( isset($team) ) $background_image = '"background-image" : "url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/person/p-'.$team.'.png)"';

					?>
		            	jq('.person[data-postid="<?php echo $position ?>"]').css({<?php echo $background_image; ?>, "background-color" : "transparent"}).attr('id','<?php echo $fichaID; ?>');
					<?php endforeach; ?>
					<?php endif; ?>
					});
					</script>
					<?php

					while ($people <= 85) : 
						global $fichaID;

						if( !empty($fichas) ){
							if( in_array_r($people, $ficha_used) ){
								$used = " in-use"; 
							}
						}else{ 
							$used = " free"; 
							$postID = "0";
						};

					?>
						<div id="" class="person<?php if ($people % 17 == 0) echo " last"; ?><?php echo $used; ?>" data-slide="1"  data-postid="<?php echo $people; ?>"></div>
					<?php $people++; ?>
					<?php endwhile; ?>
					</li>

					<li id="people" class="slide-2">
					<?php 

					global $wpdb, $fichaID, $name, $lastname, $team, $video_type, $video_id, $imageShare, $votes;
					$people = 86;

					$querystr = "SELECT  SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
					INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND wp_posts.post_type = 'fichas' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') AND ( (wp_postmeta.meta_key = 'video_active_value' AND CAST(wp_postmeta.meta_value AS SIGNED) = '1')
					AND  (mt1.meta_key = 'slide_value' AND CAST(mt1.meta_value AS SIGNED) = '2') ) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 10";

					$fichas = $wpdb->get_results($querystr); ?>
					<script type="text/javascript">
					var jq =jQuery.noConflict();

		            jq(document).ready(function() {
					<?php

					foreach ($fichas as $ficha) :
						$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
						$fichaID 		= $ficha->ID;

						$name 			= get_post_meta($fichaID, 'name_value', true);
						$lastname 		= get_post_meta($fichaID, 'lastname_value', true);
						$team 			= get_post_meta($fichaID, 'team_value', true);
						$video_type 	= get_post_meta($fichaID, 'video_type_value', true);
						$video_id 		= get_post_meta($fichaID, 'video_id_value', true);
						$imageShare 	= get_post_meta($fichaID, 'video_image_value', true);
						$votes 			= get_post_meta($fichaID, 'votes_value', true);
						$position 		= get_post_meta($fichaID, 'position_value', true);

						if( isset($team) ) $background_image = '"background-image" : "url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/person/p-'.$team.'.png)"';

					?>
		            	jq('.person[data-postid="<?php echo $position ?>"]').css({<?php echo $background_image; ?>, "background-color" : "transparent"}).attr('id','<?php echo $fichaID; ?>');
					<?php endforeach; ?>
					});
					</script>
					<?php

					while ($people <= 170) : 
						global $fichaID;

						if( in_array_r($people, $ficha_used) ){
							$used = " in-use"; 
						}else{ 
							$used = " free"; 
							$postID = "0";
						};

					?>
						<div id="" class="person<?php if ($people % 17 == 0) echo " last"; ?><?php echo $used; ?>" data-slide="2"  data-postid="<?php echo $people; ?>"></div>
					<?php $people++; ?>
					<?php endwhile; ?>
					</li>

					<li id="people" class="slide-3">
					<?php 

					global $wpdb, $fichaID, $name, $lastname, $team, $video_type, $video_id, $imageShare, $votes;
					$people = 171;

					$querystr = "SELECT  SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
					INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND wp_posts.post_type = 'fichas' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') AND ( (wp_postmeta.meta_key = 'video_active_value' AND CAST(wp_postmeta.meta_value AS SIGNED) = '1')
					AND  (mt1.meta_key = 'slide_value' AND CAST(mt1.meta_value AS SIGNED) = '3') ) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 10";

					$fichas = $wpdb->get_results($querystr); ?>
					<script type="text/javascript">
					var jq =jQuery.noConflict();

		            jq(document).ready(function() {
					<?php

					foreach ($fichas as $ficha) :
						$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
						$fichaID 		= $ficha->ID;

						$name 			= get_post_meta($fichaID, 'name_value', true);
						$lastname 		= get_post_meta($fichaID, 'lastname_value', true);
						$team 			= get_post_meta($fichaID, 'team_value', true);
						$video_type 	= get_post_meta($fichaID, 'video_type_value', true);
						$video_id 		= get_post_meta($fichaID, 'video_id_value', true);
						$imageShare 	= get_post_meta($fichaID, 'video_image_value', true);
						$votes 			= get_post_meta($fichaID, 'votes_value', true);
						$position 		= get_post_meta($fichaID, 'position_value', true);

						if( isset($team) ) $background_image = '"background-image" : "url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/person/p-'.$team.'.png)"';

					?>
		            	jq('.person[data-postid="<?php echo $position ?>"]').css({<?php echo $background_image; ?>, "background-color" : "transparent"}).attr('id','<?php echo $fichaID; ?>');
					<?php endforeach; ?>
					});
					</script>
					<?php

					while ($people <= 255) : 
						global $fichaID;

						if( in_array_r($people, $ficha_used) ){
							$used = " in-use"; 
						}else{ 
							$used = " free"; 
							$postID = "0";
						};

					?>
						<div id="" class="person<?php if ($people % 17 == 0) echo " last"; ?><?php echo $used; ?>" data-slide="3"  data-postid="<?php echo $people; ?>"></div>
					<?php $people++; ?>
					<?php endwhile; ?>
					</li>

					<li id="people" class="slide-4">
					<?php 

					global $wpdb, $fichaID, $name, $lastname, $team, $video_type, $video_id, $imageShare, $votes;
					$people = 256;

					$querystr = "SELECT  SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
					INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND wp_posts.post_type = 'fichas' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private') AND ( (wp_postmeta.meta_key = 'video_active_value' AND CAST(wp_postmeta.meta_value AS SIGNED) = '1')
					AND  (mt1.meta_key = 'slide_value' AND CAST(mt1.meta_value AS SIGNED) = '4') ) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 10";

					$fichas = $wpdb->get_results($querystr); ?>
					<script type="text/javascript">
					var jq =jQuery.noConflict();

		            jq(document).ready(function() {
					<?php

					foreach ($fichas as $ficha) :
						$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
						$fichaID 		= $ficha->ID;

						$name 			= get_post_meta($fichaID, 'name_value', true);
						$lastname 		= get_post_meta($fichaID, 'lastname_value', true);
						$team 			= get_post_meta($fichaID, 'team_value', true);
						$video_type 	= get_post_meta($fichaID, 'video_type_value', true);
						$video_id 		= get_post_meta($fichaID, 'video_id_value', true);
						$imageShare 	= get_post_meta($fichaID, 'video_image_value', true);
						$votes 			= get_post_meta($fichaID, 'votes_value', true);
						$position 		= get_post_meta($fichaID, 'position_value', true);

						if( isset($team) ) $background_image = '"background-image" : "url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/person/p-'.$team.'.png)"';

					?>
		            	jq('.person[data-postid="<?php echo $position ?>"]').css({<?php echo $background_image; ?>, "background-color" : "transparent"}).attr('id','<?php echo $fichaID; ?>');
					<?php endforeach; ?>
					});
					</script>
					<?php

					while ($people <= 340) : 
						global $fichaID;

						if( in_array_r($people, $ficha_used) ){
							$used = " in-use"; 
						}else{ 
							$used = " free"; 
							$postID = "0";
						};

					?>
						<div id="" class="person<?php if ($people % 17 == 0) echo " last"; ?><?php echo $used; ?>" data-slide="4"  data-postid="<?php echo $people; ?>"></div>
					<?php $people++; ?>
					<?php endwhile; ?>
					</li>
				</ul>
				<div class="clearfix"></div>
		        <a class="prev" id="mainSlider_prev" href="#"><span>prev</span></a>
		        <a class="next" id="mainSlider_next" href="#"><span>next</span></a>
			</div>

			<script type="text/javascript">
			var jq =jQuery.noConflict();
			var jqf = $f;

            jq(document).ready(function() {
            	jq('.person.in-use').click(function(){
            		var ID 		= jq(this).attr('id');

            		jq('.wideScreen').empty();
            		jq('.wideScreen').css({'background-image': 'url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png)'});

            		jq.ajax({
						type: 'POST',         
						url: apfajax.ajaxurl,
						data: {
							action: 'show_video',
							postID: ID,
						},
						success: function(data, textStatus, XMLHttpRequest) {
							var objData = jq.parseJSON(data);
							jq('.wideScreen').css({'background-image': 'url('+objData.screen+')'});
							jq('.wideScreen').append('<div class="playerInfo"></div>');
							jq('.wideScreen').append('<div class="playerVideo"></div>');
							jq('.wideScreen').append('<div class="embedVideo"></div>');
							jq('.wideScreen .playerInfo').append('<div class="playerName">'+objData.name+'</div>');
							jq('.wideScreen .playerInfo').append('<div class="playerTeam">'+objData.team+'</div>');
							jq('.wideScreen .playerInfo').append('<div class="playerVotes">'+objData.votes+'</div>');

							jq('.wideScreen .playerVideo').append('<div class="playerImage"><img src="'+objData.image+'"/></div>');
							jq('.wideScreen .playerVideo').append('<div class="viewVideo"></div>');

							jq('.wideScreen .embedVideo').append(objData.video);

							jq('.wideScreen').append(objData.footer);

							jq('.viewVideo').click(function() {
								jq('.embedVideo').show();
							});

							jq('.backInfo').click(function() {
								if(objData.type == 'youtube'){
									jq("#popup-youtube-player")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*'); 
								}
								else if(objData.type == 'vimeo'){
									var iframe = jq('#vimeo-player')[0];
									var player = jqf(iframe);

									player.api('pause');
								};
								jq('.embedVideo').hide();
							});
						},
						error: function(MLHttpRequest, textStatus, errorThrown) {
							alert(errorThrown);
						}

					});
            	});

				
            });
			</script>
		</div>
	</div><!-- #box -->

<?php get_footer(); ?>