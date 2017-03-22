<div id="profileModal" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">User Profile</h4>
      </div>
      <form class="form-horizontal" role="form" action="<?php echo site_url('media/update_details'); ?>" method="POST">
        <div class="modal-body">
          <?php $message = $this->session->flashdata('profile.message'); ?>
          <?php if($message): ?>
            <div class="row"><div class="col-sm-12"><?php echo $message; ?></div></div>            
          <?php endif; ?>
          <!-- Name -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Name">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="name" name="name" placeholder="Full name" value="<?php echo set_value('name',isset($user['name']) ? $user['name'] : ''); ?>" autofocus>
              <?php echo form_error('name'); ?>
            </div>
          </div>
          <!-- Email Address -->
          <div class="form-group row">
            <label for="email" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Email Address">Email Address</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo set_value('email',isset($user['email']) ? $user['email'] : ''); ?>">
              <?php echo form_error('email'); ?>
            </div>
          </div> 
          <!-- Birthday -->
          <div class="form-group row">
            <label for="month" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Birthday">Birthday</label>
            <div class="col-sm-3">              
              <?php $options = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');?>
              <?php echo form_dropdown('month', $options, set_value('month',isset($user['month']) ? $user['month'] : ''), 'class="form-control"'); ?> 
              <?php echo form_error('month'); ?>
            </div>
            <br class="hidden-xs-up">
            <div class="col-sm-3">
              <input type="number" class="form-control" name="day" maxlength="2" min="1" max="31" placeholder="Day" value="<?php echo set_value('day',isset($user['day']) ? $user['day'] : ''); ?>">
              <?php echo form_error('day'); ?>
            </div>
            <br class="hidden-xs-up">
            <div class="col-sm-3">
              <input type="number" class="form-control" name="year" maxlength="4" size="4" placeholder="Year" value="<?php echo set_value('year',isset($user['year']) ? $user['year'] : ''); ?>">
              <?php echo form_error('year'); ?>
            </div>
          </div>  
          <!-- Gender -->
          <div class="form-group row">
            <label for="" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Gender">Gender</label>
            <div class="col-sm-9">
              <?php $options = array('male'=>'Male','female'=>'Female','other'=>'Other');?>
              <?php echo form_dropdown('gender', $options, set_value('gender',isset($user['gender']) ? $user['gender'] : ''), 'class="form-control"'); ?>
              <?php echo form_error('gender'); ?>
            </div>
          </div>  
          <!-- Mobile phone -->
          <div class="form-group row">
            <label for="mobile_no" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Mobile Phone">Mobile Phone</label>
            <div class="col-sm-9">
              <input type="tel" class="form-control" name="mobile_no" maxlength="15" placeholder="Mobile no" value="<?php echo set_value('mobile_no',isset($user['mobile_no']) ? $user['mobile_no'] : ''); ?>">
              <?php echo form_error('mobile_no'); ?>
            </div>
          </div> 
          <!-- Location -->
          <div class="form-group row">
            <label for="location" class="col-sm-3 form-control-label" data-toggle="tooltip" title="Location">Location</label>
            <div class="col-sm-9">
              <?php 
              $result = $this->db->get('countries')->result();
              $options = array();
              foreach($result as $row){
                  $options[$row->id] = $row->name;
              }
              ?>                
              <?php echo form_dropdown('location', $options, set_value('location',isset($user['location']) ? $user['location'] : ''), 'class="form-control"'); ?>      
              <?php echo form_error('location'); ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->