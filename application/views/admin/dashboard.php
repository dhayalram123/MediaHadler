<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<h2 class="page-header">Dashboard</h2>
	<?php $this->load->view('messages'); ?>
</div>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
	<div class="card card-inverse card-primary">
		<div class="card-block">
			<div class="card-blockquote">
				<div class="pull-xs-left">
					<span class="fa fa-user fa-5x"></span>
				</div>
				<div class="pull-xs-right text-xs-right">
					<div class="text-large"><?php echo $this->db->count_all('users'); ?></div>
					<div>Users Listed</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<a href="<?php echo site_url('admin/users'); ?>">
			<div class="card-footer text-primary">
				<div class="pull-left">View Details</div>
				<div class="pull-right"><span class="fa fa-arrow-circle-right"></span></div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
<!-- /.users -->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
	<div class="card card-inverse card-success">
		<div class="card-block">
			<div class="card-blockquote">
				<div class="pull-xs-left">
					<span class="fa fa-flag fa-5x"></span>
				</div>
				<div class="pull-xs-right text-xs-right">
					<div class="text-large"><?php echo $this->db->count_all('countries'); ?></div>
					<div>Countries Listed</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<a href="<?php echo site_url('admin/countries'); ?>">
			<div class="card-footer text-success">
				<div class="pull-left">View Details</div>
				<div class="pull-right"><span class="fa fa-arrow-circle-right"></span></div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
<!-- /.countries -->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
	<div class="card card-inverse card-warning">
		<div class="card-block">
			<div class="card-blockquote">
				<div class="pull-xs-left">
					<span class="fa fa-shopping-cart fa-5x"></span>
				</div>
				<div class="pull-xs-right text-xs-right">
					<div class="text-large"><?php echo $this->db->count_all('media'); ?></div>
					<div>Media</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<a href="<?php echo site_url('admin/media'); ?>">
			<div class="card-footer text-warning">
				<div class="pull-left">View Details</div>
				<div class="pull-right"><span class="fa fa-arrow-circle-right"></span></div>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>
<!-- /.media -->