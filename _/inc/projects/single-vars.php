<?php 
$date_start = get_field('project_start_date');
$date_end = get_field('project_completed_date');
$company = wp_get_post_terms($post->ID, 'tlw_company_tax', array("fields" => "names"));
$post_media_types = wp_get_post_terms($post->ID, 'tlw_media_types', array("fields" => "names"));
$media_type = get_the_term_list($post->ID, 'tlw_media_types', '<i>Media type:</i> ', ', ');
//echo '<pre>';print_r($post_media_types);echo '</pre>';
 ?>
 
 <?php 
$tasks_args = array(
'post_type'	=> 'tlw_task',
'post_status'	=> 'publish',
'posts_per_page' => -1,
'meta_key'	=> 'task_date',
'orderby' => 'meta_value_num',
'order'	=> 'ASC'
);

$p_tasks_args = $tasks_args;
$p_tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'pending'));
$pending_tasks = get_posts($p_tasks_args);
$pending_total = count($pending_tasks);

$c_tasks_args = $tasks_args;
$c_tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'completed'));
$completed_tasks = get_posts($c_tasks_args);
$completed_total = count($completed_tasks);

if ($pending_total == 0 && $completed_total > 0 && !isset($_GET['tasks-filter'])) {
$tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'completed'));
} else {
$tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'pending'));	
}

if (isset($_GET['tasks-filter']) && $_GET['tasks-filter'] == 'complete') {
$tasks_args['order'] = 'DESC';	
$tasks_args['meta_query'] = array('relation' => 'AND',array('key'	=> 'project','value'	=> get_the_ID()), array('key'	=> 'task_status','value'	=> 'completed'));
}

$tasks = get_posts($tasks_args);
 ?>