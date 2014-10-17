<?php if ($_GET['action'] == 'delete-task') { ?>

<?php
$tid = $_GET['tid'];
wp_trash_post( $tid );
?>

	<div class="alert alert-success">
		
		<h3><span><i class="fa fa-check"></i> Task removed</span></h3>
		
		<p class="bold text-center"><i class="fa fa-check-circle"></i> Your task has been removed.</p><br>

		<div class="action-btns">
			<a href="<?php the_permalink(); ?>" class="btn btn-success btn-block" title="Continue">Continue <i class="fa fa-angle-right"></i> </a>
		</div>

	</div>

<?php } ?>