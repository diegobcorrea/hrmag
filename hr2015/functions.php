<?php
/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

define("THEME_THEMENAME", 'HRMAG 2015');

define("THEME_LIB_URL", get_template_directory_uri(). '/lib/');
define('THEME_FRAMEWORK', get_template_directory() . '/lib/');
define("THEME_ADMIN", THEME_FRAMEWORK . '/admin');
define("THEME_IMAGES_URL", get_template_directory_uri(). '/lib/images/');
define("THEME_FUNCTIONS_PATH", TEMPLATEPATH . '/lib/functions/');
define("THEME_CSS_URL", get_template_directory_uri() . '/lib/css/');
define("THEME_SCRIPT_URL", get_template_directory_uri() . '/lib/js/');
define("THEME_UTILS_URL", get_template_directory_uri() . '/lib/utils/');
define("THEME_TIMTHUMB_URL", THEME_UTILS_URL . 'timthumb.php');

$uploadsdir=wp_upload_dir();
define("THEME_UPLOADS_URL", $uploadsdir['url']);

if(is_admin()){

	add_action('admin_enqueue_scripts', 'theme_admin_init');
	add_action('admin_head', 'theme_admin_head_add');

	/**
	 * Enqueues the JavaScript files needed depending on the current section.
	 */
	function theme_admin_init(){

		//enqueue the script and CSS files for the TinyMCE editor formatting buttons and Upload functionality
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('theme-page-options',THEME_SCRIPT_URL.'page-options.js');
		wp_enqueue_script('theme-metaboxes-options',THEME_SCRIPT_URL.'metaboxes_scripts.js');
		wp_enqueue_script('theme-myupload-options',THEME_SCRIPT_URL.'my_upload.js');
		wp_enqueue_script('theme-options',THEME_SCRIPT_URL.'options.js');
		
		

		//set the style files
		add_editor_style('lib/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('theme-page-style',THEME_CSS_URL.'page_style.css');
		wp_enqueue_style('theme-metaboxes-style',THEME_CSS_URL.'metaboxes_styles.css');

	}

	/**
	 * Inserts scripts for initializing the JavaScript functionality for the relevant section.
	 */
	function theme_admin_head_add(){
		
		//create JavaScript variables that will be accessible globally from all scripts
		echo '<script type="text/javascript">
		pexetoUploadHandlerUrl="'.THEME_UTILS_URL.'upload-handler.php",
		pexetoUploadsUrl="'.THEME_UPLOADS_URL.'";
		</script>';
	}

}

//------ Twitter OAuth ------//
require_once ('includes/twitteroauth.php');

//------ Load Widgets ------//
require_once ('includes/widgets/datetime-widget.php');
require_once ('includes/widgets/twitter-widget.php');
require_once ('includes/widgets/recent-posts-widget.php');
require_once ('includes/widgets/select-pages-widget.php');

//------ THEME OPTIONS PANEL ------//
require_once('theme-options/options-init.php');

require_once (THEME_FUNCTIONS_PATH.'type-pichanga.php'); 
require_once (THEME_FUNCTIONS_PATH.'meta.php');  //adds the custom meta fields to the posts and pages

function theme_setup() {

	load_theme_textdomain( 'theme', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	//------ Post Formats ------//
	add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'theme' ) );
	register_nav_menu( 'top', __( 'Top Menu', 'theme' ) );
	register_nav_menu( 'left', __( 'Left Menu', 'theme' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	add_image_size( 'homepage-thumb', 230, 130, true );
	add_image_size( 'slider-image', 630, 280, true );
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Add intermediate image sizes to media gallery modal dialog
 */
 
function image_sizes_attachment_fields_to_edit( $form_fields, $post ) {
    if ( !is_array( $imagedata = wp_get_attachment_metadata( $post->ID ) ) )
        return $form_fields;
 
    if ( is_array($imagedata['sizes']) ) :
        foreach ( $imagedata['sizes'] as $size => $val ) :
            if ( $size != 'thumbnail' && $size != 'medium' && $size != 'large' ) :
                $css_id = "image-size-{$size}-{$post->ID}";
                $html .= '<div class="image-size-item"><input type="radio" name="attachments[' . $post->ID . '][image-size]" id="' . $css_id . '" value="' . $size . '" />';
                $html .= '<label for="' . $css_id . '">' . $size . '</label>';
                $html .= ' <label for="' . $css_id . '" class="help">' . sprintf( __("(%d&nbsp;&times;&nbsp;%d)"), $val['width'], $val['height'] ). '</label>';
                $html .= '</div>';
            endif;
        endforeach;
    endif;
 
    $form_fields['image-size']['html'] .= $html;
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'image_sizes_attachment_fields_to_edit', 100, 2 );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/includes/custom-header.php' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function theme_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script('jquery');
	wp_enqueue_script('theme-js-foundation', get_template_directory_uri() . '/js/foundation.min.js');
	wp_enqueue_script('theme-js-modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js');
	wp_enqueue_script('theme-js-validate', get_template_directory_uri() . '/js/jquery.validate.js');

	wp_enqueue_script('theme-js-global', get_template_directory_uri() . '/js/global.js');

    wp_localize_script( 'theme-js-global', 'apfajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
	wp_enqueue_style( 'theme-base', get_template_directory_uri() . '/css/hrstyle.css', array( 'theme-style' ), '20131002' );

}
add_action( 'wp_enqueue_scripts', 'theme_scripts_styles' );

function theme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'theme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'theme_wp_title', 10, 2 );

function theme_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'theme_page_menu_args' );

function theme_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'theme' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'theme' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'theme' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Main Area', 'theme' ),
		'id' => 'main-area',
		'description' => __( 'Appears on front page area - Static Front Page', 'theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title" style="display:none">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

if ( ! function_exists( 'theme_content_nav' ) ) :

function theme_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php  echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php  _e( 'Post navigation', 'theme' ); ?></h3>
			<div class="nav-previous alignleft"><?php  next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'theme' ) ); ?></div>
			<div class="nav-next alignright"><?php  previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'theme' ) ); ?></div>
		</nav><!-- #<?php  echo $html_id; ?> .navigation -->
	<?php  endif;
}
endif;

