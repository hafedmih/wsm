<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

require APPPATH.'third_party/PHPExcel/IOFactory.php';
class Crud_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}


	public function session_create()
	{
		$data['name'] = html_escape($this->input->post('session_title'));
		$this->db->insert('sessions', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_created_successfully')
		);

		return json_encode($response);
	}

	public function session_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('session_title'));
		$this->db->where('id', $param1);
		$this->db->update('sessions', $data);
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function session_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('sessions');
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function active_session($param1 = ''){
		$previous_session_id = active_session();
		$this->db->where('id', $previous_session_id);
		$this->db->update('sessions', array('status' => 0));
		$this->db->where('id', $param1);
		$this->db->update('sessions', array('status' => 1));
		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_activated')
		);
		return json_encode($response);
	}

	// START OF NOTICEBOARD SECTION
	public function create_notice() {

		$this->db->trans_start(); 
	
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$ndata['send_to']          = html_escape($this->input->post('send_to'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date']             = $this->input->post('date') . ' 00:00:01';
		$data['school_id']        = $this->school_id;
		$data['session']          = $this->active_session;
	

		if (!empty($_FILES['notice_photo']['name'])) {
			$data['image'] = random(15) . '.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/' . $data['image']);
		} else {
			$data['image'] = 'placeholder.png';
		}
	
		$this->db->insert('noticeboard', $data);
		$notice_id = $this->db->insert_id(); 
	
		if ($ndata['send_to'] === 'users') {
			$this->db->where('id !=', $this->session->userdata('user_id'));
			$users = $this->db->get('users')->result();
		} elseif ($ndata['send_to'] === 'selected_user') {
			$user_ids = $this->input->post('user_ids'); 
			if (!empty($user_ids)) {
				$this->db->where_in('id', $user_ids);
				$users = $this->db->get('users')->result();
			} else {
				$users = []; 
			}
		} else {
			$this->db->where('role', $ndata['send_to']);
			$users = $this->db->get('users')->result();
		}
	
		foreach ($users as $user) {
			$notification_data = [
				'user_id'    => $user->id,
				'notice_id'  => $notice_id,
				'message'    => $data['notice_title'], 
				'status'     => 'unread',
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->db->insert('notifications', $notification_data);
		}
	
		$this->db->trans_complete(); 
	
		if ($this->db->trans_status() === FALSE) {
			$response = [
				'status'        => false,
				'notification'  => get_phrase('failed_to_create_notice')
			];
		} else {
			$response = [
				'status'        => true,
				'notification'  => get_phrase('notice_has_been_created')
			];
		}
	
		echo json_encode($response);
	}
	
	public function searchUsers($query) {
        $this->db->like('name', $query);
        $this->db->select('id, name');
        $query = $this->db->get('users');
        return $query->result();
    }
	

	public function update_notice($notice_id) {
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date'] 						= $this->input->post('date').' 00:00:1';
		if ($_FILES['notice_photo']['name'] != '') {
			$data['image']  = random(15).'.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/'. $data['image']);
		}
		$this->db->where('id', $notice_id);
		$this->db->update('noticeboard', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_updated')
		);

		return json_encode($response);
	}

	public function delete_notice($notice_id) {
		$this->db->where('id', $notice_id);
		$this->db->delete('noticeboard');

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_deleted')
		);

		return json_encode($response);
	}

	public function get_all_the_notices() {
		$notices = $this->db->get_where('noticeboard', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
		return json_encode($notices);
	}

	public function get_noticeboard_image($image) {
		if (file_exists('uploads/images/notice_images/'.$image))
		return base_url().'uploads/images/notice_images/'.$image;
		else
		return base_url().'uploads/images/notice_images/placeholder.png';
	}
	public function get_session($id = "") {
		if ($id > 0) {
			$this->db->where('id', $id);
		}
		$sessions = $this->db->get('sessions');
		return $sessions;
	}




	public function get_schools() {
		if (!addon_status('multi-school')) {
			$this->db->where('id', school_id());
		}
		$schools = $this->db->get('schools');
		return $schools;
	}

	// GET INSTALLED ADDONS
	public function get_addons($unique_identifier = "") {
		if ($unique_identifier != "") {
			$addons = $this->db->get_where('addons', array('unique_identifier' => $unique_identifier));
		}else{
			$addons = $this->db->get_where('addons');
		}
		return $addons;
	}

	// A function to convert excel to csv
	public function excel_to_csv($file_path = "", $rename_to = "") {
		//read file from path
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($file_path);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$index = 0;
		if ($objPHPExcel->getSheetCount() > 1) {
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$objPHPExcel->setActiveSheetIndex($index);
				$fileName = strtolower(str_replace(array("-"," "), "_", $worksheet->getTitle()));
				$outFile = str_replace(".", "", $fileName) .".csv";
				$objWriter->setSheetIndex($index);
				$objWriter->save("assets/csv_file/".$outFile);
				$index++;
			}
		}else{
			$outFile = $rename_to;
			$objWriter->setSheetIndex($index);
			$objWriter->save("assets/csv_file/".$outFile);
		}

		return true;
	}

	public function check_recaptcha(){
        if (isset($_POST["g-recaptcha-response"])) {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => get_common_settings('recaptcha_secretkey'),
                'response' => $_POST["g-recaptcha-response"]
            );
                $query = http_build_query($data);
                $options = array(
                'http' => array (
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                        "Content-Length: ".strlen($query)."\r\n".
                        "User-Agent:MyAgent/1.0\r\n",
                    'method' => 'POST',
                    'content' => $query
                )
            );
            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);
            if ($captcha_success->success == false) {
                return false;
            } else if ($captcha_success->success == true) {
                return true;
            }
        } else {
            return false;
        }
    }
