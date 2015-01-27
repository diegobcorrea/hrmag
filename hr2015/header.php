<!DOCTYPE html>
<html lang="es">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

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

<header id="top-nav" class="noPadding">
	<nav class="row">
		<div class="large-12 columns">
			<ul class="title-area">
				<li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
			</ul>
		</div>
	</nav>
</header>
