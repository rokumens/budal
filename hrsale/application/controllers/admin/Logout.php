<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller
{
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function __construct() {
		parent::__construct();
		//load the login model
		$this->load->model('Login_model');
		$this->load->model('Employees_model');
		date_default_timezone_set("Asia/Jakarta");
	}

	// Logout from admin page
	public function index() {
		// Removing session data
		if(!empty($_SESSION['username'])){
			$data['title'] = 'Kanon HRM';
			$session = $this->session->userdata('username');
			$last_data = array(
				'is_logged_in' => '0',
				'last_logout_date' => date('d-m-Y H:i:s')
			);
			$this->Employees_model->update_record($last_data, $session['user_id']);
			$sess_array = array('username' => '');
			$this->session->sess_destroy();
		}
		//sso logout
		if(!empty($_SESSION['access_token'])){
			unset($_SESSION['access_token']);
			$session_data=array('sess_logged_in'=>0);
			$this->session->set_userdata($session_data);
		}
		$Return['result'] = 'Successfully Logout.';
		redirect('admin/', 'refresh');
	}
}
?>
