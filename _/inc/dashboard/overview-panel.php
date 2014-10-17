<?php 
global $current_user;
$companies = get_terms('tlw_company_tax', 'hide_empty=0');
$account_pg = get_page_by_title("My Account");
$account_pg_icon = get_field('page_icon', $account_pg->ID);
$team_pg = get_page_by_title("Team");
$team_pg_icon = get_field('page_icon', $team_pg->ID);
$help_pg = get_page_by_title("Help");
$help_pg_icon = get_field('page_icon', $help_pg->ID);
$help_pgs = get_pages('sort_column=menu_order&parent='.$help_pg->ID);
//echo '<pre>';print_r($help_pgs);echo '</pre>';
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title text-center">Projects dashboard</h3>
	</div>
	<div class="panel-body">
		<div class="row">
		
			<div class="col-md-4">
			
				<div class="well well-sm col-grayLt">
					<div class="welcome-box">
						<?php echo get_avatar( $current_user->ID, 70 ); ?>
						<div class="user-txt">
							<p>Team Member</p>
							<span><?php echo $current_user->display_name; ?></span>
						</div>
					</div>
				<a href="<?php echo get_permalink($account_pg->ID); ?>" class="btn btn-primary btn-block float-icon"><?php echo ($account_pg_icon) ? '<i class="fa '.$account_pg_icon.' fa-lg"></i> ':''; ?><?php echo $account_pg->post_title; ?></a>
					<a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename); ?>" class="btn btn-primary btn-block float-icon"><i class="fa fa-archive fa-lg"></i> My Projects</a>
					<a href="<?php echo get_permalink($team_pg->ID); ?>" class="btn btn-primary btn-block float-icon"><?php echo ($team_pg_icon) ? '<i class="fa '.$team_pg_icon.' fa-lg"></i> ':''; ?><?php echo $team_pg->post_title; ?></a>
					<a href="https://drive.google.com/folderview?id=0B0YEQYF714l7THBTUE9rd3dFTHc&usp=sharing" class="btn btn-primary btn-block float-icon" target="_blank"><i class="fa fa-google fa-lg"></i> Google Drive</a>
					
					<a href="http://adobe.ly/1nq8OxP" class="btn btn-primary btn-block float-icon" target="_blank"><i class="fa fa-cloud fa-lg"></i> Creative Cloud</a>

				</div>
			
				<!--
<div class="btns">
					
					<a href="<?php echo get_permalink($team_pg->ID); ?>" class="btn btn-primary btn-block float-icon"><?php echo ($team_pg_icon) ? '<i class="fa '.$team_pg_icon.' fa-lg"></i> ':''; ?><?php echo $team_pg->post_title; ?></a>
					<?php foreach ($help_pgs as $help_pg) { 
					$icon = get_field('page_icon', $help_pg->ID);	
					?>
					<a href="<?php echo get_permalink($help_pg->ID); ?>" class="btn btn-primary btn-block float-icon"><?php echo ($icon) ? '<i class="fa '.$icon.' fa-lg"></i> ':''; ?><?php echo $help_pg->post_title; ?></a>
					<?php } ?>
				</div>
-->
				
			</div>

	
<?php foreach ($companies as $company) { 
	
	$projects_args = array (
	'post_type'	=> 'tlw_project',
	'posts_per_page' => -1,
	'company'	=> $company->slug,
	'meta_query' => array(
		array('key' => 'project_completed_date','value' => "",'compare' => "=")
		)
	);
	$pending_projects = get_posts($projects_args);	
	
	$projects_args['author'] = $current_user->ID;
	
	$your_projects = get_posts($projects_args);	
	
	$all_projects = array_merge($pending_projects, $your_projects);
	$pending_tasks_counter = 0;
	$your_tasks_counter = 0;
	
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
		
		$tasks_args['author'] = $current_user->ID;
		
		$your_tasks = get_posts($tasks_args);
		
		$your_tasks_counter += count($your_tasks);
	}
	
/*
	echo '<pre>';
	print_r($pending_task_counter);
	echo '<br>';
	print_r($complete_task_counter);
	echo '</pre>';
*/
	
?>
			<div class="col-sm-6 col-md-4">
				<div id="overview-panel-<?php echo $company->slug; ?>" class="overview-panel">
					<span class="icon"></span>
					<a href="<?php echo get_term_link( $company ); ?>" class="btn btn-primary btn-block"><?php echo $company->name; ?></a>
					<ul class="list-group" style="margin-bottom: 10px;">
						<li class="list-group-item">
							<span class="badge"><?php echo count($your_projects); ?></span>
							Your Pending Projects 
						</li>
						<li class="list-group-item">
							<span class="badge"><?php echo $your_tasks_counter; ?></span>
							Your Pending Tasks
						</li>
					</ul>
					<ul class="list-group">
						<li class="list-group-item">
							<span class="badge"><?php echo count($pending_projects); ?></span>
							All Pending Projects 
						</li>
						<li class="list-group-item">
							<span class="badge"><?php echo $pending_tasks_counter; ?></span>
							All Pending Tasks
						</li>
					</ul>
				</div>
			</div>
<?php } ?>

		</div>
	</div>

				
</div>
