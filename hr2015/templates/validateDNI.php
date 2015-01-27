<?php
/**
 * Template Name: Validate DNI
 */
?>
<?php 

if (!empty($_GET['dni']))
{
	global $wpdb;

    $dni = $_GET['dni'];
  
	$results = $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $dni . "'", 'ARRAY_A');

    if($results['post_title'] == $dni)
    {
        $valid = false;
    }
    else
    {
        $valid = true;
    }
}
else
{
    $valid = false;
}

echo json_encode($valid);

?>