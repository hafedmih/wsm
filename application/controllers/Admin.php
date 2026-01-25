<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Admin extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Addon_model',    'addon_model');
		$this->load->model('Frontend_model', 'frontend_model');
		
		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();

		/*LOAD EXTERNAL LIBRARIES*/
		$this->load->library('pdf');

		if ($this->session->userdata('admin_login') != 1) {
			redirect(site_url('login'), 'refresh');
		}
	}
	//dashboard
	public function index()
	{
		redirect(route('dashboard'), 'refresh');
	}

	public function dashboard()
	{

		// $this->msg91_model->clickatell();
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}
	public function profile($param1 = "", $param2 = "")
	{
		if ($param1 == 'update_profile') {
			$response = $this->user_model->update_profile();
			echo $response;
		}
		if ($param1 == 'update_password') {
			$response = $this->user_model->update_password();
			echo $response;
		}

		// showing the Smtp Settings file
		if (empty($param1)) {
			$page_data['folder_name'] = 'profile';
			$page_data['page_title']  = 'manage_profile';
			$this->load->view('backend/index', $page_data);
		}
	}
public function language($param1 = "", $param2 = "") {
    // adding language
    if ($param1 == 'create') {
      $response = $this->settings_model->create_language();
      echo $response;
    }

    // update language
    

    // showing the list of language
    if ($param1 == 'active') {
      $this->settings_model->update_system_language($param2);
      redirect(route('dashboard'), 'refresh');
   
    }

    // showing the list of language
    if ($param1 == 'update_phrase') {
      $current_editing_language = htmlspecialchars($this->input->post('currentEditingLanguage'));
      $updatedValue = htmlspecialchars($this->input->post('updatedValue'));
      $key = htmlspecialchars($this->input->post('key'));
      saveJSONFile($current_editing_language, $key, $updatedValue);
      echo $current_editing_language.' '.$key.' '.$updatedValue;
    }

    // GET THE DROPDOWN OF LANGUAGES
    if($param1 == 'dropdown') {
      $this->load->view('backend/superadmin/language/dropdown');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'language';
      $page_data['page_title']  = 'languages';
      $this->load->view('backend/index', $page_data);
    }
  }
}
