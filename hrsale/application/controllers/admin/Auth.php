<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends MY_Controller
{
	public function __construct(){
    parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Employees_model');
		$this->load->model('Users_model');
		$this->load->library('email');
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
  }

	 /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function logout_sso(){
		$loginURL = base_url().'admin';
		if(!empty($this->session->access_profile)){
			$profile=$this->session->access_profile;
			$username=$profile->emails[0]->value; // using employee's email.
			$result=$this->Login_model->read_user_sso_by_email($username);
			if(!empty($result)){
				$data['title']='Kanon HRM';
				$session=$this->session->userdata('username');
				$last_data=array(
					'is_logged_in'=>'0',
					'last_logout_date'=>date('d-m-Y H:i:s')
				);
				$this->Employees_model->update_record($last_data, $session['user_id']);
				$sess_array=array('username'=>'');
				$this->session->sess_destroy();
				$this->session->access_token='';
				$this->session->access_profile='';
				redirect(filter_var($loginURL,FILTER_SANITIZE_URL));
			}else{
				redirect(filter_var($loginURL,FILTER_SANITIZE_URL));
			}
		}
	}

	public function login_sso(){
		$client = new Google_Client();
		$client->setAuthConfigFile('luffy_sso_client_secret.json');
		$client->setRedirectUri(base_url()."admin/auth/login_sso");
		$client->setScopes(array(
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile",
			"https://www.googleapis.com/auth/plus.me"
		));
		if (!isset($_GET['code'])){
		  $authURL = $client->createAuthUrl();
			redirect(filter_var($authURL,FILTER_SANITIZE_URL));
		}else{
		  $client->authenticate($_GET['code']);
			$this->session->access_token=$client->getAccessToken();
		  try{
	      // store profile to sesssion :)
	      $plus=new Google_Service_Plus($client);
	      $this->session->access_profile=$plus->people->get("me");
				$profile=$this->session->access_profile;
				$SSO_email=$profile->emails[0]->value;
				$SSO_photo=$profile->image->url;
				$SSO_displayName=$profile->displayName;
				$data=array('username'=>$SSO_email);
				$result=$this->Login_model->login_sso($data);
				if($result==TRUE){
					$result=$this->Login_model->read_user_sso_by_email($SSO_email);
					$session_data=array(
						'user_id'=>$result[0]->user_id,
						'username'=>$result[0]->username,
						'email'=>$result[0]->email,
					);
					// Add user data to session
					$this->session->set_userdata('username', $session_data);
					$this->session->set_userdata('user_id', $session_data);
					// update last login info
					$ipaddress=$this->input->ip_address();
					$last_data=array(
						'last_login_date'=>date('d-m-Y H:i:s'),
						'last_login_ip'=>$ipaddress,
						'is_logged_in'=>'1',
						'profile_picture_sso'=>$SSO_photo
					);
					$id=$result[0]->user_id; // user id
					$this->Xin_model->login_update_record($last_data, $id);
				}
		  }catch (\Exception $e){
					$this->session->access_token='';
					echo $e->__toString();
					die;
		  }
			$urlAfterLogin=base_url().'admin/dashboard?module=dashboard';
			$lastUrl=$this->session->lastUrl;
			// if(!empty($lastUrl)){
			// 	redirect(filter_var($lastUrl,FILTER_SANITIZE_URL));
			// }else{
				redirect(filter_var($urlAfterLogin,FILTER_SANITIZE_URL));
			// }
		}
	}

	public function login(){
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($username==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} elseif($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!='')
			$this->output($Return);
		$data = array(
			'username'=>$username,
			'password'=>$password
		);
		$result = $this->Login_model->login($data);
		if ($result==TRUE){
			$result = $this->Login_model->read_user_information($username);
			$session_data = array(
			'user_id' => $result[0]->user_id,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			);
			// Add user data in session
			$this->session->set_userdata('username', $session_data);
			$this->session->set_userdata('user_id', $session_data);
			$Return['result']=$this->lang->line('xin_success_logged_in');
			// update last login info
			$ipaddress = $this->input->ip_address();
			 $last_data = array(
				'last_login_date' => date('d-m-Y H:i:s'),
				'last_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			);
			$id = $result[0]->user_id; // user id
			$this->Xin_model->login_update_record($last_data, $id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}else{
			$Return['error']=$this->lang->line('xin_error_invalid_credentials');
			/*Return*/
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$this->output($Return);
		}
	}

	// forgot password.
	public function forgot_password(){
		$data['title'] = $this->lang->line('xin_forgot_password_link');
		$this->load->view('admin/auth/forgot_password', $data);
	}

	// unlock user.
	public function lock(){
		$session_id = $this->session->userdata('user_id');
		$data['title'] = $this->lang->line('xin_lock_user');
		$session = $this->session->userdata('username');
		$this->session->unset_userdata('username');
		$Return['result'] = 'Locked User.';
		$this->load->view('admin/auth/user_lock', $data);
	}

	//unlock user.
	public function unlock() {
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$password = $this->input->post('ipassword');
		$session_id = $this->session->userdata('user_id');
		$iresult = $this->Login_model->read_user_info_session_id($session_id['user_id']);
		/* Server side PHP input validation */
		if($password===''){
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$username = $iresult[0]->username;
		$data = array(
			'username' => $username,
			'password' => $password
			);
		$result = $this->Login_model->login($data);

		if ($result == TRUE) {
			$result = $this->Login_model->read_user_information($username);
			$session_data = array(
			'user_id' => $result[0]->user_id,
			'username' => $result[0]->username,
			'email' => $result[0]->email,
			);
			// put user data to session
			$this->session->set_userdata('username', $session_data);
			$this->session->set_userdata('user_id', $session_data);
			$Return['result'] = $this->lang->line('xin_success_logged_in');
			// update last login info
			$ipaddress = $this->input->ip_address();
			$last_data = array(
				'last_login_date' => date('d-m-Y H:i:s'),
				'last_login_ip' => $ipaddress,
				'is_logged_in' => '1'
			);
			$id = $result[0]->user_id; // user id
			$this->Xin_model->login_update_record($last_data, $id);
			$this->output($Return);
		} else {
			$Return['error'] = $this->lang->line('xin_error_invalid_credentials');
			$this->output($Return);
		}
	}

	public static function AlphaNumeric($length){
    $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $clen   = strlen( $chars )-1;
    $id  = '';
    for ($i = 0; $i < $length; $i++) {
    	$id .= $chars[mt_rand(0,$clen)];
    }
    return ($id);
  }

	public function send_mail() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */
		if($this->input->post('iemail')==='') {
			$Return['error'] = $this->lang->line('xin_error_enter_email_address');
		} else if(!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		if($this->input->post('iemail')) {
			$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(2);
			//get employee info
			$query = $this->Xin_model->read_user_info_byemail($this->input->post('iemail'));
			$user = $query->num_rows();
			if($user > 0) {
				$user_info = $query->result();
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/signin/'.$cinfo[0]->sign_in_logo;
				//$cid = $this->email->attachment_cid($logo);
				$password = $this->AlphaNumeric(15);
				$options = array('cost' => 12);
				$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
				$last_data = array(
					'password' => $password_hash,
				);
				$id = $user_info[0]->user_id; // user id
				$this->Xin_model->login_update_record($last_data, $id);
				$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->username,$user_info[0]->email,$password),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
				$this->email->to($this->input->post('iemail'));
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
				$Return['result'] = $this->lang->line('xin_success_sent_forgot_password');
			} else {
				/* Unsuccessful attempt: Set error message */
				$Return['error'] = $this->lang->line('xin_error_email_addres_not_exist');
			}
			$this->output($Return);
			exit;
		}
	}
}
?>
