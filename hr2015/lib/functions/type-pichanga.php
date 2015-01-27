<?php
/**
 * This file contains all the botas functionality.
 *
 * @author Vita
 */

function create_fichas_post_types() {

    register_post_type('fichas', array(
        'labels' => array(
	    	'name' => 'Fichas',
	    	'all_items' => 'Ver Fichas',
	    	'singular_name' => 'Fichas',
			'add_new' => 'Agregar',
			'add_new_item' => 'Agregar nuevo item',
			'edit_item' => 'Editar Item',
			'new_item' => 'Nuevo Item',
			'view_item' => 'Ver item',
			'search_items' => 'Buscar Fichas',
			'not_found' =>  'No se encontró',
			'not_found_in_trash' => 'No se encontró en papelera',
			'parent_item_colon' => '',
			'menu_name' => 'Fichas'
		),
        'public' => true,
        'has_archive' => false,
		'rewrite' => array('slug' => 'fichas'),
		'supports' => array('title', 'thumbnail'),
    ));

}
add_action('init', 'create_fichas_post_types');


// register Taxonomies
function create_fichas_taxonomies() {

    register_taxonomy('fichas-categories', 
    	array('fichas'), 
    	array(
			'labels' => array(
			    'name' => 'Fichas Cat.'
			),
	        'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => array(
			    'slug' => 'fichas'
			)
		)
	);

}
add_action('init', 'create_fichas_taxonomies');