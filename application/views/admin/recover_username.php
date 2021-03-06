<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
	<!-- header -->
	<header id="page-title" class="row">
		<div class="col-md-12 text-xs-center">
			<h1><span class="fa fa-picture-o"></span> 
			<?php 
			$this->load->config('site');
			echo $this->config->item('site_name').' - Admin'; 
			?>
			</h1>
		</div>
	</header>
	<!-- /.header -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="card card-recover">
			  <div class="card-header">Recover Username</div>
			  <form class="form-horizontal" role="form" action="<?php echo site_url('admin/dashboard/send_username'); ?>" method="POST" accept-charset="utf-8">
					<div class="card-block">
						<p class="alert alert-info" role="alert">Please enter the e-mail address associated with your user account. Your username will be sent to your e-mail address.</p>
    				<?php $this->load->view('messages'); ?>
    				<div class="form-group row">
					    <label for="email" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Email Address">Email Address</label>
					    <div class="col-sm-9">
					      <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo set_value('email'); ?>" autofocus>
								<?php echo form_error('email'); ?>
					    </div>
					  </div>
					</div>
					<div class="card-footer text-xs-right">
						<div class="btn-toolbar">
							<button type="submit" class="btn btn-primary">Submit</button>
							<a href="<?php echo site_url('admin'); ?>" class="btn btn-secondary">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>