<?php
/**
 * Media Manager for Codeigniter
 *
 * @package    CodeIgniter
 * @author     Prashant Pareek
 * @link       http://codecanyon.net/item/media-manager-for-codeigniter/9517058
 * @version    2.3.1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media class
 */
class Media extends CI_Controller {

	public $table = 'media';

	/**
	 * Constructor, initializes media model     
	 */
	public function __construct()
	{	 
		parent::__construct();

		// redirect user to login page if not logged-in
		if (!$this->auth->loggedin()) 
		{        	
      redirect('user','refresh');
    }

		// create constant for media controller relative path
		$cn_dir = realpath(FCPATH.'application/controllers');
		$fl_dir = realpath(dirname(__FILE__));
		$path = str_replace($cn_dir,'',$fl_dir);	
		$cn_base = $path.'/media/';		
		define('CN_BASE',$cn_base);

		// app parameters
		$this->load->config('app');
		$media_path = $this->config->item('media_path');
		
		// create constant for user media base directory
		$user_id = $this->session->userdata('auth_user');
		$mm_base = FCPATH.$media_path.'/'.$user_id;
		$mm_base = str_replace(DIRECTORY_SEPARATOR, '/', $mm_base.'/');			
		define('MM_BASE', $mm_base);	

		// create folder to save user media
		if (!is_dir($mm_base)) {
	    if(!mkdir($mm_base, 0777, TRUE)){
	    	exit('Could not create user media directory.');									
	    }
		}	

		// load model
		$this->load->model('media_model');
		$this->load->model('user_model');
	}

	/**
	 * Get media manager settings, load folder structure 
	 * media list of path selected and display the page
	 */
	public function index()
	{
		// get media folder path from POST
		$path = $this->input->post('path');

		if (!$path)
		{
			// if not set then get from session
			$path = $this->session->userdata('path');
		}
		else
		{
			if ($path == 'home')
			{
				$path = null;
				$this->session->unset_userdata('path');
			}
			else
			{
				// switch to specified media folder				
				$this->session->set_userdata('path',$path);
			}
		}

		// get folder tree structure
		$data['foldertree'] = $this->media_model->get_folder_tree();

		// get folders list
		$data['folders'] = $this->media_model->get_folders_list($path);

		// get media files
		$data['media'] = $this->media_model->get_media_list($path);

		// load view
		$data['page'] = 'manager';	

		// get logged-in user details
		$data['user'] = $this->user_model->get_item($this->session->userdata('auth_user'));

		// set notifications if file(s) uploaded previously
		$this->set_upload_notifications();

		$this->load->view('index', $data);
	}

	/**
	 * Method to upload media files
	 */
	public function do_upload()
	{	
		// check if files received				
		if (isset($_FILES['filedata']) && !empty($_FILES['filedata']['tmp_name'])) 
		{    
			// upload files														
			$this->media_model->upload_files($_FILES['filedata']);			
		}
		else
		{
			$this->base->set_message('No files found to upload.', 'error');
		}		

		redirect(CN_BASE.'index', 'refresh');		
	}

	/**
	 * Method to set upload notifications
	 */
	public function set_upload_notifications()
	{
		$count = (int) $this->session->userdata('upload_count');
		$errors = (array) $this->session->userdata('upload_errors');
		
		if ($count) 
		{
			$no_files = ($count > 1) ? 'files' : 'file';
			$message = $count.' '.$no_files.' uploaded successfully';
			$this->base->set_message($message, 'success');
		}

		if ($errors) 
		{
			$message = implode('<br>', $errors);
			$this->base->set_message($message, 'error');
		}

		// Clear session for uploaded file count on every redirect
		$this->session->unset_userdata('upload_count');
		$this->session->unset_userdata('upload_errors');
	}

	/**
	 * Method to create folder in specified media directory
	 */
	public function create_folder()
	{
		// media base path
		$basepath = MM_BASE;

		// get media path
		if ($this->session->userdata('path'))
		{
			$basepath .= '/'.$this->session->userdata('path').'/'; 
		}

		// get folder name
		$foldername = trim(strip_tags($this->input->post('foldername')));

		// sanitize folder name for . .. ... strings
		$foldername = str_replace('\\', '/', $foldername);
		$tmp = explode('/',$foldername);			
		$tmp = array_filter($tmp);
		$tmp = array_diff($tmp, array('.','..','...'));
		$foldername = implode('/',$tmp);

		if ($foldername)
		{
			if ($foldername != 'thumb')
			{ 
				$dir = $basepath.'/'.$foldername;

				// create folder
				if (!is_dir($dir))
				{ 
					if (mkdir($dir, 0777, TRUE))
					{
						$message = 'Folder with name <strong>'.$foldername.'</strong> created successfully';
						$type = 'success';									
					}
					else
					{ 
						$message = 'Could not create folder.';
						$type = 'error';
					}
				}
				else 
				{ 
					$message = 'Folder already exists.';
					$type = 'error';
				}
			}
		}
		else
		{ 
			$message = 'Choose appropriate name for folder.';
			$type = 'warning';
		}

		$this->base->set_message($message, $type);

		redirect(CN_BASE.'index', 'refresh');
	}

