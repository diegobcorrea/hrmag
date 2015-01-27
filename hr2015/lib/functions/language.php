<?php
/**
 * This file contains all the language functionality.
 *
 * @author Vita
 */

/**
 * ADD THE ACTIONS
 */
add_action('init', 'pexeto_register_language_category');  
add_action('init', 'pexeto_register_language_post_type');  
add_action( 'admin_head', 'pexeto_register_language_icons' );
add_action('manage_posts_custom_column',  'language_show_columns'); 
add_filter('manage_edit-language_columns', 'language_columns');

/**
 * Registers the language category taxonomy.
 */
function pexeto_register_language_category(){

	register_taxonomy("language_category",
	array('language'),
	array(	"hierarchical" => true,
			"label" => "Language Categories", 
			"singular_label" => "Language Categories", 
			"rewrite" => true,
			"query_var" => true
	));
}

/**
 * Registers the language custom type.
 */
function pexeto_register_language_post_type() {

	//the labels that will be used for the language items
	$labels = array(
		    'name' => _x('Languages', 'language name'),
		    'singular_name' => _x('Language Item', 'language type singular name'),
		    'add_new' => _x('Add New', 'language'),
		    'add_new_item' => __('Add New Item'),
		    'edit_item' => __('Edit Item'),
		    'new_item' => __('New Language Item'),
		    'view_item' => __('View Item'),
		    'search_items' => __('Search Language Items'),
		    'not_found' =>  __('No language items found'),
		    'not_found_in_trash' => __('No language items found in Trash'), 
		    'parent_item_colon' => ''
		    );

		    //register the custom post type
		    register_post_type( 'language',
		    array( 'labels' => $labels,
	         'public' => true,  
	         'show_ui' => true,  
	         'capability_type' => 'post',  
	         'hierarchical' => false,  
			 'rewrite' => array('slug'=>'language'),
			 'taxonomies' => array('language_category'),
	         'supports' => array('title', 'editor', 'thumbnail', 'comments', 'page-attributes') ) );
}


function language_columns($columns) {
	$columns['category'] = 'Language Category';
	return $columns;
}

/**
 * Add category column to the language items page
 * @param $name
 */
function language_show_columns($name) {
	global $post;
	switch ($name) {
		case 'category':
			$cats = get_the_term_list( $post->ID, 'language_category', '', ', ', '' );
			echo $cats;
	}
}


/**
 * Gets a list of custom taxomomies by slug
 * @param $term_id the slug
 */
function pexeto_get_taxonomy_slug($term_id){
	global $wpdb;

	$res = $wpdb->get_results($wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE term_id=%s LIMIT 1;", $term_id));
	$res=$res[0];
	return $res->slug;
}

function pexeto_register_language_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-language .wp-menu-image {
            background: url('<?php echo VITA_IMAGES_URL ?>language-icon.png') no-repeat 3px -22px !important;
        }
        #menu-posts-language:hover .wp-menu-image, #menu-posts-language.wp-has-current-submenu .wp-menu-image {
            background-position:3px 3px!important;
        }
        #icon-edit.icon32-posts-language {
        	background: url('<?php echo VITA_IMAGES_URL ?>language-icon32.png') no-repeat 2px 2px !important;	
        }
    </style>
<?php }

/**
 * Builds the HTML code for a single portfolio item image - can be used in plugins or
 * other widgets that display a set of portfolio items
 * @param $post_id the ID of the post
 * @param $width the width that will be set to the image
 * @param $height the height that will be set to the image
 */
function pexeto_build_language_image_html($post, $width, $height, $showTitle=false, $groupName='group'){
	$post_id=$post->ID;
	$preview = pexeto_get_portfolio_preview_img($post);
	$thumbnail=get_post_meta($post_id, 'thumbnail_value', true);

	if(!$thumbnail || $thumbnail==''){
		$crop=get_post_meta($post->ID, 'crop_value', true);
		$thumbnail=pexeto_get_resized_image($preview, $width, $height,$crop);
	}

	$action=get_post_meta($post_id, 'action_value', true);
	$customlink=get_post_meta($post_id, 'custom_value', true);

	//set the link of the image depending on the action selected
	if($action=='nothing'){
		$openLink='';
		$closeLink='';
	}else if($action=='permalink_new'){
		$openLink='<a href="'.get_permalink($post_id).'">';
		$closeLink='</a>';
	}else if($action=='custom'){
		$openLink='<a href="'.$customlink.'" target="_blank">';
		$closeLink='</a>';
	}else{
		$preview=$action=='video'?$customlink:$preview;
		$rel=$groupName==''?'lightbox':'lightbox['.$groupName.']';
		$description=get_post_meta($post_id, 'description_value', true);
		$desc_title=$description?esc_attr($description):'';
		$openLink='<a rel="'.$rel.'" class="single_image" href="'.$preview.'" title="'.$desc_title.'">';
		$closeLink='</a>';
	}
	
	$title=$showTitle?'<div class="portfolio-project-title"><div class="portfolio-arrow"></div><h3>'.$post->post_title.'</h3></div>':'';

	return $openLink.'<img src="'.$thumbnail.'" class="gallery-img" width="'.$width.'" height="'.$height.'"/>'.$title.$closeLink;
}

if(!function_exists("pexeto_get_language_preview_img")){
	function pexeto_get_language_preview_img($post){
		$preview = get_post_meta($post->ID, 'preview_value', true);
		if (!$preview){
			$attachments = pexeto_get_post_images($post);
			if(sizeof($attachments)>0){
				$preview = array_shift(array_values($attachments))->guid;
			}
		}

		return $preview;
	}
}