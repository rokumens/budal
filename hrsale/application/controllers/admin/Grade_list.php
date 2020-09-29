<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Grade list
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_list extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Grade_model");
		$this->load->model("Grade_detail_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Xin_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Appraisal_model");
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
		$data['title'] = 'Grade List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Grade List';
		$data['path_url'] = 'grade_list';
		$data['all_sub_departments'] = $this->Appraisal_task_model->all_sub_departments();
		$data['allGradeDetail'] = $this->Grade_detail_model->all_grade_detail()->result();
		$data['allShift'] = $this->Timesheet_model->get_office_shifts()->result();
		$data['allMainTask'] = $this->Appraisal_task_model->all_appraisal_task()->result();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$gradeList = $this->Grade_model->all_minimum_requirements();
		if(in_array('1007',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/grade_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
  public function grade_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/appraisal/grade_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$gradeList = $this->Grade_model->all_minimum_requirements();
		$data = array();
		foreach($gradeList as $r) {
			if(in_array('2031',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-grade_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			}else{
				$edit = '';
			}
			if(in_array('2032',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			}else{
				$delete = '';
			}
			if(in_array('2033',$role_resources_ids)) { //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-grade_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			}else{
				$view = '';
			}
			$shiftId=$r->office_shift_id;
	 	  ($shiftId==0)?$shiftName='':$shiftName=$this->Timesheet_model->read_office_shift_information($shiftId);
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$r->grade_name,
				number_format($r->minimum_monthly_requirement,0,'.','.').' x',
				(empty($r->maintaskName))?'-':$r->maintaskName,
				(empty($r->department_name))?'-':$r->department_name,
				(empty($shiftName))?'-':$shiftName[0]->shift_name,
			);
		}
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $gradeList,
			 "recordsFiltered" => $gradeList,
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// get auto subdept name based on the main task.
	public function get_subdept() {
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 $maintaskId = $this->uri->segment(4);
		 $data = array('maintask_id' => $maintaskId);
		 if(!empty($session)){
			 $this->load->view("admin/appraisal/subDeptByMaintask", $data);
		 } else {
			 redirect('admin/');
		 }
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	public function add_grade() {
		if($this->input->post('add_type')=='add_grade') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$paramGradeDetailId=$this->input->post('grade_detail_id');
			$paramSubDeptId=$this->input->post('subdepartment_id');
			$paramDailyRequirement=$this->input->post('dailyRequirement');
			$paramMonthlyRequirement=$this->input->post('monthlyRequirement');
			$paramMainTask=$this->input->post('maintask');
			$paramShift=$this->input->post('office_shift');
			// ga boleh ada grade sama & requirement sama, dalam 1 subdept.
			$checkExistingGrade=$this->Grade_model->existingGrade_By_MaintaskGradeMonthlyRequirement($paramMainTask,$paramGradeDetailId,$paramMonthlyRequirement);
			// ga boleh: grade apapun, selama minimum requirement sama dalam 1 sub dept.
			$checkExistingGrade2=$this->Grade_model->existingGrade_By_MaintaskSubdeptShiftMonthlyRequirement($paramMainTask,$paramSubDeptId,$paramShift,$paramMonthlyRequirement);
			// ga boleh: ada grade sama dalam 1 subdept & shift.
			// jgn applly yg ini di update.
			$checkExistingGrade3=$this->Grade_model->existingGrade_By_GradeDetailIdMaintaskSubdeptShift($paramGradeDetailId,$paramMainTask,$paramSubDeptId,$paramShift);
			if($paramGradeDetailId==='') {
				$Return['error'] = "Please choose grade.";
			}elseif($this->input->post('dailyRequirement')===''){
				$Return['error'] = "Please set daily minimum requirement.";
			}elseif($this->input->post('monthlyRequirement')===''){
				$Return['error'] = "Please set monthly minimum requirement.";
			}elseif($paramMainTask==='') {
				$Return['error'] = "Please choose main task.<br>Add more task from Main Task in the menu.";
			}elseif($checkExistingGrade==='existed'){
				$Return['error'] = 'The grade you choosed for this maintask with the same minimum requirement exists already.<br>Try to change the grade or the minimum requirement.';
			}elseif($checkExistingGrade2==='existed'){
				$Return['error'] = 'The grade you choosed for this maintask with the same shift & minimum requirement exists already.<br>Try to change the shift or the minimum requirement.';
			}elseif($checkExistingGrade3==='existed'){
				$Return['error'] = 'The grade you choosed for under this subdepartment with the same shift exists already.<br>Try to change the grade or the shift.';
			}
			if($Return['error']!='') $this->output($Return);
			$session = $this->session->userdata('username');
			//multiple loop saving by "All Sub Department".
			if($paramSubDeptId=='allSubDepartments_val'){
				$arrSubDept=$this->Grade_model->all_sub_departments()->result();
		    foreach($arrSubDept as $singSubdept){
					$data=array(
						'grade_detail_id' => $paramGradeDetailId,
						'minimum_daily_requirement' => $this->input->post('dailyRequirement'),
						'minimum_monthly_requirement' => $this->input->post('monthlyRequirement'),
						'maintask_id' => $paramMainTask,
						'created_by' => $session['user_id'],
						'created_at' => date('Y-m-d H:i:s'),
					);
					// ga boleh ada grade sama, dalam 1 subdept.
					$skipExistingGrade=$this->Grade_model->existingGrade_By_MaintaskGradeMonthlyRequirement($paramMainTask,$paramGradeDetailId,$paramMonthlyRequirement);
					if($skipExistingGrade==='existed') continue;
					$result = $this->Grade_model->add($data);
				}
				if($result==TRUE)
					$Return['result'] = "New multiple grades created.";
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}else{	// adding single grade
				$data=array(
					'grade_detail_id' => $paramGradeDetailId,
					'minimum_daily_requirement' => $this->input->post('dailyRequirement'),
					'minimum_monthly_requirement' => $this->input->post('monthlyRequirement'),
					'maintask_id' => $paramMainTask,
					'created_by' => $session['user_id'],
					'created_at' => date('Y-m-d H:i:s'),
				);
				$result = $this->Grade_model->add($data);
				if($result == TRUE)
					$Return['result'] = "New grade added.";
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			}
		}
	}
	public function read() {
	 $data['title']=$this->Xin_model->site_title();
	 $id=$this->input->get('grade_id');
	 $result=$this->Grade_model->read_requirement_information($id);
	 $gradeId=$result[0]->id;
	 $gradeDetailId=$result[0]->grade_detail_id;
	 $subDeptId=$result[0]->sub_department_id;
	 $arrGrade=$this->Grade_detail_model->all_grade_detail()->result();
	 $arrSubDept=$this->Grade_model->all_sub_departments()->result();
	 $allShift=$this->Timesheet_model->get_office_shifts()->result();
	 $shiftId=$result[0]->office_shift_id;
	 ($shiftId==0)?$shiftName='':$shiftName=$this->Timesheet_model->read_office_shift_information($shiftId);
	 $allMainTask=$this->Appraisal_task_model->all_appraisal_task()->result();
	 $mainTaskid=$result[0]->maintask_id;
	 $mainTaskName=$result[0]->mainTaskName;
	 $data = array(
		 'grade_id' => $gradeId,
		 'gradeDetailId' => $gradeDetailId,
		 'allGradeDetail' => $arrGrade,
		 'subDeptId' => $subDeptId,
		 'allSubDept' => $arrSubDept,
		 'gradeName' => $result[0]->grade_name,
		 'gradeDescription' => $result[0]->grade_description,
		 'minimumPercentage' => $result[0]->minimum_percentage,
		 'maximumPercentage' => $result[0]->maximum_percentage,
		 'subDepartmentName' => $result[0]->department_name,
		 'dailyRequirement'	=> $result[0]->minimum_daily_requirement,
		 'monthlyRequirement' => $result[0]->minimum_monthly_requirement,
		 'allShift' => $allShift,
		 'shiftId' => $shiftId,
		 'shiftName' => (empty($shiftName))?'-':$shiftName[0]->shift_name,
		 'allMainTask' => $allMainTask,
		 'mainTaskId' => $mainTaskid,
		 'mainTaskName' => $mainTaskName,
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session))
		 $this->load->view('admin/appraisal/dialog_grade', $data);
	 else redirect('admin/');
 }
  public function update() {
 	 if($this->input->post('edit_type')=='grade_update') {
 	  $id = $this->uri->segment(4);
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$paramGradeDetailId=$this->input->post('grade_detail_id');
		$paramSubDeptId=$this->input->post('subdepartment_id');
		$paramDailyRequirement=$this->input->post('dailyRequirement');
		$paramMonthlyRequirement=$this->input->post('monthlyRequirement');
		$paramMainTask=$this->input->post('maintask');
		$paramShift=$this->input->post('office_shift');
		// ga boleh ada grade sama, dalam 1 subdept.
		$checkExistingGrade=$this->Grade_model->existingGrade_By_MaintaskGradeMonthlyRequirement($paramMainTask,$paramGradeDetailId,$paramMonthlyRequirement);
		// ga boleh: grade apapun, selama minimum requirement sama dalam 1 sub dept.
		$checkExistingGrade2=$this->Grade_model->existingGrade_By_MaintaskSubdeptShiftMonthlyRequirement($paramMainTask,$paramSubDeptId,$paramShift,$paramMonthlyRequirement);
		if($paramGradeDetailId===''){
			$Return['error'] = "Please choose grade.";
		}elseif($this->input->post('dailyRequirement')===''){
			$Return['error'] = "Daily Minimum Requirement is required.";
		}elseif($this->input->post('monthlyRequirement')===''){
			$Return['error'] = "Monthly Minimum Requirement is required.";
		}elseif($checkExistingGrade==='existed'){
			$Return['error'] = 'The grade you choosed for this maintask with the same minimum requirement exists already.<br>Try to change the grade or the minimum requirement.';
		}elseif($checkExistingGrade2==='existed'){
			$Return['error'] = 'The grade you choosed for this maintask with the same grade, shift & minimum requirement exists already.<br>Try to change the grade or the shift or the minimum requirement.';
		}elseif($checkExistingGrade2==='existed'){
			$Return['error'] = 'The grade you choosed for this maintask with the same grade, shift & minimum requirement exists already.<br>Try to change the grade or the shift or the minimum requirement.';
		}
		if($Return['error']!='')
			$this->output($Return);
 		$session = $this->session->userdata('username');
 		$dataGrade = array(
			#ini buat grade, ya update grade aja jgn ke sana ke sini ga jelas.
			'grade_detail_id' => $paramGradeDetailId,
			'minimum_daily_requirement' => $this->input->post('dailyRequirement'),
			'minimum_monthly_requirement' => $this->input->post('monthlyRequirement'),
			'updated_by' => $session['user_id'],
			'updated_at' => date('Y-m-d H:i:s')
	 	 );
	 	 $result = $this->Grade_model->update_record($dataGrade,$id);
	 	 if($result == TRUE)
	 		 $Return['result'] = "Grade has been updated.";
	 	 else $Return['error'] = $this->lang->line('xin_error_msg');
	 	 $this->output($Return);
	 	 exit;
 	 }
  }
	public function delete(){
 	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 	 $id = $this->uri->segment(4);
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
 	 $result = $this->Grade_model->delete_record($id);
 	 if(isset($id))
 		 $Return['result'] = "Grade has been deleted successfully.";
 	 else $Return['error'] = $this->lang->line('xin_error_msg');
 	 $this->output($Return);
  }

}
