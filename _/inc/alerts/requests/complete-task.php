<?php if ($_GET['request'] == 'completed') { ?>

<div class="alert alert-danger">

	<h3><span><i class="fa fa-warning"></i> Alert</span></h3>

	<p class="text-center bold">Are you sure want to mark this task as completed.</p><br>

	<div class="action-btns">
		<div class="row">
			<div class="col-xs-6">
			<a href="?action=completed&tid=<?php echo $_GET['tid']; ?>&pid=<?php echo $_GET['pid']; ?>" class="btn btn-success btn-block request-btn" title="Yes"><i class="fa fa-check"></i> Yes</a>
			</div>
			<div class="col-xs-6">
			<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block cancel-btn" title="No"><i class="fa fa-times"></i> No</a>
			</div>
		</div>
	</div>

</div>

<?php } ?>
