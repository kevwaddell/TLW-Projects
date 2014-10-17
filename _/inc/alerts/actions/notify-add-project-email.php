<?php 
$default_tz = date_default_timezone_get();
date_default_timezone_set('Europe/London'); 
$notified = $_POST['user-notify'];
$now = strtotime("now");
$from = get_user_by('id', $_POST['uid']);
$project = get_post($_POST['pid']);
$project_created = strtotime( get_field('project_start_date', $project->ID) );
$created_by = get_user_by('id', $project->post_author);

$from_name = $from->data->display_name;
$from_email = $from->data->user_email;

//echo '<pre>';print_r($from);echo '</pre>';

$subject = "$from_name has added a TLW Project";
$message = "<h3><font style=\"color: red;\">$from_name</font> has added <font style=\"color: red;\">". $project->post_title ."</font> project.</h3>";
$message .= "<br>";
$message .= "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"10\"><tbody><thead>";
$message .= "<tr><th colspan=\"2\" bgcolor=\"#989898\">PROJECT DETAILS</th></tr></thead>";
$message .= "<tbody><tr><td bgcolor=\"#C0C0C0\" width=\"20%\">Title:</td><td bgcolor=\"#D8D8D8\">".  $project->post_title ."</td></tr>";
$message .= "<tr><td bgcolor=\"#C0C0C0\">Description:</td><td bgcolor=\"#D8D8D8\">". $project->post_content ."</td></tr>";
if ($_POST['uid'] != $project->post_author) {
$message .= "<tr><td bgcolor=\"#C0C0C0\">Project created for:</td><td bgcolor=\"#D8D8D8\">". $created_by->data->display_name ."</td></tr>";
} else {
$message .= "<tr><td bgcolor=\"#C0C0C0\">Project created by:</td><td bgcolor=\"#D8D8D8\">". $created_by->data->display_name ."</td></tr>";	
}
$message .= "<tr><td bgcolor=\"#C0C0C0\" valign=\"top\">Project created on:</td><td bgcolor=\"#D8D8D8\">".  date('D jS F Y', $project_created) . "</td></tr></tbody>";
$message .= "<tfoot><tr><td bgcolor=\"#C0C0C0\">Project updated at:</td><td bgcolor=\"#D8D8D8\">". date('D jS F Y', $now) ." at ". date('H:i', $now)  . "</td></tr></tfoot>";
$message .= "</table><br><br>";
$message .= "Please use the link below to view project details.<br><br>";
$message .= "<a href=\"".get_permalink($project->ID)."\" title=\"View project details\">View project details >></a><br><br>";
$headers = "From: $from_name <$from_email>";


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