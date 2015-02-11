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
define("THEME_CSS_URL", get_template_directory_uri() . '/lib/css/admin/');
define("THEME_SCRIPT_URL", get_template_directory_uri() . '/lib/js/admin/');
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
		wp_enqueue_script('theme-switcher-options',THEME_SCRIPT_URL.'switcher-options.js');

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

//------ THEME OPTIONS PANEL ------//
require_once('theme-options/options-init.php');

require_once (THEME_FUNCTIONS_PATH.'meta.php');  //adds the custom meta fields to the posts and pages

function theme_setup() {

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

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	add_image_size( 'homepage-featured-full', 1000, 600 );
	add_image_size( 'homepage-featured-small', 640, 360, true );
	add_image_size( 'post-image', 580, 360, true );
	add_image_size( 'post-32x32', 32, 32, true );
	add_image_size( 'page-image', 1000, 600 );
}
add_action( 'after_setup_theme', 'theme_setup' );

function theme_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript if theme is develop or production mode 
	 */
	if( get_option( 'theme_status_dev') != 0 ):
		wp_deregister_script('jquery');
		wp_enqueue_script('theme-js-jquery', get_template_directory_uri() . '/lib/js/dev/jquery.js');
		wp_enqueue_script('theme-js-prefixfree', get_template_directory_uri() . '/lib/js/dev/prefixfree.js');
		wp_enqueue_script('theme-js-hammer', get_template_directory_uri() . '/lib/js/dev/hammer.js');
		wp_enqueue_script('theme-js-modernizr', get_template_directory_uri() . '/lib/js/dev/vendor/modernizr.js');

		wp_enqueue_script('theme-js-global', get_template_directory_uri() . '/lib/js/dev/global.js');
	else:
		wp_enqueue_script('theme-js-global', get_template_directory_uri() . '/lib/js/live/main.min.js');
	endif;

    wp_localize_script( 'theme-js-global', 'apfajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	/*
	 * Loads our main stylesheet.
	 */
	// wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700');
	
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
    // wp_enqueue_style( 'googleFonts');
	wp_enqueue_style( 'theme-base', get_template_directory_uri() . '/lib/css/site/hrstyle.css', array( 'theme-style' ), '20131002' );

}
add_action( 'wp_enqueue_scripts', 'theme_scripts_styles' );

function theme_admin_bar_render() {
	global $wp_admin_bar;
	// Remove comments icon
	// We use FB comments box
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'theme_admin_bar_render' );

function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    	=> 'theme-switcher',
        'parent'    => 'top-secondary',
        'title' 	=> '<span class="ab-icon"></span><span class="ab-label">Switcher</span>',
        'href'  	=> '#',
        'meta'  	=> array(
            'title' => 'Switcher',            
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    	=> 'theme-dev',
        'parent' 	=> 'theme-switcher',
        'title' 	=> 'Desarrollo',
        'href'  	=> '#',
        'meta'  	=> array(
            'title' => __('Desarrollo'),
            'class' => 'theme_switcher_class'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    	=> 'theme-prod',
        'parent' 	=> 'theme-switcher',
        'title' 	=> 'Producción',
        'href'  	=> '#',
        'meta'  	=> array(
            'title' => __('Producción'),
            'class' => 'theme_switcher_class'
        ),
    ));
}
add_action('admin_bar_menu', 'add_toolbar_items', 100);

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

function short_title($after = '', $length, $postID) {
	$mytitle = get_the_title( $postID );;
	if ( strlen($mytitle) > $length ) {
		$mytitle = substr($mytitle,0,$length);
		return $mytitle.$after;
	} else {
		return $mytitle;
	}
}

function change_switcher_callback() {
	global $wpdb; // this is how you get access to the database

	$status = $_POST['status'];

	if( $status == 'theme-dev' ):
		update_option( 'theme_status_dev', true );
		$mode = 'theme-dev';
	else:
		update_option( 'theme_status_dev', false );
		$mode = 'theme-prod';
	endif;	

	echo $mode;

	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_change_switcher', 'change_switcher_callback' );

function get_theme_status_callback() {
	global $wpdb; // this is how you get access to the database

	if( get_option( 'theme_status_dev') != 0 ):
		$mode = 'theme-dev';	
	else:
		$mode = 'theme-prod';
	endif;

	echo $mode;

	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_get_theme_status', 'get_theme_status_callback' );
