<?php
 /**
 * @author   luffy
 * Assign punishment module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_punishment extends MY_Controller {

	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Assign_punishment_model");
		$this->load->model("Punishment_model");
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
		if(in_array('2044',$role_resources_ids)){
			$data['my_title']=' My'; $title='My Punishments';
		}else{
			$data['my_title']=''; $title='Assign Punishment';
		}
		$data['title'] = $title.' | '.$this->Xin_model->site_title();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['breadcrumbs'] = $title;
		$assignPunishment = $this->Assign_punishment_model->all_assign_punishment();
		$data['path_url'] = 'assign_punishment';
		if(in_array('1009',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/punishment/assign_punishment", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function assign_punishment() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/punishment/assign_punishment", $data);
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
		if(in_array('2044',$role_resources_ids)){
			$assignPunishment = $this->Assign_punishment_model->my_own_assigned_punishment($session['user_id']);
		} else {
			$assignPunishment = $this->Assign_punishment_model->all_assign_punishment();
		}
		$data = array();
    foreach($assignPunishment->result() as $r) {
			if(in_array('2041',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-assign_punishment_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('2042',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('2043',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-assign_punishment_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$r->assignTo_firstName." ".$r->assignTo_lastName,
				$r->location_name_to ? $r->location_name_to : '-',
				$r->department_name,
				$r->punishment_name,
				$r->punishmentPoint,
				"Rp. ".number_format($r->punishmentAmount,0,',','.'),
				date('d-M-Y',strtotime($r->punishment_date))
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $assignPunishment->num_rows(),
			 "recordsFiltered" => $assignPunishment->num_rows(),
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
			 $this->load->view("admin/punishment/get_employees", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// get sub department > punishment
	public function get_punishment() {
		 $data['title'] = $this->Xin_model->site_title();
		 $data['allPunishment'] = $this->Punishment_model->all_punishment();
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/punishment/get_punishment", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// Validate and add job tasks
	public function add_assign_punishment() {
		if($this->input->post('add_type')=='add_assign_punishment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
	 		if($this->input->post('subdepartment_id')==='') {
	 				$Return['error'] = "Sub Department is required.";
	 		} else if($this->input->post('assign_to')==='') {
	 				$Return['error'] = "Select employee to assign the punishment.";
	 		} else if($this->input->post('punishment')==='') {
	 				$Return['error'] = "Punishment is required.";
	 		}
	 		if($Return['error']!=''){
	 				$this->output($Return);
	 		}
			$session = $this->session->userdata('username');
			$data = array(
				'punishment_id' => $this->input->post('punishment'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'assigned_to' => $this->input->post('assign_to'),
				'assigned_by' => $session['user_id'],
				'punishment_date' => $this->input->post('punishment_date'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => ''
			);
			$result = $this->Assign_punishment_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Punishment assigned.";
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('assign_punishment_id');
	 $result = $this->Assign_punishment_model->read_assign_punishment_information($id);
	 $allSubDepartments = $this->Appraisal_task_model->all_sub_departments();
	 $allEmployees = $this->Employees_model->employeeActiveAPG();
	 $allPunishment = $this->Punishment_model->all_punishment();
	 $data = array(
		 'assPunishmentId' => $result[0]->id,
		 'punishment' => $result[0]->punishment_name,
		 'subDepartmentName' => $result[0]->department_name,
		 'assignTo' => $result[0]->assignTo_firstName." ".$result[0]->assignTo_lastName,
		 'assignedBy' => $result[0]->assignBy_firstName." ".$result[0]->assignBy_lastName,
		 'assignedAt' => $result[0]->created_at,
		 'punishmentDate' => $result[0]->punishment_date,
		 // starting from below for selected combobox
		 'allSubDepartments' => $allSubDepartments,
		 'subDepartmentId' => $result[0]->sub_department_id,
		 'allEmployees' => $allEmployees,
		 'employeesId' => $result[0]->assigned_to,
		 'allPunishment' => $allPunishment,
		 'punishmentId' => $result[0]->punishment_id
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/punishment/dialog_assign_punishment', $data);
	 } else {
		 redirect('admin/');
	 }
 }

	// Validate and update info in database
  public function update() {
 	 if($this->input->post('edit_type')=='assign_punishment_update') {
 	 $id = $this->uri->segment(4);

 	 /* Define return | here result is used to return user data and error for error message */
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();

 		/* Server side PHP input validation */
		if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = "Sub Department is required.";
		} else if($this->input->post('assign_to')==='') {
				$Return['error'] = "Select employee to assign the punishment.";
		} else if($this->input->post('punishment')==='') {
				$Return['error'] = "Punishment is required.";
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
 		$session = $this->session->userdata('username');
 		$data = array(
			'punishment_id' => $this->input->post('punishment'),
			'sub_department_id' => $this->input->post('subdepartment_id'),
			'assigned_to' => $this->input->post('assign_to'),
			'punishment_date' => $this->input->post('punishment_date'),
			'assigned_by' => $session['user_id'],
 		  'updated_at' => date('Y-m-d H:i:s')
 		);
 	 $result = $this->Assign_punishment_model->update_record($data,$id);
 	 if ($result == TRUE) {
 		 $Return['result'] = "Assigned Punishment updated.";
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
 	 $result = $this->Assign_punishment_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Assigned Punishment deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
