<?php
 /**
 * @author   luffy
 * Assign rewards module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_rewards extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Assign_rewards_model");
		$this->load->model("Rewards_model");
		$this->load->model("Appraisal_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		// $this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
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
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('2039',$role_resources_ids)){
			$data['my_title']=' My'; $title='My Rewards';
		}else{
			$data['my_title']=''; $title='Assign Rewards';
		}
		$data['title'] = $title.' | '.$this->Xin_model->site_title();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['breadcrumbs'] = $title;
		$data['path_url'] = 'assign_rewards';	//js named di sini jg.
		if(in_array('1008',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/rewards/assign_rewards", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function assign_rewards() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/rewards/assign_rewards", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// Luffy's note:
		// View Own berlaku, datatable akan kosong jika bukan miliknya.
		// catatan 1: PENTING > untuk View Own ini, di role Admin jangan dicentang, hanya centang View Own role punya user saja.
		// catatan 2: dan kalau sudah centang View Own, centang juga View (di role user), biar user bisa view.
		if(in_array('2039',$role_resources_ids)){
			$assignRewards = $this->Assign_rewards_model->my_own_assigned_rewards($session['user_id']);
		} else {
			$assignRewards = $this->Assign_rewards_model->all_assign_rewards();
		}
		$data = array();
    foreach($assignRewards->result() as $r) {
			if(in_array('2036',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-assign_rewards_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('2037',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('2038',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-assign_rewards_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$r->assignTo_firstName." ".$r->assignTo_lastName,
				$r->location_name_to ? $r->location_name_to : '-',
				$r->department_name,
				$r->rewards_name,
				$r->rewardsPoint,
				"Rp. ".number_format($r->rewardsAmount,0,',','.'),
				date('d-M-Y',strtotime($r->rewards_date))
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $assignRewards->num_rows(),
			 "recordsFiltered" => $assignRewards->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	// get sub department > employees
	public function get_employees() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array(
			 'subdept_id' => $id
		 );
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/rewards/get_employees", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// get sub department > rewards
	public function get_rewards() {
		 $data['title'] = $this->Xin_model->site_title();
		 $data['allRewards'] = $this->Rewards_model->all_rewards();
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/rewards/get_rewards", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// Validate and add job tasks
	public function add_assign_rewards() {
		if($this->input->post('add_type')=='add_assign_rewards') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
	 		if($this->input->post('subdepartment_id')==='') {
	 				$Return['error'] = "Sub Department is required.";
	 		} else if($this->input->post('assign_to')==='') {
	 				$Return['error'] = "Select employee to assign the reward.";
	 		} else if($this->input->post('rewards')==='') {
	 				$Return['error'] = "Rewards is required.";
	 		}
	 		if($Return['error']!=''){
	 				$this->output($Return);
	 		}
			$session = $this->session->userdata('username');
			$data = array(
				'rewards_id' => $this->input->post('rewards'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'assigned_to' => $this->input->post('assign_to'),
				'assigned_by' => $session['user_id'],
				'rewards_date' => $this->input->post('rewards_date'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => ''
			);
			$result = $this->Assign_rewards_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Rewards assigned.";
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('assign_rewards_id');
	 $result = $this->Assign_rewards_model->read_assign_rewards_information($id);
	 $allSubDepartments = $this->Appraisal_task_model->all_sub_departments();
	 $allEmployees = $this->Employees_model->employeeActiveAPG();
	 $allRewards = $this->Rewards_model->all_rewards();
	 $data = array(
		 'assRewardsId' => $result[0]->id,
		 'rewards' => $result[0]->rewards_name,
		 'subDepartmentName' => $result[0]->department_name,
		 'assignTo' => $result[0]->assignTo_firstName." ".$result[0]->assignTo_lastName,
		 'assignedBy' => $result[0]->assignBy_firstName." ".$result[0]->assignBy_lastName,
		 'assignedAt' => $result[0]->created_at,
		 'rewardsDate' => $result[0]->rewards_date,
		 // starting from below for selected combobox
		 'allSubDepartments' => $allSubDepartments,
		 'subDepartmentId' => $result[0]->sub_department_id,
		 'allEmployees' => $allEmployees,
		 'employeesId' => $result[0]->assigned_to,
		 'allRewards' => $allRewards,
		 'rewardsId' => $result[0]->rewards_id
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/rewards/dialog_assign_rewards', $data);
	 } else {
		 redirect('admin/');
	 }
 }

	// Validate and update info in database
  public function update() {
 	 if($this->input->post('edit_type')=='assign_rewards_update') {
 	 $id = $this->uri->segment(4);

 	 /* Define return | here result is used to return user data and error for error message */
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();

 		/* Server side PHP input validation */
		if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = "Sub Department is required.";
		} else if($this->input->post('assign_to')==='') {
				$Return['error'] = "Select employee to assign the reward.";
		} else if($this->input->post('rewards')==='') {
				$Return['error'] = "Rewards is required.";
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
 		$session = $this->session->userdata('username');
 		$data = array(
			'rewards_id' => $this->input->post('rewards'),
			'sub_department_id' => $this->input->post('subdepartment_id'),
			'assigned_to' => $this->input->post('assign_to'),
			'rewards_date' => $this->input->post('rewards_date'),
			'assigned_by' => $session['user_id'],
 		  'updated_at' => date('Y-m-d H:i:s')
 		);
 	 $result = $this->Assign_rewards_model->update_record($data,$id);
 	 if ($result == TRUE) {
 		 $Return['result'] = "Assigned Rewards updated.";
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
 	 $result = $this->Assign_rewards_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Assigned Rewards deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
