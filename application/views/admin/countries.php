<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
  <h2 class="page-header">Countries</h2>
  <?php $this->load->view('messages'); ?>
  <div class="btn-toolbar">
    <a href="<?php echo site_url('/admin/countries/edit_details'); ?>" class="btn btn-sm btn-success"><span class="fa fa-plus-circle"></span> Add Country</a>
  </div>
  <div class="card">
    <div class="card-header">Countries list</div>
    <div class="card-block">
      <form action="<?php echo site_url('admin/countries/get_results'); ?>" method="POST" class="form-inline">
        <div class="row">
          <div class="col-md-6">
            <?php $options = array('10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'); ?>
            Show <?php echo form_dropdown('limit', $options, $this->session->userdata('countries.filter.limit'), 'onchange="this.form.submit();" class="form-control form-control-sm"'); ?> entries
          </div>
          <div class="col-md-6 text-xs-right">
            Search: <input type="text" name="search" class="form-control form-control-sm" placeholder="Search" value="<?php echo $this->session->userdata('countries.filter.search'); ?>">
          </div>
          <?php if(empty($countries)): ?>
            <div class="alert alert-warning">No result found</div>
          <?php else: ?>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover">
                  <thead class="thead-default">
                    <tr>
                      <th>ID</th>
                      <th>Name</th>                      
                    </tr>
                  </thead>
                  <tbody>                    
                    <?php foreach($countries as $country): ?>
                      <tr>
                        <td><?php echo $country->id; ?></td>
                        <td><a href="<?php echo site_url('/admin/countries/edit_details/'.$country->id); ?>"><?php echo $country->name; ?></a></td>
                      </tr>
                    <?php endforeach; ?>                                                          
                  </tbody>
                </table> 
              </div>
            </div>
            <div class="col-sm-6"><?php echo $enteries; ?></div>
            <div class="col-sm-6 text-xs-right"><?php echo $pagination; ?></div>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>