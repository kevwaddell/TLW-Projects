<?php get_header(); ?>

<?php 
remove_action('pre_get_posts', 'custom_author_archive');
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
global $current_user;
get_currentuserinfo();
$user_meta = get_user_meta($curauth->ID);
$user_id = get_the_author_meta( "ID", $curauth->ID );
//echo '<pre>';print_r($curauth);echo '</pre>';
 ?>

<div class="alerts">
	
	<?php include (STYLESHEETPATH . '/_/inc/alerts/alerts.php'); ?>
			
</div>

<?php include (STYLESHEETPATH . '/_/inc/user/user-info-panel.php'); ?>


<section class="panels">

	<?php include (STYLESHEETPATH . '/_/inc/user/author-projects-panel.php'); ?>
	
	<?php include (STYLESHEETPATH . '/_/inc/user/author-tasks-panel.php'); ?>

</section>

<?php get_footer(); ?>
