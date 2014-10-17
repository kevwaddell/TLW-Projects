<?php if ($_GET['request'] == 'add-link') { ?>
<?php
$tid = $_GET['tid'];
 ?>
<div class="alert alert-info">

<h3><span><i class="fa fa-plus"></i> Add Link</span></h3>

<div class="alert-content">

	<form action="<?php the_permalink(); ?>" method="post" class="alert-form" id="add_link_form">
	
		<input type="hidden" value="<?php echo $tid; ?>" name="tid">
	
		<div class="form-group">
			<label for="gdrive_link">Link url:</label>
			<input type="text" id="gdrive_link" name="gdrive_link" class="form-control" value="">
			<p class="help-block">Enter the url link for a file of web page.</p>
		</div>
		
		<div class="action-btns">
			<div class="row">
				<div class="col-sm-6">
					<input type="submit" name="add_link" value="Add" class="btn btn-success btn-block">
				</div>
				<div class="col-sm-6">
				<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-block cancel-btn" title="Cancel">Cancel</a>
				</div>
			</div>
		</div>

		
	</form>
	
</div>
	
</div>



<?php } ?>