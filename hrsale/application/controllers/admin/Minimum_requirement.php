<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Minimum_requirement extends MY_Controller {

	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Minimum_requirement_model");
		$this->load->model("Xin_model");
	}

	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = 'Requirement List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Requirement List';
		$data['path_url'] = 'minimum_requirement';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1007',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/minimum_requirement_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function minimum_requirement_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/appraisal/minimum_requirement_list", $data);
		} else {
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$minimumRequirements = $this->Minimum_requirement_model->all_minimum_requirements();
		$data = array();
		foreach($minimumRequirements->result() as $r) {
			if(in_array('2031',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-minimum_requirement_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}

			if(in_array('2032',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('2033',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-minimum_requirement_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$delete.$view;

			$data[] = array(
				$combhr,
				$r->minimum_daily_requirement,
				$r->minimum_monthly_requirement
			);
		}
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $minimumRequirements->num_rows(),
			 "recordsFiltered" => $minimumRequirements->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	// Validate and add job tasks
	public function add_minimum_requirement() {
		if($this->input->post('add_type')=='add_minimum_requirement') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
			if($this->input->post('dailyRequirement')==='') {
	        $Return['error'] = "Daily Minimum Requirement is required.";
			} else if($this->input->post('dailyRequirement')==='') {
	        $Return['error'] = "Monthly Minimum Requirement is required.";
			}
			if($Return['error']!=''){
       		$this->output($Return);
    	}
			$session = $this->session->userdata('username');
			$data = array(
				'minimum_daily_requirement' => $this->input->post('dailyRequirement'),
				'minimum_monthly_requirement' => $this->input->post('monthlyRequirement')
			);
			$result = $this->Minimum_requirement_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Appraisal added.";
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('minimum_requirement_id');
	 $result = $this->Minimum_requirement_model->read_requirement_information($id);
	 $data = array(
		 'minimum_requirement_id' => $result[0]->id,
		 'dailyRequirement'	=> $result[0]->minimum_daily_requirement,
		 'monthlyRequirement' => $result[0]->minimum_monthly_requirement
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/appraisal/dialog_minimum_requirement', $data);
	 } else {
		 redirect('admin/');
	 }
 }

	// Validate and update info in database
  public function update() {
 	 if($this->input->post('edit_type')=='minimum_requirement_update') {
 	 $id = $this->uri->segment(4);

 	 /* Define return | here result is used to return user data and error for error message */
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */
		if($this->input->post('dailyRequirement')==='') {
				$Return['error'] = "Daily Minimum Requirement is required.";
		} else if($this->input->post('dailyRequirement')==='') {
				$Return['error'] = "Monthly Minimum Requirement is required.";
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
 		$session = $this->session->userdata('username');
 		$data = array(
			'minimum_daily_requirement' => $this->input->post('dailyRequirement'),
			'minimum_monthly_requirement' => $this->input->post('monthlyRequirement')
 	 );
 	 $result = $this->Minimum_requirement_model->update_record($data,$id);
 	 if ($result == TRUE) {
 		 $Return['result'] = "Minimum requirement updated.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
 	 exit;
 	 }
  }

	public function delete() {
 	 /* Define return | here result is used to return user data and error for error message */
 	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 	 $id = $this->uri->segment(4);
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
 	 $result = $this->Minimum_requirement_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Minimum requirement deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
