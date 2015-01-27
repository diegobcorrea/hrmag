<?php
/**
 * This file contains all the functionality for the additional meta boxes for the pages and posts.
 * It contains functions for loading the meta data into arrays, displaying the meta boxes and
 * saving the meta data.
 *
 * @author Pexeto
 */

/**
 * ADD THE ACTIONS
 */
add_action('init', 'pexeto_load_meta_boxes');
add_action('admin_menu', 'create_meta_fichas_box');
add_action('save_post', 'save_postdata');  
add_action('save_post', 'save_fichas_postdata');


function pexeto_load_meta_boxes(){
	//load the porftfolio categeories
	$portf_taxonomies=get_terms('portfolio_category', array('hierarchical'=>true, 'hide_empty'=>0));
	$portf_categories=array(array('id'=>'-1', 'name'=>'All Portfolio Categories'));

	foreach($portf_taxonomies as $taxonomy){
		$portf_categories[]=array("name"=>$taxonomy->name, "id"=>$taxonomy->term_id);
	}
	$loader_portf_categories=array_merge(array(array('id'=>'hide','name'=>'Hide'), (array('id'=>'disabled','name'=>'Show:'))), $portf_categories);

	//load the post categeories
	$categories=get_categories('hide_empty=0');
	$pexeto_categories=array(array('id'=>'-1', 'name'=>'All Categories'));
	for($i=0; $i<sizeof($categories); $i++){
		$pexeto_categories[]=array('id'=>$categories[$i]->cat_ID, 'name'=>$categories[$i]->cat_name);
	}
	
	global $pexeto_data, $new_meta_page_boxes, $new_meta_fichas_boxes;

	/* ------------------------------------------------------------------------*
	 * META BOXES FOR THE PAGES
	 * ------------------------------------------------------------------------*/

	//the meta data for pages
	$new_meta_boxes =
	array(

	array(
		"title" => '<div class="ui-icon ui-icon-wrench"></div>General Page Settings',
		"type" => "heading"),

		array(
		"title" => "Page Layout",
		"name" => "layout",
		"type" => "imageradio",
		"options" => array(array("img"=>VITA_IMAGES_URL.'layout-right-sidebar.png', "id"=>"right", "title"=>"Right Sidebar Layout"),
		array("img"=>VITA_IMAGES_URL.'layout-left-sidebar.png', "id"=>"left", "title"=>"Left Sidebar Layout"),
		array("img"=>VITA_IMAGES_URL.'layout-full-width.png', "id"=>"full", "title"=>"Full Width Layout")),
		"std" => 'right',
		"description" => 'Available for Default, Featured Posts and Contact page templates'
		),

		array(
		"name" => "sidebar",
		"title" => "Sidebar",
		"type" => "select",
		"options" => $pexeto_data->pexeto_sidebars,
		"description" => 'You can select a sidebar for this page between the default one and another one that
		you have created. If you would like to use another sidebar, rather than the default one, you can
		create a new sidebar in "'.VITA_THEMENAME.' Options->Sidebars" section and after that you will be able to select the
		sidebar here.'),
		
		array(
		"name" => "show_title",
		"title" => "Display Page Title",
		"type" => "select",
		"options" => array(array("name"=>"Use Global Settings", "id"=>"global"),
		array("name"=>"Display", "id"=>"on"),
		array("name"=>"Hide", "id"=>"off")),
		"std" => 'global',
		"description" => 'Whether to display the page title or not - if "Use Global Settings" selected, the global setting selected in the
		'.VITA_THEMENAME.' Options &raquo; General &raquo; "Display page title on pages" field will be used.'),
		
		array(
		"title" => "Custom full width background image",
		"name" => "full_bg",
		"std" => "",
		"type" => "upload",
		"description" => 'You can globally set a full width background image in the '.VITA_THEMENAME.' Options &raquo; Style Settings  &raquo; 
		General section. In this field you can set a custom background image that will be displayed for this page only. <br/>
		Use the "<b>Upload Image</b>" button to upload a new image. If you would like to select an image from the Media Library,
		click on the "<b>Use Media Library</b>" button. Once you select the image, click on the "Insert into post" button.'
		),
		
		array(
		"title" => '<div class="ui-icon ui-icon-wrench"></div>Featured Page Template Settings',
		"type" => "heading"),
		
			array(
		"name" => "featured_category",
		"title" => "Display blog posts from category",
		"type" => "select",
		"none" => true,
		"options" => $pexeto_categories,
		"std" => '-1'
			),
			
			array(
		"title" => "Number of posts to display",
		"name" => "featured_post_number",
		"std" => "5",
		"type" => "text"
		),
		
		array(
		"title" => '<div class="ui-icon ui-icon-image"></div>Portfolio Settings - available only for Portfolio/Gallery page templates',
		"type" => "heading"),

		array(
		"name" => "post_category",
		"title" => "Display portfolio items from categories",
		"type" => "select",
		"none" => true,
		"options" => $portf_categories,
		"std" => '-1',
		"description" => 'If "All Categories" selected, all the Portfolio items will be displayed. If another category is selected, only the Portfolio items that belong
		to this category or this category\'s subcategories will be displayed. By selecting different categories, you can create multiple portfolio/gallery
		pages with different items displayed.'),

		array(
		"name" => "order",
		"title" => "Portfolio item order",
		"type" => "select",
		"options" => array(array("name"=>"By Date", "id"=>"date"),
		array("name"=>"By Custom Order", "id"=>"custom")),
		"std" => 'date',
		"description" => 'If you select "By Date" the last created item will be displayed first. If you select by "By Custom Order"
		you will have to set the order field of each of the items - the items with the smaller order number will be displayed first.'),


		array(
		"name" => "show_filter",
		"title" => "Show portfolio category filter",
		"type" => "select",
		"options" => array(array("name"=>"Show", "id"=>"true"),
		array("name"=>"Hide", "id"=>"false")),
		"std" => 'true',
		"description" => 'If "Show" selected, a category filter will be displayed above the portfolio items'),

		array(
		"name" => "show_info",
		"title" => "Show item info",
		"type" => "select",
		"options" => array( array("name"=>"Hide", "id"=>"false"),
		array("name"=>"Show", "id"=>"true")),
		"std" => 'true',
		"description" => 'If "Show" selected, the portfolio item title and category will be displayed below the image (only for the Grid Gallery template)'
		),


		array(
		"title" => "Number of portfolio items to show per load/page",
		"name" => "post_number",
		"std" => "10",
		"type" => "text"
		),
		
		array(
		"name" => "image_width",
		"title" => "Image width",
		"type" => "text",
		"std" => '290',
		"description" => 'The image width in the grid gallery. The image width is always static and the height is determined by the image ratio (only for the Grid Gallery template)'
		),
		
		array(
		"name" => "desaturate",
		"title" => "Black/white image effect",
		"type" => "select",
		"options" => array( array("name"=>"OFF", "id"=>"false"),array("name"=>"ON", "id"=>"true")),
		"std" => 'false',
		"description" => 'If this option is enabled, the images will be automatically converted to black/white (desaturated) and they will be colored on hover (only for the Grid Gallery template).'
		),
		
		array(
		"name" => "show_back_btn_end",
		"title" => 'Show a "Back to gallery" button in the end of the image slider',
		"type" => "select",
		"options" => array( array("name"=>"Hide", "id"=>"false"),
		array("name"=>"Show", "id"=>"true")),
		"std" => 'false',
		"description" => 'If "Show" selected, a "Back to gallery" button will be appended to the last image of the image slider (only for the Grid Gallery template)'
		),

		array(
		"name" => "partial_loading",
		"title" => 'Partial image loading in horizontal slider',
		"type" => "select",
		"options" => array( array("name"=>"Disabled", "id"=>"false"),
		array("name"=>"Enabled", "id"=>"true")),
		"std" => 'false',
		"description" => 'If "Enabled" selected, the slider will not wait for all the images to be loaded in order to get displayed. Before the slider is displayed it will load the amount of images you set in the "Number of images to load before displaying the slider" field below and after that the rest of the images will be displayed dynamically - as soon as the image gets loaded it will be displayed on the slider  (only for the Grid Gallery template)'
		),

		array(
		"name" => "img_num_before_load",
		"title" => "Number of images to load before displaying the slider",
		"type" => "text",
		"std" => '3',
		"description" => 'If partial image loaing is enabled above, this would be the number of images to load before displaying the horizontal slider. (only for the Grid Gallery template)'
		)
		
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_post_boxes =
		array(

			array(
				"title" => "Header URL",
				"name" => "header",
				"std" => "",
				"type" => "upload",
				"description" => 'By default the theme will show a custom header image. Use the "<b>Upload</b>" button to upload a new image.'
			),
		
		);

		
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PAGE POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_page_boxes =
		array(

			array(
				"title" => "Small Content",
				"name" => "small_content",
				"std" => "",
				"type" => "textarea"
			),

			array(
				"title" => '<div class="ui-icon ui-icon-wrench format-gallery"></div>Gallery Settings',
				"type" => "heading",
			),

			array(
				"title" => "Gallery Slides",
				"name" => "galleryImg",
				"std" => "",
				"type" => "multi-upload",
				"description" => 'By default the theme will show a custom header image. Use the "<b>Upload</b>" button to upload a new image.'
			),
		
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE FICHAS POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_fichas_boxes =
		array(

			array("title" => '<div class="ui-icon ui-icon-wrench format-gallery"></div>Datos del Usuario',"type" => "heading"),
			array("title" => "Nombre","name" => "name","std" => "","type" => "text","class" => "half"),
			array("title" => "Apellidos","name" => "lastname","std" => "","type" => "text","class" => "half last"),
			array("title" => "Email","name" => "email","std" => "","type" => "text","class" => "half"),
			array("title" => "Ciudad","name" => "city","std" => "","type" => "text","description" => '',"class" => "half last"),
			array("title" => "Teléfono","name" => "phone","std" => "","type" => "text","description" => '',"class" => "onethird"),
			array("title" => "DNI","name" => "dni","std" => "","type" => "text","description" => '',"class" => "onethird"),
			array("title" => "Equipo","name" => "team","std" => "","type" => "text","description" => '',"class" => "onethird last"),

			array("title" => "Votos","name" => "votes","std" => "","type" => "text","class" => ""),

			array("title" => '<div class="ui-icon ui-icon-wrench format-gallery"></div>Datos del Video',"type" => "heading"),
			array("title" => "Activo","name" => "video_active","std" => "","type" => "checkbox_ui","class" => "checkbox_ui"),
			array("title" => "Tipo de Video","name" => "video_type","std" => "","type" => "text","class" => "onethird"),
			array("title" => "ID del Video","name" => "video_id","std" => "","type" => "text","description" => '',"class" => "onethird"),
			array("title" => "Imagen del Video","name" => "video_image","std" => "","type" => "text","description" => '',"class" => "onethird last"),

			array(
				"title" => "Escoge Slide",
				"name" => "slide",
				"std" => '1',
				"type" => "select",
				"options" => array(
					array("name"=>"Slide #1", "id"=>"1"),
					array("name"=>"Slide #2", "id"=>"2"),
					array("name"=>"Slide #3", "id"=>"3"),
					array("name"=>"Slide #4", "id"=>"4"),
				),
				"description" => '',"class" => ""
			),
		
			array("title" => "Posición","name" => "position","std" => "","type" => "choose-position","description" => '',"class" => ""),
		
		);
		
}

/**
 * Creates a post meta box.
 */
function create_meta_fichas_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-fichas-boxes', '<div class="icon-small"></div> '.THEME_THEMENAME.' - DATOS', 'new_meta_fichas_boxes', 'fichas', 'normal', 'high' );
	}
}

/**
 * Calls the print method for botas2014 meta boxes.
 */
function new_meta_page_boxes() {
	global $post, $new_meta_page_boxes;

	foreach($new_meta_page_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for botas2014 meta boxes.
 */
function new_meta_fichas_boxes() {
	global $post, $new_meta_fichas_boxes;

	foreach($new_meta_fichas_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * DYNAMIC IMAGE UPLOAD ROW
 */
function Print_gallery_image_fileds($meta, $cnt, $gallImgUrl = null) {
	if ($gallImgUrl === null){
	    $a = '';
	}else{
	    $a = $gallImgUrl;
	}
	return 
	'<div class="dynamicField">
		<input type="text" name="'.$meta.'['.$cnt.']" value="'.$a.'">
		<input type="button" name="upload_image_button" class="upload_img button" value="'. __('Upload', 'unicorn') .'" />
		<input type="button" name="remove" class="remove button" value="&times;" />
	</div>';
}

/**
 * DYNAMIC TAG ROW
 */
function Print_tag_image_fields($meta, $cnt, $tagName = null, $tagSKU = null, $tagPrice = null, $tagX = null, $tagY = null, $tagStatic = null, $tagBrand = null, $tagURL = null ) {
	if ($tagName === null){ $a = ''; }else{ $a = $tagName; };
	if ($tagSKU === null){ $b = ''; }else{ $b = $tagSKU; };
	if ($tagPrice === null){ $c = ''; }else{ $c = $tagPrice; };
	if ($tagX === null){ $x = ''; }else{ $x = $tagX; };
	if ($tagY === null){ $y = ''; }else{ $y = $tagY; };
	if ($tagStatic === null){ $static = ''; $checked = ''; }else{ $static = $tagStatic; $checked = "checked"; };
	if ($tagBrand === null){ $d = ''; }else{ $d = $tagBrand; };
	if ($tagURL === null){ $e = ''; }else{ $e = $tagURL; };

	return 
	'<div id="tag-'.$cnt.'" class="dynamicField">
		<div class="inner">
			<div class="field">
				<div class="label">Nombre: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][title]" class="large" id="tagName" value="'.$a.'">
			</div>
			<div class="field">
				<div class="label">Marca: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][brand]" class="medium" id="tagBrand" value="'.$d.'">
			</div>

			<div class="field">
				<div class="label">URL: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][url]" class="large" id="tagURL" value="'.$e.'">
			</div>
			<div class="field">
				<div class="label">SKU: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][sku]" class="medium" id="tagSKU" value="'.$b.'">
			</div>

			<div class="field">
				<div class="label">Precio: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][price]" class="small" id="tagPrice" value="'.$c.'">
			</div>
			<div class="field">
				<div class="label">Rollover: </div>
				<div class="switch switch-square">
					<input type="checkbox" name="'.$meta.'['.$cnt.'][static]" id="s'.$cnt.'" value="1" '.$checked.'>
					<label for="s'.$cnt.'" data-on="ON" data-off="OFF"></label>
				</div>
	        </div>
        </div>

		<input type="hidden" name="'.$meta.'['.$cnt.'][x]" id="tagX" value="'.$x.'">
		<input type="hidden" name="'.$meta.'['.$cnt.'][y]" id="tagY" value="'.$y.'">

		<div class="field-remove">
			<input type="button" name="remove" id="'.$cnt.'" class="remove button" value="&times;" />
		</div>
	</div>
	<div class="temp" style="display:none"><div id="'.$cnt.'" class="wPsticky" style="top:'.$y.'%;left:'.$x.'%"></div></div>';
}

function Print_product_fields($meta, $cnt, $tagName = null, $tagSKU = null, $tagPrice = null, $tagBrand = null) {
	if ($tagName === null){ $a = ''; }else{ $a = $tagName; };
	if ($tagSKU === null){ $b = ''; }else{ $b = $tagSKU; };
	if ($tagPrice === null){ $c = ''; }else{ $c = $tagPrice; };
	if ($tagBrand === null){ $d = ''; }else{ $d = $tagBrand; };

	return 
	'<div id="tag-'.$cnt.'" class="dynamicField">
		<div class="inner">
			<div class="field">
				<div class="label">Nombre: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][title]" class="large" id="tagName" value="'.$a.'">
			</div>
			<div class="field">
				<div class="label">Marca: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][brand]" class="large" id="tagBrand" value="'.$d.'">
			</div>

			<div class="field">
				<div class="label">SKU: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][sku]" class="large" id="tagSKU" value="'.$b.'">
			</div>
			<div class="field">
				<div class="label">Precio: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][price]" class="large" id="tagPrice" value="'.$c.'">
			</div>
        </div>        

		<div class="field-remove">
			<input type="button" name="remove" id="'.$cnt.'" class="remove button" value="&times;" />
		</div>
	</div>';
}

