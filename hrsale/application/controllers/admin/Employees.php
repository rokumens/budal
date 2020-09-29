<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {
	public function __construct() {
  	parent::__construct();
		//load the models
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Roles_model");
		$this->load->model("Location_model");
		$this->load->model("Company_model");
		$this->load->model("Timesheet_model");
		$this->load->model("Reports_model");
		$this->load->library("pagination");
		# luffy 29 Dec 2019 06:21 pm
		$this->load->model("Employee_exit_model");
		// if(empty($lastUrl)){
		// 	#$this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
		// 	$this->session->set_userdata('lastUrl',current_url());
		// }
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
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('xin_employees');
		$data['path_url'] = 'employees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user = $this->Xin_model->read_employee_info($session['user_id']);
		$userRole=$user[0]->user_role_id;
		$data['userRole']=$userRole;
		if(in_array('13',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/employees/employees_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
	// luffy
	// employees directory/hr
	public function hr() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_employees_directory').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_employees_directory');
		$data['path_url'] = 'employees_directory';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('88',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/employees/directory", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
  }
	// luffy
	public function employees_directory() {
	 $data['title'] = $this->Xin_model->site_title();
	 $session = $this->session->userdata('username');
	 if(!empty($session))
		 $this->load->view("admin/employees/directory", $data);
	 else redirect('admin/');
	 $draw = intval($this->input->get("draw"));
	 $start = intval($this->input->get("start"));
	 $length = intval($this->input->get("length"));
	 $company_id = $this->uri->segment(4);
	 $location_id = $this->uri->segment(5);
	 $department_id = $this->uri->segment(6);
	 $shift_id = $this->uri->segment(7);
	 $employee = $this->Employees_model->get_employees_directory($company_id, $location_id, $department_id,$shift_id);
	 $data = array();
	 foreach($employee->result() as $r) {
		 // get company
		 $company = $this->Xin_model->read_company_info($r->company_id);
		 if(!is_null($company))
			 $comp_name = $company[0]->name;
		 else $comp_name = '--';
		 // user full name
		 $full_name = $r->first_name.' '.$r->last_name;
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
		 if(!is_null($department)){
			 $department_name = $department[0]->department_name;
		 } else {
			 $department_name = '--';
		 }
		 $data[] = array(
			 $r->employee_id,
			 ucwords(strtolower($r->username)),
			 $r->email,
			 ucwords(strtolower($r->location_name ? $r->location_name : '-')),
			 $department_name,
			 $designation_name,
			 $r->shift_name,
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
	// luffy
	public function location_directory() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/get_location_directory", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	// get company > departments
	public function departments_directory() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/get_departments_directory", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	// get departmens > shift
	public function shift_directory() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->uri->segment(4);
	 $data = array(
		 'company_id' => $id,
		 // 'all_designations' => $this->Designation_model->all_designations(),
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session))
		 $this->load->view("admin/employees/get_shift_directory", $data);
	 else redirect('admin/');
	 $draw = intval($this->input->get("draw"));
	 $start = intval($this->input->get("start"));
	 $length = intval($this->input->get("length"));
	}
  public function employees_list(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employees_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$employee = $this->Employees_model->get_attendance_employees();
		$data = array();
    foreach($employee->result() as $r) {
			// company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			// employee name
			$full_name = $r->first_name.' '.$r->last_name;
			// status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if(!is_null($role))
				$role_name = $role[0]->role_name;
			else $role_name = '--';
			// designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation))
				$designation_name = $designation[0]->designation_name;
			else $designation_name = '--';
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department))
				$department_name = $department[0]->department_name;
			else $department_name = '--';
			$department_designation = $designation_name.' ('.$department_name.')';
			if($r->user_id != '1') {
				if(in_array('203',$role_resources_ids)) {
					$del_opt = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fa fa-trash"></span></button></span>';
				} else {
					$del_opt = '';
				}
			} else {
				$del_opt = '';
			}
			if(in_array('202',$role_resources_ids))
				$view_opt = ' <span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/employees/detail/'.$r->user_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			else $view_opt = '';
			$function = $view_opt.$del_opt.'';
			$data[] = array(
				$function,
				$r->employee_id,
				ucwords(strtolower($r->username)),
				ucwords(strtolower($full_name)),
				#$comp_name,
				$r->location_name,
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
	public function deleted() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();
		$data['breadcrumbs'] = $this->lang->line('xin_employees');
		$data['path_url'] = 'employees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user = $this->Xin_model->read_employee_info($session['user_id']);
		$userRole=$user[0]->user_role_id;
		$data['userRole']=$userRole;
		if(in_array('13',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/employees/employees_list_deleted", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
  public function employees_list_deleted(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employees_list_deleted", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$employee = $this->Employees_model->get_attendance_employees_deleted();
		$data = array();
    foreach($employee->result() as $r) {
			// company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			// employee name
			$full_name = $r->first_name.' '.$r->last_name;
			// status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if(!is_null($role))
				$role_name = $role[0]->role_name;
			else $ole_name = '--';
			// designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation))
				$designation_name = $designation[0]->designation_name;
			else $designation_name = '--';
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department))
				$department_name = $department[0]->department_name;
			else $department_name = '--';
			$department_designation = $designation_name.' ('.$department_name.')';
			// luffy restore button
			$user = $this->Xin_model->read_employee_info($session['user_id']);
			$restore='';
			if($user[0]->user_role_id==1)
				if(!empty($session))
					$restore='<span data-toggle="tooltip" data-placement="top" title="Restore"><button type="button" class="btn icon-btn btn-xs btn-success waves-effect waves-light restore" data-toggle="modal" data-target=".restore-modal" data-record-id="'. $r->user_id . '"><span class="fa fa-undo"></span></button></span>';
			$action=$restore;
			$data[] = array(
				$action,
				$r->employee_id,
				ucwords(strtolower($r->username)),
				ucwords(strtolower($full_name)),
				#$comp_name,
				$r->fingerprint_location,
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
	public function employees_cards_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employees_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$employee = $this->Employees_model->get_employees();
		$countries = $this->Xin_model->get_countries();
		$data = array();
		$function = '<table>';
    foreach (array_chunk($countries, 4) as $row) {
			$function .= '<tr>';
			foreach ($row as $value) {
				$function .='<td>
        <div class="col-xl-12 col-md-12 col-xs-12">
                    <div class="card">
                        <div class="text-xs-center">
                            <div class="card-block">
                                <img src="'.base_url().'skin/app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150" alt="Card image">
                            </div>
                            <div class="card-block">
                                <h4 class="card-title">asddd</h4>
                                <h6 class="card-subtitle text-muted">asddd</h6>
                            </div>
                            <div class="text-xs-center">
                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
                                <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                </td>';
				$function .='</tr>';
			}
			$data[] = array(
				$function
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

	public function detail() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$id = $this->uri->segment(4);
		$result = $this->Employees_model->read_employee_information($id);
		if(is_null($result))
			redirect('admin/employees');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$check_role = $this->Employees_model->read_employee_information($session['user_id']);
		if(!in_array('202',$role_resources_ids))
			redirect('admin/employees');
		/*if($check_role[0]->user_id!=$result[0]->user_id) {
			redirect('admin/employees');
		}*/
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		//$data['breadcrumbs'] = $this->lang->line('xin_employee_details');
		//$data['path_url'] = 'employees_detail';
		$data = array(
			'breadcrumbs' => $this->lang->line('xin_employee_detail'),
			'path_url' => 'employees_detail',
			'first_name' => ucwords(strtolower($result[0]->first_name)),
			'last_name' => ucwords(strtolower($result[0]->last_name)),
			'user_id' => $result[0]->user_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'office_shift_id' => $result[0]->office_shift_id,
			'username' => ucwords(strtolower($result[0]->username)),
			'email' => $result[0]->email,
			'department_id' => $result[0]->department_id,
			'sub_department_id' => $result[0]->sub_department_id,
			'designation_id' => $result[0]->designation_id,
			'user_role_id' => $result[0]->user_role_id,
			'date_of_birth' => $result[0]->date_of_birth,
			'birthTime' => $result[0]->time_of_birth,
			'date_of_leaving' => $result[0]->date_of_leaving,
			'gender' => $result[0]->gender,
			'marital_status' => $result[0]->marital_status,
			'contact_no' => $result[0]->contact_no,
			'address' => $result[0]->address,
			'wages_type' => $result[0]->wages_type,
			'basic_salary' => $result[0]->basic_salary,
			'daily_wages' => $result[0]->daily_wages,
			'salary_ssempee' => $result[0]->salary_ssempee,
			'salary_ssempeer' => $result[0]->salary_ssempeer,
			'salary_income_tax' => $result[0]->salary_income_tax,
			'salary_overtime' => $result[0]->salary_overtime,
			'salary_commission' => $result[0]->salary_commission,
			'salary_claims' => $result[0]->salary_claims,
			'salary_paid_leave' => $result[0]->salary_paid_leave,
			'salary_director_fees' => $result[0]->salary_director_fees,
			'salary_bonus' => $result[0]->salary_bonus,
			'salary_advance_paid' => $result[0]->salary_advance_paid,
			'is_active' => $result[0]->is_active,
			'date_of_joining' => $result[0]->date_of_joining,
			'all_departments' => $this->Department_model->all_departments(),
			'all_designations' => $this->Designation_model->all_designations(),
			'all_user_roles' => $this->Roles_model->all_user_roles(),
			'title' => $this->lang->line('xin_employee_detail').' | '.$this->Xin_model->site_title(),
			'profile_picture' => $result[0]->profile_picture,
			'facebook_link' => $result[0]->facebook_link,
			'twitter_link' => $result[0]->twitter_link,
			'blogger_link' => $result[0]->blogger_link,
			'linkdedin_link' => $result[0]->linkdedin_link,
			'google_plus_link' => $result[0]->google_plus_link,
			'instagram_link' => $result[0]->instagram_link,
			'pinterest_link' => $result[0]->pinterest_link,
			'youtube_link' => $result[0]->youtube_link,
			'leave_categories' => $result[0]->leave_categories,
			'all_countries' => $this->Xin_model->get_countries(),
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill(),
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_contracts' => $this->Employees_model->all_contracts(),
			'all_office_shifts' => $this->Employees_model->all_office_shifts(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_office_locations' => $this->Location_model->all_office_locations(),
			'all_leave_types' => $this->Timesheet_model->all_leave_types(),
			// luffy 6 Des 2019 - 06:34 pm
			'baziFile' => $result[0]->bazi_file,
			'baziDesc' => $result[0]->bazi_description,
			// luffy 7 Des 2019 - 06:34 pm
			'inactiveReason' => $result[0]->inactive_reason,
			# luffy 29 Dec 2019 06:28 pm
			'all_exit_types' => $this->Employee_exit_model->all_exit_types(),
			'inactiveReason' => $result[0]->inactive_reason
		);
		$data['subview'] = $this->load->view("admin/employees/employee_detail", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
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
			$this->load->view("admin/employees/get_departments", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	public function dialog_contact() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_contact_information($id);
		$data = array(
			'contact_id' => $result[0]->contact_id,
			'employee_id' => $result[0]->employee_id,
			'relation' => $result[0]->relation,
			'is_primary' => $result[0]->is_primary,
			'is_dependent' => $result[0]->is_dependent,
			'contact_name' => $result[0]->contact_name,
			'work_phone' => $result[0]->work_phone,
			'work_phone_extension' => $result[0]->work_phone_extension,
			'mobile_phone' => $result[0]->mobile_phone,
			'home_phone' => $result[0]->home_phone,
			'work_email' => $result[0]->work_email,
			'personal_email' => $result[0]->personal_email,
			'address_1' => $result[0]->address_1,
			'address_2' => $result[0]->address_2,
			'city' => $result[0]->city,
			'state' => $result[0]->state,
			'zipcode' => $result[0]->zipcode,
			'icountry' => $result[0]->country,
			'all_countries' => $this->Xin_model->get_countries()
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_document() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_document_information($id);
		$data = array(
			'document_id' => $document[0]->document_id,
			'document_type_id' => $document[0]->document_type_id,
			'd_employee_id' => $document[0]->employee_id,
			'all_document_types' => $this->Employees_model->all_document_types(),
			'date_of_expiry' => $document[0]->date_of_expiry,
			'title' => $document[0]->title,
			'is_alert' => $document[0]->is_alert,
			'description' => $document[0]->description,
			'notification_email' => $document[0]->notification_email,
			// luffy start
			'license_notification_1' => $document[0]->notification_interval_1,
			'license_notification_2' => $document[0]->notification_interval_2,
			'notification_interval_satuan_1' => $document[0]->notification_interval_satuan_1,
			'notification_interval_satuan_2' => $document[0]->notification_interval_satuan_2,
			'license_notification_full_1' => $document[0]->notification_interval_1." ".$document[0]->notification_interval_satuan_1,
			'license_notification_full_2' => $document[0]->notification_interval_2." ".$document[0]->notification_interval_satuan_2,
			// luffy end
			'document_file' => $document[0]->document_file
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_imgdocument() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$document = $this->Employees_model->read_imgdocument_information($id);
		$data = array(
			'immigration_id' => $document[0]->immigration_id,
			'document_type_id' => $document[0]->document_type_id,
			'd_employee_id' => $document[0]->employee_id,
			'all_document_types' => $this->Employees_model->all_document_types(),
			'all_countries' => $this->Xin_model->get_countries(),
			'document_number' => $document[0]->document_number,
			'document_file' => $document[0]->document_file,
			'issue_date' => $document[0]->issue_date,
			'expiry_date' => $document[0]->expiry_date, //luffy fixing
			'country_id' => $document[0]->country_id,
			'eligible_review_date' => $document[0]->eligible_review_date
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_qualification() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_qualification_information($id);
		$data = array(
			'qualification_id' => $result[0]->qualification_id,
			'employee_id' => $result[0]->employee_id,
			'name' => $result[0]->name,
			'education_level_id' => $result[0]->education_level_id,
			'from_year' => $result[0]->from_year,
			'language_id' => $result[0]->language_id,
			'to_year' => $result[0]->to_year,
			'skill_id' => $result[0]->skill_id,
			'description' => $result[0]->description,
			'all_education_level' => $this->Employees_model->all_education_level(),
			'all_qualification_language' => $this->Employees_model->all_qualification_language(),
			'all_qualification_skill' => $this->Employees_model->all_qualification_skill()
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_work_experience() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_work_experience_information($id);
		$data = array(
			'work_experience_id' => $result[0]->work_experience_id,
			'employee_id' => $result[0]->employee_id,
			'company_name' => $result[0]->company_name,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date,
			'post' => $result[0]->post,
			'description' => $result[0]->description
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_bank_account() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_bank_account_information($id);
		$data = array(
			'bankaccount_id' => $result[0]->bankaccount_id,
			'employee_id' => $result[0]->employee_id,
			'is_primary' => $result[0]->is_primary,
			'account_title' => $result[0]->account_title,
			'account_number' => $result[0]->account_number,
			'bank_name' => $result[0]->bank_name,
			'bank_code' => $result[0]->bank_code,
			'bank_branch' => $result[0]->bank_branch
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_contract() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_contract_information($id);
		$data = array(
			'contract_id' => $result[0]->contract_id,
			'employee_id' => $result[0]->employee_id,
			'contract_type_id' => $result[0]->contract_type_id,
			'from_date' => $result[0]->from_date,
			'designation_id' => $result[0]->designation_id,
			'title' => $result[0]->title,
			'to_date' => $result[0]->to_date,
			'description' => $result[0]->description,
			'all_contract_types' => $this->Employees_model->all_contract_types(),
			'all_designations' => $this->Designation_model->all_designations(),
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_leave() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_leave_information($id);
		$data = array(
			'leave_id' => $result[0]->leave_id,
			'employee_id' => $result[0]->employee_id,
			'contract_id' => $result[0]->contract_id,
			'casual_leave' => $result[0]->casual_leave,
			'medical_leave' => $result[0]->medical_leave
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_shift() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_emp_shift_information($id);
		$data = array(
			'emp_shift_id' => $result[0]->emp_shift_id,
			'employee_id' => $result[0]->employee_id,
			'shift_id' => $result[0]->shift_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
	 	else redirect('admin/');
	}
	public function dialog_location() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_location_information($id);
		$data = array(
			'office_location_id' => $result[0]->office_location_id,
			'employee_id' => $result[0]->employee_id,
			'location_id' => $result[0]->location_id,
			'from_date' => $result[0]->from_date,
			'to_date' => $result[0]->to_date
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_salary_loan() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_loan_deductions($id);
		$data = array(
			'loan_deduction_id' => $result[0]->loan_deduction_id,
			'employee_id' => $result[0]->employee_id,
			'loan_deduction_title' => $result[0]->loan_deduction_title,
			'start_date' => $result[0]->start_date,
			'end_date' => $result[0]->end_date,
			'monthly_installment' => $result[0]->monthly_installment,
			'reason' => $result[0]->reason,
			'created_at' => $result[0]->created_at
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	public function dialog_emp_overtime() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_salary_overtime_record($id);
		$data = array(
			'salary_overtime_id' => $result[0]->salary_overtime_id,
			'employee_id' => $result[0]->employee_id,
			'overtime_type' => $result[0]->overtime_type,
			'no_of_days' => $result[0]->no_of_days,
			'overtime_hours' => $result[0]->overtime_hours,
			'overtime_rate' => $result[0]->overtime_rate
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}
	 // get departmens > designations
	 public function designation() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'subdepartment_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/get_designations", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get main department > sub departments
	 public function get_sub_departments() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'department_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/get_sub_departments", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 public function read() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('warning_id');
		$result = $this->Warning_model->read_warning_information($id);
		$data = array(
			'warning_id' => $result[0]->warning_id,
			'warning_to' => $result[0]->warning_to,
			'warning_by' => $result[0]->warning_by,
			'warning_date' => $result[0]->warning_date,
			'warning_type_id' => $result[0]->warning_type_id,
			'subject' => $result[0]->subject,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'all_employees' => $this->Xin_model->all_employees(),
			'all_warning_types' => $this->Warning_model->all_warning_types(),
		);
		if(!empty($session))
			$this->load->view('admin/warning/dialog_warning', $data);
		else redirect('admin/');
	}
	// add employee
	public function add_employee() {
		$session = $this->session->userdata('username');
		$userId=$session['user_id'];
		if($this->input->post('add_type')=='employee') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('first_name')==='') {
	    	$Return['error'] = $this->lang->line('xin_employee_error_first_name');
			}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('xin_hr_string_error');
			}elseif($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_last_name');
			}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('xin_hr_string_error');
			}elseif($this->input->post('employee_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_employee_id');
			}
			// luffy start
			elseif( preg_match('/\s/',$this->input->post('employee_id')) ) {
			#elseif( preg_match('/[^0-9]/',$this->input->post('employee_id')) ) {	//same with above, only numbers allowed only.
				 $Return['error'] = 'Don\'t use space for Employee ID';
			}elseif( preg_match('/\D/',$this->input->post('employee_id')) ) {
			#elseif( preg_match('/[^0-9]/',$this->input->post('employee_id')) ) {
				 $Return['error'] = 'Please use only numbers for Employee ID.';
			}
			// luffy end.
			elseif($this->input->post('date_of_joining')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
			}elseif($this->Xin_model->validate_date($this->input->post('date_of_joining'),'Y-m-d') == false) {
				 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
			}elseif($this->input->post('company_id')==='') {
				 $Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('department_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_department');
			}elseif($this->input->post('subdepartment_id')==='') {
	    	 $Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
			}elseif($this->input->post('designation_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_designation');
			}elseif($this->input->post('role')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_user_role');
			}elseif($this->input->post('username')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_username');
			}
			// luffy start
			elseif( preg_match('/\s/',$this->input->post('username')) ) {
				 $Return['error'] = 'Don\'t use space for Nickname.';
			}
			// luffy end.
			elseif($this->input->post('email')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_email');
			}elseif (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				 $Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			}elseif($this->input->post('date_of_birth')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_date_of_birth');
			}elseif($this->input->post('time_of_birth')=='') {	// validate time of birth too.
				 $Return['error'] = 'Time of birth is required.';
			}elseif($this->Xin_model->validate_date($this->input->post('date_of_birth'),'Y-m-d') == false) {
				 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
			}elseif($this->input->post('contact_no')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
			}elseif(!preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
				 $Return['error'] = 'Please use only numbers for Contact Number.';
			}
			// elseif($this->input->post('password')==='') {
			// 	 $Return['error'] = $this->lang->line('xin_employee_error_password');
			// }elseif(strlen($this->input->post('password')) < 6) {
			// 	 $Return['error'] = $this->lang->line('xin_employee_error_password_least');
			// }elseif($this->input->post('password')!==$this->input->post('confirm_password')) {
			// 	 $Return['error'] = $this->lang->line('xin_employee_error_password_not_match');
			// }
			elseif($this->input->post('bazi_desc')=='') {
				 $Return['error'] = 'Bazi description is required.';
			}
			# luffy 8 dec 2019 09:01 pm
			/* Check if Bazi file uploaded..*/
			if($_FILES['bazi_file']['size'] == 0) {
				$Return['error'] = "Please upload bazi file.";
			}else{
				if(is_uploaded_file($_FILES['bazi_file']['tmp_name'])) {
					//checking image type
					$allowed =  array('png','jpg','jpeg','pdf','gif','pdf');
					$filename = $_FILES['bazi_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["bazi_file"]["tmp_name"];
						$documentd = "uploads/profile/bazi/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$name = basename($_FILES["bazi_file"]["name"]);
						$newfilename = "bazi_".$this->input->post('username')."_".round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
					}else{
						$Return['error'] = "The attachment must be a file of type: png, jpg, jpeg, pdf, gif, pdf";
					}
				}
			}
			if($Return['error']!='') $this->output($Return);
			$first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
			$employee_id = $this->Xin_model->clean_post($this->input->post('employee_id'));
			$date_of_joining = $this->Xin_model->clean_date_post($this->input->post('date_of_joining'));
			$username = $this->Xin_model->clean_post($this->input->post('username'));
			$date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
			$contact_no = $this->Xin_model->clean_post($this->input->post('contact_no'));
			$address = $this->Xin_model->clean_post($this->input->post('address'));
			$options = array('cost' => 12);
			// $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
			$leave_categories = array($this->input->post('leave_categories'));
			$cat_ids = implode(',',$this->input->post('leave_categories'));
			// $Return['error'] = $cat_ids;
			$data = array(
				'employee_id' => $employee_id,
				'office_shift_id' => $this->input->post('office_shift_id'),
				'first_name' => ucwords(strtolower($first_name)),
				'last_name' => ucwords(strtolower($last_name)),
				'username' => ucwords(strtolower($username)),
				'company_id' => $this->input->post('company_id'),
				'email' => $this->input->post('email'),
				// 'password' => $password_hash,
				'date_of_birth' => $date_of_birth,
				'time_of_birth' => $this->input->post('time_of_birth').':00',
				'gender' => $this->input->post('gender'),
				'user_role_id' => $this->input->post('role'),
				'department_id' => $this->input->post('department_id'),
				'sub_department_id' => $this->input->post('subdepartment_id'),
				'designation_id' => $this->input->post('designation_id'),
				'date_of_joining' => $date_of_joining,
				'contact_no' => $contact_no,
				'address' => $address,
				'is_active' => 1,
				'leave_categories' => $cat_ids,
				'bazi_file' => $fname,
				'bazi_description' => $this->input->post('bazi_desc'),
				'created_at' => date('Y-m-d h:i:s'),
				'created_by' => $userId
			);
			$result = $this->Employees_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_add_employee');
				// //get setting info
				// $setting = $this->Xin_model->read_setting_info(1);
				// $company = $this->Xin_model->read_company_setting_info(1);
				// if($setting[0]->enable_email_notification == 'yes') {
				// 	// load email library
				// 	$this->load->library('email');
				// 	$this->email->set_mailtype("html");
				// 	//get company info
				// 	$cinfo = $this->Xin_model->read_company_setting_info(1);
				// 	//get email template
				// 	$template = $this->Xin_model->read_email_template(8);
				// 	$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				// 	$logo = base_url().'uploads/logo/signin/'.$company[0]->sign_in_logo;
				// 	// get user full name
				// 	$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
				// 	$message = '
				// 	<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
				// 	<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var username}","{var employee_id}","{var employee_name}","{var email}","{var password}"),array($cinfo[0]->company_name,site_url(),$this->input->post('username'),$this->input->post('employee_id'),ucwords(strtolower($full_name)),$this->input->post('email'),$this->input->post('password')),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
				// 	$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
				// 	$this->email->to($this->input->post('email'));
				// 	$this->email->subject($subject);
				// 	$this->email->message($message);
				// 	$this->email->send();
				// }
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// update employee / edit employee
	public function basic_info() {
		$session=$this->session->userdata('username');
		$userId=$session['user_id'];
		$id = $this->input->post('user_id');
		if($this->input->post('type')=='basic_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('first_name')==='') {
	    	$Return['error'] = $this->lang->line('xin_employee_error_first_name');
			}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('first_name'))!=1) {
				$Return['error'] = $this->lang->line('xin_hr_string_error');
			}elseif($this->input->post('last_name')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_last_name');
			}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('last_name'))!=1) {
				$Return['error'] = $this->lang->line('xin_hr_string_error');
			}
			elseif($this->input->post('employee_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_employee_id');
			}
			// luffy start
			elseif( preg_match('/\s/',$this->input->post('employee_id')) ) {
			#elseif( preg_match('/[^0-9]/',$this->input->post('employee_id')) ) {	//same with above, only numbers allowed only.
				 $Return['error'] = 'Don\'t use space for Employee ID';
			}
			elseif( preg_match('/\D/',$this->input->post('employee_id')) ) {
			#elseif( preg_match('/[^0-9]/',$this->input->post('employee_id')) ) {
				 $Return['error'] = 'Please use only numbers for Employee ID.';
			}
			// luffy end.
			elseif($this->input->post('username')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_username');
			}
			// luffy start
			elseif( preg_match('/\s/',$this->input->post('username')) ) {
				 $Return['error'] = 'Don\'t use space for Nickname.';
			}
			// luffy end.
			elseif($this->input->post('email')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_email');
			}elseif (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
				$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
			}elseif($this->input->post('company_id')==='') {
				 $Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('department_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_department');
			}elseif($this->input->post('subdepartment_id')==='') {
	       $Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
			}elseif($this->input->post('designation_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_designation');
			}elseif($this->input->post('date_of_birth')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_date_of_birth');
			}elseif($this->input->post('time_of_birth')=='') {	// validate time of birth too.
				$Return['error'] = 'Time of birth is required.';
			}elseif($this->Xin_model->validate_date($this->input->post('date_of_birth'),'Y-m-d') == false) {
				 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
			}elseif($this->input->post('date_of_joining')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_joining_date');
			}elseif($this->Xin_model->validate_date($this->input->post('date_of_joining'),'Y-m-d') == false) {
				 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
			}  elseif($this->input->post('role')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_user_role');
			}elseif($this->input->post('contact_no')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_contact_number');
			}elseif(!preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
				 $Return['error'] = 'Please use only numbers for Contact Number.';
			}
			// # luffy 8 dec 2019 09:01 pm
			// # ga perlu validasi, perbolehkan kosong
			// elseif($this->input->post('bazi_desc')=='') {
			// 	 $Return['error'] = 'Bazi description is required.';
			// }
			// /* Check if Bazi file uploaded..*/
			// if($this->input->post('existingBazi')==''){
			// 	$Return['error'] = 'Please upload bazi file';
			// }else{
				$fname=''; #biar ga error krn diperboleh update tanpa bazi.
				if($_FILES['bazi_file']['size'] != 0) {
					if(is_uploaded_file($_FILES['bazi_file']['tmp_name'])) {
						//checking image type
						$allowed =  array('png','jpg','jpeg','pdf','gif','pdf');
						$filename = $_FILES['bazi_file']['name'];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						if(in_array($ext,$allowed)){
							$tmp_name = $_FILES["bazi_file"]["tmp_name"];
							$documentd = "uploads/profile/bazi/";
							// basename() may prevent filesystem traversal attacks;
							// further validation/sanitation of the filename may be appropriate
							$name = basename($_FILES["bazi_file"]["name"]);
							// $newfilename = 'bazi_'.round(microtime(true)).'.'.$ext;
							$newfilename = "bazi_".$this->input->post('username')."_".round(microtime(true)).'.'.$ext;
							move_uploaded_file($tmp_name, $documentd.$newfilename);
							$fname = $newfilename;
						}else{
							$Return['error'] = "The bazi file of type allowed: png, jpg, jpeg, pdf, gif, pdf";
						}
					}
				}
			// 	else{
			// 		$result = $this->Employees_model->read_employee_information($id);
			// 		$fname = $result[0]->bazi_file;
			// 	}
			// }
			if($Return['error']!='')
	    	$this->output($Return);
			$first_name = $this->Xin_model->clean_post($this->input->post('first_name'));
			$last_name = $this->Xin_model->clean_post($this->input->post('last_name'));
			$employee_id = $this->input->post('employee_id');
			$date_of_joining = $this->Xin_model->clean_date_post($this->input->post('date_of_joining'));
			//$username = $this->Xin_model->clean_post($this->input->post('username'));
			$username = $this->input->post('username');
			$date_of_birth = $this->Xin_model->clean_date_post($this->input->post('date_of_birth'));
			$contact_no = $this->Xin_model->clean_post($this->input->post('contact_no'));
			$address = $this->Xin_model->clean_post($this->input->post('address'));
			$leave_categories = array($this->input->post('leave_categories'));
			$cat_ids = implode(',',$this->input->post('leave_categories'));
			if($this->input->post('status')==1){ //employee diaktifin kembali
				$data = array(
					'deleted_at' => NULL,
					'deleted_by' => 0,
					'employee_id' => $employee_id,
					'office_shift_id' => $this->input->post('office_shift_id'),
					'first_name' => ucwords(strtolower($first_name)),
					'last_name' => ucwords(strtolower($last_name)),
					'username' => ucwords(strtolower($username)),
					'company_id' => $this->input->post('company_id'),
					'email' => $this->input->post('email'),
					'date_of_birth' => $date_of_birth,
					'time_of_birth' => $this->input->post('time_of_birth').':00',
					'gender' => $this->input->post('gender'),
					'user_role_id' => $this->input->post('role'),
					'department_id' => $this->input->post('department_id'),
					'sub_department_id' => $this->input->post('subdepartment_id'),
					'designation_id' => $this->input->post('designation_id'),
					'date_of_joining' => $date_of_joining,
					'contact_no' => $contact_no,
					'address' => $address,
					'leave_categories' => $cat_ids,
					'date_of_leaving' => $this->input->post('date_of_leaving'),
					'marital_status' => $this->input->post('marital_status'),
					// luffy 6 Des 2019 - 06:38 pm
					'bazi_file' => $fname,
					'bazi_description' => $this->input->post('bazi_desc'),
					'is_active' => 1,
					'inactive_reason' => 0,
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => $userId
				);
			}else{ //employee di-in'active-kan.
				$data = array(
					'employee_id' => $employee_id,
					'office_shift_id' => $this->input->post('office_shift_id'),
					'first_name' => ucwords(strtolower($first_name)),
					'last_name' => ucwords(strtolower($last_name)),
					'username' => ucwords(strtolower($username)),
					'company_id' => $this->input->post('company_id'),
					'email' => $this->input->post('email'),
					'date_of_birth' => $date_of_birth,
					'time_of_birth' => $this->input->post('time_of_birth').':00',
					'gender' => $this->input->post('gender'),
					'user_role_id' => $this->input->post('role'),
					'department_id' => $this->input->post('department_id'),
					'sub_department_id' => $this->input->post('subdepartment_id'),
					'designation_id' => $this->input->post('designation_id'),
					'date_of_joining' => $date_of_joining,
					'contact_no' => $contact_no,
					'address' => $address,
					'leave_categories' => $cat_ids,
					'date_of_leaving' => $this->input->post('date_of_leaving'),
					'marital_status' => $this->input->post('marital_status'),
					// luffy 6 Des 2019 - 06:38 pm
					'bazi_file' => $fname,
					'bazi_description' => $this->input->post('bazi_desc'),
					'is_active' => 0,
					'inactive_reason' => $this->input->post('inactive_reason'),
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => $userId
				);
			}
			$result = $this->Employees_model->basic_info($data,$id);
			if ($result == TRUE)
				$Return['result'] = $this->lang->line('xin_employee_basic_info_updated');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}

	// Validate and update info in database // social info
	public function profile_picture() {
		if($this->input->post('type')=='profile_picture') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->input->post('user_id');
			/* Check if file uploaded..*/
			if($_FILES['p_file']['size'] == 0 && null ==$this->input->post('remove_profile_picture')) {
				$Return['error'] = $this->lang->line('xin_employee_select_picture');
			}else{
				if(is_uploaded_file($_FILES['p_file']['tmp_name'])) {
					//checking image type
					$allowed =  array('png','jpg','jpeg','pdf','gif','JPG','JPEG','PNG','GIF');
					$filename = $_FILES['p_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["p_file"]["tmp_name"];
						$profile = "uploads/profile/";
						$set_img = base_url()."uploads/profile/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$name = basename($_FILES["p_file"]["name"]);
						$newfilename = 'profile_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $profile.$newfilename);
						$fname = $newfilename;
						//UPDATE Employee info in DB
						$data = array('profile_picture' => $fname);
						$result = $this->Employees_model->profile_picture($data,$id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_employee_picture_updated');
							$Return['img'] = $set_img.$fname;
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('xin_employee_picture_type');
					}
				}
			}
			if(null!=$this->input->post('remove_profile_picture')) {
				//UPDATE Employee info in DB
				$data = array('profile_picture' => 'no file');
				$row = $this->Employees_model->read_employee_information($id);
				$profile = base_url()."uploads/profile/";
				$result = $this->Employees_model->profile_picture($data,$id);
				if ($result == TRUE) {
					$Return['result'] = $this->lang->line('xin_employee_picture_updated');
					if($row[0]->gender=='Male') {
						$Return['img'] = $profile.'default_male.jpg';
					} else {
						$Return['img'] = $profile.'default_female.jpg';
					}
				} else {
					$Return['error'] = $this->lang->line('xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
			if($Return['error']!='')
				$this->output($Return);
		}
	}
	public function social_info() {
		if($this->input->post('type')=='social_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if ($this->input->post('facebook_link')!=='' && !filter_var($this->input->post('facebook_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_fb_field_error');
		}elseif ($this->input->post('twitter_link')!=='' && !filter_var($this->input->post('twitter_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_twitter_field_error');
		}elseif ($this->input->post('blogger_link')!=='' && !filter_var($this->input->post('blogger_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_blogger_field_error');
		}elseif ($this->input->post('linkdedin_link')!=='' && !filter_var($this->input->post('linkdedin_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_linkedin_field_error');
		}elseif ($this->input->post('google_plus_link')!=='' && !filter_var($this->input->post('google_plus_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_gplus_field_error');
		}elseif ($this->input->post('instagram_link')!=='' && !filter_var($this->input->post('instagram_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_instagram_field_error');
		}elseif ($this->input->post('pinterest_link')!=='' && !filter_var($this->input->post('pinterest_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_pinterest_field_error');
		}elseif ($this->input->post('youtube_link')!=='' && !filter_var($this->input->post('youtube_link'), FILTER_VALIDATE_URL)) {
			$Return['error'] = $this->lang->line('xin_hr_youtube_field_error');
		}
		if($Return['error']!='')
			$this->output($Return);
		$data = array(
			'facebook_link' => $this->input->post('facebook_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'blogger_link' => $this->input->post('blogger_link'),
			'linkdedin_link' => $this->input->post('linkdedin_link'),
			'google_plus_link' => $this->input->post('google_plus_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'pinterest_link' => $this->input->post('pinterest_link'),
			'youtube_link' => $this->input->post('youtube_link')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->social_info($data,$id);
		if ($result == TRUE)
			$Return['result'] = $this->lang->line('xin_success_update_social_info');
		else $Return['error'] = $this->lang->line('xin_error_msg');
		$this->output($Return);
		exit;
		}
	}
	public function update_contacts_info() {
		if($this->input->post('type')=='contact_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('salutation')==='') {
	   		 $Return['error'] = $this->lang->line('xin_employee_error_salutation');
			}elseif($this->input->post('contact_name')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
			}elseif($this->input->post('relation')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_grp');
			}elseif($this->input->post('primary_email')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_pemail');
			}elseif($this->input->post('mobile_phone')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
			}elseif($this->input->post('city')==='') {
				 $Return['error'] = $this->lang->line('xin_error_city_field');
			}elseif($this->input->post('country')==='') {
				 $Return['error'] = $this->lang->line('xin_error_country_field');
			}
			if($Return['error']!='')
	    	$this->output($Return);
			$data = array(
				'salutation' => $this->input->post('salutation'),
				'contact_name' => $this->input->post('contact_name'),
				'relation' => $this->input->post('relation'),
				'company' => $this->input->post('company'),
				'job_title' => $this->input->post('job_title'),
				'primary_email' => $this->input->post('primary_email'),
				'mobile_phone' => $this->input->post('mobile_phone'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zipcode' => $this->input->post('zipcode'),
				'country' => $this->input->post('country'),
				'employee_id' => $this->input->post('user_id'),
				'contact_type' => 'permanent'
			);
			$query = $this->Employees_model->check_employee_contact_permanent($this->input->post('user_id'));
			if ($query->num_rows() > 0 ) {
				$res = $query->result();
				$e_field_id = $res[0]->contact_id;
				$result = $this->Employees_model->contact_info_update($data,$e_field_id);
			} else {
				$result = $this->Employees_model->contact_info_add($data);
			}
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	public function update_contact_info() {
		if($this->input->post('type')=='contact_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('salutation')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_salutation');
		}elseif($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		}elseif($this->input->post('relation')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_grp');
		}elseif($this->input->post('primary_email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_pemail');
		}elseif($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		}elseif($this->input->post('city')==='') {
			 $Return['error'] = $this->lang->line('xin_error_city_field');
		}elseif($this->input->post('country')==='') {
			 $Return['error'] = $this->lang->line('xin_error_country_field');
		}
		if($Return['error']!='')
    	$this->output($Return);
		$data = array(
			'salutation' => $this->input->post('salutation'),
			'contact_name' => $this->input->post('contact_name'),
			'relation' => $this->input->post('relation'),
			'company' => $this->input->post('company'),
			'job_title' => $this->input->post('job_title'),
			'primary_email' => $this->input->post('primary_email'),
			'mobile_phone' => $this->input->post('mobile_phone'),
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'employee_id' => $this->input->post('user_id'),
			'contact_type' => 'current'
		);
		$query = $this->Employees_model->check_employee_contact_current($this->input->post('user_id'));
		if ($query->num_rows() > 0 ) {
			$res = $query->result();
			$e_field_id = $res[0]->contact_id;
			$result = $this->Employees_model->contact_info_update($data,$e_field_id);
		} else {
			$result = $this->Employees_model->contact_info_add($data);
		}
		//$e_field_id = 1;
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // contact info
	public function contact_info() {
		if($this->input->post('type')=='contact_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('relation')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_relation');
		}elseif($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		}elseif(!preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('contact_name'))) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}elseif($this->input->post('contact_no')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('contact_no'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}elseif($this->input->post('work_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('work_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}elseif($this->input->post('work_phone_extension')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('work_phone_extension'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}elseif($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		}elseif(!preg_match('/^([0-9]*)$/', $this->input->post('mobile_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}elseif($this->input->post('home_phone')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('home_phone'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}elseif($this->input->post('work_email')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_email');
		}elseif (!filter_var($this->input->post('work_email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		}elseif ($this->input->post('personal_email')!=='' && !filter_var($this->input->post('personal_email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		}elseif($this->input->post('zipcode')!=='' && !preg_match('/^([0-9]*)$/', $this->input->post('zipcode'))) {
			 $Return['error'] = $this->lang->line('xin_hr_numeric_error');
		}
		if(null!=$this->input->post('is_primary')) {
			$is_primary = $this->input->post('is_primary');
		} else {
			$is_primary = '';
		}
		if(null!=$this->input->post('is_dependent')) {
			$is_dependent = $this->input->post('is_dependent');
		} else {
			$is_dependent = '';
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$contact_name = $this->Xin_model->clean_post($this->input->post('contact_name'));
		$address_1 = $this->Xin_model->clean_post($this->input->post('address_1'));
		$address_2 = $this->Xin_model->clean_post($this->input->post('address_2'));
		$city = $this->Xin_model->clean_post($this->input->post('city'));
		$state = $this->Xin_model->clean_post($this->input->post('state'));
		$data = array(
			'relation' => $this->input->post('relation'),
			'work_email' => $this->input->post('work_email'),
			'is_primary' => $is_primary,
			'is_dependent' => $is_dependent,
			'personal_email' => $this->input->post('personal_email'),
			'contact_name' => $contact_name,
			'address_1' => $address_1,
			'work_phone' => $this->input->post('work_phone'),
			'work_phone_extension' => $this->input->post('work_phone_extension'),
			'address_2' => $address_2,
			'mobile_phone' => $this->input->post('mobile_phone'),
			'city' => $city,
			'state' => $state,
			'zipcode' => $this->input->post('zipcode'),
			'home_phone' => $this->input->post('home_phone'),
			'country' => $this->input->post('country'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->contact_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	public function e_contact_info() {
		if($this->input->post('type')=='e_contact_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('relation')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_relation');
		}elseif($this->input->post('contact_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_contact_name');
		}elseif($this->input->post('mobile_phone')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_mobile');
		}
		if(null!=$this->input->post('is_primary')) {
			$is_primary = $this->input->post('is_primary');
		} else {
			$is_primary = '';
		}
		if(null!=$this->input->post('is_dependent')) {
			$is_dependent = $this->input->post('is_dependent');
		} else {
			$is_dependent = '';
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$data = array(
			'relation' => $this->input->post('relation'),
			'work_email' => $this->input->post('work_email'),
			'is_primary' => $is_primary,
			'is_dependent' => $is_dependent,
			'personal_email' => $this->input->post('personal_email'),
			'contact_name' => $this->input->post('contact_name'),
			'address_1' => $this->input->post('address_1'),
			'work_phone' => $this->input->post('work_phone'),
			'work_phone_extension' => $this->input->post('work_phone_extension'),
			'address_2' => $this->input->post('address_2'),
			'mobile_phone' => $this->input->post('mobile_phone'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'home_phone' => $this->input->post('home_phone'),
			'country' => $this->input->post('country')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->contact_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contact_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // document info
	public function document_info() {
		if($this->input->post('type')=='document_info' && $this->input->post('data')=='document_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('document_type_id')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		} /*elseif($this->Xin_model->validate_date($this->input->post('date_of_expiry'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}*/ elseif($this->input->post('title')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
		}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('title')) != 1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}
		// elseif($this->input->post('email')==='') {
		// 	 $Return['error'] = $this->lang->line('xin_error_notify_email_field');
		// }
		// elseif(!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
		// 	$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		// }
		// luffy start
		elseif($this->input->post('license_notification_1')==='') {
			$Return['error'] = "Alarm notifications 1 field is required.";
		}elseif($this->input->post('license_notification_2')==='') {
			$Return['error'] = "Alarm notifications 2 field is required.";
		}elseif($this->input->post('date_of_expiry')==='') {
			$Return['error'] = $this->lang->line('xin_co_error_license_exp_date');
		}
		/* Check if file uploaded..*/
		elseif($_FILES['document_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_employee_select_d_file');
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
		if($Return['error']!='')
   		$this->output($Return);
		//clean simple fields
		$title = $this->Xin_model->clean_post($this->input->post('title'));
		$description = $this->Xin_model->clean_post($this->input->post('description'));
		// clean date fields
		$date_of_expiry = $this->Xin_model->clean_date_post($this->input->post('date_of_expiry'));
		// luffy start
		$notification_interval_1 = $this->input->post('license_notification_1');
		$notification_interval_satuan_1 = $this->input->post('license_notification_satuan_1');
		$notification_date_1 = date("Y-m-d", strtotime($this->input->post('date_of_expiry')." -".$notification_interval_1." ".$notification_interval_satuan_1));
		$notification_interval_2 = $this->input->post('license_notification_2');
		$notification_interval_satuan_2 = $this->input->post('license_notification_satuan_2');
		$notification_date_2 = date("Y-m-d", strtotime($this->input->post('date_of_expiry')." -".$notification_interval_2." ".$notification_interval_satuan_2));
		// luffy end
		$data = array(
			'document_type_id' => $this->input->post('document_type_id'),
			'date_of_expiry' => $date_of_expiry,
			'document_file' => $fname,
			'title' => $title,
			// 'notification_email' => $this->input->post('email'),
			// 'is_alert' => $this->input->post('send_mail'),
			'is_alert' => 2, #forced to no, 1=yes.
			'description' => $description,
			'employee_id' => $this->input->post('user_id'),
			// luffy start
			'notification_interval_1' => $notification_interval_1,
			'notification_interval_satuan_1' => $notification_interval_satuan_1,
			'notification_date_1' => $notification_date_1,
			'notification_interval_2' => $notification_interval_2,
			'notification_interval_satuan_2' => $notification_interval_satuan_2,
			'notification_date_2' => $notification_date_2,
			// luffy end
		);
		$result = $this->Employees_model->document_info_add($data);
		if($result == TRUE)
			$Return['result'] = $this->lang->line('xin_employee_d_info_added');
		else $Return['error'] = $this->lang->line('xin_error_msg');
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // document info
	public function immigration_info() {
		if($this->input->post('type')=='immigration_info' && $this->input->post('data')=='immigration_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		//preg_match("/^(\pL{1,}[ ]?)+$/u",
		if($this->input->post('document_type_id')==='') {
      $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		}elseif($this->input->post('document_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_number');
		}elseif($this->input->post('issue_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_issue');
		}elseif($this->Xin_model->validate_date($this->input->post('issue_date'),'Y-m-d') == false) {
			$Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}elseif($this->input->post('expiry_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_expiry_date');
		}elseif($this->Xin_model->validate_date($this->input->post('expiry_date'),'Y-m-d') == false) {
			$Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}
		/* Check if file uploaded..*/
		elseif($_FILES['document_file']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_employee_select_d_file');
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed = array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/immigration/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
		if($Return['error']!='')
   		$this->output($Return);
		$document_number = $this->Xin_model->clean_post($this->input->post('document_number'));
		$issue_date = $this->Xin_model->clean_date_post($this->input->post('issue_date'));
		$expiry_date = $this->Xin_model->clean_date_post($this->input->post('expiry_date'));
		$eligible_review_date = $this->Xin_model->clean_date_post($this->input->post('eligible_review_date'));
		$data = array(
			'document_type_id' => $this->input->post('document_type_id'),
			'document_number' => $document_number,
			'document_file' => $fname,
			'issue_date' => $issue_date,
			'expiry_date' => $expiry_date,
			'country_id' => $this->input->post('country'),
			'eligible_review_date' => $eligible_review_date,
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y h:i:s'),
		);
		$result = $this->Employees_model->immigration_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_img_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// Validate and add info in database // document info
	public function e_immigration_info() {
		if($this->input->post('type')=='e_immigration_info' && $this->input->post('data')=='e_immigration_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('document_type_id')==='') {
      $Return['error'] = $this->lang->line('xin_employee_error_d_type');
		}elseif($this->input->post('document_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_number');
		}elseif($this->input->post('issue_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_d_issue');
		}elseif($this->input->post('expiry_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_expiry_date');
		}
		/* Check if file uploaded..*/
		elseif($_FILES['document_file']['size'] == 0) {
			$data = array(
				'document_type_id' => $this->input->post('document_type_id'),
				'document_number' => $this->input->post('document_number'),
				'issue_date' => $this->input->post('issue_date'),
				'expiry_date' => $this->input->post('expiry_date'),
				'country_id' => $this->input->post('country'),
				'eligible_review_date' => $this->input->post('eligible_review_date'),
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->img_document_info_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_img_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
				$filename = $_FILES['document_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["document_file"]["tmp_name"];
					$documentd = "uploads/document/immigration/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$name = basename($_FILES["document_file"]["name"]);
					$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $documentd.$newfilename);
					$fname = $newfilename;
					$data = array(
						'document_type_id' => $this->input->post('document_type_id'),
						'document_number' => $this->input->post('document_number'),
						'document_file' => $fname,
						'issue_date' => $this->input->post('issue_date'),
						'expiry_date' => $this->input->post('expiry_date'),
						'country_id' => $this->input->post('country'),
						'eligible_review_date' => $this->input->post('eligible_review_date'),
					);
					$e_field_id = $this->input->post('e_field_id');
					$result = $this->Employees_model->img_document_info_update($data,$e_field_id);
					if ($result == TRUE) {
						$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
					} else {
						$Return['error'] = $this->lang->line('xin_error_msg');
					}
					$this->output($Return);
					exit;
				} else {
					$Return['error'] = $this->lang->line('xin_employee_document_file_type');
				}
			}
		}
		if($Return['error']!=''){
    	$this->output($Return);
  	}
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_img_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // e_document info
	public function e_document_info() {
		if($this->input->post('type')=='e_document_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// luffy start
			$notification_interval_1 = $this->input->post('license_notification_1');
			$notification_interval_satuan_1 = $this->input->post('license_notification_satuan_1');
			$notification_date_1 = date("Y-m-d", strtotime($this->input->post('date_of_expiry')." -".$notification_interval_1." ".$notification_interval_satuan_1));
			$notification_interval_2 = $this->input->post('license_notification_2');
			$notification_interval_satuan_2 = $this->input->post('license_notification_satuan_2');
			$notification_date_2 = date("Y-m-d", strtotime($this->input->post('date_of_expiry')." -".$notification_interval_2." ".$notification_interval_satuan_2));
			// luffy end
			if($this->input->post('document_type_id')==='') {
     		 $Return['error'] = $this->lang->line('xin_employee_error_d_type');
			}elseif($this->input->post('title')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_document_title');
			}
			// elseif($this->input->post('email')==='') {
			// 	 $Return['error'] = $this->lang->line('xin_error_notify_email_field');
			// }
			/* Check if file uploaded..*/
			elseif($_FILES['document_file']['size'] == 0) {
				$data = array(
					'document_type_id' => $this->input->post('document_type_id'),
					'date_of_expiry' => $this->input->post('date_of_expiry'),
					'title' => $this->input->post('title'),
					// 'notification_email' => $this->input->post('email'),
					// 'is_alert' => $this->input->post('send_mail'),
					'is_alert' => 2, #forced to no, 1=yes.
					// luffy start
					'notification_interval_1' => $notification_interval_1,
					'notification_interval_satuan_1' => $notification_interval_satuan_1,
					'notification_date_1' => $notification_date_1,
					'notification_interval_2' => $notification_interval_2,
					'notification_interval_satuan_2' => $notification_interval_satuan_2,
					'notification_date_2' => $notification_date_2,
					// luffy end
					'description' => $this->input->post('description')
				);
				$e_field_id = $this->input->post('e_field_id');
				$result = $this->Employees_model->document_info_update($data,$e_field_id);
				if($result == TRUE)
					$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
				else $Return['error'] = $this->lang->line('xin_error_msg');
				$this->output($Return);
				exit;
			} else {
				if(is_uploaded_file($_FILES['document_file']['tmp_name'])) {
					//checking image type
					$allowed =  array('png','jpg','jpeg','pdf','gif','txt','pdf','xls','xlsx','doc','docx');
					$filename = $_FILES['document_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["document_file"]["tmp_name"];
						$documentd = "uploads/document/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$name = basename($_FILES["document_file"]["name"]);
						$newfilename = 'document_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $documentd.$newfilename);
						$fname = $newfilename;
						$data = array(
							'document_type_id' => $this->input->post('document_type_id'),
							'date_of_expiry' => $this->input->post('date_of_expiry'),
							'document_file' => $fname,
							'title' => $this->input->post('title'),
							'notification_email' => $this->input->post('email'),
							'is_alert' => $this->input->post('send_mail'),
							// luffy start
							'notification_interval_1' => $notification_interval_1,
							'notification_interval_satuan_1' => $notification_interval_satuan_1,
							'notification_date_1' => $notification_date_1,
							'notification_interval_2' => $notification_interval_2,
							'notification_interval_satuan_2' => $notification_interval_satuan_2,
							'notification_date_2' => $notification_date_2,
							// luffy end
							'description' => $this->input->post('description')
						);
						$e_field_id = $this->input->post('e_field_id');
						$result = $this->Employees_model->document_info_update($data,$e_field_id);
						if ($result == TRUE) {
							$Return['result'] = $this->lang->line('xin_employee_d_info_updated');
						} else {
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
						$this->output($Return);
						exit;
					} else {
						$Return['error'] = $this->lang->line('xin_employee_document_file_type');
					}
				}
			}
			if($Return['error']!='')
	    	$this->output($Return);
		}
	}
	// Validate and add info in database // qualification info
	public function qualification_info() {
		if($this->input->post('type')=='qualification_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$from_year = $this->input->post('from_year');
		$to_year = $this->input->post('to_year');
		$st_date = strtotime($from_year);
		$ed_date = strtotime($to_year);
		if($this->input->post('name')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_sch_uni');
		}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('name'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}elseif($this->input->post('from_year')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->Xin_model->validate_date($this->input->post('from_year'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}elseif($this->input->post('to_year')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		}elseif($this->Xin_model->validate_date($this->input->post('to_year'),'Y-m-d') == false) {
			 $Return['error'] = $this->lang->line('xin_hr_date_format_error');
		}elseif($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		}
		if($Return['error']!='')
   		$this->output($Return);
		$name = $this->Xin_model->clean_post($this->input->post('name'));
		$from_year = $this->Xin_model->clean_date_post($this->input->post('from_year'));
		$to_year = $this->Xin_model->clean_date_post($this->input->post('to_year'));
		$description = $this->Xin_model->clean_post($this->input->post('description'));
		$data = array(
			'name' => $name,
			'education_level_id' => $this->input->post('education_level'),
			'from_year' => $from_year,
			'language_id' => $this->input->post('language'),
			'to_year' => $this->input->post('to_year'),
			'skill_id' => $this->input->post('skill'),
			'description' => $description,
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->qualification_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_q_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // qualification info
	public function e_qualification_info() {
		if($this->input->post('type')=='e_qualification_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$from_year = $this->input->post('from_year');
		$to_year = $this->input->post('to_year');
		$st_date = strtotime($from_year);
		$ed_date = strtotime($to_year);
		if($this->input->post('name')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_sch_uni');
		}elseif($this->input->post('from_year')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->input->post('to_year')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		}elseif($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$data = array(
			'name' => $this->input->post('name'),
			'education_level_id' => $this->input->post('education_level'),
			'from_year' => $this->input->post('from_year'),
			'language_id' => $this->input->post('language'),
			'to_year' => $this->input->post('to_year'),
			'skill_id' => $this->input->post('skill'),
			'description' => $this->input->post('description')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->qualification_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_q_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // work experience info
	public function work_experience_info() {
		if($this->input->post('type')=='work_experience_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$frm_date = strtotime($this->input->post('from_date'));
		$to_date = strtotime($this->input->post('to_date'));
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_company_name');
		}elseif($this->input->post('post')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_post');
		}elseif($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		}elseif($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$data = array(
			'company_name' => $this->input->post('company_name'),
			'from_date' => $this->input->post('from_date'),
			'to_date' => $this->input->post('to_date'),
			'post' => $this->input->post('post'),
			'description' => $this->input->post('description'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->work_experience_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_w_exp_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	public function e_work_experience_info() {
		if($this->input->post('type')=='e_work_experience_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$frm_date = strtotime($this->input->post('from_date'));
			$to_date = strtotime($this->input->post('to_date'));
			if($this->input->post('company_name')==='') {
     		 $Return['error'] = $this->lang->line('xin_employee_error_company_name');
			}elseif($this->input->post('from_date')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_frm_date');
			}elseif($this->input->post('to_date')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
			}elseif($frm_date > $to_date) {
				 $Return['error'] = $this->lang->line('xin_employee_error_date_shouldbe');
			}elseif($this->input->post('post')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_post');
			}
			if($Return['error']!='')
	   		$sthis->output($Return);
			$data = array(
				'company_name' => $this->input->post('company_name'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'post' => $this->input->post('post'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->work_experience_info_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_error_w_exp_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and add info in database // bank account info
	public function bank_account_info() {
		if($this->input->post('type')=='bank_account_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('account_title')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_acc_title');
		}elseif(preg_match("/^(\pL{1,}[ ]?)+$/u",$this->input->post('account_title'))!=1) {
			$Return['error'] = $this->lang->line('xin_hr_string_error');
		}elseif($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		}elseif($this->input->post('bank_name')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_name');
		}elseif($this->input->post('bank_code')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_code');
		}
		if($Return['error']!='')
   		$this->output($Return);
		$data = array(
			'account_title' => $this->input->post('account_title'),
			'account_number' => $this->input->post('account_number'),
			'bank_name' => $this->input->post('bank_name'),
			'bank_code' => $this->input->post('bank_code'),
			'bank_branch' => $this->input->post('bank_branch'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->bank_account_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_bank_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // ebank account info
	public function e_bank_account_info() {
		if($this->input->post('type')=='e_bank_account_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('account_title')==='') {
       		 $Return['error'] = $this->lang->line('xin_employee_error_acc_title');
		}elseif($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		}elseif($this->input->post('bank_name')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_name');
		}elseif($this->input->post('bank_code')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_bank_code');
		}
		if($Return['error']!='')
   		$this->output($Return);
		$data = array(
			'account_title' => $this->input->post('account_title'),
			'account_number' => $this->input->post('account_number'),
			'bank_name' => $this->input->post('bank_name'),
			'bank_code' => $this->input->post('bank_code'),
			'bank_branch' => $this->input->post('bank_branch')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->bank_account_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_error_bank_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //contract info
	public function contract_info() {
		if($this->input->post('type')=='contract_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$frm_date = strtotime($this->input->post('from_date'));
		$to_date = strtotime($this->input->post('to_date'));
		if($this->input->post('contract_type_id')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_contract_type');
		}elseif($this->input->post('title')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_contract_title');
		}elseif($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->input->post('to_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
		}elseif($frm_date > $to_date) {
			 $Return['error'] = $this->lang->line('xin_employee_error_frm_to_date');
		}elseif($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		}
		if($Return['error']!='')
     		$this->output($Return);
		$data = array(
			'contract_type_id' => $this->input->post('contract_type_id'),
			'title' => $this->input->post('title'),
			'from_date' => $this->input->post('from_date'),
			'to_date' => $this->input->post('to_date'),
			'designation_id' => $this->input->post('designation_id'),
			'description' => $this->input->post('description'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->contract_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_contract_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //e contract info
	public function e_contract_info() {
		if($this->input->post('type')=='e_contract_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$frm_date = strtotime($this->input->post('from_date'));
			$to_date = strtotime($this->input->post('to_date'));
			if($this->input->post('contract_type_id')==='') {
	   		 $Return['error'] = $this->lang->line('xin_employee_error_contract_type');
			}elseif($this->input->post('title')==='') {
	   		 $Return['error'] = $this->lang->line('xin_employee_error_contract_title');
			}elseif($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
			}elseif($this->input->post('to_date')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_to_date');
			}elseif($frm_date > $to_date) {
				 $Return['error'] = $this->lang->line('xin_employee_error_frm_to_date');
			}elseif($this->input->post('designation_id')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_designation');
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$data = array(
				'contract_type_id' => $this->input->post('contract_type_id'),
				'title' => $this->input->post('title'),
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date'),
				'designation_id' => $this->input->post('designation_id'),
				'description' => $this->input->post('description')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->contract_info_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_contract_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and add info in database //leave_info
	public function leave_info() {
		if($this->input->post('type')=='leave_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('contract_id')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_contract_f');
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$data = array(
			'contract_id' => $this->input->post('contract_id'),
			'casual_leave' => $this->input->post('casual_leave'),
			'medical_leave' => $this->input->post('medical_leave'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->leave_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_leave_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database //Eleave_info
	public function e_leave_info() {

		if($this->input->post('type')=='e_leave_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($Return['error']!='')
     		$this->output($Return);
		$data = array(
			'casual_leave' => $this->input->post('casual_leave'),
			'medical_leave' => $this->input->post('medical_leave')
		);
		$e_field_id = $this->input->post('e_field_id');
		$result = $this->Employees_model->leave_info_update($data,$e_field_id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_leave_info_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // shift info
	public function shift_info() {
		if($this->input->post('type')=='shift_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->input->post('shift_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_shift_field');
		}
		if($Return['error']!='')
     		$this->output($Return);
		$data = array(
			'from_date' => $this->input->post('from_date'),
			'to_date' => $this->input->post('to_date'),
			'shift_id' => $this->input->post('shift_id'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->shift_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_shift_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// Validate and add info in database // eshift info
	public function e_shift_info() {
		if($this->input->post('type')=='e_shift_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('from_date')==='')
				$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->shift_info_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_shift_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and add info in database // location info
	public function location_info() {
		if($this->input->post('type')=='location_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('from_date')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
		}elseif($this->input->post('location_id')==='') {
		  $Return['error'] = $this->lang->line('error_location_dept_field');
		}
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$data = array(
			'from_date' => $this->input->post('from_date'),
			'to_date' => $this->input->post('to_date'),
			'location_id' => $this->input->post('location_id'),
			'employee_id' => $this->input->post('user_id'),
			'created_at' => date('d-m-Y'),
		);
		$result = $this->Employees_model->location_info_add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_location_info_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and add info in database // elocation info
	public function e_location_info() {
		if($this->input->post('type')=='e_location_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('from_date')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_frm_date');
			}elseif($this->input->post('location_id')==='') {
			 	$Return['error'] = $this->lang->line('error_location_dept_field');
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$data = array(
				'from_date' => $this->input->post('from_date'),
				'to_date' => $this->input->post('to_date')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->location_info_update($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_location_info_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and update info in database // change password
	public function change_password() {
		if($this->input->post('type')=='change_password') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(trim($this->input->post('new_password'))==='') {
     		 $Return['error'] = $this->lang->line('xin_employee_error_newpassword');
			}elseif(strlen($this->input->post('new_password')) < 6) {
				$Return['error'] = $this->lang->line('xin_employee_error_password_least');
			}elseif(trim($this->input->post('new_password_confirm'))==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_new_cpassword');
			}elseif($this->input->post('new_password')!=$this->input->post('new_password_confirm')) {
				 $Return['error'] = $this->lang->line('xin_employee_error_old_new_cpassword');
			}
			if($Return['error']!='')
     		$this->output($Return);
			$options = array('cost' => 12);
			$password_hash = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT, $options);
			$data = array(
				'password' => $password_hash
			);
			$id = $this->input->post('user_id');
			$result = $this->Employees_model->change_password($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_password_update');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	 /*  get all employee details lisitng *//////////////////
	// employee contacts - listing
	public function contacts() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$contacts = $this->Employees_model->set_employee_contacts($id);
		$data = array();
    foreach($contacts->result() as $r) {
			if($r->is_primary==1){
				$primary = '<span class="tag tag-success">'.ucfirst($this->lang->line('xin_employee_primary')).'</span>';
			 } else {
				 $primary = '';
			 }
			 if($r->is_dependent==2){
				$dependent = '<span class="tag tag-danger">'.ucfirst($this->lang->line('xin_employee_dependent')).'</span>';
			 } else {
				 $dependent = '';
			 }
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->contact_id . '" data-field_type="contact"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contact_id . '" data-token_type="contact"><i class="fa fa-trash-o"></i></button></span>',
				$r->contact_name,
				# luffy 7 January 2020 12:41 pm
				$primary . ' '.$dependent,
				$r->relation,
				$r->work_email,
				$r->mobile_phone
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contacts->num_rows(),
			 "recordsFiltered" => $contacts->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	// employee documents - listing
	public function documents() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$documents = $this->Employees_model->set_employee_documents($id);
		$data = array();
    foreach($documents->result() as $r) {
			// luffy start
			$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
			if(!is_null($d_type))
				$document_d = $d_type[0]->document_type;
			else $document_d = '--';
			// luffy end
			$date_of_expiry = $this->Xin_model->set_date_format($r->date_of_expiry);
			if($r->document_file!='' && $r->document_file!='no file')
				$downloadDocument = '<span data-toggle="tooltip" data-placement="top" title="Download"><a href="'.site_url().'admin/download?type=document&filename='.$r->document_file.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" title="'.$this->lang->line('xin_download').'"><i class="fa fa-download"></i></button></a></span>';
			else $downloadDocument ='';
			if($r->is_alert==1)
			  $notificationEmail = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_e_details_alert_notifyemail').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-bell"></i></button></span>';
			else $notificationEmail = '';
			// luffy document start
			$data[] = array(
				#$notificationEmail.
				# luffy 7 January 2020 03:39 pm | Remove the download document.
				// $downloadDocument,
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->document_id . '" data-field_type="document"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->document_id . '" data-token_type="document"><i class="fa fa-trash-o"></i></button></span>',
				$document_d,
				$r->title,
				$date_of_expiry
			);
			//luffy end
    }
	  $output = array(
	    "draw" => $draw,
		  "recordsTotal" => $documents->num_rows(),
		  "recordsFiltered" => $documents->num_rows(),
		  "data" => $data
		);
	  echo json_encode($output);
	  exit();
 	}
	//luffy start ajax sending email function
	function ajaxSendingEmail($emailTo){
		// load email library
		$this->load->library('email');
		$this->email->set_mailtype("html");
		//get company info
		$cinfo = $this->Xin_model->read_company_setting_info(1);
		//get email template
		$template = $this->Xin_model->read_email_template(8);
		$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
		$logo = base_url().'uploads/logo/signin/'.$company[0]->sign_in_logo;
		// get user full name
		#$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
		$full_name = 'testing full name';
		$message = '
		<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
		<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'">
		<br>'.str_replace(
			array("{var site_name}","{var site_url}","{var username}","{var employee_id}","{var employee_name}","{var email}","{var password}"),
			array($cinfo[0]->company_name,site_url(),$this->input->post('username'),$this->input->post('employee_id'),ucwords(strtolower($full_name)),$this->input->post('email'),$this->input->post('password')),
			htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
		$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
		$this->email->to($emailTo);
		$this->email->subject($subject);
		$this->email->message($message);
		if($this->email->send())
    return TRUE;
		else return FALSE; #show_error($this->email->print_debugger());
	}
	//luffy end ajax sending email function
 	// employee immigration - listing
	public function immigration() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$immigration = $this->Employees_model->set_employee_immigration($id);
		$data = array();
		// luffy
		$role_resources_ids = $this->Xin_model->user_role_resource();
    foreach($immigration->result() as $r){
			$issue_date = $this->Xin_model->set_date_format($r->issue_date);
			$expiry_date = $this->Xin_model->set_date_format($r->expiry_date);
			$eligible_review_date = $this->Xin_model->set_date_format($r->eligible_review_date);
			$d_type = $this->Employees_model->read_document_type_information($r->document_type_id);
			$documentFile=$r->document_file;
			if(!is_null($d_type))
				$documentType = $d_type[0]->document_type;
			else $documentType = '-';
			#luffy 5 January 2020 07:34 pm
			if(!is_null($r->document_number))
				$documentNumber = $r->document_number;
			else $documentNumber = '-';
			$country = $this->Xin_model->read_country_info($r->country_id);
			if(!is_null($country))
				$c_name = $country[0]->country_name;
			else $c_name = '--';
			// luffy
			if(in_array('2071',$role_resources_ids)) // update
				$edit = '
				<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'">
					<button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fa fa-pencil-square-o"></i></button>
				</span>';
			else $edit = '';
			if(in_array('2072',$role_resources_ids)) // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->immigration_id . '" data-token_type="imgdocument"><i class="fa fa-trash-o"></i></button></span>';
			else $delete = '';
			if(in_array('2073',$role_resources_ids)) //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-field_id="'. $r->immigration_id . '" data-field_type="imgdocument"><i class="fa fa-eye"></i></button></span>';
			else $view = '';
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$documentType,
				$documentNumber, #luffy 5 January 2020 07:34 pm
				$c_name,
				$issue_date,
				$expiry_date,
				$eligible_review_date
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $immigration->num_rows(),
			 "recordsFiltered" => $immigration->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// employee qualification - listing
	public function qualification() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$qualification = $this->Employees_model->set_employee_qualification($id);
		$data = array();
    foreach($qualification->result() as $r) {
			$education = $this->Employees_model->read_education_information($r->education_level_id);
			if(!is_null($education)){
				$edu_name = $education[0]->name;
			} else {
				$edu_name = '--';
			}
		//	$language = $this->Employees_model->read_qualification_language_information($r->language_id);

			/*if($r->skill_id == 'no course') {
				$ol = 'No Course';
			} else {
				$ol = '<ol class="nl">';
				foreach(explode(',',$r->skill_id) as $desig_id) {
					$skill = $this->Employees_model->read_qualification_skill_information($desig_id);
					$ol .= '<li>'.$skill[0]->name.'</li>';
				 }
				 $ol .= '</ol>';
			}*/
			$sdate = $this->Xin_model->set_date_format($r->from_year);
			$edate = $this->Xin_model->set_date_format($r->to_year);
			$time_period = $sdate.' - '.$edate;
			// get date
			$pdate = $time_period;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->qualification_id . '" data-field_type="qualification"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->qualification_id . '" data-token_type="qualification"><i class="fa fa-trash-o"></i></button></span>',
				$r->name,
				#$pdate,
				$edu_name
			);
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $qualification->num_rows(),
			 "recordsFiltered" => $qualification->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// employee work experience - listing
	public function experience() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$experience = $this->Employees_model->set_employee_experience($id);
		$data = array();
    foreach($experience->result() as $r) {
			$from_date = $this->Xin_model->set_date_format($r->from_date);
			$to_date = $this->Xin_model->set_date_format($r->to_date);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->work_experience_id . '" data-field_type="work_experience"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->work_experience_id . '" data-token_type="work_experience"><i class="fa fa-trash-o"></i></button></span>',
				$r->company_name,
				$from_date,
				$to_date,
				$r->post,
			);
		}
	  $output = array(
	   "draw" => $draw,
		 "recordsTotal" => $experience->num_rows(),
		 "recordsFiltered" => $experience->num_rows(),
		 "data" => $data
		);
	  echo json_encode($output);
	  exit();
   }
	// employee bank account - listing
	public function bank_account() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		 else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$bank_account = $this->Employees_model->set_employee_bank_account($id);
		$data = array();
    foreach($bank_account->result() as $r) {
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->bankaccount_id . '" data-field_type="bank_account"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankaccount_id . '" data-token_type="bank_account"><i class="fa fa-trash-o"></i></button></span>',
				$r->account_title,
				$r->account_number,
				$r->bank_name,
				$r->bank_code,
				$r->bank_branch
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $bank_account->num_rows(),
			 "recordsFiltered" => $bank_account->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// employee contract - listing
	public function contract() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		 else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$contract = $this->Employees_model->set_employee_contract($id);
		$data = array();
    foreach($contract->result() as $r) {
			// designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';
			}
			//contract type
			$contract_type = $this->Employees_model->read_contract_type_information($r->contract_type_id);
			if(!is_null($contract_type)){
				$ctype = $contract_type[0]->name;
			} else {
				$ctype = '--';
			}
			// date
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->contract_id . '" data-field_type="contract"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->contract_id . '" data-token_type="contract"><i class="fa fa-trash-o"></i></button></span>',
				$duration,
				$designation_name,
				$ctype,
				$r->title
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $contract->num_rows(),
			 "recordsFiltered" => $contract->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	// employee leave - listing
	public function leave() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$leave = $this->Employees_model->set_employee_leave($id);
		$data = array();
    foreach($leave->result() as $r) {
			// contract
			$contract = $this->Employees_model->read_contract_information($r->contract_id);
			if(!is_null($contract)){
				// contract duration
				$duration = $this->Xin_model->set_date_format($contract[0]->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($contract[0]->to_date);
				$ctitle = $contract[0]->title.' '.$duration;
			} else {
				$ctitle = '--';
			}
			$contracti = $ctitle;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->leave_id . '" data-field_type="leave"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->leave_id . '" data-token_type="leave"><i class="fa fa-trash-o"></i></button></span>',
				$contracti,
				$r->casual_leave,
				$r->medical_leave
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $leave->num_rows(),
			 "recordsFiltered" => $leave->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// employee office shift - listing
	public function shift() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$shift = $this->Employees_model->set_employee_shift($id);
		$data = array();
    foreach($shift->result() as $r) {
			// contract
			$shift_info = $this->Employees_model->read_shift_information($r->shift_id);
			// contract duration
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			if(!is_null($shift_info)){
				$shift_name = $shift_info[0]->shift_name;
			} else {
				$shift_name = '--';
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->emp_shift_id . '" data-field_type="shift"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->emp_shift_id . '" data-token_type="shift"><i class="fa fa-trash-o"></i></button></span>',
				$duration,
				$shift_name
			);
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $shift->num_rows(),
			 "recordsFiltered" => $shift->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
 }
	// employee location - listing
	public function location() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$location = $this->Employees_model->set_employee_location($id);
		$data = array();
    foreach($location->result() as $r) {
			// contract
			$of_location = $this->Location_model->read_location_information($r->location_id);
			// contract duration
			$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date);
			if(!is_null($of_location)){
				$location_name = $of_location[0]->location_name;
			} else {
				$location_name = '--';
			}
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->office_location_id . '" data-field_type="location"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->office_location_id . '" data-token_type="location"><i class="fa fa-trash-o"></i></button></span>',
				$duration,
				$location_name
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $location->num_rows(),
			 "recordsFiltered" => $location->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
 }
	// Validate and update info in database
	public function update() {
		if($this->input->post('edit_type')=='warning') {
		$id = $this->uri->segment(4);
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		if($this->input->post('warning_to')==='') {
   		 $Return['error'] = $this->lang->line('xin_employee_error_warning');
		}elseif($this->input->post('type')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_warning_type');
		}elseif($this->input->post('subject')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_subject');
		}elseif($this->input->post('warning_by')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_warning_by');
		}elseif($this->input->post('warning_date')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_warning_date');
		}
		if($Return['error']!='')
   		 $this->output($Return);
		$data = array(
			'warning_to' => $this->input->post('warning_to'),
			'warning_type_id' => $this->input->post('type'),
			'description' => $qt_description,
			'subject' => $this->input->post('subject'),
			'warning_by' => $this->input->post('warning_by'),
			'warning_date' => $this->input->post('warning_date'),
			'status' => $this->input->post('status'),
		);
		$result = $this->Warning_model->update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_warning_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// import > timesheet
	 public function import() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->lang->line('xin_import_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_import_employees');
		$data['path_url'] = 'import_employees';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('92',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/employees/employes_import", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
	// Validate and add info in database
	public function import_employees() {
		if($this->input->post('is_ajax')=='3') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		//validate whether uploaded file is a csv file
   		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		if($this->input->post('company_id')==='') {
			 $Return['error'] = $this->lang->line('error_company_field');
		}elseif($this->input->post('department_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_department');
		}elseif($this->input->post('subdepartment_id')==='') {
			 $Return['error'] = $this->lang->line('xin_hr_sub_department_field_error');
		}elseif($this->input->post('designation_id')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_designation');
		}elseif($this->input->post('role')==='') {
			 $Return['error'] = $this->lang->line('xin_employee_error_user_role');
		}elseif($_FILES['file']['name']==='') {
			$Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
		} else {
			if(in_array($_FILES['file']['type'],$csvMimes)){
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					// check file size
					if(filesize($_FILES['file']['tmp_name']) > 2000000) {
						$Return['error'] = $this->lang->line('xin_error_employees_import_size');
					} else {
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					//skip first line
					fgetcsv($csvFile);
					//parse data from csv file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
							$data = array(
								'company_id' => $this->input->post('company_id'),
								'department_id' =>$this->input->post('department_id'),
								'sub_department_id' =>$this->input->post('subdepartment_id'),
								'designation_id' => $this->input->post('designation_id'),
								'user_role_id' => $this->input->post('role'),
								'office_shift_id' => 1,
								'is_active' => 1,
								'first_name' => $line[0],
								'last_name' => $line[1],
								'username' => $line[2],
								'email' => $line[3],
								'password' => $line[4],
								'employee_id' => $line[5],
								'date_of_joining' => $line[6],
								'gender' => $line[7],
								'date_of_birth' => $line[8],
								'contact_no' => $line[9],
								'address' => $line[10],
								'created_at' => date('Y-m-d h:i:s')
							);
							$result = $this->Employees_model->add($data);
						}
						//close opened csv file
						fclose($csvFile);
						$Return['result'] = $this->lang->line('xin_success_attendance_import');
					}
				}else{
					$Return['error'] = $this->lang->line('xin_error_not_employee_import');
				}
			}else{
				$Return['error'] = $this->lang->line('xin_error_invalid_file');
			}
		} // file empty
		if($Return['error']!=''){
   		$this->output($Return);
  	}
		$this->output($Return);
		exit;
		}
	}
	// delete contact record
	public function delete_contact() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_contact_record($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_contact_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete document record
	public function delete_document() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Employees_model->delete_document_record($id);
			if(isset($id))
				$Return['result'] = $this->lang->line('xin_employee_document_deleted');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
		}
	}
	// delete document record
	public function delete_imgdocument() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_imgdocument_record($id);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_img_document_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete qualification record
	public function delete_qualification() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_qualification_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_qualification_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete work_experience record
	public function delete_work_experience() {
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_work_experience_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_work_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete bank_account record
	public function delete_bank_account() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_bank_account_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_bankaccount_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete contract record
	public function delete_contract() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_contract_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_contract_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete leave record
	public function delete_leave() {
		if($this->input->post('data')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_leave_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_leave_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete shift record
	public function delete_shift() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_shift_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_shift_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete location record
	public function delete_location() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_location_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_location_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete employee record
	public function delete() {
		if($this->input->post('is_ajax')=='2') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_current_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	//luffy restore employee
	public function restore(){
		if($this->input->post('is_ajax')==2) {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Employees_model->restore($id);
			if(isset($id))
				$Return['result'] = 'Employee restored.';
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
		}
	}
	// Validate and update info in database // basic info
	public function update_salary_option() {
		if($this->input->post('type')=='employee_update_salary') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('wages_type')=='1') {
			if($this->input->post('basic_salary')==='') {
				$Return['error'] = $this->lang->line('xin_employee_salary_error_basic');
			}
		}elseif($this->input->post('wages_type')=='2') {
			 if($this->input->post('daily_wages')==='') {
				$Return['error'] = $this->lang->line('xin_employee_salary_error_daily');
			}
		}
		if($Return['error']!=''){
			$this->output($Return);
		}
		$data = array(
		'wages_type' => $this->input->post('wages_type'),
		'basic_salary' => $this->input->post('basic_salary'),
		'daily_wages' => $this->input->post('daily_wages')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_salary_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function set_overtime() {
		if($this->input->post('type')=='emp_overtime') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('overtime_type')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_title_error');
		}elseif($this->input->post('no_of_days')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_no_of_days_error');
		}elseif($this->input->post('overtime_hours')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_hours_error');
		}elseif($this->input->post('overtime_rate')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_rate_error');
		}
		if($Return['error']!='')
			$this->output($Return);
		$data = array(
			'employee_id' => $this->input->post('user_id'),
			'overtime_type' => $this->input->post('overtime_type'),
			'no_of_days' => $this->input->post('no_of_days'),
			'overtime_hours' => $this->input->post('overtime_hours'),
			'overtime_rate' => $this->input->post('overtime_rate')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->add_salary_overtime($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_added_overtime_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function update_overtime_info() {
		if($this->input->post('type')=='e_overtime_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('overtime_type')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_title_error');
		}elseif($this->input->post('no_of_days')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_no_of_days_error');
		}elseif($this->input->post('overtime_hours')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_hours_error');
		}elseif($this->input->post('overtime_rate')==='') {
			$Return['error'] = $this->lang->line('xin_employee_set_overtime_rate_error');
		}
		if($Return['error']!='')
			$this->output($Return);
		$id = $this->input->post('e_field_id');
		$data = array(
			'overtime_type' => $this->input->post('overtime_type'),
			'no_of_days' => $this->input->post('no_of_days'),
			'overtime_hours' => $this->input->post('overtime_hours'),
			'overtime_rate' => $this->input->post('overtime_rate')
		);
		//$id = $this->input->post('user_id');
		$result = $this->Employees_model->salary_overtime_update_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_overtime_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// luffy 29 nov 2019 - 5:36 pm
	// all adjustment (+)
	public function salary_all_allowances() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$allowances = $this->Employees_model->set_employee_allowances($id);
		$data = array();
		/*$system = $this->Xin_model->read_setting_info(1);
		$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
    foreach($allowances->result() as $r) {
			//$current_amount = $r->allowance_amount * $current_rate;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'">
					<button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->allowance_id . '" data-field_type="salary_allowance"><span class="fa fa-pencil"></span></button>
				</span>
				<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'">
					<button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->allowance_id . '" data-token_type="all_allowances"><span class="fa fa-trash"></span></button>
				</span>',
				$r->allowance_title,
				$r->allowance_amount
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $allowances->num_rows(),
			 "recordsFiltered" => $allowances->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// luffy 29 nov 2019 - 5:36 pm
	// add adjustment (+)
	public function employee_allowance_option() {
		if($this->input->post('type')=='employee_update_allowance') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('allowance_title')==='') {
				$Return['error'] = 'Title field is required';
			}elseif($this->input->post('allowance_amount')==='') {
				$Return['error'] = 'Amount field is required';
			}
			if($Return['error']!='')
				$this->output($Return);
			$data = array(
				'allowance_title' => $this->input->post('allowance_title'),
				'allowance_amount' => $this->input->post('allowance_amount'),
				'employee_id' => $this->input->post('user_id')
			);
			$result = $this->Employees_model->add_alary_allowances($data);
			if ($result == TRUE) {
				$Return['result'] = 'Adjustment(+) added';
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// luffy 29 nov 2019 - 5:36 pm
	// update adjustment (+)
	public function update_allowance_info() {
		if($this->input->post('type')=='e_allowance_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('allowance_title')==='') {
				$Return['error'] = $this->lang->line('xin_employee_set_allowance_title_error');
			}elseif($this->input->post('allowance_amount')==='') {
			  $Return['error'] = $this->lang->line('xin_employee_set_allowance_amount_error');
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$data = array(
				'allowance_title' => $this->input->post('allowance_title'),
				'allowance_amount' => $this->input->post('allowance_amount')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->salary_allowance_update_record($data,$e_field_id);
			if ($result == TRUE) {
				$Return['result'] = 'Adjustment(+) updated';
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// luffy 29 nov 2019 - 5:37 pm
	// del adjustment (+)
	public function delete_all_allowances() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_allowance_record($id);
			if(isset($id)) {
				$Return['result'] = 'Adjustment(+) deleted';
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function dialog_salary_allowance() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_single_salary_allowance($id);
		$data = array(
			'allowance_id' => $result[0]->allowance_id,
			'employee_id' => $result[0]->employee_id,
			'allowance_title' => $result[0]->allowance_title,
			'allowance_amount' => $result[0]->allowance_amount
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}

	// luffy 29 nov 2019 - 08:17 pm
	// for all adjustment minus list
	public function all_adjustment_minus() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$userId = $this->uri->segment(4);
		$allowances = $this->Employees_model->all_adjustment_minus($userId);
		$data = array();
    foreach($allowances->result() as $r) {
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->adjustment_minus_id . '" data-field_type="adjustment_minus"><span class="fa fa-pencil"></span></button></span>
				<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->adjustment_minus_id . '" data-token_type="all_adjustment_minus"><span class="fa fa-trash"></span></button></span>',
				$r->adjustment_minus_title,
				$r->adjustment_minus_amount
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $allowances->num_rows(),
			 "recordsFiltered" => $allowances->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// luffy 29 nov 2019 - 5:39 pm
	// add adjustment (-)
	public function add_adjustment_minus() {
		if($this->input->post('type')=='employee_add_adjustment_minus') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('adjustment_min_title')==='') {
				$Return['error'] = 'Title field is required for Adjustment(-)';
			}elseif($this->input->post('adjustment_min_amount')==='') {
				$Return['error'] = 'Amount field is required for Adjustment(-)';
			}elseif($this->input->post('adjustment_min_amount')===0) {
				$Return['error'] = 'Amount field can not 0 (zero) for Adjustment(-)';
			}
			if($Return['error']!='')
				$this->output($Return);
			$data = array(
				'adjustment_minus_title' => $this->input->post('adjustment_min_title'),
				'adjustment_minus_amount' => $this->input->post('adjustment_min_amount'),
				'employee_id' => $this->input->post('user_id')
			);
			$result = $this->Employees_model->add_adjustment_minus($data);
			if ($result == TRUE)
				$Return['result'] = 'Adjustment(-) added';
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// luffy 29 nov 2019 - 5:39 pm
	// add adjustment (-)
	public function update_adjustment_minus() {
		if($this->input->post('type')=='e_adjustment_minus') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('adjustment_min_title')==='') {
				$Return['error'] = 'Title field is required for Adjustment(-)';
			}elseif($this->input->post('adjustment_min_amount')==='') {
				$Return['error'] = 'Amount field is required for Adjustment(-)';
			}elseif($this->input->post('adjustment_min_amount')===0) {
				$Return['error'] = 'Amount field can not 0 (zero) for Adjustment(-)';
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$data = array(
				'adjustment_minus_title' => $this->input->post('adjustment_min_title'),
				'adjustment_minus_amount' => $this->input->post('adjustment_min_amount')
			);
			$e_field_id = $this->input->post('e_field_id');
			$result = $this->Employees_model->update_adjustment_minus($data,$e_field_id);
			if ($result == TRUE)
				$Return['result'] = 'Adjustment(-) updated';
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// luffy 29 nov 2019 - 5:39 pm
	// del adjustment (-)
	public function delete_all_adjustment_minus() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->del_adjustment_minus($id);
			if(isset($id)) {
				$Return['result'] = 'Adjustment(-) deleted';
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function dialog_adjustment_minus() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('field_id');
		$result = $this->Employees_model->read_adjustment_minus($id);
		$data = array(
			'adjusmentMinusId' => $result[0]->adjustment_minus_id,
			'employee_id' => $result[0]->employee_id,
			'adjustment_min_title' => $result[0]->adjustment_minus_title,
			'adjustment_min_amount' => $result[0]->adjustment_minus_amount
		);
		if(!empty($session))
			$this->load->view('admin/employees/dialog_employee_details', $data);
		else redirect('admin/');
	}

	// delete location record
	public function delete_all_deductions() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_loan_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_loan_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete location record
	public function delete_emp_overtime() {
		if($this->input->post('data')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			$result = $this->Employees_model->delete_overtime_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_employee_delete_overtime_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}

	 // employee overtime
	public function salary_overtime() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$overtime = $this->Employees_model->set_employee_overtime($id);
		$system = $this->Xin_model->read_setting_info(1);
		$data = array();
    foreach($overtime->result() as $r) {
			$current_amount = $r->overtime_rate;
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->salary_overtime_id . '" data-field_type="emp_overtime"><span class="fa fa-pencil"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->salary_overtime_id . '" data-token_type="emp_overtime"><span class="fa fa-trash"></span></button></span>',
				$r->overtime_type,
				$r->no_of_days,
				$r->overtime_hours,
				$current_amount
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $overtime->num_rows(),
			 "recordsFiltered" => $overtime->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	 // employee salary_all_deductions
	public function salary_all_deductions() {
		//set data
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/employees/employee_detail", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$deductions = $this->Employees_model->set_employee_deductions($id);
		/*$system = $this->Xin_model->read_setting_info(1);
		$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);
		if(!is_null($default_currency)) {
			$current_rate = $default_currency[0]->to_currency_rate;
			$current_title = $default_currency[0]->to_currency_title;
		} else {
			$current_rate = 1;
			$current_title = 'USD';
		}*/
		$data = array();
    foreach($deductions->result() as $r) {
			$sdate = $this->Xin_model->set_date_format($r->start_date);
			$edate = $this->Xin_model->set_date_format($r->end_date);
			// loan time
			if($r->loan_time < 2) {
				$loan_time = $r->loan_time. ' '.$this->lang->line('xin_employee_loan_time_single_month');
			} else {
				$loan_time = $r->loan_time. ' '.$this->lang->line('xin_employee_loan_time_more_months');
			}
			//$current_amount = $r->monthly_installment * $current_rate;
			//$eoption_removed = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->loan_deduction_id . '" data-field_type="salary_loan"><span class="fas fa-pencil-alt"></span></button></span>';
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->loan_deduction_id . '" data-token_type="all_deductions"><span class="fa fa-trash"></span></button></span>',
				$r->loan_deduction_title,
				$r->monthly_installment,
				$sdate,
				$edate,
				$loan_time
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deductions->num_rows(),
			 "recordsFiltered" => $deductions->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
 	}
	 // Validate and add info in database
	public function update_loan_info() {
		if($this->input->post('type')=='loan_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$id = $this->input->post('e_field_id');
			if($this->input->post('loan_deduction_title')==='') {
				$Return['error'] = $this->lang->line('xin_employee_set_loan_title_error');
			}elseif($this->input->post('monthly_installment')==='') {
				$Return['error'] = $this->lang->line('xin_employee_set_mins_title_error');
			}elseif($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_start_date');
			}elseif($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_end_date');
			}elseif($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('xin_error_start_end_date');
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$data = array(
				'loan_deduction_title' => $this->input->post('loan_deduction_title'),
				'reason' => $qt_reason,
				'monthly_installment' => $this->input->post('monthly_installment'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date')
			);
			$result = $this->Employees_model->salary_loan_update_record($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_update_loan_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	 // Validate and add info in database
	public function employee_loan_info() {
		if($this->input->post('type')=='loan_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$reason = $this->input->post('reason');
			$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$st_date = strtotime($start_date);
			$ed_date = strtotime($end_date);
			$user_id = $this->input->post('user_id');
			if($this->input->post('loan_deduction_title')==='') {
				$Return['error'] = $this->lang->line('xin_employee_set_loan_title_error');
			}elseif($this->input->post('monthly_installment')==='') {
				$Return['error'] = $this->lang->line('xin_employee_set_mins_title_error');
			}elseif($this->input->post('start_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_start_date');
			}elseif($this->input->post('end_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_end_date');
			}elseif($st_date > $ed_date) {
				$Return['error'] = $this->lang->line('xin_error_start_end_date');
			}
			if($Return['error']!='')
	   		$this->output($Return);
			$tm = $this->Employees_model->get_month_diff($this->input->post('start_date'),$this->input->post('end_date'));
			if($tm < 1) {
				$m_ins = $this->input->post('monthly_installment');
			} else {
				$m_ins = $this->input->post('monthly_installment')/$tm;
			}
			$data = array(
				'loan_deduction_title' => $this->input->post('loan_deduction_title'),
				'reason' => $qt_reason,
				'monthly_installment' => $this->input->post('monthly_installment'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'loan_time' => $tm,
				'loan_deduction_amount' => $m_ins,
				'employee_id' => $user_id
			);
			$result = $this->Employees_model->add_salary_loan($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_add_loan_success');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and update info in database // basic info
	public function set_statutory_deductions() {
		if($this->input->post('type')=='statutory_info') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$data = array(
			'salary_ssempee' => $this->input->post('salary_ssempee'),
			'salary_ssempeer' => $this->input->post('salary_ssempeer'),
			'salary_income_tax' => $this->input->post('salary_income_tax')
		);
		$id = $this->input->post('user_id');
		$result = $this->Employees_model->basic_info($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_employee_updated_statutory_deductions');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database // basic info
	public function set_other_payments() {
		if($this->input->post('type')=='other_payments') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$data = array(
				'salary_commission' => $this->input->post('salary_commission'),
				'salary_claims' => $this->input->post('salary_claims'),
				'salary_paid_leave' => $this->input->post('salary_paid_leave'),
				'salary_director_fees' => $this->input->post('salary_director_fees'),
				'salary_advance_paid' => $this->input->post('salary_advance_paid')
			);
			$id = $this->input->post('user_id');
			$result = $this->Employees_model->basic_info($data,$id);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_employee_updated_other_pay');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}
