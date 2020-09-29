<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Promotion_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");	// luffy
		# luffy 9 January 2020 06:27 pm
		$this->load->model("Employees_model");
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

	 public function index() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_promotions').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_promotions');
		$data['path_url'] = 'promotion';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('18',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/promotion/promotion_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

    public function promotion_list() {
			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session)){
				$this->load->view("admin/promotion/promotion_list", $data);
			} else {
				redirect('admin/');
			}
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$role_resources_ids = $this->Xin_model->user_role_resource();
			if(in_array('375',$role_resources_ids)) {
				$promotion = $this->Promotion_model->get_employee_promotions($session['user_id']);
			} else {
				$promotion = $this->Promotion_model->get_promotions();
			}
			$data = array();
	    foreach($promotion->result() as $r) {
				// get user > employee_
				$employee = $this->Xin_model->read_user_info($r->employee_id);
				// employee full name
				if(!is_null($employee)){
					$employee_name = $employee[0]->first_name.' '.$employee[0]->last_name;
					$location = $employee[0]->fingerprint_location;
				} else {
					$employee_name = '--';
					$location = 'X';
				}
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';
				}
				// get promotion date
				$promotion_date = $this->Xin_model->set_date_format($r->promotion_date);
				if(in_array('220',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-pencil"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('221',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->promotion_id . '"><span class="fa fa-trash"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('236',$role_resources_ids)) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-promotion_id="'. $r->promotion_id . '"><span class="fa fa-eye"></span></button></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$view.$delete;

				// luffy
				$titleName = $this->Designation_model->getTitle($r->title);

				$data[] = array(
					$combhr,
					$employee_name,
					$location,
					// $comp_name,
					$titleName[0]->designation_name,
					$promotion_date
				);
	    }

		  $output = array(
			   "draw" => $draw,
				 "recordsTotal" => $promotion->num_rows(),
				 "recordsFiltered" => $promotion->num_rows(),
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
			$this->load->view("admin/promotion/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 // luffy
	 public function designation() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/promotion/get_designations", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 public function read() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('promotion_id');
		$result = $this->Promotion_model->read_promotion_information($id);
		$titleName = $this->Designation_model->getTitle($result[0]->title); // luffy
		$designations = $this->Designation_model->ajax_company_designation_info($result[0]->company_id); // luffy
		$data = array(
			'promotion_id' => $result[0]->promotion_id,
			'company_id' => $result[0]->company_id,
			'employee_id' => $result[0]->employee_id,
			// luffy
			'title' => $titleName[0]->designation_name,
			'title_id' => $result[0]->title,
			'designations' => $designations,
			// luffy
			'promotion_date' => $result[0]->promotion_date,
			'description' => $result[0]->description,
			'get_all_companies' => $this->Xin_model->get_companies(),
			# luffy 9 January 2020 06:28 pm
			// 'all_employees' => $this->Xin_model->all_employees()
			'all_employees' => $this->Employees_model->employeeActiveAPG()->result()
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view('admin/promotion/dialog_promotion', $data);
		} else {
			redirect('admin/');
		}
	}

	// Validate and add info in database
	public function add_promotion() {

		if($this->input->post('add_type')=='promotion') {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
    	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('promotion_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_promotion_date');
		}

		if($Return['error']!=''){
    	$this->output($Return);
  	}

		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'title' => $this->input->post('title'),
		'promotion_date' => $this->input->post('promotion_date'),
		'description' => $qt_description,
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),

		);
		$result = $this->Promotion_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_promotion_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}

	// Validate and update info in database
	public function update() {

		if($this->input->post('edit_type')=='promotion') {

		$id = $this->uri->segment(4);

		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();

		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);

		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
       		 $Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('title')==='') {
			$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('promotion_date')==='') {
			 $Return['error'] = $this->lang->line('xin_error_promotion_date');
		}

		if($Return['error']!=''){
    	$this->output($Return);
  	}

		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company_id'),
		'title' => $this->input->post('title'),
		'promotion_date' => $this->input->post('promotion_date'),
		'description' => $qt_description,
		);

		$result = $this->Promotion_model->update_record($data,$id);

		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_promotion_updated');
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
		$result = $this->Promotion_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_promotion_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}