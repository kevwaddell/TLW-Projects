<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$notified = $_POST['user-notify'];
$now = strtotime("now");
$from = get_user_by('id', $_POST['uid']);
$project = get_post($_POST['pid']);
$task = get_post($_POST['tid']);
$link = get_field('gdrive_link', $task->ID);
$task_created = strtotime( get_field('task_date', $task->ID) );
$task_created_by = get_user_by('id', $task->post_author);

$from_name = $from->data->display_name;
$from_email = $from->data->user_email;

//echo '<pre>';print_r($from);echo '</pre>';

$subject = $from_name. ' has added a TLW Project task';
$message = '<h3><font style="color: red;">'. $from_name .'</font> has added a task to <font style="color: red;">'. $project->post_title .'</font> project.</h3>';
$message .= '<br>';
$message .= '<table width="100%" border="0" cellspacing="2" cellpadding="10"><tbody><thead>';
$message .= '<tr><th colspan="2" bgcolor="#989898">TASK DETAILS</th></tr></thead>';
$message .= '<tbody><tr><td bgcolor="#C0C0C0" width="20%">Task name:</td><td bgcolor="#D8D8D8">'.  $task->post_title .'</td></tr>';
$message .= '<tr><td bgcolor="#C0C0C0">Description:</td><td bgcolor="#D8D8D8">'. $task->post_content .'</td></tr>';
if ($link) { 
$message .= '<tr><td bgcolor="#C0C0C0">Attachment:</td><td bgcolor="#D8D8D8"><a href="'.  $link .'" title="Attachment link">Attachment link >></a></td></tr>';
}
$message .= '<tr><td bgcolor="#C0C0C0">Task created by:</td><td bgcolor="#D8D8D8">'. $task_created_by->data->display_name .'</td></tr>';
$message .= '<tr><td bgcolor="#C0C0C0" valign="top">Task created on:</td><td bgcolor="#D8D8D8">'.  date('D jS F Y', $task_created) . '</td></tr></tbody>';
$message .= '</table><br><br>';
$message .= 'Please use the link below to view project details.<br><br>';
$message .= '<a href="'.get_permalink($project->ID).'" title="View project details">View project details >></a><br><br>';
$headers = 'From:'. $from_name .'<'. $from_email .'>';

function wps_set_content_type(){
	return "text/html";
	}
add_filter( 'wp_mail_content_type','wps_set_content_type' );

if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
	foreach ($notified as $user_id) {
	$user_data = get_user_by('id', $user_id);	
	wp_mail( $user_data->data->user_email, $subject, $message, $headers );
	}
} else {
	wp_mail( "kevwaddell@mac.com", $subject, $message, $headers );
}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

date_default_timezone_set($default_tz); 
?>