public function get_time_ago($timestamp)
{
    $time_ago = $timestamp;
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;

    $minutes      = round($seconds / 60);           // value 60 is seconds
    $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
    $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 min * 60 sec
    $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+366)/5/12) * 24 * 60 * 60
    $years        = round($seconds / 31553280);     // value 31553280 is ((365+365+365+365+366)/5) * 24 * 60 * 60

    if ($seconds <= 60) {
        return get_phrase("just_now");
    } else if ($minutes <= 60) {
        return ($minutes == 1) ? "1 " . get_phrase("minute_ago") : $minutes . " " . get_phrase("minutes_ago");
    } else if ($hours <= 24) {
        return ($hours == 1) ? "1 " . get_phrase("hour_ago") : $hours . " " . get_phrase("hours_ago");
    } else if ($days <= 7) {
        return ($days == 1) ? get_phrase("yesterday") : $days . " " . get_phrase("days_ago");
    } else if ($weeks <= 4.3) {
        return ($weeks == 1) ? "1 " . get_phrase("week_ago") : $weeks . " " . get_phrase("weeks_ago");
    } else if ($months <= 12) {
        return ($months == 1) ? "1 " . get_phrase("month_ago") : $months . " " . get_phrase("months_ago");
    } else {
        return ($years == 1) ? "1 " . get_phrase("year_ago") : $years . " " . get_phrase("years_ago");
    }
}


	public function asset_create() {
    $data['asset_code'] = htmlspecialchars($this->input->post('asset_code'));
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['site_id'] = htmlspecialchars($this->input->post('site_id'));
    $data['last_calibration'] = htmlspecialchars($this->input->post('last_calibration'));
    $data['next_calibration'] = htmlspecialchars($this->input->post('next_calibration'));
    
    $this->db->insert('assets', $data);
    return json_encode(array('status' => true, 'notification' => get_phrase('asset_added_successfully')));
}

public function asset_update($id) {
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['next_calibration'] = htmlspecialchars($this->input->post('next_calibration'));
    $data['status'] = htmlspecialchars($this->input->post('status'));

    $this->db->where('id', $id);
    $this->db->update('assets', $data);
    return json_encode(array('status' => true, 'notification' => get_phrase('asset_updated_successfully')));
}
public function project_create() {
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['client_name'] = htmlspecialchars($this->input->post('client_name'));
    $data['quotation_amount'] = htmlspecialchars($this->input->post('quotation_amount'));
    $data['site_id'] = htmlspecialchars($this->input->post('site_id'));
    $data['start_date'] = htmlspecialchars($this->input->post('start_date'));
    $data['deadline'] = htmlspecialchars($this->input->post('deadline'));
    $data['status'] = 'open';

    // Upload du contrat
    if ($_FILES['contract_file']['name'] != "") {
        $data['contract_file'] = md5(rand(100, 1000)) . '.pdf';
        move_uploaded_file($_FILES['contract_file']['tmp_name'], 'uploads/contracts/' . $data['contract_file']);
    }

    $this->db->insert('projects', $data);
    return json_encode(array('status' => true, 'notification' => get_phrase('project_created_successfully')));
}

