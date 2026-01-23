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


	
}
