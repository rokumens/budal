<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller
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
	  $this->load->model('Events_model');
	  $this->load->model('Meetings_model');
	  $this->load->model('Department_model');
		# luffy 10 January 2020 02:31 pm
	  $this->load->model('Employees_model');
		// $this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
  }

	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_events').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_events');
		$data['path_url'] = 'events';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('98',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/events_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	//events calendar
	public function calendar() {

		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_events_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_events_calendar');
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'event_calendar';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('100',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/calendar_events", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);

		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/events/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	// events_list > Events
	 public function events_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/events/events_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$events = $this->Events_model->get_events();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

        foreach($events->result() as $r) {

			 // get start date and end date
			 $sdate = $this->Xin_model->set_date_format($r->event_date);
			 // get time am/pm
			 $event_time = new DateTime($r->event_time);
			 // get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';
			}

			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$location = $user[0]->fingerprint_location;
			} else {
				$full_name = '--';
				$location = 'X';
			}
			if(in_array('270',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light edit-data" data-toggle="modal" data-target=".edit-modal-data" data-event_id="'. $r->event_id.'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('271',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->event_id . '"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('272',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-event_id="'. $r->event_id . '"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$view.$delete;
		   $data[] = array(
				$combhr,
				$comp_name,
				$full_name,
				$location,
				$r->event_title,
				$sdate,
				$event_time->format('h:i a')
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $events->num_rows(),
			 "recordsFiltered" => $events->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }

	 // Validate and add info in database
	public function add_event() {

		if($this->input->post('add_type')=='event') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		$event_date = $this->input->post('event_date');
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		$ev_date = strtotime($event_date);
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);

		/* Server side PHP input validation */
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('event_title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_title_field');
		} else if($this->input->post('event_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_date_field');
		} else if($ev_date < $ct_date) {
			$Return['error'] = $this->lang->line('xin_error_event_date_current_date');
		} else if($this->input->post('event_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_time_field');
		}

		if($Return['error']!=''){
       		$this->output($Return);
    	}

		$data = array(
		'company_id' => $this->input->post('company_id'),
		'employee_id' => $this->input->post('employee_id'),
		'event_title' => $this->input->post('event_title'),
		'event_date' => $this->input->post('event_date'),
		'event_time' => $this->input->post('event_time'),
		'event_note' => $qt_event_note,
		'created_at' => date('Y-m-d')
		);
		$result = $this->Events_model->add($data);

		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('event_id',"DESC")->get("xin_events")->row();
			$Return['result'] = $this->lang->line('xin_hr_success_event_added');
			$Return['re_event_id'] = $row->event_id;
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// Validate and add info in database
	public function edit_event() {

		if($this->input->post('edit_type')=='event') {

		$id = $this->uri->segment(4);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		$event_date = $this->input->post('event_date');
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		$ev_date = strtotime($event_date);
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);

		/* Server side PHP input validation */
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('event_title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_title_field');
		} else if($this->input->post('event_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_date_field');
		} else if($ev_date < $ct_date) {
			$Return['error'] = $this->lang->line('xin_error_event_date_current_date');
		} else if($this->input->post('event_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_time_field');
		}

		if($Return['error']!=''){
       		$this->output($Return);
    	}

		$data = array(
		'company_id' => $this->input->post('company_id'),
		'employee_id' => $this->input->post('employee_id'),
		'event_title' => $this->input->post('event_title'),
		'event_date' => $this->input->post('event_date'),
		'event_time' => $this->input->post('event_time'),
		'event_note' => $qt_event_note
		);
		$result = $this->Events_model->update_record($data,$id);

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_success_event_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// get record of event
	public function read_event_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$event_id = $this->input->get('event_id');
		$result = $this->Events_model->read_event_information($event_id);
		$activeEmployees=$this->Employees_model->employeeActiveAPG()->result();
		$data = array(
			'event_id' => $result[0]->event_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'event_title' => $result[0]->event_title,
			'event_date' => $result[0]->event_date,
			'event_time' => $result[0]->event_time,
			'event_note' => $result[0]->event_note,
			# luffy 10 January 2020 02:33 pm
			// 'all_employees' => $this->Xin_model->all_employees(),
			'all_employees' => $activeEmployees,
			'get_all_companies' => $this->Xin_model->get_companies()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view('admin/events/dialog_events', $data);
		} else {
			redirect('admin/');
		}
	}

	public function delete_event() {
		if($this->input->post('type')=='delete') {
			// Define return | here result is used to return user data and error for error message
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Events_model->delete_event_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hr_success_event_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}



}
?>