if ( ! function_exists( 'theme_comment' ) ) :

function theme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php  comment_class(); ?> id="comment-<?php  comment_ID(); ?>">
		<p><?php  _e( 'Pingback:', 'theme' ); ?> <?php  comment_author_link(); ?> <?php  edit_comment_link( __( '(Edit)', 'theme' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php 
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php  comment_class(); ?> id="li-comment-<?php  comment_ID(); ?>">
		<article id="comment-<?php  comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php 
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'theme' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'theme' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php  if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php  _e( 'Your comment is awaiting moderation.', 'theme' ); ?></p>
			<?php  endif; ?>

			<section class="comment-content comment">
				<?php  comment_text(); ?>
				<?php  edit_comment_link( __( 'Edit', 'theme' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php  comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'theme' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php 
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'theme_entry_meta' ) ) :

function theme_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'theme' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'theme' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'theme' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'theme' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'theme' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'theme' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

function theme_customize_preview_js() {
	wp_enqueue_script( 'theme-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'theme_customize_preview_js' );

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
};

// ADD POST FRONT SITE
function apf_addpost() {
    $results = '';
 
    $name 		= $_POST['name'];
    $lastname 	= $_POST['lastname'];
    $email 		= $_POST['email'];
    $city 		= $_POST['city'];
    $phone 		= $_POST['phone'];
    $dni 		= $_POST['dni'];
    $team 		= $_POST['team'];
    $videoID 	= $_POST['videoID'];
	$videoType 	= $_POST['videoType'];
	$videoImage = $_POST['videoImage'];
 
    $post_id = wp_insert_post( array(
        'post_title'        => $dni,
        'post_status'       => 'publish',
        'post_type'       	=> 'fichas'
    ) );

    update_post_meta($post_id, 'name_value', $name);
    update_post_meta($post_id, 'lastname_value', $lastname);
    update_post_meta($post_id, 'email_value', $email);
    update_post_meta($post_id, 'city_value', $city);
    update_post_meta($post_id, 'phone_value', $phone);
    update_post_meta($post_id, 'dni_value', $dni);
    update_post_meta($post_id, 'team_value', $team);
    update_post_meta($post_id, 'video_type_value', $videoType);
    update_post_meta($post_id, 'video_id_value', $videoID);
    update_post_meta($post_id, 'video_image_value', $videoImage);

    $permalink = get_permalink( $post_id );
 
    if ( $post_id != 0 )
    {
        $results = $permalink;
    }
    else {
        $results = '*Error occurred while adding the post';
    }
    // Return the String
    die($results);
}
add_action( 'wp_ajax_nopriv_apf_addpost', 'apf_addpost' );
add_action( 'wp_ajax_apf_addpost', 'apf_addpost' );

// ADD POST FRONT SITE
function show_video() {
    $output = '';
 
    $postID 		= $_POST['postID'];

	$name 			= get_post_meta($postID, 'name_value', true);
	$lastname 		= get_post_meta($postID, 'lastname_value', true);
	$team 			= get_post_meta($postID, 'team_value', true);
	$video_type 	= get_post_meta($postID, 'video_type_value', true);
	$video_id 		= get_post_meta($postID, 'video_id_value', true);
	$imageShare 	= get_post_meta($postID, 'video_image_value', true);
	$votes 			= get_post_meta($postID, 'votes_value', true);
	$position 		= get_post_meta($postID, 'position_value', true);
	$dni 			= get_post_meta($postID, 'dni_value', true);

	$permalink 		= get_permalink( $postID );

	if($votes == '') $votes = '0';

	switch ($team) {
	    case 'peru':
	        $teamName = 'Perú';
	        break;
	    case 'brasil':
	        $teamName = 'Brasil';
	        break;
	    case 'spain':
	        $teamName = 'España';
	        break;
	    case 'colombia':
	        $teamName = 'Colombia';
	        break;
	    case 'holand':
	        $teamName = 'Holanda';
	        break;
	    case 'germany':
	        $teamName = 'Alemania';
	        break;
	    case 'italy':
	        $teamName = 'Italia';
	        break;
	    case 'argentina':
	        $teamName = 'Argentina';
	        break;
	}

	$replacement = "102.mp4";

	if( $video_type == "instagram" ) $instavid = substr($imageShare, 0, -5).$replacement;

	if( $video_type == "youtube" ) : 
		$video = '<iframe id="popup-youtube-player" width="434" height="234" src="//www.youtube.com/embed/' . $video_id .'?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allowfullscreen="true" allowscriptaccess="always"></iframe>';
	elseif( $video_type == "vimeo" ) :
		$video = '<iframe id="vimeo-player" src="//player.vimeo.com/video/' . $video_id .'?api=1" width="434" height="234" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	else:
		$video = '<video width="320" height="234" controls><source src="' . $instavid .'" type="video/mp4"><object data="' . $instavid .'" width="320" height="202"></object></video>';
	endif;

	//$videoFrame = '<div class="videoThumbPreview"><div class="share-video-overlay" id="share-video-overlay"><iframe src="'. get_stylesheet_directory_uri() . '/fb_likebutton.php?postID='. $postID .'&url='. $permalink .'&num= '. $dni .'" width="75" height="20" frameborder="0" scrolling="no" id="iframe"></iframe><div class="backInfo"></div></div>'. $video .'</div>';
	$videoFrame = '<div class="videoThumbPreview"><div class="share-video-overlay" id="share-video-overlay"><div class="backInfo"></div></div>'. $video .'</div>';

	$output['screen'] = "http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/screen/s-".$team.".jpg";
	$output['name'] = $name . ' ' . $lastname;
	$output['votes'] = $votes;
	$output['image'] = $imageShare;
	$output['team'] = $teamName;
	//$output['footer'] = '<div class="playerFooter"><iframe src="'. get_stylesheet_directory_uri() . '/fb_likebutton.php?postID='. $postID .'&url='. $permalink .'&num= '. $dni .'" width="75" height="20" frameborder="0" scrolling="no" id="iframe"></iframe></div>';
	$output['footer'] = '<div class="playerFooter"></div>';
	$output['video'] = $videoFrame;
	$output['type'] = $video_type;

    if ( $postID != '' )
    {
        $output;
    }
    else {
        $output = '*Error occurred while adding the post';
    }
    // Return the String
    echo json_encode($output);

    exit();
}
add_action( 'wp_ajax_nopriv_show_video', 'show_video' );
add_action( 'wp_ajax_show_video', 'show_video' );
