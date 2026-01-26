<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sitemanager extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');

        /* CHARGEMENT DES MODÈLES (Requis pour backend/index.php) */
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        
        /* Contrôle du cache */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        /* Vérification de session pour le Site Manager */
        if ($this->session->userdata('sitemanager_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('sitemanager/dashboard'), 'refresh');
    }

public function dashboard() {
    $current_site_id = $this->session->userdata('site_id');
    
    // On ne récupère que les projets "open" pour le dashboard actif
    $this->db->where('status', 'open');
    if ($this->session->userdata('user_type') != 'gm') {
        $this->db->where('site_id', $current_site_id);
    }
    $page_data['active_projects'] = $this->db->get('projects')->result_array();

    $page_data['page_title'] = 'Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $page_data['page_name'] = 'index';
    $this->load->view('backend/index', $page_data);
}
public function project($param1 = '', $param2 = '') {
    $current_site_id = $this->session->userdata('site_id');

    // Cas 1 : Ajout de progression (Action POST)
    if ($param1 == 'add_progress') {
        echo $this->crud_model->add_project_progress($param2);
        return; // Important d'arrêter ici
    }

    // Cas 2 : Appel AJAX pour la liste seule
    if ($param1 == 'list') {
        $page_data['projects'] = $this->db->get_where('projects', array('site_id' => $current_site_id))->result_array();
        $this->load->view('backend/sitemanager/project/list', $page_data);
    }elseif ($param1 == 'progress_history') {
    // On définit explicitement 'param1' pour que la vue le reconnaisse
    $page_data['param1'] = $param2; 
    $this->load->view('backend/'.$this->session->userdata('user_type').'/project/progress_history', $page_data);
}
    // Cas 3 : Chargement initial de la page (index + list)
    elseif (empty($param1)) {
        // AJOUTEZ CETTE LIGNE ICI POUR CORRIGER L'ERREUR
        $page_data['projects'] = $this->db->get_where('projects', array('site_id' => $current_site_id))->result_array();
        
        $page_data['folder_name'] = 'project';
        $page_data['page_title'] = 'assigned_projects';
        $this->load->view('backend/index', $page_data);
    }
}
   public function inventory($param1 = '', $param2 = '') {
    if ($param1 == 'create') {
        echo $this->crud_model->inventory_create();
    }
    elseif ($param1 == 'update_stock') {
        echo $this->crud_model->stock_update($param2);
    }
    elseif ($param1 == 'list') {
        $this->load->view('backend/storekeeper/inventory/list');
    }
    elseif ($param1 == 'update_stock') {
    echo $this->crud_model->stock_update($param2); // param2 est l'id du produit
}
    elseif (empty($param1)) {
        $page_data['folder_name'] = 'inventory';
        $page_data['page_title'] = 'manage_inventory';
        $this->load->view('backend/index', $page_data);
    }
}
public function exit_voucher($param1 = '', $param2 = '') {
    if ($param1 == 'approve') {
        echo $this->crud_model->exit_voucher_approve($param2);
    }
    elseif ($param1 == 'list') {
        $this->load->view('backend/sitemanager/exit_voucher/list');
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