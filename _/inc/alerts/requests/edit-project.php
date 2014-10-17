<?php if ($_GET['request'] == 'edit-project') { ?>

<?php
$pid = $_GET['pid'];
$project = get_post($pid);
$date_start = get_field('project_start_date', $pid);
$company = wp_get_post_terms($pid, 'tlw_company_tax', array("fields" => "names"));
$companies = get_terms('tlw_company_tax', 'hide_empty=0');
$media_types = get_terms('tlw_media_types', 'hide_empty=0&parent=0');
$post_media_types = wp_get_post_terms($pid, 'tlw_media_types', array("fields" => "names"));
$users = get_users();
//echo '<pre>';print_r($media_types);echo '</pre>';

$curURL = get_permalink();

if (is_front_page()) {
$curURL = get_option('home');
}

if (is_tax('tlw_media_types')) {
$media_type = get_query_var("media-type");
$curURL = get_term_link($media_type, 'tlw_media_types');
}

if (is_tax('tlw_company_tax')) {
$company = get_query_var("company");
$curURL = get_term_link($company, 'tlw_company_tax');
}

if (is_post_type_archive('tlw_project')) {
$projects_pg = get_page_by_title('Projects');
$curURL = get_permalink($projects_pg->ID);
}
 ?>
<div class="alert alert-info">
	
	<h3><span><i class="fa fa-pencil"></i> Edit Project</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="edit_project_form">
	
		<input type="hidden" value="<?php echo $pid; ?>" name="pid">
	
		<div class="form-group">
			<label for="project_title">Project title:</label>
			<input type="text" id="project_title" name="project_title" class="form-control" value="<?php echo $project->post_title ; ?>">
		</div>
		
		<div class="form-group">
			<label for="project_date">Project date</label>
			<input type="text" id="project_date" name="project_date" class="form-control date-picker" placeholder="Choose a date" value="<?php echo date('l j F, Y', strtotime($date_start)); ?>">
		</div>
		
		<div class="row">
		
			<div class="col-sm-6">
			
				<div class="form-group">
					<label for="project_company">Business area:</label>
					<div>
						<?php foreach ($companies as $comp) { ?>
						<label class="radio-inline">
							<input type="radio" name="company_tax" id="task-status-pending" value="<?php echo $comp->term_id ; ?>"<?php echo ($company[0] == $comp->name) ? ' checked':''; ?>> <?php echo $comp->name ; ?>
						</label>
						<?php } ?>
						
					</div>
				</div>
			
				<div class="form-group">
					<label for="project_content">Project details</label>
					<textarea id="project_content" name="project_content" class="form-control" rows="6"><?php echo $project->post_content; ?></textarea>
				</div>
								
			</div>
			
			<div class="col-sm-6">
			
				<div class="form-group">
					<label for="project_company">Media type:</label>
					<div>
		
					<?php foreach ($media_types as $media) { 
							$media_kids = get_terms('tlw_media_types', 'hide_empty=0&parent='.$media->term_id);
							?>
								
							<div class="checkbox">
								<label>
									<input type="checkbox" name="media_type[]" value="<?php echo $media->term_id; ?>"<?php echo (in_array($media->name, $post_media_types)) ? ' checked':''; ?>> <?php echo $media->name; ?>
								</label>
								<?php if ($media_kids) { ?>
									<?php foreach ($media_kids as $mk) { ?>
									<div class="checkbox indented">
										<label>
										<input type="checkbox" name="media_type[]" value="<?php echo $mk->term_id; ?>"<?php echo (in_array($mk->name, $post_media_types)) ? ' checked':''; ?>> <?php echo $mk->name; ?>
										</label>
									</div>
									<?php } ?>
								<?php } ?>
							</div>
							<?php } ?>
					</div>
				</div>
			
			</div>
			
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-xs-6">
					<input type="submit" name="edit_project" value="Update" class="btn btn-success btn-block">
				</div>
				<div class="col-xs-6">
				<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>

		
	</form>
	
	</div>
	
</div>

<?php } ?>