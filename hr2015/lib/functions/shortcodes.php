<?php
/**
 * This file contains all the shortcodes and TinyMCE formatting buttons functionality.
 *
 * @author Pexeto
 */



/* ------------------------------------------------------------------------*
 * TABS
 * ------------------------------------------------------------------------*/

function show_tabs($atts, $content = null) {
	extract(shortcode_atts(array(
		"titles" => '',
		"width" => 'medium'
	), $atts));
	$titlearr=explode(',',$titles);
	$html='<div class="tabs-container"><ul class="tabs ">';
	if($width=='small'){
		$wclass='w1';
	}elseif($width=='big'){
		$wclass='w3';
	}else{
		$wclass='w2';
	}
	foreach($titlearr as $title){
		$html.='<li class="'.$wclass.'"><a href="#">'.$title.'</a></li>';
	}
	$html.='</ul><div class="panes">'.do_shortcode($content).'</div></div>';
	return $html;
}
add_shortcode('tabs', 'show_tabs');


function show_pane($atts, $content = null) {
	return '<div>'.do_shortcode($content).'</div>';
}
add_shortcode('pane', 'show_pane');


function show_accordion($atts, $content = null) {
	return '<div class="accordion-container"><div id="accordion">'.do_shortcode($content).'</div></div>';
}
add_shortcode('accordion', 'show_accordion');


function show_apane($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
		), $atts));
		return '<h2>'.$title.'</h2><div class="pane">'.do_shortcode($content).'</div>';
}
add_shortcode('apane', 'show_apane');

/* ------------------------------------------------------------------------*
 * TESTIMONIALS
 * ------------------------------------------------------------------------*/


function pexeto_show_testim($atts, $content = null) {
	extract(shortcode_atts(array(
		"name" => '',
		"img" =>'',
		"org" =>'',
		"link" =>'',
		"occup" =>''
		), $atts));
		
		$addClass=$img?'':' no-image';
		$testim='<div class="testimonial-container'.$addClass.'"><h2>'.$name.'</h2><span class="testimonials-details">'.$occup;
		if($org){
			$testim.=' / ';
			if($link) $testim.='<a href="'.$link.'">';
			$testim.=$org;
			if($link) $testim.='</a>';
		}
		$testim.='</span><div class="double-line"></div>';
		if ($img) $testim.='<img class="img-frame testimonial-img" src="'.$img.'" alt="" />';
		$testim.='<blockquote><p>'.do_shortcode($content).'</p></blockquote><div class="clear"></div></div>';
		return $testim;
}
add_shortcode('pextestim', 'pexeto_show_testim');

/* ------------------------------------------------------------------------*
 * SCROLLBAR
 * ------------------------------------------------------------------------*/


function pexeto_show_scrollbar($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => '',
		"width" =>'',
		"height" =>'',
		"color" =>''
		), $atts));

		if($id == '') { $id = 'default'; }
		if($width == '') { $width = 640; }
		if($height == '') { $height = 220; }
		if($color == '') { $color = edc234; }
		
		$scrollbar = '<script> var jq = jQuery; jq(document).ready( function() { jq(".scroll-'.$id.'").slimScroll({ color: "#'.$color.'", width: "'.$width.'px", height: "'.$height.'px", alwaysVisible: true }); }); </script>';

		$scrollbar.= '<div class="scroll-'.$id.'">';
		$scrollbar.= do_shortcode($content);
		$scrollbar.= '</div>';

		return $scrollbar;
}
add_shortcode('scrollbar', 'pexeto_show_scrollbar');

/* ------------------------------------------------------------------------*
 * ADD CUSTOM FORMATTING BUTTONS
 * ------------------------------------------------------------------------*/

global $pexeto_buttons;
$pexeto_styling_buttons=array("pexetolistchecksmall", "pexetolistcheckbig", "pexetolistcheck", "pexetoliststar", "pexetolistarrow", "pexetolistarrow2", "pexetolistarrow4", "pexetolistplus", "|", "pexetolinebreak", 
"pexetoframe", "pexetolightbox", "|", "pexetobutton", "pexetoinfoboxes");
$pexeto_content_buttons=array( "|", "pexetotwocolumns", "pexetothreecolumns", "pexetofourcolumns", "|", "pexetoyoutube", "pexetovimeo", "pexetoflash", "|", "pexetotestimonials", "pexetoscrollbar");

function add_pexeto_buttons() {
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'pexeto_add_btn_tinymce_plugin');
		add_filter('mce_buttons_4', 'pexeto_register_styling_buttons');
		add_filter('mce_buttons_4', 'pexeto_register_content_buttons');
	}
}

add_action('init', 'add_pexeto_buttons');


/**
 * Register the buttons
 * @param $buttons
 */
function pexeto_register_styling_buttons($buttons) {
	global $pexeto_styling_buttons;

	array_push($buttons, implode(',',$pexeto_styling_buttons));
	return $buttons;
}

/**
 * Add the buttons
 * @param $plugin_array
 */
function pexeto_add_btn_tinymce_plugin($plugin_array) {
	global $pexeto_styling_buttons, $pexeto_content_buttons;
	$merged_buttons=array_merge($pexeto_styling_buttons, $pexeto_content_buttons);
	foreach($merged_buttons as $btn){
		$plugin_array[$btn] = THEME_LIB_URL.'formatting-buttons/editor-plugin.js';
	}
	return $plugin_array;
}

/**
 * Register the buttons
 * @param $buttons
 */
function pexeto_register_content_buttons($buttons) {
	global $pexeto_content_buttons;

	array_push($buttons, implode(',',$pexeto_content_buttons));
	return $buttons;
}

