<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gm extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        // CHARGEMENT DES BIBLIOTHÈQUES
        $this->load->database();
        $this->load->library('session');

        // CHARGEMENT DES MODÈLES (Indispensable pour Ekattor)
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        
        /* Cache control */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        // Vérification de session pour le GM
        if ($this->session->userdata('gm_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('gm/dashboard'), 'refresh');
    }

   public function dashboard() {
    // Récupérer tous les projets ouverts pour le dashboard
    $this->db->where('status', 'open');
    $page_data['active_projects'] = $this->db->get('projects')->result_array();

    // Statistiques globales pour le GM
    $page_data['total_budget'] = $this->db->select_sum('quotation_amount')->get_where('projects', ['status' => 'open'])->row()->quotation_amount;
    $page_data['total_projects'] = count($page_data['active_projects']);

    $page_data['page_title'] = 'General Manager Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $page_data['page_name'] = 'index';
    $this->load->view('backend/index', $page_data);
}
    public function asset($param1 = '', $param2 = '') {
    if ($param1 == 'create') {
        echo $this->crud_model->asset_create();
    }
    if ($param1 == 'update') {
        echo $this->crud_model->asset_update($param2);
    }
    if ($param1 == 'list') {
        $this->load->view('backend/gm/asset/list');
    }
    if (empty($param1)) {
        $page_data['folder_name'] = 'asset';
        $page_data['page_title'] = 'manage_assets';
        $this->load->view('backend/index', $page_data);
    }
}
public function project($param1 = '', $param2 = '') {
    if ($param1 == 'create') {
        echo $this->crud_model->project_create();
    }
    elseif ($param1 == 'update') {
        echo $this->crud_model->project_update($param2);
    }
    elseif ($param1 == 'list') {
        $this->load->view('backend/gm/project/list');
    }
    elseif (empty($param1)) {
        $page_data['folder_name'] = 'project';
        $page_data['page_title'] = 'manage_projects';
        $this->load->view('backend/index', $page_data);
    }
}
public function exit_voucher($param1 = '', $param2 = '') {
    if ($param1 == 'approve') {
        echo $this->crud_model->exit_voucher_approve($param2);
    }
    elseif ($param1 == 'list') {
        $this->load->view('backend/gm/exit_voucher/list');
    }
    elseif (empty($param1)) {
        $page_data['folder_name'] = 'exit_voucher';
        $page_data['page_title'] = 'approve_vouchers';
        $this->load->view('backend/index', $page_data);
    }
}
public function purchase_order($param1 = '', $param2 = '') {
    if ($param1 == 'create' || $param1 == 'update_status') {
        echo $this->crud_model->manage_purchase_order($param1, $param2);
    }
    elseif ($param1 == 'list') {
        $this->load->view('backend/'.$this->session->userdata('user_type').'/purchase_order/list');
    }
    elseif (empty($param1)) {
        $page_data['folder_name'] = 'purchase_order';
        $page_data['page_title'] = 'purchase_orders';
        $this->load->view('backend/index', $page_data);
    }
}
}