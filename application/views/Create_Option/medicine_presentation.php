<?php
if ($msg == "main") {
	$msg = "";
} elseif ($msg == "empty") {
	$msg = "Please fill out all required fields";
} elseif ($msg == "created") {
	$msg = "Created Successfully";
} elseif ($msg == "edit") {
	$msg = "Edited Successfully";
} elseif ($msg == "delete") {
	$msg = "Deleted Successfully";
}
?>
<!-- /.Breadcrumb -->
<section id="breadcrumb">
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="#">Create Option</a></li>
			<li class="active"><?php echo $msg; ?></li>
		</ol>
	</div>
</section>

 <!-- /.container -->
	<section id="main">
		<div class="container">

			<div class="row">
				<div class="col-md-3">
					<div class="list-group">
						<a href="index.html" class="list-group-item active main-color-bg">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Create Option</a>
						<a href="<?php echo base_url(); ?>ShowForm/create_medicine_presentation/main" class="list-group-item">
							<span class="	fa fa-capsules" aria-hidden="true"></span> Medicine Presentation</a>
						<a href="<?php echo base_url(); ?>ShowForm/create_generic_name/main" class="list-group-item">
							<span class="fa fa-plus-circle" aria-hidden="true"></span> Generic Name </a>
						<a href="<?php echo base_url(); ?>ShowForm/create_medicine_name/main" class="list-group-item">
							<span class="fa fa-pills" aria-hidden="true"></span> Medicine Name</a>
<!--						<a href="--><?php //echo base_url(); ?><!--ShowForm/create_product_category/main" class="list-group-item">-->
<!--							<span class="fa fa-tasks" aria-hidden="true"></span> Product Category</a>-->
<!--						<a href="--><?php //echo base_url(); ?><!--ShowForm/create_product_name/main" class="list-group-item">-->
<!--							<span class="fa fa-plus" aria-hidden="true"></span> Product Name</a>-->
						<a href="<?php echo base_url(); ?>ShowForm/create_supplier/main" class="list-group-item">
							<span class="fa fa-truck-moving" aria-hidden="true"></span> Supplier</a>
					</div>
				</div>
					   <div class="col-md-9">
								<div class="panel panel-default">
								  <div class="panel-heading main-color-bg">
									<h3 class="panel-title">Create Medicine Presentation</h3>
								  </div>

								  <div class="panel-body">
									  <!-- /.Panel End -->
									  <div class="row">
									  <div class="col-md-3">
										  <?php echo form_open_multipart('Insert/medicine_presentation'); ?>
										  <div class="box-body">
<!--											  <p  style="font-size: 20px; color: #066;">--><?php //echo $msg; ?><!--</p>-->
											  <div class="form-group" style="width: 400px;">
												  <label for="medicine_presentation">Medicine Presentation</label>
												  <input type="text" class="form-control" id="medicine_presentation" required="required" placeholder="Enter Medicine Presentation" autocomplete="off" name="medicine_presentation">
											  </div>
										  </div>
										  <div class="box-footer">
											  <button type="submit" class="pull-left btn btn-primary">Create</button>
										  </div>
										  </form>
									  </div>
									  </div>
								  </div>
							   </div><!-- /.Panel End -->
						   <!-- /.Panel 2nd -->
						   <div class="panel panel-default">
							   <div class="panel-heading">
								   <h3 class="panel-title">Medicine Presentation List</h3>
							   </div>
							   <div class="panel-body">
								   <div class="panel-body">
									   <table class="table table-striped table-bordered table-hover">
										   <thead>
										   <tr>
											   <th style="text-align: center;">#</th>
											   <th style="text-align: center;">Medicine Presentation</th>
											   <th style="text-align: center;">Action</th>
										   </tr>
										   </thead>
										   <!-- /.Row from DB-->
										   <tbody>
										   <?php
										   $count = 0;
										   foreach ($all_value as $single_value) {
											   $count++;
											   ?>
											   <tr>
												   <td style="text-align: center;"><?php echo $count; ?></td>
												   <td style="text-align: center;"><?php echo $single_value->MedicinePresentationName; ?></td>
												   <td style="text-align: center;">
													   <a style="margin: 5px;" class="btn btn-danger"
														  href="<?php echo base_url(); ?>Delete/medicine_presentation/<?php echo $single_value->_id; ?>">Delete
													   </a>
												   </td>
											   </tr>
										   <?php } ?>
										   </tbody>
									   </table>
								   </div>
							   </div>
						   </div>
					   </div>
			</div> <!-- /.row -->
		</div> <!-- /.Container -->
</section>