function Print_details($meta, $cnt, $details){
	$d = 1;
	foreach ($details as $detail) {
		$object .= Print_tagwdetail_product_fields($meta,$cnt,$d,$detail['title'],$detail['sku'],$detail['price'],$detail['brand']);
		$d = $d +1;
	}

	return $object;
}

function Print_tagwdetail_fields($meta, $cnt, $image = null, $imagezoom = null, $tagX = null, $tagY = null, $tagDetail = null) {
	if ($image === null){ $a = ''; }else{ $a = $image; }
	if ($imagezoom === null){ $b = ''; }else{ $b = $imagezoom; }
	if ($tagX === null){ $x = ''; }else{ $x = $tagX; }
	if ($tagY === null){ $y = ''; }else{ $y = $tagY; }
	if ($tagDetail === null){ $tagD = ''; }else{ $tagD = Print_details( $meta, $cnt, $tagDetail ); }

	return 
	'<div id="tag-'.$cnt.'" class="dynamicField" style="width: 100%;">
		<div class="inner">
			<div class="field">
				<div class="label">Imagen: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][img]" value="'.$a.'" class="option-input upload pexeto-upload medium"/>
				<input type="button" class="button-primary pexeto-upload-btn" value="Upload Image" />
			</div>
			<div class="field">
				<div class="label">Zoom: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][imgzoom]" value="'.$b.'" class="option-input upload pexeto-upload medium" />
				<input type="button" class="button-primary pexeto-upload-btn" value="Upload Image" />
			</div>

			<input type="hidden" name="'.$meta.'['.$cnt.'][x]" id="tagX" value="'.$x.'">
			<input type="hidden" name="'.$meta.'['.$cnt.'][y]" id="tagY" value="'.$y.'">

			<div class="details" data-id="'.$cnt.'">'. $tagD .'</div>

			<input type="button" name="add" data-id="'.$cnt.'" class="add button" value="+ Agregar Detalle" />
		</div>

		<div class="field-remove">
			<input type="button" name="remove" data-id="'.$cnt.'" class="remove button" value="&times;" />
		</div>
	</div>
	<div class="temp" style="display:none"><div id="'.$cnt.'" class="wPsticky" style="top:'.$y.'%;left:'.$x.'%"></div></div>';
}

