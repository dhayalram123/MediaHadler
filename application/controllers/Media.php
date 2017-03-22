<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Media extends CI_Controller{

		public function __constuct(){
			parent::__constuct();
			
		}
		
		public function index(){
			echo "Index Loaded";
		}
		
	}
	
?>