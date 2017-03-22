<?php
/**
 * Media Manager for Codeigniter
 *
 * @package    CodeIgniter
 * @author     Prashant Pareek
 * @link       http://codecanyon.net/item/media-manager-for-codeigniter/9517058
 * @version    2.2.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Install Class
 */
class Install extends CI_Controller
{ 
  /**
   * Constructor, initializes the libraries and model
   */
  function __construct()
  {
    parent::__construct();

    // setup config base_url
    $base_url = base_url();
    $base_url = str_replace('127.0.0.1', 'localhost', $base_url);
    
    $file_path = './application/config/config.php';
    $data = file_get_contents($file_path);    
    $data = str_replace('$config[\'base_url\'] = \'\';', '$config[\'base_url\'] = \''.$base_url.'\';', $data);
    write_file($file_path, $data);

    $this->load->config('config');

    $this->load->library('form_validation');
    
    /*cash control*/
    $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  }
  
  /**
   * Default method, loads first page of installer
   */
  public function index()
  {   
    $data['page'] = 'install/step-0';
    $this->load->view('install/index',$data);
  }

  /**
   * Method to load install pages
   *
   * @param  int  $step  no. of installer page
   * @param  string  $type  bootstrap color themes
   */ 
  public function step($step, $type = 'primary')
  {
    $data = array();

    switch($step)
    {
      case '1': $data['page'] = 'install/step-1';
                $data['type'] = $type;
                break;
      case '2': $data['page'] = 'install/step-2';
                $data['type'] = $type;
                break;
      default : break;      
    }

    $this->load->view('install/index',$data);
  }

  /**
   * Method to setup database and other settings
   */
  public function setup_database()
  {
    // set bootstrap error delimiter for registration form
    $this->form_validation->set_error_delimiters('<div class="has-danger"><small class="text-help">', '</small></div>');

    $this->form_validation->set_rules('hostname', 'Host Name', 'trim|required|strip_tags');
    $this->form_validation->set_rules('username', 'User Name', 'trim|required|strip_tags');   
    $this->form_validation->set_rules('database', 'Database Name', 'trim|required|strip_tags');

    // if form validation fails load 1st page of installer
    if($this->form_validation->run() == FALSE)
    {           
      $this->step(1,'danger');
      return false;     
    }

    // db settings details
    $hostname = $this->input->post('hostname');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $database = $this->input->post('database');

    // check db connection
    $con = @mysql_connect($hostname, $username, $password);

    if (!$con) {
      @mysql_close($con);     
      $this->base->set_message('Could not make database connection, check your database details.','danger');
      $this->step(1,'danger');
      return false;
    }       

    // try to create database
    $result = @mysql_query('CREATE DATABASE IF NOT EXISTS '.$database);
    
    if(!$result) {            
      $this->base->set_message('Could not create database, please try again.','danger');
      $this->step(1,'danger');
      return false;
    }

    // update database.php file
    $file_path = './application/config/database.php';
    $data = file_get_contents($file_path);
    $data = str_replace('<hostname>', $hostname, $data);
    $data = str_replace('<username>', $username, $data);
    $data = str_replace('<password>', $password, $data);
    $data = str_replace('<db_name>', $database, $data);
    write_file($file_path, $data);

    // update routes.php file
    $file_path = './application/config/routes.php';
    $data = file_get_contents($file_path);
    $data = str_replace('install', 'user', $data);    
    write_file($file_path, $data);

    // update autoload.php file
    $file_path = './application/config/autoload.php';
    $data = file_get_contents($file_path);
    $data = str_replace("'base'", "'auth','base','database','session','database'", $data);    
    write_file($file_path, $data);

    // install database
    $sql = file_get_contents('./install/mediamanager.sql');
    $sql = rtrim(trim($sql), "\n;");
    $queries = explode(';', $sql);

    $this->load->database();
    
    // run queries
    foreach ($queries as $query) {
      $this->db->query($query);
    }
      
    redirect(site_url().'install/step/2', 'refresh');
    return true;
  }

  /**
   * Method to save extra settings of script
   */
  public function save_settings()
  {
    // set bootstrap error delimiter for registration form
    $this->form_validation->set_error_delimiters('<div class="has-danger"><small class="text-help">', '</small></div>');

    $this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|strip_tags');
    $this->form_validation->set_rules('email', 'Admin Email', 'trim|required|strip_tags|valid_email');    
    $this->form_validation->set_rules('username', 'Admin Username', 'trim|required|strip_tags|callback_check_username|min_length[8]|max_length[32]');
    $this->form_validation->set_rules('password', 'Admin Password', 'trim|required|strip_tags|min_length[8]|max_length[32]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|strip_tags|matches[password]');    

    // if form validation fails load IInd page of installer 
    if($this->form_validation->run() == FALSE)
    {           
      $this->step(2,'danger');
      return false;     
    }

    // update site.php file
    $file_path = './application/config/site.php';
    $admin_email = $this->input->post('email');
    $data = file_get_contents($file_path);    
    $data = str_replace('<site_name>', $this->input->post('site_name'), $data);
    $data = str_replace('<admin_email>', $admin_email, $data);    
    write_file($file_path, $data);
    
    // encrypt password
    $password = $this->base->encrypt_password($this->input->post('password'));

    // set data to store
    $data = array(
      'name' => 'admin',
      'username' => trim($this->input->post('username')),
      'password' => $password,
      'email' => trim($admin_email),  
      'birth_date' => '',     
      'gender' => '',
      'mobile_no' => '',
      'location' => '', 
      'usertype' => 1, // 1: admin, 0: normal user
      'register_date' => date('Y-m-d H:m:s'),
      'activation' => 1
    );

    // store data into database
    $this->load->database();
    $insert = $this->db->insert('users', $data);

    // update recaptcha.php file
    $file_path = './application/config/recaptcha.php';
    $data = file_get_contents($file_path);    
    $data = str_replace('<site_key>', $this->input->post('recaptcha_site_key'), $data);
    $data = str_replace('<secret_key>', $this->input->post('recaptcha_secret_key'), $data);   
    write_file($file_path, $data);

    // delete installer script
    unlink('./application/controllers/Install.php');

    // delete other helper files
    $this->load->helper('file');
    delete_files('././install',TRUE);
    rmdir('././install');
    delete_files('./application/views/install',TRUE);
    rmdir('./application/views/install');
    
    // set success notification message   
    $this->base->set_message('Congrats, you have successfully installed Media Manager script.','success');
    redirect(site_url().'user','refresh');
    return true;
  }   

  /**
   * Validate username 
   *
   * @param  string  $username  username supplied by user
   * @return  boolean  TRUE if username validated, FALSE either
   */
  public function check_username($username)
  {
    // check if username started with alphabet
    if(!preg_match('/^[A-Za-z]+/', $username))
    {
      $this->form_validation->set_message('check_username', '%s should start with alphabet');
      return false;
    }
    // check if username contains valid characters
    elseif(!preg_match('/^[A-Za-z0-9_.-]+$/', $username))
    {     
      $this->form_validation->set_message('check_username', 'Only alphanumeric characters, underscores (_), dashes(-) and periods(.) are allowed');
      return false;
    }

    return true;  
  }
}