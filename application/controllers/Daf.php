<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daf extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');

        /* CHARGEMENT DES MODÈLES (Indispensable pour backend/index.php) */
        $this->load->model('Crud_model',     'crud_model');
        $this->load->model('User_model',     'user_model');
        $this->load->model('Settings_model', 'settings_model');
        
        /* Contrôle du cache (Standard Ekattor) */
        $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");

        /* Vérification de session pour le DAF */
        if ($this->session->userdata('daf_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        // Redirection standard vers le dashboard
        redirect(site_url('daf/dashboard'), 'refresh');
    }

    public function dashboard() {
        $page_data['page_title']  = 'Daf Dashboard';
        $page_data['folder_name'] = 'dashboard'; // Sous-dossier dans views/backend/daf/
        $page_data['page_name']   = 'index';     // Fichier index.php
        $this->load->view('backend/index', $page_data);
    }
}