<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaints extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Complaints_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		# luffy 1 January 2020 05:02 pm
		$this->load->model('Employees_model');
		// $this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
	}

	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	 public function index(){
			$session = $this->session->userdata('username');
			if(empty($session))
				redirect('admin/');
			$data['title'] = $this->lang->line('left_complaints').' | '.$this->Xin_model->site_title();
			$data['all_employees'] = $this->Xin_model->all_employees();
			$data['get_all_companies'] = $this->Xin_model->get_companies();
			$data['breadcrumbs'] = $this->lang->line('left_complaints');
			$data['path_url'] = 'complaints';
			$role_resources_ids = $this->Xin_model->user_role_resource();
			if(in_array('19',$role_resources_ids)) {
				if(!empty($session)){
					$data['subview'] = $this->load->view("admin/complaints/complaint_list", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard');
			}
    }

    public function complaint_list(){
			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session))
				$this->load->view("admin/complaints/complaint_list", $data);
			else redirect('admin/');
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$complaint = $this->Complaints_model->get_complaints();
			$role_resources_ids = $this->Xin_model->user_role_resource();
			$data = array();
	    foreach($complaint->result() as $r) {
				if(in_array('376',$role_resources_ids)) {
					 $aim = explode(',',$r->complaint_against);
					 foreach($aim as $dIds) {
						 if($session['user_id'] == $dIds) {
							// get user > added by
							$user = $this->Xin_model->read_user_info($r->complaint_from);
							// user full name
							if(!is_null($user)){
								# luffy 1 January 2020 04:34 pm
								// $complaint_from = $user[0]->first_name.' '.$user[0]->last_name.'<br />('.$user[0]->fingerprint_location.')';
								$complaint_from = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$complaint_from = '--';
							}
							if($r->complaint_against == '') {
								$ol = '--';
							} else {
								$ol = '<ol class="nl">';
								foreach(explode(',',$r->complaint_against) as $desig_id) {
									$_comp_name = $this->Xin_model->read_user_info($desig_id);
									if(!is_null($_comp_name)){
										# luffy 1 Jan 2020 04:37 pm
										// $ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name.' ('.$_comp_name[0]->fingerprint_location.')</li>';
										$ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name;
									} else {
										$ol .= '';
									}
								 }
								 $ol .= '</ol>';
							}
							// get complaint date
							$complaint_date = $this->Xin_model->set_date_format($r->complaint_date);
							if(in_array('223',$role_resources_ids)) { // update
								$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-complaint_id="'. $r->complaint_id . '"><span class="fa fa-pencil"></span></button></span>';
							} else {
								$edit = '';
							}
							if(in_array('224',$role_resources_ids)) { // delete
								$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->complaint_id . '">
								<span class="fa fa-trash"></span></button></span>';
							} else {
								$delete = '';
							}
							if(in_array('237',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-complaint_id="'. $r->complaint_id . '"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';
							}
							// get status
							switch($r->status){
								case 1:
									$status='Pending'; break;
								case 2:
									$status='Accepted'; break;
								case 3:
									$status='Rejected'; break;
								case 4:
									$status='Solved'; break;
								default:
									$status='Pending';
							}
							$combhr = $edit.$view.$delete;
							$data[] = array(
								$combhr,
								$complaint_from,
								$ol,
								$comp_name,
								$r->title,
								$complaint_date,
								$status
							);
						 }
					}
				} else {
					// get user > added by
					$user = $this->Xin_model->read_user_info($r->complaint_from);
					// user full name
					if(!is_null($user)){
						# luffy 1 January 2020 04:49 pm
						// $complaint_from = $user[0]->first_name.' '.$user[0]->last_name.'<br />('.$user[0]->fingerprint_location.')';
						$complaint_from = $user[0]->first_name.' '.$user[0]->last_name;
					} else {
						$complaint_from = '--';
					}

					if($r->complaint_against == '') {
						$ol = '--';
					} else {
						$ol = '<ol class="nl">';
						foreach(explode(',',$r->complaint_against) as $desig_id) {
							$_comp_name = $this->Xin_model->read_user_info($desig_id);
							if(!is_null($_comp_name)){
								# luffy 1 January 2020 04:49 pm
								// $ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name.' ('.$_comp_name[0]->fingerprint_location.')</li>';
								$ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name;
							} else {
								$ol .= '';
							}
						 }
						 $ol .= '</ol>';
					}
					// get complaint date
					$complaint_date = $this->Xin_model->set_date_format($r->complaint_date);
					if(in_array('223',$role_resources_ids)) { // update
						$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-complaint_id="'. $r->complaint_id . '"><span class="fa fa-pencil"></span></button></span>';
					} else {
						$edit = '';
					}
					if(in_array('224',$role_resources_ids)) { // delete
						$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->complaint_id . '">
						<span class="fa fa-trash"></span></button></span>';
					} else {
						$delete = '';
					}
					if(in_array('237',$role_resources_ids)) { //view
						$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-complaint_id="'. $r->complaint_id . '"><span class="fa fa-eye"></span></button></span>';
					} else {
						$view = '';
					}
					// get company
					$company = $this->Xin_model->read_company_info($r->company_id);
					if(!is_null($company)){
						$comp_name = $company[0]->name;
					} else {
						$comp_name = '--';
					}
					/// get status
					switch($r->status){
						case 1:
							$status='Pending'; break;
						case 2:
							$status='Accepted'; break;
						case 3:
							$status='Rejected'; break;
						case 4:
							$status='Solved'; break;
						default:
							$status='Pending';
					}
					$combhr = $edit.$view.$delete;
						$data[] = array(
						$combhr,
						$complaint_from,
						$ol,
						$comp_name,
						$r->title,
						$complaint_date,
						$status
					);
				}
	    }
		  $output = array(
			   "draw" => $draw,
				 "recordsTotal" => $complaint->num_rows(),
				 "recordsFiltered" => $complaint->num_rows(),
				 "data" => $data
			);
		  echo json_encode($output);
		  exit();
   }

	 public function read(){
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('complaint_id');
		$result = $this->Complaints_model->read_complaint_information($id);
		$status=$result[0]->status;
		switch($status){
			case 1:
				$complaintStatus='Pending'; break;
			case 2:
				$complaintStatus='Accepted'; break;
			case 3:
				$complaintStatus='Rejected'; break;
			case 4:
				$complaintStatus='Solved'; break;
			default:
				$complaintStatus='Pending';
		}
		$data = array(
			'complaint_id' => $result[0]->complaint_id,
			'company_id' => $result[0]->company_id,
			'complaint_from' => $result[0]->complaint_from,
			'title' => $result[0]->title,
			'complaint_date' => $result[0]->complaint_date,
			'complaint_against' => $result[0]->complaint_against,
			'description' => $result[0]->description,
			'companyResponse' => $result[0]->company_response,
			'status' => $result[0]->status,
			'complaintStatus' => $complaintStatus,
			'all_employees' => $this->Xin_model->all_employees(),
			'get_all_companies' => $this->Xin_model->get_companies()
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view('admin/complaints/dialog_complaint', $data);
		else redirect('admin/');
	}

	// get company > employees
	public function get_employees() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/complaints/get_employees", $data);
	  else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 // get company > employees
	 public function get_complaint_employees() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/complaints/get_complaint_employees", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	}
	public function add_complaint() {
		if($this->input->post('add_type')=='complaint') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('company_id')==='') {
				 $Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('employee_id')==='') {
	   		 $Return['error'] = $this->lang->line('xin_error_complaint_from');
			}elseif($this->input->post('title')==='') {
				$Return['error'] = $this->lang->line('xin_error_complaint_title');
			}elseif($this->input->post('complaint_date')==='') {
				 $Return['error'] = $this->lang->line('xin_error_complaint_date');
			}elseif($this->input->post('complaint_against')==='') {
				 $Return['error'] = $this->lang->line('xin_error_complaint_against');
			}
			if($Return['error']!=''){
	    	$this->output($Return);
	  	}
			$complaint_against_ids = implode(',',$this->input->post('complaint_against'));
			$data = array(
				'complaint_from' => $this->input->post('employee_id'),
				'company_id' => $this->input->post('company_id'),
				'title' => $this->input->post('title'),
				'description' => $qt_description,
				'complaint_date' => $this->input->post('complaint_date'),
				'complaint_against' => $complaint_against_ids,
				'created_at' => date('d-m-Y'),
			);
			$result = $this->Complaints_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_complaint_added');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	// Validate and update info in database
	public function update() {
		if($this->input->post('edit_type')=='complaint') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('employee_id')==='') {
	   		 $Return['error'] = $this->lang->line('xin_error_complaint_from');
			}elseif($this->input->post('title')==='') {
				 $Return['error'] = $this->lang->line('xin_error_complaint_title');
			}elseif($this->input->post('complaint_date')==='') {
				 $Return['error'] = $this->lang->line('xin_error_complaint_date');
			}elseif($this->input->post('complaint_against')==='') {
				 $Return['error'] = $this->lang->line('xin_error_complaint_against');
			}
			if($Return['error']!='')
	    	$this->output($Return);
			$complaint_against_ids = implode(',',$this->input->post('complaint_against'));
			$data = array(
				'complaint_from' => $this->input->post('employee_id'),
				'company_id' => $this->input->post('company_id'),
				'title' => $this->input->post('title'),
				'description' => $qt_description,
				'complaint_date' => $this->input->post('complaint_date'),
				'complaint_against' => $complaint_against_ids,
				'status' => $this->input->post('status'),
				'company_response' => $this->input->post('company_response'),
			);
			$result = $this->Complaints_model->update_record($data,$id);
			if ($result == TRUE)
				$Return['result'] = $this->lang->line('xin_success_complaint_updated');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}

	public function delete() {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Complaints_model->delete_record($id);
		if(isset($id))
			$Return['result'] = $this->lang->line('xin_success_complaint_deleted');
		else $Return['error'] = $this->lang->line('xin_error_msg');
		$this->output($Return);
	}
}
