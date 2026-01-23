<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Email_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}

	function account_opening_email($account_type = '' , $email = '', $password = '')
	{
		$system_name	=	get_settings('system_name');

		$email_msg		=	"Welcome to ".$system_name."<br />";
		$email_msg		.=	"Your account type : ".$account_type."<br />";
		$email_msg		.=	"Your login password : ". $password ."<br />";
		$email_msg		.=	"Login Here : ".base_url()."<br />";

		$email_sub		=	"Account opening email";
		$email_to		=	$email;

		if (get_smtp('mail_sender') == 'php_mailer') {
			$this->send_mail_using_php_mailer($email_msg , $email_sub , $email_to);
		}else{
			$this->send_mail_using_smtp($email_msg , $email_sub , $email_to);
		}
	}

	function password_reset_email($new_password = '' , $user_id = "")
	{
		$query			=	$this->db->get_where('users' , array('id' => $user_id))->row_array();
		if(sizeof($query) > 0)
		{

			$email_msg	=	"Your account type is : ".ucfirst($query['role'])."<br />";
			$email_msg	.=	"Your password is : ".$new_password."<br />";

			$email_sub	=	"Password reset request";
			$email_to	=	$query['email'];

			if (get_smtp('mail_sender') == 'php_mailer') {
				$this->send_mail_using_php_mailer($email_msg , $email_sub , $email_to);
			}else{
				$this->send_mail_using_smtp($email_msg , $email_sub , $email_to);
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function contact_message_email($email_from, $email_to, $email_message) {
		$email_sub = "Message from School Website";

		if (get_smtp('mail_sender') == 'php_mailer') {
			$this->send_mail_using_php_mailer($email_message, $email_sub, $email_to, $email_from);
		}else{
			$this->send_mail_using_smtp($email_message, $email_sub, $email_to, $email_from);
		}
	}

	function personal_message_email($email_from, $email_to, $email_message) {
		$email_sub = "Message from School Website";

		if (get_smtp('mail_sender') == 'php_mailer') {
			$this->send_mail_using_php_mailer($email_message, $email_sub, $email_to, $email_from);
		}else{
			$this->send_mail_using_smtp($email_message, $email_sub, $email_to, $email_from);
		}
	}

	function request_book_email($student_id){
		$student_details = $this->user_model->get_student_details_by_id('student', $student_id);
		$student_name = $student_details['name'];
		$student_code = $student_details['code'];
		$email_message  = '<html><body><p>'.$student_name.' has been requested you, for the book.'.'</p><br><p>Student Code : '.$student_code.'</p></body></html>';
		$email_sub		= 'New book issued';
		$this->db->limit(1);
		$librarians = $this->db->get('librarian')->result_array();
		foreach($librarians as $librarian){
			$email_to = $librarian['email'];
		}
		$this->send_mail_using_smtp($email_message, $email_sub, $email_to);
	}

	function approved_online_admission($student_id = "", $user_id = "", $password = ""){
		$student_details = $this->user_model->get_student_details_by_id('student', $student_id);
		$student_email = $student_details['email'];
		$student_name = $student_details['name'];
		$student_code = $student_details['code'];
		$email_message  = '<html><body><p> Your admission request has been accepted.'.'</p><br><p>Student Code : '.$student_code.'</p><p>Email : '.$student_email.'</p><p>Password : '.$password.'</p></body></html>';
		$email_sub		= 'Admission approval';
		$email_to = $student_email;
		

		$this->send_mail_using_smtp($email_message, $email_sub, $email_to);
	}

	function approved_online_admission_parent_access($user_id = "", $password = ""){
		$parent_details = $this->db->get_where('users', array('id' => $user_id))->row_array();
		$email = $parent_details['email'];
		$email_message  = "<html><body><p> Your son/daughter's admission has been accepted.".'</p><br><p>Your account access-</p><p>Email : '.$email.'</p><p>Password : '.$password.'</p></body></html>';
		$email_sub		= 'Admission approval';
		$email_to = $email;
		

		$this->send_mail_using_smtp($email_message, $email_sub, $email_to);
	}


	//SEND MARKS VIA MAIL
	function send_marks_email($email_msg=NULL, $email_sub=NULL, $email_to=NULL)
	{
		if (get_smtp('mail_sender') == 'php_mailer') {
			$this->send_mail_using_php_mailer($email_msg , $email_sub , $email_to);
		}else{
			$this->send_mail_using_smtp($email_msg , $email_sub , $email_to);
		}
		return true;
	}
	// more stable function
	public function send_mail_using_smtp($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
    // 1. Load email library
    $this->load->library('email');

    // 2. Configuration
    // I hardcoded the user here to ensure it matches the 'From' address exactly (Required for Office 365)
    $config = array(
        'protocol'    => 'smtp',
        'smtp_host'   => 'smtp.office365.com',
        'smtp_port'   => '587',
        'smtp_user'   => 'contact@jcp.gov.mr', // <--- HARDCODED TO MATCH FROM
        'smtp_pass'   => get_smtp('smtp_password'),
        'smtp_crypto' => 'tls',
        'mailtype'    => 'html',
        'charset'     => 'utf-8',
        'newline'     => "\r\n",
        'crlf'        => "\r\n",
        'wordwrap'    => TRUE,
        'wordwrap'    => FALSE, 
        'smtp_timeout'=> 30
    );

    // 3. Initialize
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");

    // 4. Set Content
    // Valid From Address
    $this->email->from('contact@jcp.gov.mr', 'Joint Coordination Platform'); 
    $this->email->to((string)$to); 
    $this->email->subject($sub);
    $this->email->message($msg);

    // 5. Send Email (ONLY ONCE)
    if (!$this->email->send()) {
        // If sending fails, show debug info and stop
         echo $this->email->print_debugger(); 
        die();
    }

    return true;
}
	public function send_mail_using_php_mailer($message=NULL, $subject=NULL, $to=NULL, $from=NULL) {
		// Load PHPMailer library
		$this->load->library('phpmailer_lib');

		// PHPMailer object
		$mail = $this->phpmailer_lib->load();

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host       = get_smtp('smtp_host');
		$mail->SMTPAuth   = true;
		$mail->Username   = get_smtp('smtp_username');
		$mail->Password   = get_smtp('smtp_password');
		$mail->SMTPSecure = get_smtp('smtp_secure');
		$mail->Port       = get_smtp('smtp_port');

		$mail->setFrom(get_smtp('smtp_username'), get_smtp('smtp_set_from'));
		$mail->addReplyTo(get_settings('system_email'), get_settings('system_name'));

		// Add a recipient
		$mail->addAddress($to);

		// Email subject
		$mail->Subject = $subject;

		// Set email format to HTML
		$mail->isHTML(true);

		// Enabled debug
		$mail->SMTPDebug = false;

		// Email body content
		$mailContent = $message;
		$mail->Body = $mailContent;

		// Send email
		if(!$mail->send()){
			// echo 'Message could not be sent.';
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent';
			return true;
		}
	}
        // NEW FUNCTION: Send Welcome Email to Donor (Bilingual)
    public function send_donor_welcome_email($name, $email, $password)
    {
        $login_url = site_url('login');
        $system_name = get_settings('system_name');

        // Email Subject
        $subject = "Welcome to " . $system_name . " / مرحباً بكم في المنصة";

        // HTML Message Body
        $msg = '
        <div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
            
            <!-- Header -->
            <div style="background-color: #00A95C; padding: 20px; text-align: center; color: #fff;">
                <h2 style="margin: 0;">Welcome / مرحباً</h2>
            </div>

            <!-- Content Area -->
            <div style="padding: 20px;">
                
               
                <!-- Arabic Section -->
                <div style="text-align: right; direction: rtl;">
                    <p>عزيزي <strong>' . $name . '</strong>،</p>
                    <p>شكراً لتسجيلكم كشريك في <strong>' . $system_name . '</strong>.</p>
                    <p>تم إنشاء حسابكم بنجاح وهو حالياً <strong>قيد المراجعة من قبل المسؤول</strong>. سيتم إشعاركم فور تفعيل الحساب.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-right: 4px solid #00A95C;">
                        <strong>بيانات الدخول:</strong><br>
                        الرابط: <a href="' . $login_url . '">' . $login_url . '</a><br>
                        البريد الإلكتروني: ' . $email . '<br>
                        كلمة المرور: ' . $password . '
                    </p>
                </div>
                 <!-- English Section -->
                <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                    <p>Dear <strong>' . $name . '</strong>,</p>
                    <p>Thank you for registering as a partner on the <strong>' . $system_name . '</strong>.</p>
                    <p>Your account has been created successfully and is currently <strong>pending administrator approval</strong>. You will receive another notification once approved.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-left: 4px solid #00A95C;">
                        <strong>Login Credentials:</strong><br>
                        URL: <a href="' . $login_url . '">' . $login_url . '</a><br>
                        Email: ' . $email . '<br>
                        Password: ' . $password . '
                    </p>
                </div>


            </div>

            <!-- Footer -->
            <div style="background-color: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; color: #777;">
                &copy; ' . date('Y') . ' ' . $system_name . '
            </div>
        </div>';

        // Check which sending method to use
        if (get_smtp('mail_sender') == 'php_mailer') {
            $this->send_mail_using_php_mailer($msg, $subject, $email);
        } else {
            $this->send_mail_using_smtp($msg, $subject, $email);
        }
    }
   // Send Account Approved Email (Bilingual & Styled - Formal)
    public function account_approved_email($email, $name)
    {
        $login_url = site_url('login');
        $system_name = get_settings('system_name');

        // Subject
        $subject = "Account Approved / تمت الموافقة على الحساب";

        // HTML Body
        $msg = '
        <div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;">
            
            <!-- Header -->
            <div style="background-color: #00A95C; padding: 20px; text-align: center; color: #fff;">
                <h2 style="margin: 0;">Account Approved / تمت الموافقة</h2>
            </div>

            <!-- Content Area -->
            <div style="padding: 20px;">
                
<!-- Arabic Section -->
                <div style="text-align: right; direction: rtl;">
                    <p>عزيزي <strong>' . $name . '</strong>،</p>
                    <p>يسرنا إبلاغكم بأنه قد تمت <strong>الموافقة على حسابكم</strong> بنجاح من قبل إدارة المنصة: <strong>' . $system_name . '</strong>.</p>
                    <p>يمكنكم الآن تسجيل الدخول والوصول إلى كافة الخدمات المتاحة.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-right: 4px solid #00A95C;">
                        <strong>الإجراء المطلوب:</strong><br>
                        يرجى الضغط على الرابط أدناه للدخول إلى لوحة التحكم.<br>
                        <a href="' . $login_url . '">' . $login_url . '</a>
                    </p>

                    <div style="margin-top: 15px;">
                        <a href="' . $login_url . '" style="background-color: #00A95C; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">تسجيل الدخول الآن</a>
                    </div>
                </div>
                <!-- English Section -->
                <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                    <p>Dear <strong>' . $name . '</strong>,</p>
                    <p>We are pleased to inform you that your account on the <strong>' . $system_name . '</strong> has been successfully <strong>approved</strong> by the administrator.</p>
                    <p>You can now log in to the platform and access all features.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-left: 4px solid #00A95C;">
                        <strong>Action Required:</strong><br>
                        Please click the button below to access your dashboard.<br>
                        <a href="' . $login_url . '">' . $login_url . '</a>
                    </p>

                    <div style="margin-top: 15px;">
                        <a href="' . $login_url . '" style="background-color: #00A95C; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Login to Dashboard</a>
                    </div>
                </div>

                

            </div>

            <!-- Footer -->
            <div style="background-color: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #777;">
                &copy; ' . date('Y') . ' ' . $system_name . '
            </div>
        </div>';

        // Send based on configuration
        if (get_smtp('mail_sender') == 'php_mailer') {
            $this->send_mail_using_php_mailer((string)$msg, (string)$subject, (string)$email);
        } else {
            $this->send_mail_using_smtp((string)$msg, (string)$subject, (string)$email);
        }
    }
    public function send_ministry_welcome_email($name, $email, $password)
    {
        $login_url = site_url('login');
        $system_name = get_settings('system_name');

        // Email Subject
        $subject = "Ministry Account Request / طلب حساب وزاري";

        // HTML Message Body
        $msg = '
        <div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
            
            <!-- Header -->
            <div style="background-color: #00A95C; padding: 20px; text-align: center; color: #fff;">
                <h2 style="margin: 0;">Welcome / مرحباً</h2>
            </div>

            <!-- Content Area -->
            <div style="padding: 20px;">
                
                <!-- Arabic Section (First) -->
                <div style="text-align: right; direction: rtl; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px;">
                    <p>عزيزي <strong>' . $name . '</strong>،</p>
                    <p>تم استلام طلبكم لإنشاء <strong>حساب وزاري</strong> في <strong>' . $system_name . '</strong> بنجاح.</p>
                    <p>حسابكم حالياً <strong>قيد المراجعة والتحقق</strong> من قبل إدارة النظام. سيتم تفعيله وإشعاركم عبر البريد الإلكتروني فور الموافقة عليه.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-right: 4px solid #00A95C;">
                        <strong>بيانات الدخول المسجلة:</strong><br>
                        الرابط: <a href="' . $login_url . '">' . $login_url . '</a><br>
                        البريد الإلكتروني: ' . $email . '<br>
                        كلمة المرور: ' . $password . '
                    </p>
                </div>

                <!-- English Section (Second) -->
                <div style="text-align: left; direction: ltr;">
                    <p>Dear <strong>' . $name . '</strong>,</p>
                    <p>Your request for a <strong>Ministry Account</strong> on the <strong>' . $system_name . '</strong> has been received successfully.</p>
                    <p>Your account is currently <strong>pending administrator verification</strong>. It will be activated, and you will be notified via email once approved.</p>
                    
                    <p style="background: #f9f9f9; padding: 10px; border-left: 4px solid #00A95C;">
                        <strong>Registered Credentials:</strong><br>
                        URL: <a href="' . $login_url . '">' . $login_url . '</a><br>
                        Email: ' . $email . '<br>
                        Password: ' . $password . '
                    </p>
                </div>

            </div>

            <!-- Footer -->
            <div style="background-color: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; color: #777;">
                &copy; ' . date('Y') . ' ' . $system_name . '
            </div>
        </div>';

        // Check which sending method to use
        if (get_smtp('mail_sender') == 'php_mailer') {
            $this->send_mail_using_php_mailer((string)$msg, (string)$subject, (string)$email);
        } else {
            $this->send_mail_using_smtp((string)$msg, (string)$subject, (string)$email);
        }
    }
    public function notify_admins_of_registration($admin_email, $new_user_name, $new_user_role)
{
    $system_name = get_settings('system_name');
    $time = date('Y-m-d H:i:s');
    
    // Bilingual Subject
    $subject = "تنبيه: تسجيل مستخدم جديد / New User Registration Alert";

    $msg = '
    <div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #ffffff; overflow: hidden;">
        
        <!-- Header -->
        <div style="background-color: #727cf5; padding: 20px; text-align: center; color: #fff;">
            <h2 style="margin: 0; font-size: 20px;">' . $subject . '</h2>
        </div>

        <div style="padding: 20px;">
            
            <!-- Arabic Section (First) -->
            <div style="text-align: right; direction: rtl; border-bottom: 2px solid #f1f1f1; padding-bottom: 20px; margin-bottom: 20px;">
                <p style="font-size: 16px;">لقد قام مستخدم جديد بالتسجيل في منصة <strong>' . $system_name . '</strong> وهو بانتظار المراجعة والموافقة.</p>
                
                <table style="width: 100%; direction: rtl; border-collapse: collapse; margin-top: 10px;">
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; width: 30%;"><strong>الاسم:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . $new_user_name . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>الدور:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . ($new_user_role == "donor" ? "مانح" : "وزارة") . ' (' . $new_user_role . ')</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>الوقت:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; direction: ltr; text-align: right;">' . $time . '</td>
                    </tr>
                </table>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="' . site_url('login') . '" style="background-color: #727cf5; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">مراجعة المستخدم في لوحة التحكم</a>
                </div>
            </div>

            <!-- English Section -->
            <div style="text-align: left; direction: ltr;">
                <p style="font-size: 15px; color: #666;">A new user has registered on the <strong>' . $system_name . '</strong> platform and is awaiting your approval.</p>
                
                <table style="width: 100%; border-collapse: collapse; color: #666;">
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; width: 30%;"><strong>Name:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . $new_user_name . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Role:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . ucfirst($new_user_role) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Time:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . $time . '</td>
                    </tr>
                </table>
                
                <p style="margin-top: 15px; font-size: 13px;">Please log in to the admin panel to review the account details.</p>
            </div>

        </div>

        <!-- Footer -->
        <div style="background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eee;">
            &copy; ' . date('Y') . ' ' . $system_name . ' | Automated Notification
        </div>
    </div>';

    // Send using your preferred method
    if (get_smtp('mail_sender') == 'php_mailer') {
        $this->send_mail_using_php_mailer((string)$msg, (string)$subject, (string)$admin_email);
    } else {
        $this->send_mail_using_smtp((string)$msg, (string)$subject, (string)$admin_email);
    }
}
}
