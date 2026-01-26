<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchasingagent extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');

        /* CHARGEMENT DES MODÈLES REQUIS PAR LE LAYOUT EKATTOR */
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
        if ($this->session->userdata('purchasingagent_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(site_url('purchasingagent/dashboard'), 'refresh');
    }

    public function dashboard() {
        $page_data['page_title'] = 'Purchasing Agent Dashboard';
        $page_data['folder_name'] = 'dashboard';
        $page_data['page_name'] = 'index';
        $this->load->view('backend/index', $page_data);
    }

    /* MODULE PURCHASE ORDER POUR L'AGENT D'ACHAT (Étape 4 -> 5 : Facturation) */
    public function purchase_order($param1 = '', $param2 = '', $param3 = '') {
        if ($param1 == 'update_status') {
            echo $this->crud_model->manage_purchase_order($param1, $param2);
        }
        elseif ($param1 == 'list') {
            // Utilise la vue commune située dans backend/purchase_order/
            $this->load->view('backend/'.$this->session->userdata('user_type').'/purchase_order/list');
        }
        elseif (empty($param1)) {
            $page_data['folder_name'] = 'purchase_order';
            $page_data['page_title'] = 'purchase_orders_to_fulfill';
            $this->load->view('backend/index', $page_data);
        }
    }
}