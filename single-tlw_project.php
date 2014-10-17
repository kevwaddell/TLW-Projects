<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
global $current_user;

//echo '<pre>';print_r( get_user_meta($current_user->ID, 'first_name') );echo '</pre>';
?>

<?php include (STYLESHEETPATH . '/_/inc/projects/single-vars.php'); ?>

	<div class="alerts">
	
		<?php include (STYLESHEETPATH . '/_/inc/alerts/alerts.php'); ?>
			
	</div>
	
	<div class="messages">
	
		<?php if ($pending_total == 0 && $completed_total > 0 && empty($date_end)) { ?>
		<div class="alert alert-warning alert-dismissible text-center fade in" role="alert">
		
			<p><strong>All tasks are completed.</strong><br>Would you like to mark this project as completed.</p><br>
			
			<a href="?action=complete-project&pid=<?php echo $post->ID; ?>" class="btn btn-success request-btn" title="Yes"><i class="fa fa-check"></i> Yes</a>
			<button type="button" class="btn btn-danger" data-dismiss="alert"><i class="fa fa-times"></i> No</button>
	
		</div>
		<?php } ?>
	
	</div>


	<article <?php post_class(); ?>>
		
		<div class="project-actions btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			 <i class="fa fa-cogs fa-lg"></i>
			</button>
			<ul class="dropdown-menu" role="menu">
				<?php if (empty($p_tasks) && empty($date_end)) { ?>
				<li><a href="?request=complete-project&pid=<?php echo $post->ID; ?>" class="request-btn"><i class="fa fa-check"></i> Complete Project</a></li>
				<?php } ?>
				<li><a href="?request=edit-project&pid=<?php echo $post->ID; ?>" class="request-btn"><i class="fa fa-pencil"></i> Edit Project</a></li>
			</ul>
		</div>

		<div class="page-header">
			<?php if ($date_end) { ?>
			<span class="label label-success"><i>Completed:</i> <?php echo date('D jS M, Y', strtotime($date_end)); ?></span> 
			<?php } ?>
			<h2><?php the_title(); ?></h2>
			
			<span class="label label-default"><i>Created by:</i> <?php the_author(); ?></span> 
			
			<span class="label label-default"><i>Created on:</i> <?php echo date('D jS M, Y', strtotime($date_start)); ?></span> 
			
			<?php if (!empty($company)) { ?>
			<span class="label label-default"><i>Business area:</i> <?php echo $company[0]; ?></span> 
			<?php } ?>
			
			<?php if (!empty($media_type)) { ?>
			<span class="label label-default"><?php echo strip_tags($media_type); ?>
			<?php } ?>
			
			</span> 
		</div>
		<div class="entry">
		<?php the_content(); ?>
		</div>
									
	</article>
		
	<section class="panels">

	<?php include (STYLESHEETPATH . '/_/inc/projects/single-tasks-panel.php'); ?>
	
	<?php comments_template(); ?>
	
	</section>
	
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
