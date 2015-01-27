<?php
/**
 * Template Name: Parallax Page Template
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

get_header(); ?>

	<div id="box" class="block-01 slide" data-section="1" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="logoShield">
				<img src="<?php echo get_template_directory_uri() ?>/images/pichanga_shield.png">
			</div>
			<div class="scrollDown"></div>
		</div>
	</div><!-- #box -->

	<div id="box" class="block-02 slide" data-section="2" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="title-02"></div>
			<form id="participaForm" action="" method="post">
				<fieldset class="info">
					<div class="field">
						<label>Nombre:</label>
						<input type="text" name="name" id="name" class="input-field" required minlength="3"/>
					</div>
					<div class="field">
						<label>Apellido:</label>
						<input type="text" name="lastname" id="lastname" class="input-field" required minlength="3"/>
					</div>
					<div class="field">
						<label>Email:</label>
						<input type="text" name="email" id="email" class="input-field" required/>
					</div>
					<div class="field">
						<label>Ciudad:</label>
						<input type="text" name="city" id="city" class="input-field" required/>
					</div>
					<div class="field">
						<label>Teléfono:</label>
						<input type="text" name="phone" id="phone" class="input-field" required minlength="6" maxlength="9"/>
					</div>
					<div class="field">
						<label>DNI:</label>
						<input type="text" name="dni" id="dni" class="input-field" required minlength="8" maxlength="8"/>
					</div>
					<div class="field flags">
						<label>Elige tu equipo:</label>
						<div class="teams">
							<span>
								<input type="radio" name="team" id="peru" class="input-field" value="peru" required/>
								<label class="choice" for="peru"></label>
							</span>
							<span>
								<input type="radio" name="team" id="brasil" class="input-field" value="brasil" required/>
								<label class="choice" for="brasil"></label>
							</span>
							<span>
								<input type="radio" name="team" id="spain" class="input-field" value="spain" required/>
								<label class="choice" for="spain"></label>
							</span>
							<span>
								<input type="radio" name="team" id="colombia" class="input-field" value="colombia" required/>
								<label class="choice" for="colombia"></label>
							</span>
							<span>
								<input type="radio" name="team" id="holand" class="input-field" value="holand" required/>
								<label class="choice" for="holand"></label>
							</span>
							<span>
								<input type="radio" name="team" id="germany" class="input-field" value="germany" required/>
								<label class="choice" for="germany"></label>
							</span>
							<span>
								<input type="radio" name="team" id="italy" class="input-field" value="italy" required/>
								<label class="choice" for="italy"></label>
							</span>
							<span>
								<input type="radio" name="team" id="argentina" class="input-field" value="argentina" required/>
								<label class="choice" for="argentina"></label>
							</span>
						</div>
					</div>
					<div class="nextStep">
						<img src="<?php echo get_template_directory_uri() ?>/images/block02-btn-next.png" alt="Continuar" />
					</div>
				</fieldset>
				<fieldset class="video">
					<div class="chooseVideoType">
						<div class="type youtube" data-type="youtube"></div>
						<div class="type vimeo" data-type="vimeo"></div>
						<div class="type instagram" data-type="instagram"></div>
					</div>
					<div class="field">
						<label>URL:</label>
						<input type="text" name="url" class="input-video" id="youtube" required/>
						<input type="hidden" name="videoID" id="videoID" />
						<input type="hidden" name="videoType" id="videoType" />
						<input type="hidden" name="videoImage" id="videoImage" />
						<div class="publish">
							<img src="<?php echo get_template_directory_uri() ?>/images/forms/publish-btn.png" alt="Publicar" />
						</div>
					</div>
					<div class="previewVideo">
						<div class="image"></div>
					</div>
					<ul class="notes">
						<li>* Tu video debe ser de 20 segundos máximo.</li>
						<li>* Recuerda que tu jugador  debe contar con una cara impresa.</li>
					</ul>
					<div class="options">
						<a href="#" class="viewProfile"></a>
						<a href="http://maspormenos.com.pe/pichangatottus/estadio/" class="goStadium"></a>
					</div>
				</fieldset>
			</form>
		</div>
	</div><!-- #box -->

	<div id="box" class="block-03 slide" data-section="3" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="title-03"></div>
			<div id="positionList">
				<div class="thead"></div>

				<div id="scrollList">
				<?php

				$votes_list = new WP_Query( array ( 'post_type' => 'fichas', 'orderby' => 'meta_value_num', 'meta_key' => 'votes_value' ) );

				while($votes_list->have_posts()) : $votes_list->the_post(); global $post;

					$name 			= get_post_meta($post->ID, 'name_value', true);
					$lastname 		= get_post_meta($post->ID, 'lastname_value', true);
					$team 			= get_post_meta($post->ID, 'team_value', true);
					$votes 			= get_post_meta($post->ID, 'votes_value', true); 

					$permalink 		= get_permalink( $post->ID );

				?>

					<div id="user-<?php echo $post->ID; ?>" class="userBox">
						<div class="team <?php echo $team; ?>"></div>
						<div class="name"><a href="<?php echo $permalink; ?>"><?php echo $name; ?> <?php echo $lastname; ?></a></div>
						<div class="votes"><?php echo $votes; ?></div>
					</div>

				<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div><!-- #box -->

<?php get_footer(); ?>