function Print_mapwdetail_fields($meta, $cnt, $image = null, $imagezoom = null, $tagX = null, $tagY = null, $tagW = null, $tagH = null, $tagStatic = null, $tagDetail = null) {
	if ($image === null){ $a = ''; }else{ $a = $image; }
	if ($imagezoom === null){ $b = ''; }else{ $b = $imagezoom; }
	if ($tagX === null){ $x = ''; }else{ $x = $tagX; }
	if ($tagY === null){ $y = ''; }else{ $y = $tagY; }
	if ($tagW === null){ $w = ''; }else{ $w = $tagW; }
	if ($tagH === null){ $h = ''; }else{ $h = $tagH; }
	if ($tagStatic === null){ $static = ''; $checked = ''; }else{ $static = $tagStatic; $checked = "checked"; };
	if ($tagDetail === null){ $tagD = ''; }else{ $tagD = Print_details( $meta, $cnt, $tagDetail ); }

	return 
	'<div id="tag-'.$cnt.'" class="dynamicField" style="width: 100%;">
		<div class="inner">
			<div class="field">
				<div class="label">Imagen: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][img]" value="'.$a.'" class="option-input upload pexeto-upload medium"/>
				<input type="button" class="button-primary pexeto-upload-btn" value="Upload Image" />
			</div>
			<div class="field">
				<div class="label">Mostrar detalle: </div>
				<div class="switch switch-square">
					<input type="checkbox" name="'.$meta.'['.$cnt.'][static]" id="s'.$cnt.'" value="1" '.$checked.'>
					<label for="s'.$cnt.'" data-on="IZQ" data-off="DER"></label>
				</div>
	        </div>

			<input type="hidden" name="'.$meta.'['.$cnt.'][x]" id="tagX" value="'.$x.'">
			<input type="hidden" name="'.$meta.'['.$cnt.'][y]" id="tagY" value="'.$y.'">
			<input type="hidden" name="'.$meta.'['.$cnt.'][w]" id="tagW" value="'.$w.'">
			<input type="hidden" name="'.$meta.'['.$cnt.'][h]" id="tagH" value="'.$h.'">

			<div class="details" data-id="'.$cnt.'">'. $tagD .'</div>

			<input type="button" name="add" data-id="'.$cnt.'" class="add button" value="+ Agregar" />
		</div>

		<div class="field-remove">
			<input type="button" name="remove" data-id="'.$cnt.'" class="remove button" value="&times;" />
		</div>
	</div>
	<div class="temp" style="display:none"><a id="'.$cnt.'" class="drawnBox" style="top:'.$y.'%;left:'.$x.'%;width:'.$w.'%;height:'.$h.'%"></a></div>';
}

