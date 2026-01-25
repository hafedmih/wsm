<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accountant extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');

        /* CHARGER LES MODÈLES REQUIS PAR EKATTOR */
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        // Optionnel : $this->load->model('Email_model', 'email_model');

        /* Cache control */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        /* Vérification de session */
        if ($this->session->userdata('accountant_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('accountant/dashboard'), 'refresh');
    }

    
    public function dashboard()
	{

		// $this->msg91_model->clickatell();
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}
}