public function project_update($id) {
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['quotation_amount'] = htmlspecialchars($this->input->post('quotation_amount'));
    $data['progress_percent'] = htmlspecialchars($this->input->post('progress_percent'));
    $data['status'] = htmlspecialchars($this->input->post('status'));

    if ($_FILES['contract_file']['name'] != "") {
        $data['contract_file'] = md5(rand(100, 1000)) . '.pdf';
        move_uploaded_file($_FILES['contract_file']['tmp_name'], 'uploads/contracts/' . $data['contract_file']);
    }

    $this->db->where('id', $id);
    $this->db->update('projects', $data);
    return json_encode(array('status' => true, 'notification' => get_phrase('project_updated_successfully')));
}

public function add_project_progress($project_id) {
    // 1. Récupérer la progression actuelle
    $project = $this->db->get_where('projects', array('id' => $project_id))->row_array();
    $current_progress = (int)$project['progress_percent'];
    $added_value = (int)$this->input->post('percentage');

    // 2. Calculer le nouveau total
    $new_total = $current_progress + $added_value;

    // 3. Vérification : Ne pas dépasser 100
    if ($new_total > 100) {
        return json_encode(array(
            'status' => false, 
            'notification' => get_phrase('error_total_exceeds_100')
        ));
    }

    // 4. Préparer les données de mise à jour du projet
    $project_update = array(
        'progress_percent' => $new_total
    );

    // LOGIQUE AUTOMATIQUE : Si 100%, on change le statut
    if ($new_total == 100) {
        $project_update['status'] = 'completed';
    }

    // 5. Enregistrer l'historique
    $history_data = array(
        'project_id'    => $project_id,
        'title'         => htmlspecialchars($this->input->post('title')),
        'percentage'    => $added_value,
        'date_reported' => htmlspecialchars($this->input->post('date_reported')),
        'updated_by'    => $this->session->userdata('user_id')
    );
    $this->db->insert('project_progress', $history_data);

    // 6. Mettre à jour la table 'projects'
    $this->db->where('id', $project_id);
    $this->db->update('projects', $project_update);

    // Message personnalisé si complété
    $message = ($new_total == 100) 
               ? get_phrase('project_completed_successfully') 
               : get_phrase('progress_added_successfully');

    return json_encode(array(
        'status' => true, 
        'notification' => $message . ' (Total: ' . $new_total . '%)'
    ));
}
public function get_project_progress($project_id) {
    $this->db->select('project_progress.*, users.name as user_name');
    $this->db->from('project_progress');
    $this->db->join('users', 'users.id = project_progress.updated_by');
    $this->db->where('project_progress.project_id', $project_id);
    $this->db->order_by('project_progress.date_reported', 'DESC');
    return $this->db->get()->result_array();
}
// Création d'un article et initialisation du stock
public function inventory_create() {
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['sku']  = htmlspecialchars($this->input->post('sku'));
    $data['unit'] = htmlspecialchars($this->input->post('unit'));
    $data['category_id'] = htmlspecialchars($this->input->post('category_id'));

    $this->db->insert('inventory', $data);
    $inventory_id = $this->db->insert_id();

    // Initialiser le stock à 0 pour les deux sites
    $this->db->insert('stocks', ['inventory_id' => $inventory_id, 'site_id' => 1, 'quantity' => 0]);
    $this->db->insert('stocks', ['inventory_id' => $inventory_id, 'site_id' => 2, 'quantity' => 0]);

    return json_encode(array('status' => true, 'notification' => get_phrase('product_added_successfully')));
}


