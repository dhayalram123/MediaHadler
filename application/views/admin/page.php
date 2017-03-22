<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid admin">
  <nav class="navbar navbar-light navbar-full navbar-fixed-top navbar-top bg-faded">
    <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#side-nav">&#9776;</button>
    <?php 
    $this->load->config('site');
    $site_title = $this->config->item('site_name').' - Admin'; 
    ?>
    <a class="navbar-brand" href="<?php echo site_url('admin/dashboard'); ?>"><?php echo $site_title; ?></a>
    <div class="dropdown pull-xs-right">
      <div id="nav-dropdown-menu" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user fa-fw"></span></div>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-dropdown-menu">
        <a class="dropdown-item" href="<?php echo site_url('/admin/users/edit_details/'.$this->session->userdata('admin_user_id')); ?>"><span class="fa fa-user fa-fw"></span> User Profile</a>
        <a class="dropdown-item" href="<?php echo site_url('admin/dashboard/logout'); ?>"><span class="fa fa-sign-out fa-fw"></span> Logout</a>
      </div>
    </div>
  </nav>
  <div class="row">
    <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 sidebar">
      <div class="row">
        <div class="collapse navbar-toggleable-sm" id="side-nav">
          <nav>
            <ul class="nav">
              <li class="nav-item"><a href="<?php echo site_url().'admin/dashboard'; ?>"><span class="fa fa-dashboard fa-fw"></span> Dashboard</a></li>
              <li class="nav-item"><a href="<?php echo site_url().'admin/users'; ?>"><span class="fa fa-user fa-fw"></span> Users</a></li>
              <li class="nav-item"><a href="<?php echo site_url().'admin/countries'; ?>"><span class="fa fa-flag fa-fw"></span> Countries</a></li>
              <li class="nav-item"><a href="<?php echo site_url().'admin/media'; ?>"><span class="fa fa-flag fa-fw"></span> Media</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 main">
      <?php $this->load->view($page); ?>
    </div>
  </div>
</div>