function Print_tagwdetail_product_fields($meta, $cnt, $detail, $tagName = null, $tagSKU = null, $tagPrice = null, $tagBrand = null) {
	if ($tagName === null){ $a = ''; }else{ $a = $tagName; };
	if ($tagSKU === null){ $b = ''; }else{ $b = $tagSKU; };
	if ($tagPrice === null){ $c = ''; }else{ $c = $tagPrice; };
	if ($tagBrand === null){ $d = ''; }else{ $d = $tagBrand; };

	return 
	'<div id="detail-'.$detail.'" class="dynamicField dynamicBox">
		<div class="inner">
			<div class="field">
				<div class="label">Nombre: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][d]['.$detail.'][title]" class="large" id="tagName" value="'.$a.'">
			</div>
			<div class="field">
				<div class="label">Marca: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][d]['.$detail.'][brand]" class="large" id="tagBrand" value="'.$d.'">
			</div>

			<div class="field">
				<div class="label">SKU: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][d]['.$detail.'][sku]" class="large" id="tagSKU" value="'.$b.'">
			</div>
			<div class="field">
				<div class="label">Precio: </div>
				<input type="text" name="'.$meta.'['.$cnt.'][d]['.$detail.'][price]" class="large" id="tagPrice" value="'.$c.'">
			</div>
        </div>        

		<div class="field-remove">
			<input type="button" name="remove" data-id="'.$detail.'" data-container="'.$cnt.'" class="remove-det button" value="&times;" />
		</div>
	</div>';
}