public function stock_update($inventory_id) {
    $site_id  = htmlspecialchars($this->input->post('site_id'));
    $quantity = htmlspecialchars($this->input->post('quantity'));

    $data = array('quantity' => $quantity);

    $this->db->where('inventory_id', $inventory_id);
    $this->db->where('site_id', $site_id);
    $this->db->update('stocks', $data);

    return json_encode(array(
        'status' => true, 
        'notification' => get_phrase('stock_adjusted_successfully')
    ));
}

// Création avec multi-articles et document
public function exit_voucher_create() {
    // 1. Données de base
    $data['code']         = 'BS-' . date('dmy') . '-' . rand(100, 999);
    $data['site_id']      = $this->session->userdata('site_id');
    $data['project_id']   = $this->input->post('project_id');
    $data['asset_id']     = $this->input->post('asset_id');
    $data['motive']       = htmlspecialchars($this->input->post('motive'));
    $data['requested_by'] = $this->session->userdata('user_id');
    $data['status']       = 'pending';

    $this->db->insert('exit_vouchers', $data);
    $voucher_id = $this->db->insert_id();

    // 2. Gestion des articles et préparation des données pour le PDF
    $inventory_ids = $this->input->post('inventory_id');
    $quantities    = $this->input->post('quantity');
    $items_for_pdf = [];

    foreach ($inventory_ids as $key => $id) {
        if(!empty($id)){
            $item_info = $this->db->get_where('inventory', ['id' => $id])->row_array();
            $this->db->insert('exit_voucher_items', [
                'voucher_id'   => $voucher_id,
                'inventory_id' => $id,
                'quantity'     => $quantities[$key]
            ]);
            $items_for_pdf[] = [
                'name' => $item_info['name'],
                'sku'  => $item_info['sku'],
                'unit' => $item_info['unit'],
                'quantity' => $quantities[$key]
            ];
        }
    }

    // 3. RÉCUPÉRATION DES NOMS POUR LE PDF (TRÈS IMPORTANT)
    $project = $this->db->get_where('projects', ['id' => $data['project_id']])->row_array();
    $pdf_data['v'] = $data;
    $pdf_data['v']['project_name'] = ($project) ? $project['name'] : 'Usage Général';
    
    $site = $this->db->get_where('sites', ['id' => $data['site_id']])->row_array();
    $pdf_data['v']['site_name'] = ($site) ? $site['name'] : 'N/A';
    
    $user = $this->db->get_where('users', ['id' => $data['requested_by']])->row_array();
    $pdf_data['v']['requester_name'] = $user['name']; // On récupère le nom exact de la DB
    $pdf_data['v']['created_at'] = date('Y-m-d H:i:s');
    $pdf_data['items'] = $items_for_pdf;

    // 4. GÉNÉRATION DU PDF ET SAUVEGARDE PHYSIQUE
    $html = $this->load->view('backend/storekeeper/exit_voucher/exit_voucher_pdf', $pdf_data, true);
    $this->load->library('pdf');
    $pdf_content = $this->pdf->generate($html, '', false);
    
    $file_name = 'BS_REQ_' . $voucher_id . '.pdf';
    $file_path = 'uploads/vouchers/' . $file_name;
    
    if (!is_dir('uploads/vouchers/')) { mkdir('uploads/vouchers/', 0777, true); }
    file_put_contents($file_path, $pdf_content);

    // 5. Enregistrement du document généré
    $this->db->insert('exit_voucher_documents', [
        'voucher_id'  => $voucher_id,
        'file_name'   => $file_name,
        'file_path'   => $file_path,
        'uploaded_by' => $data['requested_by'],
        'doc_type'    => 'request_doc'
    ]);

    return json_encode(['status' => true, 'notification' => get_phrase('voucher_created_and_pdf_generated')]);
}


