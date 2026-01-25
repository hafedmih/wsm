<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING MODELS*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Email_model',    'email_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		timezone();
	}

	public function index()
	{
		if ($this->session->userdata('superadmin_login')) {
			redirect(site_url('superadmin/dashboard'), 'refresh');
		} elseif ($this->session->userdata('admin_login')) {
			redirect(site_url('admin/dashboard'), 'refresh');
		} elseif ($this->session->userdata('storekeeper_login')) {
			redirect(site_url('storekeeper/dashboard'), 'refresh');
		} elseif ($this->session->userdata('sitemanager_login')) {
			redirect(site_url('sitemanager/dashboard'), 'refresh');
		} elseif ($this->session->userdata('procurement_login')) {
			redirect(site_url('procurement/dashboard'), 'refresh');
		} elseif ($this->session->userdata('gm_login')) {
			redirect(site_url('gm/dashboard'), 'refresh');
		} elseif ($this->session->userdata('purchasingagent_login')) {
			redirect(site_url('purchasingagent/dashboard'), 'refresh');
		} elseif ($this->session->userdata('daf_login')) {
			redirect(site_url('daf/dashboard'), 'refresh');
		} elseif ($this->session->userdata('accountant_login')) {
			redirect(site_url('accountant/dashboard'), 'refresh');
		} else {
			$this->load->view('login');
		}
	}

	public function validate_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$credential = array('email' => $email, 'password' => sha1($password));

		$query = $this->db->get_where('users', $credential);
                
		if ($query->num_rows() > 0) {
			$row = $query->row();
            
            if ($row->status == 0) {
                $this->session->set_flashdata('error_message', get_phrase('your_account_is_disabled'));
                redirect(site_url('login'), 'refresh');
                return;
            }

			// Données de session communes
			$this->session->set_userdata('user_login_type', true);
			$this->session->set_userdata('user_id', $row->id);
			$this->session->set_userdata('user_name', $row->name);
			$this->session->set_userdata('user_type', $row->role);
			$this->session->set_userdata('site_id', $row->site_id); 
// Important pour Nouakchott/Tasiast

			$this->session->set_flashdata('flash_message', get_phrase('welcome_back'));

			// Redirection par rôle
			if ($row->role == 'superadmin') {
				$this->session->set_userdata('superadmin_login', true);
				redirect(site_url('superadmin/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'admin') {
				$this->session->set_userdata('admin_login', true);
				redirect(site_url('admin/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'storekeeper') {
				$this->session->set_userdata('storekeeper_login', true);
				redirect(site_url('storekeeper/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'sitemanager') {
				$this->session->set_userdata('sitemanager_login', true);
				redirect(site_url('sitemanager/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'procurement') {
				$this->session->set_userdata('procurement_login', true);
				redirect(site_url('procurement/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'gm') {
				$this->session->set_userdata('gm_login', true);
				redirect(site_url('gm/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'purchasingagent') {
				$this->session->set_userdata('purchasingagent_login', true);
				redirect(site_url('purchasingagent/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'daf') {
				$this->session->set_userdata('daf_login', true);
				redirect(site_url('daf/dashboard'), 'refresh');
			} 
			elseif ($row->role == 'accountant') {
				$this->session->set_userdata('accountant_login', true);
				redirect(site_url('accountant/dashboard'), 'refresh');
			}
		} else {
			$this->session->set_flashdata('error_message', get_phrase('invalid_email_or_password'));
			redirect(site_url('login'), 'refresh');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url('login'), 'refresh');
	}

	public function retrieve_password()
	{
		$email = $this->input->post('email');
		$query = $this->db->get_where('users', array('email' => $email));
		if ($query->num_rows() > 0) {
			$query = $query->row_array();
			$new_password = substr(md5(rand(100000000, 20000000000)), 0, 7);

			$updater = array('password' => sha1($new_password));
			$this->db->where('id', $query['id']);
			$this->db->update('users', $updater);

			$this->email_model->password_reset_email($new_password, $query['id']);

			$this->session->set_flashdata('flash_message', get_phrase('please_check_your_mail_inbox'));
			redirect(site_url('login'), 'refresh');
		} else {
			$this->session->set_flashdata('error_message', get_phrase('email_not_found'));
            redirect(site_url('login'), 'refresh');
		}
	}

    public function change_language($language = '')
    {
        if ($language != "") {
            $this->db->where('id', 1);
            $this->db->update('settings', array('language' => $language));
            $this->session->set_userdata('language', $language);
        }
        redirect(site_url('login'), 'refresh');
    }
}