<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Superadmin extends CI_Controller {
  public function __construct(){

    parent::__construct();

    $this->load->database();
    $this->load->library('session');

    /*LOADING ALL THE MODELS HERE*/
    $this->load->model('Crud_model',     'crud_model');
    $this->load->model('User_model',     'user_model');
    $this->load->model('Settings_model', 'settings_model');
    $this->load->model('Payment_model',  'payment_model');
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

    if($this->session->userdata('superadmin_login') != 1){
      redirect(site_url('login'), 'refresh');
    }
  }
  //dashboard
  public function index(){
    redirect(route('dashboard'), 'refresh');
  }

  public function dashboard(){

    // $this->msg91_model->clickatell();
    $page_data['page_title'] = 'Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $this->load->view('backend/index', $page_data);
  }

  // START ADMIN SECTION
  public function admin($param1 = "", $param2 = "", $param3 = "") {
    if($param1 == 'create'){
      $response = $this->user_model->create_admin();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_admin($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_admin($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/admin/list');
    }
if($param1 == 'update_status'){
        $user_id = $param2;
        $status  = $param3;

        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => $status));
        
        echo '1'; // Success
        return; // Stop execution
    }
    if(empty($param1)){
      $page_data['folder_name'] = 'admin';
      $page_data['page_title'] = 'admins';
      $this->load->view('backend/index', $page_data);
    }
  }
  // END ADMIN SECTION


 





  // SETTINGS MANAGER
  public function system_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_system_settings();
      echo $response;
    }

    if ($param1 == 'logo_update') {
      $response = $this->settings_model->update_system_logo();
      echo $response;
    }
    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'system_settings';
      $page_data['settings_type'] = 'system_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // FRONTEND SETTINGS MANAGER
  public function website_settings($param1 = '', $param2 = '', $param3 = '') {
    if ($param1 == 'events') {
      $page_data['page_content']  = 'events';
    }
    if ($param1 == 'gallery') {
      $page_data['page_content']  = 'gallery';
    }
    if ($param1 == 'privacy_policy') {
      $page_data['page_content']  = 'privacy_policy';
    }
    if ($param1 == 'about_us') {
      $page_data['page_content']  = 'about_us';
    }
    if ($param1 == 'terms_and_conditions') {
      $page_data['page_content']  = 'terms_and_conditions';
    }
    if ($param1 == 'homepage_slider') {
      $page_data['page_content']  = 'homepage_slider';
    }
    if ($param1 == 'gallery_image') {
      $page_data['page_content']  = 'gallery_image';
      $page_data['gallery_id']  = $param2;
    }
    if ($param1 == 'other_settings') {
      $page_data['page_content']  = 'other_settings';
    }
    if(empty($param1) || $param1 == 'general_settings'){
      $page_data['page_content']  = 'general_settings';
    }

    $page_data['folder_name']   = 'website_settings';
    $page_data['page_title']    = 'website_settings';
    $page_data['settings_type'] = 'website_settings';
    $this->load->view('backend/index', $page_data);
  }

  public function website_update($param1 = "") {
    if ($param1 == 'general_settings') {
      $response = $this->frontend_model->update_frontend_general_settings();
    }

    echo $response;
  }

  public function other_settings_update($param1 = "") {
    $response = $this->frontend_model->other_settings_update();
    echo $response;
  }

  public function update_recaptcha_settings($param1 = "") {
    $response = $this->frontend_model->update_recaptcha_settings();
    echo $response;
  }

  //ABOUT US UPDATE
  public function about_us($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_about_us();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //PRIVACY POLICY UPDATE
  public function privacy_policy($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_privacy_policy();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //TERMS AND CONDITION UPDATE
  public function terms_and_conditions($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_terms_and_conditions();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }
  //TERMS AND CONDITION UPDATE
  public function homepage_slider($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_homepage_slider();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  // SETTINGS MANAGER
  public function school_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_current_school_settings();
      echo $response;
    }

    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'school_settings';
      $page_data['settings_type'] = 'school_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

 
  // LANGUAGE SETTINGS
  public function language($param1 = "", $param2 = "") {
    // adding language
    if ($param1 == 'create') {
      $response = $this->settings_model->create_language();
      echo $response;
    }

    // update language
    if ($param1 == 'update') {
      $response = $this->settings_model->update_language($param2);
      echo $response;
    }

    // deleting language
    if ($param1 == 'delete') {
      $response = $this->settings_model->delete_language($param2);
      echo $response;
    }

    // showing the list of language
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/language/list');
    }

    // showing the list of language
    if ($param1 == 'active') {
      $this->settings_model->update_system_language($param2);
      redirect(route('language'), 'refresh');
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
  // SMTP SETTINGS MANAGER
  public function smtp_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_smtp_settings();
      echo $response;
    }

    // showing the Smtp Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'smtp_settings';
      $page_data['settings_type'] = 'smtp_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  //MANAGE PROFILE STARTS
  public function profile($param1 = "", $param2 = "") {
    if ($param1 == 'update_profile') {
      $response = $this->user_model->update_profile();
      echo $response;
    }
    if ($param1 == 'update_password') {
      $response = $this->user_model->update_password();
      echo $response;
    }

    // showing the Smtp Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'profile';
      $page_data['page_title']  = 'manage_profile';
      $this->load->view('backend/index', $page_data);
    }
  }
  //MANAGE PROFILE ENDS

  // ABOUT APPLICATION STARTS
  public function about() {

    $page_data['application_details'] = $this->settings_model->get_application_details();
    $page_data['folder_name'] = 'about';
    $page_data['page_title']  = 'about';
    $this->load->view('backend/index', $page_data);
  }
  // ABOUT APPLICATION ENDS

    public function searchUsers() {
      $query = $this->input->get('query');

      $this->load->model('Crud_model');
      $users = $this->Crud_model->searchUsers($query);

      echo json_encode($users);
  }
  
}
