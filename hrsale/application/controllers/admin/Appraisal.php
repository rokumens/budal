<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal extends MY_Controller {

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
		$data['title'] = 'Appraisal List | '.$this->Xin_model->site_title();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['all_job_task'] = $this->Appraisal_model->all_appraisal();
		$data['allApprovalStatus'] = $this->Appraisal_approval_status_model->get_appraisal_status();
		$data['breadcrumbs'] = 'Appraisal List';
		$data['path_url'] = 'appraisal';	//js named di sini jg.
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1001',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/appraisal_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function appraisal_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/appraisal/appraisal_list", $data);
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
		if(in_array('2004',$role_resources_ids)){
			$appraisal = $this->Appraisal_model->my_own_appraisal($session['user_id']);
		} else {
			$appraisal = $this->Appraisal_model->all_appraisal();
		}
		$data = array();
		foreach($appraisal->result() as $r) {

			if(in_array('2001',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-appraisal_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			} else {
				$edit = '';
			}

			if(in_array('2002',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('2003',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="View report"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-appraisal_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			} else {
				$view = '';
			}
			$combhr = $edit.$delete.$view;
			$jobTask = $this->Appraisal_model->getJobtaskNameBy($r->appraisal_task_id);
			$subDepartment = $this->Appraisal_model->getSubDepartmentBy($r->sub_department_id);
			$appraisalStatus=$r->appraisal_status_name;
			$approvalStatus=$r->approvalstatus_name;
			$data[] = array(
				$combhr,
				$r->first_name.' '.$r->last_name,
				$jobTask->name,
				$r->final_point,
				$appraisalStatus,
				$approvalStatus
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

	// get company > employees
	public function get_employees() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array(
			 'subdept_id' => $id
			 );
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/get_employees", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// get company > employees
	public function get_jobtask() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array(
			 'subdept_id' => $id
			 );
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/get_jobtask", $data);
		 } else {
			 redirect('admin/');
		 }
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}

	// Validate and add job tasks
	public function add_appraisal() {
		if($this->input->post('add_type')=='add_appraisal') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
			if($this->input->post('subdepartment_id')==='') {
	        $Return['error'] = "Sub Department is required.";
			} else if(empty($this->input->post('jobtask[]'))) {
	        $Return['error'] = "Job task is required.";
			} else if($this->input->post('employee')==='') {
	        $Return['error'] = "Employee is required.";
			}
			if($Return['error']!=''){
       		$this->output($Return);
    	}
			$session = $this->session->userdata('username');
			$subDepartmentId=$this->input->post('subdepartment_id');
			$department=$this->Appraisal_model->getSubDepartmentBy($subDepartmentId);
			$note = htmlspecialchars(addslashes($this->input->post('note')), ENT_QUOTES);
			// select multiple jobTask
			$multiJobTask = $this->input->post('jobtask');
	    foreach($multiJobTask as $singJobTask) {
				$data = array(
					'reviewer_id' => $session['user_id'],
					'employee_id' => $this->input->post('employee'),
					'department_id' => $department->department_id,
					'sub_department_id' => $subDepartmentId,
					'appraisal_task_id' => $singJobTask,
					'final_point' => 0,
					'final_amount' => 0,
					'progress_percentage_grade_a' => 0,
					'progress_percentage_grade_b' => 0,
					// 'grade' => "",	//should automatically result by accumulating all the points.
					'start_date' => $this->input->post('start_date'),
					'due_date' => $this->input->post('due_date'),
					'appraisal_status' => 1,	// pending
					'approval_status' => 1, // pending	-> appraisal_approval_status
					// 'approved_by' => '',
					'note' => $note,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => ''
				);
				$result = $this->Appraisal_model->add($data);
	    }
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
	 $id = $this->input->get('appraisal_id');
	 $result = $this->Appraisal_model->read_appraisal_information($id);
	 $allSubDept=$this->Appraisal_model->all_sub_departments();
	 $allJobTask=$this->Appraisal_model->ajax_jobtask_info($result[0]->sub_department_id);
	 $allEmployees=$this->Appraisal_model->all_employees();
	 $allApprovalStatus=$this->Appraisal_approval_status_model->get_appraisal_status();
	 $approvedByName = ($result[0]->approved_by==0)?'Not yet':$result[0]->approvedby_firstname." ".$result[0]->approvedby_lastname;
	 #$disabled=$result[0]->approval_status==1?'':'disabled'; //can't approve it again when it's approved.
	 $data = array(
		 'appraisal_id'	=> $result[0]->id,
		 'reviewer' => $result[0]->reviewer_firstname." ".$result[0]->reviewer_lastname,
		 'approvedBy' => $approvedByName,
		 'employee' => $result[0]->first_name." ".$result[0]->last_name,
		 'department' => $result[0]->department_name,
		 'subDepartment' => $result[0]->subdept_deptname,
		 'jobTaskName' => $result[0]->jobtask_jobtaskname,
		 'finalPoint' => $result[0]->final_point,
		 'progressPercentageA' => $result[0]->progress_percentage_grade_a,
		 'progressPercentageB' => $result[0]->progress_percentage_grade_b,
		 'grade' => $result[0]->grade,
		 'period' => date('F Y', strtotime($result[0]->start_date,time())),
		 'appraisalStatus' => $result[0]->appraisal_status,
		 'approvalStatus' => $result[0]->approval_status,
		 'note' => $result[0]->note,
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
		 #'disabled' => $disabled,
		 // employee bonus
		 'bonus' => ($result[0]->final_amount>0)?'Rp. '.number_format($result[0]->final_amount,0,",","."):0
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/appraisal/dialog_appraisal', $data);
	 } else {
		 redirect('admin/');
	 }
 }

	// Validate and update info in database
  public function update() {
 	 if($this->input->post('edit_type')=='appraisal_update') {
 	 $id = $this->uri->segment(4);
	 // get info from current appraisal
	 $apprInfo = $this->Appraisal_model->read_appraisal_information($id);
	 $currentAppraisalStatus = $apprInfo[0]->appraisal_status;
	 $currentApprovalStatus = $apprInfo[0]->approval_status;

 	 /* Define return | here result is used to return user data and error for error message */
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */
		if($this->input->post('subdepartment_id')==='') {
				$Return['error'] = "Sub Department is required.";
		} else if($this->input->post('jobtask')==='') {
				$Return['error'] = "Job task is required.";
		} else if($this->input->post('employee')==='') {
				$Return['error'] = "Employee is required.";
		} elseif($currentAppraisalStatus!=3){	// Can't approve the appraisal instead of Completed.
				$Return['error'] = "This appraisal is still in progress, can't approve it right now.";
		} elseif(($currentApprovalStatus==2)){	// Can't approve when it has been approved.
				$Return['error'] = "It has been approved. <br />Can't update it anymore.";
		} elseif(($currentApprovalStatus==3)){	// Can't reject when it has been rejected.
				$Return['error'] = "It has been rejected. <br />Can't update it anymore.";
		}
		if($Return['error']!=''){
				$this->output($Return);
		}
 		$session = $this->session->userdata('username');
		$note = htmlspecialchars(addslashes($this->input->post('note')), ENT_QUOTES);
		$approvalStatus = $this->input->post('approvalStatus');
		$subDepartmentId=$this->input->post('subdepartment_id');
		$department=$this->Appraisal_model->getSubDepartmentBy($subDepartmentId);
		$approvedBy='';
		if($approvalStatus!=1){ //selain pending -> Approved & Rejected
			$approvedBy=$session['user_id'];
		}
 		$data = array(
			'reviewer_id' => $session['user_id'],
			'approval_status' => $approvalStatus,
			'approved_by' => $approvedBy,	//approved by current user id (should be the leader or above)
			'note' => $note,
			'updated_at' => date('Y-m-d H:i:s')
 	 );
 	 $result = $this->Appraisal_model->update_record($data,$id);
 	 if ($result===TRUE) {
 		 $Return['result'] = "Appraisal updated.";
		 //----------------------------------------------------------------------------------------------------------------------------------------
		 // NOTE: ONLY when the apprisal was completed AND the approval === 'Approved', make it goes to Appraisal Report.
		 // Count the TOTAL ACTUAL POINT based on grade
		 // Only when to Approve or Reject ONLY.
		 if(($this->input->post('approvalStatus')==2)||($this->input->post('approvalStatus')==3)){
			 $currentMonthPeriod=date('n',strtotime($apprInfo[0]->start_date));
			 $appraisalPeriod=date('Y-m-d',strtotime($apprInfo[0]->start_date));
			 $employeeId=$apprInfo[0]->employee_id;
			 //actual point + grade
			 $actualPointGrade_A=$this->Appraisal_model->sum_actual_point_grade_a($currentMonthPeriod,$employeeId)->totalActualPointGradeA;
			 $actualPointGrade_B=$this->Appraisal_model->sum_actual_point_grade_b($currentMonthPeriod,$employeeId)->totalActualPointGradeB;
			 if($actualPointGrade_A>$actualPointGrade_B){
				 $totalGrade='A';
			 }elseif($actualPointGrade_B>$actualPointGrade_A){
				 $totalGrade='B';
			 }else{
				 $totalGrade='Below standard grade.';
			 }
			 // Count the TOTAL BONUS based on grade
			 $getTotalBonus=$this->Appraisal_model->sum_total_bonus($employeeId,$currentMonthPeriod)->totalBonus;	// employee_id, start_date (month)
			 $tempBonus=0;
			 if(!is_null($getTotalBonus)) $tempBonus=$getTotalBonus;
			 // check the this user has some rewards or punishment.
			 $sum_rewardsAmount=0; $sum_rewardsPoint=0;
			 $sumRewardsInfo=$this->Assign_rewards_model->getSumRewardsBy_Month_UserId($currentMonthPeriod,$employeeId);
			 if(!is_null($sumRewardsInfo->sum_rewardsAmount)||$sumRewardsInfo->sum_rewardsAmount!=0){
				 $sum_rewardsAmount=$sumRewardsInfo->sum_rewardsAmount;
				 $sum_rewardsPoint=$sumRewardsInfo->sum_rewardsPoint;
			 }
			 $sum_punishmentAmount=0;$sum_punishmentPoint=0;
			 $sumPunishmentInfo=$this->Assign_punishment_model->getSumPunishmentBy_Month_UserId($currentMonthPeriod,$employeeId);
			 if(!is_null($sumPunishmentInfo->sum_punishmentAmount)||$sumPunishmentInfo->sum_punishmentAmount!=0){
				 $sum_punishmentAmount=$sumPunishmentInfo->sum_punishmentAmount;
				 $sum_punishmentPoint=$sumPunishmentInfo->sum_punishmentPoint;
			 }
			 $totalBonus=$sum_rewardsAmount+$sum_punishmentAmount+$tempBonus;
			 // check existing current user in the appraisal report
			 $dataToAppraisalReport=array(
				 'employee_id' => $employeeId,
				 'final_grade' => $totalGrade,
				 'total_bonus' => $totalBonus,
				 'period' => $appraisalPeriod,
				 'total_rewards_point' => $sum_rewardsPoint,
				 'total_rewards_amount' => $sum_rewardsAmount,
				 'total_punishment_point' => $sum_punishmentPoint,
				 'total_punishment_amount' => $sum_punishmentAmount
			 );
			 $existingEmployeeInAppraisalReport=$this->Appraisal_report_model->getAppraisalReportBy_Month_UserId($currentMonthPeriod,$employeeId);
			 if(is_null($existingEmployeeInAppraisalReport)){
				 $this->Appraisal_report_model->add($dataToAppraisalReport);
			 }
			 $this->Appraisal_report_model->update_record($dataToAppraisalReport,$currentMonthPeriod,$employeeId);
		 } // if Approve / Reject
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
 	 $result = $this->Appraisal_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Appraisal deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
