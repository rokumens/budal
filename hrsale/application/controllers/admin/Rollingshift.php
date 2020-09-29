<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rollingshift extends MY_Controller {

	public function __construct() {
  	parent::__construct();
		//load the login model
		$this->load->model('Company_model');
		$this->load->model('Xin_model');
		$this->load->model('Timesheet_model');
		$this->load->model('Department_model');
		$this->load->model('Rollingshift_model');
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
		$data['title'] = 'Rolling Shift | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Rolling Shift';
		$data['path_url'] = 'rollingshift';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1024',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/rollingshift/rollingshift_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	// list view index
	public function rollingshift_list()
	{
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/rollingshift/rollingshift_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$rollingshift = $this->Rollingshift_model->get_rollingshifts();
		$data = array();
		foreach($rollingshift->result() as $r) {
			// if(in_array('308',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->period . '"><span class="fa fa-trash"></span></button></span>';
			// } else {
			// 	$delete = '';
			// }
			if(in_array('1026',$role_resources_ids)) { // view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/rollingshift/detail/'.$r->period.'/'.$r->rollingshift_date.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			}else{
				$view="";
			}
			if(in_array('1027',$role_resources_ids)) { // download
				$download = '<a href="' . site_url() . 'admin/rollingshift/pdf/p/' . $r->period . '" class="btn btn-social-icon mb-1 btn-outline-github" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Rolling Shift">
                <i class="fa fa-file-pdf-o"></i>
              </a> ';
			}else{
				$download="";
			}
			// luffy end
			$u_created = $this->Xin_model->read_user_info($r->created_by);
			if(!is_null($u_created)){
				$f_name = $u_created[0]->employee_id.' - '.$u_created[0]->username;
			} else {
				$f_name = '--';
			}
			$combhr = $view.$download;
			$data[] = array(
				$combhr,
				date('d-F-Y', strtotime($r->rollingshift_start_day)),
				date('d-F-Y', strtotime($r->rollingshift_end_day)),
				$f_name
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $rollingshift->num_rows(),
			"recordsFiltered" => $rollingshift->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
	public function add_rollingshift()
	{
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('add_type')=='add_rollingshift') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session = $this->session->userdata('username');
			// luffy 28 January 2020 09:47 pm | get the latest period
			$post = $this->input->post(NULL, TRUE);
			$dateFrom = $post['dateFrom'];// date from start
			$dateTo = $post['dateTo'];// date to end
			// luffy 9 Feb 2020 12:56 pm
			$lastPeriod = $this->Rollingshift_model->getMaxPeriod()->period;
			$currentPeriod = $lastPeriod + 1;
			$dataInsert = [];
			if(empty($dateFrom) OR empty($dateTo)){// if 'date from' and 'date to' is empty show error
				$Return['error'] = 'Please choose date.';
			}
			if($Return['error'] != ''){
				$this->output($Return);
				exit();
			}
			$rollingShift = $this->Rollingshift_model->getRollingshiftBySubdeptId(NULL)->result();
			$period = new DatePeriod(//get interval
				new DateTime($dateFrom),
				new DateInterval('P1D'),
				new DateTime(date('Y-m-d', strtotime($dateTo . ' + 1 day')))
			);
			if(empty($dateFrom)){
				$Return['error'] = 'Please choose date.';
				$this->output($Return);
				exit();
			}
			$getRollingShift = $this->Rollingshift_model->getRollingshiftByDate($dateFrom);
			if(!empty($getRollingShift->row())){
				$Return['error'] = 'Please select another date. <br> Rolling shift on this date has been created previously.';
			}else{
				foreach ($period as $day) {
					foreach($rollingShift as $value){
						$checkLeave = $this->Rollingshift_model->getRollingByPeriodId($lastPeriod, $value->employee_id)->row();
						$data = [
							'user_id'=>$value->user_id,
							'period'=>	$currentPeriod,
							'employee_id'=>$value->employee_id,
							'sub_department_id'=>$value->sub_department_id,
							'office_shift_id'=>$value->office_shift_id,
							'rollingshift_date'=>$day->format('Y-m-d'),
							'rollingshift_start_day'=>$dateFrom,
							'rollingshift_end_day'=>$dateTo,
							'created_at'=>date('Y-m-d'),
							'created_by'=>$this->session->userdata('user_id')['user_id'],
							'is_leave_at'=>NULL
						];
						if(!empty($checkLeave)){
							if($checkLeave->is_leave_at != NULL){
								$data['is_leave_at'] = $checkLeave->is_leave_at;
							}
						}
						$dataInsert[] = $data;
					}
				}
				// luffy 9 Feb 2020 12:57pm | Paramaters for notif to slack.
				$rollingShiftStartDayParam=$dateFrom;
				$rollingShiftStartDay=date('d M Y', strtotime($dateFrom));
				$rollingShiftEndDay=date('d M Y', strtotime($dateTo));
				$userIdSession=$this->session->userdata('user_id')['user_id'];
				$employeeData=$this->Employees_model->read_employee_information($userIdSession);
				$createdBy=$employeeData[0]->employee_id.' - '.$employeeData[0]->username;
				$result = $this->Rollingshift_model->add($dataInsert);
				if($result==TRUE) {
					$Return['result'] = 'Rolling shift created.';
					// luffy 9 Feb 2020 12:31 pm | send notif to slack
					$this->sendCreatedRollingShiftToChannel($currentPeriod, $rollingShiftStartDayParam, $rollingShiftStartDay, $rollingShiftEndDay, $createdBy);
				}else{
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
			}
			$this->output($Return);
			exit;
		}
	}

	// luffy 6 Feb 2020 - 06:14 pm
	// send channel notif to slack after Dayoff created & need for approval.
	function sendCreatedRollingShiftToChannel($currentPeriod, $rollingShiftStartDayParam, $rollingShiftStartDay, $rollingShiftEndDay, $createdBy){
		#9-it-support-kanon-a2
		$callSlack = curl_init('https://hooks.slack.com/services/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');
		#luffy
		// $callSlack = curl_init('https://hooks.slack.com/services/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');
		$rollingShiftStartDayParam = date('Y-m-d', strtotime($rollingShiftStartDay));
		$redirectTo = site_url() . 'admin/rollingshift/detail/' . $currentPeriod . '/' . $rollingShiftStartDayParam;
		$mentionChannel='<!channel>';
		// $mentionHere='<!here>';
		$array = array(
			'username' => 'APG Bot',
			'text' => "New rolling shift schedule was just created by $createdBy. $mentionChannel",
			'mrkdwn' => true,
			'attachments' => array(
				array(
					'color' => '#ff4757',
					'title' => "Rolling shift period: $rollingShiftStartDay - $rollingShiftEndDay",
					'fallback' => 'fallback',
					'pretext' => '',
					'author_name' => ">> Go <$redirectTo|here> for detail.",
					'author_link' => '#',
					'author_icon' => '',
					'text' => '',
					'fields' => array(
						array(
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

	// detail rolling shift by period
	public function detail($period = NULL) {
		$session = $this->session->userdata('username');
		if (empty($session)) 
			redirect('admin/');
		if($period == NULL)
			redirect('admin/rollingshift');
		// luffy 10 Feb 2020 08:26 pm
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if (!in_array('1026', $role_resources_ids)) 
			redirect('admin/');
		$data['title'] = 'Rolling Shift Detail | ' . $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Rolling Shift Detail';
		$data['path_url'] = 'rollingshift';
		$data['all_subdepartments'] = $this->Rollingshift_model->all_subdepartments();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$checkDayoff = $this->Rollingshift_model->checkDayoffInRollingshift($period)->result();
		if(!empty($checkDayoff)){
			$data['rollingshift'] = $this->Rollingshift_model->getAllRollingshiftPeriodHaveDayoff($period)->result_array();
		}else{
			$data['rollingshift'] = $this->Rollingshift_model->getAllRollingshiftPeriodNoDayoff($period)->result_array();
		}
		$data['checkDayoff'] = $checkDayoff;
		$allShift = $this->Rollingshift_model->getAllShift()->result();
		foreach($allShift as $key => $value){
			$shift[$value->office_shift_id] = $value->shift_name;
		}
		$allOprasional = $this->Rollingshift_model->getAllSubdepartmentOprasional()->result();
		foreach($allOprasional as $key => $value){
			$oprasional[$value->sub_department_id] = $value->department_name;
		}
		$data['shift'] = $shift;
		$data['oprasional'] = $oprasional;
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// if (in_array('95', $role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/rollingshift/detail", $data, true);
			$this->load->view('admin/layout/layout_main', $data); //page load
		// } else {
		// 	redirect('admin/dashboard');
		// }
	}
	// ajax detail rolling shift by employee
	public function ajaxDetail()
	{
		$user_id = $this->input->get('user_id');
		$id = $this->input->get('id');
		$data = $this->Rollingshift_model->getEmployeeRollingshiftById($id)->row();
		echo json_encode($data);
	}
	public function rollingshiftAjax()//subdept
	{
		$id = $this->uri->segment(4);
		$data = array('subdept_id' => $id);
		$data['date'] = $this->uri->segment(4);
		$data['curr_subdept_id'] = $this->uri->segment(5);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/rollingshift/get_rollingshift_ajax", $data);
		else redirect('admin/');
	}
	public function ajaxrollingshift()//default
	{
		$id = $this->uri->segment(4);
		$session = $this->session->userdata('username');
		$data['date'] = $this->uri->segment(4);
		$data['curr_subdept_id'] = $this->uri->segment(5);
		if(!empty($session))
			$this->load->view("admin/rollingshift/get_rollingshift_ajax", $data);
		else redirect('admin/');
	}
	// edit rolling shift by id
	public function edit_rollingshift()
	{
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$session = $this->session->userdata('username');
		if (empty($session)) 
			redirect('admin/');
		$post = $this->input->post(NULL, TRUE);
		$dayoff = $this->Rollingshift_model->getRollingshiftByPeriod($post['period'], $post['employee_id'], $post['date'])->row();
		if($dayoff->is_leave_at != NULL){ // where status already leave
			if($post['anual_leave'] == 1){ // post leave
				$data['is_leave_at'] = $post['anual_leave_date'];
				$where = [
					'employee_id'=>$post['employee_id'],
					'anual_leave_date'=>$post['anual_leave_date']
				];
				if($this->Rollingshift_model->updateAnualLeave($where, $data)){
					$Return['result'] = "Rolling shift updated.";
				}else{
					$Return['error'] = 'No changed.';
				}
			}else{ // post not leave
				$dataLeave['is_leave_at'] = NULL;
				$where = [
					'employee_id'=>$post['employee_id'],
					'anual_leave_date'=>$post['anual_leave_date']
				];
				if($this->Rollingshift_model->updateAnualLeave($where, $dataLeave)){
					$Return['result'] = "Rolling shift updated.";
				}else{
					$Return['error'] = 'No changed.';
				}
			}
		}else{ // where status not leave
			if($post['anual_leave'] == 1){ // post leave
				$data['is_leave_at'] = $post['anual_leave_date'];
				$where = [
					'employee_id'=>$post['employee_id'],
					'anual_leave_date'=>$post['anual_leave_date']
				];
				if($this->Rollingshift_model->updateAnualLeave($where, $data)){
					$Return['result'] = "Rolling shift updated.";
				}else{
					$Return['error'] = 'No changed.';
				}
			}else{ // post not leave
				$data = [
					'office_shift_id'=>$post['shift'],
					'sub_department_id'=>$post['divisi'],
				];
				if($this->Rollingshift_model->update($post['id'], $data)){
					$Return['result'] = "Rolling shift updated.";
				}else{
					$Return['error'] = 'No changed.';
				}
			}
		}
		$this->output($Return);
		exit;
	}
	public function truncate()
	{
		$this->db->truncate('rollingshift');
		redirect('admin/rollingshift');
	}
	////////////////////////////////////////////////////////////////////////
	// luffy 1 February 2020 06:11 pm
	public function pdf() {
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('1027',$role_resources_ids))
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
		$rollingshiftData = $this->Rollingshift_model->getAllRollingshiftByPeriod($period);
		$creator=$this->Employees_model->getNamebyUserId(35);
	  $author=$creator->employee_id.' - '.$creator->username;
		$startDatePeriodDb=$rollingshiftData[0]->rollingshift_start_day;
		$endDatePeriodDb=$rollingshiftData[0]->rollingshift_end_day;
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
		$fileName = 'APG - Rolling Shift Schedule '.$periodRange;
		$arrRollingShiftGroupByPeriod = $this->Rollingshift_model->AllRolingshiftGroupByPeriod($period);
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

		$htmlRollingshiftData = '
		<table border="1" cellspacing="0" cellpadding="3">
			<tr>
				<td>
					<h3 align="center">JADWAL OPERASIONAL</h3>
				</td>
			</tr>
		</table>
		<table border="1" cellspacing="0" cellpadding="3">
			<tr align="center">
				<th>TANGGAL</th>
				<th>Shift</th>
				<th>DEPO</th>
				<th>WD</th>
				<th>CS</th>
				<th>LAIN-LAIN</th>
				<th>DAY OFF</th>
			</tr>';
			foreach ($oneWeekDayoff as $dt) {
				$tanggal = $dt->format("d F Y");
				$currentDateColumn = $dt->format("Y-m-d");
			// foreach($arrRollingShiftGroupByPeriod as $dt) {
			// 	$tanggal = date('d F Y',strtotime($dt->rollingshift_date));
			// 	$currentDateColumn = $dt->rollingshift_date;
			//////----- Shift PAGI -----//////
			// DEPO Pagi
			$arrEmployeeDepoPagi = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 1, 32);
			$employeeDepoPagi = array();
			$empDepoPagi='-'; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeDepoPagi)){
				foreach($arrEmployeeDepoPagi as $singEmployeeDepoPagi) {
					$dateAsDepoPagi = $singEmployeeDepoPagi->rollingshift_date;
					$employeeDepoPagi[] = $singEmployeeDepoPagi->username;
				}
			}
			($currentDateColumn==$dateAsDepoPagi)?$empDepoPagi=implode(', ', $employeeDepoPagi):$empDepoPagi='-';
			// WD Pagi
			$arrEmployeeWDPagi = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 1, 13);
			$employeeWDPagi = array();
			$empWDPagi=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeWDPagi)){
				foreach($arrEmployeeWDPagi as $singEmployeeWDPagi) {
					$dateAsWDPagi=$singEmployeeWDPagi->rollingshift_date;
					$employeeWDPagi[] = $singEmployeeWDPagi->username;
				}
			}
			($currentDateColumn==$dateAsWDPagi)?$empWDPagi=implode(', ', $employeeWDPagi):$empWDPagi='-';
			// CS Pagi
			$arrEmployeeCSPagi = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 1, 21);
			$employeeCSPagi = array();
			$empCSPagi=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeCSPagi)){
				foreach($arrEmployeeCSPagi as $singEmployeeCSPagi) {
					$dateAsCSPagi=$singEmployeeCSPagi->rollingshift_date;
					$employeeCSPagi[] = $singEmployeeCSPagi->username;
				}
				($currentDateColumn==$dateAsCSPagi)?$empCSPagi=implode(', ', $employeeCSPagi):$empCSPagi='-';
			}
			// Lain2 Pagi
			$arrEmployeeOtherPagi = $this->Rollingshift_model->getNameRollingshiftByPeriodDateOther($period, $currentDateColumn, 1);
			$employeeOtherPagi = array();
			$empOtherPagi=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeOtherPagi)){
				foreach($arrEmployeeOtherPagi as $singEmployeeOtherPagi) {
					$dateAsOtherPagi=$singEmployeeOtherPagi->rollingshift_date;
					$employeeOtherPagi[] = $singEmployeeOtherPagi->username;
				}
				($currentDateColumn==$dateAsOtherPagi)?$empOtherPagi=implode(', ', $employeeOtherPagi):$empOtherPagi='-';
			}
			// Dayoff Pagi
			$arrEmployeeDayoffPagi = $this->Rollingshift_model->getNameRollingshiftByPeriodDateDayoff($period, $currentDateColumn, 1);
			// d($arrEmployeeDayoffPagi);
			$employeeDayoffPagi = array();
			$empDayoffPagi=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeDayoffPagi)){
				foreach($arrEmployeeDayoffPagi->result() as $singEmployeeDayoffPagi) {
					$dateAsDayoffPagi=$singEmployeeDayoffPagi->rollingshift_date;
					$employeeDayoffPagi[] = $singEmployeeDayoffPagi->username;
				}
				($currentDateColumn==$dateAsDayoffPagi)?$empDayoffPagi=implode(', ', $employeeDayoffPagi):$empDayoffPagi='-';
			}
			$htmlRollingshiftData .= '
			<tr align="center">
				<td rowspan="2">
					<br /><br /><br />
					'.$tanggal.'
					<br /><br /> 
				</td>
				<td>PAGI</td>
				<td>'.$empDepoPagi.'</td>
				<td>'.$empWDPagi.'</td>
				<td>'.$empCSPagi.'</td>
				<td>'.$empOtherPagi.'</td>
				<td>'.$empDayoffPagi.'</td>
			</tr>';
			//////----- Shift MALAM -----//////
			// DEPO Malam
			$arrEmployeeDepoMalam = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 2, 32);
			$employeeDepoMalam = array();
			$empDepoMalam='';// prevant error
			// jazz 7381 6 february 2020 21:13
			// add check not empty to prevant error
			if(!empty($arrEmployeeDepoMalam)){
				foreach($arrEmployeeDepoMalam as $singEmployeeDepoMalam) {
					$dateAsWDMalam=$singEmployeeDepoMalam->rollingshift_date;
					$employeeDepoMalam[] = $singEmployeeDepoMalam->username;
				}
				($currentDateColumn==$dateAsWDMalam)?$empDepoMalam=implode(', ', $employeeDepoMalam):$empDepoMalam='-';
			}
			// WD Malam
			$arrEmployeeWDMalam = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 2, 13);
			$employeeWDMalam = array();
			$empWDMalam=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeWDMalam)){
				foreach($arrEmployeeWDMalam as $singEmployeeWDMalam) {
					$dateAsWDMalam = $singEmployeeWDMalam->rollingshift_date;
					$employeeWDMalam[] = $singEmployeeWDMalam->username;
				}
				($currentDateColumn==$dateAsWDMalam)?$empWDMalam=implode(', ', $employeeWDMalam):$empWDMalam='-';
			}
			// CS Malam
			$arrEmployeeCSMalam = $this->Rollingshift_model->getNameRollingshiftByPeriodDateSubdept($period, $currentDateColumn, 2, 21);
			$employeeCSMalam = array();
			// add check not empty to prevant error
			if(!empty($arrEmployeeCSMalam)){
				foreach($arrEmployeeCSMalam as $singEmployeeCSMalam) {
					$dateAsCSMalam=$singEmployeeCSMalam->rollingshift_date;
					$employeeCSMalam[] = $singEmployeeCSMalam->username;
				}
				($currentDateColumn==$dateAsCSMalam)?$empCSMalam=implode(', ', $employeeCSMalam):$empCSMalam='-';
			}
			// Lain2 Malam
			$arrEmployeeOtherMalam = $this->Rollingshift_model->getNameRollingshiftByPeriodDateOther($period, $currentDateColumn, 2);
			$employeeOtherMalam = array();
			$empOtherMalam=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeOtherMalam)){
				foreach($arrEmployeeOtherMalam as $singEmployeeOtherMalam) {
					$dateAsOtherMalam=$singEmployeeOtherMalam->rollingshift_date;
					$employeeOtherMalam[] = $singEmployeeOtherMalam->username;
				}
				($currentDateColumn==$dateAsOtherMalam)?$empOtherMalam=implode(', ', $employeeOtherMalam):$empOtherMalam='-';
			}
			// Dayoff Malam
			$arrEmployeeDayoffMalam = $this->Rollingshift_model->getNameRollingshiftByPeriodDateDayoff($period, $currentDateColumn, 2);
			$employeeDayoffMalam = array();
			$empDayoffMalam=''; // prevant error
			// add check not empty to prevant error
			if(!empty($arrEmployeeDayoffMalam)){
				foreach($arrEmployeeDayoffMalam->result() as $singEmployeeDayoffMalam) {
					$dateAsDayoffMalam=$singEmployeeDayoffMalam->rollingshift_date;
					$employeeDayoffMalam[] = $singEmployeeDayoffMalam->username;
				}
				($currentDateColumn==$dateAsDayoffMalam)?$empDayoffMalam=implode(', ', $employeeDayoffMalam):$empDayoffMalam='-';
			}
			$htmlRollingshiftData .= '
			<tr align="center">
				<td>MALAM</td>
				<td>'.$empDepoMalam.'</td>
				<td>'.$empWDMalam.'</td>
				<td>'.$empCSMalam.'</td>
				<td>'.$empOtherMalam.'</td>
				<td>'.$empDayoffMalam.'</td>
			</tr>';
		}
		$htmlRollingshiftData .= '
		</table>';
		$htmlDayoff = '
			<table border="1" cellspacing="0" cellpadding="3">
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
				$htmlDayoff .= '<td align="center">
					'.$hari.'
					</td>';
		}
		$htmlDayoff .= '</tr>';
		$no = 1;
		foreach($rollingshiftData as $singRollingshiftData){
			$dayOffDate = $singRollingshiftData->rollingshift_date;
			$name=ucfirst(strtolower($singRollingshiftData->username));
			$nik=$singRollingshiftData->employee_id;
			// Office Location
			if($singRollingshiftData->fingerprint_location=='KPS Office 1')
				$site='Office 1';
			elseif($singRollingshiftData->fingerprint_location=='KPS Office 2')
				$site='Office 2';
			else $site='-';
			// luffy | skipped who has no fingerprint in office location.
			if($site=='-') continue;
			// Division
			if($singRollingshiftData->department_name=='Accounting' OR $singRollingshiftData->department_name=='Finance Analyst')
				$divisi='Acc';
			elseif($singRollingshiftData->department_name=='Auditor' OR $singRollingshiftData->department_name=='Research')
				$divisi='Auditor';
			elseif($singRollingshiftData->department_name=='CS & Sales')
				$divisi='CS & SL';
			elseif($singRollingshiftData->department_name=='Digital Marketing')
				$divisi='DM';
			elseif($singRollingshiftData->department_name=='CS & Deposit')
				$divisi='DP';
			elseif($singRollingshiftData->department_name== 'GA' OR $singRollingshiftData->department_name=='Recruitment/Personalia')
				$divisi='HRD';
			elseif($singRollingshiftData->department_name=='Sysadmin')
				$divisi='IT';
			elseif($singRollingshiftData->department_name=='Developer')
				$divisi='DV';
			elseif($singRollingshiftData->department_name=='Withdrawl')
				$divisi='WD';
			else $divisi='-';
			// get shift name.
			$shift=($singRollingshiftData->shift_name=='Morning Shift')?'Pagi':'Malam';
			$htmlDayoff .='<tr>
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
					$htmlDayoff .='
					<td align="center" bgcolor="'.$bgColor.'">'.$currentDayOff.'</td>';
				}
			$htmlDayoff .='	</tr>';
		}
		$htmlDayoff .='	</table>';
		$pdf->writeHTML($htmlRollingshiftData, true, false, true, false, '');
		// Close and output PDF document
		// luffy 28 nov 2019
		ob_start();
		$pdf->Output($fileName.'.pdf', 'I');
		ob_end_flush();
		exit;
	 }
}