/**
 * Prints the meta box
 * @param $meta_box the meta box to be printed
 * @param $post the post to contain the meta box
 */
function print_meta_box($meta_box, $post){
	$meta_box_value = "";
	if(isset($meta_box['name'])){
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
	}
	if($meta_box_value == "" && isset($meta_box['std'])){
		$meta_box_value = $meta_box['std'];
	}

	if($meta_box['type']!='heading'){
		$box_class = isset($meta_box['class'])?' '.$meta_box['class']:'';
		echo '<div class="option-container'.$box_class.'">';
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
	}


	switch($meta_box['type']){
		case 'heading':
			echo'<div class="option-heading '.$meta_box['class'].'"><h4>'.$meta_box['title'].'</h4></div>';
			break;
		case 'text':
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input"/><br />';
			break;
		case 'upload':
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" id="pexeto-'.$meta_box['name'].'" class="option-input upload pexeto-upload"/>';

			echo '<input type="button" id="pexeto-'.$meta_box['name'].'_button" class="button-primary pexeto-upload-btn" value="Upload Image" />';
			//echo '<input type="button" id="pex-media" class="button-secondary" value="Use Media Library" onclick="pexetoPageOptions.loadMediaImage(jQuery(\'#pexeto-'.$meta_box['name'].'\'));"/>';
			break;
		case 'upload-preview':
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" id="pexeto-'.$meta_box['name'].'" class="option-input upload preview pexeto-upload"/>';
			echo'<div class="tag-container">';
			echo'<img src="'.$meta_box_value.'" class="option-image" />';
			echo'</div>';

			echo '<input type="button" id="pexeto-'.$meta_box['name'].'_button" class="button-primary pexeto-upload-btn" value="Upload Image" />';
			//echo '<input type="button" id="pex-media" class="button-secondary" value="Use Media Library" onclick="pexetoPageOptions.loadMediaImage(jQuery(\'#pexeto-'.$meta_box['name'].'\'));"/>';
			break;
		case 'upload-mapping':
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" id="pexeto-'.$meta_box['name'].'" class="option-input upload preview pexeto-upload"/>';
			echo'<div id="map-container">';
			echo'<img src="'.$meta_box_value.'" class="option-image mapping" />';
			echo'</div>';

			echo '<input type="button" id="pexeto-'.$meta_box['name'].'_button" class="button-primary pexeto-upload-btn" value="Upload Image" />';

			break;
		case 'choose-position':
			echo '<input type="hidden" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input position-person"/>';

			echo'<div class="people_list" data-slide="1">';

			$people = 1;
			global $wpdb;

			$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'slide_value' AND $wpdb->postmeta.meta_value = '1' AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'fichas' ORDER BY $wpdb->posts.post_date DESC";

			$fichas = $wpdb->get_results($querystr);

			foreach ($fichas as $ficha) {
				$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
			}

			while ($people <= 85) :
				
				if( $people == $meta_box_value ){ 
					$used = " in-use"; 
					$postID = $post->ID;
				}else{ 
					$used = " free"; 
					$postID = $post->ID;
				};

				if( !empty($fichas) ){
					if( in_array_r($people, $ficha_used) ){
						$used = " in-use"; 
						$postID = '0';
					}
				}
				echo '<div id="'. $people .'" class="person'. $used .'" data-slide="1" data-postid="'. $postID .'"></div>';

			$people++;
			endwhile;
			echo '</div>';

			echo'<div class="people_list" data-slide="2" style="display: none">';

			$people = 86;
			global $wpdb;

			$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'slide_value' AND $wpdb->postmeta.meta_value = '2' AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'fichas' ORDER BY $wpdb->posts.post_date DESC";

			$fichas = $wpdb->get_results($querystr);

			foreach ($fichas as $ficha) {
				$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
			}

			while ($people <= 170) :
				
				if( $people == $meta_box_value ){ 
					$used = " in-use"; 
					$postID = $post->ID;
				}else{ 
					$used = " free"; 
					$postID = $post->ID;
				};

				if( !empty($fichas) ){
					if( in_array_r($people, $ficha_used) ){
						$used = " in-use"; 
						$postID = '0';
					}
				}

				echo '<div id="'. $people .'" class="person'. $used .'" data-slide="2" data-postid="'. $postID .'"></div>';

			$people++;
			endwhile;
			echo '</div>'; 

			echo'<div class="people_list" data-slide="3" style="display: none">';

			$people = 171;
			global $wpdb;

			$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'slide_value' AND $wpdb->postmeta.meta_value = '3' AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'fichas' ORDER BY $wpdb->posts.post_date DESC";

			$fichas = $wpdb->get_results($querystr);

			foreach ($fichas as $ficha) {
				$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
			}

			while ($people <= 255) :
				
				if( $people == $meta_box_value ){ 
					$used = " in-use"; 
					$postID = $post->ID;
				}else{ 
					$used = " free"; 
					$postID = $post->ID;
				};

				if( !empty($fichas) ){
					if( in_array_r($people, $ficha_used) ){
						$used = " in-use"; 
						$postID = '0';
					}
				}

				echo '<div id="'. $people .'" class="person'. $used .'" data-slide="3" data-postid="'. $postID .'"></div>';

			$people++;
			endwhile;
			echo '</div>'; 

			echo'<div class="people_list" data-slide="4" style="display: none">';

			$people = 256;
			global $wpdb;

			$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'slide_value' AND $wpdb->postmeta.meta_value = '4' AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'fichas' ORDER BY $wpdb->posts.post_date DESC";

			$fichas = $wpdb->get_results($querystr);

			foreach ($fichas as $ficha) {
				$ficha_used[] = array(get_post_meta($ficha->ID, 'position_value', true));
			}

			while ($people <= 340) :
				
				if( $people == $meta_box_value ){ 
					$used = " in-use"; 
					$postID = $post->ID;
				}else{ 
					$used = " free"; 
					$postID = $post->ID;
				};

				if( !empty($fichas) ){
					if( in_array_r($people, $ficha_used) ){
						$used = " in-use"; 
						$postID = '0';
					}
				}

				echo '<div id="'. $people .'" class="person'. $used .'" data-slide="4" data-postid="'. $postID .'"></div>';

			$people++;
			endwhile;
			echo '</div>'; 


			?>

			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            	$('.person').click(function(){
            		var ID 		= $(this).attr('id'),
            			postID 	= $(this).data('postid');

            		$('.person[data-postid="'+postID+'"]').css( "background-color", "#cbcbcb" ).removeClass('.in-use');

            		$('.position-person').val(ID);
            		$(this).css({'background-color':'#103f71'}).siblings().not('.in-use').css( "background-color", "#cbcbcb" );
            	});	
            });
            </script>
			<?php

			break;
		case 'multi-upload':
			echo'<div id="gallImgs">';
			$gallImages = get_post_meta($post->ID, $meta_box['name'].'_value',true);

			$c = 1;
			if (count($gallImages) > 0){
				foreach((array)$gallImages as $gallImgUrl ){
					echo Print_gallery_image_fileds($meta_box['name'].'_value',$c,$gallImgUrl);
					$c = $c +1;
				}
			
			}
			echo'</div>';
			echo'<span id="here"></span>';
			echo'<input type="button" name="add" class="add button" value="+ Add Slide Image" />';
			
			?>
			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            }
	            
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            
	            var count = <?php echo $c; ?>;
	            $(".add").click(function() {
	                count = count + 1;
	                $('#gallImgs').append('<?php echo implode('',explode("\n",Print_gallery_image_fileds($meta_box["name"]."_value", 'count'))); ?>'.replace(/count/g, count));
	                return false;
	            });
	            $(".remove").live('click', function() {
	                $(this).parent().remove();
	            });
	        });
		    </script>
			<?
			break;
		case 'multi-tag':
			echo'<div id="tagFields">';
			$tagFields = get_post_meta($post->ID, $meta_box['name'].'_value',true);

			$c = 1;
			if ($tagFields != ''){
				foreach($tagFields as $tag ){
					echo Print_tag_image_fields($meta_box['name'].'_value',$c,$tag['title'],$tag['sku'],$tag['price'],$tag['x'],$tag['y'],$tag['static'],$tag['brand'],$tag['url']);
					$c = $c +1;
				}
			}
			echo'</div>';
			//echo'<span id="here"></span>';
			echo'<input type="hidden" name="add" class="add button" value="+ Agregar Tag" />';
			
			?>
			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            }
	            
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            var count = <?php echo $c; ?>;
	            $("img.option-image").click(function(e){
					var offset = $(this).offset(),
						center = 19.5,
						a = e.pageX - offset.left,
				    	b = e.pageY - offset.top,
				    	h = $(this).height(),
				    	w = $(this).width(),
				    	percentX = ( a / w * 100 ) - 2,
				    	percentY = ( b / h * 100 ) - 2;

				    count = count + 1;
				  
					$(".tag-container").append("<div id='"+count+"' class='wPsticky' style='top:"+percentY+"%;left:"+percentX+"%'></div>");
					//$("#new-meta-dcotendencia-boxes .inside").append("<div class='option-heading'><h4><div class='ui-icon ui-icon-wrench format-gallery'></div>Tag #"+ c +"</h4></div><div class='option-container onethird'><input type='hidden' name='title_"+c+"_noncename' id='title_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>Nombre del Producto</h4><input type='text' name='title_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div><div class='option-container onethird'><input type='hidden' name='sku_"+c+"_noncename' id='sku_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>SKU</h4><input type='text' name='sku_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div><div class='option-container onethird last'><input type='hidden' name='precio_"+c+"_noncename' id='precio_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>Precio</h4><input type='text' name='precio_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div>");
					$('#tagFields').append('<?php echo implode('',explode("\n",Print_tag_image_fields($meta_box["name"]."_value", 'count'))); ?>'.replace(/count/g, count));

					$("#tag-"+count+" #tagX").val(percentX);
					$("#tag-"+count+" #tagY").val(percentY);

					$("#"+count+".wPsticky").draggable({ 
						drag: function(e, ui) {
							var top = ui.position.top,
								left = ui.position.left,
								h = $("img.option-image").height(),
				    			w = $("img.option-image").width(),
								leftX = ( left / w ) * 100,
				    			topY = ( top / h ) * 100;

							var id = $(this).attr("id");

							$("#tag-"+id+" #tagX").val(leftX);
							$("#tag-"+id+" #tagY").val(topY);
						}
					});

					return false;
				});

				$(".wPsticky").draggable({ 
					drag: function(e, ui) {
						var top = ui.position.top,
							left = ui.position.left,
							h = $("img.option-image").height(),
				    		w = $("img.option-image").width(),
							leftX = ( left / w ) * 100,
				    		topY = ( top / h ) * 100;

						var id = $(this).attr("id");

						$("#tag-"+id+" #tagX").val(leftX);
						$("#tag-"+id+" #tagY").val(topY);
					}
				});

	            $(".remove").live('click', function() {
	            	var id = $(this).attr('id');

	                $("#tag-"+id).remove();
	                $("#"+id+".wPsticky").remove();
	            });
	        });
		    </script>
			<?
			break;
		case 'multi-products':
			echo'<div id="tagFields">';
			$tagFields = get_post_meta($post->ID, $meta_box['name'].'_value',true);

			$c = 1;
			if ($tagFields != ''){
				foreach($tagFields as $tag ){
					echo Print_product_fields($meta_box['name'].'_value',$c,$tag['title'],$tag['sku'],$tag['price'],$tag['brand']);
					$c = $c +1;
				}
			}
			echo'</div>';
			echo'<span id="here"></span>';
			echo'<input type="button" name="add" class="add button" value="+ Agregar Detalle" />';
			
			?>
			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            }
	            
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            
	            var count = <?php echo $c; ?>;
	            $(".add").click(function() {
	                count = count + 1;
	                $('#tagFields').append('<?php echo implode('',explode("\n",Print_product_fields($meta_box["name"]."_value", 'count'))); ?>'.replace(/count/g, count));
	                return false;
	            });
	            $(".remove").live('click', function() {
	                var id = $(this).attr('id');

	                $("#tag-"+id).remove();
	            });
	        });
		    </script>
			<?
			break;
		case 'multi-tag-with-detail':
			echo'<div id="tagFields">';
			$tagFields = get_post_meta($post->ID, $meta_box['name'].'_value',true);

			$c = 1;
			$d = 1;
			if ($tagFields != ''){
				foreach($tagFields as $tag ){
					echo Print_tagwdetail_fields($meta_box['name'].'_value',$c,$tag['img'],$tag['imgzoom'],$tag['x'],$tag['y'],$tag['d']);
					/*if($tag['d']){
						foreach ($tag['d'] as $detail) {
							echo Print_tagwdetail_product_fields($meta_box['name'].'_value',$c,$d,$detail['title'],$detail['sku'],$detail['price'],$detail['brand']);
						}
						$d = $d +1;
					}*/
					$c = $c +1;
				}
			}
			echo'</div>';
			echo'<span id="here"></span>';
			
			?>
			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            };
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            var count = <?php echo $c; ?>;
	            $("img.option-image").click(function(e){
					var offset = $(this).offset(),
						center = 19.5,
						a = e.pageX - offset.left,
				    	b = e.pageY - offset.top,
				    	h = $(this).height(),
				    	w = $(this).width(),
				    	percentX = ( a / w * 100 ) - 2,
				    	percentY = ( b / h * 100 ) - 2;

				    count = count + 1;
				  
					$(".tag-container").append("<div id='"+count+"' class='wPsticky' style='top:"+percentY+"%;left:"+percentX+"%'></div>");
					//$("#new-meta-dcotendencia-boxes .inside").append("<div class='option-heading'><h4><div class='ui-icon ui-icon-wrench format-gallery'></div>Tag #"+ c +"</h4></div><div class='option-container onethird'><input type='hidden' name='title_"+c+"_noncename' id='title_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>Nombre del Producto</h4><input type='text' name='title_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div><div class='option-container onethird'><input type='hidden' name='sku_"+c+"_noncename' id='sku_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>SKU</h4><input type='text' name='sku_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div><div class='option-container onethird last'><input type='hidden' name='precio_"+c+"_noncename' id='precio_"+c+"_noncename' value='"+noncename+"'><h4 class='page-option-title'>Precio</h4><input type='text' name='precio_"+c+"_value' value='' class='option-input'><br><span class='option-description'></span></div>");
					$('#tagFields').append('<?php echo implode('',explode("\n",Print_tagwdetail_fields($meta_box["name"]."_value", 'count'))); ?>'.replace(/count/g, count));

					$("#tag-"+count+" #tagX").val(percentX);
					$("#tag-"+count+" #tagY").val(percentY);

					$("#"+count+".wPsticky").draggable({ 
						drag: function(e, ui) {
							var top = ui.position.top,
								left = ui.position.left,
								h = $("img.option-image").height(),
				    			w = $("img.option-image").width(),
								leftX = ( left / w ) * 100,
				    			topY = ( top / h ) * 100;

							var id = $(this).attr("id");

							$("#tag-"+id+" #tagX").val(leftX);
							$("#tag-"+id+" #tagY").val(topY);
						}
					});

					pexetoPageOptions.loadUploadFunctionality();

					var dcnt = 1
		            $(".add").click(function() {
		                dcnt = dcnt + 1;
		                $("#tag-"+count+" .details").append(('<?php echo implode('',explode("\n",Print_tagwdetail_product_fields($meta_box["name"]."_value", 'count','dcnt'))); ?>'.replace(/count/g, count).replace(/dcnt/g, dcnt)));
		                return false;
		            });

					return false;
				});

				$(".wPsticky").draggable({ 
					drag: function(e, ui) {
						var top = ui.position.top,
							left = ui.position.left,
							h = $("img.option-image").height(),
				    		w = $("img.option-image").width(),
							leftX = ( left / w ) * 100,
				    		topY = ( top / h ) * 100;

						var id = $(this).attr("id");

						$("#tag-"+id+" #tagX").val(leftX);
						$("#tag-"+id+" #tagY").val(topY);
					}
				});

	            $(".add").click(function() {
	            	var dataID = $(this).data("id"),
						num = $("#tag-"+dataID+" .details .dynamicBox").length;
	                
	                dcount = num + 1;

	                $("#tag-"+dataID+" .details").append(('<?php echo implode('',explode("\n",Print_tagwdetail_product_fields($meta_box["name"]."_value", 'dataID','dcount'))); ?>'.replace(/dataID/g, dataID).replace(/dcount/g, dcount)));
	                return false;
	            });

	            $(".remove").live('click', function() {
	            	var id = $(this).data('id');

	                $("#tag-"+id).remove();
	                $("#"+id+".wPsticky").remove();
	            });

	            $(".remove-det").live('click', function() {
	            	var id = $(this).data('id'),
	            		cnt = $(this).data('container');;

	                $("#tag-"+cnt+" #detail-"+id).remove();
	            });

	        });
		    </script>
			<?
			break;
		case 'multi-map-with-detail':
			require_once (THEME_FUNCTIONS_PATH.'metaboxes/multi-map-w-detail-metaboxes.php');
			break;
		case 'textarea':
			echo'<textarea name="'.$meta_box['name'].'_value" class="option-textarea" />'.$meta_box_value.'</textarea><br />';
			break;
		case 'imageradio':
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
					$checked= $meta_box_value == $option['id']?'checked="checked"':'';
					echo '<div class="imageradio"><input type="radio" name="'.$meta_box['name'].'_value" value="'.$option['id'].'" '.$checked.'/><img src="'.$option['img'].'" title="'.$option['title'].'"/></div>';
				}
			}
			break;
		case 'checkbox_ui':
				$checked = $meta_box_value == '1' ?'checked="checked"':'';
				echo '<div class="switch switch-square">';
					echo '<input type="checkbox" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'" value="1" '.$checked.'>';
					echo '<label for="'.$meta_box['name'].'" data-on="ON" data-off="OFF"></label>';
				echo '</div>';
			break;
		case 'select':
			echo '<select name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">';

				
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { ?>
				<option
				<?php if ( $meta_box_value == $option['id']) {
					echo ' selected="selected"';
				}
				if ($option['id']=='disabled') {
					echo ' disabled="disabled"';
				}

				if (isset($option['class'])) {
					echo ' class="'.$option['class'].'"';
				}
				?>
					value="<?php echo($option['id']);?>"><?php echo $option['name']; ?></option>
				<?php

				}
			}
			echo '</select>';
			break;
	}

	if($meta_box['type']!='heading'){
		echo'<span class="option-description">';
		if(isset($meta_box['description'])){
			echo $meta_box['description'];
		}
		echo '</span></div>';
		if(strstr($box_class,'last')){
			echo '<div class="clear"></div>';
		}
	}
}


