<?php 
$companies = get_terms('tlw_company_tax', 'hide_empty=0');
$account_pg = get_page_by_title("My Account");
$account_pg_icon = get_field('page_icon', $account_pg->ID);
$help_pg = get_page_by_title("Help");
$help_pg_icon = get_field('page_icon', $help_pg->ID);
$help_pgs = get_pages('sort_column=menu_order&parent='.$help_pg->ID);
//echo '<pre>';print_r($help_pgs);echo '</pre>';
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center"><?php echo $curauth->display_name; ?></h3>
	</div>
	<div class="panel-body">
		<?php if ($current_user->ID == $user_id) { ?>
		<div class="well wel-sm col-grayLt">
		<a href="<?php echo get_permalink($account_pg->ID); ?>" class="btn btn-primary btn-block float-icon"><?php echo ($account_pg_icon) ? '<i class="fa '.$account_pg_icon.' fa-lg"></i> ':''; ?><?php echo $account_pg->post_title; ?></a>
		</div>
		<?php } ?>
		
		<div class="row">
	
<?php foreach ($companies as $company) { 
	
	$projects_args = array (
	'post_type'	=> 'tlw_project',
	'posts_per_page' => -1,
	'company'	=> $company->slug,
	'author'	=> $curauth->ID,
	'meta_query' => array(
		array('key' => 'project_completed_date','value' => "",'compare' => "=")
		)
	);
	$pending_projects = get_posts($projects_args);	
	
	$projects_args['meta_query'] = array(array('key' => 'project_completed_date','value' => "",'compare' => "!="));
	
	$completed_projects = get_posts($projects_args);	
	
	$all_projects = array_merge($pending_projects, $completed_projects);
	$pending_tasks_counter = 0;
	$completed_tasks_counter = 0;
	
	foreach ($all_projects as $ap) {
		
		$tasks_args	= array(
		'post_type'	=> 'tlw_task',
		'posts_per_page' => -1,
		'meta_key'	=> 'project',
		'meta_value' => $ap->ID
		);
		$tasks_args['meta_query'] = array(array('key'	=> 'task_status','value' => 'pending'));
		
		$pending_tasks = get_posts($tasks_args);
		
		$pending_tasks_counter += count($pending_tasks);	
		
		$tasks_args['meta_query'] = array(array('key'	=> 'task_status','value' => 'completed'));
		
		$completed_tasks = get_posts($tasks_args);
		
		$completed_tasks_counter += count($completed_tasks);
	}
	
/*
	echo '<pre>';
	print_r($pending_task_counter);
	echo '<br>';
	print_r($complete_task_counter);
	echo '</pre>';
*/
	
?>
			<div class="col-sm-6">
				<div id="overview-panel-<?php echo $company->slug; ?>" class="overview-panel">
					<span class="icon"></span>
					<a href="<?php echo get_term_link( $company ); ?>" class="btn btn-primary btn-block"><?php echo $company->name; ?></a>
					<ul class="list-group" style="margin-bottom: 10px;">
						<li class="list-group-item">
							<span class="badge"><?php echo count($pending_projects); ?></span>
							Pending Projects 
						</li>
						<li class="list-group-item">
							<span class="badge"><?php echo $pending_tasks_counter; ?></span>
							Pending Tasks
						</li>
					</ul>
					<ul class="list-group">
						<li class="list-group-item">
							<span class="badge"><?php echo count($completed_projects); ?></span>
							Completed Projects 
						</li>
						<li class="list-group-item">
							<span class="badge"><?php echo $completed_tasks_counter; ?></span>
							Completed Tasks
						</li>
					</ul>
				</div>
			</div>
<?php } ?>

		</div>
	</div>

				
</div>
