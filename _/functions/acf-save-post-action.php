<?php
function my_acf_save_post( $post_id )
{
	global $current_screen;
	// vars	
	
	//echo '<pre>';print_r($current_screen);echo '</pre>';
	
	if ($current_screen->id == 'tlw_project') {
		
		//echo '<pre>';print_r($_POST);echo '</pre>';
		
		$slug = sanitize_title('projectid '.$_POST['aa'].$_POST['mm'].$_POST['jj'].$_POST['hh'].$_POST['mn'].$_POST['ss']); 
		$title = $_POST['acf']['field_541ad2e0fc4ea'];
				
		wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_name' => $slug) );
	}	
	
	if ($current_screen->id == 'tlw_task') {
		
		//echo '<pre>';print_r($_POST);echo '</pre>';
		
		$slug = sanitize_title('taskid '.$_POST['aa'].$_POST['mm'].$_POST['jj'].$_POST['hh'].$_POST['mn'].$_POST['ss']); 
		$title = $_POST['acf']['field_541adcec36c33'];

		
		wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_name' => $slug) );
	}	
	
	//exit;
	
}

add_action('acf/save_post', 'my_acf_save_post', 1);
 
?>