/**
 * Saves the meta box content of a page
 * @param $post_id the ID of the page that contains the meta box
 */
function save_postdata( $post_id ) {
	global $post, $new_meta_page_boxes;

	if(isset($post) && $post->post_type=='page'){
		$new_meta_page_boxes=$GLOBALS['new_meta_page_boxes'];
		pexeto_save_meta_data($new_meta_page_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_fichas_postdata( $post_id ) {
	global $post, $new_meta_fichas_boxes;

	if(isset($post) && $post->post_type=='fichas'){
		pexeto_save_meta_data($new_meta_fichas_boxes, $post_id);
	}
}

/**
 * Saves the post meta for all types of posts.
 * @param $new_meta_boxes the meta data array
 * @param $post_id the ID of the post
 */
function pexeto_save_meta_data($new_meta_boxes, $post_id){
	foreach($new_meta_boxes as $meta_box) {

		if($meta_box['type']!='heading'){
			// Verify
			if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
				return $post_id;
			}

			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
			}

			$data = $_POST[$meta_box['name'].'_value'];



			if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
			add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
			elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
			update_post_meta($post_id, $meta_box['name'].'_value', $data);
			elseif($data == "")
			delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));

		}
	}
}


/* ------------------------------------------------------------------------*
 * HELPER META FUNCTIONS
 * ------------------------------------------------------------------------*/

/**
 * Returns the default value of a meta box.
 * @param $meta_array the array of meta boxes to search within
 * @param $name the name (ID) of the meta box
 */
function pexeto_get_meta_std_value($meta_array, $name){
	foreach($meta_array as $meta_item){
		if($meta_item["name"]==$name){
			return $meta_item["std"];
		}
	}
	return '';
}

/**
 * Returns the saved meta data for a page of each of the given keys.
 * @param int $page_id the ID of the page to retrieve the meta data
 * @param array $keys an array containing all the keys whose values will be retrieved
 */
function pexeto_get_post_meta($page_id, $keys){
	global $new_meta_boxes;
	
	$res=array();
	foreach($keys as $key){
		$meta=get_post_meta($page_id, $key.'_value', true);
		if($meta!=''){
			$res[$key]=$meta;
		}else{
			//if the value is not saved, get the default value from the array
			$res[$key]=pexeto_get_meta_std_value($new_meta_boxes, $key);
		}
	}
	return $res;
}

