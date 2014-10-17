<?php if ( isset($_POST['add_link']) ) { ?>

<?php 
//echo '<pre>';print_r($_POST);echo '</pre>';
$tid = $_POST['tid'];
$gdrive_link = trim($_POST['gdrive_link']);
$link_errors = array();
$parsed_link = parse_url($gdrive_link);

//echo '<pre>';print_r($parsed_link);echo '</pre>';

if ($gdrive_link == "") {
$link_errors[] = "You have not entered a url.";	
}

if (!array_key_exists('scheme', $parsed_link)) {
$link_errors[] = "Please enter http:// or https:// at the start of the link.";	
}

if (empty($task_errors)) {
update_post_meta($tid, 'gdrive_link', $gdrive_link);
}

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

<?php if (empty($link_errors)) { ?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-check"></i> Link Added</span></h3>

	<p class="text-center bold">Your link has been added.</p><br>

	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>

<?php } else { ?>

<div class="alert alert-danger">
		
	<h3><span><i class="fa fa-plus"></i> Add Task</span></h3>
	
	<div class="alert-content">
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="add_link_form">
		
		<br>
		<div class="well">
			<p class="bold"><i class="fa fa-warning"></i> Errors!</p>
		
			<ul class="list-unstyled" style="margin-bottom: 0px;">
			<?php foreach ($link_errors as $error) { ?>
				<li><i class="fa fa-asterisk"></i> <?php echo $error; ?></li>
			<?php } ?>
			</ul>
		</div>

		<div class="form-group">
			<span class="label label-danger pull-right"><i class="fa fa-asterisk"></i> Required</span>
		</div>
	
		<input type="hidden" value="<?php echo $tid; ?>" name="tid">

		<div class="form-group">
			<label for="gdrive_link">Link url:</label>
			<input type="text" id="gdrive_link" name="gdrive_link" class="form-control" value="<?php echo $gdrive_link; ?>">
			<p class="help-block">Enter the url link for a file of web page.</p>
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-sm-6">
					<input type="submit" name="add_link" value="Update" class="btn btn-success btn-block">
				</div>
				<div class="col-sm-6">
				<a href="<?php echo $curURL; ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>

		
	</form>
	
	</div>
	
</div>

<?php } ?>

<?php } ?>