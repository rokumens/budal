<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_task extends MY_Controller {

	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Appraisal_task_model");
		$this->load->model("Department_model");
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
		$data['title'] = 'Task List Setting | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['allMinimumRequirement'] = $this->Minimum_requirement_model->all_minimum_requirements()->result();
		$data['breadcrumbs'] = 'Task List Setting';
		$data['path_url'] = 'appraisal_task';	//js named di sini jg.
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1002',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/task_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function task_listzz() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/appraisal/task_list", $data);
		} else {
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$role_resources_ids = $this->Xin_model->user_role_resource();
		// if(in_array('380',$role_resources_ids)) {
		// 	$appraisal = $this->Performance_appraisal_model->get_employee_performance_appraisal($session['user_id']);
		// } else {
		// 	$appraisal = $this->Performance_appraisal_model->get_performance_appraisal();
		// }
		$appraisal = $this->Appraisal_task_model->all_appraisal_task();
		$data = array();

    foreach($appraisal->result() as $r) {
			if(in_array('2006',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-appraisal_task_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('2007',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('2008',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-appraisal_task_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$delete.$view;
			$subDept = $this->Appraisal_task_model->getDepartment($r->sub_department_id);
			$data[] = array(
				$combhr,
				$subDept->department_name,
				$r->name,
				$r->minimum_daily_requirement_grade_b,
				$r->minimum_monthly_requirement_grade_b,
				$r->minimum_daily_requirement_grade_a,
				$r->minimum_monthly_requirement_grade_a
			);
    }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $appraisal->num_rows(),
			 "recordsFiltered" => $appraisal->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();

  }

	// Validate and add job tasks
	public function add_jobtask() {

		if($this->input->post('add_type')=='job_task') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
			if($this->input->post('job_task')==='') {
	        $Return['error'] = "Job task is required.";
			} else if($this->input->post('min_daily_grade_b')==='') {
					$Return['error'] = "Minimum Daily Requirement for Grade B can not 0 (zero).";
			} else if($this->input->post('min_daily_grade_a')==='') {
	        $Return['error'] = "Minimum Daily Requirement for Grade A can not 0 (zero).";
			} else if($this->input->post('min_monthly_grade_a')<=$this->input->post('min_monthly_grade_b')){
					$Return['error'] = "Grade A requirement should be higher than Grade B.";
			}
			if($Return['error']!=''){
       		$this->output($Return);
    	}
			$session = $this->session->userdata('username');
			$data = array(
				'name' => $this->input->post('job_task'),
				'description' => $this->input->post('description'),
				'minimum_daily_requirement_grade_a' => $this->input->post('min_daily_grade_a'),
				'minimum_monthly_requirement_grade_a' => $this->input->post('min_monthly_grade_a'),
				'minimum_daily_requirement_grade_b' => $this->input->post('min_daily_grade_b'),
				'minimum_monthly_requirement_grade_b' => $this->input->post('min_monthly_grade_b'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'created_by' => $session['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Appraisal_task_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Job task added.";
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('appraisal_task_id');
	 $result = $this->Appraisal_task_model->read_appraisal_task_information($id);
	 $allSubDepartment = $this->Appraisal_task_model->all_sub_departments();
	 $allMinimumRequirement = $this->Minimum_requirement_model->all_minimum_requirements()->result();
	 $data = array(
		 'appraisal_task_id'	=> $result[0]->id,
		 'department_name' => $result[0]->department_name,
		 'name' => $result[0]->name,
		 'description' => $result[0]->description,
		 'minimum_daily_requirement_grade_a' => $result[0]->minimum_daily_requirement_grade_a,
		 'minimum_monthly_requirement_grade_a' => $result[0]->minimum_monthly_requirement_grade_a,
		 'minimum_daily_requirement_grade_b' => $result[0]->minimum_daily_requirement_grade_b,
		 'minimum_monthly_requirement_grade_b' => $result[0]->minimum_monthly_requirement_grade_b,
		 'subDept' => $allSubDepartment,
		 'subDeptIdAppraisal' => $result[0]->sub_department_id,
		 'allMinimumRequirement' => $allMinimumRequirement
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/appraisal/dialog_appraisal_task', $data);
	 } else {
		 redirect('admin/');
	 }
 }

 // Validate and update info in database
 public function update() {

	 if($this->input->post('edit_type')=='job_task_update') {

	 $id = $this->uri->segment(4);

	 /* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */
		if($this->input->post('job_task')==='') {
				$Return['error'] = "Job task is required.";
		} else if($this->input->post('min_daily_grade_b')==='') {
				$Return['error'] = "Minimum Daily Requirement for Grade B can not 0 (zero).";
		} else if($this->input->post('min_daily_grade_a')==='') {
				$Return['error'] = "Minimum Daily Requirement for Grade A can not 0 (zero).";
		} else if($this->input->post('min_monthly_grade_a')<=$this->input->post('min_monthly_grade_b')){
				$Return['error'] = "Grade A requirement should be higher than Grade B.";
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
		$session = $this->session->userdata('username');
		$data = array(
			'name' => $this->input->post('job_task'),
			'description' => htmlspecialchars(addslashes($this->input->post('description')), ENT_QUOTES),
			'minimum_daily_requirement_grade_a' => $this->input->post('min_daily_grade_a'),
			'minimum_monthly_requirement_grade_a' => $this->input->post('min_monthly_grade_a'),
			'minimum_daily_requirement_grade_b' => $this->input->post('min_daily_grade_b'),
			'minimum_monthly_requirement_grade_b' => $this->input->post('min_monthly_grade_b'),
			'sub_department_id' => $this->input->post('subdepartment_id'),
		);
	 $result = $this->Appraisal_task_model->update_record($data,$id);
	 if ($result == TRUE) {
		 $Return['result'] = "Job task updated.";
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
	 $result = $this->Appraisal_task_model->delete_record($id);
	 if(isset($id)) {
		 $Return['result'] = "Job Task deleted.";
	 } else {
		 $Return['error'] = $this->lang->line('xin_error_msg');
	 }
	 $this->output($Return);
 }

}