public function exit_voucher_approve($voucher_id) {
    $approved_by = $this->session->userdata('user_id');
    $approved_at = date('Y-m-d H:i:s');
    
    // 1. Mise à jour de l'approbateur
    $this->db->where('id', $voucher_id);
    $this->db->update('exit_vouchers', [
        'status'      => 'approved',
        'approved_by' => $approved_by,
        'approved_at' => $approved_at
    ]);

    // 2. Déduction Stock (Identique)
    $voucher = $this->db->get_where('exit_vouchers', ['id' => $voucher_id])->row_array();
    $items = $this->db->get_where('exit_voucher_items', ['voucher_id' => $voucher_id])->result_array();
    foreach ($items as $item) {
        $this->db->where(['inventory_id' => $item['inventory_id'], 'site_id' => $voucher['site_id']]);
        $this->db->set('quantity', 'quantity - ' . $item['quantity'], FALSE);
        $this->db->update('stocks');
    }

    // 3. GÉNÉRATION DU PDF FINAL (Le template inclura maintenant la signature)
    $this->db->select('exit_vouchers.*, p.name as project_name, s.name as site_name');
    $this->db->from('exit_vouchers');
    $this->db->join('projects p', 'p.id = exit_vouchers.project_id', 'left');
    $this->db->join('sites s', 's.id = exit_vouchers.site_id');
    $this->db->where('exit_vouchers.id', $voucher_id);
    $pdf_data['v'] = $this->db->get()->row_array();

    $pdf_data['items'] = $this->db->select('exit_voucher_items.*, i.name, i.sku, i.unit')
                                  ->join('inventory i', 'i.id = exit_voucher_items.inventory_id')
                                  ->get_where('exit_voucher_items', ['voucher_id' => $voucher_id])->result_array();

    $html = $this->load->view('backend/storekeeper/exit_voucher/exit_voucher_pdf', $pdf_data, true);
    $this->load->library('pdf');
    $pdf_content = $this->pdf->generate($html, '', false);
    
    $file_name = 'BS_FINAL_' . $voucher_id . '.pdf';
    $file_path = 'uploads/vouchers/' . $file_name;
    file_put_contents($file_path, $pdf_content);

    // 4. Enregistrement du PDF FINAL
    $this->db->insert('exit_voucher_documents', [
        'voucher_id'  => $voucher_id,
        'file_name'   => $file_name,
        'file_path'   => $file_path,
        'uploaded_by' => $approved_by,
        'doc_type'    => 'approval_doc'
    ]);

    return json_encode(['status' => true, 'notification' => get_phrase('approved_successfully')]);
}
public function manage_purchase_order($param1 = '', $param2 = '') {
    
    // --- ÉTAPE 1 : CRÉATION DU BON (Storekeeper / Magasinier) ---
    if ($param1 == 'create') {
        $data['code']         = 'PO-' . date('Ymd') . '-' . rand(100, 999);
        $data['project_id']   = htmlspecialchars($this->input->post('project_id'));
        $data['site_id']      = $this->session->userdata('site_id');
        $data['requested_by'] = $this->session->userdata('user_id');
        $data['status']       = 1; 

        $this->db->insert('purchase_orders', $data);
        $po_id = $this->db->insert_id();

        // Récupération des articles (Multi-items)
        $inventory_ids = $this->input->post('inventory_id');
        $custom_names  = $this->input->post('custom_item_name'); // NOUVEAU
        $quantities    = $this->input->post('quantity');

        if (!empty($quantities)) {
            foreach ($quantities as $key => $qty) {
                $item_data = [
                    'purchase_order_id' => $po_id,
                    'inventory_id'      => (!empty($inventory_ids[$key])) ? $inventory_ids[$key] : NULL,
                    'custom_item_name'  => (!empty($custom_names[$key])) ? $custom_names[$key] : NULL,
                    'quantity'          => $qty
                ];
                $this->db->insert('purchase_order_items', $item_data);
            }
        }

        // --- GÉNÉRATION AUTOMATIQUE DU PDF ÉTAPE 1 ---
        $this->generate_po_document($po_id, 'step1_request');

        return json_encode(['status' => true, 'notification' => get_phrase('purchase_order_created_and_pdf_generated')]);
    }

    // --- ÉTAPES 2 À 7 : VALIDATION ---
    if ($param1 == 'update_status') {
        $po_id = $param2;
        $new_status = $this->input->post('status') ? $this->input->post('status') : $this->uri->segment(5);
        $update_data = ['status' => $new_status];

        // Étape 6 : Paiement (Méthode)
        if ($new_status == 6) {
            $update_data['payment_method'] = $this->input->post('payment_method_name');
        }   
        
        // Étape 5 : Agent d'achat (Prix et fournisseurs)
        if ($new_status == 5) {
            $update_data['supplier_name']  = htmlspecialchars($this->input->post('supplier_name'));
            $update_data['supplier_phone'] = htmlspecialchars($this->input->post('supplier_phone'));
            $suggested = $this->input->post('suggested_methods');
            if (!empty($suggested)) {
                $update_data['suggested_payment_methods'] = implode(',', $suggested);
            }
            
            $item_ids = $this->input->post('item_ids');
            $prices   = $this->input->post('unit_prices');
            $total_po = 0;

            foreach ($item_ids as $key => $id) {
                $unit_price = $prices[$key];
                $this->db->where('id', $id);
                $this->db->update('purchase_order_items', ['unit_price' => $unit_price]);
                
                $item = $this->db->get_where('purchase_order_items', ['id' => $id])->row_array();
                $total_po += ($unit_price * $item['quantity']);
            }
            $update_data['total_amount'] = $total_po;
        } 

        // Étape 7 : Archivage (Mise à jour du stock physique)
        if ($new_status == 7) {
            $po = $this->db->get_where('purchase_orders', ['id' => $po_id])->row_array();
            $items = $this->db->get_where('purchase_order_items', ['purchase_order_id' => $po_id])->result_array();

            foreach ($items as $item) {
                // On n'augmente le stock que si l'article est lié à l'inventaire
                if (!empty($item['inventory_id']) && $item['inventory_id'] > 0) {
                    $this->db->where(['inventory_id' => $item['inventory_id'], 'site_id' => $po['site_id']]);
                    $this->db->set('quantity', 'quantity + ' . $item['quantity'], FALSE);
                    $this->db->update('stocks');
                }
            }
              $archive_log = [
        'purchase_order_id' => $po_id,
        'file_name'         => 'N/A', // Pas de fichier
        'file_path'         => 'N/A',
        'doc_type'          => 'archived_log',
        'uploaded_by'       => $this->session->userdata('user_id'),
        'created_at'        => date('Y-m-d H:i:s')
    ];
    $this->db->insert('purchase_order_docs', $archive_log);
        }
        
        // Gestion des documents (Upload manuel ou Signature Automatique)
        if (!empty($_FILES['po_document']['name'])) {
            $this->upload_po_file($po_id);
        }

        $this->db->where('id', $po_id);
        $this->db->update('purchase_orders', $update_data);
         if (in_array($new_status, [2, 3, 4])) {
            $doc_type = $this->input->post('doc_type');
            // On régénère le document PDF qui inclura toutes les signatures jusqu'à cette étape
            $this->generate_po_document($po_id, $doc_type);
        }
        
        return json_encode(['status' => true, 'notification' => get_phrase('po_status_updated')]);
    }
}

