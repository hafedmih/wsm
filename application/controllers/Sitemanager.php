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

    // 1. Récupérer les projets ouverts UNIQUEMENT pour son site
    $this->db->where('status', 'open');
    $this->db->where('site_id', $current_site_id);
    $page_data['active_projects'] = $this->db->get('projects')->result_array();

    // 2. Compter les Bons de Sortie en attente pour son site
    $page_data['pending_vouchers_count'] = $this->db->get_where('exit_vouchers', [
        'site_id' => $current_site_id,
        'status'  => 'pending'
    ])->num_rows();

    // 3. Compter les tâches globales (Bons de sortie + Projets en retard)
    $urgent_projects = 0;
    foreach($page_data['active_projects'] as $p) {
        $days = (strtotime($p['deadline']) - time()) / (60 * 60 * 24);
        if($days <= 7) $urgent_projects++;
    }
    $page_data['total_tasks'] = $page_data['pending_vouchers_count']+$this->crud_model->get_pending_tasks_count();

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
    
    // 1. Actions AJAX (Approbation)
    if ($param1 == 'approve') {
        echo $this->crud_model->exit_voucher_approve($param2);
        return; // Arrêter l'exécution ici
    }

    // 2. Chargement de la liste via AJAX
    if ($param1 == 'list') {
        $page_data['selected_status'] = $param2; 
        // IMPORTANT : Passez $page_data pour que list.php reçoive 'selected_status'
        $this->load->view('backend/sitemanager/exit_voucher/list', $page_data);
        return; // Arrêter l'exécution ici
    }

    // 3. Affichage de la page principale (si vide OU si pending)
    if (empty($param1) || $param1 == 'pending') {
        $page_data['status_filter'] = ($param1 == 'pending') ? 'pending' : 'all';
        $page_data['folder_name']   = 'exit_voucher';
        $page_data['page_title']    = 'approve_vouchers';
        
        // On charge l'index global qui inclura votre index.php de dossier
        $this->load->view('backend/index', $page_data);
    }
}

public function purchase_order($param1 = '', $param2 = '') {
    if ($param1 == 'create' || $param1 == 'update_status') {
        echo $this->crud_model->manage_purchase_order($param1, $param2);
    }
    elseif ($param1 == 'list') {
         $page_data['step_filter'] = $this->input->get('step'); 
        $this->load->view('backend/'.$this->session->userdata('user_type').'/purchase_order/list',$page_data);
    }
     if ($param1 == 'step_sign_digital') {
        // Cette fonction gérera l'upload du BC signé par le GM
        echo $this->crud_model->po_gm_signature($param2); // param2 = ID du Bon
        return;
    }
    elseif (empty($param1)) {
        $page_data['step_filter'] = $this->input->get('step');
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
 public function my_tasks() {
    $current_site_id = $this->session->userdata('site_id');
    
    // 1. Compter les Bons de Sortie (Exit Vouchers) en attente
    $page_data['pending_vouchers'] = $this->db->get_where('exit_vouchers', [
        'site_id' => $current_site_id,
        'status'  => 'pending'
    ])->num_rows();

    // 2. Compter les Bons de Commande (PO) à valider (Étape 2 du Workflow)
    // On suppose que status = 2 correspond à la validation Site Manager
    $page_data['pending_pos'] = $this->db->get_where('purchase_orders', [
        'site_id' => $current_site_id,
        'status'  => 1 
    ])->num_rows();

    $page_data['page_title'] = get_phrase('my_task_center');
    $page_data['folder_name'] = 'tasks';
    $page_data['page_name'] = 'index';
    $this->load->view('backend/index', $page_data);
}
    }