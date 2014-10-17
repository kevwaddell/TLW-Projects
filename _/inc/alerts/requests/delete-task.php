<?php if ($_GET['request'] == 'delete-task') { ?>

<?php
$tid = $_GET['tid'];
$task = get_post($tid);
global $current_user;
$owner = get_userdata($task->post_author);	
 ?>
 
 <?php if ($current_user->ID == $task->post_author || current_user_can('administrator')) { ?>
 	
	<div class="alert alert-danger">
	
		<h3><span><i class="fa fa-warning"></i> Alert</span></h3>
		
		<p class="bold text-center"><i class="fa fa-warning"></i> Are you sure want to remove this task.</p><br>

		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
				<a href="?action=delete-task&tid=<?php echo $tid; ?>" class="btn btn-success btn-block request-btn" title="Yes"><i class="fa fa-check"></i> Yes</a>
				</div>
				<div class="col-xs-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block cancel-btn" title="No"><i class="fa fa-times"></i> No</a>
				</div>
			</div>
		</div>

	</div>

 
 <?php } else { ?>
 	
	<div class="alert alert-danger">
	
		<h3><span><i class="fa fa-warning"></i> Alert</span></h3>
		
		<p class="bold text-center"><i class="fa fa-warning"></i> Sorry this task was created by <?php echo $owner->data->display_name; ?>.<br> You do not have permission to remove this task.</p><br>

		<div class="action-btns">
			<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
		</div>

	</div>
 
 <?php } ?>

<?php } ?>