/**
 * Génère le PDF du Bon de Commande avec la signature du profil
 */
private function generate_po_document($po_id, $doc_type) {
    $this->load->library('pdf');
    $user_id = $this->session->userdata('user_id');
    
    // RÉCUPÉRATION DES DONNÉES DU PO (Indispensable pour corriger l'erreur)
    $po = $this->db->get_where('purchase_orders', ['id' => $po_id])->row_array();
    
    // Préparation des données pour la vue
    $page_data['po_id'] = $po_id;
    $page_data['po']    = $po; // <-- Correction de l'erreur "Undefined variable: po"
    $page_data['user']  = $this->db->get_where('users', ['id' => $user_id])->row_array();
    
    // Charge la vue HTML
    $html = $this->load->view('backend/storekeeper/purchase_order/pdf_template', $page_data, true);
    
    // NOM DU FICHIER FIXE (Pour remplacer le document au lieu d'en créer un nouveau)
    $file_name = 'PO_' . $po_id . '_Final_Document.pdf';
    $file_path = 'uploads/po/' . $file_name;

    if (!is_dir('uploads/po')) mkdir('uploads/po', 0777, true);

    // Génération et ÉCRASEMENT du fichier existant
    $this->pdf->load_html($html);
    $this->pdf->render();
    file_put_contents($file_path, $this->pdf->output());

    // Vérifier si une entrée existe déjà dans purchase_order_docs pour ce type
    // ou si vous voulez un seul enregistrement par PO, utilisez un type générique
    $check_doc = $this->db->get_where('purchase_order_docs', [
        'purchase_order_id' => $po_id, 
        'doc_type' => $doc_type 
    ]);

    $doc_data = [
        'purchase_order_id' => $po_id,
        'file_name'         => $file_name,
        'file_path'         => $file_path,
        'doc_type'          => $doc_type,
        'uploaded_by'       => $user_id,
        'created_at'        => date('Y-m-d H:i:s')
    ];

    if ($check_doc->num_rows() > 0) {
        // On met à jour l'enregistrement existant
        $this->db->where('id', $check_doc->row()->id);
        $this->db->update('purchase_order_docs', $doc_data);
    } else {
        // On insère si c'est la première fois
        $this->db->insert('purchase_order_docs', $doc_data);
    }
}

