<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
  <h2 class="page-header"><?php echo isset($item['id']) ? 'Edit Country Details' : 'Add Country'; ?></h2>
  <?php $this->load->view('messages'); ?>  
  <div class="card">
    <div class="card-header">Country form</div>
    <div class="card-block">
      <form action="<?php echo site_url('admin/countries/save_details'); ?>" method="POST">
        <div class="col-md-6">
          <fieldset class="form-group">
            <label for="name">Name</label>   
            <input type="text" class="form-control form-control-sm" name="name" maxlength="255" placeholder="Name" value="<?php echo set_value('name',isset($item['name']) ? $item['name'] : ''); ?>" autofocus>
            <?php echo form_error('name'); ?>
          </fieldset>          
          <input type="hidden" name="id" value="<?php echo set_value('id',isset($item['id']) ? $item['id'] : ''); ?>" />                                   
          <fieldset class="form-group">
            <input type="submit" class="btn btn-sm btn-success" value="Save">
            <a class="btn btn-sm btn-warning" href="<?php echo site_url().'admin/countries'; ?>">Close</a>
          </fieldset>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div>