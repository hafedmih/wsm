<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchasingagent extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        if ($this->session->userdata('purchasingagent_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function index() {
        redirect(route('dashboard'), 'refresh');
    }

    public function dashboard() {
        $page_data['page_title'] = 'Purchasingagent Dashboard';
        $page_data['folder_name'] = 'purchasing_agent';
        $this->load->view('backend/index', $page_data);
    }
}
