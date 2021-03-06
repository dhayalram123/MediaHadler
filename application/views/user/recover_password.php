<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
	<!-- header -->
	<header id="page-title" class="row">
		<div class="col-md-12 text-xs-center">
			<h1><span class="fa fa-picture-o"></span> 
			<?php 
			$this->load->config('site');
			echo $this->config->item('site_name'); 
			?>
			</h1>
		</div>
	</header>
	<!-- /.header -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="card card-recover">
			  <div class="card-header">Recover Password</div>
			  <form class="form-horizontal" role="form" action="<?php echo site_url('user/get_recovery_link'); ?>" method="POST" accept-charset="utf-8">
					<div class="card-block">
						<p class="alert alert-info" role="alert">Please enter the e-mail address or username associated with your user account. A link to password recovery page will be sent to your email address.</p>
    				<?php $this->load->view('messages'); ?>
    				<div class="form-group row">
					    <label for="user" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Email Address or Username">Email Address or Username</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="user" name="user" placeholder="Email Address or Username" value="<?php echo set_value('user'); ?>" autofocus>
								<?php echo form_error('user'); ?>
					    </div>
					  </div>
					</div>
					<div class="card-footer text-xs-right">
						<div class="btn-toolbar">
							<button type="submit" class="btn btn-primary">Submit</button>
							<a href="<?php echo site_url('user'); ?>" class="btn btn-secondary">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>