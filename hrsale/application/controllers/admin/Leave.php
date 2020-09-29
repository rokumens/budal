<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function __construct(){
    parent::__construct();
    //load the login model
    $this->load->model('Company_model');
	  $this->load->model('Xin_model');
	  $this->load->model('Timesheet_model');
		// $this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
  }

	//leave calendar
	public function calendar() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_leave_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_leave_calendar');
		$data['path_url'] = 'calendar_leave';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('102',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/leave/leave_calendar", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
}
?>
