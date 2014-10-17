<?php if ( isset($_POST['notify-team']) ) { 
global $current_user;
$users = get_users('exclude='.$current_user->ID);
$notified = $_POST['user-notify'];
$errors = array();
//echo '<pre>';print_r($_POST);echo '</pre>';

if (empty($notified)) {
$errors[] = "You have not selected a team member";
} else {

if ($_POST['event-action'] == 'completed-task') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-task-completed-email.php');
}

if ($_POST['event-action'] == 'add-task') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-add-task-email.php');
}

if ($_POST['event-action'] == 'edit-task') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-edit-task-email.php');
}

if ($_POST['event-action'] == 'completed-project') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-project-completed-email.php');
}

if ($_POST['event-action'] == 'edit-project') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-edit-project-email.php');
}

if ($_POST['event-action'] == 'add-project') {
include (STYLESHEETPATH . '/_/inc/alerts/actions/notify-add-project-email.php');
}
	
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
	
<?php if (!empty($errors)) { ?>

<div class="alert alert-danger">

	<h3><span><i class="fa fa-warning"></i> Error!</span></h3>

	<p class="text-center"><strong>Notify team members.</strong></p><br>
	
	<div class="well well-sm bg-red text-center">
		<?php echo $errors[0]; ?>
	</div>
	
	<form action="<?php echo $curURL; ?>" method="post" class="alert-form" id="notify_task_form">
	
	<input type="hidden" value="<?php echo $current_user->ID; ?>" name="uid">
	<input type="hidden" value="<?php $_POST['tid']; ?>" name="tid">
	
	<div class="form-group text-center">
		<?php foreach ($users as $u) { 
		//echo '<pre>';print_r($u);echo '</pre>';
		?>
		<label class="checkbox-inline">
			<input type="checkbox" name="user-notify[]" value="<?php echo $u->ID; ?>"> <?php echo $u->data->display_name; ?>
		</label>
		<?php } ?>
	</div>

	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
			<input type="submit" name="notify-team" value="Notify" class="btn btn-danger btn-block">
			</div>
			<div class="col-xs-6">
			<a href="<?php echo $curURL; ?>" class="btn btn-default btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
			</div>
		</div>
	</div>
	
	</form>

</div>

<?php } else { ?>

<div class="alert alert-success">

	<h3><span><i class="fa fa-check"></i> Notified</span></h3>

	<p class="text-center"><strong>The following team <?php echo(count($notified) > 1) ? "members have":"member has"; ?> been notified.</strong></p>
	
	<ul class="list-unstyled text-center">
		<?php foreach ($notified as $user_id) { 
		$user = get_userdata($user_id);	
		//echo '<pre>';print_r($user);echo '</pre>';
		?>
		<li><?php echo $user->data->display_name; ?></li>
		<?php } ?>
	
	</ul>
	<br>
	<div class="action-btns">
		<a href="<?php echo $curURL; ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i></a>
	</div>

</div>


<?php } ?>

<?php } ?>

