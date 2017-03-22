<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="media-manager" class="container-fluid">
  <!-- navbar -->
  <div id="page-nav" class="row">
    <div class="navbar navbar-full navbar-dark" role="navigation">
      <a class="navbar-brand" href="<?php echo site_url(); ?>"><span class="fa fa-picture-o"></span>
      <?php 
      $this->load->config('site');
      echo $this->config->item('site_name'); 
      ?>    
      </a>
      <div class="dropdown pull-xs-right">
        <div id="nav-dropdown-menu" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user fa-fw"></span></div>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-dropdown-menu">
          <a class="dropdown-item up-prfl" href="#"><span class="fa fa-user fa-fw"></span> User Profile</a>
          <a class="dropdown-item ch-pass" href="#"><span class="fa fa-lock fa-fw"></span> Change Password</a>
          <a class="dropdown-item" href="<?php echo site_url('user/logout'); ?>"><span class="fa fa-sign-out fa-fw"></span> Logout</a>
        </div>
      </div>
    </div>
  </div>
  <!-- /.navbar -->
  <!-- toolbar container -->
  <div id="controls" class="row">
    <div class="col-md-12">
      <div class="btn-toolbar" role="toolbar" area-label="toolbar of control buttons" title="Toggle Folder Lists">
        <div class="btn-group hidden-md-up" role="group" area-label="show off-canvas folders list">
          <button type="button" class="btn btn-secondary btn btn-sm btn-off-canvas"><span class="fa fa-list"></span></button>
        </div>
        <div class="btn-group" role="group" area-label="upload media" title="Upload">
          <button type="button" data-toggle="collapse" data-target="#collapse-upload" class="btn btn-success btn-sm"><span class="fa fa-upload"></span> <span class="hidden-sm-down"> Upload</span></button>
        </div>
        <div class="btn-group" role="group" area-label="create new folder" title="Create New Folder">
          <button type="button" data-toggle="collapse" data-target="#collapse-folder" class="btn btn-secondary btn-sm"><span class="fa fa-folder-open-o"></span> <span class="hidden-sm-down"> Create New Folder</span></button>          
        </div>
        <div class="btn-group" role="group" area-label="trash media or folder" title="Rename">
          <button type="button" class="btn btn-secondary btn-sm btn-tb-rename"><span class="fa fa-pencil"></span> <span class="hidden-sm-down"> Rename</span></button>          
        </div>
        <div class="btn-group" role="group" area-label="trash media or folder" title="Delete">
          <button type="button" class="btn btn-secondary btn-sm btn-tb-delete"><span class="fa fa-times"></span> <span class="hidden-sm-down"> Delete</span></button>         
        </div>        
      </div>
    </div>
  </div>  
  <!-- /.toolbar container -->  
  <!-- main container -->
  <div class="row">
    <!-- notifications -->
    <div class="col-md-12">
      <?php $this->load->view('messages'); ?>
    </div>
    <!-- /.notifications -->
  </div>
  <div class="row wrapper">
    <!-- folder tree structure -->
    <div class="col-xl-2 col-lg-2 col-md-3 off-canvas">   
      <?php $this->load->view('foldertree'); ?>
    </div>
    <!-- /.folder tree structure -->
    <!-- media container -->
    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-xs-12 main-section">   
      <?php $this->load->view('mediaform'); ?>
      <?php $this->load->view('medialayout'); ?>
    </div>
    <!-- /.media container -->
  </div>
  <!-- /.main-container -->
</div>
<?php $this->load->view('user/profile'); ?>
<?php $this->load->view('user/change-password'); ?>
<script>var site_url = '<?php echo site_url(CN_BASE).'/'; ?>';</script>
<script>var max_size = '<?php echo $this->config->item('max_size'); ?>';</script>
<script>var max_files = '<?php echo $this->config->item('max_files'); ?>';</script>