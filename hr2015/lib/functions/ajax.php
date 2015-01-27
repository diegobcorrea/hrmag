<?php 
/**
 * AJAX Functions
 *
 * All of these functions enhance the responsiveness of the user interface in
 * the default theme by adding AJAX functionality.
 *
 * For more information on how the custom AJAX functions work, see
 * http://codex.wordpress.org/AJAX_in_Plugins.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register AJAX handlers for functionality.
 */
function ajax_register_actions() {
  $actions = array(
    // Directory filters
    'update_vote'     => 'update_vote_callback',

  );

  /**
   * Register all of these AJAX handlers
   *
   * The "wp_ajax_" action is used for logged in users, and "wp_ajax_nopriv_"
   * executes for users that aren't logged in. This is for backpat with BP <1.6.
   */
  foreach( $actions as $name => $function ) {
    add_action( 'wp_ajax_'        . $name, $function );
    add_action( 'wp_ajax_nopriv_' . $name, $function );
  } 
}
add_action( 'after_setup_theme', 'ajax_register_actions', 20 );

function update_vote_callback() {
  global $wpdb;

  $ID = $_POST['id'];

  //$filter_table = $wpdb->prefix . 'qu_carlist.' . $type;

  //$modelCar = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}qu_carlist WHERE {$filter_table} = 'X' GROUP BY marca ORDER BY marca ASC", $filter_table ) );

  echo $ID;

  die();
}