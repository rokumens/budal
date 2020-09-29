<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Main Task List
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_task_list extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Appraisal_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Appraisal_sub_task_model");
		$this->load->model("Department_model");
		$this->load->model("Grade_model");
		$this->load->model("Grade_detail_model");
		$this->load->model("Xin_model");
		$this->load->model("Timesheet_model");
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
		if($system[0]->module_performance!='true') redirect('admin/dashboard');
		$data['title'] = 'Main Task List | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['allGradeDetail'] = $this->Grade_detail_model->all_grade_detail()->result();
		$data['breadcrumbs'] = 'Main Task List';
		$data['path_url'] = 'appraisal_task_list';
		$data['allShift'] = $this->Timesheet_model->get_office_shifts()->result();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1002',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/task_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			}else{
				redirect('admin/');
			}
		}else{
			redirect('admin/dashboard');
		}
  }
  public function task_listzz() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/appraisal/task_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$appraisal = $this->Appraisal_task_model->all_appraisal_task();
		$data = array();
    foreach($appraisal->result() as $r) {
			if(in_array('2006',$role_resources_ids)){ //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-appraisal_task_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			}else{
				$edit = '';
			}
			if(in_array('2007',$role_resources_ids)){ // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".del-modal-appraisal-task" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			}else{
				$delete = '';
			}
			if(in_array('2008',$role_resources_ids)){ //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-appraisal_task_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			}else{
				$view = '';
			}
			$shiftId=$r->office_shift_id;
	 	  ($shiftId==0)?$shiftName='-':$shiftName=$this->Timesheet_model->read_office_shift_information($shiftId);
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$r->taskName,
				$r->department_name,
				(empty($shiftName))?'-':$shiftName[0]->shift_name,
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
	// get sub departements > grade by subDept id
	public function get_grade() {
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->uri->segment(4);
		 $data = array('subdept_id' => $id);
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/get_grade",$data);
		 } else {redirect('admin/');}
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// get sub departements > all sub department > all grades
	public function get_all_grade() {
		 $data['title'] = $this->Xin_model->site_title();
		 // $id = $this->uri->segment(4);
		 // $data = array('subdept_id' => $id);
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/get_all_grade");
		 } else {redirect('admin/');}
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
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/get_requirement",$data);
		 } else {redirect('admin/');}
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	// all sub department > grade > create requirement
	public function create_requirement() {
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/create_requirement",$data);
		 } else {redirect('admin/');}
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	public function add_task_list() {
		if($this->input->post('add_type')=='add_task_list') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$paramMainTask=$this->input->post('maintask');
			$paramSubDeptId=$this->input->post('subdepartment_id');
			$paramSubtaskTitle=$this->input->post('subtaskTitle');
			$paramSubtaskTitleArray=$this->input->post('subtaskTitle[]');
			$paramOfficeShift=$this->input->post('office_shift');
			$paramGradeDetailId=$this->input->post('grade_detail_id');
			$paramDailyRequirement=$this->input->post('dailyRequirement');
			$paramMonthlyRequirement=$this->input->post('monthlyRequirement');
			$existingGradeByAll=$this->Grade_model->existingGrade_By_SubdeptShiftGradeMonthlyRequirement($paramSubDeptId,$paramOfficeShift,$paramGradeDetailId,$paramMonthlyRequirement);
			$existingMainTask=$this->Appraisal_task_model->existingMaintask($paramMainTask,$paramSubDeptId,$paramOfficeShift);
			if($paramMainTask===''){
        $Return['error'] = "Please set a name for main task.";
			}elseif($paramSubDeptId===''){
				$Return['error'] = "Please choose sub department.";
			}elseif($paramOfficeShift===''){
        $Return['error'] = "Please choose office shift.";
			}elseif($paramGradeDetailId===''){
        $Return['error'] = "Please choose grade for this main task.";
			}elseif($this->input->post('dailyRequirement')===''){
				$Return['error'] = "Daily Minimum Requirement can't be empty.";
			}elseif($paramMonthlyRequirement===''){
				$Return['error'] = "Monthly Minimum Requirement can't be empty.";
			}
			// checking grade & maintask validation.
			if($existingGradeByAll==='existed'){
				$Return['error']='The grade was existed.<br>Choose another grade.';
			}elseif($existingMainTask==='existed'){
				$Return['error']='Main task for the Subdepartment & Shift you choosen was already created.<br>Change the Sub Department or Shift to create a new main task.<br>Or if you\'d like to create a new grade for this Sub Department & Shift click <a href="grade_list"><u>here</u> &raquo;</a>';
			}
			if($Return['error']!='') $this->output($Return);
			$session = $this->session->userdata('username');
			// multiple loop saving by "All Sub Department".
			// // + create a new multiple grade
			// // previously post('grade') = grade_detail_id -> now change to id from grade table.
			// $paramGradeId=$this->input->post('grade');
			// $paramSubDeptId=$this->input->post('subdepartment_id');
			// $gradeDetailId=$this->Appraisal_task_model->getGradeDetailByGradeId($paramGradeId)->grade_detail_id;
			// next id > main task
			$mainTaskTableStatus=$this->Appraisal_task_model->mainTaskTableStatus();
			$currentMainTaskId=$mainTaskTableStatus[0]->Auto_increment;
			// next id > grade
			$gradeTableStatus=$this->Grade_model->gradeTableStatus();
			$nextGradeId=$gradeTableStatus[0]->Auto_increment;
			if($paramSubDeptId=='allSubDepartments_val'){
				$arrSubDept=$this->Grade_model->all_sub_departments()->result();
				foreach($arrSubDept as $singSubdept){
					// dynamic subtask title
					$numberOfSubtask=count($paramSubtaskTitle);
					$incrMaintaskId=$currentMainTaskId++;
					if($numberOfSubtask>0){
						// multiple subtask title.
						foreach($paramSubtaskTitle as $singSubtaskTitle){
							if(empty($singSubtaskTitle)) continue;
							$dataSubtask = array(
								'maintask_id' => $incrMaintaskId,
								'sub_department_id' => $singSubdept->sub_department_id,
								'sub_task_title_name' => $singSubtaskTitle,
							);
							$resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
						}
					}
					//grade
					$dataGrade = array(
						'maintask_id' => $currentMainTaskId,
						'grade_detail_id' => $paramGradeDetailId,
						'minimum_daily_requirement' => $paramDailyRequirement,
						'minimum_monthly_requirement' => $paramMonthlyRequirement,
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s'),
					);
					$resultGrade = $this->Grade_model->add($dataGrade);
					// main task
					if($paramOfficeShift=='allShift_val'){ // all shift
						$arrShift=$this->Timesheet_model->get_office_shifts()->result();
						foreach($arrShift as $singShift){
							$dataMainTask = array(
								'name' => $paramMainTask,
								'description' => $this->input->post('description'),
								'sub_department_id' => $singSubdept->sub_department_id,
								'office_shift_id' => $singShift->office_shift_id,
								'created_by' => $session['user_id'],
								'created_at' => date('Y-m-d H:i:s')
							);
						}
					}else{ // single shift
						$dataMainTask = array(
							'name' => $paramMainTask,
							'description' => $this->input->post('description'),
							'sub_department_id' => $singSubdept->sub_department_id,
							'office_shift_id' => $paramOfficeShift,
							'created_by' => $session['user_id'],
							'created_at' => date('Y-m-d H:i:s')
						);
					}
					$skipExistingGrade=$this->Grade_model->existingGrade_By_SubdeptShiftGradeMonthlyRequirement($singSubdept->sub_department_id,$paramOfficeShift,$paramGradeDetailId,$paramMonthlyRequirement);
					if($skipExistingGrade==='existed') continue;
					$resultMainTask = $this->Appraisal_task_model->add($dataMainTask);
				}
				if(($resultMainTask==TRUE)&&($resultGrade==TRUE)&&($resultSubtask==TRUE))
					$Return['result'] = "New multiple main tasks & grades for this task created.";
				 else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}
			// single sub department
			else{
				// all shift
				if($paramOfficeShift=='allShift_val'){
					$arrShift=$this->Timesheet_model->get_office_shifts()->result();
					foreach($arrShift as $singShift){
						// dynamic subtask title
						$numberOfSubtask=count($paramSubtaskTitle);
						$incrMaintaskId=$currentMainTaskId++;
						if($numberOfSubtask>0){
							// multiple subtask title.
							foreach($paramSubtaskTitle as $singSubtaskTitle){
								if(empty($singSubtaskTitle)) continue;
								$dataSubtask = array(
									'maintask_id' => $incrMaintaskId,
									'sub_department_id' => $paramSubDeptId,
									'sub_task_title_name' => $singSubtaskTitle,
								);
								$resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
							}
						}
						//grade
						$dataGrade = array(
							'maintask_id' => $incrMaintaskId,
							'grade_detail_id' => $paramGradeDetailId,
							'minimum_daily_requirement' => $paramDailyRequirement,
							'minimum_monthly_requirement' => $paramMonthlyRequirement,
							'created_by' => $session['user_id'],
							'created_at' => date('Y-m-d H:i:s'),
						);
						$resultGrade = $this->Grade_model->add($dataGrade);
						// main task
						$dataMainTask = array(
							'name' => $paramMainTask,
							'description' => $this->input->post('description'),
							'sub_department_id' => $paramSubDeptId,
							'office_shift_id' => $singShift->office_shift_id,
							'created_by' => $session['user_id'],
							'created_at' => date('Y-m-d H:i:s')
						);
						$resultMainTask=$this->Appraisal_task_model->add($dataMainTask);
					}
				}else{ // single shift
					// dynamic subtask title
					$numberOfSubtask=count($paramSubtaskTitle);
					if($numberOfSubtask>0){
						foreach($paramSubtaskTitle as $singSubtaskTitle){
							if(empty($singSubtaskTitle)) continue;
							$dataSubtask = array(
								'maintask_id' => $currentMainTaskId,
								'sub_department_id' => $paramSubDeptId,
								'sub_task_title_name' => $singSubtaskTitle,
							);
							$resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
						}
					}
					// grade
					// checking a same grade was applied above using $existingGradeByAll, no need to check here anymore.
					$dataGrade = array(
						'maintask_id' => $currentMainTaskId,
						'grade_detail_id' => $paramGradeDetailId,
						'minimum_daily_requirement' => $paramDailyRequirement,
						'minimum_monthly_requirement' => $paramMonthlyRequirement,
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s'),
					);
					$resultGrade = $this->Grade_model->add($dataGrade);
					// maintask
					$dataMainTask = array(
						'name' => $paramMainTask,
						'description' => $this->input->post('description'),
						'sub_department_id' => $paramSubDeptId,
						'office_shift_id' => $paramOfficeShift,
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s')
					);
					$resultMainTask=$this->Appraisal_task_model->add($dataMainTask);
				}
				if($resultMainTask==TRUE)
					$Return['result']="New main task added.";
				else $Return['error']=$this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}
		}
	}
	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id=$this->input->get('appraisal_task_id');
	 $result=$this->Appraisal_task_model->read_appraisal_task_information($id);
	 $allSubDepartment=$this->Appraisal_task_model->all_sub_departments();
	 $allGrades=$this->Appraisal_task_model->getGrade($result[0]->sub_department_id);
	 $allSubtaskTitle=$this->Appraisal_task_model->allSubtaskTitleByTaskId($id);
	 $allShift=$this->Timesheet_model->get_office_shifts()->result();
	 $allGradeByMainTask=$this->Appraisal_task_model->allGradeByMainTask($id);
	 $shiftId=$result[0]->office_shift_id;
	 ($shiftId==0)?$shiftName='':$shiftName=$this->Timesheet_model->read_office_shift_information($shiftId);
	 $listAllSubtaskTitle='';
	 if(!is_null($allSubtaskTitle)){
	 foreach($allSubtaskTitle as $singSubtaskTitle){
		 $listAllSubtaskTitle.=ucfirst($singSubtaskTitle->sub_task_title_name).', ';
	 }}
	 $data = array(
		 'appraisal_task_id' => $result[0]->id,
		 'department_name' => $result[0]->department_name,
		 'name' => ucfirst($result[0]->name),
		 'description' => $result[0]->description,
		 'subDept' => $allSubDepartment,
		 'subDeptIdAppraisal' => $result[0]->sub_department_id,
		 'arrGrade' => $allGrades,
		 'allGradeByMainTask' => $allGradeByMainTask,
		 'allSubtaskTitle' => $allSubtaskTitle,
		 'listAllSubtaskTitle' => rtrim($listAllSubtaskTitle,', '),
		 'gradeName' => $result[0]->gradeName,
		 'dailyRequirement' => $result[0]->minimum_daily_requirement,
		 'monthlyRequirement' => $result[0]->minimum_monthly_requirement,
		 'currentGradeName' => $result[0]->gradeName,
		 'allShift' => $allShift,
		 'shiftId' => $shiftId,
		 'shiftName' => (empty($shiftName))?'-':$shiftName[0]->shift_name,
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/appraisal/dialog_appraisal_task', $data);
	 } else {redirect('admin/');}
 }
 public function update() {
	  if($this->input->post('edit_type')=='task_list_update') {
	  $id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$paramMainTask=$this->input->post('maintask');
		$paramSubDeptId=$this->input->post('subdepartment_id');
		$paramSubtaskTitle=$this->input->post('subtaskTitle');
		$paramOfficeShift=$this->input->post('office_shift');
		$existingMainTask=$this->Appraisal_task_model->existingMaintask($paramMainTask,$paramSubDeptId,$paramOfficeShift);
		if($paramSubDeptId==='') {
			$Return['error'] = "Please choose sub department.";
		}elseif($paramMainTask==='') {
			$Return['error'] = "Please set a task name.";
		}elseif($paramOfficeShift==='') {
			$Return['error'] = "Please choose office shift.";
		}
		// checking grade & maintask validation.
		if($existingMainTask==='existed'){
			$Return['error']='Main task for the Subdepartment & Shift you choosen was already created.<br>Change the Main Task name or Sub Department or Shift to create a new main task.<br>Or if you\'d like to create a new grade for this Sub Department & Shift click <a href="grade_list"><u>here</u> &raquo;</a>';
		}
		if($Return['error']!='') $this->output($Return);
		$session = $this->session->userdata('username');

		// all sub department
		if($paramSubDeptId=='allSubDepartments_val'){
			$arrSubDept=$this->Grade_model->all_sub_departments()->result();
			foreach($arrSubDept as $singSubdept){
				$mainTaskTableStatus=$this->Appraisal_task_model->mainTaskTableStatus();
				$currentMainTaskId=$mainTaskTableStatus[0]->Auto_increment;
				//grade
				$arrCurrGrade=$this->Grade_model->currentGradeByMaintask($id);
				foreach($arrCurrGrade as $singCurrGrade){
					$dataGrade = array(
						'maintask_id' => $currentMainTaskId,
						'grade_detail_id' => $singCurrGrade->gradeDetailId,
						'minimum_daily_requirement' => $singCurrGrade->dailyRequirement,
						'minimum_monthly_requirement' => $singCurrGrade->monthlyRequirement,
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s'),
					);
					$resultGrade = $this->Grade_model->add($dataGrade);
				}
				// subtask title.
				$arrCurrSubtask=$this->Appraisal_sub_task_model->getAllSubtaskTitleByMainTaskId($id);
				foreach($arrCurrSubtask as $singCurrSubtask){
					$subtaskId=$singCurrSubtask->id;

					if(empty($this->input->post("subtaskTitle$subtaskId"))){
						$dataSubtask = array(
							'sub_task_title_name' => 'kehapus',
						);
						$resultSubtask=$this->Appraisal_task_model->update_subtask_title($dataSubtask,$subtaskId);
					}else{
						$dataSubtask = array(
							# luffy 29 Dec 2019 11:33 am
							// 'maintask_id' => $currentMainTaskId, #no need to update the maintask id
							'sub_department_id' => $paramSubDeptId,
							// 'sub_task_title_name' => $singCurrSubtask->sub_task_title_name,
							# luffy 29 Dec 2019 11:12 am
							'sub_task_title_name' => $this->input->post("subtaskTitle$subtaskId"),
						);
						// $resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
						# luffy 29 Dec 2019 10:42 am
						$resultSubtask=$this->Appraisal_task_model->update_subtask_title($dataSubtask,$subtaskId);
					}
				}
				# luffy 29 Dec 2019 12:36 pm | to add new more subtask title.
				$numberOfSubtask=count($paramSubtaskTitle);
				if($numberOfSubtask>0){
					foreach($paramSubtaskTitle as $singSubtaskTitleonUpdate){
						if(empty($singSubtaskTitleonUpdate)) continue;
						$dataSubtask = array(
							'maintask_id' => $id, #current maintask id
							'sub_department_id' => $paramSubDeptId,
							'sub_task_title_name' => $singSubtaskTitleonUpdate,
						);
						$resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
					}
				}

				// maintask
				if($paramOfficeShift=='allShift_val'){ // all shift
					//update dulu
					$dataMainTask = array(
						'name' => $paramMainTask,
						'description' => htmlspecialchars(addslashes($this->input->post('description')), ENT_QUOTES),
						'sub_department_id' => $singSubdept->sub_department_id,
						'office_shift_id' => 1, //force  shift pagi
					);
					$resultMainTask = $this->Appraisal_task_model->update_record($dataMainTask,$id);
					//baru add new
					$dataMainTaskAdd = array(
						'name' => $paramMainTask,
						'description' => $this->input->post('description'),
						'sub_department_id' => $singSubdept->sub_department_id,
						'office_shift_id' => 2, //force  shift malam
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s')
					);
					$resultMainTaskAdd = $this->Appraisal_task_model->add($dataMainTaskAdd);
					if($resultMainTask==TRUE && $resultMainTaskAdd==TRUE)
						$Return['result'] = "Main task updated.";
					else $Return['error']=$this->lang->line('xin_error_msg');
					$this->output($Return);
					exit;
				}else{ // single shift
					$dataMainTask = array(
						'name' => $paramMainTask,
						'description' => htmlspecialchars(addslashes($this->input->post('description')), ENT_QUOTES),
						'sub_department_id' => $singSubdept->sub_department_id,
						'office_shift_id' => $paramOfficeShift,
					);
					//update if single shift
					$resultMainTask = $this->Appraisal_task_model->update_record($dataMainTask,$id);
					if($resultMainTask==TRUE)
						$Return['result'] = "Main task updated.";
					else $Return['error']=$this->lang->line('xin_error_msg');
					$this->output($Return);
					exit;
				}
				//end maintask
			}
		}

		// single sub department
		else{
			$mainTaskTableStatus=$this->Appraisal_task_model->mainTaskTableStatus();
			$currentMainTaskId=$mainTaskTableStatus[0]->Auto_increment;
			//grade
			$arrCurrGrade=$this->Grade_model->currentGradeByMaintask($id);
			foreach($arrCurrGrade as $singCurrGrade){
				$dataGrade = array(
					'maintask_id' => $currentMainTaskId,
					'grade_detail_id' => $singCurrGrade->gradeDetailId,
					'minimum_daily_requirement' => $singCurrGrade->dailyRequirement,
					'minimum_monthly_requirement' => $singCurrGrade->monthlyRequirement,
					'created_by' => $session['user_id'],
					'created_at' => date('Y-m-d H:i:s'),
				);
				$resultGrade = $this->Grade_model->add($dataGrade);
			}
			// subtask title.
			$arrCurrSubtask=$this->Appraisal_sub_task_model->getAllSubtaskTitleByMainTaskId($id);
			foreach($arrCurrSubtask as $singCurrSubtask){
				$subtaskId=$singCurrSubtask->id;
				$dataSubtask = array(
					# luffy 29 Dec 2019 11:33 am
					// 'maintask_id' => $currentMainTaskId, #no need to update the maintask id
					'sub_department_id' => $paramSubDeptId,
					// 'sub_task_title_name' => $singCurrSubtask->sub_task_title_name,
					# luffy 29 Dec 2019 11:12 am
					'sub_task_title_name' => $this->input->post("subtaskTitle$subtaskId"),
				);
				// $resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
				# luffy 29 Dec 2019 10:42 am
				$resultSubtask=$this->Appraisal_task_model->update_subtask_title($dataSubtask,$subtaskId);
			}
			# luffy 29 Dec 2019 12:27 pm | to add new more subtask title.
			$numberOfSubtask=count($paramSubtaskTitle);
			if($numberOfSubtask>0){
				foreach($paramSubtaskTitle as $singSubtaskTitleonUpdate){
					if(empty($singSubtaskTitleonUpdate)) continue;
					$dataSubtask = array(
						'maintask_id' => $id, #current maintask id
						'sub_department_id' => $paramSubDeptId,
						'sub_task_title_name' => $singSubtaskTitleonUpdate,
					);
					$resultSubtask=$this->Appraisal_task_model->addSubtaskTitle($dataSubtask);
				}
			}

			// maintask
			if($paramOfficeShift=='allShift_val'){ // all shift
				//update dulu
				$dataMainTask = array(
					'name' => $paramMainTask,
					'description' => htmlspecialchars(addslashes($this->input->post('description')), ENT_QUOTES),
					'sub_department_id' => $paramSubDeptId,
					'office_shift_id' => 1, //force  shift pagi
				);
				$resultMainTask = $this->Appraisal_task_model->update_record($dataMainTask,$id);
				//baru add new
				$dataMainTaskAdd = array(
					'name' => $paramMainTask,
					'description' => $this->input->post('description'),
					'sub_department_id' => $paramSubDeptId,
					'office_shift_id' => 2, //force  shift malam
					'created_by' => $session['user_id'],
					'created_at' => date('Y-m-d H:i:s')
				);
				$resultMainTaskAdd = $this->Appraisal_task_model->add($dataMainTaskAdd);
				if($resultMainTask==TRUE && $resultMainTaskAdd==TRUE)
					$Return['result'] = "Main task updated.";
				else $Return['error']=$this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}else{ // single shift
				$dataMainTask = array(
					'name' => $paramMainTask,
					'description' => htmlspecialchars(addslashes($this->input->post('description')), ENT_QUOTES),
					'sub_department_id' => $paramSubDeptId,
					'office_shift_id' => $paramOfficeShift,
				);
				//update if single shift
				$resultMainTask = $this->Appraisal_task_model->update_record($dataMainTask,$id);
				if($resultMainTask==TRUE)
					$Return['result'] = "Main task updated.";
				else $Return['error']=$this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}
			//end maintask
		}



	 }
 }
 public function delete() {
	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	 $id = $this->uri->segment(4);
	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 #del all related assigned main task too.
	 $arrAssignTaskToDelete=$this->Appraisal_task_model->getApprisalByAppraisalTaskId($id);
	 foreach($arrAssignTaskToDelete as $singAppraisalTask){
		 $delAllAssignedTask=$this->Appraisal_task_model->delAssignTaskByMaintaskId($singAppraisalTask->appraisal_task_id);
	 }
	 #delete all the related subtask too
	 $arrSubtaskToDelete=$this->Appraisal_task_model->getSubtaskByMainTaskId($id);
	 foreach($arrSubtaskToDelete as $singSubtask){
		 $delAllSubtask=$this->Appraisal_task_model->delSubtaskByMainTaskId($singSubtask->appraisal_task_id);
	 }
	 #del all related kpi sales too.
	 $arrKpiSalesToDelete=$this->Appraisal_task_model->getKpiByMainTaskId($id);
	 foreach($arrKpiSalesToDelete as $singKpi){
		 $delAllKpi=$this->Appraisal_task_model->delKpiByMaintaskId($singKpi->job_task);
	 }
	 #del all related subtask title too.
	 $arrSubtaskTitleToDelete=$this->Appraisal_task_model->getSubtaskTitleByMainTaskId($id);
	 foreach($arrSubtaskTitleToDelete as $singSubtaskTitle){
		 $delAllSubtaskTitle=$this->Appraisal_task_model->delSubtaskTitleByMaintaskId($singSubtaskTitle->maintask_id);
	 }
	 #del all related grade too.
	 $arrGradeListToDelete=$this->Appraisal_task_model->getGradeListByMainTaskId($id);
	 foreach($arrGradeListToDelete as $singGradeList){
		 $delAllSubtaskTitle=$this->Appraisal_task_model->delGradeListByMaintaskId($singGradeList->maintask_id);
	 }
	 #then del the main task list
	 $result = $this->Appraisal_task_model->delete_record($id);
	 if(isset($id))
		 $Return['result'] = "Main task and <br /> all related to this main task has been deleted: <br /> &raquo; Assign Main Task, Subtask List, KPI Sales & Grade List.";
	 else $Return['error'] = $this->lang->line('xin_error_msg');
	 $this->output($Return);
 }

 # luffy 29 Dec 2019 02:31 pm
 public function delete_subtask_title() {
	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	 $id = $this->uri->segment(4);
	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 $result = $this->Appraisal_task_model->deleteSubtaskTitle($id);
	 if(isset($id))
		 $Return['result'] = "Subtask title deleted.";
	 else $Return['error'] = $this->lang->line('xin_error_msg');
	 $this->output($Return);
 }

}
