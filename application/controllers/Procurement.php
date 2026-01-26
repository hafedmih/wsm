<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Procurement extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');

        /* CHARGEMENT DES MODÈLES (Indispensable pour le layout backend/index.php) */
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        
        /* Contrôle du cache (Standard Ekattor) */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        /* Vérification de session pour le rôle Procurement */
        if ($this->session->userdata('procurement_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('procurement/dashboard'), 'refresh');
    }

    public function dashboard() {
        
         $page_data['pending_po_count'] = $this->crud_model->get_pending_tasks_count();
        $page_data['page_title']  = 'Procurement Dashboard';
        $page_data['folder_name'] = 'dashboard'; // Dossier sous views/backend/procurement/
        $page_data['page_name']   = 'index';     // Fichier index.php
        $this->load->view('backend/index', $page_data);
    }
    public function purchase_order($param1 = '', $param2 = '') {
    if ($param1 == 'create' || $param1 == 'update_status') {
        echo $this->crud_model->manage_purchase_order($param1, $param2);
    }
    elseif ($param1 == 'list') {
        $page_data['step_filter'] = $this->input->get('step');
        $this->load->view('backend/'.$this->session->userdata('user_type').'/purchase_order/list',$page_data['step_filter']);
    }
    elseif (empty($param1)) {
         $page_data['step_filter'] = $this->input->get('step');
         $page_data['folder_name'] = 'purchase_order';
        $page_data['page_title'] = 'purchase_orders';
        $this->load->view('backend/index', $page_data);
    }
}
}