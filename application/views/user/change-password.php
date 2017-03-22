<div id="changePwdModal" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <form class="form-horizontal" role="form" action="<?php echo site_url('media/change_password'); ?>" method="POST">
        <div class="modal-body">
          <?php $message = $this->session->flashdata('cpassword.message'); ?>
          <?php if($message): ?>
            <div class="row"><div class="col-sm-12"><?php echo $message; ?></div></div>
          <?php endif; ?>
          <!-- Old password -->
          <div class="form-group row">
            <label for="name" class="col-sm-4 form-control-label" data-toggle="tooltip" title="Old Password">Old Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password" value="" autofocus>
              <?php echo form_error('old_password'); ?>
            </div>
          </div> 
          <!-- New password -->
          <div class="form-group row">
            <label for="name" class="col-sm-4 form-control-label" data-toggle="tooltip" title="New Password">New Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" value="">
              <?php echo form_error('new_password'); ?>
            </div>
          </div> 
          <!-- Confirm password -->
          <div class="form-group row">
            <label for="name" class="col-sm-4 form-control-label" data-toggle="tooltip" title="Confirm New Password">Confirm Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="Confirm Password" value="">
              <?php echo form_error('conf_password'); ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->