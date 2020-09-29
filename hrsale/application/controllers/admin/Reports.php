<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller
{

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
	  $this->load->model('Payroll_model');
	  $this->load->model('Reports_model');
	  $this->load->model('Timesheet_model');
	  $this->load->model('Training_model');
	  $this->load->model('Trainers_model');
	  $this->load->model("Project_model");
	  $this->load->model("Roles_model");
	  $this->load->model("Employees_model");
	  $this->load->model("Designation_model");
		$this->load->model("Fingerprint_model");
		// $this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
  }

	// reports > employee attendance
	public function employee_attendance() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_attendance_employee').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_attendance_employee');
		$data['path_url'] = 'reports_employee_attendance';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('112',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_attendance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// luffy
	// date wise attendance list > timesheet
	public function employee_date_wise_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session))
			$this->load->view("admin/reports/employee_attendance", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$employee_id = $this->input->get("user_id");
		//$employee = $this->Xin_model->read_user_info($employee_id);
		$employee = $this->Xin_model->read_user_info($employee_id);
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' );
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$attendance_arr = array();
		$data = array();
		// luffy
		foreach($date_range as $date) {
			$attendance_date =  $date->format("Y-m-d");
			// foreach($employee->result() as $r) {
			// user full name
			//	$full_name = $r->first_name.' '.$r->last_name;
			// get office shift for employee
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			// office shift
			$office_shift = $this->Timesheet_model->read_office_shift_information($employee[0]->office_shift_id);
			// get clock in/clock out of each employee
			if($day == 'Monday') {
				if($office_shift[0]->monday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->monday_in_time;
					$out_time = $office_shift[0]->monday_out_time;
				}
			}elseif($day == 'Tuesday') {
				if($office_shift[0]->tuesday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->tuesday_in_time;
					$out_time = $office_shift[0]->tuesday_out_time;
				}
			}elseif($day == 'Wednesday') {
				if($office_shift[0]->wednesday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->wednesday_in_time;
					$out_time = $office_shift[0]->wednesday_out_time;
				}
			}elseif($day == 'Thursday') {
				if($office_shift[0]->thursday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->thursday_in_time;
					$out_time = $office_shift[0]->thursday_out_time;
				}
			}elseif($day == 'Friday') {
				if($office_shift[0]->friday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->friday_in_time;
					$out_time = $office_shift[0]->friday_out_time;
				}
			}elseif($day == 'Saturday') {
				if($office_shift[0]->saturday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->saturday_in_time;
					$out_time = $office_shift[0]->saturday_out_time;
				}
			}elseif($day == 'Sunday') {
				if($office_shift[0]->sunday_in_time==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift[0]->sunday_in_time;
					$out_time = $office_shift[0]->sunday_out_time;
				}
			}
			// check if clock-in for date
			$attendance_status = '';
			$check = $this->Timesheet_model->attendance_first_in_check($employee[0]->employee_id,$attendance_date);
			if($check->num_rows() > 0){
				// check clock in time
				// luffy
				// $attendance = $this->Timesheet_model->attendance_first_in($employee[0]->user_id,$attendance_date);
				$attendance = $this->Timesheet_model->attendance_first_in($employee[0]->employee_id,$attendance_date);
				// clock in
				$clock_in = new DateTime($attendance[0]->clock_in);
				// $clock_in2 = $clock_in->format('h:i a');
				$clock_in2 = $clock_in->format('H:i');	// luffy
				$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_in_ip_address.'" data-uid="'.$employee[0]->employee_id.'" data-att_type="clock_in" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkin_ip').'</button>';
				$office_time =  new DateTime($in_time.' '.$attendance_date);
				//time diff > total time late
				$office_time_new = strtotime($in_time.' '.$attendance_date);
				$clock_in_time_new = strtotime($attendance[0]->clock_in);
				if($clock_in_time_new <= $office_time_new) {
					$total_time_l = '00:00';
				} else {
					$interval_late = $clock_in->diff($office_time);
					$hours_l   = $interval_late->format('%h');
					$minutes_l = $interval_late->format('%i');
					$total_time_l = $hours_l ."h ".$minutes_l."m";
				}
				// total hours work/ed
				$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($employee[0]->employee_id,$attendance_date);
				$hrs_old_int1 = 0;
				$Total = '';
				$Trest = '';
				$hrs_old_seconds = 0;
				$hrs_old_seconds_rs = 0;
				$total_time_rs = '';
				$hrs_old_int_res1 = 0;
				foreach ($total_hrs->result() as $hour_work){
					// total work
					$timee = $hour_work->total_work.':00';
					$str_time =$timee;
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					$hrs_old_int1 += $hrs_old_seconds;
					$Total = gmdate("H:i", $hrs_old_int1);
				}
				if($Total=='')
					$total_work = '00:00';
				else $total_work = $Total;
				// total rest >
				$total_rest = $this->Timesheet_model->total_rest_attendance($employee[0]->employee_id,$attendance_date);
				foreach ($total_rest->result() as $rest){
					// total rest
					$str_time_rs = $rest->total_rest.':00';
					//$str_time_rs =$timee_rs;
					$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
					sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
					$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
					$hrs_old_int_res1 += $hrs_old_seconds_rs;
					$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
				}
				// check attendance status
				$status = $attendance[0]->attendance_status;
				if($total_time_rs=='') {
					$Trest = '00:00';
				} else {
					$Trest = $total_time_rs;
				}
			} else {
				$clock_in2 = '-';
				$total_time_l = '00:00';
				$total_work = '00:00';
				$Trest = '00:00';
				$clkInIp = $clock_in2;
				// get holiday/leave or absent
				/* attendance status */
				// get holiday
				$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
				$holiday_arr = array();
				if($h_date_chck->num_rows() == 1){
					$h_date = $this->Timesheet_model->holiday_date($attendance_date);
					$begin = new DateTime( $h_date[0]->start_date );
					$end = new DateTime( $h_date[0]->end_date);
					$end = $end->modify( '+1 day' );
					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);
					foreach($daterange as $date){
						$holiday_arr[] =  $date->format("Y-m-d");
					}
				} else {
					$holiday_arr[] = '99-99-99';
				}
				// get leave/employee
				$leave_date_chck = $this->Timesheet_model->leave_date_check($employee[0]->employee_id,$attendance_date);
				$leave_arr = array();
				if($leave_date_chck->num_rows() == 1){
					$leave_date = $this->Timesheet_model->leave_date($employee[0]->employee_id,$attendance_date);
					$begin1 = new DateTime( $leave_date[0]->from_date );
					$end1 = new DateTime( $leave_date[0]->to_date);
					$end1 = $end1->modify( '+1 day' );
					$interval1 = new DateInterval('P1D');
					$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
					foreach($daterange1 as $date1){
						$leave_arr[] =  $date1->format("Y-m-d");
					}
				} else {
					$leave_arr[] = '99-99-99';
				}
				if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
					$status = $this->lang->line('xin_holiday');
				}elseif($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
					$status = $this->lang->line('xin_holiday');
				}elseif(in_array($attendance_date,$holiday_arr)) { // holiday
					$status = $this->lang->line('xin_holiday');
				}elseif(in_array($attendance_date,$leave_arr)) { // on leave
					$status = $this->lang->line('xin_on_leave');
				}
				else {
					$status = $this->lang->line('xin_absent');
				}
			}
			// check if clock-out for date
			$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->employee_id,$attendance_date);
			if($check_out->num_rows() == 1){
				/* early time */
				$early_time =  new DateTime($out_time.' '.$attendance_date);
				// check clock in time
				$first_out = $this->Timesheet_model->attendance_first_out($employee[0]->employee_id,$attendance_date);
				// clock out
				$clock_out = new DateTime($first_out[0]->clock_out);
				if ($first_out[0]->clock_out!='') {
					// $clock_out2 = $clock_out->format('h:i a');
					$clock_out2 = $clock_out->format('H:i');	// luffy
					$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_out_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkout_ip').'</button>';
					// early leaving
					$early_new_time = strtotime($out_time.' '.$attendance_date);
					$clock_out_time_new = strtotime($first_out[0]->clock_out);
					if($early_new_time <= $clock_out_time_new) {
						$total_time_e = '00:00';
					} else {
						$interval_lateo = $clock_out->diff($early_time);
						$hours_e   = $interval_lateo->format('%h');
						$minutes_e = $interval_lateo->format('%i');
						$total_time_e = $hours_e ."h ".$minutes_e."m";
					}
					/* over time */
					$over_time =  new DateTime($out_time.' '.$attendance_date);
					$overtime2 = $over_time->format('h:i a');
					// over time
					$over_time_new = strtotime($out_time.' '.$attendance_date);
					$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
					if($clock_out_time_new1 <= $over_time_new) {
						$overtime2 = '00:00';
					} else {
						$interval_lateov = $clock_out->diff($over_time);
						$hours_ov   = $interval_lateov->format('%h');
						$minutes_ov = $interval_lateov->format('%i');
						$overtime2 = $hours_ov ."h ".$minutes_ov."m";
					}
				} else {
					$clock_out2 =  '-';
					$total_time_e = '00:00';
					$overtime2 = '00:00';
					$clkOutIp = $clock_out2;
				}
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$overtime2 = '00:00';
				$clkOutIp = $clock_out2;
			}
			// luffy
			$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->employee_id,$attendance_date);
			if($check_out->num_rows() == 1){
				// check clock in time
				$first_break = $this->Timesheet_model->attendance_first_out($employee[0]->employee_id,$attendance_date);
				// break in out
				$break_out = new DateTime($first_break[0]->break_out);
				$break_in = new DateTime($first_break[0]->break_in);
				if ($first_break[0]->break_out!='') {
					$break_out2 = $break_out->format('H:i');	// luffy
				} else {
					$break_out2 =  '-';
				}
				if ($first_break[0]->break_in!='') {
					$break_in2 = $break_in->format('H:i');	// luffy
				} else {
					$break_in2 =  '-';
				}
			} else {
				$break_out2 =  '-';
				$break_in2 =  '-';
			}
			// user full name
				$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
				// get company
				$company = $this->Xin_model->read_company_info($employee[0]->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';
				}
				// attendance date
				$tdate = $this->Xin_model->set_date_format($attendance_date);
				/*if($user_info[0]->user_role_id==1){
					$fclckIn = $clkInIp;
					$fclckOut = $clkOutIp;
				} else {
					$fclckIn = $clock_in2;
					$fclckOut = $clock_out2;
				}*/
				// attendance date
				//$tdate = $this->Xin_model->set_date_format($attendance_date);

				// // luffy
				// $checkaja = $this->Timesheet_model->attendance_first_out($employee[0]->employee_id,$attendance_date);
				// switch(true){
				// 	 case empty($checkaja[0]->clock_out):
				// 		 $totalWorkzz = '--';break;
				// 	 default:
				// 		 $startWork = new DateTime($clock_in2);
				// 		 $endWork = new DateTime($clock_out2);
				// 		 $intrWork = $startWork->diff($endWork);
				// 		 // $totalWork = $intrWork->format('%y years %m months %a days %h hours %i minutes %s seconds');
				// 		 $totalWork = $intrWork->format('%h hours %i minutes');
				// 		 $totalWorkzz = $totalWork;
				// 		 break;
				// }
				// for late
				$clockIn = $attendance[0]->clock_in;
				if($clockIn>="21:30:00"){	//night shift
					$startWorkingPagi = new DateTime("21:30:00");
					$fingerMasukPagi = new DateTime($clockIn);
					if($clockIn>="21:31:00"){
						$intrWork = $startWorkingPagi->diff($fingerMasukPagi);
						$late = $intrWork->format('%h hours %i minutes');
					}else{$late='-';}
				}else{	//monrning shift
					$startWorking = new DateTime("09:30:00");
					$fingerMasuk = new DateTime($clockIn);
					if(($clockIn>="09:31:00")&&($clockIn<="19:00:00")){
						$intrWork = $startWorking->diff($fingerMasuk);
						$late = $intrWork->format('%h hours %i minutes');
					}else{$late='-';}
				}
				$data[] = array(
					$attendance[0]->employee_id,
					$full_name,
					$comp_name,
					// $status,
					$tdate,
					$clock_in2,
					$clock_out2,
					$break_out2,
					$break_in2,
					$late
					// $total_work
					// $totalWorkzz
				);
			}
			$output = array(
				 "draw" => $draw,
				 //"recordsTotal" => count($date_range),
				 //"recordsFiltered" => count($date_range),
				 "data" => $data
			);
			echo json_encode($output);
			exit();
	}

	// payslip reports > employees and company
	public function payslip() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_reports_payslip').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_payslip');
		$data['path_url'] = 'reports_payslip';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/payslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// projects report
	public function projects() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_reports_projects').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_projects');
		$data['path_url'] = 'reports_project';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('114',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/projects", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// tasks report
	public function tasks() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_reports_tasks').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_tasks');
		$data['path_url'] = 'reports_task';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('115',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/tasks", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		}else{
			redirect('admin/dashboard');
		}
	}
	// roles/privileges report
	public function roles() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_report_user_roles_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_user_roles_report');
		$data['path_url'] = 'reports_roles';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		// $data['all_user_roles'] = $this->Employees_model->employeeActiveAPG();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('116',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/roles", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// employees report
	public function employees() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['path_url'] = 'reports_employees';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('117',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// get company > departments
	public function get_departments() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/report_get_departments", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get departmens > designations
	 public function designation() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/report_get_designations", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
  }
	// reports > employee training
	public function employee_training() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_hr_reports_training').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_training');
		$data['path_url'] = 'reports_employee_training';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('113',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_training", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}

	// Validate and add info in database
	public function payslip_report() {
		if($this->input->post('type')=='payslip_report') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('employee_id')==='') {
      	$Return['error'] = $this->lang->line('xin_error_employee_id');
			}elseif($this->input->post('month_year')==='') {
				$Return['error'] = $this->lang->line('xin_hr_report_error_month_field');
			}
			if($Return['error']!=''){
     		$this->output($Return);
			}
			$Return['result'] = $this->lang->line('xin_hr_request_submitted');
			$this->output($Return);
		}
	}

	public function role_employees_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/roles", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$roleId = $this->uri->segment(4);
		$employee = $this->Reports_model->get_roles_employees($roleId);
		$data = array();
    foreach($employee->result() as $r) {
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			// user full name
			$full_name = $r->first_name.' '.$r->last_name;
			$location = $r->location_name ? $r->location_name : '-';
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// user role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';
			}
			$department_designation = $designation_name.' ('.$department_name.')';
			$data[] = array(
				$full_name,
				$location,
				$r->email,
				$role_name,
				$department_designation,
				$status
			);
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	public function report_employees_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/employees", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);
		$designation_id = $this->uri->segment(6);
		$employee = $this->Reports_model->get_employees_reports($company_id,$department_id,$designation_id);
		$data = array();
    foreach($employee->result() as $r) {
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			// user full name
			$full_name = $r->first_name.' '.$r->last_name;
			$location = empty($r->fingerprint_location)?'X':$r->fingerprint_location;
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation))
				$designation_name = $designation[0]->designation_name;
			else $designation_name = '--';
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department))
				$department_name = $department[0]->department_name;
			else $department_name = '--';
			$data[] = array(
				$r->employee_id,
				$full_name,
				$location,
				$r->email,
				$comp_name,
				$department_name,
				$designation_name,
				$status
			);
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	public function task_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/tasks", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$taskId = $this->uri->segment(4);
		$taskStatus = $this->uri->segment(5);
		$tasks = $this->Reports_model->get_task_list($taskId,$taskStatus);
		$data = array();
    foreach($tasks->result() as $r) {
			// get start date
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			// get end date
			$end_date = $this->Xin_model->set_date_format($r->end_date);
			//status
			if($r->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			}elseif($r->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			}elseif($r->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			//assigned user
			if($r->assigned_to == '') {
				$ol = $this->lang->line('xin_not_assigned');
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->assigned_to) as $desig_id) {
						$assigned_to = $this->Xin_model->read_user_info($desig_id);
						if(!is_null($assigned_to)){
							$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
							$location = $assigned_to[0]->fingerprint_location;
							# luffy 3 January 2020 11:20 am
						 	$ol .= '<li>'.$assigned_name.'</li>';
						}
				}
				$ol .= '</ol>';
			}
			$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id . '/">'.$r->task_name.'</a></div>';
			$data[] = array(
				$project_summary,$start_date,$end_date,$ol,$status,
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $tasks->num_rows(),
			 "recordsFiltered" => $tasks->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	public function project_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/projects", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$projId = $this->uri->segment(4);
		$projStatus = $this->uri->segment(5);
		$project = $this->Reports_model->get_project_list($projId,$projStatus);
		$data = array();
    foreach($project->result() as $r) {
			// get start date
			$start_date = $this->Xin_model->set_date_format($r->start_date);
			// get end date
			$end_date = $this->Xin_model->set_date_format($r->end_date);
			$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' '.$r->project_progress.'%</p>';
			//status
			if($r->status == 0) {
				$status = $this->lang->line('xin_not_started');
			}elseif($r->status ==1){
				$status = $this->lang->line('xin_in_progress');
			}elseif($r->status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			// priority
			if($r->priority == 1) {
				$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
			}elseif($r->priority ==2){
				$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
			}elseif($r->priority ==3){
				$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
			} else {
				$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
			}
			//assigned user
			if($r->assigned_to == '') {
				$ol = $this->lang->line('xin_not_assigned');
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->assigned_to) as $desig_id) {
					$assigned_to = $this->Xin_model->read_user_info($desig_id);
					if(!is_null($assigned_to)){
						$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
						$ol .= '<li>'.$assigned_name.'</li>';
					}
				}
				$ol .= '</ol>';
			}
			$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '">'.$r->title.'</a></div>';
			$data[] = array(
				$project_summary,
				$priority,
				$start_date,
				$end_date,
				$status,
				$ol
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $project->num_rows(),
			 "recordsFiltered" => $project->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	public function training_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/reports/employee_training", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$start_date = $this->uri->segment(4);
		$end_date = $this->uri->segment(5);
		$uid = $this->uri->segment(6);
		$cid = $this->uri->segment(7);
		$training = $this->Reports_model->get_training_list($cid,$start_date,$end_date);
		$data = array();
        foreach($training->result() as $r) {
		 $aim = explode(',',$r->employee_id);
		 foreach($aim as $dIds) {
		 if($uid == $dIds) {
		// get training type
		$type = $this->Training_model->read_training_type_information($r->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';
		}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$finish_date = $this->Xin_model->set_date_format($r->finish_date);
		// training date
		$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
		// set currency
		$training_cost = $this->Xin_model->currency_sign($r->training_cost);
		/* get Employee info*/
		if($uid == '') {
			$ol = '--';
		} else {
			$user = $this->Exin_model->read_user_info($uid);
			$fname = $user[0]->first_name.' '.$user[0]->last_name;
			$location = $user[0]->fingerprint_location;
		}
		// status
		if($r->training_status==0): $status = $this->lang->line('xin_pending');
		elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
		else: $status = $this->lang->line('xin_terminated'); endif;
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
		$comp_name = $company[0]->name;
		} else {
		  $comp_name = '--';
		}
		$data[] = array(
			$comp_name,
			$fname,
			$location,
			$itype,
			$trainer_name,
			$training_date,
			$training_cost,
			$status
		);
      }
		 } } // e- training
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $training->num_rows(),
			 "recordsFiltered" => $training->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	// hourly_list > templates
	public function payslip_report_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/payroll/hourly_wages", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$cid = $this->uri->segment(4);
		$eid = $this->uri->segment(5);
		$re_date = $this->uri->segment(6);
		$payslip_re = $this->Reports_model->get_payslip_list($cid,$eid,$re_date);
		$data = array();
    foreach($payslip_re->result() as $r) {
			  // get addd by > template
			  $user = $this->Xin_model->read_user_info($r->employee_id);
			  // user full name
			  if(!is_null($user)){
			  	$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$emp_link = '<a target="_blank" href="'.site_url().'admin/employees/detail/'.$r->employee_id.'">'.$user[0]->employee_id.'</a>';
				// view
			 	$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->employee_id . '" data-pay_id="'. $r->payslip_id . '"><i class="fa fa-arrow-circle-right"></i></button></span>';
			  // 1: salary type
				if($r->wages_type==1){
					$wages_type = $this->lang->line('xin_payroll_basic_salary');
					$basic_salary = $r->basic_salary;
					$p_class = 'emo_monthly_pay';
				} else {
					$wages_type = $this->lang->line('xin_employee_daily_wages');
					$basic_salary = $r->daily_wages;
					$p_class = 'emo_monthly_pay';
				}
				// 2: all allowances
				$salary_allowances = $this->Employees_model->read_salary_allowances($r->user_id);
				$count_allowances = $this->Employees_model->count_employee_allowances($r->user_id);
				$allowance_amount = 0;
				if($count_allowances > 0) {
					foreach($salary_allowances as $sl_allowances){
						$allowance_amount += $sl_allowances->allowance_amount;
					}
				} else {
					$allowance_amount = 0;
				}
				// 3: all loan/deductions
				$salary_loan_deduction = $this->Employees_model->read_salary_loan_deductions($r->user_id);
				$count_loan_deduction = $this->Employees_model->count_employee_deductions($r->user_id);
				$loan_de_amount = 0;
				if($count_loan_deduction > 0) {
					foreach($salary_loan_deduction as $sl_salary_loan_deduction){
						$loan_de_amount += $sl_salary_loan_deduction->loan_deduction_amount;
					}
				} else {
					$loan_de_amount = 0;
				}
				// 4: other payment
				if($r->salary_commission == ''){
					$salary_commission = 0;
				} else {
					$salary_commission = $r->salary_commission;
				}
				if($r->salary_paid_leave == ''){
					$salary_paid_leave = 0;
				} else {
					$salary_paid_leave = $r->salary_paid_leave;
				}
				if($r->salary_director_fees == ''){
					$salary_director_fees = 0;
				} else {
					$salary_director_fees = $r->salary_director_fees;
				}
				if($r->salary_advance_paid == ''){
					$salary_advance_paid = 0;
				} else {
					$salary_advance_paid = $r->salary_advance_paid;
				}
				if($r->salary_claims == ''){
					$salary_claims = 0;
				} else {
					$salary_claims = $r->salary_claims;
				}
				// all other payment
				$all_other_payment = $salary_commission + $salary_claims + $salary_paid_leave + $salary_director_fees + $salary_advance_paid;
				// 5: overtime
				$salary_overtime = $this->Employees_model->read_salary_overtime($r->user_id);
				$count_overtime = $this->Employees_model->count_employee_overtime($r->user_id);
				$overtime_amount = 0;
				if($count_overtime > 0) {
					foreach($salary_overtime as $sl_overtime){
						$overtime_total = $sl_overtime->overtime_hours * $sl_overtime->overtime_rate;
						$overtime_amount += $overtime_total;
					}
				} else {
					$overtime_amount = 0;
				}
				// add amount
				$add_salary = $allowance_amount + $basic_salary + $overtime_amount + $all_other_payment;
				// add amount
				$net_salary_default = $add_salary;
				//
				$sta_salary = $allowance_amount + $basic_salary;
				// 6: statutory deductions
				$salary_ssempee = 0;
				if($r->salary_ssempee == '' && $r->salary_ssempee == 0){
					$salary_ssempee = 0;
				} else {
					$salary_ssempee = $sta_salary / 100 * $r->salary_ssempee;
				}
				$salary_ssempeer = 0;
				if($r->salary_ssempeer == '' && $r->salary_ssempeer == 0){
					$salary_ssempeer = 0;
				} else {
					$salary_ssempeer = $sta_salary / 100 * $r->salary_ssempeer;
				}
				$salary_income_tax = 0;
				if($r->salary_income_tax == '' && $r->salary_income_tax == 0){
					$salary_income_tax = 0;
				} else {
					$salary_income_tax = $sta_salary / 100 * $r->salary_income_tax;
				}
				$statutory_deductions = $salary_ssempee + $salary_ssempeer + $salary_income_tax;
				//if($r->salary_advance_paid == ''){
				//$data1 = $add_salary. ' - ' .$loan_de_amount. ' - ' .$net_salary . ' - ' .$salary_ssempee . ' - ' .$statutory_deductions;
				$fnet_salary = $net_salary_default + $statutory_deductions;
				$net_salary = $fnet_salary - $loan_de_amount;
				//$net_salary = number_format((float)$net_salary, 2, '.', '');
				$month_payment = date("F, Y", strtotime($r->salary_month));
			  	$net_salary = $this->Xin_model->currency_sign($r->net_salary);

			  // get date > created at > and format
			  $created_at = $this->Xin_model->set_date_format($r->created_at);
			  // payslip
		 	 $payslip = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_id.'">'.$this->lang->line('left_generate_payslip').'</a>';
       $data[] = array(
          $full_name,
          $net_salary,
          $month_payment,
          $created_at,
					$payslip
      	);
      }
	  } // if employee available
      $output = array(
     	 "draw" => $draw,
       "recordsTotal" => $payslip_re->num_rows(),
       "recordsFiltered" => $payslip_re->num_rows(),
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
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/reports/get_employees", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get company > employees
	 public function get_employees_att() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/reports/get_employees_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	// daily attendance list > timesheet
  public function empdtwise_attendance_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$employee = $this->Xin_model->read_user_attendance_info();
		$data = array();
    foreach($employee->result() as $r) {
			$data[] = array('','','','','','','','','','');
		}
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// General Report > Action Call from A1 + A2 //luffy
	public function general_report(){
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = 'General Report | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'General Report';
		$data['path_url'] = 'general_report';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		if(in_array('1018',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/reports/general_report_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data);
			}else{
				redirect('admin/');
			}
		}else{
			redirect('admin/dashboard');
		}
	}
	// general report socket_create_listen// payslip > employees
	public function general_report_list(){
 		$data['title'] = $this->Xin_model->site_title();
 		$session = $this->session->userdata('username');
 		if(!empty($session)){
 			$this->load->view("admin/reports/general_report_list", $data);
 		} else {
 			redirect('admin/');
 		}
 		// Datatables Variables
 		$draw = intval($this->input->get("draw"));
 		$start = intval($this->input->get("start"));
 		$length = intval($this->input->get("length"));
		$report_month = $this->input->get("report_month");
		$generalReport = $this->Reports_model->getActiveEmployees($report_month);
		$data=array();
		foreach($generalReport as $r) {
			$full_name = $r->first_name.' '.$r->last_name;
			#$view='<span data-toggle="tooltip" data-placement="top" title="Quick View"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-employee_id="'.$r->user_id.'"><span class="fa fa-eye"></span></button></span>';
			$view='<span data-toggle="tooltip" data-placement="top" title="Quick View"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-employee_id="'.$r->employee_id.'" data-report_month="'.$report_month.'"><span class="fa fa-eye"></span></button></span>';
			// $viewDetail='<span data-toggle="tooltip" data-placement="top" title="View Detail"><a href="'.site_url().'admin/reports/general_report_detail/id/'.$r->employee_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// $act=$view.$viewDetail;
			$data[] = array(
				// $act,
				$view,
				$r->employee_id,
				$r->username,
				$full_name,
				$r->fingerprint_location
			);
		}
		$output = array(
		 "draw" => $draw,
		 "recordsTotal" => $generalReport,
		 "recordsFiltered" => $generalReport,
		 "data" => $data
		);
		echo json_encode($output);
		exit();
  }

	// General Report quick view modal
  public function general_report_quickview(){
		 $session = $this->session->userdata('username');
		 if(empty($session)){
			 redirect('admin/');
		 }
		 $data['title'] = $this->Xin_model->site_title();
		 $id = $this->input->get('employee_id');
		 // get addd by > template
		 $user = $this->Reports_model->read_user_info($id);
		 // user full name
		 $full_name = $user[0]->first_name.' '.$user[0]->last_name;
		 // get designation
		 $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		 if(!is_null($designation)){
			 $designation_name = $designation[0]->designation_name;
		 } else {
			 $designation_name = '--';
		 }
		 // get department & sub.
		 $department = $this->Department_model->read_department_information($user[0]->department_id);
		 $subDepartment = $this->Department_model->read_sub_department_info($user[0]->sub_department_id);
		 if(!is_null($department)){
			 $department_name = $department[0]->department_name;
			 $departmentId = $user[0]->department_id;
			 $subDepartmentId = $user[0]->sub_department_id;
		 } else {
			 $department_name = '--';
			 $departmentId = '0';
			 $subDepartmentId = '0';
		 }
		 // get all Connect Response from A1
		 $allConnectResponse=$this->Reports_model->a1AllConnectResponse();
		 $employeeEmail=$user[0]->email;
		 $reportMonth=$_GET['report_month'];
		 $data = array(
			 'first_name' => $user[0]->first_name,
			 'last_name' => $user[0]->last_name,
			 'employee_id' => $user[0]->employee_id,
			 'user_id' => $user[0]->user_id,
			 'employeeId' => $user[0]->employee_id,
			 'employeeEmail' => $employeeEmail,
			 'allConnectResponse' => $allConnectResponse,
			 'department_name' => $department_name,
			 'departmentId' => $departmentId,
			 'subDepartmentId' => $subDepartmentId,
			 'designation_name' => $designation_name,
			 'office_location' => $user[0]->fingerprint_location,
			 'date_of_joining' => $user[0]->date_of_joining,
			 'profile_picture' => $user[0]->profile_picture,
			 'gender' => $user[0]->gender,
			 'reportMonth' => $reportMonth,
			 'reportMonthFormat' => date('F Y',strtotime($reportMonth))
		 );
		 if(!empty($session))
			 $this->load->view('admin/reports/dialog_templates', $data);
		 else redirect('admin/');
  }

	// General Report detail
	public function general_report_detail(){
	 $session = $this->session->userdata('username');
	 if(empty($session)){
		 redirect('admin/');
	 }
	 $data['title'] = ' Report | '.$this->Xin_model->site_title();
	 $payment_id = $this->uri->segment(5);
	 $result = $this->Payroll_model->read_salary_payslip_info($payment_id);
	 /*if(is_null($result)){
		 redirect('admin/payroll/payment_history');
	 }*/
	 $p_method = '';
	 //$department_designation = $designation[0]->designation_name.'('.$department[0]->department_name.')';
	 $data['all_employees'] = $this->Xin_model->all_employees();
	 $data['breadcrumbs'] = 'General Report Detail';
	 $data['path_url'] = 'general_report_detail';
	 $role_resources_ids = $this->Xin_model->user_role_resource();
	 if(!empty($session)){
		 $data['subview'] = $this->load->view("admin/reports/general_report_detail", $data, TRUE);
		 $this->load->view('admin/layout/layout_main', $data); //page load
	 }else{redirect('admin/');}
	 $data = array(
		 'first_name' => 'a',
		 'last_name' => 'b',
		 'employee_id' => $user[0]->employee_id,
		 'contact_no' => $user[0]->contact_no,
		 'date_of_joining' => $user[0]->date_of_joining,
		 'department_name' => $department_name,
		 'designation_name' => $designation_name,
		 'date_of_joining' => $user[0]->date_of_joining,
		 'profile_picture' => $user[0]->profile_picture,
		 'gender' => $user[0]->gender,
		 'make_payment_id' => $result[0]->payslip_id,
		 'wages_type' => $result[0]->wages_type,
		 'payment_date' => $result[0]->salary_month,
		 'basic_salary' => $result[0]->basic_salary,
		 'daily_wages' => $result[0]->daily_wages,
		 'salary_ssempee' => $result[0]->salary_ssempee,
		 'payment_method' => $p_method,
		 'salary_ssempeer' => $result[0]->salary_ssempeer,
		 'salary_income_tax' => $result[0]->salary_income_tax,
		 'salary_commission' => $result[0]->salary_commission,
		 'salary_claims' => $result[0]->salary_claims,
		 'salary_paid_leave' => $result[0]->salary_paid_leave,
		 'salary_director_fees' => $result[0]->salary_director_fees,
		 'salary_advance_paid' => $result[0]->salary_advance_paid,
		 'total_allowances' => $result[0]->total_allowances,
		 'total_loan' => $result[0]->total_loan,
		 'total_overtime' => $result[0]->total_overtime,
		 'statutory_deductions' => $result[0]->statutory_deductions,
		 'net_salary' => $result[0]->net_salary,
		 'other_payment' => $result[0]->other_payment,
		 'pay_comments' => $result[0]->pay_comments,
		 'is_payment' => $result[0]->is_payment,
	 );
	}
}
?>