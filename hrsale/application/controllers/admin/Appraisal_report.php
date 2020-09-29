<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Appraisal report
 */
defined('BASEPATH') OR exit('No direct script access allowed');
// for API AMP
define("AMPURL", "http://amp.kanonplay.com"); #luffy API for AMP
// for API TMP
define("TMPURL", "http://tmp.kanonplay.com"); #luffy API for TMP
class Appraisal_report extends MY_Controller {

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
		$this->load->model("Appraisal_report_model");
		$this->load->model("Appraisal_approval_status_model");
		#$this->load->model("Reports_model");
		$this->load->model("Designation_model");
		$this->load->model("Payroll_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Appraisal_sub_task_model");
		#$this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
	 }
	// payslip reports > employees and company
	public function index(){
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$data['title'] = 'Appraisal Report | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Appraisal Report';
		$data['path_url'] = 'appraisal_report';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1010',$role_resources_ids)){
			$data['subview'] = $this->load->view("admin/appraisal_report/report_list", $data, TRUE);
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
			$this->load->view("admin/appraisal_report/report_list", $data);
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
		// $arrAppraisalReport = $this->Appraisal_report_model->getActiveEmployees($report_month);
		if(in_array('2048',$role_resources_ids))
			$arrAppraisalReport = $this->Appraisal_report_model->getActiveEmployees();
		elseif(in_array('2049',$role_resources_ids))
			$arrAppraisalReport = $this->Appraisal_report_model->getOwnReport($userId);
		$data=array();
		foreach($arrAppraisalReport as $r) {
			$full_name = $r->first_name.' '.$r->last_name;
			$department=$this->Department_model->read_department_information($r->department_id);
	 	  if(!is_null($department))
	 			$department_name=$department[0]->department_name;
	 	  else $department_name='--';
			if($reportType==='daily'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/appraisal_report/detail/id/$r->employee_id/report_type/$reportType/report_daily/$reportDaily'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}elseif($reportType==='monthly'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/appraisal_report/detail/id/$r->employee_id/report_type/$reportType/report_month/$reportDately'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}elseif($reportType==='custom'){
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/appraisal_report/detail/id/$r->employee_id/report_type/$reportType/report_custom_from/$reportCustomFrom/report_custom_to/$reportCustomTo'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
			}else{
				//as default use the montly report.
				$detailLink="<span data-toggle='tooltip' data-placement='top' title='View Detail'><a href='".site_url()."admin/appraisal_report/detail/id/$r->employee_id/report_type/$reportType/report_month/$reportDately'><button type='button' class='btn icon-btn btn-xs btn-default waves-effect waves-light'><span class='fa fa-arrow-circle-right'></span></button></a></span>";
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
	$result = $this->Appraisal_model->read_appraisal_information($id);	//all_appraisal_report($id)
	$allSubDept=$this->Appraisal_model->all_sub_departments();
	$allJobTask=$this->Appraisal_model->ajax_jobtask_info($result[0]->sub_department_id);
	$allEmployees=$this->Appraisal_model->all_employees();
	$allApprovalStatus=$this->Appraisal_approval_status_model->get_appraisal_status();
	$approvedByName = ($result[0]->approved_by==0)?'Not yet':$result[0]->approvedby_firstname." ".$result[0]->approvedby_lastname;
	$appraisalReportInfo=$this->Appraisal_report_model->all_appraisal_report($id);
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
		$this->load->view('admin/appraisal_report/dialog_appraisal_report', $data);
	else redirect('admin/');
}
 // get company > employees
 public function get_employees() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array('company_id'=>$id);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/appraisal_report/get_employees", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
 }

 ///////////////////////////////////// API function for AMP start /////////////////////////////////////
 /*
	* NOTE: API function for AMP by Luffy for Authentication & Transaction.
 */
 /****************** API AMP Authentication ******************/
 function authenticate_API_AMP($companyId,$method,$endPoint) {
	 $apiURL = AMPURL . "/" . $endPoint;
	 $curl = curl_init();
	 $postFields=array();
	 switch($companyId){
		 case '168':
			 $postFields=array(
				 "company" => $companyId, #string
				 "secret" => '0eef14addbb3203cc8f73f3b98abdf9a',
				 "login" => 'a2_kanonhost_com',
				 "password" => 'txujJ$WQufpsw0gq',
			 );
			 break;
		 case "001":
			 $postFields=array(
				 "company" => $companyId, #string
				 "secret" => '0eef14addbb3203cc8f73f3b98abdf9a',
				 "login" => 'a2_kanonhost_com',
				 "password" => 'aZJ8h2?3A29gunAh',
			 );
			 break;
			
	 }
	 switch($method){
		 case "GET":
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			 break;
		 case "POST":
			 curl_setopt($curl,CURLOPT_URL,$apiURL);
			 curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			 curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
			 curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$method); #POST
			 curl_setopt($curl,CURLOPT_POSTFIELDS,$postFields);
			 break;
		 case "PUT":
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			 break;
		 case "DELETE":
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 break;
	 }
	 $response = curl_exec($curl);
	 $data = json_decode($response);
	 /****************** checking 404 ******************/
	 $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	 // checking http status code
	 switch($httpCode){
		 case 200:
 			 $statusError="Status code 200: Success from AMP";
 			 return ($data);
 			 break;
 		 case 401:
 			 $statusError="Error from AMP. <br /> Status code 401: Unauthorized";
 			 return ($data);
 			 break;
 		 case 404:
 			 $statusError="Error from AMP. <br /> Status code 404: API Not found";
 			 break;
 		 case 500:
 			 $statusError="Error from AMP. <br /> Status code 500: servers replied with an error.";
 			 break;
 		 case 502:
 			 $statusError="Error from AMP. <br /> Status code 502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
 			 break;
 		 case 503:
 			 $statusError="Error from AMP. <br /> Status code 503: service unavailable. Hopefully they'll be OK soon!";
 			 break;
 		 default:
 			 $statusError="Error from AMP. <br /> Status code: " . $httpCode . " (Bad Request) " . curl_error($curl);
 			 break;
	 }
	 curl_close($curl);
	 echo $statusError;
	 die;
 }
 /****************** Transaction ******************/
 function transaction_API_AMP($brandId,$startDate,$endDate,$type,$method,$endPoint,$bearerKey, $channel){
	 $transactionHeader = array(
		 "brand" => $brandId, #integer
		 "start_date" => $startDate, #d-m-Y
		 "end_date" => $endDate, #d-m-Y
		 "type" => $type, #DEPO #WD #TF
		 "channel" => $channel #ADMIN #MEMBER
	 );
	 $apiURL = AMPURL . "/" . $endPoint;
	 $curl = curl_init();
	 switch($method){
		 case "GET":
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			 break;
		 case "POST":
			 curl_setopt($curl,CURLOPT_URL,$apiURL);
			 curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			 curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
			 curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$method); #POST
			 curl_setopt($curl,CURLOPT_POSTFIELDS,$transactionHeader);
			 curl_setopt($curl,CURLOPT_HTTPHEADER,array(
				 'Authorization: Bearer '.$bearerKey
			 ));
			 break;
		 case "PUT":
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			 break;
		 case "DELETE":
			 // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			 // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			 break;
	 }
	 $response = curl_exec($curl);
	 $data = json_decode($response);
	 // checking 404
	 $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
	 // checking http status code
	 switch($httpCode){
		 case 200:
 			 $statusError="Status code 200: Success from AMP";
 			 return ($data);
 			 break;
 		 case 401:
 			 $statusError="Error from AMP. <br /> Status code 401: Unauthorized";
 			 return ($data);
 			 break;
 		 case 404:
 			 $statusError="Error from AMP. <br /> Status code 404: API Not found";
 			 break;
 		 case 500:
 			 $statusError="Error from AMP. <br /> Status code 500: servers replied with an error.";
 			 break;
 		 case 502:
 			 $statusError="Error from AMP. <br /> Status code 502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
 			 break;
 		 case 503:
 			 $statusError="Error from AMP. <br /> Status code 503: service unavailable. Hopefully they'll be OK soon!";
 			 break;
 		 default:
 			 $statusError="Error from AMP. <br /> Status code: " . $httpCode . " (Bad Request) " . curl_error($curl);
 			 break;
	 }
	 curl_close($curl);
	 echo $statusError;
	 die;
 }
 // filtering the API data for created_by to get the nik id.
 function filterAPIResponseDataByEmployeeId_CreatedBy_AMP($API_response, $userNikId){
	return array_filter($API_response, function($API_singResponse) use ($userNikId) {
		// if(substr($API_singResponse['approved_by'],-4) == $userNikId){
		// 	return true;
		// }
		$createdBy=$API_singResponse['created_by'];
		if((strlen($createdBy)>4)&&(substr($createdBy,-4)==$userNikId)){
			return true;
		}elseif($createdBy==$userNikId){
			return true;
		}
	});
 }
 // filtering the API data for approved_by to get the nik id.
 function filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($API_response, $userNikId){
	return array_filter($API_response, function($API_singResponse) use ($userNikId) {
		$approvedBy=$API_singResponse['approved_by'];
		if((strlen($approvedBy)>4)&&(substr($approvedBy,-4)==$userNikId)){
			return true;
		}elseif($approvedBy==$userNikId){
			return true;
		}
	});
 }


 ///////////////////////////////////// API function for AMP end /////////////////////////////////////

 ///////////////////////////////////// API function for TMP start /////////////////////////////////////
 /*
 * NOTE: API function for TMP by Luffy for Authentication & Transaction.
 */
 /****************** API TMP Authentication ******************/
 function authenticate_API_TMP($method,$endPoint) {
	$apiURL = TMPURL . "/" . $endPoint;
	$curl = curl_init();
	$email = urlencode('application@mail.com');
	$password = urlencode('tmpapi123**##');
	switch($method){
		case "GET":
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		case "POST":
			curl_setopt_array($curl, array(
				CURLOPT_URL => $apiURL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => "email=$email&password=$password",
				CURLOPT_HTTPHEADER => array(
					'content-type: application/x-www-form-urlencoded',
					'x-api-key: API-key-dari-TMP-kalau-ada',
				),
			));
			break;
		case "PUT":
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			break;
		case "DELETE":
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			break;
	}
	$response = curl_exec($curl);
	$data = json_decode($response);
	/****************** checking 404 ******************/
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	// checking http status code
	switch($httpCode){
		case 200:
			$statusError="Status code 200: Success from TMP";
			return ($data);
			break;
		case 401:
			$statusError="Error from TMP. <br /> Status code 401: Unauthorized";
			return ($data);
			break;
		case 404:
			$statusError="Error from TMP. <br /> Status code 404: API Not found";
			break;
		case 500:
			$statusError="Error from TMP. <br /> Status code 500: servers replied with an error.";
			break;
		case 502:
			$statusError="Error from TMP. <br /> Status code 502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
			break;
		case 503:
			$statusError="Error from TMP. <br /> Status code 503: service unavailable. Hopefully they'll be OK soon!";
			break;
		default:
			$statusError="Error from TMP. <br /> Status code: " . $httpCode . " (Bad Request) " . curl_error($curl);
			break;
	}
	curl_close($curl);
	echo $statusError;
	die;
 }
 /****************** Transaction TMP ******************/
 function transaction_API_TMP($startDate,$endDate,$type,$method,$endPoint,$bearerKey,$channel) {
	$transactionHeader = array(
		"start_date" => $startDate, #d-m-Y
		"end_date" => $endDate, #d-m-Y
		"type" => $type, #DEPO #WD #TF
		"channel" => $channel #ADMIN #MEMBER
	);
	$apiURL = TMPURL . "/" . $endPoint;
	$curl = curl_init();
	switch($method){
		case "GET":
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		case "POST":
			curl_setopt($curl,CURLOPT_URL,$apiURL);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl,CURLOPT_TIMEOUT,120);
			curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$method); #POST
			curl_setopt($curl,CURLOPT_POSTFIELDS,$transactionHeader);
			curl_setopt($curl,CURLOPT_HTTPHEADER,array(
				'Authorization: Bearer '.$bearerKey
			));
			break;
		case "PUT":
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			break;
		case "DELETE":
			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			break;
	}
	$response = curl_exec($curl);
	$data = json_decode($response);
	// checking 404
	$httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
	// checking http status code
	switch($httpCode){
		case 200:
			$statusError="Status code 200: Success from TMP";
			return ($data);
			break;
		case 401:
			$statusError="Error from TMP. <br /> Status code 401: Unauthorized";
			return ($data);
			break;
		case 404:
			$statusError="Error from TMP. <br /> Status code 404: API Not found";
			break;
		case 500:
			$statusError="Error from TMP. <br /> Status code 500: servers replied with an error.";
			break;
		case 502:
			$statusError="Error from TMP. <br /> Status code 502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
			break;
		case 503:
			$statusError="Error from TMP. <br /> Status code 503: service unavailable. Hopefully they'll be OK soon!";
			break;
		default:
			$statusError="Error from TMP. <br /> Status code: " . $httpCode . " (Bad Request) " . curl_error($curl);
			break;
	}
	curl_close($curl);
	echo $statusError;
	die;
 }
 function filterAPIResponseDataByEmployeeId_CreatedBy_TMP($API_response, $userNikId){
	 return array_filter($API_response, function($API_singResponse) use ($userNikId) {
		 $API_userEmailAddress = $API_singResponse['created_by'];
		 $API_NikId = explode("@",$API_userEmailAddress);
		 array_pop($API_NikId); #remove last element.
		 $API_NikId = implode("@",$API_NikId);
		 if($API_NikId===$userNikId){
			 return true;
		 }
	 });
 }
 function filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($API_response, $userNikId){
	 return array_filter($API_response, function($API_singResponse) use ($userNikId) {
		 $API_userEmailAddress = $API_singResponse['approved_by'];
		 $API_NikId = explode("@",$API_userEmailAddress);
		 array_pop($API_NikId); #remove last element.
		 $API_NikId = implode("@",$API_NikId);
		 if($API_NikId===$userNikId){
			 return true;
		 }
	 });
 }
 ///////////////////////////////////// API function for TMP end /////////////////////////////////////
 public function detail(){
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$employeeId=$this->uri->segment(5);
		$reportType=$this->uri->segment(7);
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
		///// VALIDATION /////
		// nik validation
		$user=$this->Appraisal_report_model->read_user_info($employeeId); #byNIK #eg:7380
		if(!is_null($user)){
			$first_name = $user[0]->first_name; $last_name = $user[0]->last_name;
		}else{
			$Return['error']="///Employee with NIK $employeeId is not exist///";
			if($Return['error']!='')
				header("refresh:6; url=".site_url('admin/appraisal_report'));
				$this->output($Return);
		}
		// 30 days validation
		// next coba nanti validasi ini pindahkan ke setiap trasaction API di AMP ataupun TMP
		$dateFrom = new DateTime($reportDateAPIformatFrom);
		$dateTo = new DateTime($reportDateAPIformatTo);
		$rangeDate = $dateTo->diff($dateFrom)->format("%a");
		if($rangeDate>30){
			$Return['error']="///Error from AMP: Date range can not more than 30 days.///";
			if($Return['error']!='')
				header("refresh:6; url=".site_url('admin/appraisal_report'));
				echo 'Error from AMP. <br />Status code 405: Date range can not more than 30 days.';
				exit;
		}
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
		$allMainTask=$this->Appraisal_report_model->allAppraisalByMainTaskAndShift($user[0]->sub_department_id,$user[0]->office_shift_id)->result();
		$allConnectResponse=$this->Appraisal_report_model->a1AllConnectResponse();
		$employeeEmail=$user[0]->email;
		if($reportType==='daily'){
			$period=date("j F Y", strtotime($reportDate));
		}elseif($reportType==='monthly'){
			$period=date("F Y", strtotime($reportDate));
		}elseif($reportType==='custom'){
			$period=date("j F Y", strtotime($reportDate)).' &nbsp; to &nbsp; '.date("j F Y", strtotime($reportDateAPIformatTo));
		};


		# luffy dumping
		/********** AMP start **********/
		///// WD brand Anonymous AMP start /////
		// CREATED BY
		$arrResponse_WD_168_Anonymous_CreatedBy_AMP = $this->Appraisal_report_model->getWidrawalAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD created_by
		$totalAction_WD_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Anonymous_CreatedBy_AMP!='')
		$totalAction_WD_168_Anonymous_CreatedBy_AMP=count($arrResponse_WD_168_Anonymous_CreatedBy_AMP);
		// total amount widrawal amount created_by
		$totalAmount_WD_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Anonymous_CreatedBy_AMP!='')
		$totalAmount_WD_168_Anonymous_CreatedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		// APPROVED BY
		$arrResponse_WD_168_Anonymous_ApprovedBy_AMP = $this->Appraisal_report_model->getWidrawalAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD approved_by
		$totalAction_WD_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Anonymous_ApprovedBy_AMP!='')
		$totalAction_WD_168_Anonymous_ApprovedBy_AMP=count($arrResponse_WD_168_Anonymous_ApprovedBy_AMP);
		// total amount widrawal amount approved_by
		$totalAmount_WD_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Anonymous_ApprovedBy_AMP!='')
		$totalAmount_WD_168_Anonymous_ApprovedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		///// WD brand Anonymous AMP end /////

		///// WD brand Seniormasteragent AMP start /////
		// CREATED BY
		$arrResponse_WD_168_Seniormasteragent_CreatedBy_AMP = $this->Appraisal_report_model->getWidrawalSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD created_by
		$totalAction_WD_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAction_WD_168_Seniormasteragent_CreatedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_CreatedBy_AMP);
		// total amount widrawal amount created_by
		$totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		// APPROVED BY
		$arrResponse_WD_168_Seniormasteragent_ApprovedBy_AMP = $this->Appraisal_report_model->getWidrawalSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD approved_by
		$totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_ApprovedBy_AMP);
		// total amount widrawal amount approved_by
		$totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		///// WD brand Seniormasteragent AMP end /////

		///// WD brand Ayosbobet AMP start /////
		// CREATED BY
		$arrResponse_WD_168_Ayosbobet_CreatedBy_AMP = $this->Appraisal_report_model->getWidrawalAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD created_by
		$totalAction_WD_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAction_WD_168_Ayosbobet_CreatedBy_AMP=count($arrResponse_WD_168_Ayosbobet_CreatedBy_AMP);
		// total amount widrawal amount created_by
		$totalAmount_WD_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_WD_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAmount_WD_168_Ayosbobet_CreatedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		// APPROVED BY
		$arrResponse_WD_168_Ayosbobet_ApprovedBy_AMP = $this->Appraisal_report_model->getWidrawalAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD approved_by
		$totalAction_WD_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAction_WD_168_Ayosbobet_ApprovedBy_AMP=count($arrResponse_WD_168_Ayosbobet_ApprovedBy_AMP);
		// total amount widrawal amount approved_by
		$totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_WD_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		///// WD brand Ayosbobet AMP end /////

		///// WD brand SbobetHoki AMP start /////
		// CREATED BY
		$arrResponse_WD_001_SbobetHoki_CreatedBy_AMP = $this->Appraisal_report_model->getWidrawalSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD created_by
		$totalAction_WD_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_WD_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAction_WD_001_SbobetHoki_CreatedBy_AMP=count($arrResponse_WD_001_SbobetHoki_CreatedBy_AMP);
		// total amount widrawal amount created_by
		$totalAmount_WD_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_WD_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAmount_WD_001_SbobetHoki_CreatedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		// APPROVED BY
		$arrResponse_WD_001_SbobetHoki_ApprovedBy_AMP = $this->Appraisal_report_model->getWidrawalSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action WD approved_by
		$totalAction_WD_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_WD_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAction_WD_001_SbobetHoki_ApprovedBy_AMP=count($arrResponse_WD_001_SbobetHoki_ApprovedBy_AMP);
		// total amount widrawal amount approved_by
		$totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_WD_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP=$this->Appraisal_report_model->sumWidrawalAmountSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		///// WD brand SbobetHoki AMP end /////

		// FINAL total all WD ----------
		// all action
		$totalALLAction_WD_AMP = $totalAction_WD_168_Anonymous_CreatedBy_AMP + $totalAction_WD_168_Anonymous_ApprovedBy_AMP + 
		$totalAction_WD_168_Seniormasteragent_CreatedBy_AMP + $totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP + 
		$totalAction_WD_168_Ayosbobet_CreatedBy_AMP + $totalAction_WD_168_Ayosbobet_ApprovedBy_AMP + 
		$totalAction_WD_001_SbobetHoki_CreatedBy_AMP + $totalAction_WD_001_SbobetHoki_ApprovedBy_AMP;
		// all amount
		$totalALLAmount_WD_AMP = $totalAmount_WD_168_Anonymous_CreatedBy_AMP + $totalAmount_WD_168_Anonymous_ApprovedBy_AMP + 
		$totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP + $totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP + 
		$totalAmount_WD_168_Ayosbobet_CreatedBy_AMP + $totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP + 
		$totalAmount_WD_001_SbobetHoki_CreatedBy_AMP + $totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP;

		///// DEPO brand Anonymous AMP start /////
		// CREATED BY
		$arrResponse_DEPO_168_Anonymous_CreatedBy_AMP = $this->Appraisal_report_model->getDepoAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO created_by
		$totalAction_DEPO_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Anonymous_CreatedBy_AMP!='')
		$totalAction_DEPO_168_Anonymous_CreatedBy_AMP=count($arrResponse_DEPO_168_Anonymous_CreatedBy_AMP);
		// total amount depo amount created_by
		$totalAmount_DEPO_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Anonymous_CreatedBy_AMP!='')
		$totalAmount_DEPO_168_Anonymous_CreatedBy_AMP=$this->Appraisal_report_model->sumDepoAmountAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		// APPROVED BY
		$arrResponse_DEPO_168_Anonymous_ApprovedBy_AMP = $this->Appraisal_report_model->getDepoAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO approved_by
		$totalAction_DEPO_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Anonymous_ApprovedBy_AMP!='')
		$totalAction_DEPO_168_Anonymous_ApprovedBy_AMP=count($arrResponse_DEPO_168_Anonymous_ApprovedBy_AMP);
		// total amount depo amount approved_by
		$totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Anonymous_ApprovedBy_AMP!='')
		$totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP=$this->Appraisal_report_model->sumDepoAmountAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		///// DEPO brand Anonymous AMP end /////

		///// DEPO brand Seniormasteragent AMP start /////
		// CREATED BY
		$arrResponse_DEPO_168_Seniormasteragent_CreatedBy_AMP = $this->Appraisal_report_model->getDepoSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO created_by
		$totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_CreatedBy_AMP);
		// total amount depo amount created_by
		$totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP=$this->Appraisal_report_model->sumDepoAmountSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		// APPROVED BY
		$arrResponse_DEPO_168_Seniormasteragent_ApprovedBy_AMP = $this->Appraisal_report_model->getDepoSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO approved_by
		$totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_ApprovedBy_AMP);
		// total amount depo amount approved_by
		$totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP=$this->Appraisal_report_model->sumDepoAmountSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		///// DEPO brand Seniormasteragent AMP end /////

		///// DEPO brand Ayosbobet AMP start /////
		// CREATED BY
		$arrResponse_DEPO_168_Ayosbobet_CreatedBy_AMP = $this->Appraisal_report_model->getDepoAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO created_by
		$totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_CreatedBy_AMP);
		// total amount depo amount created_by
		$totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_DEPO_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP=$this->Appraisal_report_model->sumDepoAmountAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		// APPROVED BY
		$arrResponse_DEPO_168_Ayosbobet_ApprovedBy_AMP = $this->Appraisal_report_model->getDepoAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO approved_by
		$totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_ApprovedBy_AMP);
		// total amount depo amount approved_by
		$totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP=$this->Appraisal_report_model->sumDepoAmountAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		///// DEPO brand Ayosbobet AMP end /////

		///// DEPO brand SbobetHoki AMP start /////
		// CREATED BY
		$arrResponse_DEPO_001_SbobetHoki_CreatedBy_AMP = $this->Appraisal_report_model->getDepoSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO created_by
		$totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_DEPO_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_CreatedBy_AMP);
		// total amount depo amount created_by
		$totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_DEPO_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP=$this->Appraisal_report_model->sumDepoAmountSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		// APPROVED BY
		$arrResponse_DEPO_001_SbobetHoki_ApprovedBy_AMP = $this->Appraisal_report_model->getDepoSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action DEPO approved_by
		$totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_ApprovedBy_AMP);
		// total amount depo amount approved_by
		$totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_DEPO_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP=$this->Appraisal_report_model->sumDepoAmountSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDepo;
		///// DEPO brand SbobetHoki AMP end /////

		// FINAL total all DEPO ----------
		// all action
		$totalALLAction_DEPO_AMP = $totalAction_DEPO_168_Anonymous_CreatedBy_AMP + $totalAction_DEPO_168_Anonymous_ApprovedBy_AMP + 
		$totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP + $totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP + 
		$totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP + $totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP + 
		$totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP + $totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP;
		// all amount
		$totalALLAmount_DEPO_AMP = $totalAmount_DEPO_168_Anonymous_CreatedBy_AMP + $totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP + 
		$totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP + $totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP + 
		$totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP + $totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP + 
		$totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP + $totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP;

		///// TF brand Anonymous AMP start /////
		// CREATED BY
		$arrResponse_TF_168_Anonymous_CreatedBy_AMP = $this->Appraisal_report_model->getTransferAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer created_by
		$totalAction_TF_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Anonymous_CreatedBy_AMP!='')
		$totalAction_TF_168_Anonymous_CreatedBy_AMP=count($arrResponse_TF_168_Anonymous_CreatedBy_AMP);
		// total amount transfer amount created_by
		$totalAmount_TF_168_Anonymous_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Anonymous_CreatedBy_AMP!='')
		$totalAmount_TF_168_Anonymous_CreatedBy_AMP=$this->Appraisal_report_model->sumTransferAmountAnonymousCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		// APPROVED BY
		$arrResponse_TF_168_Anonymous_ApprovedBy_AMP = $this->Appraisal_report_model->getTransferAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer approved_by
		$totalAction_TF_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Anonymous_ApprovedBy_AMP!='')
		$totalAction_TF_168_Anonymous_ApprovedBy_AMP=count($arrResponse_TF_168_Anonymous_ApprovedBy_AMP);
		// total amount transfer amount approved_by
		$totalAmount_TF_168_Anonymous_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Anonymous_ApprovedBy_AMP!='')
		$totalAmount_TF_168_Anonymous_ApprovedBy_AMP=$this->Appraisal_report_model->sumTransferAmountAnonymousApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		///// TF brand Anonymous AMP end /////

		///// TF brand Seniormasteragent AMP start /////
		// CREATED BY
		$arrResponse_TF_168_Seniormasteragent_CreatedBy_AMP = $this->Appraisal_report_model->getTransferSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer created_by
		$totalAction_TF_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAction_TF_168_Seniormasteragent_CreatedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_CreatedBy_AMP);
		// total amount transfer amount created_by
		$totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Seniormasteragent_CreatedBy_AMP!='')
		$totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP=$this->Appraisal_report_model->sumTransferAmountSeniormasteragentCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		// APPROVED BY
		$arrResponse_TF_168_Seniormasteragent_ApprovedBy_AMP = $this->Appraisal_report_model->getTransferSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer approved_by
		$totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_ApprovedBy_AMP);
		// total amount transfer amount approved_by
		$totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Seniormasteragent_ApprovedBy_AMP!='')
		$totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP=$this->Appraisal_report_model->sumTransferAmountSeniormasteragentApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		///// TF brand Seniormasteragent AMP end /////

		///// TF brand Ayosbobet AMP start /////
		// CREATED BY
		$arrResponse_TF_168_Ayosbobet_CreatedBy_AMP = $this->Appraisal_report_model->getTransferAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer created_by
		$totalAction_TF_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAction_TF_168_Ayosbobet_CreatedBy_AMP=count($arrResponse_TF_168_Ayosbobet_CreatedBy_AMP);
		// total amount transfer amount created_by
		$totalAmount_TF_168_Ayosbobet_CreatedBy_AMP=0;
		if($arrResponse_TF_168_Ayosbobet_CreatedBy_AMP!='')
		$totalAmount_TF_168_Ayosbobet_CreatedBy_AMP=$this->Appraisal_report_model->sumTransferAmountAyosbobetCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		// APPROVED BY
		$arrResponse_TF_168_Ayosbobet_ApprovedBy_AMP = $this->Appraisal_report_model->getTransferAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer approved_by
		$totalAction_TF_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAction_TF_168_Ayosbobet_ApprovedBy_AMP=count($arrResponse_TF_168_Ayosbobet_ApprovedBy_AMP);
		// total amount transfer amount approved_by
		$totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP=0;
		if($arrResponse_TF_168_Ayosbobet_ApprovedBy_AMP!='')
		$totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP=$this->Appraisal_report_model->sumTransferAmountAyosbobetApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		///// TF brand Ayosbobet AMP end /////

		///// TF brand SbobetHoki AMP start /////
		// CREATED BY
		$arrResponse_TF_001_SbobetHoki_CreatedBy_AMP = $this->Appraisal_report_model->getTransferSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer created_by
		$totalAction_TF_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_TF_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAction_TF_001_SbobetHoki_CreatedBy_AMP=count($arrResponse_TF_001_SbobetHoki_CreatedBy_AMP);
		// total amount transfer amount created_by
		$totalAmount_TF_001_SbobetHoki_CreatedBy_AMP=0;
		if($arrResponse_TF_001_SbobetHoki_CreatedBy_AMP!='')
		$totalAmount_TF_001_SbobetHoki_CreatedBy_AMP=$this->Appraisal_report_model->sumTransferAmountSbobetHokiCreatedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		// APPROVED BY
		$arrResponse_TF_001_SbobetHoki_ApprovedBy_AMP = $this->Appraisal_report_model->getTransferSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action transfer approved_by
		$totalAction_TF_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_TF_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAction_TF_001_SbobetHoki_ApprovedBy_AMP=count($arrResponse_TF_001_SbobetHoki_ApprovedBy_AMP);
		// total amount transfer amount approved_by
		$totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP=0;
		if($arrResponse_TF_001_SbobetHoki_ApprovedBy_AMP!='')
		$totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP=$this->Appraisal_report_model->sumTransferAmountSbobetHokiApprovedBy_AMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		///// TF brand SbobetHoki AMP end /////

		// FINAL total all TF ----------
		// all action
		$totalALLAction_TF_AMP = $totalAction_TF_168_Anonymous_CreatedBy_AMP + $totalAction_TF_168_Anonymous_ApprovedBy_AMP +
		$totalAction_TF_168_Seniormasteragent_CreatedBy_AMP + $totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP +
		$totalAction_TF_168_Ayosbobet_CreatedBy_AMP + $totalAction_TF_168_Ayosbobet_ApprovedBy_AMP +
		$totalAction_TF_001_SbobetHoki_CreatedBy_AMP + $totalAction_TF_001_SbobetHoki_ApprovedBy_AMP;
		// all amount
		$totalALLAmount_TF_AMP = $totalAmount_TF_168_Anonymous_CreatedBy_AMP + $totalAmount_TF_168_Anonymous_ApprovedBy_AMP +
		$totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP + $totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP +
		$totalAmount_TF_168_Ayosbobet_CreatedBy_AMP + $totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP +
		$totalAmount_TF_001_SbobetHoki_CreatedBy_AMP + $totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP;

		/********** AMP end **********/

		/********** TMP start **********/

		///// DEPO on TMP start /////
		// CREATED BY
		$arrResponse_DEPO_CreatedBy_TMP = $this->Appraisal_report_model->getDepositCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action deposit created_by
		$totalAction_DEPO_CreatedBy_TMP = 0;
		if ($arrResponse_DEPO_CreatedBy_TMP != '') {
			$totalAction_DEPO_CreatedBy_TMP = count($arrResponse_DEPO_CreatedBy_TMP);
		}
		// total amount deposit amount created_by
		$totalAmount_DEPO_CreatedBy_TMP = 0;
		if ($arrResponse_DEPO_CreatedBy_TMP != '') {
			$totalAmount_DEPO_CreatedBy_TMP = $this->Appraisal_report_model->sumDepositAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDeposit;
		}
		// APPROVED BY
		$arrResponse_DEPO_ApprovedBy_TMP = $this->Appraisal_report_model->getDepositApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action deposit created_by
		$totalAction_DEPO_ApprovedBy_TMP = 0;
		if ($arrResponse_DEPO_ApprovedBy_TMP != '') {
			$totalAction_DEPO_ApprovedBy_TMP = count($arrResponse_DEPO_ApprovedBy_TMP);
		}
		// total amount deposit amount created_by
		$totalAmount_DEPO_ApprovedBy_TMP = 0;
		if ($arrResponse_DEPO_ApprovedBy_TMP != '') {
			$totalAmount_DEPO_ApprovedBy_TMP = $this->Appraisal_report_model->sumDepositAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalDeposit;
		}
		// FINAL total all DEPO ----------
		// all action
		$totalAllAction_DEPO_TMP = $totalAction_DEPO_CreatedBy_TMP + $totalAction_DEPO_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_DEPO_TMP = $totalAmount_DEPO_CreatedBy_TMP + $totalAmount_DEPO_ApprovedBy_TMP;
		///// DEPO on TMP end /////

		///// WD on TMP start /////
		// CREATED BY
		$arrResponse_WD_CreatedBy_TMP = $this->Appraisal_report_model->getWidrawalCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Widrawal created_by
		$totalAction_WD_CreatedBy_TMP = 0;
		if ($arrResponse_WD_CreatedBy_TMP != '') {
			$totalAction_WD_CreatedBy_TMP = count($arrResponse_WD_CreatedBy_TMP);
		}
		// total amount Widrawal amount created_by
		$totalAmount_WD_CreatedBy_TMP = 0;
		if ($arrResponse_WD_CreatedBy_TMP != '') {
			$totalAmount_WD_CreatedBy_TMP = $this->Appraisal_report_model->sumWidrawalAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		}
		// APPROVED BY
		$arrResponse_WD_ApprovedBy_TMP = $this->Appraisal_report_model->getWidrawalApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Widrawal created_by
		$totalAction_WD_ApprovedBy_TMP = 0;
		if ($arrResponse_WD_ApprovedBy_TMP != '') {
			$totalAction_WD_ApprovedBy_TMP = count($arrResponse_WD_ApprovedBy_TMP);
		}
		// total amount Widrawal amount created_by
		$totalAmount_WD_ApprovedBy_TMP = 0;
		if ($arrResponse_WD_ApprovedBy_TMP != '') {
			$totalAmount_WD_ApprovedBy_TMP = $this->Appraisal_report_model->sumWidrawalAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalWidrawal;
		}
		// FINAL total all WD ----------
		// all action
		$totalAllAction_WD_TMP = $totalAction_WD_CreatedBy_TMP + $totalAction_WD_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_WD_TMP = $totalAmount_WD_CreatedBy_TMP + $totalAmount_WD_ApprovedBy_TMP;
		///// WD on TMP end /////

		///// TF on TMP start /////
		// CREATED BY
		$arrResponse_TF_CreatedBy_TMP = $this->Appraisal_report_model->getTransferCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Transfer created_by
		$totalAction_TF_CreatedBy_TMP = 0;
		if ($arrResponse_TF_CreatedBy_TMP != '') {
			$totalAction_TF_CreatedBy_TMP = count($arrResponse_TF_CreatedBy_TMP);
		}
		// total amount Transfer amount created_by
		$totalAmount_TF_CreatedBy_TMP = 0;
		if ($arrResponse_TF_CreatedBy_TMP != '') {
			$totalAmount_TF_CreatedBy_TMP = $this->Appraisal_report_model->sumTransferAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		}
		// APPROVED BY
		$arrResponse_TF_ApprovedBy_TMP = $this->Appraisal_report_model->getTransferApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Transfer created_by
		$totalAction_TF_ApprovedBy_TMP = 0;
		if ($arrResponse_TF_ApprovedBy_TMP != '') {
			$totalAction_TF_ApprovedBy_TMP = count($arrResponse_TF_ApprovedBy_TMP);
		}
		// total amount Transfer amount created_by
		$totalAmount_TF_ApprovedBy_TMP = 0;
		if ($arrResponse_TF_ApprovedBy_TMP != '') {
			$totalAmount_TF_ApprovedBy_TMP = $this->Appraisal_report_model->sumTransferAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalTransfer;
		}
		// FINAL total all TF ----------
		// all action
		$totalAllAction_TF_TMP = $totalAction_TF_CreatedBy_TMP + $totalAction_TF_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_TF_TMP = $totalAmount_TF_CreatedBy_TMP + $totalAmount_TF_ApprovedBy_TMP;
		///// TF on TMP end /////

		///// ADJ on TMP start /////
		// CREATED BY
		$arrResponse_ADJ_CreatedBy_TMP = $this->Appraisal_report_model->getAdjustmentCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Adjustment created_by
		$totalAction_ADJ_CreatedBy_TMP = 0;
		if ($arrResponse_ADJ_CreatedBy_TMP != '') {
			$totalAction_ADJ_CreatedBy_TMP = count($arrResponse_ADJ_CreatedBy_TMP);
		}
		// total amount Adjustment amount created_by
		$totalAmount_ADJ_CreatedBy_TMP = 0;
		if ($arrResponse_ADJ_CreatedBy_TMP != '') {
			$totalAmount_ADJ_CreatedBy_TMP = $this->Appraisal_report_model->sumAdjustmentAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalAdjustment;
		}
		// APPROVED BY
		$arrResponse_ADJ_ApprovedBy_TMP = $this->Appraisal_report_model->getAdjustmentApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Adjustment created_by
		$totalAction_ADJ_ApprovedBy_TMP = 0;
		if ($arrResponse_ADJ_ApprovedBy_TMP != '') {
			$totalAction_ADJ_ApprovedBy_TMP = count($arrResponse_ADJ_ApprovedBy_TMP);
		}
		// total amount Adjustment amount created_by
		$totalAmount_ADJ_ApprovedBy_TMP = 0;
		if ($arrResponse_ADJ_ApprovedBy_TMP != '') {
			$totalAmount_ADJ_ApprovedBy_TMP = $this->Appraisal_report_model->sumAdjustmentAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalAdjustment;
		}
		// FINAL total all ADJ ----------
		// all action
		$totalAllAction_ADJ_TMP = $totalAction_ADJ_CreatedBy_TMP + $totalAction_ADJ_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_ADJ_TMP = $totalAmount_ADJ_CreatedBy_TMP + $totalAmount_ADJ_ApprovedBy_TMP;
		///// ADJ on TMP end /////

		///// BONUS on TMP start /////
		// CREATED BY
		$arrResponse_BONUS_CreatedBy_TMP = $this->Appraisal_report_model->getBonusCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Bonus created_by
		$totalAction_BONUS_CreatedBy_TMP = 0;
		if ($arrResponse_BONUS_CreatedBy_TMP != '') {
			$totalAction_BONUS_CreatedBy_TMP = count($arrResponse_BONUS_CreatedBy_TMP);
		}
		// total amount Bonus amount created_by
		$totalAmount_BONUS_CreatedBy_TMP = 0;
		if ($arrResponse_BONUS_CreatedBy_TMP != '') {
			$totalAmount_BONUS_CreatedBy_TMP = $this->Appraisal_report_model->sumBonusAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalBonus;
		}
		// APPROVED BY
		$arrResponse_BONUS_ApprovedBy_TMP = $this->Appraisal_report_model->getBonusApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Bonus created_by
		$totalAction_BONUS_ApprovedBy_TMP = 0;
		if ($arrResponse_BONUS_ApprovedBy_TMP != '') {
			$totalAction_BONUS_ApprovedBy_TMP = count($arrResponse_BONUS_ApprovedBy_TMP);
		}
		// total amount Bonus amount created_by
		$totalAmount_BONUS_ApprovedBy_TMP = 0;
		if ($arrResponse_BONUS_ApprovedBy_TMP != '') {
			$totalAmount_BONUS_ApprovedBy_TMP = $this->Appraisal_report_model->sumBonusAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalBonus;
		}
		// FINAL total all BONUS ----------
		// all action
		$totalAllAction_BONUS_TMP = $totalAction_BONUS_CreatedBy_TMP + $totalAction_BONUS_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_BONUS_TMP = $totalAmount_BONUS_CreatedBy_TMP + $totalAmount_BONUS_ApprovedBy_TMP;
		///// BONUS on TMP end /////

		///// Commission on TMP start /////
		// CREATED BY
		$arrResponse_Commission_CreatedBy_TMP = $this->Appraisal_report_model->getCommissionCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Commission created_by
		$totalAction_COMMISSION_CreatedBy_TMP = 0;
		if ($arrResponse_Commission_CreatedBy_TMP != '') {
			$totalAction_COMMISSION_CreatedBy_TMP = count($arrResponse_Commission_CreatedBy_TMP);
		}
		// total amount Commission amount created_by
		$totalAmount_COMMISSION_CreatedBy_TMP = 0;
		if ($arrResponse_Commission_CreatedBy_TMP != '') {
			$totalAmount_COMMISSION_CreatedBy_TMP = $this->Appraisal_report_model->sumCommissionAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCommission;
		}
		// APPROVED BY
		$arrResponse_Commission_ApprovedBy_TMP = $this->Appraisal_report_model->getCommissionApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Commission created_by
		$totalAction_COMMISSION_ApprovedBy_TMP = 0;
		if ($arrResponse_Commission_ApprovedBy_TMP != '') {
			$totalAction_COMMISSION_ApprovedBy_TMP = count($arrResponse_Commission_ApprovedBy_TMP);
		}
		// total amount Commission amount created_by
		$totalAmount_COMMISSION_ApprovedBy_TMP = 0;
		if ($arrResponse_Commission_ApprovedBy_TMP != '') {
			$totalAmount_COMMISSION_ApprovedBy_TMP = $this->Appraisal_report_model->sumCommissionAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCommission;
		}
		// FINAL total all Commission ----------
		// all action
		$totalAllAction_COMMISSION_TMP = $totalAction_COMMISSION_CreatedBy_TMP + $totalAction_COMMISSION_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_COMMISSION_TMP = $totalAmount_COMMISSION_CreatedBy_TMP + $totalAmount_COMMISSION_ApprovedBy_TMP;
		///// Commission on TMP end /////

		///// Cashback on TMP start /////
		// CREATED BY
		$arrResponse_Cashback_CreatedBy_TMP = $this->Appraisal_report_model->getCashbackCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Cashback created_by
		$totalAction_CASHBACK_CreatedBy_TMP = 0;
		if ($arrResponse_Cashback_CreatedBy_TMP != '') {
			$totalAction_CASHBACK_CreatedBy_TMP = count($arrResponse_Cashback_CreatedBy_TMP);
		}
		// total amount Cashback amount created_by
		$totalAmount_CASHBACK_CreatedBy_TMP = 0;
		if ($arrResponse_Cashback_CreatedBy_TMP != '') {
			$totalAmount_CASHBACK_CreatedBy_TMP = $this->Appraisal_report_model->sumCashbackAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCashback;
		}
		// APPROVED BY
		$arrResponse_Cashback_ApprovedBy_TMP = $this->Appraisal_report_model->getCashbackApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Cashback created_by
		$totalAction_CASHBACK_ApprovedBy_TMP = 0;
		if ($arrResponse_Cashback_ApprovedBy_TMP != '') {
			$totalAction_CASHBACK_ApprovedBy_TMP = count($arrResponse_Cashback_ApprovedBy_TMP);
		}
		// total amount Cashback amount created_by
		$totalAmount_CASHBACK_ApprovedBy_TMP = 0;
		if ($arrResponse_Cashback_ApprovedBy_TMP != '') {
			$totalAmount_CASHBACK_ApprovedBy_TMP = $this->Appraisal_report_model->sumCashbackAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCashback;
		}
		// FINAL total all Cashback ----------
		// all action
		$totalAllAction_CASHBACK_TMP = $totalAction_CASHBACK_CreatedBy_TMP + $totalAction_CASHBACK_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_CASHBACK_TMP = $totalAmount_CASHBACK_CreatedBy_TMP + $totalAmount_CASHBACK_ApprovedBy_TMP;
		///// Cashback on TMP end /////

		///// Referral on TMP start /////
		// CREATED BY
		$arrResponse_Referral_CreatedBy_TMP = $this->Appraisal_report_model->getReferralCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Referral created_by
		$totalAction_REFERRAL_CreatedBy_TMP = 0;
		if ($arrResponse_Referral_CreatedBy_TMP != '') {
			$totalAction_REFERRAL_CreatedBy_TMP = count($arrResponse_Referral_CreatedBy_TMP);
		}
		// total amount Referral amount created_by
		$totalAmount_REFERRAL_CreatedBy_TMP = 0;
		if ($arrResponse_Referral_CreatedBy_TMP != '') {
			$totalAmount_REFERRAL_CreatedBy_TMP = $this->Appraisal_report_model->sumReferralAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalReferral;
		}
		// APPROVED BY
		$arrResponse_Referral_ApprovedBy_TMP = $this->Appraisal_report_model->getReferralApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Referral created_by
		$totalAction_REFERRAL_ApprovedBy_TMP = 0;
		if ($arrResponse_Referral_ApprovedBy_TMP != '') {
			$totalAction_REFERRAL_ApprovedBy_TMP = count($arrResponse_Referral_ApprovedBy_TMP);
		}
		// total amount Referral amount created_by
		$totalAmount_REFERRAL_ApprovedBy_TMP = 0;
		if ($arrResponse_Referral_ApprovedBy_TMP != '') {
			$totalAmount_REFERRAL_ApprovedBy_TMP = $this->Appraisal_report_model->sumReferralAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalReferral;
		}
		// FINAL total all Referral ----------
		// all action
		$totalAllAction_REFERRAL_TMP = $totalAction_REFERRAL_CreatedBy_TMP + $totalAction_REFERRAL_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_REFERRAL_TMP = $totalAmount_REFERRAL_CreatedBy_TMP + $totalAmount_REFERRAL_ApprovedBy_TMP;
		///// Referral on TMP end /////

		///// Freebet on TMP start /////
		// CREATED BY
		$arrResponse_Freebet_CreatedBy_TMP = $this->Appraisal_report_model->getFreebetCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Freebet created_by
		$totalAction_FREEBET_CreatedBy_TMP = 0;
		if ($arrResponse_Freebet_CreatedBy_TMP != '') {
			$totalAction_FREEBET_CreatedBy_TMP = count($arrResponse_Freebet_CreatedBy_TMP);
		}
		// total amount Freebet amount created_by
		$totalAmount_FREEBET_CreatedBy_TMP = 0;
		if ($arrResponse_Freebet_CreatedBy_TMP != '') {
			$totalAmount_FREEBET_CreatedBy_TMP = $this->Appraisal_report_model->sumFreebetAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalFreebet;
		}
		// APPROVED BY
		$arrResponse_Freebet_ApprovedBy_TMP = $this->Appraisal_report_model->getFreebetApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Freebet created_by
		$totalAction_FREEBET_ApprovedBy_TMP = 0;
		if ($arrResponse_Freebet_ApprovedBy_TMP != '') {
			$totalAction_FREEBET_ApprovedBy_TMP = count($arrResponse_Freebet_ApprovedBy_TMP);
		}
		// total amount Freebet amount created_by
		$totalAmount_FREEBET_ApprovedBy_TMP = 0;
		if ($arrResponse_Freebet_ApprovedBy_TMP != '') {
			$totalAmount_FREEBET_ApprovedBy_TMP = $this->Appraisal_report_model->sumFreebetAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalFreebet;
		}
		// FINAL total all Freebet ----------
		// all action
		$totalAllAction_FREEBET_TMP = $totalAction_FREEBET_CreatedBy_TMP + $totalAction_FREEBET_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_FREEBET_TMP = $totalAmount_FREEBET_CreatedBy_TMP + $totalAmount_FREEBET_ApprovedBy_TMP;
		///// Freebet on TMP end /////

		///// Affiliate on TMP start /////
		// CREATED BY
		$arrResponse_Affiliate_CreatedBy_TMP = $this->Appraisal_report_model->getAffiliateCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Affiliate created_by
		$totalAction_AFFILIATE_CreatedBy_TMP = 0;
		if ($arrResponse_Affiliate_CreatedBy_TMP != '') {
			$totalAction_AFFILIATE_CreatedBy_TMP = count($arrResponse_Affiliate_CreatedBy_TMP);
		}
		// total amount Affiliate amount created_by
		$totalAmount_AFFILIATE_CreatedBy_TMP = 0;
		if ($arrResponse_Affiliate_CreatedBy_TMP != '') {
			$totalAmount_AFFILIATE_CreatedBy_TMP = $this->Appraisal_report_model->sumAffiliateAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalAffiliate;
		}
		// APPROVED BY
		$arrResponse_Affiliate_ApprovedBy_TMP = $this->Appraisal_report_model->getAffiliateApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Affiliate created_by
		$totalAction_AFFILIATE_ApprovedBy_TMP = 0;
		if ($arrResponse_Affiliate_ApprovedBy_TMP != '') {
			$totalAction_AFFILIATE_ApprovedBy_TMP = count($arrResponse_Affiliate_ApprovedBy_TMP);
		}
		// total amount Affiliate amount created_by
		$totalAmount_AFFILIATE_ApprovedBy_TMP = 0;
		if ($arrResponse_Affiliate_ApprovedBy_TMP != '') {
			$totalAmount_AFFILIATE_ApprovedBy_TMP = $this->Appraisal_report_model->sumAffiliateAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalAffiliate;
		}
		// FINAL total all Affiliate ----------
		// all action
		$totalAllAction_AFFILIATE_TMP = $totalAction_AFFILIATE_CreatedBy_TMP + $totalAction_AFFILIATE_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_AFFILIATE_TMP = $totalAmount_AFFILIATE_CreatedBy_TMP + $totalAmount_AFFILIATE_ApprovedBy_TMP;
		///// Affiliate on TMP end /////

		///// Surrender on TMP start /////
		// CREATED BY
		$arrResponse_Surrender_CreatedBy_TMP = $this->Appraisal_report_model->getSurrenderCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Surrender created_by
		$totalAction_SURRENDER_CreatedBy_TMP = 0;
		if ($arrResponse_Surrender_CreatedBy_TMP != '') {
			$totalAction_SURRENDER_CreatedBy_TMP = count($arrResponse_Surrender_CreatedBy_TMP);
		}
		// total amount Surrender amount created_by
		$totalAmount_SURRENDER_CreatedBy_TMP = 0;
		if ($arrResponse_Surrender_CreatedBy_TMP != '') {
			$totalAmount_SURRENDER_CreatedBy_TMP = $this->Appraisal_report_model->sumSurrenderAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalSurrender;
		}
		// APPROVED BY
		$arrResponse_Surrender_ApprovedBy_TMP = $this->Appraisal_report_model->getSurrenderApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Surrender created_by
		$totalAction_SURRENDER_ApprovedBy_TMP = 0;
		if ($arrResponse_Surrender_ApprovedBy_TMP != '') {
			$totalAction_SURRENDER_ApprovedBy_TMP = count($arrResponse_Surrender_ApprovedBy_TMP);
		}
		// total amount Surrender amount created_by
		$totalAmount_SURRENDER_ApprovedBy_TMP = 0;
		if ($arrResponse_Surrender_ApprovedBy_TMP != '') {
			$totalAmount_SURRENDER_ApprovedBy_TMP = $this->Appraisal_report_model->sumSurrenderAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalSurrender;
		}
		// FINAL total all Surrender ----------
		// all action
		$totalAllAction_SURRENDER_TMP = $totalAction_SURRENDER_CreatedBy_TMP + $totalAction_SURRENDER_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_SURRENDER_TMP = $totalAmount_SURRENDER_CreatedBy_TMP + $totalAmount_SURRENDER_ApprovedBy_TMP;
		///// Surrender on TMP end /////

		///// Cancel on TMP start /////
		// CREATED BY
		$arrResponse_Cancel_CreatedBy_TMP = $this->Appraisal_report_model->getCancelCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Cancel created_by
		$totalAction_CANCEL_CreatedBy_TMP = 0;
		if ($arrResponse_Cancel_CreatedBy_TMP != '') {
			$totalAction_CANCEL_CreatedBy_TMP = count($arrResponse_Cancel_CreatedBy_TMP);
		}
		// total amount Cancel amount created_by
		$totalAmount_CANCEL_CreatedBy_TMP = 0;
		if ($arrResponse_Cancel_CreatedBy_TMP != '') {
			$totalAmount_CANCEL_CreatedBy_TMP = $this->Appraisal_report_model->sumCancelAmountCreatedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCancel;
		}
		// APPROVED BY
		$arrResponse_Cancel_ApprovedBy_TMP = $this->Appraisal_report_model->getCancelApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo);
		// total action Cancel created_by
		$totalAction_CANCEL_ApprovedBy_TMP = 0;
		if ($arrResponse_Cancel_ApprovedBy_TMP != '') {
			$totalAction_CANCEL_ApprovedBy_TMP = count($arrResponse_Cancel_ApprovedBy_TMP);
		}
		// total amount Cancel amount created_by
		$totalAmount_CANCEL_ApprovedBy_TMP = 0;
		if ($arrResponse_Cancel_ApprovedBy_TMP != '') {
			$totalAmount_CANCEL_ApprovedBy_TMP = $this->Appraisal_report_model->sumCancelAmountApprovedBy_TMP($employeeId, $reportDateAPIformatFrom, $reportDateAPIformatTo)->totalCancel;
		}
		// FINAL total all Cancel ----------
		// all action
		$totalAllAction_CANCEL_TMP = $totalAction_CANCEL_CreatedBy_TMP + $totalAction_CANCEL_ApprovedBy_TMP;
		// all amount
		$totalAllAmount_CANCEL_TMP = $totalAmount_CANCEL_CreatedBy_TMP + $totalAmount_CANCEL_ApprovedBy_TMP;
		///// Cancel on TMP end /////

		/********** TMP end **********/

		# luffy end dumping


	// 	/**************************************** API act for AMP ****************************************/
	// 	#Authentication
	// 	$authenticationEndPoint_AMP='API/v1/authenticate/';
	// 	#Authenticate Company 168
	// 	$authenticationAPI_Company_168_AMP = $this->authenticate_API_AMP('168','POST',$authenticationEndPoint_AMP); #168 string
	// 	$authenticationResponse_Company_168_AMP = json_decode(json_encode($authenticationAPI_Company_168_AMP),true);
	// 	if(401!==$authenticationResponse_Company_168_AMP['status']){ #Unauthorized
	// 		$authenticationData_Company_168_AMP = $authenticationResponse_Company_168_AMP['data'];
	// 		$authenticationAccessToken_Company_168_AMP = $authenticationResponse_Company_168_AMP['data']['access_token'];
	// 		$authenticationStatus_Company_168_AMP = $authenticationResponse_Company_168_AMP['status'];
	// 		$authenticationMessage_Company_168_AMP = $authenticationResponse_Company_168_AMP['message'];
	// 	}
	// 	#Authenticate Company 001
	// 	$authenticationAPI_Company_001_AMP = $this->authenticate_API_AMP('001','POST',$authenticationEndPoint_AMP); #001 string
	// 	$authenticationResponse_Company_001_AMP = json_decode(json_encode($authenticationAPI_Company_001_AMP),true);
	// 	if(401!==$authenticationResponse_Company_001_AMP['status']){ #Unauthorized
	// 		$authenticationData_Company_001_AMP = $authenticationResponse_Company_001_AMP['data'];
	// 		$authenticationAccessToken_Company_001_AMP = $authenticationResponse_Company_001_AMP['data']['access_token'];
	// 		$authenticationStatus_Company_001_AMP = $authenticationResponse_Company_001_AMP['status'];
	// 		$authenticationMessage_Company_001_AMP = $authenticationResponse_Company_001_AMP['message'];
	// 	}
	// 	// #Transaction AMP
	// 	$transactionEndPoint_AMP='API/v1/transaction/';
	// 	// WD - Withdrawal AMP ------------------------------------------------------------
	// 	// WD Brand Anonymous ---
    // // WD API Transaction 168 Anonymous ADMIN AMP
    // $transaction_API_WD_168_Anonymous_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_WD_168_Anonymous_ADMIN_AMP = json_decode(json_encode($transaction_API_WD_168_Anonymous_ADMIN_AMP),true);
	// 	$arrResponse_WD_168_Anonymous_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Anonymous_ADMIN_AMP['data'],$employeeId);
	// 	$arrResponse_WD_168_Anonymous_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Anonymous_ADMIN_AMP['data'],$employeeId);
    // // WD API Transaction WD 168 Anonymous MEMBER AMP
    // $transaction_API_WD_168_Anonymous_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_WD_168_Anonymous_MEMBER_AMP = json_decode(json_encode($transaction_API_WD_168_Anonymous_MEMBER_AMP),true);
    // $arrResponse_WD_168_Anonymous_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Anonymous_MEMBER_AMP['data'],$employeeId);
	// 	$arrResponse_WD_168_Anonymous_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Anonymous_MEMBER_AMP['data'],$employeeId);
    // // WD 168 Anonymous ADMIN Created_By AMP
    // $arrTotal_WD_168_Anonymous_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Anonymous_ADMIN_CreatedBy_AMP as $singResponse_WD_168_Anonymous_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Anonymous_ADMIN_CreatedBy_AMP[]=$singResponse_WD_168_Anonymous_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Anonymous_ADMIN_CreatedBy_AMP=count($arrResponse_WD_168_Anonymous_ADMIN_CreatedBy_AMP);
    // $totalAmount_WD_168_Anonymous_ADMIN_CreatedBy_AMP=array_sum($arrTotal_WD_168_Anonymous_ADMIN_CreatedBy_AMP);
    // // WD 168 Anonymous MEMBER Created_By AMP
    // $arrTotal_WD_168_Anonymous_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Anonymous_MEMBER_CreatedBy_AMP as $singResponse_WD_168_Anonymous_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Anonymous_MEMBER_CreatedBy_AMP[]=$singResponse_WD_168_Anonymous_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Anonymous_MEMBER_CreatedBy_AMP=count($arrResponse_WD_168_Anonymous_MEMBER_CreatedBy_AMP);
    // $totalAmount_WD_168_Anonymous_MEMBER_CreatedBy_AMP=array_sum($arrTotal_WD_168_Anonymous_MEMBER_CreatedBy_AMP);
    // // WD 168 Anonymous ADMIN Approved_By AMP
    // $arrTotal_WD_168_Anonymous_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Anonymous_ADMIN_ApprovedBy_AMP as $singResponse_WD_168_Anonymous_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Anonymous_ADMIN_ApprovedBy_AMP[]=$singResponse_WD_168_Anonymous_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Anonymous_ADMIN_ApprovedBy_AMP=count($arrResponse_WD_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // $totalAmount_WD_168_Anonymous_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // // WD 168 Anonymous MEMBER Approved_by AMP
    // $arrTotal_WD_168_Anonymous_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Anonymous_MEMBER_ApprovedBy_AMP as $singResponse_WD_168_Anonymous_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Anonymous_MEMBER_ApprovedBy_AMP[]=$singResponse_WD_168_Anonymous_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Anonymous_MEMBER_ApprovedBy_AMP=count($arrResponse_WD_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // $totalAmount_WD_168_Anonymous_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // // Total WD 168 Anonymous Created_By AMP
    // $totalAction_WD_168_Anonymous_CreatedBy_AMP = $totalAction_WD_168_Anonymous_ADMIN_CreatedBy_AMP;
    // $totalAmount_WD_168_Anonymous_CreatedBy_AMP = $totalAmount_WD_168_Anonymous_ADMIN_CreatedBy_AMP + $totalAmount_WD_168_Anonymous_MEMBER_CreatedBy_AMP;
    // // Total WD 168 Anonymous Approved_By AMP
    // $totalAction_WD_168_Anonymous_ApprovedBy_AMP = $totalAction_WD_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAction_WD_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // $totalAmount_WD_168_Anonymous_ApprovedBy_AMP = $totalAmount_WD_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAmount_WD_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // // Total ALL WD 168 Anonymous AMP
    // $totalAllAction_WD_168_Anonymous_AMP = $totalAction_WD_168_Anonymous_CreatedBy_AMP + $totalAction_WD_168_Anonymous_ApprovedBy_AMP;
    // $totalAllAmount_WD_168_Anonymous_AMP = $totalAmount_WD_168_Anonymous_CreatedBy_AMP + $totalAmount_WD_168_Anonymous_ApprovedBy_AMP;

	// 	// WD Brand Seniormasteragent ---
    // // WD API Transaction 168 Seniormasteragent ADMIN AMP
    // $transaction_API_WD_168_Seniormasteragent_ADMIN_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_WD_168_Seniormasteragent_ADMIN_AMP = json_decode(json_encode($transaction_API_WD_168_Seniormasteragent_ADMIN_AMP),true);
    // $arrResponse_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // // WD API Transaction 168 Seniormasteragent MEMBER AMP
    // $transaction_API_WD_168_Seniormasteragent_MEMBER_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_WD_168_Seniormasteragent_MEMBER_AMP = json_decode(json_encode($transaction_API_WD_168_Seniormasteragent_MEMBER_AMP),true);
    // $arrResponse_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // // WD 168 Seniormasteragent ADMIN Created_By AMP
    // $arrTotal_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP as $singResponse_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP[]=$singResponse_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // $totalAmount_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array_sum($arrTotal_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // // WD 168 Seniormasteragent MEMBER Created_By AMP
    // $arrTotal_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP as $singResponse_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP[]=$singResponse_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // $totalAmount_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array_sum($arrTotal_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // // WD 168 Seniormasteragent ADMIN Approved_By AMP
    // $arrTotal_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP as $singResponse_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP[]=$singResponse_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // $totalAmount_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // // WD 168 Seniormasteragent MEMBER Approved_by AMP
    // $arrTotal_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP as $singResponse_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP[]=$singResponse_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=count($arrResponse_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // $totalAmount_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // // Total WD 168 Seniormasteragent Created_By AMP
    // $totalAction_WD_168_Seniormasteragent_CreatedBy_AMP = $totalAction_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAction_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // $totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP = $totalAmount_WD_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAmount_WD_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // // Total WD 168 Seniormasteragent Approved_By AMP
    // $totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP = $totalAction_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAction_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // $totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP = $totalAmount_WD_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAmount_WD_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // // Total ALL WD 168 Seniormasteragent AMP
    // $totalAllAction_WD_168_Seniormasteragent_AMP = $totalAction_WD_168_Seniormasteragent_CreatedBy_AMP + $totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP;
    // $totalAllAmount_WD_168_Seniormasteragent_AMP = $totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP + $totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP;

	// 	// WD Brand Ayosbobet ---
    // // WD API Transaction 168 Ayosbobet ADMIN AMP
    // $transaction_API_WD_168_Ayosbobet_ADMIN_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_WD_168_Ayosbobet_ADMIN_AMP = json_decode(json_encode($transaction_API_WD_168_Ayosbobet_ADMIN_AMP),true);
    // $arrResponse_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // // WD API Transaction 168 Ayosbobet MEMBER AMP
    // $transaction_API_WD_168_Ayosbobet_MEMBER_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_WD_168_Ayosbobet_MEMBER_AMP = json_decode(json_encode($transaction_API_WD_168_Ayosbobet_MEMBER_AMP),true);
    // $arrResponse_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // // WD 168 Ayosbobet ADMIN Created_By AMP
    // $arrTotal_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP as $singResponse_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP[]=$singResponse_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP=count($arrResponse_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP);
    // $totalAmount_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP=array_sum($arrTotal_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP);
    // // WD 168 Ayosbobet MEMBER Created_By AMP
    // $arrTotal_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP as $singResponse_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP[]=$singResponse_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP=count($arrResponse_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // $totalAmount_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP=array_sum($arrTotal_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // // WD 168 Ayosbobet ADMIN Approved_By AMP
    // $arrTotal_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP as $singResponse_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP[]=$singResponse_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP=count($arrResponse_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // $totalAmount_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // // WD 168 Ayosbobet MEMBER Approved_by AMP
    // $arrTotal_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP as $singResponse_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP[]=$singResponse_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP=count($arrResponse_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // $totalAmount_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // // Total WD 168 Ayosbobet Created_By AMP
    // $totalAction_WD_168_Ayosbobet_CreatedBy_AMP = $totalAction_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAction_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // $totalAmount_WD_168_Ayosbobet_CreatedBy_AMP = $totalAmount_WD_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAmount_WD_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // // Total WD 168 Ayosbobet Approved_By AMP
    // $totalAction_WD_168_Ayosbobet_ApprovedBy_AMP = $totalAction_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAction_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // $totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP = $totalAmount_WD_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAmount_WD_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // // Total ALL WD 168 Ayosbobet AMP
    // $totalAllAction_WD_168_Ayosbobet_AMP = $totalAction_WD_168_Ayosbobet_CreatedBy_AMP + $totalAction_WD_168_Ayosbobet_ApprovedBy_AMP;
    // $totalAllAmount_WD_168_Ayosbobet_AMP = $totalAmount_WD_168_Ayosbobet_CreatedBy_AMP + $totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP;

	// 	// WD Brand SbobetHoki ---
    // // WD API Transaction 001 SbobetHoki ADMIN AMP
    // $transaction_API_WD_001_SbobetHoki_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'ADMIN');
	// 	$response_WD_001_SbobetHoki_ADMIN_AMP = json_decode(json_encode($transaction_API_WD_001_SbobetHoki_ADMIN_AMP),true);
    // $arrResponse_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // // WD API Transaction 001 SbobetHoki MEMBER AMP
    // $transaction_API_WD_001_SbobetHoki_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'MEMBER');
	// 	$response_WD_001_SbobetHoki_MEMBER_AMP = json_decode(json_encode($transaction_API_WD_001_SbobetHoki_MEMBER_AMP),true);
    // $arrResponse_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_WD_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_WD_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // // WD 001 SbobetHoki ADMIN Created_By AMP
    // $arrTotal_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP as $singResponse_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP[]=$singResponse_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP=count($arrResponse_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // $totalAmount_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP=array_sum($arrTotal_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // // WD 001 SbobetHoki MEMBER Created_By AMP
    // $arrTotal_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP as $singResponse_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP[]=$singResponse_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP=count($arrResponse_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // $totalAmount_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP=array_sum($arrTotal_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // // WD 001 SbobetHoki ADMIN Approved_By AMP
    // $arrTotal_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP as $singResponse_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP[]=$singResponse_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP=count($arrResponse_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // $totalAmount_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // // WD 001 SbobetHoki MEMBER Approved_by AMP
    // $arrTotal_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP as $singResponse_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP[]=$singResponse_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP=count($arrResponse_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // $totalAmount_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // // Total WD 001 SbobetHoki Created_By AMP
    // $totalAction_WD_001_SbobetHoki_CreatedBy_AMP = $totalAction_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAction_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // $totalAmount_WD_001_SbobetHoki_CreatedBy_AMP = $totalAmount_WD_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAmount_WD_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // // Total WD 001 SbobetHoki Approved_By AMP
    // $totalAction_WD_001_SbobetHoki_ApprovedBy_AMP = $totalAction_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAction_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // $totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP = $totalAmount_WD_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAmount_WD_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // // Total ALL WD 001 SbobetHoki AMP
    // $totalAllAction_WD_001_SbobetHoki_AMP = $totalAction_WD_001_SbobetHoki_CreatedBy_AMP + $totalAction_WD_001_SbobetHoki_ApprovedBy_AMP;
    // $totalAllAmount_WD_001_SbobetHoki_AMP = $totalAmount_WD_001_SbobetHoki_CreatedBy_AMP + $totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP;

	// 	// Final total ALL Withdrawal AMP ---
	// 	$totalALLAction_WD_AMP=$totalAllAction_WD_168_Anonymous_AMP+$totalAllAction_WD_168_Seniormasteragent_AMP+$totalAllAction_WD_168_Ayosbobet_AMP+$totalAllAction_WD_001_SbobetHoki_AMP;
	// 	$totalALLAmount_WD_AMP=$totalAllAmount_WD_168_Anonymous_AMP+$totalAllAmount_WD_168_Seniormasteragent_AMP+$totalAllAmount_WD_168_Ayosbobet_AMP+$totalAllAmount_WD_001_SbobetHoki_AMP;

	// 	// DEPO - DEPO AMP ------------------------------------------------------------
    // // DEPO Brand Anonymous ---
    // // DEPO API Transaction 168 Anonymous ADMIN AMP
    // $transaction_API_DEPO_168_Anonymous_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_DEPO_168_Anonymous_ADMIN_AMP = json_decode(json_encode($transaction_API_DEPO_168_Anonymous_ADMIN_AMP),true);
    // $arrResponse_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Anonymous_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Anonymous_ADMIN_AMP['data'],$employeeId);
    // // DEPO API Transaction 168 Anonymous MEMBER AMP
    // $transaction_API_DEPO_168_Anonymous_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_DEPO_168_Anonymous_MEMBER_AMP = json_decode(json_encode($transaction_API_DEPO_168_Anonymous_MEMBER_AMP),true);
    // $arrResponse_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Anonymous_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Anonymous_MEMBER_AMP['data'],$employeeId);
    // // DEPO 168 Anonymous ADMIN Created_By AMP
    // $arrTotal_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP as $singResponse_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP[]=$singResponse_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP=count($arrResponse_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP);
    // $totalAmount_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP);
    // // DEPO 168 Anonymous MEMBER Created_By AMP
    // $arrTotal_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP as $singResponse_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP[]=$singResponse_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP=count($arrResponse_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP);
    // $totalAmount_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP);
    // // DEPO 168 Anonymous ADMIN Approved_By AMP
    // $arrTotal_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP as $singResponse_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP[]=$singResponse_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP=count($arrResponse_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // // DEPO 168 Anonymous MEMBER Approved_by AMP
    // $arrTotal_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP as $singResponse_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP[]=$singResponse_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP=count($arrResponse_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // // Total DEPO 168 Anonymous Created_By AMP
    // $totalAction_DEPO_168_Anonymous_CreatedBy_AMP = $totalAction_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP + $totalAction_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP;
    // $totalAmount_DEPO_168_Anonymous_CreatedBy_AMP = $totalAmount_DEPO_168_Anonymous_ADMIN_CreatedBy_AMP + $totalAmount_DEPO_168_Anonymous_MEMBER_CreatedBy_AMP;
    // // Total DEPO 168 Anonymous Approved_By AMP
    // $totalAction_DEPO_168_Anonymous_ApprovedBy_AMP = $totalAction_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAction_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // $totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP = $totalAmount_DEPO_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAmount_DEPO_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // // Total ALL DEPO 168 Anonymous AMP
    // $totalAllAction_DEPO_168_Anonymous_AMP = $totalAction_DEPO_168_Anonymous_CreatedBy_AMP + $totalAction_DEPO_168_Anonymous_ApprovedBy_AMP;
    // $totalAllAmount_DEPO_168_Anonymous_AMP = $totalAmount_DEPO_168_Anonymous_CreatedBy_AMP + $totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP;

	// 	// DEPO Brand Seniormasteragent ---
    // // DEPO API Transaction 168 Seniormasteragent ADMIN AMP
    // $transaction_API_DEPO_168_Seniormasteragent_ADMIN_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_DEPO_168_Seniormasteragent_ADMIN_AMP = json_decode(json_encode($transaction_API_DEPO_168_Seniormasteragent_ADMIN_AMP),true);
    // $arrResponse_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // // DEPO API Transaction 168 Seniormasteragent MEMBER AMP
    // $transaction_API_DEPO_168_Seniormasteragent_MEMBER_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_DEPO_168_Seniormasteragent_MEMBER_AMP = json_decode(json_encode($transaction_API_DEPO_168_Seniormasteragent_MEMBER_AMP),true);
    // $arrResponse_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // // DEPO 168 Seniormasteragent ADMIN Created_By AMP
    // $arrTotal_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP as $singResponse_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP[]=$singResponse_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // $totalAmount_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // // DEPO 168 Seniormasteragent MEMBER Created_By AMP
    // $arrTotal_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP as $singResponse_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP[]=$singResponse_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // $totalAmount_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // // DEPO 168 Seniormasteragent ADMIN Approved_By AMP
    // $arrTotal_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP as $singResponse_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP[]=$singResponse_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // // DEPO 168 Seniormasteragent MEMBER Approved_by AMP
    // $arrTotal_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP as $singResponse_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP[]=$singResponse_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=count($arrResponse_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // // Total DEPO 168 Seniormasteragent Created_By AMP
    // $totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP = $totalAction_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAction_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // $totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP = $totalAmount_DEPO_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAmount_DEPO_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // // Total DEPO 168 Seniormasteragent Approved_By AMP
    // $totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP = $totalAction_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAction_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // $totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP = $totalAmount_DEPO_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAmount_DEPO_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // // Total ALL DEPO 168 Seniormasteragent AMP
    // $totalAllAction_DEPO_168_Seniormasteragent_AMP = $totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP + $totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP;
    // $totalAllAmount_DEPO_168_Seniormasteragent_AMP = $totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP + $totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP;

	// 	// DEPO Brand Ayosbobet ---
    // // DEPO API Transaction 168 Ayosbobet ADMIN AMP
    // $transaction_API_DEPO_168_Ayosbobet_ADMIN_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_DEPO_168_Ayosbobet_ADMIN_AMP = json_decode(json_encode($transaction_API_DEPO_168_Ayosbobet_ADMIN_AMP),true);
    // $arrResponse_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // // DEPO API Transaction 168 Ayosbobet MEMBER AMP
    // $transaction_API_DEPO_168_Ayosbobet_MEMBER_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_DEPO_168_Ayosbobet_MEMBER_AMP = json_decode(json_encode($transaction_API_DEPO_168_Ayosbobet_MEMBER_AMP),true);
    // $arrResponse_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // // DEPO 168 Ayosbobet ADMIN Created_By AMP
    // $arrTotal_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP as $singResponse_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP[]=$singResponse_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP);
	// 	$totalAmount_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP);
    // // DEPO 168 Ayosbobet MEMBER Created_By AMP
	// 	$arrTotal_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP as $singResponse_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP[]=$singResponse_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // $totalAmount_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP=array_sum($arrTotal_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // // DEPO 168 Ayosbobet ADMIN Approved_By AMP
    // $arrTotal_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP as $singResponse_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP[]=$singResponse_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // // DEPO 168 Ayosbobet MEMBER Approved_by AMP
    // $arrTotal_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP as $singResponse_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP[]=$singResponse_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP=count($arrResponse_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // $totalAmount_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // // Total DEPO 168 Ayosbobet Created_By AMP
    // $totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP = $totalAction_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAction_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // $totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP = $totalAmount_DEPO_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAmount_DEPO_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // // Total DEPO 168 Ayosbobet Approved_By AMP
    // $totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP = $totalAction_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAction_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // $totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP = $totalAmount_DEPO_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAmount_DEPO_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // // Total ALL DEPO 168 Ayosbobet AMP
    // $totalAllAction_DEPO_168_Ayosbobet_AMP = $totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP + $totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP;
    // $totalAllAmount_DEPO_168_Ayosbobet_AMP = $totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP + $totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP;

	// 	// DEPO Brand SbobetHoki ---
    // // DEPO API Transaction 168 SbobetHoki ADMIN AMP
    // $transaction_API_DEPO_001_SbobetHoki_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'ADMIN');
	// 	$response_DEPO_001_SbobetHoki_ADMIN_AMP = json_decode(json_encode($transaction_API_DEPO_001_SbobetHoki_ADMIN_AMP),true);
    // $arrResponse_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // // DEPO API Transaction 168 SbobetHoki MEMBER AMP
    // $transaction_API_DEPO_001_SbobetHoki_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'MEMBER');
	// 	$response_DEPO_001_SbobetHoki_MEMBER_AMP = json_decode(json_encode($transaction_API_DEPO_001_SbobetHoki_MEMBER_AMP),true);
    // $arrResponse_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_DEPO_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_DEPO_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // // DEPO 168 SbobetHoki ADMIN Created_By AMP
    // $arrTotal_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP as $singResponse_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP[]=$singResponse_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // $totalAmount_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP=array_sum($arrTotal_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // // DEPO 168 SbobetHoki MEMBER Created_By AMP
    // $arrTotal_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP as $singResponse_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP[]=$singResponse_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // $totalAmount_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP=array_sum($arrTotal_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // // DEPO 168 SbobetHoki ADMIN Approved_By AMP
    // $arrTotal_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP as $singResponse_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP[]=$singResponse_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // $totalAmount_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // // DEPO 168 SbobetHoki MEMBER Approved_by AMP
    // $arrTotal_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP as $singResponse_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP[]=$singResponse_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP=count($arrResponse_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // $totalAmount_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // // Total DEPO 168 SbobetHoki Created_By AMP
    // $totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP = $totalAction_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAction_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // $totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP = $totalAmount_DEPO_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAmount_DEPO_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // // Total DEPO 168 SbobetHoki Approved_By AMP
    // $totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP = $totalAction_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAction_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // $totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP = $totalAmount_DEPO_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAmount_DEPO_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // // Total ALL DEPO 168 SbobetHoki AMP
    // $totalAllAction_DEPO_001_SbobetHoki_AMP = $totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP + $totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP;
    // $totalAllAmount_DEPO_001_SbobetHoki_AMP = $totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP + $totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP;

	// 	// Final total all DEPO AMP ---
	// 	$totalALLAction_DEPO_AMP=$totalAllAction_DEPO_168_Anonymous_AMP+$totalAllAction_DEPO_168_Seniormasteragent_AMP+$totalAllAction_DEPO_168_Ayosbobet_AMP+$totalAllAction_DEPO_001_SbobetHoki_AMP;
	// 	$totalALLAmount_DEPO_AMP=$totalAllAmount_DEPO_168_Anonymous_AMP+$totalAllAmount_DEPO_168_Seniormasteragent_AMP+$totalAllAmount_DEPO_168_Ayosbobet_AMP+$totalAllAmount_DEPO_001_SbobetHoki_AMP;

	// 	// TF - Transfer AMP ------------------------------------------------------------
    // // TF Brand Anonymous ---
    // // TF API Transaction 168 Anonymous ADMIN AMP
	// 	$transaction_API_TF_168_Anonymous_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_TF_168_Anonymous_ADMIN_AMP = json_decode(json_encode($transaction_API_TF_168_Anonymous_ADMIN_AMP),true);
    // $arrResponse_TF_168_Anonymous_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Anonymous_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Anonymous_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Anonymous_ADMIN_AMP['data'],$employeeId);
    // // TF API Transaction 168 Anonymous MEMBER AMP
    // $transaction_API_TF_168_Anonymous_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_TF_168_Anonymous_MEMBER_AMP = json_decode(json_encode($transaction_API_TF_168_Anonymous_MEMBER_AMP),true);
    // $arrResponse_TF_168_Anonymous_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Anonymous_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Anonymous_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Anonymous_MEMBER_AMP['data'],$employeeId);
    // // TF 168 Anonymous ADMIN Created_By AMP
    // $arrTotal_TF_168_Anonymous_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Anonymous_ADMIN_CreatedBy_AMP as $singResponse_TF_168_Anonymous_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Anonymous_ADMIN_CreatedBy_AMP[]=$singResponse_TF_168_Anonymous_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Anonymous_ADMIN_CreatedBy_AMP=count($arrResponse_TF_168_Anonymous_ADMIN_CreatedBy_AMP);
    // $totalAmount_TF_168_Anonymous_ADMIN_CreatedBy_AMP=array_sum($arrTotal_TF_168_Anonymous_ADMIN_CreatedBy_AMP);
    // // TF 168 Anonymous MEMBER Created_By AMP
    // $arrTotal_TF_168_Anonymous_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Anonymous_MEMBER_CreatedBy_AMP as $singResponse_TF_168_Anonymous_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Anonymous_MEMBER_CreatedBy_AMP[]=$singResponse_TF_168_Anonymous_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Anonymous_MEMBER_CreatedBy_AMP=count($arrResponse_TF_168_Anonymous_MEMBER_CreatedBy_AMP);
    // $totalAmount_TF_168_Anonymous_MEMBER_CreatedBy_AMP=array_sum($arrTotal_TF_168_Anonymous_MEMBER_CreatedBy_AMP);
    // // TF 168 Anonymous ADMIN Approved_By AMP
    // $arrTotal_TF_168_Anonymous_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Anonymous_ADMIN_ApprovedBy_AMP as $singResponse_TF_168_Anonymous_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Anonymous_ADMIN_ApprovedBy_AMP[]=$singResponse_TF_168_Anonymous_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Anonymous_ADMIN_ApprovedBy_AMP=count($arrResponse_TF_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // $totalAmount_TF_168_Anonymous_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Anonymous_ADMIN_ApprovedBy_AMP);
    // // TF 168 Anonymous MEMBER Approved_by AMP
    // $arrTotal_TF_168_Anonymous_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Anonymous_MEMBER_ApprovedBy_AMP as $singResponse_TF_168_Anonymous_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Anonymous_MEMBER_ApprovedBy_AMP[]=$singResponse_TF_168_Anonymous_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Anonymous_MEMBER_ApprovedBy_AMP=count($arrResponse_TF_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // $totalAmount_TF_168_Anonymous_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Anonymous_MEMBER_ApprovedBy_AMP);
    // // Total TF 168 Anonymous Created_By AMP
    // $totalAction_TF_168_Anonymous_CreatedBy_AMP = $totalAction_TF_168_Anonymous_ADMIN_CreatedBy_AMP + $totalAction_TF_168_Anonymous_MEMBER_CreatedBy_AMP;
    // $totalAmount_TF_168_Anonymous_CreatedBy_AMP = $totalAmount_TF_168_Anonymous_ADMIN_CreatedBy_AMP + $totalAmount_TF_168_Anonymous_MEMBER_CreatedBy_AMP;
    // // Total TF 168 Anonymous Approved_By AMP
    // $totalAction_TF_168_Anonymous_ApprovedBy_AMP = $totalAction_TF_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAction_TF_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // $totalAmount_TF_168_Anonymous_ApprovedBy_AMP = $totalAmount_TF_168_Anonymous_ADMIN_ApprovedBy_AMP + $totalAmount_TF_168_Anonymous_MEMBER_ApprovedBy_AMP;
    // // Total ALL TF 168 Anonymous AMP
    // $totalAllAction_TF_168_Anonymous_AMP = $totalAction_TF_168_Anonymous_CreatedBy_AMP+$totalAction_TF_168_Anonymous_ApprovedBy_AMP;
    // $totalAllAmount_TF_168_Anonymous_AMP = $totalAmount_TF_168_Anonymous_CreatedBy_AMP+$totalAmount_TF_168_Anonymous_ApprovedBy_AMP;

	// 	// TF Brand Seniormasteragent ---
    // // TF API Transaction 168 Seniormasteragent ADMIN AMP
    // $transaction_API_TF_168_Seniormasteragent_ADMIN_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_TF_168_Seniormasteragent_ADMIN_AMP = json_decode(json_encode($transaction_API_TF_168_Seniormasteragent_ADMIN_AMP),true);
    // $arrResponse_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Seniormasteragent_ADMIN_AMP['data'],$employeeId);
    // // TF API Transaction 168 Seniormasteragent MEMBER AMP
    // $transaction_API_TF_168_Seniormasteragent_MEMBER_AMP = $this->transaction_API_AMP(2,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_TF_168_Seniormasteragent_MEMBER_AMP = json_decode(json_encode($transaction_API_TF_168_Seniormasteragent_MEMBER_AMP),true);
    // $arrResponse_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Seniormasteragent_MEMBER_AMP['data'],$employeeId);
    // // TF 168 Seniormasteragent ADMIN Created_By AMP
    // $arrTotal_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP as $singResponse_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP[]=$singResponse_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // $totalAmount_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP=array_sum($arrTotal_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP);
    // // TF 168 Seniormasteragent MEMBER Created_By AMP
    // $arrTotal_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP as $singResponse_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP[]=$singResponse_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // $totalAmount_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP=array_sum($arrTotal_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP);
    // // TF 168 Seniormasteragent ADMIN Approved_By AMP
    // $arrTotal_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP as $singResponse_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP[]=$singResponse_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // $totalAmount_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP);
    // // TF 168 Seniormasteragent MEMBER Approved_by AMP
    // $arrTotal_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP as $singResponse_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP[]=$singResponse_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=count($arrResponse_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // $totalAmount_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP);
    // // Total TF 168 Seniormasteragent Created_By AMP
    // $totalAction_TF_168_Seniormasteragent_CreatedBy_AMP = $totalAction_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAction_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // $totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP = $totalAmount_TF_168_Seniormasteragent_ADMIN_CreatedBy_AMP + $totalAmount_TF_168_Seniormasteragent_MEMBER_CreatedBy_AMP;
    // // Total TF 168 Seniormasteragent Approved_By AMP
    // $totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP = $totalAction_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAction_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // $totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP = $totalAmount_TF_168_Seniormasteragent_ADMIN_ApprovedBy_AMP + $totalAmount_TF_168_Seniormasteragent_MEMBER_ApprovedBy_AMP;
    // // Total ALL TF 168 Seniormasteragent AMP
    // $totalAllAction_TF_168_Seniormasteragent_AMP = $totalAction_TF_168_Seniormasteragent_CreatedBy_AMP+$totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP;
    // $totalAllAmount_TF_168_Seniormasteragent_AMP = $totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP+$totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP;

	// 	// TF Brand Ayosbobet ---
    // // TF API Transaction 168 Ayosbobet ADMIN AMP
    // $transaction_API_TF_168_Ayosbobet_ADMIN_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'ADMIN');
	// 	$response_TF_168_Ayosbobet_ADMIN_AMP = json_decode(json_encode($transaction_API_TF_168_Ayosbobet_ADMIN_AMP),true);
    // $arrResponse_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Ayosbobet_ADMIN_AMP['data'],$employeeId);
    // // TF API Transaction 168 Ayosbobet MEMBER AMP
    // $transaction_API_TF_168_Ayosbobet_MEMBER_AMP = $this->transaction_API_AMP(3,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_168_AMP,'MEMBER');
	// 	$response_TF_168_Ayosbobet_MEMBER_AMP = json_decode(json_encode($transaction_API_TF_168_Ayosbobet_MEMBER_AMP),true);
    // $arrResponse_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_168_Ayosbobet_MEMBER_AMP['data'],$employeeId);
    // // TF 168 Ayosbobet ADMIN Created_By AMP
    // $arrTotal_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP as $singResponse_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP[]=$singResponse_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP=count($arrResponse_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP);
    // $totalAmount_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP=array_sum($arrTotal_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP);
    // // TF 168 Ayosbobet MEMBER Created_By AMP
    // $arrTotal_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP as $singResponse_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP[]=$singResponse_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP=count($arrResponse_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // $totalAmount_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP=array_sum($arrTotal_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP);
    // // TF 168 Ayosbobet ADMIN Approved_By AMP
    // $arrTotal_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP as $singResponse_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP[]=$singResponse_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP=count($arrResponse_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // $totalAmount_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP);
    // // TF 168 Ayosbobet MEMBER Approved_by AMP
    // $arrTotal_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP as $singResponse_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP[]=$singResponse_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP=count($arrResponse_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // $totalAmount_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP);
    // // Total TF 168 Ayosbobet Created_By AMP
    // $totalAction_TF_168_Ayosbobet_CreatedBy_AMP = $totalAction_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAction_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // $totalAmount_TF_168_Ayosbobet_CreatedBy_AMP = $totalAmount_TF_168_Ayosbobet_ADMIN_CreatedBy_AMP + $totalAmount_TF_168_Ayosbobet_MEMBER_CreatedBy_AMP;
    // // Total TF 168 Ayosbobet Approved_By AMP
    // $totalAction_TF_168_Ayosbobet_ApprovedBy_AMP = $totalAction_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAction_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // $totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP = $totalAmount_TF_168_Ayosbobet_ADMIN_ApprovedBy_AMP + $totalAmount_TF_168_Ayosbobet_MEMBER_ApprovedBy_AMP;
    // // Total ALL TF 168 Ayosbobet AMP
    // $totalAllAction_TF_168_Ayosbobet_AMP = $totalAction_TF_168_Ayosbobet_CreatedBy_AMP+$totalAction_TF_168_Ayosbobet_ApprovedBy_AMP;
    // $totalAllAmount_TF_168_Ayosbobet_AMP = $totalAmount_TF_168_Ayosbobet_CreatedBy_AMP+$totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP;

	// 	// TF Brand SbobetHoki ---
    // // TF API Transaction 001 SbobetHoki ADMIN AMP
    // $transaction_API_TF_001_SbobetHoki_ADMIN_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'ADMIN');
	// 	$response_TF_001_SbobetHoki_ADMIN_AMP = json_decode(json_encode($transaction_API_TF_001_SbobetHoki_ADMIN_AMP),true);
    // $arrResponse_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // $arrResponse_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_001_SbobetHoki_ADMIN_AMP['data'],$employeeId);
    // // TF API Transaction 001 SbobetHoki MEMBER AMP
    // $transaction_API_TF_001_SbobetHoki_MEMBER_AMP = $this->transaction_API_AMP(1,$reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_AMP,$authenticationAccessToken_Company_001_AMP,'MEMBER');
	// 	$response_TF_001_SbobetHoki_MEMBER_AMP = json_decode(json_encode($transaction_API_TF_001_SbobetHoki_MEMBER_AMP),true);
    // $arrResponse_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_AMP($response_TF_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // $arrResponse_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_AMP($response_TF_001_SbobetHoki_MEMBER_AMP['data'],$employeeId);
    // // TF 001 SbobetHoki ADMIN Created_By AMP
    // $arrTotal_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP as $singResponse_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP){
	// 		$arrTotal_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP[]=$singResponse_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP=count($arrResponse_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // $totalAmount_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP=array_sum($arrTotal_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP);
    // // TF 001 SbobetHoki MEMBER Created_By AMP
    // $arrTotal_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP=array();
    // foreach($arrResponse_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP as $singResponse_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP){
	// 		$arrTotal_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP[]=$singResponse_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP=count($arrResponse_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // $totalAmount_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP=array_sum($arrTotal_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP);
    // // TF 001 SbobetHoki ADMIN Approved_By AMP
    // $arrTotal_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP as $singResponse_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP){
	// 		$arrTotal_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP[]=$singResponse_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP=count($arrResponse_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // $totalAmount_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP=array_sum($arrTotal_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP);
    // // TF 001 SbobetHoki MEMBER Approved_by AMP
    // $arrTotal_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array();
    // foreach($arrResponse_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP as $singResponse_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP){
	// 		$arrTotal_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP[]=$singResponse_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP['amount'];
	// 	}
	// 	$totalAction_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP=count($arrResponse_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // $totalAmount_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP=array_sum($arrTotal_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP);
    // // Total TF 001 SbobetHoki Created_By AMP
    // $totalAction_TF_001_SbobetHoki_CreatedBy_AMP = $totalAction_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAction_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // $totalAmount_TF_001_SbobetHoki_CreatedBy_AMP = $totalAmount_TF_001_SbobetHoki_ADMIN_CreatedBy_AMP + $totalAmount_TF_001_SbobetHoki_MEMBER_CreatedBy_AMP;
    // // Total TF 001 SbobetHoki Approved_By AMP
    // $totalAction_TF_001_SbobetHoki_ApprovedBy_AMP = $totalAction_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAction_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // $totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP = $totalAmount_TF_001_SbobetHoki_ADMIN_ApprovedBy_AMP + $totalAmount_TF_001_SbobetHoki_MEMBER_ApprovedBy_AMP;
    // // Total ALL TF 001 SbobetHoki AMP
    // $totalAllAction_TF_001_SbobetHoki_AMP = $totalAction_TF_001_SbobetHoki_CreatedBy_AMP+$totalAction_TF_001_SbobetHoki_ApprovedBy_AMP;
    // $totalAllAmount_TF_001_SbobetHoki_AMP = $totalAmount_TF_001_SbobetHoki_CreatedBy_AMP+$totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP;

	// 	// Final total all TF AMP ---
	// 	$totalALLAction_TF_AMP=$totalAllAction_TF_168_Anonymous_AMP+$totalAllAction_TF_168_Seniormasteragent_AMP+$totalAllAction_TF_168_Ayosbobet_AMP+$totalAllAction_TF_001_SbobetHoki_AMP;
	// 	$totalALLAmount_TF_AMP=$totalAllAmount_TF_168_Anonymous_AMP+$totalAllAmount_TF_168_Seniormasteragent_AMP+$totalAllAmount_TF_168_Ayosbobet_AMP+$totalAllAmount_TF_001_SbobetHoki_AMP;

	// 	/**************************************** API act for AMP ****************************************/

	// 	/**************************************** API act for TMP ****************************************/
	// 	#Authentication TMP
	// 	$authenticationEndPoint_TMP='api/login';
	// 	$authenticationAPI_TMP = $this->authenticate_API_TMP('POST',$authenticationEndPoint_TMP);
	// 	$authenticationResponse_TMP = json_decode(json_encode($authenticationAPI_TMP),true);
    // if(401!==$authenticationResponse_TMP['status_code']){ #Unauthorized
	// 		$authenticationData = $authenticationResponse_TMP['data'];
	// 		$authenticationAccessToken = $authenticationResponse_TMP['data']['token'];
	// 		$authenticationStatus = $authenticationResponse_TMP['status_code'];
	// 		$authenticationMessage = $authenticationResponse_TMP['message'];
	// 	}
    // // #Transaction TMP
    // $transactionEndPoint_TMP='api/transaction';
    // // DEPO - Deposit TMP ------------------------------------------------------------
	// 	$transaction_API_DEPO_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_DEPO_ADMIN_TMP = json_decode(json_encode($transaction_API_DEPO_ADMIN_TMP),true);
    // $arrResponse_DEPO_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_DEPO_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_DEPO_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_DEPO_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_DEPO_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'DEPO','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_DEPO_MEMBER_TMP = json_decode(json_encode($transaction_API_DEPO_MEMBER_TMP),true);
	// 	$arrResponse_DEPO_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_DEPO_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_DEPO_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_DEPO_MEMBER_TMP['data'],$employeeId);
    // // DEPO Admin Created By TMP
    // $arrTotal_DEPO_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_DEPO_ADMIN_CreatedBy_TMP as $singResponse_DEPO_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_DEPO_ADMIN_CreatedBy_TMP[]=$singResponse_DEPO_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_DEPO_ADMIN_CreatedBy_TMP=count($arrResponse_DEPO_ADMIN_CreatedBy_TMP);
    // $totalAmount_DEPO_ADMIN_CreatedBy_TMP=array_sum($arrTotal_DEPO_ADMIN_CreatedBy_TMP);
    // // DEPO Member Created By TMP
	// 	$arrTotal_DEPO_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_DEPO_MEMBER_CreatedBy_TMP as $singResponse_DEPO_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_DEPO_MEMBER_CreatedBy_TMP[]=$singResponse_DEPO_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_DEPO_MEMBER_CreatedBy_TMP=count($arrResponse_DEPO_MEMBER_CreatedBy_TMP);
    // $totalAmount_DEPO_MEMBER_CreatedBy_TMP=array_sum($arrTotal_DEPO_MEMBER_CreatedBy_TMP);
    // // DEPO Admin Approved By TMP
	// 	$arrTotal_DEPO_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_DEPO_ADMIN_ApprovedBy_TMP as $singResponse_DEPO_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_DEPO_ADMIN_ApprovedBy_TMP[]=$singResponse_DEPO_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_DEPO_ADMIN_ApprovedBy_TMP=count($arrResponse_DEPO_ADMIN_ApprovedBy_TMP);
    // $totalAmount_DEPO_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_DEPO_ADMIN_ApprovedBy_TMP);
    // // DEPO Member Approved By TMP
	// 	$arrTotal_DEPO_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_DEPO_MEMBER_ApprovedBy_TMP as $singResponse_DEPO_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_DEPO_MEMBER_ApprovedBy_TMP[]=$singResponse_DEPO_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_DEPO_MEMBER_ApprovedBy_TMP=count($arrResponse_DEPO_MEMBER_ApprovedBy_TMP);
    // $totalAmount_DEPO_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_DEPO_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL DEPO TMP -----------
    // // Total Depo Created By TMP
    // $totalAction_DEPO_CreatedBy_TMP = $totalAction_DEPO_ADMIN_CreatedBy_TMP + $totalAction_DEPO_MEMBER_CreatedBy_TMP;
    // $totalAmount_DEPO_CreatedBy_TMP = $totalAmount_DEPO_ADMIN_CreatedBy_TMP + $totalAmount_DEPO_MEMBER_CreatedBy_TMP;
    // // Total Depo Approved By TMP
    // $totalAction_DEPO_ApprovedBy_TMP = $totalAction_DEPO_ADMIN_ApprovedBy_TMP + $totalAction_DEPO_MEMBER_ApprovedBy_TMP;
    // $totalAmount_DEPO_ApprovedBy_TMP = $totalAmount_DEPO_ADMIN_ApprovedBy_TMP + $totalAmount_DEPO_MEMBER_ApprovedBy_TMP;
    // // Total ALL Depo By TMP
    // $totalAllAction_DEPO_TMP = $totalAction_DEPO_CreatedBy_TMP + $totalAction_DEPO_ApprovedBy_TMP;
    // $totalAllAmount_DEPO_TMP = $totalAmount_DEPO_CreatedBy_TMP + $totalAmount_DEPO_ApprovedBy_TMP;

	// 	// WD - Withdrawal TMP ------------------------------------------------------------
	// 	$transaction_API_WD_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_WD_ADMIN_TMP = json_decode(json_encode($transaction_API_WD_ADMIN_TMP),true);
    // $arrResponse_WD_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_WD_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_WD_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_WD_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_WD_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'WD','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_WD_MEMBER_TMP = json_decode(json_encode($transaction_API_WD_MEMBER_TMP),true);
	// 	$arrResponse_WD_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_WD_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_WD_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_WD_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_WD_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_WD_ADMIN_CreatedBy_TMP as $singResponse_WD_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_WD_ADMIN_CreatedBy_TMP[]=$singResponse_WD_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_WD_ADMIN_CreatedBy_TMP=count($arrResponse_WD_ADMIN_CreatedBy_TMP);
    // $totalAmount_WD_ADMIN_CreatedBy_TMP=array_sum($arrTotal_WD_ADMIN_CreatedBy_TMP);
    // // Withdrawal Member Created By TMP
	// 	$arrTotal_WD_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_WD_MEMBER_CreatedBy_TMP as $singResponse_WD_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_WD_MEMBER_CreatedBy_TMP[]=$singResponse_WD_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_WD_MEMBER_CreatedBy_TMP=count($arrResponse_WD_MEMBER_CreatedBy_TMP);
    // $totalAmount_WD_MEMBER_CreatedBy_TMP=array_sum($arrTotal_WD_MEMBER_CreatedBy_TMP);
    // // Withdrawal Admin Approved By TMP
	// 	$arrTotal_WD_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_WD_ADMIN_ApprovedBy_TMP as $singResponse_WD_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_WD_ADMIN_ApprovedBy_TMP[]=$singResponse_WD_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_WD_ADMIN_ApprovedBy_TMP=count($arrResponse_WD_ADMIN_ApprovedBy_TMP);
    // $totalAmount_WD_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_WD_ADMIN_ApprovedBy_TMP);
    // // Withdrawal Member Approved By TMP
	// 	$arrTotal_WD_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_WD_MEMBER_ApprovedBy_TMP as $singResponse_WD_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_WD_MEMBER_ApprovedBy_TMP[]=$singResponse_WD_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_WD_MEMBER_ApprovedBy_TMP=count($arrResponse_WD_MEMBER_ApprovedBy_TMP);
    // $totalAmount_WD_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_WD_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Withdrawal TMP -----------
    // // Total Withdrawal Created By TMP
    // $totalAction_WD_CreatedBy_TMP = $totalAction_WD_ADMIN_CreatedBy_TMP + $totalAction_WD_MEMBER_CreatedBy_TMP;
    // $totalAmount_WD_CreatedBy_TMP = $totalAmount_WD_ADMIN_CreatedBy_TMP + $totalAmount_WD_MEMBER_CreatedBy_TMP;
    // // Total Withdrawal Approved By TMP
    // $totalAction_WD_ApprovedBy_TMP = $totalAction_WD_ADMIN_ApprovedBy_TMP + $totalAction_WD_MEMBER_ApprovedBy_TMP;
    // $totalAmount_WD_ApprovedBy_TMP = $totalAmount_WD_ADMIN_ApprovedBy_TMP + $totalAmount_WD_MEMBER_ApprovedBy_TMP;
    // // Total ALL Withdrawal By TMP
    // $totalAllAction_WD_TMP = $totalAction_WD_CreatedBy_TMP + $totalAction_WD_ApprovedBy_TMP;
    // $totalAllAmount_WD_TMP = $totalAmount_WD_CreatedBy_TMP + $totalAmount_WD_ApprovedBy_TMP;

	// 	// TF - Transfer TMP ------------------------------------------------------------
	// 	$transaction_API_TF_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_TF_ADMIN_TMP = json_decode(json_encode($transaction_API_TF_ADMIN_TMP),true);
    // $arrResponse_TF_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_TF_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_TF_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_TF_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_TF_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'TF','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_TF_MEMBER_TMP = json_decode(json_encode($transaction_API_TF_MEMBER_TMP),true);
	// 	$arrResponse_TF_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_TF_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_TF_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_TF_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_TF_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_TF_ADMIN_CreatedBy_TMP as $singResponse_TF_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_TF_ADMIN_CreatedBy_TMP[]=$singResponse_TF_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_TF_ADMIN_CreatedBy_TMP=count($arrResponse_TF_ADMIN_CreatedBy_TMP);
    // $totalAmount_TF_ADMIN_CreatedBy_TMP=array_sum($arrTotal_TF_ADMIN_CreatedBy_TMP);
    // // Transfer Member Created By TMP
	// 	$arrTotal_TF_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_TF_MEMBER_CreatedBy_TMP as $singResponse_TF_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_TF_MEMBER_CreatedBy_TMP[]=$singResponse_TF_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_TF_MEMBER_CreatedBy_TMP=count($arrResponse_TF_MEMBER_CreatedBy_TMP);
    // $totalAmount_TF_MEMBER_CreatedBy_TMP=array_sum($arrTotal_TF_MEMBER_CreatedBy_TMP);
    // // Transfer Admin Approved By TMP
	// 	$arrTotal_TF_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_TF_ADMIN_ApprovedBy_TMP as $singResponse_TF_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_TF_ADMIN_ApprovedBy_TMP[]=$singResponse_TF_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_TF_ADMIN_ApprovedBy_TMP=count($arrResponse_TF_ADMIN_ApprovedBy_TMP);
    // $totalAmount_TF_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_TF_ADMIN_ApprovedBy_TMP);
    // // Transfer Member Approved By TMP
	// 	$arrTotal_TF_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_TF_MEMBER_ApprovedBy_TMP as $singResponse_TF_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_TF_MEMBER_ApprovedBy_TMP[]=$singResponse_TF_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_TF_MEMBER_ApprovedBy_TMP=count($arrResponse_TF_MEMBER_ApprovedBy_TMP);
    // $totalAmount_TF_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_TF_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Transfer TMP -----------
    // // Total Transfer Created By TMP
    // $totalAction_TF_CreatedBy_TMP = $totalAction_TF_ADMIN_CreatedBy_TMP + $totalAction_TF_MEMBER_CreatedBy_TMP;
    // $totalAmount_TF_CreatedBy_TMP = $totalAmount_TF_ADMIN_CreatedBy_TMP + $totalAmount_TF_MEMBER_CreatedBy_TMP;
    // // Total Transfer Approved By TMP
    // $totalAction_TF_ApprovedBy_TMP = $totalAction_TF_ADMIN_ApprovedBy_TMP + $totalAction_TF_MEMBER_ApprovedBy_TMP;
    // $totalAmount_TF_ApprovedBy_TMP = $totalAmount_TF_ADMIN_ApprovedBy_TMP + $totalAmount_TF_MEMBER_ApprovedBy_TMP;
    // // Total ALL Transfer By TMP
    // $totalAllAction_TF_TMP = $totalAction_TF_CreatedBy_TMP + $totalAction_TF_ApprovedBy_TMP;
    // $totalAllAmount_TF_TMP = $totalAmount_TF_CreatedBy_TMP + $totalAmount_TF_ApprovedBy_TMP;

	// 	// ADJ - Adjustment TMP ------------------------------------------------------------
	// 	$transaction_API_ADJ_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'ADJ','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_ADJ_ADMIN_TMP = json_decode(json_encode($transaction_API_ADJ_ADMIN_TMP),true);
    // $arrResponse_ADJ_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_ADJ_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_ADJ_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_ADJ_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_ADJ_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'ADJ','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_ADJ_MEMBER_TMP = json_decode(json_encode($transaction_API_ADJ_MEMBER_TMP),true);
	// 	$arrResponse_ADJ_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_ADJ_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_ADJ_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_ADJ_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_ADJ_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_ADJ_ADMIN_CreatedBy_TMP as $singResponse_ADJ_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_ADJ_ADMIN_CreatedBy_TMP[]=$singResponse_ADJ_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_ADJ_ADMIN_CreatedBy_TMP=count($arrResponse_ADJ_ADMIN_CreatedBy_TMP);
    // $totalAmount_ADJ_ADMIN_CreatedBy_TMP=array_sum($arrTotal_ADJ_ADMIN_CreatedBy_TMP);
    // // Adjusment Member Created By TMP
	// 	$arrTotal_ADJ_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_ADJ_MEMBER_CreatedBy_TMP as $singResponse_ADJ_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_ADJ_MEMBER_CreatedBy_TMP[]=$singResponse_ADJ_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_ADJ_MEMBER_CreatedBy_TMP=count($arrResponse_ADJ_MEMBER_CreatedBy_TMP);
    // $totalAmount_ADJ_MEMBER_CreatedBy_TMP=array_sum($arrTotal_ADJ_MEMBER_CreatedBy_TMP);
    // // Adjusment Admin Approved By TMP
	// 	$arrTotal_ADJ_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_ADJ_ADMIN_ApprovedBy_TMP as $singResponse_ADJ_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_ADJ_ADMIN_ApprovedBy_TMP[]=$singResponse_ADJ_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_ADJ_ADMIN_ApprovedBy_TMP=count($arrResponse_ADJ_ADMIN_ApprovedBy_TMP);
    // $totalAmount_ADJ_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_ADJ_ADMIN_ApprovedBy_TMP);
    // // Adjusment Member Approved By TMP
	// 	$arrTotal_ADJ_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_ADJ_MEMBER_ApprovedBy_TMP as $singResponse_ADJ_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_ADJ_MEMBER_ApprovedBy_TMP[]=$singResponse_ADJ_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_ADJ_MEMBER_ApprovedBy_TMP=count($arrResponse_ADJ_MEMBER_ApprovedBy_TMP);
    // $totalAmount_ADJ_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_ADJ_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Adjusment TMP -----------
    // // Total Adjusment Created By TMP
    // $totalAction_ADJ_CreatedBy_TMP = $totalAction_ADJ_ADMIN_CreatedBy_TMP + $totalAction_ADJ_MEMBER_CreatedBy_TMP;
    // $totalAmount_ADJ_CreatedBy_TMP = $totalAmount_ADJ_ADMIN_CreatedBy_TMP + $totalAmount_ADJ_MEMBER_CreatedBy_TMP;
    // // Total Adjusment Approved By TMP
    // $totalAction_ADJ_ApprovedBy_TMP = $totalAction_ADJ_ADMIN_ApprovedBy_TMP + $totalAction_ADJ_MEMBER_ApprovedBy_TMP;
    // $totalAmount_ADJ_ApprovedBy_TMP = $totalAmount_ADJ_ADMIN_ApprovedBy_TMP + $totalAmount_ADJ_MEMBER_ApprovedBy_TMP;
    // // Total ALL Adjusment By TMP
    // $totalAllAction_ADJ_TMP = $totalAction_ADJ_CreatedBy_TMP + $totalAction_ADJ_ApprovedBy_TMP;
    // $totalAllAmount_ADJ_TMP = $totalAmount_ADJ_CreatedBy_TMP + $totalAmount_ADJ_ApprovedBy_TMP;

	// 	// BONUS - Bonus TMP ------------------------------------------------------------
	// 	$transaction_API_BONUS_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'BONUS','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_BONUS_ADMIN_TMP = json_decode(json_encode($transaction_API_BONUS_ADMIN_TMP),true);
    // $arrResponse_BONUS_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_BONUS_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_BONUS_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_BONUS_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_BONUS_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'BONUS','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_BONUS_MEMBER_TMP = json_decode(json_encode($transaction_API_BONUS_MEMBER_TMP),true);
	// 	$arrResponse_BONUS_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_BONUS_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_BONUS_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_BONUS_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_BONUS_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_BONUS_ADMIN_CreatedBy_TMP as $singResponse_BONUS_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_BONUS_ADMIN_CreatedBy_TMP[]=$singResponse_BONUS_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_BONUS_ADMIN_CreatedBy_TMP=count($arrResponse_BONUS_ADMIN_CreatedBy_TMP);
    // $totalAmount_BONUS_ADMIN_CreatedBy_TMP=array_sum($arrTotal_BONUS_ADMIN_CreatedBy_TMP);
    // // Bonus Member Created By TMP
	// 	$arrTotal_BONUS_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_BONUS_MEMBER_CreatedBy_TMP as $singResponse_BONUS_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_BONUS_MEMBER_CreatedBy_TMP[]=$singResponse_BONUS_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_BONUS_MEMBER_CreatedBy_TMP=count($arrResponse_BONUS_MEMBER_CreatedBy_TMP);
    // $totalAmount_BONUS_MEMBER_CreatedBy_TMP=array_sum($arrTotal_BONUS_MEMBER_CreatedBy_TMP);
    // // Bonus Admin Approved By TMP
	// 	$arrTotal_BONUS_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_BONUS_ADMIN_ApprovedBy_TMP as $singResponse_BONUS_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_BONUS_ADMIN_ApprovedBy_TMP[]=$singResponse_BONUS_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_BONUS_ADMIN_ApprovedBy_TMP=count($arrResponse_BONUS_ADMIN_ApprovedBy_TMP);
    // $totalAmount_BONUS_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_BONUS_ADMIN_ApprovedBy_TMP);
    // // Bonus Member Approved By TMP
	// 	$arrTotal_BONUS_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_BONUS_MEMBER_ApprovedBy_TMP as $singResponse_BONUS_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_BONUS_MEMBER_ApprovedBy_TMP[]=$singResponse_BONUS_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_BONUS_MEMBER_ApprovedBy_TMP=count($arrResponse_BONUS_MEMBER_ApprovedBy_TMP);
    // $totalAmount_BONUS_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_BONUS_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Bonus TMP -----------
    // // Total Bonus Created By TMP
    // $totalAction_BONUS_CreatedBy_TMP = $totalAction_BONUS_ADMIN_CreatedBy_TMP + $totalAction_BONUS_MEMBER_CreatedBy_TMP;
    // $totalAmount_BONUS_CreatedBy_TMP = $totalAmount_BONUS_ADMIN_CreatedBy_TMP + $totalAmount_BONUS_MEMBER_CreatedBy_TMP;
    // // Total Bonus Approved By TMP
    // $totalAction_BONUS_ApprovedBy_TMP = $totalAction_BONUS_ADMIN_ApprovedBy_TMP + $totalAction_BONUS_MEMBER_ApprovedBy_TMP;
    // $totalAmount_BONUS_ApprovedBy_TMP = $totalAmount_BONUS_ADMIN_ApprovedBy_TMP + $totalAmount_BONUS_MEMBER_ApprovedBy_TMP;
    // // Total ALL Bonus By TMP
    // $totalAllAction_BONUS_TMP = $totalAction_BONUS_CreatedBy_TMP + $totalAction_BONUS_ApprovedBy_TMP;
    // $totalAllAmount_BONUS_TMP = $totalAmount_BONUS_CreatedBy_TMP + $totalAmount_BONUS_ApprovedBy_TMP;

	// 	// COMMISSION - Commission TMP ------------------------------------------------------------
	// 	$transaction_API_COMMISSION_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'COMMISSION','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_COMMISSION_ADMIN_TMP = json_decode(json_encode($transaction_API_COMMISSION_ADMIN_TMP),true);
    // $arrResponse_COMMISSION_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_COMMISSION_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_COMMISSION_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_COMMISSION_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_COMMISSION_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'COMMISSION','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_COMMISSION_MEMBER_TMP = json_decode(json_encode($transaction_API_COMMISSION_MEMBER_TMP),true);
	// 	$arrResponse_COMMISSION_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_COMMISSION_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_COMMISSION_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_COMMISSION_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_COMMISSION_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_COMMISSION_ADMIN_CreatedBy_TMP as $singResponse_COMMISSION_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_COMMISSION_ADMIN_CreatedBy_TMP[]=$singResponse_COMMISSION_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_COMMISSION_ADMIN_CreatedBy_TMP=count($arrResponse_COMMISSION_ADMIN_CreatedBy_TMP);
    // $totalAmount_COMMISSION_ADMIN_CreatedBy_TMP=array_sum($arrTotal_COMMISSION_ADMIN_CreatedBy_TMP);
    // // Commission Member Created By TMP
	// 	$arrTotal_COMMISSION_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_COMMISSION_MEMBER_CreatedBy_TMP as $singResponse_COMMISSION_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_COMMISSION_MEMBER_CreatedBy_TMP[]=$singResponse_COMMISSION_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_COMMISSION_MEMBER_CreatedBy_TMP=count($arrResponse_COMMISSION_MEMBER_CreatedBy_TMP);
    // $totalAmount_COMMISSION_MEMBER_CreatedBy_TMP=array_sum($arrTotal_COMMISSION_MEMBER_CreatedBy_TMP);
    // // Commission Admin Approved By TMP
	// 	$arrTotal_COMMISSION_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_COMMISSION_ADMIN_ApprovedBy_TMP as $singResponse_COMMISSION_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_COMMISSION_ADMIN_ApprovedBy_TMP[]=$singResponse_COMMISSION_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_COMMISSION_ADMIN_ApprovedBy_TMP=count($arrResponse_COMMISSION_ADMIN_ApprovedBy_TMP);
    // $totalAmount_COMMISSION_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_COMMISSION_ADMIN_ApprovedBy_TMP);
    // // Commission Member Approved By TMP
	// 	$arrTotal_COMMISSION_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_COMMISSION_MEMBER_ApprovedBy_TMP as $singResponse_COMMISSION_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_COMMISSION_MEMBER_ApprovedBy_TMP[]=$singResponse_COMMISSION_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_COMMISSION_MEMBER_ApprovedBy_TMP=count($arrResponse_COMMISSION_MEMBER_ApprovedBy_TMP);
    // $totalAmount_COMMISSION_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_COMMISSION_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Commission TMP -----------
    // // Total Commission Created By TMP
    // $totalAction_COMMISSION_CreatedBy_TMP = $totalAction_COMMISSION_ADMIN_CreatedBy_TMP + $totalAction_COMMISSION_MEMBER_CreatedBy_TMP;
    // $totalAmount_COMMISSION_CreatedBy_TMP = $totalAmount_COMMISSION_ADMIN_CreatedBy_TMP + $totalAmount_COMMISSION_MEMBER_CreatedBy_TMP;
    // // Total Commission Approved By TMP
    // $totalAction_COMMISSION_ApprovedBy_TMP = $totalAction_COMMISSION_ADMIN_ApprovedBy_TMP + $totalAction_COMMISSION_MEMBER_ApprovedBy_TMP;
    // $totalAmount_COMMISSION_ApprovedBy_TMP = $totalAmount_COMMISSION_ADMIN_ApprovedBy_TMP + $totalAmount_COMMISSION_MEMBER_ApprovedBy_TMP;
    // // Total ALL Commission By TMP
    // $totalAllAction_COMMISSION_TMP = $totalAction_COMMISSION_CreatedBy_TMP + $totalAction_COMMISSION_ApprovedBy_TMP;
    // $totalAllAmount_COMMISSION_TMP = $totalAmount_COMMISSION_CreatedBy_TMP + $totalAmount_COMMISSION_ApprovedBy_TMP;

	// 	// CASHBACK - Cashback TMP ------------------------------------------------------------
	// 	$transaction_API_CASHBACK_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'CASHBACK','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_CASHBACK_ADMIN_TMP = json_decode(json_encode($transaction_API_CASHBACK_ADMIN_TMP),true);
    // $arrResponse_CASHBACK_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_CASHBACK_ADMIN_TMP['data'],$employeeId);
    // $arrResponse_CASHBACK_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_CASHBACK_ADMIN_TMP['data'],$employeeId);
    // $transaction_API_CASHBACK_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'CASHBACK','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_CASHBACK_MEMBER_TMP = json_decode(json_encode($transaction_API_CASHBACK_MEMBER_TMP),true);
	// 	$arrResponse_CASHBACK_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_CASHBACK_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_CASHBACK_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_CASHBACK_MEMBER_TMP['data'],$employeeId);
    // $arrTotal_CASHBACK_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_CASHBACK_ADMIN_CreatedBy_TMP as $singResponse_CASHBACK_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_CASHBACK_ADMIN_CreatedBy_TMP[]=$singResponse_CASHBACK_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CASHBACK_ADMIN_CreatedBy_TMP=count($arrResponse_CASHBACK_ADMIN_CreatedBy_TMP);
    // $totalAmount_CASHBACK_ADMIN_CreatedBy_TMP=array_sum($arrTotal_CASHBACK_ADMIN_CreatedBy_TMP);
    // // Cashback Member Created By TMP
	// 	$arrTotal_CASHBACK_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_CASHBACK_MEMBER_CreatedBy_TMP as $singResponse_CASHBACK_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_CASHBACK_MEMBER_CreatedBy_TMP[]=$singResponse_CASHBACK_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CASHBACK_MEMBER_CreatedBy_TMP=count($arrResponse_CASHBACK_MEMBER_CreatedBy_TMP);
    // $totalAmount_CASHBACK_MEMBER_CreatedBy_TMP=array_sum($arrTotal_CASHBACK_MEMBER_CreatedBy_TMP);
    // // Cashback Admin Approved By TMP
	// 	$arrTotal_CASHBACK_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_CASHBACK_ADMIN_ApprovedBy_TMP as $singResponse_CASHBACK_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_CASHBACK_ADMIN_ApprovedBy_TMP[]=$singResponse_CASHBACK_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CASHBACK_ADMIN_ApprovedBy_TMP=count($arrResponse_CASHBACK_ADMIN_ApprovedBy_TMP);
    // $totalAmount_CASHBACK_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_CASHBACK_ADMIN_ApprovedBy_TMP);
    // // Cashback Member Approved By TMP
	// 	$arrTotal_CASHBACK_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_CASHBACK_MEMBER_ApprovedBy_TMP as $singResponse_CASHBACK_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_CASHBACK_MEMBER_ApprovedBy_TMP[]=$singResponse_CASHBACK_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CASHBACK_MEMBER_ApprovedBy_TMP=count($arrResponse_CASHBACK_MEMBER_ApprovedBy_TMP);
    // $totalAmount_CASHBACK_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_CASHBACK_MEMBER_ApprovedBy_TMP);
    // // Final Result ALL Commission TMP -----------
    // // Total Cashback Created By TMP
    // $totalAction_CASHBACK_CreatedBy_TMP = $totalAction_CASHBACK_ADMIN_CreatedBy_TMP + $totalAction_CASHBACK_MEMBER_CreatedBy_TMP;
    // $totalAmount_CASHBACK_CreatedBy_TMP = $totalAmount_CASHBACK_ADMIN_CreatedBy_TMP + $totalAmount_CASHBACK_MEMBER_CreatedBy_TMP;
    // // Total Cashback Approved By TMP
    // $totalAction_CASHBACK_ApprovedBy_TMP = $totalAction_CASHBACK_ADMIN_ApprovedBy_TMP + $totalAction_CASHBACK_MEMBER_ApprovedBy_TMP;
    // $totalAmount_CASHBACK_ApprovedBy_TMP = $totalAmount_CASHBACK_ADMIN_ApprovedBy_TMP + $totalAmount_CASHBACK_MEMBER_ApprovedBy_TMP;
    // // Total ALL Cashback By TMP
    // $totalAllAction_CASHBACK_TMP = $totalAction_CASHBACK_CreatedBy_TMP + $totalAction_CASHBACK_ApprovedBy_TMP;
    // $totalAllAmount_CASHBACK_TMP = $totalAmount_CASHBACK_CreatedBy_TMP + $totalAmount_CASHBACK_ApprovedBy_TMP;

	// 	// REFFERAL - Referral TMP ------------------------------------------------------------
	// 	$transaction_API_REFERRAL_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'REFERRAL','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_REFERRAL_ADMIN_TMP = json_decode(json_encode($transaction_API_REFERRAL_ADMIN_TMP),true);
	// 	$arrResponse_REFERRAL_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_REFERRAL_ADMIN_TMP['data'],$employeeId);
	// 	$arrResponse_REFERRAL_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_REFERRAL_ADMIN_TMP['data'],$employeeId);
	// 	$transaction_API_REFERRAL_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'REFERRAL','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_REFERRAL_MEMBER_TMP = json_decode(json_encode($transaction_API_REFERRAL_MEMBER_TMP),true);
	// 	$arrResponse_REFERRAL_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_REFERRAL_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_REFERRAL_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_REFERRAL_MEMBER_TMP['data'],$employeeId);
	// 	$arrTotal_REFERRAL_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_REFERRAL_ADMIN_CreatedBy_TMP as $singResponse_REFERRAL_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_REFERRAL_ADMIN_CreatedBy_TMP[]=$singResponse_REFERRAL_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_REFERRAL_ADMIN_CreatedBy_TMP=count($arrResponse_REFERRAL_ADMIN_CreatedBy_TMP);
	// 	$totalAmount_REFERRAL_ADMIN_CreatedBy_TMP=array_sum($arrTotal_REFERRAL_ADMIN_CreatedBy_TMP);
	// 	// Referral Member Created By TMP
	// 	$arrTotal_REFERRAL_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_REFERRAL_MEMBER_CreatedBy_TMP as $singResponse_REFERRAL_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_REFERRAL_MEMBER_CreatedBy_TMP[]=$singResponse_REFERRAL_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_REFERRAL_MEMBER_CreatedBy_TMP=count($arrResponse_REFERRAL_MEMBER_CreatedBy_TMP);
	// 	$totalAmount_REFERRAL_MEMBER_CreatedBy_TMP=array_sum($arrTotal_REFERRAL_MEMBER_CreatedBy_TMP);
	// 	// Referral Admin Approved By TMP
	// 	$arrTotal_REFERRAL_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_REFERRAL_ADMIN_ApprovedBy_TMP as $singResponse_REFERRAL_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_REFERRAL_ADMIN_ApprovedBy_TMP[]=$singResponse_REFERRAL_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_REFERRAL_ADMIN_ApprovedBy_TMP=count($arrResponse_REFERRAL_ADMIN_ApprovedBy_TMP);
	// 	$totalAmount_REFERRAL_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_REFERRAL_ADMIN_ApprovedBy_TMP);
	// 	// Referral Member Approved By TMP
	// 	$arrTotal_REFERRAL_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_REFERRAL_MEMBER_ApprovedBy_TMP as $singResponse_REFERRAL_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_REFERRAL_MEMBER_ApprovedBy_TMP[]=$singResponse_REFERRAL_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_REFERRAL_MEMBER_ApprovedBy_TMP=count($arrResponse_REFERRAL_MEMBER_ApprovedBy_TMP);
	// 	$totalAmount_REFERRAL_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_REFERRAL_MEMBER_ApprovedBy_TMP);
	// 	// Final Result ALL Referral TMP -----------
	// 	// Total Referral Created By TMP
	// 	$totalAction_REFERRAL_CreatedBy_TMP = $totalAction_REFERRAL_ADMIN_CreatedBy_TMP + $totalAction_REFERRAL_MEMBER_CreatedBy_TMP;
	// 	$totalAmount_REFERRAL_CreatedBy_TMP = $totalAmount_REFERRAL_ADMIN_CreatedBy_TMP + $totalAmount_REFERRAL_MEMBER_CreatedBy_TMP;
	// 	// Total Referral Approved By TMP
	// 	$totalAction_REFERRAL_ApprovedBy_TMP = $totalAction_REFERRAL_ADMIN_ApprovedBy_TMP + $totalAction_REFERRAL_MEMBER_ApprovedBy_TMP;
	// 	$totalAmount_REFERRAL_ApprovedBy_TMP = $totalAmount_REFERRAL_ADMIN_ApprovedBy_TMP + $totalAmount_REFERRAL_MEMBER_ApprovedBy_TMP;
	// 	// Total ALL Referral By TMP
	// 	$totalAllAction_REFERRAL_TMP = $totalAction_REFERRAL_CreatedBy_TMP + $totalAction_REFERRAL_ApprovedBy_TMP;
	// 	$totalAllAmount_REFERRAL_TMP = $totalAmount_REFERRAL_CreatedBy_TMP + $totalAmount_REFERRAL_ApprovedBy_TMP;

	// 	// FREEBET - Freebet TMP ------------------------------------------------------------
	// 	$transaction_API_FREEBET_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'FREEBET','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_FREEBET_ADMIN_TMP = json_decode(json_encode($transaction_API_FREEBET_ADMIN_TMP),true);
	// 	$arrResponse_FREEBET_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_FREEBET_ADMIN_TMP['data'],$employeeId);
	// 	$arrResponse_FREEBET_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_FREEBET_ADMIN_TMP['data'],$employeeId);
	// 	$transaction_API_FREEBET_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'FREEBET','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_FREEBET_MEMBER_TMP = json_decode(json_encode($transaction_API_FREEBET_MEMBER_TMP),true);
	// 	$arrResponse_FREEBET_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_FREEBET_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_FREEBET_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_FREEBET_MEMBER_TMP['data'],$employeeId);
	// 	$arrTotal_FREEBET_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_FREEBET_ADMIN_CreatedBy_TMP as $singResponse_FREEBET_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_FREEBET_ADMIN_CreatedBy_TMP[]=$singResponse_FREEBET_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_FREEBET_ADMIN_CreatedBy_TMP=count($arrResponse_FREEBET_ADMIN_CreatedBy_TMP);
	// 	$totalAmount_FREEBET_ADMIN_CreatedBy_TMP=array_sum($arrTotal_FREEBET_ADMIN_CreatedBy_TMP);
	// 	// Freebet Member Created By TMP
	// 	$arrTotal_FREEBET_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_FREEBET_MEMBER_CreatedBy_TMP as $singResponse_FREEBET_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_FREEBET_MEMBER_CreatedBy_TMP[]=$singResponse_FREEBET_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_FREEBET_MEMBER_CreatedBy_TMP=count($arrResponse_FREEBET_MEMBER_CreatedBy_TMP);
	// 	$totalAmount_FREEBET_MEMBER_CreatedBy_TMP=array_sum($arrTotal_FREEBET_MEMBER_CreatedBy_TMP);
	// 	// Freebet Admin Approved By TMP
	// 	$arrTotal_FREEBET_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_FREEBET_ADMIN_ApprovedBy_TMP as $singResponse_FREEBET_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_FREEBET_ADMIN_ApprovedBy_TMP[]=$singResponse_FREEBET_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_FREEBET_ADMIN_ApprovedBy_TMP=count($arrResponse_FREEBET_ADMIN_ApprovedBy_TMP);
	// 	$totalAmount_FREEBET_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_FREEBET_ADMIN_ApprovedBy_TMP);
	// 	// Freebet Member Approved By TMP
	// 	$arrTotal_FREEBET_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_FREEBET_MEMBER_ApprovedBy_TMP as $singResponse_FREEBET_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_FREEBET_MEMBER_ApprovedBy_TMP[]=$singResponse_FREEBET_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_FREEBET_MEMBER_ApprovedBy_TMP=count($arrResponse_FREEBET_MEMBER_ApprovedBy_TMP);
	// 	$totalAmount_FREEBET_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_FREEBET_MEMBER_ApprovedBy_TMP);
	// 	// Final Result ALL Freebet TMP -----------
	// 	// Total Freebet Created By TMP
	// 	$totalAction_FREEBET_CreatedBy_TMP = $totalAction_FREEBET_ADMIN_CreatedBy_TMP + $totalAction_FREEBET_MEMBER_CreatedBy_TMP;
	// 	$totalAmount_FREEBET_CreatedBy_TMP = $totalAmount_FREEBET_ADMIN_CreatedBy_TMP + $totalAmount_FREEBET_MEMBER_CreatedBy_TMP;
	// 	// Total Freebet Approved By TMP
	// 	$totalAction_FREEBET_ApprovedBy_TMP = $totalAction_FREEBET_ADMIN_ApprovedBy_TMP + $totalAction_FREEBET_MEMBER_ApprovedBy_TMP;
	// 	$totalAmount_FREEBET_ApprovedBy_TMP = $totalAmount_FREEBET_ADMIN_ApprovedBy_TMP + $totalAmount_FREEBET_MEMBER_ApprovedBy_TMP;
	// 	// Total ALL Freebet By TMP
	// 	$totalAllAction_FREEBET_TMP = $totalAction_FREEBET_CreatedBy_TMP + $totalAction_FREEBET_ApprovedBy_TMP;
	// 	$totalAllAmount_FREEBET_TMP = $totalAmount_FREEBET_CreatedBy_TMP + $totalAmount_FREEBET_ApprovedBy_TMP;

	// 	// AFFILIATE - Affiliate TMP ------------------------------------------------------------
	// 	$transaction_API_AFFILIATE_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'AFFILIATE','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_AFFILIATE_ADMIN_TMP = json_decode(json_encode($transaction_API_AFFILIATE_ADMIN_TMP),true);
	// 	$arrResponse_AFFILIATE_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_AFFILIATE_ADMIN_TMP['data'],$employeeId);
	// 	$arrResponse_AFFILIATE_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_AFFILIATE_ADMIN_TMP['data'],$employeeId);
	// 	$transaction_API_AFFILIATE_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'AFFILIATE','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_AFFILIATE_MEMBER_TMP = json_decode(json_encode($transaction_API_AFFILIATE_MEMBER_TMP),true);
	// 	$arrResponse_AFFILIATE_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_AFFILIATE_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_AFFILIATE_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_AFFILIATE_MEMBER_TMP['data'],$employeeId);
	// 	$arrTotal_AFFILIATE_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_AFFILIATE_ADMIN_CreatedBy_TMP as $singResponse_AFFILIATE_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_AFFILIATE_ADMIN_CreatedBy_TMP[]=$singResponse_AFFILIATE_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_AFFILIATE_ADMIN_CreatedBy_TMP=count($arrResponse_AFFILIATE_ADMIN_CreatedBy_TMP);
	// 	$totalAmount_AFFILIATE_ADMIN_CreatedBy_TMP=array_sum($arrTotal_AFFILIATE_ADMIN_CreatedBy_TMP);
	// 	// Affiliate Member Created By TMP
	// 	$arrTotal_AFFILIATE_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_AFFILIATE_MEMBER_CreatedBy_TMP as $singResponse_AFFILIATE_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_AFFILIATE_MEMBER_CreatedBy_TMP[]=$singResponse_AFFILIATE_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_AFFILIATE_MEMBER_CreatedBy_TMP=count($arrResponse_AFFILIATE_MEMBER_CreatedBy_TMP);
	// 	$totalAmount_AFFILIATE_MEMBER_CreatedBy_TMP=array_sum($arrTotal_AFFILIATE_MEMBER_CreatedBy_TMP);
	// 	// Affiliate Admin Approved By TMP
	// 	$arrTotal_AFFILIATE_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_AFFILIATE_ADMIN_ApprovedBy_TMP as $singResponse_AFFILIATE_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_AFFILIATE_ADMIN_ApprovedBy_TMP[]=$singResponse_AFFILIATE_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_AFFILIATE_ADMIN_ApprovedBy_TMP=count($arrResponse_AFFILIATE_ADMIN_ApprovedBy_TMP);
	// 	$totalAmount_AFFILIATE_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_AFFILIATE_ADMIN_ApprovedBy_TMP);
	// 	// Affiliate Member Approved By TMP
	// 	$arrTotal_AFFILIATE_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_AFFILIATE_MEMBER_ApprovedBy_TMP as $singResponse_AFFILIATE_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_AFFILIATE_MEMBER_ApprovedBy_TMP[]=$singResponse_AFFILIATE_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_AFFILIATE_MEMBER_ApprovedBy_TMP=count($arrResponse_AFFILIATE_MEMBER_ApprovedBy_TMP);
	// 	$totalAmount_AFFILIATE_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_AFFILIATE_MEMBER_ApprovedBy_TMP);
	// 	// Final Result ALL Affiliate TMP -----------
	// 	// Total Affiliate Created By TMP
	// 	$totalAction_AFFILIATE_CreatedBy_TMP = $totalAction_AFFILIATE_ADMIN_CreatedBy_TMP + $totalAction_AFFILIATE_MEMBER_CreatedBy_TMP;
	// 	$totalAmount_AFFILIATE_CreatedBy_TMP = $totalAmount_AFFILIATE_ADMIN_CreatedBy_TMP + $totalAmount_AFFILIATE_MEMBER_CreatedBy_TMP;
	// 	// Total Affiliate Approved By TMP
	// 	$totalAction_AFFILIATE_ApprovedBy_TMP = $totalAction_AFFILIATE_ADMIN_ApprovedBy_TMP + $totalAction_AFFILIATE_MEMBER_ApprovedBy_TMP;
	// 	$totalAmount_AFFILIATE_ApprovedBy_TMP = $totalAmount_AFFILIATE_ADMIN_ApprovedBy_TMP + $totalAmount_AFFILIATE_MEMBER_ApprovedBy_TMP;
	// 	// Total ALL Affiliate By TMP
	// 	$totalAllAction_AFFILIATE_TMP = $totalAction_AFFILIATE_CreatedBy_TMP + $totalAction_AFFILIATE_ApprovedBy_TMP;
	// 	$totalAllAmount_AFFILIATE_TMP = $totalAmount_AFFILIATE_CreatedBy_TMP + $totalAmount_AFFILIATE_ApprovedBy_TMP;

	// 	// SURRENDER - Surrender TMP ------------------------------------------------------------
	// 	$transaction_API_SURRENDER_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'SURRENDER','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_SURRENDER_ADMIN_TMP = json_decode(json_encode($transaction_API_SURRENDER_ADMIN_TMP),true);
	// 	$arrResponse_SURRENDER_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_SURRENDER_ADMIN_TMP['data'],$employeeId);
	// 	$arrResponse_SURRENDER_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_SURRENDER_ADMIN_TMP['data'],$employeeId);
	// 	$transaction_API_SURRENDER_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'SURRENDER','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_SURRENDER_MEMBER_TMP = json_decode(json_encode($transaction_API_SURRENDER_MEMBER_TMP),true);
	// 	$arrResponse_SURRENDER_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_SURRENDER_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_SURRENDER_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_SURRENDER_MEMBER_TMP['data'],$employeeId);
	// 	$arrTotal_SURRENDER_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_SURRENDER_ADMIN_CreatedBy_TMP as $singResponse_SURRENDER_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_SURRENDER_ADMIN_CreatedBy_TMP[]=$singResponse_SURRENDER_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_SURRENDER_ADMIN_CreatedBy_TMP=count($arrResponse_SURRENDER_ADMIN_CreatedBy_TMP);
	// 	$totalAmount_SURRENDER_ADMIN_CreatedBy_TMP=array_sum($arrTotal_SURRENDER_ADMIN_CreatedBy_TMP);
	// 	// Affiliate Member Created By TMP
	// 	$arrTotal_SURRENDER_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_SURRENDER_MEMBER_CreatedBy_TMP as $singResponse_SURRENDER_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_SURRENDER_MEMBER_CreatedBy_TMP[]=$singResponse_SURRENDER_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_SURRENDER_MEMBER_CreatedBy_TMP=count($arrResponse_SURRENDER_MEMBER_CreatedBy_TMP);
	// 	$totalAmount_SURRENDER_MEMBER_CreatedBy_TMP=array_sum($arrTotal_SURRENDER_MEMBER_CreatedBy_TMP);
	// 	// Surrender Admin Approved By TMP
	// 	$arrTotal_SURRENDER_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_SURRENDER_ADMIN_ApprovedBy_TMP as $singResponse_SURRENDER_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_SURRENDER_ADMIN_ApprovedBy_TMP[]=$singResponse_SURRENDER_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_SURRENDER_ADMIN_ApprovedBy_TMP=count($arrResponse_SURRENDER_ADMIN_ApprovedBy_TMP);
	// 	$totalAmount_SURRENDER_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_SURRENDER_ADMIN_ApprovedBy_TMP);
	// 	// Surrender Member Approved By TMP
	// 	$arrTotal_SURRENDER_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_SURRENDER_MEMBER_ApprovedBy_TMP as $singResponse_SURRENDER_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_SURRENDER_MEMBER_ApprovedBy_TMP[]=$singResponse_SURRENDER_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_SURRENDER_MEMBER_ApprovedBy_TMP=count($arrResponse_SURRENDER_MEMBER_ApprovedBy_TMP);
	// 	$totalAmount_SURRENDER_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_SURRENDER_MEMBER_ApprovedBy_TMP);
	// 	// Final Result ALL Surrender TMP -----------
	// 	// Total Surrender Created By TMP
	// 	$totalAction_SURRENDER_CreatedBy_TMP = $totalAction_SURRENDER_ADMIN_CreatedBy_TMP + $totalAction_SURRENDER_MEMBER_CreatedBy_TMP;
	// 	$totalAmount_SURRENDER_CreatedBy_TMP = $totalAmount_SURRENDER_ADMIN_CreatedBy_TMP + $totalAmount_SURRENDER_MEMBER_CreatedBy_TMP;
	// 	// Total Surrender Approved By TMP
	// 	$totalAction_SURRENDER_ApprovedBy_TMP = $totalAction_SURRENDER_ADMIN_ApprovedBy_TMP + $totalAction_SURRENDER_MEMBER_ApprovedBy_TMP;
	// 	$totalAmount_SURRENDER_ApprovedBy_TMP = $totalAmount_SURRENDER_ADMIN_ApprovedBy_TMP + $totalAmount_SURRENDER_MEMBER_ApprovedBy_TMP;
	// 	// Total ALL Surrender By TMP
	// 	$totalAllAction_SURRENDER_TMP = $totalAction_SURRENDER_CreatedBy_TMP + $totalAction_SURRENDER_ApprovedBy_TMP;
	// 	$totalAllAmount_SURRENDER_TMP = $totalAmount_SURRENDER_CreatedBy_TMP + $totalAmount_SURRENDER_ApprovedBy_TMP;

	// 	// CANCEL - Cancel TMP ------------------------------------------------------------
	// 	$transaction_API_CANCEL_ADMIN_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'CANCEL','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"ADMIN");
	// 	$response_CANCEL_ADMIN_TMP = json_decode(json_encode($transaction_API_CANCEL_ADMIN_TMP),true);
	// 	$arrResponse_CANCEL_ADMIN_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_CANCEL_ADMIN_TMP['data'],$employeeId);
	// 	$arrResponse_CANCEL_ADMIN_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_CANCEL_ADMIN_TMP['data'],$employeeId);
	// 	$transaction_API_CANCEL_MEMBER_TMP = $this->transaction_API_TMP($reportDateAPIformatFrom,$reportDateAPIformatTo,'CANCEL','POST',$transactionEndPoint_TMP,$authenticationAccessToken,"MEMBER");
	// 	$response_CANCEL_MEMBER_TMP = json_decode(json_encode($transaction_API_CANCEL_MEMBER_TMP),true);
	// 	$arrResponse_CANCEL_MEMBER_CreatedBy_TMP = $this->filterAPIResponseDataByEmployeeId_CreatedBy_TMP($response_CANCEL_MEMBER_TMP['data'],$employeeId);
	// 	$arrResponse_CANCEL_MEMBER_ApprovedBy_TMP = $this->filterAPIResponseDataByEmployeeId_ApprovedBy_TMP($response_CANCEL_MEMBER_TMP['data'],$employeeId);
	// 	$arrTotal_CANCEL_ADMIN_CreatedBy_TMP=array();
	// 	foreach($arrResponse_CANCEL_ADMIN_CreatedBy_TMP as $singResponse_CANCEL_ADMIN_CreatedBy_TMP){
	// 		$arrTotal_CANCEL_ADMIN_CreatedBy_TMP[]=$singResponse_CANCEL_ADMIN_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CANCEL_ADMIN_CreatedBy_TMP=count($arrResponse_CANCEL_ADMIN_CreatedBy_TMP);
	// 	$totalAmount_CANCEL_ADMIN_CreatedBy_TMP=array_sum($arrTotal_CANCEL_ADMIN_CreatedBy_TMP);
	// 	// Cancel Member Created By TMP
	// 	$arrTotal_CANCEL_MEMBER_CreatedBy_TMP=array();
	// 	foreach($arrResponse_CANCEL_MEMBER_CreatedBy_TMP as $singResponse_CANCEL_MEMBER_CreatedBy_TMP){
	// 		$arrTotal_CANCEL_MEMBER_CreatedBy_TMP[]=$singResponse_CANCEL_MEMBER_CreatedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CANCEL_MEMBER_CreatedBy_TMP=count($arrResponse_CANCEL_MEMBER_CreatedBy_TMP);
	// 	$totalAmount_CANCEL_MEMBER_CreatedBy_TMP=array_sum($arrTotal_CANCEL_MEMBER_CreatedBy_TMP);
	// 	// Cancel Admin Approved By TMP
	// 	$arrTotal_CANCEL_ADMIN_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_CANCEL_ADMIN_ApprovedBy_TMP as $singResponse_CANCEL_ADMIN_ApprovedBy_TMP){
	// 		$arrTotal_CANCEL_ADMIN_ApprovedBy_TMP[]=$singResponse_CANCEL_ADMIN_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CANCEL_ADMIN_ApprovedBy_TMP=count($arrResponse_CANCEL_ADMIN_ApprovedBy_TMP);
	// 	$totalAmount_CANCEL_ADMIN_ApprovedBy_TMP=array_sum($arrTotal_CANCEL_ADMIN_ApprovedBy_TMP);
	// 	// Cancel Member Approved By TMP
	// 	$arrTotal_CANCEL_MEMBER_ApprovedBy_TMP=array();
	// 	foreach($arrResponse_CANCEL_MEMBER_ApprovedBy_TMP as $singResponse_CANCEL_MEMBER_ApprovedBy_TMP){
	// 		$arrTotal_CANCEL_MEMBER_ApprovedBy_TMP[]=$singResponse_CANCEL_MEMBER_ApprovedBy_TMP['amount'];
	// 	}
	// 	$totalAction_CANCEL_MEMBER_ApprovedBy_TMP=count($arrResponse_CANCEL_MEMBER_ApprovedBy_TMP);
	// 	$totalAmount_CANCEL_MEMBER_ApprovedBy_TMP=array_sum($arrTotal_CANCEL_MEMBER_ApprovedBy_TMP);
	// 	// Final Result ALL Cancel TMP -----------
	// 	// Total Cancel Created By TMP
	// 	$totalAction_CANCEL_CreatedBy_TMP = $totalAction_CANCEL_ADMIN_CreatedBy_TMP + $totalAction_CANCEL_MEMBER_CreatedBy_TMP;
	// 	$totalAmount_CANCEL_CreatedBy_TMP = $totalAmount_CANCEL_ADMIN_CreatedBy_TMP + $totalAmount_CANCEL_MEMBER_CreatedBy_TMP;
	// 	// Total Cancel Approved By TMP
	// 	$totalAction_CANCEL_ApprovedBy_TMP = $totalAction_CANCEL_ADMIN_ApprovedBy_TMP + $totalAction_CANCEL_MEMBER_ApprovedBy_TMP;
	// 	$totalAmount_CANCEL_ApprovedBy_TMP = $totalAmount_CANCEL_ADMIN_ApprovedBy_TMP + $totalAmount_CANCEL_MEMBER_ApprovedBy_TMP;
	// 	// Total ALL Cancel By TMP
	// 	$totalAllAction_CANCEL_TMP = $totalAction_CANCEL_CreatedBy_TMP + $totalAction_CANCEL_ApprovedBy_TMP;
	// 	$totalAllAmount_CANCEL_TMP = $totalAmount_CANCEL_CreatedBy_TMP + $totalAmount_CANCEL_ApprovedBy_TMP;

    // /**************************************** API act for TMP ****************************************/
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
			'allMainTask' => $allMainTask,
			'allConnectResponse' => $allConnectResponse,
			'employeeEmail' => $employeeEmail,
			'title' => 'Employee Appraisal Report | '.$this->Xin_model->site_title(),
			'all_employees' => $this->Xin_model->all_employees(),
			'breadcrumbs' => "Appraisal report detail",
			'path_url' => 'appraisal_report',
			'reportType' => $reportType,
			'reportMonth' => $reportDate,
			'reportMonthTo' => $reportDateAPIformatTo,
			'period' => $period,
			'subDeptid' => $user[0]->sub_department_id,
			/*=================== for API AMP ===================*/
			// WD ----------------------------
			// WD brand Anonymous
			'totalAction_WD_168_Anonymous_CreatedBy_AMP'=>$totalAction_WD_168_Anonymous_CreatedBy_AMP,
			'totalAmount_WD_168_Anonymous_CreatedBy_AMP'=>$totalAmount_WD_168_Anonymous_CreatedBy_AMP,
			'totalAction_WD_168_Anonymous_ApprovedBy_AMP'=>$totalAction_WD_168_Anonymous_ApprovedBy_AMP,
			'totalAmount_WD_168_Anonymous_ApprovedBy_AMP'=>$totalAmount_WD_168_Anonymous_ApprovedBy_AMP,
			// WD brand Seniormasteragent
			'totalAction_WD_168_Seniormasteragent_CreatedBy_AMP'=>$totalAction_WD_168_Seniormasteragent_CreatedBy_AMP,
			'totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP'=>$totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP,
			'totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP,
			'totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP,
			// WD brand Ayosbobet
			'totalAction_WD_168_Ayosbobet_CreatedBy_AMP'=>$totalAction_WD_168_Ayosbobet_CreatedBy_AMP,
			'totalAmount_WD_168_Ayosbobet_CreatedBy_AMP'=>$totalAmount_WD_168_Ayosbobet_CreatedBy_AMP,
			'totalAction_WD_168_Ayosbobet_ApprovedBy_AMP'=>$totalAction_WD_168_Ayosbobet_ApprovedBy_AMP,
			'totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP'=>$totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP,
			// WD brand SbobetHoki
			'totalAction_WD_001_SbobetHoki_CreatedBy_AMP'=>$totalAction_WD_001_SbobetHoki_CreatedBy_AMP,
			'totalAmount_WD_001_SbobetHoki_CreatedBy_AMP'=>$totalAmount_WD_001_SbobetHoki_CreatedBy_AMP,
			'totalAction_WD_001_SbobetHoki_ApprovedBy_AMP'=>$totalAction_WD_001_SbobetHoki_ApprovedBy_AMP,
			'totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP'=>$totalAmount_WD_001_SbobetHoki_ApprovedBy_AMP,
			// FINAL total all WD ---
			'totalALLAction_WD_AMP'=>$totalALLAction_WD_AMP,
			'totalALLAmount_WD_AMP'=>$totalALLAmount_WD_AMP,
			// DEPO ----------------------------
			// DEPO brand Anonymous
			'totalAction_DEPO_168_Anonymous_CreatedBy_AMP'=>$totalAction_DEPO_168_Anonymous_CreatedBy_AMP,
			'totalAmount_DEPO_168_Anonymous_CreatedBy_AMP'=>$totalAmount_DEPO_168_Anonymous_CreatedBy_AMP,
			'totalAction_DEPO_168_Anonymous_ApprovedBy_AMP'=>$totalAction_DEPO_168_Anonymous_ApprovedBy_AMP,
			'totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP'=>$totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP,
			// DEPO brand Seniormasteragent
			'totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP'=>$totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP,
			'totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP'=>$totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP,
			'totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP,
			'totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP,
			// DEPO brand Ayosbobet
			'totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP'=>$totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP,
			'totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP'=>$totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP,
			'totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP'=>$totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP,
			'totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP'=>$totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP,
			// DEPO brand SbobetHoki
			'totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP'=>$totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP,
			'totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP'=>$totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP,
			'totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP'=>$totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP,
			'totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP'=>$totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP,
			// FINAL total all DEPO
			'totalALLAction_DEPO_AMP' => $totalALLAction_DEPO_AMP,
			'totalALLAmount_DEPO_AMP' => $totalALLAmount_DEPO_AMP,
			// TF ----------------------------
			// TF brand Anonymous
			'totalAction_TF_168_Anonymous_CreatedBy_AMP'=>$totalAction_TF_168_Anonymous_CreatedBy_AMP,
			'totalAmount_TF_168_Anonymous_CreatedBy_AMP'=>$totalAmount_TF_168_Anonymous_CreatedBy_AMP,
			'totalAction_TF_168_Anonymous_ApprovedBy_AMP'=>$totalAction_TF_168_Anonymous_ApprovedBy_AMP,
			'totalAmount_TF_168_Anonymous_ApprovedBy_AMP'=>$totalAmount_TF_168_Anonymous_ApprovedBy_AMP,
			// TF brand Seniormasteragent
			'totalAction_TF_168_Seniormasteragent_CreatedBy_AMP'=>$totalAction_TF_168_Seniormasteragent_CreatedBy_AMP,
			'totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP'=>$totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP,
			'totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP,
			'totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP'=>$totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP,
			// TF brand Ayosbobet
			'totalAction_TF_168_Ayosbobet_CreatedBy_AMP'=>$totalAction_TF_168_Ayosbobet_CreatedBy_AMP,
			'totalAmount_TF_168_Ayosbobet_CreatedBy_AMP'=>$totalAmount_TF_168_Ayosbobet_CreatedBy_AMP,
			'totalAction_TF_168_Ayosbobet_ApprovedBy_AMP'=>$totalAction_TF_168_Ayosbobet_ApprovedBy_AMP,
			'totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP'=>$totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP,
			// TF brand SbobetHoki
			'totalAction_TF_001_SbobetHoki_CreatedBy_AMP'=>$totalAction_TF_001_SbobetHoki_CreatedBy_AMP,
			'totalAmount_TF_001_SbobetHoki_CreatedBy_AMP'=>$totalAmount_TF_001_SbobetHoki_CreatedBy_AMP,
			'totalAction_TF_001_SbobetHoki_ApprovedBy_AMP'=>$totalAction_TF_001_SbobetHoki_ApprovedBy_AMP,
			'totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP'=>$totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP,

			// FINAL total TF
			'totalALLAction_TF_AMP' => $totalALLAction_TF_AMP,
			'totalALLAmount_TF_AMP' => $totalALLAmount_TF_AMP,
			/*=================== for API TMP ===================*/
			'totalAction_DEPO_CreatedBy_TMP' => $totalAction_DEPO_CreatedBy_TMP,
			'totalAmount_DEPO_CreatedBy_TMP' => $totalAmount_DEPO_CreatedBy_TMP,
			'totalAction_DEPO_ApprovedBy_TMP' => $totalAction_DEPO_ApprovedBy_TMP,
			'totalAmount_DEPO_ApprovedBy_TMP' => $totalAmount_DEPO_ApprovedBy_TMP,
			'totalAllAction_DEPO_TMP' => $totalAllAction_DEPO_TMP,
			'totalAllAmount_DEPO_TMP' => $totalAllAmount_DEPO_TMP,
			'totalAction_WD_CreatedBy_TMP' => $totalAction_WD_CreatedBy_TMP,
	    'totalAmount_WD_CreatedBy_TMP' => $totalAmount_WD_CreatedBy_TMP,
	    'totalAction_WD_ApprovedBy_TMP' => $totalAction_WD_ApprovedBy_TMP,
	    'totalAmount_WD_ApprovedBy_TMP' => $totalAmount_WD_ApprovedBy_TMP,
	    'totalAllAction_WD_TMP' => $totalAllAction_WD_TMP,
	    'totalAllAmount_WD_TMP' => $totalAllAmount_WD_TMP,
			'totalAction_TF_CreatedBy_TMP' => $totalAction_TF_CreatedBy_TMP,
	    'totalAmount_TF_CreatedBy_TMP' => $totalAmount_TF_CreatedBy_TMP,
	    'totalAction_TF_ApprovedBy_TMP' => $totalAction_TF_ApprovedBy_TMP,
	    'totalAmount_TF_ApprovedBy_TMP' => $totalAmount_TF_ApprovedBy_TMP,
	    'totalAllAction_TF_TMP' => $totalAllAction_TF_TMP,
	    'totalAllAmount_TF_TMP' => $totalAllAmount_TF_TMP,
			'totalAction_ADJ_CreatedBy_TMP' => $totalAction_ADJ_CreatedBy_TMP,
	    'totalAmount_ADJ_CreatedBy_TMP' => $totalAmount_ADJ_CreatedBy_TMP,
	    'totalAction_ADJ_ApprovedBy_TMP' => $totalAction_ADJ_ApprovedBy_TMP,
	    'totalAmount_ADJ_ApprovedBy_TMP' => $totalAmount_ADJ_ApprovedBy_TMP,
	    'totalAllAction_ADJ_TMP' => $totalAllAction_ADJ_TMP,
	    'totalAllAmount_ADJ_TMP' => $totalAllAmount_ADJ_TMP,
			'totalAction_BONUS_CreatedBy_TMP' => $totalAction_BONUS_CreatedBy_TMP,
	    'totalAmount_BONUS_CreatedBy_TMP' => $totalAmount_BONUS_CreatedBy_TMP,
	    'totalAction_BONUS_ApprovedBy_TMP' => $totalAction_BONUS_ApprovedBy_TMP,
	    'totalAmount_BONUS_ApprovedBy_TMP' => $totalAmount_BONUS_ApprovedBy_TMP,
	    'totalAllAction_BONUS_TMP' => $totalAllAction_BONUS_TMP,
	    'totalAllAmount_BONUS_TMP' => $totalAllAmount_BONUS_TMP,
			'totalAction_COMMISSION_CreatedBy_TMP' => $totalAction_COMMISSION_CreatedBy_TMP,
	    'totalAmount_COMMISSION_CreatedBy_TMP' => $totalAmount_COMMISSION_CreatedBy_TMP,
	    'totalAction_COMMISSION_ApprovedBy_TMP' => $totalAction_COMMISSION_ApprovedBy_TMP,
	    'totalAmount_COMMISSION_ApprovedBy_TMP' => $totalAmount_COMMISSION_ApprovedBy_TMP,
	    'totalAllAction_COMMISSION_TMP' => $totalAllAction_COMMISSION_TMP,
	    'totalAllAmount_COMMISSION_TMP' => $totalAllAmount_COMMISSION_TMP,
			'totalAction_CASHBACK_CreatedBy_TMP' => $totalAction_CASHBACK_CreatedBy_TMP,
	    'totalAmount_CASHBACK_CreatedBy_TMP' => $totalAmount_CASHBACK_CreatedBy_TMP,
	    'totalAction_CASHBACK_ApprovedBy_TMP' => $totalAction_CASHBACK_ApprovedBy_TMP,
	    'totalAmount_CASHBACK_ApprovedBy_TMP' => $totalAmount_CASHBACK_ApprovedBy_TMP,
	    'totalAllAction_CASHBACK_TMP' => $totalAllAction_CASHBACK_TMP,
	    'totalAllAmount_CASHBACK_TMP' => $totalAllAmount_CASHBACK_TMP,
			'totalAction_REFERRAL_CreatedBy_TMP' => $totalAction_REFERRAL_CreatedBy_TMP,
	    'totalAmount_REFERRAL_CreatedBy_TMP' => $totalAmount_REFERRAL_CreatedBy_TMP,
	    'totalAction_REFERRAL_ApprovedBy_TMP' => $totalAction_REFERRAL_ApprovedBy_TMP,
	    'totalAmount_REFERRAL_ApprovedBy_TMP' => $totalAmount_REFERRAL_ApprovedBy_TMP,
	    'totalAllAction_REFERRAL_TMP' => $totalAllAction_REFERRAL_TMP,
	    'totalAllAmount_REFERRAL_TMP' => $totalAllAmount_REFERRAL_TMP,
			'totalAction_FREEBET_CreatedBy_TMP' => $totalAction_FREEBET_CreatedBy_TMP,
	    'totalAmount_FREEBET_CreatedBy_TMP' => $totalAmount_FREEBET_CreatedBy_TMP,
	    'totalAction_FREEBET_ApprovedBy_TMP' => $totalAction_FREEBET_ApprovedBy_TMP,
	    'totalAmount_FREEBET_ApprovedBy_TMP' => $totalAmount_FREEBET_ApprovedBy_TMP,
	    'totalAllAction_FREEBET_TMP' => $totalAllAction_FREEBET_TMP,
	    'totalAllAmount_FREEBET_TMP' => $totalAllAmount_FREEBET_TMP,
			'totalAction_AFFILIATE_CreatedBy_TMP' => $totalAction_AFFILIATE_CreatedBy_TMP,
	    'totalAmount_AFFILIATE_CreatedBy_TMP' => $totalAmount_AFFILIATE_CreatedBy_TMP,
	    'totalAction_AFFILIATE_ApprovedBy_TMP' => $totalAction_AFFILIATE_ApprovedBy_TMP,
	    'totalAmount_AFFILIATE_ApprovedBy_TMP' => $totalAmount_AFFILIATE_ApprovedBy_TMP,
	    'totalAllAction_AFFILIATE_TMP' => $totalAllAction_AFFILIATE_TMP,
	    'totalAllAmount_AFFILIATE_TMP' => $totalAllAmount_AFFILIATE_TMP,
			'totalAction_SURRENDER_CreatedBy_TMP' => $totalAction_SURRENDER_CreatedBy_TMP,
	    'totalAmount_SURRENDER_CreatedBy_TMP' => $totalAmount_SURRENDER_CreatedBy_TMP,
	    'totalAction_SURRENDER_ApprovedBy_TMP' => $totalAction_SURRENDER_ApprovedBy_TMP,
	    'totalAmount_SURRENDER_ApprovedBy_TMP' => $totalAmount_SURRENDER_ApprovedBy_TMP,
	    'totalAllAction_SURRENDER_TMP' => $totalAllAction_SURRENDER_TMP,
	    'totalAllAmount_SURRENDER_TMP' => $totalAllAmount_SURRENDER_TMP,
			'totalAction_CANCEL_CreatedBy_TMP' => $totalAction_CANCEL_CreatedBy_TMP,
	    'totalAmount_CANCEL_CreatedBy_TMP' => $totalAmount_CANCEL_CreatedBy_TMP,
	    'totalAction_CANCEL_ApprovedBy_TMP' => $totalAction_CANCEL_ApprovedBy_TMP,
	    'totalAmount_CANCEL_ApprovedBy_TMP' => $totalAmount_CANCEL_ApprovedBy_TMP,
	    'totalAllAction_CANCEL_TMP' => $totalAllAction_CANCEL_TMP,
	    'totalAllAmount_CANCEL_TMP' => $totalAllAmount_CANCEL_TMP,
		);
		if(!empty($session)){
			$data['subview'] = $this->load->view("admin/appraisal_report/detail", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data);
		} else {
			redirect('admin/');
		}
	}
	/* 
	* for manually import API data from AMP
	*/
	public function import_amp()
	{
		#EndPoint
		$authenticationEndPoint_AMP='API/v1/authenticate/';
		$transactionEndPoint_AMP='API/v1/transaction/';
		$data['title'] = 'Import AMP';
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$data['breadcrumbs'] = 'Import API data AMP';
		$data['path_url'] = 'appraisal_report';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('company_id', 'Company ID', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Brand ID', 'trim|required');
		$this->form_validation->set_rules('dateFrom', 'Date From', 'trim|required');
		$this->form_validation->set_rules('dateTo', 'Date To', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		$this->form_validation->set_rules('channel', 'Channel', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data['subview'] = $this->load->view("admin/appraisal_report/api/import_amp", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			$post = $this->input->post(NULL, TRUE);
			$company_id = $post['company_id'];
			$brand_id = $post['brand_id'];
			$dateFrom = $post['dateFrom'];
			$dateTo = $post['dateTo'];
			$type = $post['type'];
			$channel = $post['channel'];
			$apiMethod = "POST";
			// authentication
			$authenticationAPI = $this->authenticate_API_AMP($company_id, $apiMethod,$authenticationEndPoint_AMP); 
			// transaction
			$transaction = $this->transaction_API_AMP($brand_id, $dateFrom, $dateTo, $type, $apiMethod, $transactionEndPoint_AMP,$authenticationAPI->data->access_token, $channel);
			if(($company_id==168) && ($brand_id==1)){
				$brand='Anonymous';
			}elseif(($company_id==168) && ($brand_id==2)){
				$brand='Seniormasteragent';
			}elseif(($company_id==168) && ($brand_id==3)){
				$brand='Ayosbobet';
			}else{
				$brand='SbobetHoki';
			}
			if($type=='WD'){
				$transactionType='Withdrawal';
			}elseif($type=='DEPO'){
				$transactionType='Deposit';
			}elseif($type=='TF'){
				$transactionType='Transfer';
			}
			if(!empty($transaction->data)){
				$time1 = microtime(true);
				$this->Appraisal_report_model->insertDataAPI_AMP($transaction, $brand_id, $company_id, $channel);
				$time2 = microtime(true);
				$time = number_format($time2-$time1,2);
				$timeRound = round($time);
				if($time>=1) $time=$timeRound;
				echo "<center><br />";
				echo 'AMP <br/><br/>';
				echo 'There are '.count($transaction->data).' <u>'.strtolower($transactionType).'</u> data in <u>'.$brand.'</u> on '.date('F Y',strtotime($dateFrom)).' saved in '.$time.' seconds<br/><br/>';
				echo "&laquo; <a href='".site_url()."admin/appraisal_report/import'>back</a>";
				// echo "<br/><br/><hr /><br/>";
				// echo "<pre>";var_dump($transaction->data);
				// echo "</center>";
			}else{
				echo "<center><br />";
				echo 'AMP <br/><br/>';
				echo "No <u>".strtolower($transactionType)."</u> data found in <u>".$brand."</u> on ".date('F Y',strtotime($dateFrom))."<br/><br/>";
				echo "&laquo; <a href='".site_url()."admin/appraisal_report/import'>back</a>";
				echo "<br/><br/><hr /><br/>";
				echo "<pre>";var_dump($transaction);
				echo "</center>";
			}
		}
	}
	/* 
	* Luffy 19 January 2020 12:29 pm
	* for manually import API data from TMP
	*/
	public function import_tmp()
	{
		#EndPoint
		$authenticationEndPoint_TMP='api/login';
		$transactionEndPoint_TMP='api/transaction';
		$data['title'] = 'Import TMP';
		$session = $this->session->userdata('username');
		if(empty($session)) redirect('admin/');
		$data['breadcrumbs'] = 'Import API data TMP';
		$data['path_url'] = 'appraisal_report';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('channel', 'Channel', 'trim|required');
		$this->form_validation->set_rules('dateFrom', 'Date From', 'trim|required');
		$this->form_validation->set_rules('dateTo', 'Date To', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data['subview'] = $this->load->view("admin/appraisal_report/api/import_tmp", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			$post = $this->input->post(NULL, TRUE);
      $channel = $post['channel'];
			$dateFrom = $post['dateFrom'];
			$dateTo = $post['dateTo'];
			$type = $post['type'];
			$apiMethod = "POST";
			// authentication
			$authenticationAPI_TMP = $this->authenticate_API_TMP($apiMethod, $authenticationEndPoint_TMP); 
			// transaction
			$transaction = $this->transaction_API_TMP($dateFrom, $dateTo, $type, $apiMethod, $transactionEndPoint_TMP,$authenticationAPI_TMP->data->token, $channel);
			if($type=='DEPO'){
				$transactionType='Deposit';
			}elseif($type=='WD'){
				$transactionType='Withdrawal';
			}elseif($type=='TF'){
				$transactionType='Transfer';
			}elseif($type=='ADJ'){
				$transactionType='Adjustment';
			}elseif($type=='BONUS'){
				$transactionType='Bonus';
			}elseif($type=='COMMISSION'){
				$transactionType='Commission';
			}elseif($type=='CASHBACK'){
				$transactionType='Cashback';
			}elseif($type=='REFERRAL'){
				$transactionType='Referral';
			}elseif($type=='FREEBET'){
				$transactionType='Freebet';
			}elseif($type=='AFFILIATE'){
				$transactionType='Affiliate';
			}elseif($type=='SURRENDER'){
				$transactionType='Surrender';
			}elseif($type=='CANCEL'){
				$transactionType='Cancel';
			}
			if(!empty($transaction->data)){
				$time1 = microtime(true);
				$this->Appraisal_report_model->insertDataAPI_TMP($transaction, $channel);
				$time2 = microtime(true);
				$time = number_format($time2-$time1,2);
				$timeRound = round($time);
				if($time>=1) $time=$timeRound;
				echo "<center><br />";
				echo 'TMP <br/><br/>';
				echo 'There are '.count($transaction->data).' <u>'.strtolower($transactionType).'</u> on ' . date('F Y', strtotime($dateFrom)) .' saved in '.$time.' seconds<br/><br/>';
				echo "&laquo; <a href='".site_url()."admin/appraisal_report/import'>back</a>";
				echo "<br/><br/><hr /><br/>";
				echo "<pre>";var_dump($transaction->data);
				echo "</center>";
			}else{
				echo "<center><br />";
				echo 'TMP <br/><br/>';
				echo "No <u>".strtolower($transactionType)."</u> data found on ".date('F Y',strtotime($dateFrom))."<br/><br/>";
				echo "&laquo; <a href='".site_url()."admin/appraisal_report/import'>back</a>";
				echo "<br/><br/><hr /><br/>";
				echo "<pre>";var_dump($transaction);
				echo "</center>";
			}
		}
	}
	/* 
	* Jazz7381
	*/
	// Cron Import AMP
	public function cron_import_amp()
	{
		$data['title'] = 'Cron AMP';
		$data['breadcrumbs'] = 'Cron AMP';
		// prepare data
		$company_id = $this->uri->segment(5);
		$brand_id = $this->uri->segment(7);
		$type = strtoupper($this->uri->segment(9));
		$channel = strtoupper($this->uri->segment(11));
		if($this->uri->segment(12)){
			$dateFrom = getFirstDateFromYearMonth_dmY($this->uri->segment(13));
			$dateTo = getLastDateFromYearMonth_dmY($this->uri->segment(13));
		}else{
			$dateFrom = date('d-m-Y');
			$dateTo = $dateFrom;
		}
		$apiMethod = "POST";
		if(empty(	$company_id) || empty($type) || empty($brand_id)){
			echo "\r\nNo data. Parameter request was empty.<br />";
			echo "<pre><br/>&raquo; Redirecting you back, please wait...";
			header("refresh:10; url=" . site_url('admin/appraisal_report'));
		}else{
			#EndPoint
			$authenticationEndPoint_AMP='API/v1/authenticate/';
			$transactionEndPoint_AMP='API/v1/transaction/';
			// authentication
			$authenticationAPI = $this->authenticate_API_AMP($company_id, $apiMethod,$authenticationEndPoint_AMP);
			if($authenticationAPI->status != 405){
				// transaction
				$transaction = $this->transaction_API_AMP($brand_id, $dateFrom, $dateTo, $type, $apiMethod, $transactionEndPoint_AMP,$authenticationAPI->data->access_token, $channel);
				// end transaction
				if(($company_id==168) && ($brand_id==1)){
					$brand='Anonymous';
				}elseif(($company_id==168) && ($brand_id==2)){
					$brand='Seniormasteragent';
				}elseif(($company_id==168) && ($brand_id==3)){
					$brand='Ayosbobet';
				}else{
					$brand='SbobetHoki';
				}
				$transactionType='';
				if($type=='WD'){
					$transactionType='Withdrawal';
				}elseif($type=='DEPO'){
					$transactionType='Deposit';
				}elseif($type=='TF'){
					$transactionType='Transfer';
				}
				if(!empty($transaction->data)){
					$time1 = microtime(true);
					$this->Appraisal_report_model->insertDataAPI_AMP($transaction, $brand_id, $company_id, $channel);
					$time2 = microtime(true);
					$time = number_format($time2-$time1,2);
					$timeRound = round($time);
					if($time>=1) $time=$timeRound;
					echo 'AMP <br/><br/>';
					echo 'There are '.count($transaction->data).' <u>'.strtolower($transactionType).'</u> data in <u>'.$brand.'</u> on '.date('F Y',strtotime($dateFrom)).' and successfully saved in '.$time.' seconds.';
					echo "<pre><br/>&raquo; Redirecting you back, please wait...";
					header("refresh:10; url=" . site_url('admin/appraisal_report'));
					exit;
				}else{
					echo 'AMP <br/><br/>';
					echo "There is no <u>" . strtolower($transactionType) . "</u> data found in <u>" . $brand . "</u> on " . date('F Y', strtotime($dateFrom));
					echo "<pre><br/>&raquo; Redirecting you back, please wait...";
					header("refresh:10; url=" . site_url('admin/appraisal_report'));
					exit;
				}
			}else{
				echo 'Company ID is not exist';
				echo "<pre><br/>&raquo; Redirecting you back, please wait...";
				header("refresh:10; url=" . site_url('admin/appraisal_report'));
				exit;
			}
		}
	}
	// Cron Import TMP
	public function cron_import_tmp()
	{
		$data['title'] = 'Cron TMP';
		$data['breadcrumbs'] = 'Cron TMP';
		// prepare data
		$channel = strtoupper($this->uri->segment(5));
		$type = strtoupper($this->uri->segment(7));
		if($this->uri->segment(8)){
			$dateFrom = getFirstDateFromYearMonth_dmY($this->uri->segment(9));
			$dateTo = getLastDateFromYearMonth_dmY($this->uri->segment(9));
		}else{
			$dateFrom = date('d-m-Y');
			$dateTo = $dateFrom;
		}
		$apiMethod = "POST";
		if(empty($channel) || empty($type)){
			echo "\r\nNo data. Parameter request was empty.<br />";
			echo "<pre><br/>&raquo; Redirecting you back, please wait...";
			header("refresh:10; url=" . site_url('admin/appraisal_report'));
		}else{
			#EndPoint
			$authenticationEndPoint_TMP='api/login';
			$transactionEndPoint_TMP='api/transaction';
			// authentication
			$authenticationAPI_TMP = $this->authenticate_API_TMP($apiMethod, $authenticationEndPoint_TMP); 
			$transaction = $this->transaction_API_TMP($dateFrom, $dateTo, $type, $apiMethod, $transactionEndPoint_TMP,$authenticationAPI_TMP->data->token, $channel);
			// rule
			$transactionType='';
			if($type=='DEPO'){
				$transactionType='Deposit';
			}elseif($type=='WD'){
				$transactionType='Withdrawal';
			}elseif($type=='TF'){
				$transactionType='Transfer';
			}elseif($type=='ADJ'){
				$transactionType='Adjustment';
			}elseif($type=='BONUS'){
				$transactionType='Bonus';
			}elseif($type=='COMMISSION'){
				$transactionType='Commission';
			}elseif($type=='CASHBACK'){
				$transactionType='Cashback';
			}elseif($type=='REFERRAL'){
				$transactionType='Referral';
			}elseif($type=='FREEBET'){
				$transactionType='Freebet';
			}elseif($type=='AFFILIATE'){
				$transactionType='Affiliate';
			}elseif($type=='SURRENDER'){
				$transactionType='Surrender';
			}elseif($type=='CANCEL'){
				$transactionType='Cancel';
			}
			if(!empty($transaction->data)){
				$time1 = microtime(true);
				$this->Appraisal_report_model->insertDataAPI_TMP($transaction, $channel);
				$time2 = microtime(true);
				$time = number_format($time2-$time1,2);
				$timeRound = round($time);
				if($time>=1) $time=$timeRound;
				echo 'TMP <br/><br/>';
				echo 'There are '.count($transaction->data).' <u>'.strtolower($transactionType).'</u> data in </u> on '.date('F Y',strtotime($dateFrom)).' and successfully saved in '.$time.' seconds.';
				echo "<pre><br/>&raquo; Redirecting you back, please wait...";
				header("refresh:10; url=" . site_url('admin/appraisal_report'));
				exit;
			}else{
				echo 'TMP <br/><br/>';
				echo "There is no <u>".strtolower($transactionType)."</u> data on ".date('F Y',strtotime($dateFrom));
				echo "<pre><br/>&raquo; Redirecting you back, please wait...";
				header("refresh:10; url=" . site_url('admin/appraisal_report'));
				exit;
			}
		}
	}

}
