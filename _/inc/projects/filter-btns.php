<div class="panel-body">
	<div class="row">
			<div class="col-xs-6">
				<div class="btn-group filter-actions">
					<a href="?projects-filter=pending" class="btn btn-danger<?php echo ($_GET['projects-filter'] == 'pending' || !isset($_GET['projects-filter']))? ' active':''; ?>" role="button"><i class="fa fa-clock-o"></i> Pending</a>
					<a href="?projects-filter=complete" class="btn btn-success<?php echo ($_GET['projects-filter'] == 'complete')? ' active':''; ?>" role="button"><i class="fa fa-check"></i> Complete</a>
					
				</div>
			</div>

			<div class="col-xs-6 text-right">
				<a href="?request=add-project" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Project</span></a>
			</div>
	</div>
</div>
