<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Appraisal report
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Kpi_report extends MY_Controller {

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
		$this->load->model('Exin_model');
		$this->load->model('Department_model');
		$this->load->model("Employees_model");
		$this->load->model("Appraisal_model");
		$this->load->model("Kpi_report_model");
		$this->load->model("Appraisal_approval_status_model");
		$this->load->model("Designation_model");
		$this->load->model("Payroll_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Appraisal_sub_task_model");
		#$this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
	 }
	public function index(){
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$data['title'] = 'Kpi Report | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Kpi Report';
		$data['path_url'] = 'kpi_report';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1010',$role_resources_ids)){
			$data['subview'] = $this->load->view("admin/kpi_report/report_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
 public function report_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$userId=$session['user_id'];
		if(!empty($session))
			$this->load->view("admin/kpi_report/report_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$reportDaily=$this->input->get('ajaxDaily');
		$reportDately=$this->input->get('ajaxMonthly');
		$reportCustomFrom=$this->input->get('ajaxCustomFrom');
		$reportCustomTo=$this->input->get('ajaxCustomTo');
		if(!empty($reportDaily)) $reportType='daily'; #$reportFilter=$this->input->get("ajaxDaily");
		if(!empty($reportDately)) $reportType='monthly'; #$reportFilter=$this->input->get("ajaxMonthly");
		if(!empty($reportCustomFrom)) $reportType='custom'; #$reportFilter=$this->input->get("ajaxCustomFrom").' - '.$this->input->get("ajaxCustomTo");
		// $arrAppraisalReport = $this->Kpi_report_model->getActiveEmployees($report_month);
		if(in_array('2048',$role_resources_ids))
			$arrAppraisalReport = $this->Kpi_report_model->getActiveEmployees();
		elseif(in_array('2049',$role_resources_ids))
			$arrAppraisalReport = $this->Kpi_report_model->getOwnReport($userId);
		$data=array();
		foreach($arrAppraisalReport as $r) {
			$full_name = $r->first_name.' '.$r->last_name;
			$department=$this->Department_model->read_department_information($r->department_id);
	 	  if(!is_null($department))
	 			$department_name=$department[0]->department_name;
	 	  else $department_name='--';
			if($reportType==='daily'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/kpi_report/detail/id/$r->employee_id/report_type/$reportType/report_daily/$reportDaily'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}elseif($reportType==='monthly'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/kpi_report/detail/id/$r->employee_id/report_type/$reportType/report_month/$reportDately'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}elseif($reportType==='custom'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/kpi_report/detail/id/$r->employee_id/report_type/$reportType/report_custom_from/$reportCustomFrom/report_custom_to/$reportCustomTo'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}else{
				//as default use the montly report.
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/kpi_report/detail/id/$r->employee_id/report_type/$reportType/report_month/$reportDately'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}
			$viewDetail=$detailLink;
			$data[] = array(
				$viewDetail,
				$r->employee_id,
				ucwords(strtolower($r->username)),
				ucwords(strtolower($full_name)),
				(strlen($department_name)>2)?ucwords(strtolower($department_name)):$department_name,
				ucwords(strtolower($r->location_name ? $r->location_name : '-'))
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $arrAppraisalReport,
			"recordsFiltered" => $arrAppraisalReport,
			"data" => $data
		);
		echo json_encode($output);
		exit();
 }
 public function show_report(){
 	if($this->input->post('type')=='show_report') {
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
 		if($this->input->post('company_id')===''){
 			$Return['error'] = $this->lang->line('error_company_field');
 		}elseif($this->input->post('employee_id')===''){
 			$Return['error'] = $this->lang->line('xin_error_employee_id');
 		}elseif($this->input->post('month_year')===''){
 			$Return['error'] = $this->lang->line('xin_hr_report_error_month_field');
 		}
 		if($Return['error']!='')
 			$this->output($Return);
 		$Return['result'] = $this->lang->line('xin_hr_request_submitted');
 		$this->output($Return);
 	}
 }
 public function read() { // buat report detail dialog
	$data['title'] = $this->Xin_model->site_title();
	$id = $this->input->get('appraisal_id');
	$result = $this->Appraisal_model->read_appraisal_information($id);	//all_kpi_report($id)
	$allSubDept=$this->Appraisal_model->all_sub_departments();
	$allJobTask=$this->Appraisal_model->ajax_jobtask_info($result[0]->sub_department_id);
	$allEmployees=$this->Appraisal_model->all_employees();
	$allApprovalStatus=$this->Appraisal_approval_status_model->get_appraisal_status();
	$approvedByName = ($result[0]->approved_by==0)?'Not yet':$result[0]->approvedby_firstname." ".$result[0]->approvedby_lastname;
	$appraisalReportInfo=$this->Kpi_report_model->all_kpi_report($id);
	$taskName=$this->Appraisal_model->getJobtaskNameBy($result[0]->appraisal_task_id)->name;
	$data = array(
		'appraisal_id'	=> $result[0]->id,
		'reviewer' => $result[0]->reviewer_firstname." ".$result[0]->reviewer_lastname,
		'approvedBy' => $approvedByName,
		'employee' => $result[0]->first_name." ".$result[0]->last_name,
		'department' => $result[0]->department_name,
		'subDepartment' => $result[0]->subdept_deptname,
		'jobTaskName' => $result[0]->jobtask_jobtaskname,
		'finalPoint' => $result[0]->final_point,
		'grade' => $result[0]->gradeName,
		'period' => date('F Y', strtotime($result[0]->start_date,time())),
		'appraisalStatus' => $result[0]->appraisal_status,
		'approvalStatus' => $result[0]->approval_status,
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
		'taskName' => $taskName,
		// employee bonus
		'bonus' => ($appraisalReportInfo->total_bonus>0)?'Rp. '.number_format($appraisalReportInfo->total_bonus,0,",","."):0,
		'totalRewardsPoint' => $appraisalReportInfo->total_rewards_point,
		'totalRewardsAmount' => (!is_null($appraisalReportInfo->total_rewards_amount))?'Rp. '.number_format($appraisalReportInfo->total_rewards_amount,0,",","."):0,
		'totalPunishmentPoint' => $appraisalReportInfo->total_punishment_point,
		'totalPunishmentAmount' => (!is_null($appraisalReportInfo->total_punishment_amount))?'Rp. '.number_format($appraisalReportInfo->total_punishment_amount,0,",","."):0
	);
	$session = $this->session->userdata('username');
	if(!empty($session))
		$this->load->view('admin/kpi_report/dialog_kpi_report', $data);
	else redirect('admin/');
}
 // get company > employees
 public function get_employees() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array('company_id'=>$id);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/kpi_report/get_employees", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
 }
 public function detail(){
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$reportType=$this->uri->segment(7);
		$employeeId=$this->uri->segment(5);
		$reportDate=$this->uri->segment(9);
		$reportDateAPIformatFrom=date('Y-m-d',strtotime($reportDate));
		// API date format for AMP and TMP
		if($reportType==='custom'){
			$reportDateAPIformatTo=date('Y-m-d',strtotime($this->uri->segment(11)));
		}elseif($reportType==='monthly'){
			$reportDate=$reportDate.'-01';
			$reportDateAPIformatFrom=date("Y-m-d", strtotime($reportDate)); #today
	    $firstDateOfTheMonth = new DateTime($reportDate);
			$reportDateAPIformatFrom=$firstDateOfTheMonth->modify('first day of this month')->format('Y-m-d');
	    $lastDateOfTheMonth = new DateTime($reportDate);
			$reportDateAPIformatTo=$lastDateOfTheMonth->modify('last day of this month')->format('Y-m-d');
		}else{ #daily
			$reportDateAPIformatTo=$reportDateAPIformatFrom;
		}
		// nik validation
		$user=$this->Kpi_report_model->read_user_info($employeeId); #byNIK #eg:7380
		if(!is_null($user)){
			$first_name = $user[0]->first_name; $last_name = $user[0]->last_name;
		}else{
			$Return['error']="///Employee with NIK $employeeId is not exist///";
			if($Return['error']!='')
				header("refresh:6; url=".site_url('admin/kpi_report'));
				$this->output($Return);
		}
		// // 30 days validation, it's used for custom date only :)
		// // next coba nanti validasi ini pindahkan ke setiap trasaction API di AMP ataupun TMP
		// $dateFrom = new DateTime($reportDateAPIformatFrom);
		// $dateTo = new DateTime($reportDateAPIformatTo);
		// $rangeDate = $dateTo->diff($dateFrom)->format("%a");
		// if($rangeDate>30){
		// 	$Return['error']="///Test  30 days validation///";
		// 	if($Return['error']!='')
		// 		header("refresh:6; url=".site_url('admin/kpi_report'));
		// 		echo 'Error from AMP. <br />Status code 405: Date range can not more than 30 days.';
		// 		exit;
		// }
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation))
			$designation_name=$designation[0]->designation_name;
		else $designation_name='--';
		$department=$this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department))
			$department_name=$department[0]->department_name;
		else $department_name='--';
		$subDept=$this->Department_model->read_sub_department_info($user[0]->sub_department_id);
		if(!is_null($subDept))
			$subDeptName=$subDept[0]->department_name;
		else $subDeptName='--';
		// All KPI Sales list
		$userId=$user[0]->user_id;
		$subDeptId=$user[0]->sub_department_id;
		$shiftId=$user[0]->office_shift_id;
		$startDate=$reportDateAPIformatFrom;
		$toDate=$reportDateAPIformatTo;
		$allKpi=$this->Kpi_report_model->allKpiBySubdeptAndShift($subDeptId,$shiftId)->result();

		$employeeEmail=$user[0]->email;
		if($reportType==='daily'){
			$period=date("j F Y", strtotime($reportDate));
		}elseif($reportType==='monthly'){
			$period=date("F Y", strtotime($reportDate));
		}elseif($reportType==='custom'){
			$period=date("j F Y", strtotime($reportDate)).' &nbsp; to &nbsp; '.date("j F Y", strtotime($reportDateAPIformatTo));
		};
		$data = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'username' => $user[0]->username,
			'userId' => $user[0]->user_id,
			'employee_id' => $employeeId,
			'contact_no' => $user[0]->contact_no,
			'date_of_joining' => $user[0]->date_of_joining,
			'department_name' => $department_name,
			'subDeptName' => $subDeptName,
			'designation_name' => $designation_name,
			'date_of_joining' => $user[0]->date_of_joining,
			'profile_picture' => $user[0]->profile_picture,
			'gender' => $user[0]->gender,
			'officeLocation' => $user[0]->fingerprint_location,
			'allKpi' => $allKpi,
			'employeeEmail' => $employeeEmail,
			'title' => 'Employee Appraisal Report | '.$this->Xin_model->site_title(),
			'all_employees' => $this->Xin_model->all_employees(),
			'breadcrumbs' => "KPI report detail",
			'path_url' => 'kpi_report',
			'reportType' => $reportType,
			'reportMonth' => $reportDate,
			'reportMonthTo' => $reportDateAPIformatTo,
			'period' => $period,
			'subDeptid' => $user[0]->sub_department_id,
			'startDate' => $reportDateAPIformatFrom,
			'toDate' => $reportDateAPIformatTo,
		);
		if(!empty($session)){
			$data['subview'] = $this->load->view("admin/kpi_report/detail", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data);
		} else {
			redirect('admin/');
		}
 }
}
