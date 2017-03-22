<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>    
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Media Manager</title>      
		<link rel="stylesheet" href="<?php echo asset_url().'css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo asset_url().'css/font-awesome.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo asset_url().'css/magnific-popup.css'; ?>">
		<link rel="stylesheet" href="<?php echo asset_url().'css/media.css'; ?>">
		<link rel="stylesheet" href="<?php echo asset_url().'css/mediaelementplayer.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo asset_url().'css/mejs-skins.min.css'; ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans" type="text/css">
	</head>
	<body>
		<?php $this->load->view($page); ?>
		<script src="<?php echo asset_url().'js/jquery.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/tether.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/bootstrap.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/dropzone.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/js.cookie.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/bootbox.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/masonry.pkgd.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/jquery.magnific-popup.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/pwstrength-bootstrap.min.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/media.js'; ?>"></script>    
		<script src="<?php echo asset_url().'js/client.js'; ?>"></script>
		<script src="<?php echo asset_url().'js/mediaelement-and-player.min.js'; ?>"></script>
		<script type="text/javascript">
    <?php
    if($this->session->flashdata('profile.status'))
    {
      ?>$(window).load(function(){$('#profileModal').modal('show')});<?php
      $this->session->unset_userdata('profile.status');
    }

    if($this->session->flashdata('cpassword.status'))
    {
      ?>$(window).load(function(){$('#changePwdModal').modal('show')});<?php
      $this->session->unset_userdata('cpassword.status');
    }
    ?>     
    </script>
	</body>
</html>