	/**
	 * Method to rename file or folder of specified directory
	 */
	public function rename_media()
	{	
		// logged-in user's ID
		$user_id = $this->session->userdata('auth_user');

		// name
		$path = $this->input->post('path');
		$edited_name = $this->input->post('edited_name');
		
		$msg = $type = '';

		if ($path && $edited_name)
		{
			$realpath = realpath(MM_BASE.'/'.$path);
			
			// If absolute path exists
			if ($realpath)
			{
				if (is_file($realpath)) // if file
				{
					// get file name and path	
					$tmp = explode('/',$path);
					$name = end($tmp);
					$mediapath = str_replace($name,'',$path);					

					// get new file name
					$tmp = explode('.',$name);				
					$ext = end($tmp);			
					$newname = $edited_name.'.'.$ext;

					// new file path
					$newpath = MM_BASE.$mediapath.$newname;				

					// thumb path in case file is image	
					$old_thumb_path = MM_BASE.$mediapath.'thumb/'.$name;
					$new_thumb_path = MM_BASE.$mediapath.'thumb/'.$newname;
					
					if (!file_exists($newpath))
					{
						$update = array('raw_name' => $edited_name, 'file_name' => $newname);

						// rename file from database
						$result = $this->db->where('user_id',$user_id)
															 ->where('file_path','/'.$mediapath)
															 ->where('file_name',$name)
															 ->update($this->table, $update);
						
						// rename file from database
						$return = rename($realpath, $newpath);

						if ($result && $return)
						{
							if (file_exists($old_thumb_path)) 
							{
								rename($old_thumb_path, $new_thumb_path);
							}

							$msg = 'Media file renamed successfully';
							$type = 'success';
						} 
						else 
						{
							$msg = 'Unable to rename media file';
							$type = 'danger';
						}											
					} 
					else 
					{						
						$msg = 'Media file already exists';
						$type = 'danger';
					}												
				} 
				elseif (is_dir($realpath)) // if folder
				{	
					// get file name and path	
					$tmp = explode('/',$path);
					array_pop($tmp);
					$tmp[] = $edited_name;
					$mediapath = implode('/',$tmp);
					$newpath = MM_BASE.'/'.$mediapath;					

					if (!file_exists($newpath))
					{
						// rename folder from database							
						$n = strlen($path);						
						$query = "UPDATE ".$this->table." SET file_path = CONCAT(REPLACE(LEFT(file_path,INSTR(file_path,'/".$path."/') + ".($n+1)."),
								 '/".$path."/','/".$mediapath."/'),SUBSTRING(file_path,INSTR(file_path,'/".$path."/') + ".($n+2).")) 
								 WHERE file_path LIKE '/".$path."/%' AND user_id = ".$user_id."";						

						$result = $this->db->query($query);

						// rename folder												
						$return = rename($realpath, $newpath);	

						if ($result && $return)
						{
							$msg = 'Media folder renamed successfully';
							$type = 'success';
						} 
						else 
						{
							$msg = 'Unable to rename media folder';
							$type = 'danger';
						}
					} 
					else 
					{
						$msg = 'Folder already exists';
						$type = 'danger';
					}
				}
			} 
			else 
			{
				$msg = 'Invalid media path';
				$type = 'danger';
			}
		} 
		else 
		{
			$msg = 'Invalid path or invalid new name';
			$type = 'warning';
		}

		$this->base->set_message($msg, $type);
	}

	/**
	 * Method to delete media of folders from specified directory
	 */
	public function remove_media()
	{	
		// logged-in user's ID
		$user_id = $this->session->userdata('auth_user');

		$rm_media = $this->input->post('rm');
		
		foreach ($rm_media as $rm)
		{
			// Sanitize file or folder name
			$rm = str_replace('\\', '/', $rm);
			$tmp = explode('/',$rm);			
			$tmp = array_filter($tmp);
			$tmp = array_diff($tmp, array('.','..'));
			$rm = implode('/',$tmp);						

			// If name exists
			if ($rm)
			{				
				$path = realpath(MM_BASE.'/'.$rm);

				// If absolute path exists
				if ($path)
				{
					if (is_file($path)) // if file
					{
						// get file name and path	
						$tmp = explode('/',$rm);
						$file = end($tmp);
						$file_path = str_replace($file,'',$rm);
						$file_path = '/'.$file_path;

						// remove file from database
						$this->db->where('user_id',$user_id);
						$this->db->where('file_path',$file_path);
						$this->db->where('file_name',$file);
						$this->db->delete($this->table);

						if (unlink($path))
						{
							// path to thumb folder file
							$n = count($tmp) - 1;
							$last_el = $tmp[$n];
							$rm_thumb = str_replace($last_el, 'thumb/'.$last_el, $rm);
							$path = MM_BASE.'/'.$rm_thumb;
							unlink($path);

							$msg = 'Media file(s) deleted successfully.';
							$type = 'success';
						}
						else
						{
							$msg = 'Could not delete media file(s).';
							$type = 'danger';
						}	
					} 
					elseif (is_dir($path)) // if folder
					{ 
						// remove folder media from database			
						$file_path = '/'.$rm.'/';

						$this->db->where('user_id',$user_id);
						$this->db->like('file_path',$file_path,'after');
						$this->db->delete($this->table);

						delete_files($path, TRUE, TRUE);

						if(rmdir($path)) {
							$msg = 'Media folder(s) and its content deleted successfully.';
							$type = 'success';
						}
						else 
						{
							$msg = 'Could not delete media folder(s).';
							$type = 'danger';
						}
					}
				}
				else
				{
					$msg = 'Media does not exists';
					$type = 'danger';
				}	
			}
			else
			{
				$msg = 'Invalid media file or folder name supplied.';
				$type = 'danger';
			}													
		}

		$this->base->set_message($msg, $type);
	}

	/**
	 * Save user settings
	 */
	public function save_params()
	{		
		$params = $this->input->post();	
		$path = realpath(APPPATH.'config/app.php');
		$default_path = realpath(APPPATH.'config/default-app.php');

		// restore default settings
		if(isset($params['restore'])) 
		{								
			$content = file_get_contents($default_path);
			
			if($handle = fopen($path, 'w')) 
			{
				if(fwrite($handle, $content)) 
				{
					$message = 'Default settings restored successfully.';
					$type = 'success';
				} 
				else 
				{
					$message = 'Could not save default settings.';
					$type = 'error';
				}

				fclose($handle);
			} 
			else 
			{
				$message = 'Error encountered while saving default settings.';
				$type = 'warning';
			}
		} 
		else 
		{
			// remove extra slashes from media path
			$media_path = explode('/',$params['media_path']);			
			$media_path = array_filter($media_path);			
			$media_path = array_diff($media_path, array('.','..'));			
			$media_path = implode('/',$media_path);

			$dir = realpath(FCPATH).DIRECTORY_SEPARATOR.$media_path;			
			
			// Check if path exists
			if(!is_dir($dir)) 
			{
				mkdir($dir, 0777, TRUE);
			}

			$params['media_path'] = $media_path;
			
			// Check if other fields left empty			
			$fields = array('allowed_types','max_size','max_width','max_height','media_path','max_filename','max_files');
				
			$this->load->config('default-app');			

			// Set default value
			foreach($fields as $key)
			{				
				if(!$params[$key])
				{
					$params[$key] = $this->config->item($key);
				}					
			}
			
			$params['overwrite'] = isset($params['overwrite']) ? 1 : 0;
			$params['remove_spaces'] = isset($params['remove_spaces']) ? 1 : 0;
			$params['encrypt_name'] = isset($params['encrypt_name']) ? 1 : 0;
			
			$content = file_get_contents($path);
			
			// edit config key values
			$content = $this->editConfigContent($params, $content, 'allowed_types', TRUE);
			$content = $this->editConfigContent($params, $content, 'max_size');			
			$content = $this->editConfigContent($params, $content, 'max_width');
			$content = $this->editConfigContent($params, $content, 'max_height');
			$content = $this->editConfigContent($params, $content, 'media_path', TRUE);
			$content = $this->editConfigContent($params, $content, 'max_filename');
			$content = $this->editConfigContent($params, $content, 'max_files');
			$content = $this->editConfigContent($params, $content, 'overwrite');
			$content = $this->editConfigContent($params, $content, 'remove_spaces');
			$content = $this->editConfigContent($params, $content, 'encrypt_name');		

			if($handle = fopen($path, 'w')) 
			{
				if(fwrite($handle, $content)) 
				{
					$message = 'Media manager settings saved successfully.';
					$type = 'success';
				} 
				else 
				{
					$message = 'Could not save media manager settings.';
					$type = 'error';
				}

				fclose($handle);
			} 
			else 
			{
				$message = 'Error encountered while saving media manager settings.';
				$type = 'warning';
			}
		}

		$this->base->set_message($message, $type);

		redirect(CN_BASE.'index', 'refresh');
	}

	/**
	 * Method to edit configuration settings with keys and values
	 *
	 * $params  array    script parameters 
	 * $content string   script config file content
	 * $key     string   parameter key to set
	 * $str 		boolean  TRUE if config value a string, FALSE if numeric
	 */
	public function editConfigContent($params, $content, $key, $str = FALSE)
	{
		$pattern = '/\n\$config\[\'OPTION\'\] = .*/';	
		$replace = "\n".'$config[\'OPTION\'] = ';

		$p = str_replace('OPTION', $key, $pattern);
		$r = str_replace('OPTION', $key, $replace);

		if ($str) 
		{
			$r .= "'".$params[$key]."';";
		} 
		else 
		{
			$r .= $params[$key].';';
		}			

		return preg_replace($p, $r, $content);		
	}	

	/**
	 * Method to update user profile details
	 */
	public function update_details()
	{
		$this->load->library('form_validation');

		// set bootstrap error delimiter for registration form
		$this->form_validation->set_error_delimiters('<div class="has-danger"><small class="text-help">', '</small></div>');		

		// set validation rules for signup form fields
		$this->form_validation->set_rules('name', 'Name', 'trim|required|strip_tags|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|strip_tags|valid_email|callback_is_unique_email');			
		$this->form_validation->set_rules('month', 'Month', 'trim|strip_tags');
		$this->form_validation->set_rules('day', 'Day', 'trim|strip_tags');
		$this->form_validation->set_rules('year', 'Year', 'trim|strip_tags');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|strip_tags');
		$this->form_validation->set_rules('mobile_no', 'Mobile no', 'trim|strip_tags');
		$this->form_validation->set_rules('location', 'Location', 'trim|strip_tags');

		$this->session->set_flashdata('profile.status',1);

		// if form validation fails
		if($this->form_validation->run() == FALSE)
		{								
			$this->index();
			return false;			
		}

		// update user details
		$user_id = $this->session->userdata('auth_user');		
		$result = $this->user_model->update_details($user_id);

		switch($result)
		{
			case 0: // could not update user details
							$msg = 'Could not update user details.';
							$type = 'danger';
							break;

			case 1: // user details updated
							$msg = 'User details updated successfully.';
							$type = 'success';
							break;

			default: break;
		}
		
		// set user profile notification
		$message = $this->base->set_message($msg,$type);

		$this->session->set_flashdata('profile.message',$message);

		redirect(CN_BASE.'index', 'refresh');	
	}

	/** 
	 * Method to check if email is already in use
	 * by other users
	 *
	 * @param  string  $email  email address to check
	 */
	public function is_unique_email($email)
	{		
		// get logged-in user id
		$user_id = $this->session->userdata('auth_user');

		// fire query
		$this->db->where('id != ',$user_id);
		$this->db->where('email',$email);
    $query = $this->db->get('users');

    if($query->num_rows() > 0) 
    {
    	$this->form_validation->set_message('is_unique_email', '%s is already in use.');
      return false;
    }

    return true;	        
	}

	/**
	 * Method to change password if supplied
	 * old password matches
	 */
	public function change_password()
	{
		$this->load->library('form_validation');

		// set bootstrap error delimiter for registration form
		$this->form_validation->set_error_delimiters('<div class="has-danger"><small class="text-help">', '</small></div>');		

		// set validation rules
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|strip_tags|min_length[8]|max_length[32]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|strip_tags|min_length[8]|max_length[32]');
		$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'trim|required|strip_tags|matches[new_password]');

		$this->session->set_flashdata('cpassword.status',1);

		// if form validation fails	
		if($this->form_validation->run() == FALSE)
		{								
			$this->index();
			return false;			
		}

		// update user details
		$user_id = $this->session->userdata('auth_user');		
		$result = (int) $this->user_model->update_password($user_id);
		
		switch($result)
		{
			case -1: // invalid password
							 $msg = 'Invalid old password supplied';
							 $type = 'danger';
							 break;

			case 1:  // user details updated
							 $msg = 'User password updated successfully.';
							 $type = 'success';
							 break;

			case 0:  // could not update user details
			default: $msg = 'Could not update user password.';
							 $type = 'danger';
							 break;			
		}
		
		// set change password notification
		$message = $this->base->set_message($msg,$type);

		$this->session->set_flashdata('cpassword.message',$message);

		redirect(CN_BASE.'index', 'refresh');		
	}	
}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */
