<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class User_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}

	// GET SUPERADMIN DETAILS
	public function get_superadmin() {
		$this->db->where('role', 'superadmin');
		return $this->db->get('users')->row_array();
	}
	// GET USER DETAILS
	public function get_user_details($user_id = '', $column_name = '') {
		if($column_name != ''){
			return $this->db->get_where('users', array('id' => $user_id))->row($column_name);
		}else{
			return $this->db->get_where('users', array('id' => $user_id))->row_array();
		}
	}

	// ADMIN CRUD SECTION STARTS
	public function create_admin() {
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['role'] = 'admin';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if($duplication_status){
			$this->db->insert('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('admin_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_admin($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('admin_has_been_updated_successfully')
			);

		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_admin($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$response = array(
			'status' => true,
			'notification' => get_phrase('admin_has_been_deleted_successfully')
		);
		return json_encode($response);
	}
	// ADMIN CRUD SECTION ENDS

	//START TEACHER section
	public function create_teacher()
	{
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['role'] = 'teacher';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if($duplication_status){
			$this->db->insert('users', $data);


			$teacher_id = $this->db->insert_id();
			$teacher_table_data['user_id'] = $teacher_id;
			$teacher_table_data['about'] = html_escape($this->input->post('about'));
			$social_links = array(
				'facebook' => $this->input->post('facebook_link'),
				'twitter' => $this->input->post('twitter_link'),
				'linkedin' => $this->input->post('linkedin_link')
			);
			$teacher_table_data['social_links'] = json_encode($social_links);
			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
			$teacher_table_data['school_id'] = html_escape($this->input->post('school_id'));
			$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
			$this->db->insert('teachers', $teacher_table_data);

			if ($_FILES['image_file']['name'] != "") {
					move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/'.$teacher_id.'.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('teacher_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_teacher($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->update('users', $data);

			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
			$teacher_table_data['about'] = html_escape($this->input->post('about'));
			$social_links = array(
				'facebook' => $this->input->post('facebook_link'),
				'twitter' => $this->input->post('twitter_link'),
				'linkedin' => $this->input->post('linkedin_link')
			);
			$teacher_table_data['social_links'] = json_encode($social_links);
			$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->where('user_id', $param1);
			$this->db->update('teachers', $teacher_table_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/'.$param1.'.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('teacher_has_been_updated_successfully')
			);

		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_teacher($param1 = '', $param2)
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$this->db->where('user_id', $param1);
		$this->db->delete('teachers');

		$this->db->where('teacher_id', $param2);
		$this->db->delete('teacher_permissions');

		$response = array(
			'status' => true,
			'notification' => get_phrase('teacher_has_been_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_teachers() {
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'teacher'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_teacher_by_id($teacher_id = "") {
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $teacher_id
		);
		$result = $this->db->get_where('teachers', $checker)->row_array();
		return $this->db->get_where('users', array('id' => $result['user_id']));
	}
	//END TEACHER section


	//START TEACHER PERMISSION section
	public function teacher_permission(){
		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));
		$teacher_id = html_escape($this->input->post('teacher_id'));
		$column_name = html_escape($this->input->post('column_name'));
		$value = html_escape($this->input->post('value'));

		$check_row = $this->db->get_where('teacher_permissions', array('class_id' => $class_id, 'section_id' => $section_id, 'teacher_id' => $teacher_id));
		if($check_row->num_rows() > 0){
			$data[$column_name] = $value;
			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$this->db->where('teacher_id', $teacher_id);
			$this->db->update('teacher_permissions', $data);
		}else{
			$data['class_id'] = $class_id;
			$data['section_id'] = $section_id;
			$data['teacher_id'] = $teacher_id;
			$data[$column_name] = 1;
			$this->db->insert('teacher_permissions', $data);
		}
	}
	//END TEACHER PERMISSION section

	//START PARENT section
	public function donor_create()
	{
            
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'donor';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if($duplication_status){

			$this->db->insert('users', $data);
                        

                $donor_data['name'] = html_escape($this->input->post('name'));
		$donor_data['name_ar'] = html_escape($this->input->post('name_ar'));
		$donor_data['contact_person'] = html_escape($this->input->post('contact_person'));
		$donor_data['email'] = html_escape($this->input->post('email'));
		$donor_data['website'] = html_escape($this->input->post('website'));
                
                $donor_data['created_at'] = time();
		
			$donor_data['user_id'] = $this->db->insert_id();
			$this->db->insert('donors', $donor_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('donor_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function donor_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){

			$this->db->where('id', $param1);
			$this->db->update('users', $data);
                        
                        $donor_data['name'] = html_escape($this->input->post('name'));
		$donor_data['name_ar'] = html_escape($this->input->post('name_ar'));
		$donor_data['contact_person'] = html_escape($this->input->post('contact_person'));
		$donor_data['email'] = html_escape($this->input->post('email'));
		$donor_data['website'] = html_escape($this->input->post('website'));
                
                $this->db->where('user_id', $param1);
			$this->db->update('donors', $donor_data);
                

			$response = array(
				'status' => true,
				'notification' => get_phrase('donor_updated_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function donor_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$this->db->where('user_id', $param1);
		$this->db->delete('donors');

		$response = array(
			'status' => true,
			'notification' => get_phrase('donor_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_parents() {
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'parent'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_parent_by_id($parent_id = "") {
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $parent_id
		);
		$result = $this->db->get_where('parents', $checker)->row_array();
		return $this->db->get_where('users', array('id' => $result['user_id']));
	}
	//END PARENT section


	//START ACCOUNTANT section
	public function accountant_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'accountant';
		$data['watch_history'] = '[]';

		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if($duplication_status){
			$this->db->insert('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('accountant_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function accountant_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('accountant_has_been_updated_successfully')
			);

		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);

	}

	public function accountant_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$response = array(
			'status' => true,
			'notification' => get_phrase('accountant_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_accountants() {
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'accountant'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_accountant_by_id($accountant_id = "") {
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $accountant_id
		);
		return $this->db->get_where('users', $checker);
	}
	//END ACCOUNTANT section

	//START LIBRARIAN section
	public function librarian_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'librarian';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if($duplication_status){
			$this->db->insert('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('librarian_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function librarian_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('librarian_updated_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function librarian_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$response = array(
			'status' => true,
			'notification' => get_phrase('librarian_deleted_successfully')
		);
		return json_encode($response);
	}


	public function get_librarians() {
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'librarian'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_librarian_by_id($librarian_id = "") {
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $librarian_id
		);
		return $this->db->get_where('users', $checker);
	}
	//END LIBRARIAN section


	//START STUDENT AND ADMISSION section
	public function single_student_create(){
		$user_data['name'] = html_escape($this->input->post('name'));
		$user_data['email'] = html_escape($this->input->post('email'));
		$user_data['password'] = sha1(html_escape($this->input->post('password')));
		$user_data['birthday'] = strtotime(html_escape($this->input->post('birthday')));
		$user_data['gender'] = html_escape($this->input->post('gender'));
		$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
		$user_data['address'] = html_escape($this->input->post('address'));
		$user_data['phone'] = html_escape($this->input->post('phone'));
		$user_data['role'] = 'student';
		$user_data['school_id'] = $this->school_id;
		$user_data['watch_history'] = '[]';
		$user_data['status'] = '1';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $user_data['email']);
		if($duplication_status){
			$this->db->insert('users', $user_data);
			$user_id = $this->db->insert_id();

			$student_data['code'] = student_code();
			$student_data['user_id'] = $user_id;
			$student_data['parent_id'] = html_escape($this->input->post('parent_id'));
			$student_data['session'] = $this->active_session;
			$student_data['school_id'] = $this->school_id;
			$this->db->insert('students', $student_data);
			$student_id = $this->db->insert_id();

			$enroll_data['student_id'] = $student_id;
			$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
			$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
			$enroll_data['session'] = $this->active_session;
			$enroll_data['school_id'] = $this->school_id;
			$this->db->insert('enrols', $enroll_data);

			move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function bulk_student_create(){
		$duplication_counter = 0;
		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));

		$students_name = html_escape($this->input->post('name'));
		$students_email = html_escape($this->input->post('email'));
		$students_password = html_escape($this->input->post('password'));
		$students_gender = html_escape($this->input->post('gender'));
		$students_parent = html_escape($this->input->post('parent_id'));

		foreach($students_name as $key => $value):
			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $students_email[$key]);
			if($duplication_status){
				$user_data['name'] = $students_name[$key];
				$user_data['email'] = $students_email[$key];
				$user_data['password'] = sha1($students_password[$key]);
				$user_data['gender'] = $students_gender[$key];
				$user_data['role'] = 'student';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';
				$user_data['status'] = '1';
				$this->db->insert('users', $user_data);
				$user_id = $this->db->insert_id();

				$student_data['code'] = student_code();
				$student_data['user_id'] = $user_id;
				$student_data['parent_id'] = $students_parent[$key];
				$student_data['session'] = $this->active_session;
				$student_data['school_id'] = $this->school_id;
				$this->db->insert('students', $student_data);
				$student_id = $this->db->insert_id();

				$enroll_data['student_id'] = $student_id;
				$enroll_data['class_id'] = $class_id;
				$enroll_data['section_id'] = $section_id;
				$enroll_data['session'] = $this->active_session;
				$enroll_data['school_id'] = $this->school_id;
				$this->db->insert('enrols', $enroll_data);
			}else{
				$duplication_counter++;
			}
		endforeach;

		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('some_of_the_emails_have_been_taken')
			);
		}else{
			$response = array(
				'status' => true,
				'notification' => get_phrase('students_added_successfully')
			);
		}

		return json_encode($response);
	}

	public function excel_create(){
		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$role = 'student';

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'],'uploads/csv_file/student.generate.csv');

		if (($handle = fopen('uploads/csv_file/student.generate.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if($count > 0){
					$user_data['name'] = html_escape($all_data[0]);
					$user_data['email'] = html_escape($all_data[1]);
					$user_data['password'] = sha1($all_data[2]);
					$user_data['phone'] = html_escape($all_data[3]);
					$user_data['gender'] = html_escape($all_data[5]);
					$user_data['role'] = $role;
					$user_data['school_id'] = $school_id;
					$user_data['watch_history'] = '[]';
					$user_data['status'] = '1';

					// check email duplication
					$duplication_status = $this->check_duplication('on_create', $user_data['email']);
					if($duplication_status){
						$this->db->insert('users', $user_data);
						$user_id = $this->db->insert_id();

						$student_data['code'] = student_code();
						$student_data['user_id'] = $user_id;
						$student_data['parent_id'] = html_escape($all_data[4]);
						$student_data['session'] = $session_id;
						$student_data['school_id'] = $school_id;
						$this->db->insert('students', $student_data);
						$student_id = $this->db->insert_id();

						$enroll_data['student_id'] = $student_id;
						$enroll_data['class_id'] = $class_id;
						$enroll_data['section_id'] = $section_id;
						$enroll_data['session'] = $session_id;
						$enroll_data['school_id'] = $school_id;
						$this->db->insert('enrols', $enroll_data);
					}else{
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}

		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('some_of_the_emails_have_been_taken')
			);
		}else{
			$response = array(
				'status' => true,
				'notification' => get_phrase('students_added_successfully')
			);
		}

		return json_encode($response);
	}

	public function student_update($student_id = '', $user_id = ''){
		$student_data['parent_id'] = html_escape($this->input->post('parent_id'));

		$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
		$enroll_data['section_id'] = html_escape($this->input->post('section_id'));

		$user_data['name'] = html_escape($this->input->post('name'));
		$user_data['email'] = html_escape($this->input->post('email'));
		$user_data['birthday'] = strtotime(html_escape($this->input->post('birthday')));
		$user_data['gender'] = html_escape($this->input->post('gender'));
		$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
		$user_data['address'] = html_escape($this->input->post('address'));
		$user_data['phone'] = html_escape($this->input->post('phone'));
		// Check Duplication
		$duplication_status = $this->check_duplication('on_update', $user_data['email'], $user_id);
		if ($duplication_status) {
			$this->db->where('id', $student_id);
			$this->db->update('students', $student_data);

			$this->db->where('student_id', $student_id);
			$this->db->update('enrols', $enroll_data);

			$this->db->where('id', $user_id);
			$this->db->update('users', $user_data);

			move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_updated_successfully')
			);

		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_student($student_id, $user_id) {
		$this->db->where('id', $student_id);
		$this->db->delete('students');

		$this->db->where('student_id', $student_id);
		$this->db->delete('enrols');

		$this->db->where('id', $user_id);
		$this->db->delete('users');

		$path = 'uploads/users/'.$user_id.'.jpg';
		if(file_exists($path)){
			unlink($path);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('student_deleted_successfully')
		);

		return json_encode($response);
	}

	public function student_enrolment($section_id = "") {
		return $this->db->get_where('enrols', array('section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session));
	}


	// This function will help to fetch student data by section, class or student id
	public function get_student_details_by_id($type = "", $id = "") {
		$enrol_data = array();
		if ($type == "section") {
			$checker = array(
				'section_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
			foreach ($enrol_data as $key => $enrol) {
				$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
				$enrol_data[$key]['code'] = $student_details['code'];
				$enrol_data[$key]['user_id'] = $student_details['user_id'];
				$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
				$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
				$enrol_data[$key]['name'] = $user_details['name'];
				$enrol_data[$key]['email'] = $user_details['email'];
				$enrol_data[$key]['role'] = $user_details['role'];
				$enrol_data[$key]['address'] = $user_details['address'];
				$enrol_data[$key]['phone'] = $user_details['phone'];
				$enrol_data[$key]['birthday'] = $user_details['birthday'];
				$enrol_data[$key]['gender'] = $user_details['gender'];
				$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

				$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
				$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

				$enrol_data[$key]['class_name'] = $class_details['name'];
				$enrol_data[$key]['section_name'] = $section_details['name'];
			}
		}
		elseif ($type == "class") {
			$checker = array(
				'class_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
			foreach ($enrol_data as $key => $enrol) {
				$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
				$enrol_data[$key]['code'] = $student_details['code'];
				$enrol_data[$key]['user_id'] = $student_details['user_id'];
				$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
				$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
				$enrol_data[$key]['name'] = $user_details['name'];
				$enrol_data[$key]['email'] = $user_details['email'];
				$enrol_data[$key]['role'] = $user_details['role'];
				$enrol_data[$key]['address'] = $user_details['address'];
				$enrol_data[$key]['phone'] = $user_details['phone'];
				$enrol_data[$key]['birthday'] = $user_details['birthday'];
				$enrol_data[$key]['gender'] = $user_details['gender'];
				$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

				$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
				$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

				$enrol_data[$key]['class_name'] = $class_details['name'];
				$enrol_data[$key]['section_name'] = $section_details['name'];
			}
		}
		elseif ($type == "student") {
			$checker = array(
				'student_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();
			$student_details = $this->db->get_where('students', array('id' => $enrol_data['student_id']))->row_array();
			$enrol_data['code'] = $student_details['code'];
			$enrol_data['user_id'] = $student_details['user_id'];
			$enrol_data['parent_id'] = $student_details['parent_id'];
			$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
			$enrol_data['name'] = $user_details['name'];
			$enrol_data['email'] = $user_details['email'];
			$enrol_data['role'] = $user_details['role'];
			$enrol_data['address'] = $user_details['address'];
			$enrol_data['phone'] = $user_details['phone'];
			$enrol_data['birthday'] = $user_details['birthday'];
			$enrol_data['gender'] = $user_details['gender'];
			$enrol_data['blood_group'] = $user_details['blood_group'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

			$enrol_data['class_name'] = $class_details['name'];
			$enrol_data['section_name'] = $section_details['name'];
		}
		return $enrol_data;
	}
	//END STUDENT AND ADMISSION section


	//STUDENT OF EACH SESSION
	public function get_session_wise_student() {
		$checker = array(
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('enrols', $checker);
	}

	// Get User Image Starts
	public function get_user_image($user_id) {
		if (file_exists('uploads/users/'.$user_id.'.jpg'))
		return base_url().'uploads/users/'.$user_id.'.jpg';
		else
		return base_url().'uploads/users/placeholder.jpg';
	}
	// Get User Image Ends

	// Check user duplication
	public function check_duplication($action = "", $email = "", $user_id = "") {
		$duplicate_email_check = $this->db->get_where('users', array('email' => $email));

		if ($action == 'on_create') {
			if ($duplicate_email_check->num_rows() > 0) {
				return false;
			}else {
				return true;
			}
		}elseif ($action == 'on_update') {
			if ($duplicate_email_check->num_rows() > 0) {
				if ($duplicate_email_check->row()->id == $user_id) {
					return true;
				}else {
					return false;
				}
			}else {
				return true;
			}
		}
	}

	//GET LOGGED IN USER DATA
	public function get_profile_data() {
		return $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row_array();
	}

	public function update_profile() {
    $response = array();
    $user_id = $this->session->userdata('user_id');
    $data['name'] = htmlspecialchars($this->input->post('name'));
    $data['email'] = htmlspecialchars($this->input->post('email'));
    $data['phone'] = htmlspecialchars($this->input->post('phone'));
    $data['address'] = htmlspecialchars($this->input->post('address'));

    // --- LOGIQUE DU SIGNATURE PAD ---
    $signature_data = $this->input->post('signature_data');
    if (!empty($signature_data)) {
        // 1. Supprimer l'ancienne signature si elle existe pour ne pas encombrer le serveur
        $old_signature = $this->db->get_where('users', array('id' => $user_id))->row()->signature;
        if (!empty($old_signature) && file_exists('uploads/signatures/' . $old_signature)) {
            unlink('uploads/signatures/' . $old_signature);
        }

        // 2. Décoder l'image Base64 envoyée par le Signature Pad
        // Format reçu : "data:image/png;base64,iVBORw0KGgoAAAANSUh..."
        $encoded_image = explode(",", $signature_data)[1];
        $decoded_image = base64_decode($encoded_image);

        // 3. Créer un nom de fichier unique et l'enregistrer
        $signature_filename = 'sig_' . $user_id . '_' . time() . '.png';
        $file_path = 'uploads/signatures/' . $signature_filename;
        
        // On sauvegarde le fichier physiquement
        file_put_contents($file_path, $decoded_image);
        
        // On ajoute le nom du fichier à la mise à jour de la base de données
        $data['signature'] = $signature_filename;
    }
    // --------------------------------

    // Check Duplication (Logique existante)
    $duplication_status = $this->check_duplication('on_update', $data['email'], $user_id);
    if($duplication_status) {
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        // Upload image de profil (Logique existante améliorée avec vérification de fichier)
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['tmp_name'] != "") {
            move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');
        }

        $response = array(
            'status' => true,
            'notification' => get_phrase('profile_updated_successfully')
        );
    } else {
        $response = array(
            'status' => false,
            'notification' => get_phrase('sorry_this_email_has_been_taken')
        );
    }

    return json_encode($response);
}

	public function update_password() {
		$user_id = $this->session->userdata('user_id');
		if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
			$user_details = $this->get_user_details($user_id);
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
				$data['password'] = sha1($new_password);
				$this->db->where('id', $user_id);
				$this->db->update('users', $data);

				$response = array(
					'status' => true,
					'notification' => get_phrase('password_updated_successfully')
				);
			}else {

				$response = array(
					'status' => false,
					'notification' => get_phrase('mismatch_password')
				);
			}
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('password_can_not_be_empty')
			);
		}
		return json_encode($response);
	}

	//GET LOGGED IN USERS CLASS ID AND SECTION ID (FOR STUDENT LOGGED IN VIEW)
	public function get_logged_in_student_details() {
		$user_id = $this->session->userdata('user_id');
		$student_data = $this->db->get_where('students', array('user_id' => $user_id))->row_array();
		$student_details = $this->get_student_details_by_id('student', $student_data['id']);
		return $student_details;
	}

	// GET STUDENT LIST BY PARENT
	public function get_student_list_of_logged_in_parent() {
		$parent_id = $this->session->userdata('user_id');
		$parent_data = $this->db->get_where('parents', array('user_id' => $parent_id))->row_array();
		$checker = array(
			'parent_id' => $parent_data['id'],
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$students = $this->db->get_where('students', $checker)->result_array();
		foreach ($students as $key => $student) {
			$checker = array(
				'student_id' => $student['id'],
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();

			$user_details = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
			$students[$key]['student_id'] = $student['id'];
			$students[$key]['name'] = $user_details['name'];
			$students[$key]['email'] = $user_details['email'];
			$students[$key]['role'] = $user_details['role'];
			$students[$key]['address'] = $user_details['address'];
			$students[$key]['phone'] = $user_details['phone'];
			$students[$key]['birthday'] = $user_details['birthday'];
			$students[$key]['gender'] = $user_details['gender'];
			$students[$key]['blood_group'] = $user_details['blood_group'];
			$students[$key]['class_id'] = $enrol_data['class_id'];
			$students[$key]['section_id'] = $enrol_data['section_id'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

			$students[$key]['class_name'] = $class_details['name'];
			$students[$key]['section_name'] = $section_details['name'];
		}
		return $students;
	}

	// In Array for associative array
	function is_in_array($associative_array = array(), $look_up_key = "", $look_up_value = "") {
		foreach ($associative_array as $associative) {
			$keys = array_keys($associative);
			for($i = 0; $i < count($keys); $i++){
				if ($keys[$i] == $look_up_key) {
					if ($associative[$look_up_key] == $look_up_value) {
						return true;
					}
				}
			}
		}
		return false;
	}

	function get_all_teachers($user_id = ""){
		if($user_id > 0){
			$this->db->where('id', $user_id);
		}

		$this->db->where('school_id', $this->school_id);
		$this->db->where("(role='superadmin' OR role='admin' OR role='teacher')");
		return $this->db->get_where('users');
	}
	function get_all_users($user_id = ""){
		if($user_id > 0){
			$this->db->where('id', $user_id);
		}

		$this->db->where('school_id', $this->school_id);
		return $this->db->get_where('users');
	}
        public function category_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_ar'] = html_escape($this->input->post('name_ar'));
		
		// check email duplication
		
			$this->db->insert('categories', $data);

			
			$response = array(
				'status' => true,
				'notification' => get_phrase('category_added_successfully')
			);
	

		return json_encode($response);
	}
        public function category_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('categories');

//		$this->db->where('user_id', $param1);
//		$this->db->delete('parents');

		$response = array(
			'status' => true,
			'notification' => get_phrase('category_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
        public function category_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['name_ar'] = html_escape($this->input->post('name_ar'));
		
		
			$this->db->where('id', $param1);
			$this->db->update('categories', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('category_updated_successfully')
			);
		
		

		return json_encode($response);
	}
        // -----------------------------------------------------------------
    // PROJECT CRUD FUNCTIONS
    // -----------------------------------------------------------------

    public function project_create()
    {
        // 1. Basic Fields
        $data['code']        = html_escape($this->input->post('code'));
        $data['title']       = html_escape($this->input->post('title'));
        $data['title_ar']    = html_escape($this->input->post('title_ar'));
        $data['budget']      = html_escape($this->input->post('budget'));
        
        // 2. Optional Fields (Standard for projects)
        // Check if these exist in your form, otherwise they will be inserted as NULL/Empty
        $data['description']    = $this->input->post('description'); // Usually rich text, so maybe no html_escape
        $data['description_ar'] = $this->input->post('description_ar');
        $data['category_id']    = html_escape($this->input->post('category_id'));
        $data['start_date']     = html_escape($this->input->post('start_date'));
        $data['end_date']       = html_escape($this->input->post('end_date'));
        $data['status']         = 'active';
        $data['currency'] ='USD';

        // 3. System Fields (Auto-filled)
        $data['user_id']     = $this->session->userdata('user_id'); // Created by current user
        $data['created_at']  = time(); // Current Timestamp

        // 4. Insert
        $this->db->insert('projects', $data);

        $response = array(
            'status' => true,
            'notification' => get_phrase('project_added_successfully')
        );

        return json_encode($response);
    }

    public function project_update($param1 = '')
    {
        // 1. Basic Fields
        $data['code']        = html_escape($this->input->post('code'));
        $data['title']       = html_escape($this->input->post('title'));
        $data['title_ar']    = html_escape($this->input->post('title_ar'));
        $data['budget']      = html_escape($this->input->post('budget'));

        // 2. Optional Fields
        $data['description']    = $this->input->post('description');
        $data['description_ar'] = $this->input->post('description_ar');
        $data['category_id']    = html_escape($this->input->post('category_id'));
        $data['start_date']     = html_escape($this->input->post('start_date'));
        $data['end_date']       = html_escape($this->input->post('end_date'));
        $data['currency'] ='USD';
                 //html_escape($this->input->post('currency'));
        
        // 3. System Fields
        $data['updated_at']  = time();

        // 4. Update
        $this->db->where('id', $param1);
        $this->db->update('projects', $data);

        $response = array(
            'status' => true,
            'notification' => get_phrase('project_updated_successfully')
        );

        return json_encode($response);
    }

    public function project_delete($param1 = '')
    {
        // 1. Delete the project
        $this->db->where('id', $param1);
        $this->db->delete('projects');

        // 2. Optional: Delete related funding or documents if needed
        // $this->db->where('project_id', $param1);
        // $this->db->delete('project_funding');
        // $this->db->delete('project_documents');

        $response = array(
            'status' => true,
            'notification' => get_phrase('project_deleted_successfully')
        );

        return json_encode($response);
    }
    // -----------------------------------------------------------------
    // PROJECT FUNDING CRUD
    // -----------------------------------------------------------------

    public function funding_create($project_id = '')
    {
     
        $project = $this->db->get_where('projects', array('id' => $project_id))->row_array();
    $total_budget = (float)$project['budget'];

    // 3. Calculate Current Total Funding already committed to this project
    $this->db->select_sum('amount');
    $this->db->where('project_id', $project_id);
    $funded_query = $this->db->get('project_funding')->row();
    $already_funded = (float)$funded_query->amount;

    // 4. Get New Amount from POST
    $new_amount = (float)$this->input->post('amount');

    // 5. VALIDATION: Check if (Existing + New) > Budget
    if (($already_funded + $new_amount) > $total_budget) {
        $remaining_allowed = $total_budget - $already_funded;
        
        return json_encode(array(
            'status' => false,
            'notification' => get_phrase('total_funding_exceeds_budget') . '. ' . 
                              get_phrase('remaining_limit') . ': ' . number_format($remaining_allowed, 2) . ' ' . $project['currency']
        ));
    }
        $data['project_id']     = $project_id;
        $data['donor_id']       = html_escape($this->input->post('donor_id'));
        $data['funding_type']   = html_escape($this->input->post('funding_type'));
        $data['amount']         = html_escape($this->input->post('amount'));
        $data['percentage']     = html_escape($this->input->post('percentage'));
        $data['agreement_date'] = html_escape($this->input->post('agreement_date'));
        
        // Optional: Set default currency if not provided (or fetch from project)
        $data['currency']       = 'USD'; 
        $data['created_at']     = time();

        $this->db->insert('project_funding', $data);

        $response = array(
            'status' => true,
            'notification' => get_phrase('funding_added_successfully')
        );

        return json_encode($response);
    }
    

    public function funding_update($funding_id = '')
    {
        $data['donor_id']       = html_escape($this->input->post('donor_id'));
        $data['funding_type']   = html_escape($this->input->post('funding_type'));
        $data['amount']         = html_escape($this->input->post('amount'));
        $data['percentage']     = html_escape($this->input->post('percentage'));
        $data['agreement_date'] = html_escape($this->input->post('agreement_date'));
        
        // We usually don't update created_at, but we might update a 'updated_at' column if it exists
        // $data['updated_at'] = time();

        $this->db->where('id', $funding_id);
        $this->db->update('project_funding', $data);

        $response = array(
            'status' => true,
            'notification' => get_phrase('funding_updated_successfully')
        );

        return json_encode($response);
    }

    public function funding_delete($funding_id = '')
    {
        $this->db->where('id', $funding_id);
        $this->db->delete('project_funding');

        $response = array(
            'status' => true,
            'notification' => get_phrase('funding_deleted_successfully')
        );

        return json_encode($response);
    }
public function get_comments_tree($resource_type, $resource_id) {
    // Add users.address as user_address to the select
    $this->db->select('comments.*, users.name as user_name, users.id as user_id, users.role as user_role, users.address as user_address');
    $this->db->select('donors.abbr as donor_abbr, ministries.abbr as ministry_abbr');
    $this->db->from('comments');
    $this->db->join('users', 'users.id = comments.user_id');
    
    $this->db->join('donors', 'donors.id = users.school_id AND users.role = "donor"', 'left');
    $this->db->join('ministries', 'ministries.id = users.school_id AND users.role = "admin"', 'left');
    
    $this->db->where('resource_type', $resource_type);
    $this->db->where('resource_id', $resource_id);
    $this->db->order_by('created_at', 'ASC');
    $all_comments = $this->db->get()->result_array();

    $tree = [];
    $processed_comments = [];

    foreach ($all_comments as $comment) {
        $abbr = '';
        if ($comment['user_role'] == 'superadmin') { $abbr = 'SA'; }
        elseif ($comment['user_role'] == 'donor') { $abbr = $comment['donor_abbr']; }
        elseif ($comment['user_role'] == 'admin') { $abbr = $comment['ministry_abbr']; }
        
        $comment['inst_abbr'] = $abbr;
        $comment['replies'] = [];
        $processed_comments[$comment['id']] = $comment;
    }

    foreach ($processed_comments as $id => &$comment) {
        if ($comment['parent_id'] == 0) {
            $tree[$id] = &$comment;
        } else {
            if (isset($processed_comments[$comment['parent_id']])) {
                $processed_comments[$comment['parent_id']]['replies'][] = &$comment;
            }
        }
    }
    return $tree;
}
// Application/models/User_model.php

public function notify_users_on_comment($sender_id, $resource_type, $resource_id)
{
    
    // 1. Get Sender Name
    $sender = $this->db->get_where('users', ['id' => $sender_id])->row_array();
    $sender_name = $sender['name'];

    // 2. Get Resource Title (Project Name) for the message
    $resource_title = 'Item';
    if ($resource_type == 'project') {
        $project = $this->db->get_where('projects', ['id' => $resource_id])->row_array();
        // Use Arabic title if main title is empty, or default to generic
        $resource_title = !empty($project['title']) ? $project['title'] : ($project['title_ar'] ?? 'Project');
    } elseif ($resource_type == 'meeting') {
        $meeting = $this->db->get_where('event_calendars', ['id' => $resource_id])->row_array();
        $resource_title = $meeting['title'];
    }

    // 3. Construct the Notification Message
    // Ex: "Admin commented on: Solar Energy Project"
    $message = $sender_name . ' ' . get_phrase('commented_on') . ': ' . $resource_title;

    // 4. Get ALL users EXCEPT the sender
    $this->db->where('id !=', $sender_id);
 //   $this->db->where('status', 1); // Only active users
    $recipients = $this->db->get('users')->result_array();
 
    // 5. Prepare Data for Batch Insert
    $notifications = [];
    $timestamp = time();

    foreach ($recipients as $user) {
        $notifications[] = [
            'user_id'    => $user['id'],      // The Receiver
            'notice_id'  => $resource_id,     // The Project/Meeting ID (to link to details)
            'message'    => $message,
            'status'     => 'unread',                // 0 = Unread
            'created_at' => $timestamp
        ];
    }
   
    // 6. Insert All at Once (Efficient)
    if (!empty($notifications)) {
        $this->db->insert_batch('notifications', $notifications);
    }
}
public function create_notice_and_notify($sender_id, $resource_type, $resource_id, $comment_content)
{
    // ---------------------------------------------------------
    // 1. PREPARE DATA (Sender Name & Resource Title)
    // ---------------------------------------------------------
    $sender = $this->db->get_where('users', ['id' => $sender_id])->row_array();
    $sender_name = $sender['name'];

    // Get Project/Meeting Title
    $title_prefix = '';
    if ($resource_type == 'project') {
        $project = $this->db->get_where('projects', ['id' => $resource_id])->row_array();
        // Use Arabic title if main is empty
        $resource_name = !empty($project['title']) ? $project['title'] : ($project['title_ar'] ?? 'Project');
        $title_prefix = get_phrase('project_update');
    } elseif ($resource_type == 'meeting') {
        $meeting = $this->db->get_where('event_calendars', ['id' => $resource_id])->row_array();
        $resource_name = $meeting['title'];
        $title_prefix = get_phrase('meeting_update');
    }

    // Format: "Project Update: Solar Energy (Comment by Admin)"
    $notice_title = $title_prefix . ': ' . $resource_name;
    
    // Format: "Admin commented: The financial report is..."
    $full_message = $sender_name . ' ' . get_phrase('commented') . ': ' . $comment_content;


    // ---------------------------------------------------------
    // 2. INSERT INTO NOTICEBOARD
    // ---------------------------------------------------------
    $notice_data = array(
        'notice_title'    => $notice_title,
        'notice'          => $full_message, // Store the comment content here
        'date'            => date('m/d/Y'), // Standard date format
        'status'          => 1,
        'show_on_website' => 0, // Internal only
        'image'           => '',
        'school_id'       => school_id(),
        'session'         => active_session()
    );

    $this->db->insert('noticeboard', $notice_data);
    
    // *** CRITICAL STEP: GET THE NEW ID ***
    $new_notice_id = $this->db->insert_id();


    // ---------------------------------------------------------
    // 3. SEND NOTIFICATIONS TO USERS
    // ---------------------------------------------------------
    
    // Get all active users EXCEPT the sender
    $this->db->where('id !=', $sender_id);
    //$this->db->where('status', 1);
    // Optional: Filter by school_id if multi-tenant
    //$this->db->where('school_id', school_id()); 
    $recipients = $this->db->get('users')->result_array();

    $notifications = [];
    $timestamp = time();

    foreach ($recipients as $user) {
        $notifications[] = [
            'user_id'    => $user['id'],
            'notice_id'  => $new_notice_id, // <--- Using the ID from Step 2
            'message'    => $notice_title,  // Short title for the notification popup
            'status'     => 'unread',              // Unread
            'created_at' => $timestamp
        ];
    }

    if (!empty($notifications)) {
        $this->db->insert_batch('notifications', $notifications);
    }
}
public function funding_create_donor($project_id = '')
{
    // 1. Get the Donor ID (Institution ID) from the current user's session
    $donor_id = $this->session->userdata('school_id');

    // Safety check: ensure the donor_id exists
    if (empty($donor_id)) {
        return json_encode(array(
            'status' => false,
            'notification' => get_phrase('error_no_institution_linked_to_this_account')
        ));
    }

    // 2. Fetch Project Budget
    $project = $this->db->get_where('projects', array('id' => $project_id))->row_array();
    $total_budget = (float)$project['budget'];

    // 3. Calculate Current Total Funding already committed to this project
    $this->db->select_sum('amount');
    $this->db->where('project_id', $project_id);
    $funded_query = $this->db->get('project_funding')->row();
    $already_funded = (float)$funded_query->amount;

    // 4. Get New Amount from POST
    $new_amount = (float)$this->input->post('amount');

    // 5. VALIDATION: Check if (Existing + New) > Budget
    if (($already_funded + $new_amount) > $total_budget) {
        $remaining_allowed = $total_budget - $already_funded;
        
        return json_encode(array(
            'status' => false,
            'notification' => get_phrase('total_funding_exceeds_budget') . '. ' . 
                              get_phrase('remaining_limit') . ': ' . number_format($remaining_allowed, 2) . ' ' . $project['currency']
        ));
    }

    // 6. Prepare Data
    $data['project_id']     = $project_id;
    $data['donor_id']       = $donor_id; // Using the school_id from session
    $data['funding_type']   = html_escape($this->input->post('funding_type'));
    $data['amount']         = $new_amount;
    $data['percentage']     = html_escape($this->input->post('percentage'));
    $data['agreement_date'] = html_escape($this->input->post('agreement_date'));
    $data['currency']       = $project['currency']; 
    $data['created_at']     = time();

    // 7. Insert into Database
    $this->db->insert('project_funding', $data);

    return json_encode(array(
        'status' => true,
        'notification' => get_phrase('funding_added_successfully')
    ));
}
public function project_document_create($project_id = '')
{
    // Enable debugging (remove in production)
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // 1. Check if file exists
    if (!isset($_FILES['document_file'])) {
        return json_encode([
            'status' => false,
            'notification' => get_phrase('please_select_a_file')
        ]);
    }

    // 2. Handle PHP upload errors
    if ($_FILES['document_file']['error'] !== UPLOAD_ERR_OK) {

        $error_messages = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL    => 'File partially uploaded',
            UPLOAD_ERR_NO_FILE    => 'No file selected',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file',
            UPLOAD_ERR_EXTENSION  => 'Upload blocked by extension'
        ];

        $error_code = $_FILES['document_file']['error'];

        return json_encode([
            'status' => false,
            'notification' => $error_messages[$error_code] ?? 'Unknown upload error'
        ]);
    }

    // 3. Validate file size (20 MB)
    $max_size = 20 * 1024 * 1024; // 20 MB
    if ($_FILES['document_file']['size'] > $max_size) {
        return json_encode([
            'status' => false,
            'notification' => 'File size exceeds 20 MB'
        ]);
    }

    // 4. Validate file extension
    $file_name = $_FILES['document_file']['name'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_types = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip'];

    if (!in_array($ext, $allowed_types)) {
        return json_encode([
            'status' => false,
            'notification' => get_phrase('file_type_not_allowed')
        ]);
    }

    // 5. Prepare DB data
    $new_file_name = 'doc_' . time() . '.' . $ext;

    $data = [
        'project_id'  => $project_id,
        'title'       => html_escape($this->input->post('title')),
        'file_name'   => $new_file_name,
        'file_type'   => $ext,
        'uploaded_by' => $this->session->userdata('user_id'),
        'created_at'  => time()
    ];

    // 6. Create folders
    $base_path = 'uploads/project_documents/';
    $project_folder = $base_path . $project_id;

    if (!is_dir($project_folder)) {
        mkdir($project_folder, 0777, true);
    }

    // 7. Move uploaded file
    $upload_path = $project_folder . '/' . $new_file_name;

    if (!move_uploaded_file($_FILES['document_file']['tmp_name'], $upload_path)) {
        return json_encode([
            'status' => false,
            'notification' => 'Failed to move uploaded file'
        ]);
    }

    // 8. Insert into database
    $this->db->insert('project_documents', $data);

    return json_encode([
        'status' => true,
        'notification' => get_phrase('document_uploaded_successfully')
    ]);
}

public function currency_create()
{
    $data['name']   = html_escape($this->input->post('name'));
    $data['code']   = html_escape($this->input->post('code'));
    $data['symbol'] = html_escape($this->input->post('symbol'));
$data['paypal_supported']=1;
    // Check if currency code already exists
    $check_duplicate = $this->db->get_where('currencies', ['code' => $data['code']])->num_rows();

    if ($check_duplicate > 0) {
        $response = array(
            'status' => false,
            'notification' => get_phrase('currency_code_already_exists')
        );
    } else {
        $this->db->insert('currencies', $data);
        $response = array(
            'status' => true,
            'notification' => get_phrase('currency_added_successfully')
        );
    }

    return json_encode($response);
}
public function currency_update($param1 = '')
{
    $data['name']   = html_escape($this->input->post('name'));
    $data['code']   = html_escape($this->input->post('code'));
    $data['symbol'] = html_escape($this->input->post('symbol'));

    $this->db->where('id', $param1);
    $this->db->update('currencies', $data);

    $response = array(
        'status' => true,
        'notification' => get_phrase('currency_updated_successfully')
    );

    return json_encode($response);
}
public function currency_delete($param1 = '')
{
    $this->db->where('id', $param1);
    $this->db->delete('currencies');

    $response = array(
        'status' => true,
        'notification' => get_phrase('currency_deleted_successfully')
    );

    return json_encode($response);
}

public function institution_create()
{
    $data['name']     = html_escape($this->input->post('name'));
    $data['name_ar']  = html_escape($this->input->post('name_ar'));
    $data['abbr']     = html_escape($this->input->post('abbr'));
    $data['abbr_ar']  = html_escape($this->input->post('abbr_ar'));
    
    
    $data['email']    = html_escape($this->input->post('email'));
    $data['website']  = html_escape($this->input->post('website'));

    // Check if institution/donor email already exists
   
        $this->db->insert('donors', $data);
        $response = array(
            'status' => true,
            'notification' => get_phrase('institution_added_successfully')
        );
    

    return json_encode($response);
}

public function institution_update($param1 = '')
{
    $data['name']     = html_escape($this->input->post('name'));
    $data['name_ar']  = html_escape($this->input->post('name_ar'));
    $data['abbr']     = html_escape($this->input->post('abbr'));
    $data['abbr_ar']  = html_escape($this->input->post('abbr_ar'));
    $data['email']    = html_escape($this->input->post('email'));
    $data['website']  = html_escape($this->input->post('website'));

    $this->db->where('id', $param1);
    $this->db->update('donors', $data);

    $response = array(
        'status' => true,
        'notification' => get_phrase('institution_updated_successfully')
    );

    return json_encode($response);
}

public function institution_delete($param1 = '')
{
    $this->db->where('id', $param1);
    $this->db->delete('donors');

    $response = array(
        'status' => true,
        'notification' => get_phrase('institution_deleted_successfully')
    );

    return json_encode($response);
}
public function ministry_create()
{
    $data['name']    = html_escape($this->input->post('name'));
    $data['name_ar'] = html_escape($this->input->post('name_ar'));
    $data['abbr']    = html_escape($this->input->post('abbr'));
    $data['abbr_ar'] = html_escape($this->input->post('abbr_ar'));
    $data['email']   = html_escape($this->input->post('email'));
    $data['website'] = html_escape($this->input->post('website'));
    $data['created_at'] = time();

    $this->db->insert('ministries', $data);
    
    return json_encode([
        'status' => true,
        'notification' => get_phrase('ministry_added_successfully')
    ]);
}

public function ministry_update($id)
{
    $data['name']    = html_escape($this->input->post('name'));
    $data['name_ar'] = html_escape($this->input->post('name_ar'));
    $data['abbr']    = html_escape($this->input->post('abbr'));
    $data['abbr_ar'] = html_escape($this->input->post('abbr_ar'));
    $data['email']   = html_escape($this->input->post('email'));
    $data['website'] = html_escape($this->input->post('website'));

    $this->db->where('id', $id);
    $this->db->update('ministries', $data);

    return json_encode([
        'status' => true,
        'notification' => get_phrase('ministry_updated_successfully')
    ]);
}

public function ministry_delete($id)
{
    $this->db->where('id', $id);
    $this->db->delete('ministries');
    
    return json_encode([
        'status' => true,
        'notification' => get_phrase('ministry_deleted_successfully')
    ]);
}

}
