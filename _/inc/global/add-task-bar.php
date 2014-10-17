<?php 
$projects_pg = get_page_by_title("Projects");
 ?>
<div class="well well-sm col-gray">

	<a href="?request=add-task&pid=<?php echo $post->ID; ?>" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Task</span></a>

	<!--
<div class="row">
		
		<div class="col-xs-6">
			<a href="?request=add-task&pid=<?php echo $post->ID; ?>" class="btn btn-primary request-btn" role="button"><i class="fa fa-plus"></i> <span class="txt">Add Task</span></a>
		</div>
		
		<div class="col-xs-6 text-right">
			
			<div class="pull-right">
				
				<button id="view-video" type="button" class="btn btn-info open-sidebar">
					<i class="fa fa-video-camera"></i>
				</button>
				
				<button id="view-help" type="button" class="btn btn-info open-sidebar">
					<i class="fa fa fa-life-ring"></i>
				</button>
					
			</div>
			
		</div>
		
	</div>
-->

</div>
