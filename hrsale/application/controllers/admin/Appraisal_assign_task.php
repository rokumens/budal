<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Assign Task
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Appraisal_assign_task extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Appraisal_model");
		$this->load->model("Appraisal_report_model");
		$this->load->model("Xin_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Appraisal_status_model");
		$this->load->model("Appraisal_approval_status_model");
		$this->load->model("Assign_rewards_model");
		$this->load->model("Assign_punishment_model");
		$this->load->model("Appraisal_report_model");
		#$this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
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
		if(empty($session))
			redirect('admin/');
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true')
			redirect('admin/dashboard');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('2004',$role_resources_ids)){
			$data['my_title']=' My'; $title='My Assigned Main Task';
		}else{$data['my_title']=' Assigned'; $title='Assign Main Task';}
		$data['title'] = $title.' | '.$this->Xin_model->site_title();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['allApprovalStatus'] = $this->Appraisal_approval_status_model->get_appraisal_status();
		$data['breadcrumbs'] = $title;
		$data['path_url'] = 'appraisal_assign_task';
		if(in_array('1001',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/assign_task", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
  public function assign_task() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/appraisal/assign_task", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$userId=$session['user_id'];
		$employeeShift=$this->Appraisal_model->getShiftBySessionUserId($userId)->office_shift_id;
		if(in_array('2004',$role_resources_ids))
			$appraisal = $this->Appraisal_model->my_own_appraisal($userId,$employeeShift);
		else $appraisal = $this->Appraisal_model->all_appraisal();
		$data = array();
		foreach($appraisal->result() as $r) {
			if(in_array('2001',$role_resources_ids)) //update
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-appraisal_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			else $edit = '';
			if(in_array('2002',$role_resources_ids)) // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			else $delete = '';
			if(in_array('2003',$role_resources_ids)) //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-appraisal_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			else $view = '';
			$combhr = $edit.$delete.$view;
			$appraisalStatus=$r->appraisal_status_name;
			$approvalStatus=$r->approvalstatus_name;
			$data[] = array(
				$combhr,
				$r->first_name.' '.$r->last_name,
				$r->location_name ? $r->location_name : '-',
				$r->taskName,
				$r->shift_name,
				$r->final_point,
				$appraisalStatus,
				#$approvalStatus
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
	// get sub departements > all employees based on sub department id
	public function get_employees() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array('subdept_id' => $id);
		 $session = $this->session->userdata('username');
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_employees", $data);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// get sub departements > all employees list
	public function get_single_employees() {
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_single_employees", null);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// get sub departements > multiple select task
	public function get_jobtask() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array('subdept_id' => $id);
		 $session = $this->session->userdata('username');
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_jobtask", $data);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// get sub departements > single single task
	public function get_single_jobtask() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array('subdept_id' => $id);
		 $session = $this->session->userdata('username');
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_single_jobtask", $data);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// get employees > sub department
	public function get_subdepartments() {
			$data['title'] = $this->Xin_model->site_title();
			$id = $this->uri->segment(4);
			$data = array('employeeId' => $id);
			$session = $this->session->userdata('username');
			if(!empty($session))
				$this->load->view("admin/appraisal/get_subdepartments", $data);
			else redirect('admin/');
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
	}
	// get employees > sub department disabled
	public function get_subdepartments_disabled() {
			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session))
				$this->load->view("admin/appraisal/get_subdepartments_disabled", null);
			else redirect('admin/');
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
	}
	// get grade > minimum requirement by sub dept id & grade detail id
	public function get_requirement() {
		 $data['title'] = $this->Xin_model->site_title();
		 $subDeptId = $this->uri->segment(4);
		 $gradeDetailId = $this->uri->segment(5);
		 $data = array('subDeptId'=>$subDeptId,'gradeDetailId'=>$gradeDetailId);
		 $session = $this->session->userdata('username');
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_requirement",$data);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	public function add_assign_task(){
		if($this->input->post('add_type')=='add_assign_task') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('subdepartment_id')==='') {
	       $Return['error'] = "Sub Department is required.";
			}elseif(empty($this->input->post('jobtask[]'))) {
	       $Return['error'] = "Please choose main task.";
			}elseif($this->input->post('employee')==='') {
	       $Return['error'] = "Please choose employee.";
			}
			if($Return['error']!='')
      	$this->output($Return);
			$session = $this->session->userdata('username');
			$userId=$session['user_id'];
			$valSubDepartments=$this->input->post('subdepartment_id');
			$valTask = $this->input->post('jobtask');
			$valEmployee=$this->input->post('employee');
			$department=$this->Appraisal_model->getSubDepartmentBy($valSubDepartments);
			// adding by multiple "All Sub Department".
			if(($valSubDepartments=='allSubDepartments_val')&&($valEmployee=='allEmployess_val')){
				$arrEmployees=$this->Appraisal_model->getAllEmployees();
				// New Grading System
				$gradeId=$this->Appraisal_model->getGradeDetailByTaskId($valTask)->gradeId;
		    foreach($arrEmployees as $singEmployee){
					if(empty($singEmployee->sub_department_id)) continue;
					$data = array(
						'reviewer_id' => $userId,
						'employee_id' => $singEmployee->user_id,
						'department_id' => $singEmployee->department_id,
						'sub_department_id' => $singEmployee->sub_department_id,
						'appraisal_task_id' => $valTask,
						'grade_id' => $gradeId,
						'final_point' => 0,
						'final_amount' => 0,
						'progress_percentage'=>0,
						'start_date' => $this->input->post('start_date'),
						'due_date' => $this->input->post('due_date'),
						'appraisal_status' => 1,	// pending
						#'approval_status' => 1, // pending -> appraisal_approval_status
						'approval_status' => 2, #force to approved temporary
						// 'approved_by' => '',
						'note' => html_entity_decode($this->input->post('note')),
					);
					$result=$this->Appraisal_model->add($data);
		    }
				if($result==TRUE)
					$Return['result'] = "Main Task assigned successfully to all subdepartment.";
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return); exit;
			}elseif($valEmployee=='allSubEmployess_val'){
				// adding by multiple "All employees in this sub-department"
				$arrSubEmployees = $this->Appraisal_model->getallEmployeesBySubDeptId($valSubDepartments);
				$subDeptName = $this->Appraisal_model->getSubDeptNameBySubDeptId($valSubDepartments)->subDeptName;
				// New Grading System
				$gradeId=$this->Appraisal_model->getGradeDetailByTaskId($valTask)->gradeId;
				foreach($arrSubEmployees as $singSubEmployees){
					$data = array(
						'reviewer_id' => $userId,
						'employee_id' => $singSubEmployees->user_id,
						'department_id' => $singSubEmployees->department_id,
						'sub_department_id' => $singSubEmployees->sub_department_id,	// atau boleh klo mo pake $valSubDepartments =)
						'appraisal_task_id' => $valTask,
						'grade_id' => $gradeId,
						'final_point' => 0,
						'final_amount' => 0,
						'progress_percentage'=>0,
						'start_date' => $this->input->post('start_date'),
						'due_date' => $this->input->post('due_date'),
						'appraisal_status' => 1,	// pending
						#'approval_status' => 1, // pending -> appraisal_approval_status
						'approval_status' => 2, #force to approved temporary
						// 'approved_by' => '',
						'note' => html_entity_decode($this->input->post('note')),
					);
					$result=$this->Appraisal_model->add($data);
				}
				if($result==TRUE)
					$Return['result'] = "Main Task assigned successfully to all employees under $subDeptName sub department.";
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return); exit;
			}elseif(($valSubDepartments!='allSubDepartments_val')&&($valEmployee!='allEmployess_val')&&($valEmployee!='allSubEmployess_val')){
				// adding by Multiple "Task".
				foreach($valTask as $singTask) {	//$valTask, select jobtask type multiple.
					// New Grading System
					// NOTE: ini wajib di sini jgn dipindah2 lg :v
					$gradeId=$this->Appraisal_model->getGradeDetailByTaskId($singTask)->gradeId;
					$data = array(
						'reviewer_id' => $userId,
						'employee_id' => $valEmployee,
						'department_id' => $department->department_id,
						'sub_department_id' => $valSubDepartments,
						'appraisal_task_id' => $singTask,
						'grade_id' => $gradeId,
						'final_point' => 0,
						'final_amount' => 0,
						'progress_percentage'=>0,
						'start_date' => $this->input->post('start_date'),
						'due_date' => $this->input->post('due_date'),
						'appraisal_status' => 1,	// pending
						#'approval_status' => 1, // pending -> appraisal_approval_status
						'approval_status' => 2, #force to approved temporary
						'note' => html_entity_decode($this->input->post('note')),
					);
					$result=$this->Appraisal_model->add($data);
		    }
				if($result==TRUE)
					$Return['result'] = "Main Task assigned successfully.";
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return); exit;
			}
		}
	}
	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('appraisal_id');
	 $result = $this->Appraisal_model->read_appraisal_information($id);
	 $allSubDept=$this->Appraisal_model->all_sub_departments();
	 $allJobTask=$this->Appraisal_model->ajax_jobtask_info($result[0]->sub_department_id);
	 $allEmployees=$this->Appraisal_model->all_employees();
	 $allApprovalStatus=$this->Appraisal_approval_status_model->get_appraisal_status();
	 $approvedByName = ($result[0]->approved_by==0)?'Not yet':$result[0]->approvedby_firstname." ".$result[0]->approvedby_lastname;
	 $actualGrade='Not reached any grade yet.';
	 if($result[0]->final_grade_id!=0)
		 $actualGrade=$this->Appraisal_model->getGradeNameByGradeDetailId($result[0]->final_grade_id)->grade_name;
	 $data = array(
		 'appraisal_id'	=> $result[0]->id,
		 'reviewer' => $result[0]->reviewer_firstname." ".$result[0]->reviewer_lastname,
		 'approvedBy' => $approvedByName,
		 'employeeId' => $result[0]->employee_id,
		 'nickname' => $result[0]->username,
		 'employee' => $result[0]->first_name." ".$result[0]->last_name,
		 'department' => $result[0]->department_name,
		 'subDepartment' => $result[0]->subdept_deptname,
		 'jobTaskName' => $result[0]->jobtask_jobtaskname,
		 'finalPoint' => $result[0]->final_point,
		 'taskProgress' => $result[0]->progress_percentage,
		 'grade' => $result[0]->gradeName,
		 'actualGrade' => $actualGrade,
		 'period' => date('F Y', strtotime($result[0]->start_date,time())),
		 'startDate' => date('F Y', strtotime($result[0]->created_at,time())),
		 'appraisalStatus' => $result[0]->appraisal_status,
		 'approvalStatus' => $result[0]->approval_status,
		 'note' => stripslashes($result[0]->note),
		 'allSubDept' => $allSubDept,
		 'subDeptIdAppraisal' => $result[0]->sub_department_id,
		 'allJobtask' => $allJobTask,
		 'jobId' => $result[0]->appraisal_task_id,
		 'allEmployees' => $allEmployees,
		 'employeeId' => $result[0]->employee_id,
		 'allApprovalStatus' => $allApprovalStatus,
		 'approvalName' => $result[0]->approval_name,
		 'delayedDays' => $result[0]->delayed_days,
		 'overDueDays' => $result[0]->overdue_days,
		 'appraisalStatusName' => $result[0]->status_name,
		 'shiftName' => $result[0]->shift_name,
		 #'disabled' => $disabled,
		 // employee bonus
		 'bonus' => ($result[0]->final_amount>0)?'Rp. '.number_format($result[0]->final_amount,0,",","."):0
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session))
		 $this->load->view('admin/appraisal/dialog_assigned_task', $data);
	 else redirect('admin/');
 }
  public function update() {
 	  if($this->input->post('edit_type')=='assign_task_update') {
			$session = $this->session->userdata('username');
			$userId=$session['user_id'];
			$id = $this->uri->segment(4);
		  // get info from current appraisal
		  $apprInfo = $this->Appraisal_model->read_appraisal_information($id);
		  $currentAppraisalStatus = $apprInfo[0]->appraisal_status;
		  $currentApprovalStatus = $apprInfo[0]->approval_status;
		  $currentReviewerId = $apprInfo[0]->reviewer_id;
		  $currentReviewerName = ucwords(strtolower($apprInfo[0]->reviewer_firstname." ".$apprInfo[0]->reviewer_lastname));
			$approvalStatus = $this->input->post('approvalStatus');
			$subDepartmentId=$this->input->post('subdepartment_id');
	 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(($currentAppraisalStatus==1)||($currentAppraisalStatus==2)){	// Can't approve the appraisal instead of Completed.
				if($apprInfo[0]->reviewer_id==$userId)
					$Return['error'] = "This main task is still in progress by employee, can't approve it right now.";
				else $Return['error'] = "This main task is still in progress, can't update.";
			}elseif($approvalStatus==1) { #pending
				$Return['error'] = "Please Approve or Reject this appraisal.";
			}elseif(($approvalStatus==2)||($approvalStatus==3)){ #approved rejected
				if($userId!=$currentReviewerId)
					$Return['error'] = "Please ask $currentReviewerName to approve or reject this.";
			}elseif(($currentApprovalStatus==2)){	// Can't approve when it has been approved.
				$Return['error'] = "It has been approved. <br />Can't update it anymore.";
			}elseif(($currentApprovalStatus==3)){	// Can't reject when it has been rejected.
				$Return['error'] = "It has been rejected. <br />Can't update it anymore.";
			}
			if($Return['error']!='')
				$this->output($Return);
			$department=$this->Appraisal_model->getSubDepartmentBy($subDepartmentId);
			$approvedBy='';
			if($approvalStatus!=1) //selain pending -> Approved & Rejected
				$approvedBy=$userId;
	 		$data = array(
				'reviewer_id' => $userId,
				#'approval_status' => $approvalStatus,
				'approval_status' => 2, #force to approved temporary
				'approved_by' => $approvedBy,	//approved by current user id (should be the leader or above)
				'note' => html_entity_decode($this->input->post('note')),
	 	 );
	 	 $result = $this->Appraisal_model->update_record($data,$id);
	 	 if ($result===TRUE) {
	 		 $Return['result'] = "Assigned Main Task updated.";
			 //----------------------------------------------------------------------------------------------------------------------------------------
			 // get period first
			 $currentMonthPeriod=date('n',strtotime($apprInfo[0]->start_date));
			 $appraisalPeriod=date('Y-m-d',strtotime($apprInfo[0]->start_date));
			 $employeeId=$apprInfo[0]->employee_id;
			 // Count the TOTAL BONUS based on grade
			 $getTotalBonus=$this->Appraisal_model->sum_total_bonus($employeeId,$currentMonthPeriod)->totalBonus;	// employee_id, start_date (month)
			 // $tempBonus=0;
			 // if(!is_null($getTotalBonus))$tempBonus=$getTotalBonus;
			 // // NOTE: ONLY when the apprisal was completed AND the approval === 'Approved', make it goes to Appraisal Report.
			 // // Count the TOTAL ACTUAL POINT based on grade
			 // // Only use for APPROVAL when to "Approve" ONLY.
			 // #if(($this->input->post('approvalStatus')==2)||($this->input->post('approvalStatus')==3)){ // Approve , Reject
			 // if($this->input->post('approvalStatus')==2){ #approve
				//  // check the this user has some rewards or punishment.
				//  $sum_rewardsAmount=0; $sum_rewardsPoint=0;
				//  $sumRewardsInfo=$this->Assign_rewards_model->getSumRewardsBy_Month_UserId($currentMonthPeriod,$employeeId);
				//  if(!is_null($sumRewardsInfo->sum_rewardsAmount)||$sumRewardsInfo->sum_rewardsAmount!=0){
				// 	 $sum_rewardsAmount=$sumRewardsInfo->sum_rewardsAmount;
				// 	 $sum_rewardsPoint=$sumRewardsInfo->sum_rewardsPoint;
				//  }
				//  $sum_punishmentAmount=0;$sum_punishmentPoint=0;
				//  $sumPunishmentInfo=$this->Assign_punishment_model->getSumPunishmentBy_Month_UserId($currentMonthPeriod,$employeeId);
				//  if(!is_null($sumPunishmentInfo->sum_punishmentAmount)||$sumPunishmentInfo->sum_punishmentAmount!=0){
				// 	 $sum_punishmentAmount=$sumPunishmentInfo->sum_punishmentAmount;
				// 	 $sum_punishmentPoint=$sumPunishmentInfo->sum_punishmentPoint;
				//  }
				//  $totalBonus=$sum_rewardsAmount+$sum_punishmentAmount+$tempBonus;
			 // } #reject
			 // else{	// if the Approval back to Pending (mana tau si admin salah/khilaf nge'klik Approve)
				//  $sum_rewardsPoint=0;
				//  $sum_rewardsAmount=0;
				//  $sum_punishmentPoint=0;
				//  $sum_punishmentAmount=0;
				//  $totalBonus=$getTotalBonus;
			 // }
			 // check existing current user in the appraisal report
			 $dataToAppraisalReport=array(
				 'employee_id' => $employeeId,
				 #'total_bonus' => $totalBonus,
				 'total_bonus' => $getTotalBonus, #use this now, all bonus rewards punishment sent kpi report
				 'period' => $appraisalPeriod,
				 'total_rewards_point' => 0, #$sum_rewardsPoint, #all bonus rewards punishment sent kpi report
				 'total_rewards_amount' => 0, #$sum_rewardsAmount, #all bonus rewards punishment sent kpi report
				 'total_punishment_point' => 0, #$sum_punishmentPoint, #all bonus rewards punishment sent kpi report
				 'total_punishment_amount' => 0, #$sum_punishmentAmount #all bonus rewards punishment sent kpi report
			 );
			 $existingEmployeeInAppraisalReport=$this->Appraisal_report_model->getAppraisalReportBy_Month_UserId($currentMonthPeriod,$employeeId);
			 if(is_null($existingEmployeeInAppraisalReport)){
				 $this->Appraisal_report_model->add($dataToAppraisalReport);
			 }
			 $this->Appraisal_report_model->update_record($dataToAppraisalReport,$currentMonthPeriod,$employeeId);
	 	 } else {
	 		 $Return['error'] = $this->lang->line('xin_error_msg');
	 	 }
	 	 $this->output($Return);
	 	 exit;
 	 }
  }
	public function delete() {
 	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 	 $id = $this->uri->segment(4);
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 // get the current employee's id (assigned to) & the task id
	 $dataToDelete=$this->Appraisal_model->getUserIdTaskIdByAppraisalId($id);
	 $employeeId=$dataToDelete->employeeId;
	 $taskId=$dataToDelete->taskId;
	 // delete all the related subtask too
	 $arrSubtaskToDelete=$this->Appraisal_model->getSubtaskByUserIdTaskId($employeeId,$taskId);
	 foreach($arrSubtaskToDelete as $singSubtask){
		 $deleteAllSubtask=$this->Appraisal_model->deleteSubtaskBySubtaskId($singSubtask->id);
	 }
	 // then delete the assigned task.
	 $result = $this->Appraisal_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Assigned Main Task and<br />All related Subtask was deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
