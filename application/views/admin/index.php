<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
    <?php 
    $this->load->config('site');
    echo $this->config->item('site_name').' - Admin'; 
    ?>
    </title>      
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/font-awesome.min.css'; ?>">     
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/admin/style.css'; ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans" type="text/css">
  </head>
  <body>
    <?php 
    $userpages = array('admin/login','admin/recover_username','admin/recover_password','admin/reset_password');    
    if(in_array($page, $userpages)) {
      $this->load->view($page);
    } else {
      $this->load->view('admin/page');
    }
    ?>
    <script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url().'assets/js/tether.min.js'; ?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'; ?>"></script>
    <script type="text/javascript">
    // show tooltip over form labels 
    $('[data-toggle="tooltip"]').tooltip(); 
    </script>   
  </body>
</html>