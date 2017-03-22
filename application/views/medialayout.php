<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="media-container">                   
	<form id="media-form" action="<?php echo site_url(CN_BASE.'index'); ?>" method="POST">		
		<!-- control bar -->
		<div class="control-bar">
			<div class="btn-toolbar" role="toolbar" area-label="toolbar of media buttons">
				<div class="btn-group" role="group" area-label="show thumb" title="Thumbs View">
					<button type="button" id="thumbs" data-layout="thumbs" class="btn btn-sm btn-secondary btn-layout"><span class="fa fa-th-large"></span></button>			    
				</div>
				<div class="btn-group" role="group" area-label="show details" title="Details View">
					<button type="button" id="details" data-layout="details" class="btn btn-sm btn-secondary btn-layout"><span class="fa fa-list"></span></button>			    
				</div>
				<div id="btn-group-select" class="btn-group hidden-xs-up" role="group" area-label="select items" title="Select Items">
					<button type="button" class="btn btn-sm btn-secondary"><span class="fa fa-check"></span> <span class="hidden-sm-down">Select Items</span></button>		    
				</div>			
			</div>
		</div>
		<!-- /.control-bar -->
		<!-- thumbs view -->    
		<div id="thumbs-layout" class="media-layout hidden-xs-up">
			<?php $this->load->view('thumbs'); ?>
		</div>
		<!-- /.thumbs view -->
		<!-- details view -->
		<div id="details-layout" class="media-layout hidden-xs-up">		
			<?php $this->load->view('details'); ?>
		</div>
		<!-- /.details view -->		
		<input id="path" name="path" type="hidden" />                        
	</form>
</div>  