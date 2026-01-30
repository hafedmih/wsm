<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Storekeeper extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');

        /* CHARGEMENT DES MODÈLES POUR ÉVITER LES ERREURS DANS backend/index.php */
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        
        /* Contrôle du cache */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        /* Vérification de session */
        if ($this->session->userdata('storekeeper_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('storekeeper/dashboard'), 'refresh');
    }

    public function dashboard() {
        $page_data['page_title']  = 'Storekeeper Dashboard';
        $page_data['folder_name'] = 'dashboard'; // Représente le dossier sous views/backend/storekeeper/
        $page_data['page_name']   = 'index';     // Représente le fichier index.php
        $this->load->view('backend/index', $page_data);
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
    if ($param1 == 'create') {
        echo $this->crud_model->exit_voucher_create();
    }
     elseif ($param1 == 'list') {
        $this->load->view('backend/storekeeper/exit_voucher/list');
    }
    elseif (empty($param1)) {
        $page_data['folder_name'] = 'exit_voucher';
        $page_data['page_title'] = 'exit_vouchers';
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
}