public function get_pending_tasks_count() {
    $user_type = strtolower($this->session->userdata('user_type'));
    $site_id   = $this->session->userdata('site_id');

    $this->db->from('purchase_orders');

    if ($user_type == 'sitemanager') {
        $this->db->where('status', 1);
        $this->db->where('site_id', $site_id);
    } 
    elseif ($user_type == 'procurement') {
        $this->db->where('status', 2);
    } 
    elseif ($user_type == 'gm') {
        // Le GM a deux tâches : Signer (3) et Payer (5)
        $this->db->where_in('status', [3, 5]);
    } 
    elseif ($user_type == 'purchasingagent') {
        $this->db->where('status', 4);
    } 
    elseif ($user_type == 'accountant' || $user_type == 'daf') {
        $this->db->where('status', 6);
    } 
    else {
        return 0;
    }

    return $this->db->count_all_results();
}
public function add_signature($po_id) {
    $status = $this->input->post('status');
    $sig_data = $this->input->post('signature_data');

    // 1. Sauvegarder l'image de la signature
    $sig_data = str_replace('data:image/png;base64,', '', $sig_data);
    $sig_data = str_replace(' ', '+', $sig_data);
    $sig_image = base64_decode($sig_data);
    
    $file_name = 'sig_'.$status.'_'.$po_id.'_'.time().'.png';
    $file_path = 'uploads/po/signatures/'.$file_name;
    file_put_contents($file_path, $sig_image);

    // 2. Enregistrer dans la DB
    $column = '';
    if($status == 2) $column = 'signature_site_manager';
    if($status == 3) $column = 'signature_procurement';
    if($status == 4) $column = 'signature_gm';

    $this->db->where('id', $po_id);
    $this->db->update('purchase_orders', [$column => $file_path, 'status' => $status]);

    return json_encode(['status' => true]);
}
/**
 * Gère l'upload physique des documents liés au workflow Purchase Order
 */
private function upload_po_file($po_id) {
    if (!empty($_FILES['po_document']['name'])) {
        
        $user_id = $this->session->userdata('user_id');
        $type = $this->input->post('doc_type'); // ex: invoice_doc, payment_doc, etc.
        
        $file_ext = pathinfo($_FILES['po_document']['name'], PATHINFO_EXTENSION);
        $file_name = $type . '_' . $po_id . '_' . time() . '.' . $file_ext;
        $file_path = 'uploads/po/' . $file_name;
        
        // Création du dossier si inexistant
        if (!is_dir('uploads/po')) {
            mkdir('uploads/po', 0777, true);
        }
        
        if (move_uploaded_file($_FILES['po_document']['tmp_name'], $file_path)) {
            $doc_data = [
                'purchase_order_id' => $po_id,
                'file_name'         => $file_name,
                'file_path'         => $file_path,
                'doc_type'          => $type,
                'uploaded_by'       => $user_id,
                'created_at'        => date('Y-m-d H:i:s')
            ];

            // Vérifier si un document du même type existe déjà pour ce PO (on le remplace)
            $check = $this->db->get_where('purchase_order_docs', [
                'purchase_order_id' => $po_id, 
                'doc_type' => $type
            ]);

            if ($check->num_rows() > 0) {
                $this->db->where('id', $check->row()->id);
                $this->db->update('purchase_order_docs', $doc_data);
            } else {
                $this->db->insert('purchase_order_docs', $doc_data);
            }
            return true;
        }
    }
    return false;
}

        }
