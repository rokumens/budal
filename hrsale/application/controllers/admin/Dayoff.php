	<?php
 /**
 * Customer Data
 * Import customer number from Excel
 * @author luffy
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start(); // prevant header redirect
class Dayoff extends MY_Controller {

	public function __construct() {
  	parent::__construct();
		//load the login model
		$this->load->model('Company_model');
		$this->load->model('Xin_model');
		$this->load->model('Department_model');
		$this->load->model('Dayoff_model');
		$this->load->model('Employees_model');
		$this->load->library('Pdf');
	}
	// round(9.1, 0, PHP_ROUND_HALF_UP);	// who knows wanted to going down.
	// ceil(9.1)	// who knows wanted to going up.
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	public function index()
	{
		$session = $this->session->userdata('username');
		if (empty($session)) 
			redirect('admin/');
		$data['title'] = 'Dayoff | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Dayoff';
		$data['path_url'] = 'dayoff';
		$objAllApprover = $this->Dayoff_model->getAllApprover()->result();
		foreach($objAllApprover as $approver){
			$allApprover[$approver->user_id] = $approver->username;
		}
		$data['allApprover'] = $allApprover;
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1012',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/dayoff/dayoff_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	// list view index
	public function dayoff_list()
	{
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$userEmail = $session['email'];
		if (!empty($session)) 
			$this->load->view("admin/dayoff/dayoff_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$dayoff = $this->Dayoff_model->get_dayoff();
		$data = array();
		foreach($dayoff->result() as $r) {
			if(in_array('1014',$role_resources_ids)) {
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/dayoff/detail/'.$r->period.'/'.$r->dayoff_start_day.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			}else{
				$view="";
			}
			if(in_array('1015',$role_resources_ids)) {
				$download='<a href="'.site_url().'admin/dayoff/pdf/p/'.$r->period.'" class="btn btn-social-icon mb-1 btn-outline-github" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Dayoff">
                <i class="fa fa-file-pdf-o"></i>
              </a> ';
			}else{
				$download="";
			}
			$u_created = $this->Xin_model->read_user_info($r->created_by);
			if(!is_null($u_created)){
				$f_name = $u_created[0]->employee_id.' - '.$u_created[0]->username;
			} else {
				$f_name = '--';
			}
			$combhr = $view.$download;
			$data[] = array(
				$combhr,
				date('d F Y',strtotime($r->dayoff_start_day)),
				date('d F Y',strtotime($r->dayoff_end_day)),
				$f_name
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $dayoff->num_rows(),
			"recordsFiltered" => $dayoff->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	// genefrate rolling shift ajax
	public function add_dayoff(){
		if($this->input->post('add_type')=='add_dayoff') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session = $this->session->userdata('username');
			$allEmployees = [];
			$dataInsert = [];
			// luffy 28 January 2020 09:47 pm | get the latest period
			$currentPeriod=$this->Dayoff_model->getMaxPeriod()->period+1;
			$post = $this->input->post(NULL, TRUE);
			$dateFrom = $post['dateFrom'];//date from
			$dateTo = $post['dateTo'];// date to
			$date1=date_create($dateFrom);
			$date2=date_create($dateTo);
			$diffDateFromTo=date_diff($date1,$date2);
			$diffDate=$diffDateFromTo->format("%a");
			if(empty($dateFrom) OR empty($dateTo)){// if 'date from' and 'date to' is empty show error
				$Return['error'] = 'Please choose date.';
			}elseif($dateFrom > $dateTo){
				$Return['error'] = 'Date to must greater than date from.';
			}elseif($diffDate < 6){ # biarkan 6, ini = 7 days
				$Return['error'] = 'Dayoff schedule must be at least 1 week or 7 days.';
			}elseif(empty($post['approval_by_1'])){
				$Return['error'] = 'Please choose approval 1.';
			}elseif(empty($post['approval_by_2'])){
				$Return['error'] = 'Please choose approval 2.';
			}elseif(empty($post['approval_by_3'])){
				$Return['error'] = 'Please choose approval 3.';
			}elseif($post['approval_by_1'] == $post['approval_by_2'] OR $post['approval_by_1'] == $post['approval_by_3'] OR $post['approval_by_2'] == $post['approval_by_3']){
				$Return['error'] = 'Approval By cannot be same person.';
			}
			if($Return['error'] != ''){
				$this->output($Return);
				exit();
			}
			// luffy 2 February 2020 10:27 am
			$note = strip_tags($post['note']); // get from post
			$totalSubdept = $this->Dayoff_model->getTotalSubDept()->result();
			foreach ($totalSubdept as $value) {
				$allEmployees['1'] = $this->Dayoff_model->getAllEmployee($value->sub_department_id, 1)->result_array();// all employee by morning shift
				$allEmployees['2'] = $this->Dayoff_model->getAllEmployee($value->sub_department_id, 2)->result_array();// all employee by night shift
				$dayStart = $post['dateFrom']; // get from post
				$dayEnd = $post['dateTo']; // get from post
				$date1 = new DateTime($dayStart);
				$date2 = new DateTime($dayEnd);
				$dayNameFrom = nama_hari($date1->format("Y-m-d"));
				$dayNameTo = nama_hari($date2->format("Y-m-d"));
				$tgl = getDaysBetweenRangeDate($dayNameFrom, $date1->format('Y-m-d'), $date2->format('Y-m-d'));
				foreach($allEmployees as $employees){
					if(!empty($employees)){
						$countEmployee = count($employees);// jumlah employee
						$quotaEmployee = ceil($countEmployee/5);// jumlah orang dalam 1 hari
						$totalDaysInWeek = ceil($countEmployee/$quotaEmployee);// Jumlah hari dalam 1 minggu
						$allDaysInWeek = array_chunk($employees, $quotaEmployee);
						$defaultDay = 0;
						foreach ($tgl as $day) {
							$selectedDateFrom = $day->format('Y-m-d');
							foreach($allDaysInWeek as $key => $employee){
								$dayoffDate = date('Y-m-d', strtotime("+$defaultDay day", strtotime($selectedDateFrom)));
								$checkDateAlreadyInDayoff = $this->db->get_where('dayoff', ['dayoff_date'=>$dayoffDate])->result();
								if(!empty($checkDateAlreadyInDayoff)){
									$Return['error'] = 'Please select another date. <br> Dayoff from this date has been created previously.';
									$this->output($Return);
									exit();
								}
								if(count($employee) == 2){
									$data = [
										'user_id'=>$employee[0]['user_id'],
										'period'=>$currentPeriod,
										'employee_id'=>$employee[0]['employee_id'],
										'sub_department_id'=>$employee[0]['sub_department_id'],
										'office_shift_id'=>$employee[0]['office_shift_id'],
										'dayoff_date'=>$dayoffDate,
										'dayoff_start_day'=>date('Y-m-d', strtotime($dayStart)),
										'dayoff_end_day'=>date('Y-m-d', strtotime($dayEnd)),
										'created_at'=>date('Y-m-d'),
										'created_by'=>$this->session->userdata('user_id')['user_id'],
										'have_quota'=>0,
										'approval_1'=>$post['approval_by_1'],
										'approval_2'=>$post['approval_by_2'],
										'approval_3'=>$post['approval_by_3'],
										'note'=>$note,
									];
									$dataInsert[] = $data;
									$data2 = [
										'user_id'=>$employee[1]['user_id'],
										'period'=>$currentPeriod,
										'employee_id'=>$employee[1]['employee_id'],
										'sub_department_id'=>$employee[1]['sub_department_id'],
										'office_shift_id'=>$employee[1]['office_shift_id'],
										'dayoff_date'=>$dayoffDate,
										'dayoff_start_day'=>date('Y-m-d', strtotime($dayStart)),
										'dayoff_end_day'=>date('Y-m-d', strtotime($dayEnd)),
										'created_at'=>date('Y-m-d'),
										'created_by'=>$this->session->userdata('user_id')['user_id'],
										'have_quota'=>0,
										'approval_1'=>$post['approval_by_1'],
										'approval_2'=>$post['approval_by_2'],
										'approval_3'=>$post['approval_by_3'],
										'note'=>$note,
									];
									$dataInsert[] = $data2;
								}else{
									$data = [
										'user_id'=>$employee[0]['user_id'],
										'period'=>$currentPeriod,
										'employee_id'=>$employee[0]['employee_id'],
										'sub_department_id'=>$employee[0]['sub_department_id'],
										'office_shift_id'=>$employee[0]['office_shift_id'],
										'dayoff_date'=>$dayoffDate,
										'dayoff_start_day'=>date('Y-m-d', strtotime($dayStart)),
										'dayoff_end_day'=>date('Y-m-d', strtotime($dayEnd)),
										'created_at'=>date('Y-m-d'),
										'created_by'=>$this->session->userdata('user_id')['user_id'],
										'have_quota'=>0,
										'approval_1'=>$post['approval_by_1'],
										'approval_2'=>$post['approval_by_2'],
										'approval_3'=>$post['approval_by_3'],
										'note'=>$note,
									];
									$dataInsert[] = $data;
								}
								$defaultDay++;
							}
							if($defaultDay == $totalDaysInWeek){//
								$defaultDay = 0;
							}
						}
					}
				}
			}
			// luffy 06 Feb 2020 06:07pm | Paramaters for notif to slack.
			$dayOffStartDay=date('d M Y', strtotime($dayStart));
			$dayOffEndDay=date('d M Y', strtotime($dayEnd));
			$approver1=$post['approval_by_1'];
			$approver2=$post['approval_by_2'];
			$approver3=$post['approval_by_3'];
			$userIdSession=$this->session->userdata('user_id')['user_id'];
			$employeeData=$this->Employees_model->read_employee_information($userIdSession);
			$createdBy=$employeeData[0]->employee_id.' - '.$employeeData[0]->username;
			// save dayoff to db
			$result = $this->Dayoff_model->add($dataInsert);
			if($result == TRUE) {
				$Return['result'] = "Dayoff created.";
				// luffy 6 Feb 2020 06:11 pm | send notif to slack
				$this->sendCreatedDayoffToChannel($currentPeriod, $dayOffStartDay, $dayOffEndDay,$createdBy,$note,$approver1,$approver2,$approver3);
			}else{
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}  

	// luffy 6 Feb 2020 - 06:14 pm
	// send channel notif to slack after Dayoff created & need for approval.
	function sendCreatedDayoffToChannel($currentPeriod, $dayOffStartDay, $dayOffEndDay, $createdBy, $note, $approver1, $approver2, $approver3){
		#9-it-support-kanon-a2
		$callSlack = curl_init('https://hooks.slack.com/services/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');
		#luffy
		// $callSlack = curl_init('https://hooks.slack.com/services/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');

		$dayOffStartDayParam=date('Y-m-d',strtotime($dayOffStartDay));
		$redirectTo = site_url().'admin/dayoff/detail/'.$currentPeriod.'/'.$dayOffStartDayParam;
		$mentionApprover1 = '<@UCG1EANCS>'; #goku
		$mentionApprover2 = '<@U03K0R81Z>'; #roy
		$mentionApprover3 = '<@UQQ4H3LHW>'; #medusa
		if($approver1=='7') $mentionApprover1='<@UCG1EANCS>'; #goku
		elseif($approver1=='54') $mentionApprover1='<@U03K0R81Z>'; #roy
		elseif($approver1=='106') $mentionApprover1='<@UQQ4H3LHW>'; #medusa
		if($approver2=='7') $mentionApprover2='<@UCG1EANCS>'; #goku
		elseif($approver2=='54') $mentionApprover2='<@U03K0R81Z>'; #roy
		elseif($approver2=='106') $mentionApprover2='<@UQQ4H3LHW>'; #medusa
		if($approver3=='7') $mentionApprover3='<@UCG1EANCS>'; #goku
		elseif($approver3=='54') $mentionApprover3='<@U03K0R81Z>'; #roy
		elseif($approver3=='106') $mentionApprover3='<@UQQ4H3LHW>'; #medusa
		$notezz=(empty($note))?"":"Note: $note";
		$array = array(
			'username' => 'APG Bot',
			// 'channel' => 'GJ32TFJ2G', #9-it-support-kanon-a2
			'channel' => 'DFTV5U3E3', #luffy
			'text' => "New dayoff schedule just created and need your approval. $mentionApprover1 $mentionApprover2 $mentionApprover3",
			'mrkdwn' => true,
			'attachments' => array(
				array(
					'color' => '#ff4757',
					'title' => "Dayoff period: $dayOffStartDay - $dayOffEndDay",
					'fallback' => 'fallback',
					'pretext' => '',
					'author_name' => ">> Please <$redirectTo|click here> for approval.",
					'author_link' => '#',
					'author_icon' => '',
					'text' => $notezz,
					'fields' => array(
						array(
							#'title' => 'tit field',
							#'value' => 'value field',
							'title' => '',
							'value' => '',
							'short' => false,
						),
					),
					'footer' => "Dayoff prepared by *$createdBy* | Thank you for your kind attention.",
					'footer_icon' => 'https://emoji.slack-edge.com/T03JZKZCX/apg/5032c072b6a519ac.png',
				),
			),
		);
		$data = json_encode($array);
		curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
		curl_setopt($callSlack, CURLOPT_CRLF, true);
		curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
			'Content-Type => application/json',
			'Content-Length => ' . strlen($data))
		);
		$result = curl_exec($callSlack);
		curl_close($callSlack);
		return $result;
	}

	// detail dayoff by period
	public function detail($period = NULL) {
		$session = $this->session->userdata('username');
		// $sessionUserId = $session['user_id'];
		$sessionUserId = 007;// session access
		$data['sessionUserId'] = $sessionUserId;
		if (empty($session)) 
			redirect('admin/');
		// luffy 10 Feb 2020 08:06 pm
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (!in_array('1014', $role_resources_ids)) 
			redirect('admin/');
		if($period == NULL)
			redirect('admin/dayoff');
		$data['title'] = 'Dayoff Detail | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Dayoff Detail';
		$data['path_url'] = 'dayoff';
		// luffy 8 feb 2020 08:37 pm
		$data['period'] = $this->uri->segment(4);
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['dayoff'] = $this->Dayoff_model->getDayoffByPeriod($period)->result_array();
		$existingDayoff = $this->Dayoff_model->getDayoffByPeriod($period)->result();
		$objAllApprover = $this->Dayoff_model->getAllApprover()->result();
		foreach($objAllApprover as $approver){
			$allApprover[$approver->user_id] = $approver->username;
		}
		$data['allApprover'] = $allApprover;
		$data['note']=$existingDayoff[0]->note;
		$approval = $this->Dayoff_model->getDayoffByPeriod($period)->row();
		$selectedApproval = 0;
		if($sessionUserId == $approval->approval_1){
			$selectedApproval = $approval->approval_action_by_1;
		}elseif($sessionUserId == $approval->approval_2){
			$selectedApproval = $approval->approval_action_by_2;
		}elseif($sessionUserId == $approval->approval_3){
			$selectedApproval = $approval->approval_action_by_3;
		}
		$data['selectedApproval'] = $selectedApproval;
		$data['prepare_by'] = $this->Dayoff_model->getEmployeeByUserId($approval->created_by);
		$data['approval_1'] = $this->Dayoff_model->getEmployeeByUserId($approval->approval_1);
		$data['approval_2'] = $this->Dayoff_model->getEmployeeByUserId($approval->approval_2);
		$data['approval_3'] = $this->Dayoff_model->getEmployeeByUserId($approval->approval_3);
		$approval_user_1 = $approval->approval_1; //7
		$approval_user_2 = $approval->approval_2; //54
		$approval_user_3 = $approval->approval_3; //106
		$data['approval_user_1'] = $approval_user_1;
		$data['approval_user_2'] = $approval_user_2;
		$data['approval_user_3'] = $approval_user_3;
		$data['approval_status'] = $this->Dayoff_model->getApprovalStatus($period)->row();
		$data['status_dropdown'] = [
			0 => $this->lang->line('xin_pending'),
			1 => $this->lang->line('xin_accepted'),
			2 => $this->lang->line('xin_rejected')
		];
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// if (in_array('95', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/dayoff/detail", $data, true);
			$this->load->view('admin/layout/layout_main', $data); //page load
		// } else {
		// 	redirect('admin/dashboard');
		// }
	}
	// jazz 7381 - 5 februari 2020 17:38
	// update dayoff
	// luffy: it's to update Dayoff Detail, and update() update event in the calendar (drag & drop event)
	public function update_dayoff() {
		if($this->input->post('type')=='update_dayoff') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session = $this->session->userdata('username');
			$sessionUserId = $session['user_id']; // session access
			$post = $this->input->post(NULL, TRUE);// get all data from post
			$approval = $this->Dayoff_model->getDayoffByPeriod($post['period'])->row();
			// approval usermb 
			// get from approval user
			$approval_user_1 = $approval->approval_1; //7
			$approval_user_2 = $approval->approval_2; //54
			$approval_user_3 = $approval->approval_3; //106
			$approval_by_1 = $approval->approval_action_by_1;
			$approval_by_2 = $approval->approval_action_by_2;
			$approval_by_3 = $approval->approval_action_by_3;
			$data = [
				'note'=>strip_tags($post['note']), // note from post
				'updated_at'=>date('Y-m-d H:i:s'),
			];
			// if user id is approval
			// uncomment line bellow if you want bypass that approval condition.
			// if($approval_user_1 == $approval->approval_1 || $approval_user_2 == $approval->approval_2 || $approval_user_3 == $approval->approval_3){
			if($sessionUserId == $approval->approval_1 || $sessionUserId == $approval->approval_2 || $sessionUserId == $approval->approval_3){
				// validation
				if($post['approval_status'] == 0){
					$Return['error'] = "Please only accept or reject for status.";
				}
				// approval status validation
				if($approval->approval_1 == $sessionUserId){
					if($post['approval_status'] == 1 && $approval_by_2 == 1 && $approval_by_3 == 1){ // accept validation
						$data['approval_status'] = 1;
					}elseif($post['approval_status'] == 2 && $approval_by_2 == 2 && $approval_by_3 == 2){ // accept validation
						$data['approval_status'] = 2;
					}else{ // pending validation
						$data['approval_status'] = 0;
					}
					$data['approved_by_1'] = $sessionUserId;
					$data['approval_action_by_1'] = $post['approval_status'];
					$data['approved_date_1'] = date('Y-m-d H:i:s');
				}elseif($approval->approval_2 == $sessionUserId){
					if($approval_by_1 == 1 && $post['approval_status'] == 1 && $approval_by_3 == 1){ // accept validation
						$data['approval_status'] = 1;
					}elseif($approval_by_1 == 2 && $post['approval_status'] == 2 && $approval_by_3 == 2){ // accept validation
						$data['approval_status'] = 2;
					}else{ // pending validation
						$data['approval_status'] = 0;
					}
					$data['approved_by_2'] = $sessionUserId;
					$data['approval_action_by_2'] = $post['approval_status'];
					$data['approved_date_2'] = date('Y-m-d H:i:s');
				}elseif($approval->approval_3 == $sessionUserId){
					if($approval_by_1 == 1 && $approval_by_2 == 1 && $post['approval_status'] == 1){ // accept validation
						$data['approval_status'] = 1;
					}elseif($approval_by_1 == 2 && $approval_by_2 == 2 && $post['approval_status'] == 2){ // accept validation
						$data['approval_status'] = 2;
					}else{ // pending validation
						$data['approval_status'] = 0;
					}
					$data['approved_by_3'] = $sessionUserId;
					$data['approval_action_by_3'] = $post['approval_status'];
					$data['approved_date_3'] = date('Y-m-d H:i:s');
				}
			}else{
				// validasi for approval
				if($post['approval_by_1'] == $post['approval_by_2'] OR $post['approval_by_1'] == $post['approval_by_3'] OR $post['approval_by_2'] == $post['approval_by_3']){
					$Return['error'] = 'Approval By cannot be same person.';
				}
				// validasi for approval 1
				if($approval->approval_action_by_1 != 0){
					if($post['approval_by_1'] != $approval->approved_by_1){
						$approvalName = $this->Dayoff_model->getEmployeeByUserId($approval->approval_1); // get username from user id approval
						if($approval->approval_action_by_1 == 1){
							$stringStatus =  $this->lang->line('xin_accepted');
						}elseif($approval->approval_action_by_1 == 2){
							$stringStatus =  $this->lang->line('xin_rejected');
						}
						$Return['error'] = "$approvalName->username already ".strtolower($stringStatus).", you can't change this approval.";
					}
				}
				// validasi for approval 2
				if($approval->approval_action_by_2 != 0){
					if($post['approval_by_2'] != $approval->approved_by_2){
						$approvalName = $this->Dayoff_model->getEmployeeByUserId($approval->approval_2); // get username from user id approval
						if($approval->approval_action_by_2 == 1){
							$stringStatus =  $this->lang->line('xin_accepted');
						}elseif($approval->approval_action_by_2 == 2){
							$stringStatus =  $this->lang->line('xin_rejected');
						}
						$Return['error'] = "$approvalName->username already ".strtolower($stringStatus).", you can't change this approval."; // get username from user id approval
					}
				}
				// validasi for approval 3
				if($approval->approval_action_by_3 != 0){
					if($post['approval_by_3'] != $approval->approved_by_3){
						$approvalName = $this->Dayoff_model->getEmployeeByUserId($approval->approval_3);
						if($approval->approval_action_by_3 == 1){
							$stringStatus =  $this->lang->line('xin_accepted');
						}elseif($approval->approval_action_by_3 == 2){
							$stringStatus =  $this->lang->line('xin_rejected');
						}
						$Return['error'] = "$approvalName->username already ".strtolower($stringStatus).", you can't change this approval.";
					}
				}
				$data['approval_1'] = $post['approval_by_1'];
				$data['approval_2'] = $post['approval_by_2'];
				$data['approval_3'] = $post['approval_by_3'];
			}
			if($Return['error']!=''){
				$this->output($Return);
				exit();
			}
			//luffy 08 Feb 2020 07:46pm | Paramaters for notif to slack.
			$period=$post['periodParam'];
			$approvalStatus=$post['approval_status'];
			$existingDayoff = $this->Dayoff_model->getDayoffByPeriod($period)->row();
			$dayOffStartDay = date('d M Y', strtotime($existingDayoff->dayoff_start_day));
			$dayOffEndDay = date('d M Y', strtotime($existingDayoff->dayoff_end_day));
			$userIdSession = $this->session->userdata('user_id')['user_id'];
			$createdBy = $existingDayoff->created_by;
			$approver = $userIdSession;
			// end if user id is approval
			$result = $this->Dayoff_model->updateApproval($post['period'], $data);
			if ($result == TRUE){
				$Return['result'] = "Dayoff updated.";
				// luffy 8 Feb 2020 07:48 pm
				// send notif to slack only when dayoff was Approved / Rejected.
				if($approvalStatus!=0){
					$this->sendApprovedDayoffToChannel($period, $dayOffStartDay, $dayOffEndDay, $createdBy, $approver, $approvalStatus);
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	// luffy 6 Feb 2020 - 06:14 pm
	// send channel notif to slack after Dayoff created & need for approval.
	function sendApprovedDayoffToChannel($period, $dayOffStartDay, $dayOffEndDay, $createdByParam, $approverParam, $approvalStatus){
		// #9-it-support-kanon-a2
		$callSlack = curl_init('https://hooks.slack.com/services/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'); 
		#luffy 	
		// $callSlack = curl_init('https://hooks.slack.com/services/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'); 
		// $dayOffStartDayParam=date('Y-m-d',strtotime($dayOffStartDay));
		$redirectTo = site_url().'admin/dayoff/detail/'.$period.'/'.$dayOffStartDay;
		// luffy 8 Feb 2020 10:00 pm
		($approvalStatus==1)?$approvalAction='accepted':$approvalAction='rejected';
		//created by
		if($createdByParam==88){ #chunz 
			$createdBy = '<@UKTMKE67K>';
		}elseif($createdByParam==43){ #romeo 
			$createdBy = '<@UFD73UZ47>';
		}else{
			$createdByData = $this->Employees_model->read_employee_information($createdByParam);
			$createdBy = $createdByData[0]->employee_id . ' - ' . $createdByData[0]->username;
		}
		$approverData = $this->Employees_model->read_employee_information($approverParam);
		$approver = $approverData[0]->employee_id . ' - ' . $approverData[0]->username;
		$array = array(
			'username' => 'APG Bot',
			// 'channel' => 'GJ32TFJ2G', #9-it-support-kanon-a2
			'channel' => 'DFTV5U3E3', #luffy
			'text' => "Hi $createdBy, dayoff schedule period: $dayOffStartDay - $dayOffEndDay has been $approvalAction by $approver.",
			'mrkdwn' => true,
			'attachments' => array(
				array(
					'color' => '#ff4757',
					'title' => "",
					'fallback' => 'fallback',
					'pretext' => '',
					'author_name' => ">> Go <$redirectTo|here> for detail.",
					'author_link' => '#',
					'author_icon' => '',
					'text' => '',
					'fields' => array(
						array(
							#'title' => 'tit field',
							#'value' => 'value field',
							'title' => '',
							'value' => '',
							'short' => false,
						),
					),
				),
			),
		);
		$data = json_encode($array);
		curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
		curl_setopt($callSlack, CURLOPT_CRLF, true);
		curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
			'Content-Type => application/json',
			'Content-Length => ' . strlen($data))
		);
		$result = curl_exec($callSlack);
		curl_close($callSlack);
		return $result;
	}

	// update dayoff / update when dayoff event drag
	// luffy: it's to update event in the calendar (drag & drop event), and update_dayoff() to update Dayoff Detail
	public function update(){
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		// start date from get
		$id = $this->input->get('id');
		$user_id = $this->input->get('user_id');
		$date = date('Y-m-d', strtotime($this->input->get('date')));
		$date_drop = date('Y-m-d', strtotime($this->input->get('date_drop')));
		$period = $this->input->get('period');
		// end data from get
		$employee = $this->db->get_where('xin_employees',['user_id'=>$user_id])->row();//get employee data
		$subdeptId = $employee->sub_department_id;//sub_department_id from employee
		$officeShiftId = $employee->office_shift_id; //from employee
		$countEmployee = $this->Dayoff_model->getCountEmployee($subdeptId, $officeShiftId)->row()->countEmployee;// jumlah employee
		$quotaEmployee = ceil($countEmployee/5);// jumlah orang dalam 1 hari
		$totalDaysInWeek = ceil($countEmployee/$quotaEmployee);// Jumlah hari dalam 1 minggu
		if($employee->department_id != 2){
			$count = $this->Dayoff_model->getQuotaDayoff($subdeptId, $officeShiftId, $date_drop)->num_rows();
			if($count >= $quotaEmployee){
				$Return['error'] = "Please select another date. <br> Maximum quota has reached in this date.";
			}else{
				$where = [
					'user_id'=>$user_id,
					'period'=>$period,
				];
				$employeeDayoffMoreThanDate = $this->db->get_where('dayoff', $where)->result();
				$currentDate = strtotime($date);
				$dropDate = strtotime($date_drop);
				$day = date("l", strtotime($date_drop));
				foreach($employeeDayoffMoreThanDate as $value){
					if($dropDate > $currentDate){
						$dateUpdate = date('Y-m-d', strtotime("next $day", strtotime($value->dayoff_date)));
					}else{
						$dateUpdate = date('Y-m-d', strtotime("last $day", strtotime($value->dayoff_date)));
					}
					$data = [
						'dayoff_date'=>$dateUpdate
					];
					$this->db->update('dayoff', $data, ['id'=>$value->id,'dayoff_date >='=>$date]);
				}
				$Return['result'] = "Dayoff changed.";
			}
		}else{
			if(date('D', strtotime($date_drop)) == 'Sat' OR date('D', strtotime($date_drop)) == 'Sun'){
				$Return['error'] = "All operasional department can't off on Saturday and Sunday";
			}else{
				$count = $this->Dayoff_model->getQuotaDayoff($subdeptId, $officeShiftId, $date_drop)->num_rows();
				if($count >= $quotaEmployee){
					$Return['error'] = "Please select another date. <br> Maximum quota has reached in this date.";
				}else{
					$where = [
						'user_id'=>$user_id,
						'period'=>$period,
					];
					$employeeDayoffMoreThanDate = $this->db->get_where('dayoff', $where)->result();
					$currentDate = strtotime($date);
					$dropDate = strtotime($date_drop);
					$day = date("l", strtotime($date_drop));
					foreach($employeeDayoffMoreThanDate as $value){
						if($dropDate > $currentDate){
							$dateUpdate = date('Y-m-d', strtotime("next $day", strtotime($value->dayoff_date)));
						}else{
							$dateUpdate = date('Y-m-d', strtotime("last $day", strtotime($value->dayoff_date)));
						}
						$data = [
							'dayoff_date'=>$dateUpdate
						];
						$this->db->update('dayoff', $data, ['id'=>$value->id,'dayoff_date >='=>$date]);
					}
					$Return['result'] = "Dayoff changed.";
				}
			}
		}
		$this->output($Return);
		exit();
	}

	// delete dayoff
	public function delete_dayoff()
	{
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->uri->segment(4);
		$idToDelete = $this->Dayoff_model->getDayoffId($id);
		if($idToDelete !== NULL) {
			$this->Dayoff_model->delete_record($id);
			$Return['result'] = 'Dayoff deleted!';
		} else {
			$Return['error'] = 'Dayoff ID not found!';
		}
		$this->output($Return);
	}
	// end 7381jazz

	////////////////////////////////////////////////////////////////////////
	// luffy 29 January 2020 06:11 pm
	public function pdf() {
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('1015',$role_resources_ids))
			redirect('admin/');
		$session = $this->session->userdata('username');
		if (empty($session)) 
			redirect('admin/');
		// create new PDF document
		// luffy 30 January 2020 01:32pm
		$paperSize = array('279.4','431.8'); //11' x 17' atau A3.
 		$pdf = new TCPDF('P', 'mm', $paperSize, true, 'UTF-8', false);
		
		// data variables
		$period = $this->uri->segment(5);
		$dayoffData = $this->Dayoff_model->getAllDayoffByPeriod($period);
		$creator=$this->Employees_model->getNamebyUserId(35);
		$author=$creator->employee_id.' - '.$creator->username;
		// action by aprovar
		$approval_action_by_1 = $dayoffData[0]->approval_action_by_1;
		$approval_action_by_2 = $dayoffData[0]->approval_action_by_2;
		$approval_action_by_3 = $dayoffData[0]->approval_action_by_3;
		// end action
		$startDatePeriodDb=$dayoffData[0]->dayoff_start_day;
		$endDatePeriodDb=$dayoffData[0]->dayoff_end_day;
		$startDatePeriod = date('d F Y',strtotime($startDatePeriodDb));
		$endDatePeriod = date('d F Y',strtotime($endDatePeriodDb));
		// luffy 31 January 2020 11:16 am
		// get day dan date within 1 week dayoff period.
		$fromDate = new DateTime($startDatePeriodDb);
		$fromDateWillBeModified = new DateTime($startDatePeriodDb);
		// luffy 31 January 2020 06:41 pm
		// get 7 days after $fromDate
		$oneWeekAfterFromDate = $fromDateWillBeModified->modify('+7 day');
		$oneWeekAfterFromDateYmd = $oneWeekAfterFromDate->format('Y-m-d');
		$toDate = new DateTime($oneWeekAfterFromDateYmd);
		$interval = DateInterval::createFromDateString('1 day');
		$oneWeekDayoff = new DatePeriod($fromDate, $interval, $toDate);
		$periodRange = $startDatePeriod.' - '.$endDatePeriod;
		$fileName = 'APG - Dayoff Schedule '.$periodRange;
		// jazz 7381 5 february 2020 17:52
		// get dayoff by period
		// approval 1
		$allApprovalData = $this->Dayoff_model->getApprovalByPeriod($period); // get approval by period
		$approval_1 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approval_1);
		$approval_action_1 = $allApprovalData->approval_action_by_1;
		$employee_id_1 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approved_by_1);
		if($approval_action_1 == 1){ // if approval 1 accept
			$signature1 = $employee_id_1->employee_id; // set signature by employee id
		}else{
			$signature1 = '';
		}
		// approval 2
		$approval_2 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approval_2); // get approval by period
		$approval_action_2 = $allApprovalData->approval_action_by_2;
		$employee_id_2 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approved_by_2);
		if($approval_action_2 == 1){  // if approval 2 accept
			$signature2 = $employee_id_2->employee_id; // set signature by employee id
		}else{
			$signature2 = '';
		}
		// approval 3
		$approval_3 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approval_3); // get approval by period
		$approval_action_3 = $allApprovalData->approval_action_by_3;
		$employee_id_3 = $this->Dayoff_model->getEmployeeByUserId($allApprovalData->approved_by_3);
		if($approval_action_3 == 1){ // if approval 3 accept
			$signature3 = $employee_id_3->employee_id; // set signature by employee id
		}else{
			$signature3 = '';
		}
		// set document information
		$pdf->SetCreator($author);
		$pdf->SetAuthor($author);
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		// set margins
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		$pdf->SetAuthor($author);

		$pdf->SetTitle($fileName);
		$pdf->SetSubject($fileName);
		$pdf->SetKeywords($fileName);
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		// Set font
		$pdf->SetFont('helvetica', '', 10, '', true);
		// Add a page
		// This method has several options, check the source code documentation for more information.
		// luffy 29 January 2020 07:42 pm | set paper size
		// $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
		$pdf->AddPage();
		// luffy 29 January 2020 08:15 pm
		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$htmlDayoffData = '
		<table border="1" cellspacing="0" cellpadding="5">
			<tr>
				<td>
					<h3 align="center">JADWAL LIBUR ASIA POWER GAMES</h3>
				</td>
			</tr>
		</table>
		<table border="1" cellspacing="0" cellpadding="3">
			<tr>
				<td rowspan="2" align="center" width="23px">
					<br /><br /> No
				</td>
				<td rowspan="2" align="center" width="90px">
					<br /><br /> Name
				</td>
				<td rowspan="2" align="center">
					<br /><br /> NIK
				</td>
				<td rowspan="2" align="center">
					<br /><br /> Site
				</td>
				<td rowspan="2" align="center">
					<br /><br /> Divisi
				</td>
				<td rowspan="2" align="center">
					<br /><br /> Shift
				</td>
				<td colspan="7" align="center">'.$startDatePeriod.' - '.$endDatePeriod.'</td>
			</tr>
			<tr>';
			foreach ($oneWeekDayoff as $dt) {
				$currentDay = $dt->format("l");
			// for($i = $fromDate; $i <= $toDate; $i->modify('+1 day')){
			// 	$currentDay = $i->format("l");
				switch($currentDay){
					case 'Sunday':
						$hari = "Minggu";
					break;
					case 'Monday':			
						$hari = "Senin";
					break;
					case 'Tuesday':
						$hari = "Selasa";
					break;
					case 'Wednesday':
						$hari = "Rabu";
					break;
					case 'Thursday':
						$hari = "Kamis";
					break;
					case 'Friday':
						$hari = "Jumat";
					break;
					case 'Saturday':
						$hari = "Sabtu";
					break;
					default:
						$hari = "-";		
					break;
				}
$htmlDayoffData .= '<td align="center">
					'.$hari.'
					</td>';
		}
$htmlDayoffData .= '</tr>';
		$no = 1;
		foreach($dayoffData as $singDayoffData){
			$dayOffDate = $singDayoffData->dayoff_date;
			$name=ucfirst(strtolower($singDayoffData->username));
			$nik=$singDayoffData->employee_id;
			$note=$singDayoffData->note;
			// Office Location
			if($singDayoffData->fingerprint_location==5)
				$site='Office 1';
			elseif($singDayoffData->fingerprint_location==6)
				$site='Office 2';
			else $site='-';
			// $site = $singDayoffData->location_name;
			// luffy | skipped who has no fingerprint in office location.
			if($site=='-') continue;
			// Division
			if($singDayoffData->department_name=='Accounting' OR $singDayoffData->department_name=='Finance Analyst')
				$divisi='Acc';
			elseif($singDayoffData->department_name=='Auditor' OR $singDayoffData->department_name=='Research')
				$divisi='Auditor';
			elseif($singDayoffData->department_name=='CS & Sales')
				$divisi='CS & SL';
			elseif($singDayoffData->department_name=='Digital Marketing')
				$divisi='DM';
			elseif($singDayoffData->department_name=='CS & Deposit')
				$divisi='DP';
			elseif($singDayoffData->department_name== 'GA' OR $singDayoffData->department_name=='Recruitment/Personalia')
				$divisi='HRD';
			elseif($singDayoffData->department_name=='Sysadmin')
				$divisi='IT';
			elseif($singDayoffData->department_name=='Developer')
				$divisi='DV';
			elseif($singDayoffData->department_name=='Withdrawl')
				$divisi='WD';
			else $divisi='-';
			// get shift name.
			$shift=($singDayoffData->shift_name=='Morning Shift')?'Pagi':'Malam';
	$htmlDayoffData .='<tr>
				<td align="center">'.$no++.'</td>
				<td align="center">'.$name.'</td>
				<td align="center">'.$nik.'</td>
				<td align="center">'.$site.'</td>
				<td align="center">'.$divisi.'</td>
				<td align="center">'.$shift.'</td>';
				// for($i = $fromDate; $i <= $toDate; $i->modify('+1 day')){
				// 	$currentDate = $i->format("Y-m-d");
				foreach ($oneWeekDayoff as $cdt) {
					$currentDate = $cdt->format("Y-m-d");
					$currentDayOff = ($dayOffDate==$currentDate)?strtoupper($shift):'-';
					if($dayOffDate==$currentDate AND $currentDayOff=='PAGI')
						$bgColor='#ffff00';
					elseif($dayOffDate==$currentDate AND $currentDayOff=='MALAM')
						$bgColor='#ee82ee';
					else $bgColor='#ffffff';
				// for($i = $fromDate; $i <= $toDate; $i->modify('+1 day')){
					// $currentDate = $i->format("Y-m-d");
$htmlDayoffData .='
					<td align="center" bgcolor="'.$bgColor.'">'.$currentDayOff.'</td>';
				}
$htmlDayoffData .='	</tr>';
		}
	$htmlDayoffData .='	</table>';
	$htmlNote = '<br /><br />
		<table border="1" cellspacing="0" cellpadding="2">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<span color="#000000">
									Notes:
								</span>
							</td>
						</tr>
						<tr>
							<td height="20px">
								<span color="#0000ff">
								'.$note.'
								</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
	$htmlSignatures = '<br /><br />
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="30%"></td>
							<td width="5%"></td>
							<td width="30%">
								<table border="1" cellspacing="0" cellpadding="5">
									<tr>
										<td align="center">Approved</td>
									</tr>
									<tr>
										<td align="center">
											<br /><br />
											'.($approval_action_1 != 1 ? "" : '<img src="'.base_url('uploads/signatures/'.$signature1.'_ttd.png').'" height="40px">').'
											<br /><br />
											['.$approval_1->employee_id.' - '.strtoupper($approval_1->username).']
										</td>
									</img>
								</table>
							</td>
							<td width="5%"></td>
							<td width="30%"></td>
						</tr>
						<tr>
							<td colspan="5" height="10px"></td>
						</tr>
						<tr>
							<td width="30%">
								<table border="1" cellspacing="0" cellpadding="5">
									<tr>
										<td align="center">Approved</td>
									</tr>
									<tr>
										<td align="center">
											<br /><br />
											'.($approval_action_2 != 1 ? "" : '<img src="'.base_url('uploads/signatures/'.$signature2.'_ttd.png').'" height="40px">').'
											<br /><br />
											['.$approval_2->employee_id.' - '.strtoupper($approval_2->username).']
										</td>
									</tr>
								</table>
							</td>
							<td width="5%"></td>
							<td width="30%"></td>
							<td width="5%"></td>
							<td width="30%">
								<table border="1" cellspacing="0" cellpadding="5">
									<tr>
										<td align="center">Approved</td>
									</tr>
									<tr>
										<td align="center">
											<br /><br />
											'.($approval_action_3 != 1 ? "" : '<img src="'.base_url('uploads/signatures/'.$signature3.'_ttd.png').'" height="40px">').'
											<br /><br />
											['.$approval_3->employee_id.' - '.strtoupper($approval_3->username).']
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';
		$pdf->writeHTML($htmlDayoffData.$htmlNote.$htmlSignatures, true, false, true, false, '');
		// Close and output PDF document
		//Close and output PDF document
		// luffy 28 nov 2019
		ob_start();
		$pdf->Output($fileName.'.pdf', 'I');
		ob_end_flush();
		exit;
	 }
}
