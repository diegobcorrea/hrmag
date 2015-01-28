<!DOCTYPE html>
<html lang="es">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta property="fb:admins" content="{YOUR_FACEBOOK_USER_ID}"/>
	<meta property="fb:app_id" content="460081534043957"/>

	<?php if (is_single()) : ?>
	<?php

	$name 			= get_post_meta($post->ID, 'name_value', true);
	$lastname 		= get_post_meta($post->ID, 'lastname_value', true);
	$team 			= get_post_meta($post->ID, 'team_value', true);
	$video_type 	= get_post_meta($post->ID, 'video_type_value', true);
	$video_id 		= get_post_meta($post->ID, 'video_id_value', true);
	$imageShare 	= get_post_meta($post->ID, 'video_image_value', true);
	$votes 			= get_post_meta($post->ID, 'votes_value', true);
	$dni 			= get_post_meta($post->ID, 'dni_value', true);

	?>
	<title>Ficha de <?php echo $name; ?> <?php echo $lastname; ?> | Pichanga Tottus</title>

	<meta property="og:site_name" content="Ficha de <?php echo $name; ?> <?php echo $lastname; ?> | Pichanga Tottus" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:url" content="<?php echo get_permalink( $post->ID ) ?>"/>
	<meta property="og:description" content="Vota por <?php echo $name; ?> <?php echo $lastname; ?> en la Pichanga Tottus" />
	<meta property="og:image" content="<?php echo $imageShare; ?>" />
	<link rel="image_src" href="<?php echo $imageShare; ?>" id="image_src" />
	<!-- if page is others -->
	<?php else : ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<meta property="og:image" content="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png">
	<link rel="image_src" href="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png" id="image_src" />
	<meta property="og:description" content="<?php echo $description; ?>">
	<meta property="og:site_name" content="Pichanga Tottus">
	<meta property="og:type" content="blog">
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
	<?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if(get_option('tottus_favicon')): ?>
		<link rel="shortcut icon" href="<?php echo get_option('tottus_favicon'); ?>" />
	<?php endif; ?>
	
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<?php
	if(get_option('tottus_analytics')) {
		echo stripslashes (get_option('tottus_analytics'));
	}
	?>
</head>

<body <?php body_class(); ?>> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=460081534043957&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="content">
	<header id="top-nav" class="noPadding">
		<nav class="row">
			<div class="small-5 medium-5 large-5 columns">
				<figure class="logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/hrlogo-sm-md.png" alt="HR MAG" width="95" height="25"></a>
				</figure>
			</div>
			<div id="mobile-button" class="icon-menu right show-for-small-only"></div>
			<?php wp_nav_menu( array( 'menu' => '2', 'container_class' => 'main_menu small-5 medium-7 large-7 columns hide-for-small' )); ?>
		</nav>
	</header>
