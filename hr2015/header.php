<!DOCTYPE html>
<html lang="es">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta property="fb:admins" content="{YOUR_FACEBOOK_USER_ID}"/>
	<meta property="fb:app_id" content="704086572939854"/>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<?php if (is_singular()) : ?>
	<?php 
		$content = get_post_field( 'post_content', $post->ID );
		$content_parts = get_extended( $content );

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'homepage-featured-full' ); 
	?>
	<meta property="og:site_name" content="<?php the_title(); ?>" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:url" content="<?php the_permalink() ?>"/>
	<meta property="og:description" content="<?php echo wp_strip_all_tags($content_parts['main']); ?>" />
	<meta property="og:image" content="<?php echo $image[0]; ?>" />
	<link rel="image_src" href="<?php echo $image[0]; ?>" id="image_src" />
	<!-- if page is others -->
	<?php else : ?>
	<meta property="og:image" content="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png">
	<link rel="image_src" href="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png" id="image_src" />
	<meta property="og:description" content="Blog de patinaje donde encontrarás las útlimas noticias, eventos, reviews y todo el contenido sobre patinaje en un solo lugar.">
	<meta property="og:site_name" content="<?php wp_title( '|', true, 'right' ); ?>">
	<meta property="og:type" content="blog">
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
	<?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if(get_option('hrmag_favicon')): ?>
		<link rel="shortcut icon" href="<?php echo get_option('hrmag_favicon'); ?>" />
	<?php endif; ?>
	
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<?php
	if(get_option('hrmag_analytics')) {
		echo stripslashes (get_option('hrmag_analytics'));
	}
	?>
</head>

<body <?php body_class(); ?>> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=704086572939854&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="content">
	<header id="top-nav" class="noPadding">
		<nav class="row">
			<div class="small-5 medium-5 large-5 columns">
				<figure class="logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/lib/images/site/hrlogo-sm-md.png" alt="HR MAG" width="95" height="25"></a>
				</figure>
			</div>
			<div id="mobile-button" class="icon-menu right hide-for-large"></div>
			<?php wp_nav_menu( array( 'menu' => '2', 'container_class' => 'main_menu small-5 medium-7 large-7 columns hide-for-small hide-for-medium' )); ?>
		</nav>
	</header>
