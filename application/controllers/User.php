<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	
	class User extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			
			$this->load->model('User_model');
		}
		
		public function index(){
			if($this->auth->loggedin()){
				redirect('media/index/','refresh');
			}else{
				$indexData['page'] = 'user/login';
				$indexData['form'] = 'login';
				
				$this->load->view('index', $indexData);
			}
		}
	}
?>
