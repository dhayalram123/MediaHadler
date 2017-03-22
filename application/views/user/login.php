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
	<div id="login-register" class="container">
		<?php $this->load->view('messages'); ?>
		<!-- login section -->
		<section class="login-block col-xl-4 col-lg-6 col-md-6 col-xl-offset-4 col-lg-offset-3 col-md-offset-3" style="<?php if($form == 'registration') echo 'display:none'; ?>">
			<div class="card">
			  <div class="card-header">Sign In</div>
			  <div class="card-block">
			    <form action="<?php echo site_url('user/validate_credentials'); ?>" method="POST" accept-charset="utf-8">
						<fieldset>
							<div class="row">
								<div class="center-block">
									<img class="profile-img" src="<?php echo base_url();?>assets/images/photo.jpg" alt="">
								</div>
								<div class="col-md-10 col-md-offset-1">
									<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="">
									<input type="password" class="form-control" name="password" placeholder="Password" required="">
									<div class="checkbox">
										<label>
											<input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
										</label>
									</div>
									<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign In">
								</div>
								<div class="col-md-12">
									<div class="form-bottom-links">
										Don't have an account! <a class="register-link" href="#">Sign Up Here</a><br>
										<a href="<?php echo site_url('user/recover_username'); ?>">Forgot Username?</a><br>
										<a href="<?php echo site_url('user/recover_password'); ?>">Forgot password?</a>
									</div>                                        
								</div>
								<div class="clearfix"></div>
							</div>
						</fieldset>
					</form>
			  </div>
			</div>
		</section>
		<!-- /.login section -->
		<!-- register section -->
		<section class="register-block col-md-12" style="<?php if($form == 'login') echo 'display:none'; ?>">
			<div class="row">
				<div class="col-md-7 col-sm-5 hidden-xs-down">
					<h2>Welcome to Media Manager</h2>
					<p>PHP Script to manage media files.</p>
					<h3>Features:</h3>
					<ul>
						<li>Upload image and other files with drag &amp; drop feature.</li>
						<li>Create directories to manage media.</li>
						<li>Remove files or folders.</li>
						<li>Responsive layout.</li>
						<li>Login, register and other auth facilities provided.</li>
						<li>Developed with codeigniter and bootstrap.</li>  
					</ul>
				</div>
				<div class="col-md-5 col-sm-7">
					<div class="card">
					  <div class="card-header">
					  	<div class="pull-left">Sign Up</div> 
					  	<div class="pull-right login-link"><a href="#">Sign In</a></div>
					  	<div class="clearfix"></div>
					  </div>
					  <div class="card-block">
					  	<form action="<?php echo site_url('user/register'); ?>" method="POST" accept-charset="utf-8" autocomplete="off" novalidate>
					  		<div class="row">
									<div class="form-group col-md-12">
										<label for="name">Name</label>   
										<input type="text" class="form-control form-control-sm" name="name" maxlength="255" placeholder="Full Name" value="<?php echo set_value('name'); ?>" required autofocus>
										<?php echo form_error('name'); ?>
									</div>  	                       
									<div class="form-group col-md-12"> 
										<label for="email">Email</label>  
										<input type="email" class="form-control form-control-sm" name="email" placeholder="Email Address" value="<?php echo set_value('email'); ?>" required>
										<?php echo form_error('email'); ?>
									</div> 
									<div class="form-group col-md-12">  
										<label for="username">Username</label> 
										<input type="text" class="form-control form-control-sm" name="username" maxlength="32" placeholder="Username" value="<?php echo set_value('username'); ?>" required>
										<?php echo form_error('username'); ?>
									</div> 
									<div class="form-group col-md-6">   
										<label for="password">Password</label>
										<input type="password" class="form-control form-control-sm" name="password" id="password" maxlength="32" placeholder="Password" required>		              
										<?php echo form_error('password'); ?>
									</div> 
									<div class="form-group col-md-6"> 
										<label for="confirm-password">Confirm Password</label>  
										<input type="password" class="form-control form-control-sm" name="confirm_password" maxlength="32" placeholder="Confirm Password" required>
										<?php echo form_error('confirm_password'); ?>
									</div>		            
									<div class="col-md-12" id="pwd-container">
										<div class="pwstrength_viewport_progress"></div>
									</div>
									<label for="month" class="col-md-12">Birthday</label>		            
									<div class="clearfix"></div>
									<div class="form-group col-md-4 col-sm-4 col-xs-12">
										<?php $options = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');?>
										<?php echo form_dropdown('month', $options, set_value('month'), 'class="form-control form-control-sm"'); ?>	
										<?php echo form_error('month'); ?>
									</div>
									<div class="form-group col-md-4 col-sm-4 col-xs-6">
										<input type="number" class="form-control form-control-sm" name="day" maxlength="2" min="1" max="31" placeholder="Day" value="<?php echo set_value('day'); ?>" required>
										<?php echo form_error('day'); ?>
									</div>
									<div class="form-group col-md-4 col-sm-4 col-xs-6">
										<input type="number" class="form-control form-control-sm" name="year" maxlength="4" size="4" placeholder="Year" value="<?php echo set_value('year'); ?>" required>
										<?php echo form_error('year'); ?>
									</div> 
									<div class="form-group col-md-6"> 
										<label for="gender">Gender</label>  
										<?php $options = array('male'=>'Male','female'=>'Female','other'=>'Other');?>
										<?php echo form_dropdown('gender', $options, set_value('gender'), 'class="form-control form-control-sm"'); ?>
										<?php echo form_error('gender'); ?>
									</div>
									<div class="form-group col-md-6"> 
										<label for="mobile_no">Mobile phone</label>  
										<input type="tel" class="form-control form-control-sm" name="mobile_no" maxlength="15" placeholder="Mobile no" value="<?php echo set_value('mobile_no'); ?>" required>
										<?php echo form_error('mobile_no'); ?>
									</div>
									<div class="form-group col-md-12"> 
										<label for="location">Location</label>
										<?php 
										$result = $this->db->get('countries')->result();
										$options = array();
										foreach($result as $row){
											$options[$row->id] = $row->name;
										}
										?> 	              
										<?php echo form_dropdown('location', $options, set_value('location'), 'class="form-control form-control-sm"'); ?>	              
										<?php echo form_error('location'); ?>
									</div>
									<?php
									$this->load->config('recaptcha');
									$site_key = $this->config->item('recaptcha_site_key');
									$secret_key = $this->config->item('recaptcha_secret_key');
									$lang = $this->config->item('recaptcha_lang');
									?>
									<?php if(($site_key) && ($secret_key)): ?>
										<div class="form-group col-md-12">		            	
											<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="<?php echo $site_key;?>"></div>						
											<?php echo form_error('g-recaptcha-response'); ?>
											<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>"></script>				      	
										</div>				      	
									<?php endif; ?>
									<div class="form-group col-md-12">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="accept_terms" value="1" <?php echo set_checkbox('accept_terms[]', '1'); ?>> I agree to the 
												<a href="<?php echo site_url('pages/index/terms-of-service'); ?>" target="_blank">Terms of Service</a> 
												and <a href="<?php echo site_url('pages/index/privacy-policy'); ?>" target="_blank">Privacy Policy</a>
												<?php echo form_error('accept_terms'); ?>
											</label>
										</div>
									</div>
									<div class="form-group col-md-12"> 
										<input type="submit" class="btn btn-sm btn-success btn-submit" value="Sign Up">
										<input type="reset" class="btn btn-sm btn-primary" value="Reset">          
									</div>
								</div>				
							</form>
					 	</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /.register section -->
	</div>
</div>