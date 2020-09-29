<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Roles_model");
		$this->load->model("Xin_model");
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

	  public function index(){
			$data['title'] = $this->lang->line('xin_role_urole').' | '.$this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(empty($session))
				redirect('admin/');
			$data['breadcrumbs'] = $this->lang->line('xin_role_urole');
			$data['path_url'] = 'roles';
			$data['get_all_companies'] = $this->Xin_model->get_companies();
			$user = $this->Xin_model->read_employee_info($session['user_id']);
			$userRole=$user[0]->user_role_id;
			$data['userRole']=$userRole;
			if($userRole==1){
				if(!empty($session)){
					$data['subview'] = $this->load->view("admin/roles/role_list", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				}else{
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard');
			}
    }
    public function role_list(){
			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session))
				$this->load->view("admin/roles/role_list", $data);
		  else redirect('admin/');
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$role = $this->Roles_model->get_user_roles();
			$data = array();
    	foreach($role->result() as $r) {
				if($r->role_access==1): $r_access = $this->lang->line('xin_role_all_menu');
				elseif($r->role_access==2): $r_access = $this->lang->line('xin_role_cmenu'); endif;
				$created_at = $this->Xin_model->set_date_format($r->created_at);
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';
				}
				// NO delete when SOP Roles: Admin, Manager, Supervisor, & User.
				if($r->role_id==1||$r->role_id==2||$r->role_id==3||$r->role_id==4){
					$roleAccess='<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-role_id="'. $r->role_id . '"><span class="fa fa-pencil"></span></button></span>';
				} else {
					$roleAccess='
					<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-role_id="'. $r->role_id . '"><span class="fa fa-pencil"></span></button></span>
					<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->role_id . '"><span class="fa fa-trash"></span></button></span>';
				}
		    $data[] = array(
					$roleAccess,
					#$r->role_id,
					$r->role_name,
					$r_access,
					$comp_name,
					#$created_at
		    );
      }
      $output = array(
	     	"draw" => $draw,
	      "recordsTotal" => $role->num_rows(),
	      "recordsFiltered" => $role->num_rows(),
	      "data" => $data
      );
      echo json_encode($output);
      exit();
   }
	public function read(){
		$data['title'] = $this->Xin_model->site_title();
		$roleIdCurrent = $this->input->get('role_id');
$roleId = $roleIdCurrent;
if ($roleIdCurrent == 4) { // role User
    $roleArr = $this->Roles_model->read_role_information(4);
    $result = $roleArr;
    $roleResources = $result[0]->role_resources;
    $data = array(
        'role_id' => $result[0]->role_id,
        'company_id' => $result[0]->company_id,
        'role_name' => $result[0]->role_name,
        'role_access' => $result[0]->role_access,
        'role_resources' => $roleResources,
        'currentRoleResourcesUser' => '',
        'currentRoleResourcesSupervisor' => '',
        'get_all_companies' => $this->Xin_model->get_companies(),
    );
} elseif ($roleIdCurrent == 3) { // role Supervisor
    $roleUserArr = $this->Roles_model->read_role_information(4);
    $roleSupervisorArr = $this->Roles_model->read_role_information(3);
    $result = array_merge($roleUserArr, $roleSupervisorArr);
    $roleResources = $result[0]->role_resources . ',' . $result[1]->role_resources;
    $data = array(
        'role_id' => $result[1]->role_id,
        'company_id' => $result[1]->company_id,
        'role_name' => $result[1]->role_name,
        'role_access' => $result[1]->role_access,
        'role_resources' => $roleResources,
        'currentRoleResourcesUser' => $result[0]->role_resources,
        'currentRoleResourcesSupervisor' => '',
        'get_all_companies' => $this->Xin_model->get_companies(),
    );
} elseif ($roleIdCurrent == 2) { // role Manager
    $roleUserArr = $this->Roles_model->read_role_information(4);
    $roleSupervisorArr = $this->Roles_model->read_role_information(3);
    $roleManagerArr = $this->Roles_model->read_role_information(2);
    $result = array_merge($roleUserArr, $roleSupervisorArr, $roleManagerArr);
    $roleResources = $result[0]->role_resources . ',' . $result[1]->role_resources . ',' . $result[2]->role_resources;
    $data = array(
        'role_id' => $result[2]->role_id,
        'company_id' => $result[2]->company_id,
        'role_name' => $result[2]->role_name,
        'role_access' => $result[2]->role_access,
        'role_resources' => $roleResources,
        'currentRoleResourcesUser' => $result[0]->role_resources,
        'currentRoleResourcesSupervisor' => $result[1]->role_resources,
        'get_all_companies' => $this->Xin_model->get_companies(),
    );
} else {
    $roleArr = $this->Roles_model->read_role_information($roleIdCurrent);
    $result = $roleArr;
    $roleResources = $result[0]->role_resources;
    $data = array(
        'role_id' => $result[0]->role_id,
        'company_id' => $result[0]->company_id,
        'role_name' => $result[0]->role_name,
        'role_access' => $result[0]->role_access,
        'role_resources' => $roleResources,
        'currentRoleResourcesUser' => '',
        'currentRoleResourcesSupervisor' => '',
        'get_all_companies' => $this->Xin_model->get_companies(),
    );
}

		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view('admin/roles/dialog_role', $data);
		else redirect('admin/');
	}
	public function add_role() {
		if($this->input->post('add_type')=='role') {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('role_name')==='') {
       $Return['error'] = $this->lang->line('xin_role_error_role_name');
		}elseif($this->input->post('company_id')==='') {
			 $Return['error'] = $this->lang->line('error_company_field');
		}elseif($this->input->post('role_access')==='') {
			 $Return['error'] = $this->lang->line('xin_role_error_access');
		}
		$role_resources = implode(',',$this->input->post('role_resources'));
		if($Return['error']!='')
    	$this->output($Return);
		$data = array(
			'role_name' => $this->input->post('role_name'),
			'company_id' => $this->input->post('company_id'),
			'role_access' => $this->input->post('role_access'),
			'role_resources' => $role_resources,
			#'created_at' => date('d-m-Y'),
		);
		$result = $this->Roles_model->add($data);
		if ($result == TRUE)
			$Return['result'] = $this->lang->line('xin_role_success_added');
		else $Return['error'] = $this->lang->line('xin_error_msg');
		$this->output($Return);
		exit;
		}
	}
	public function update() {
		if($this->input->post('edit_type')=='role') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('role_name')==='') {
				$Return['error'] = $this->lang->line('xin_role_error_role_name');
			}elseif($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('role_access')==='') {
				$Return['error'] = $this->lang->line('xin_role_error_access');
			}
			$role_resources = implode(',',$this->input->post('role_resources'));
			$existing_sop_role_resources = $this->input->post('existing_sop_role_resources');
			if($Return['error']!='')
			$this->output($Return);
			$data = array(
				'role_name' => $this->input->post('role_name'),
				'company_id' => $this->input->post('company_id'),
				'role_access' => $this->input->post('role_access'),
				'role_resources' => $role_resources.$existing_sop_role_resources,
			);
			$result = $this->Roles_model->update_record($data,$id);
			if ($result == TRUE)
				$Return['result'] = $this->lang->line('xin_role_success_updated');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	public function deleted(){
		$data['title'] = 'Deleted '.$this->lang->line('xin_role_urole').' | '.$this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$data['breadcrumbs'] = $this->lang->line('xin_role_urole');
		$data['path_url'] = 'roles';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$user = $this->Xin_model->read_employee_info($session['user_id']);
		if($user[0]->user_role_id==1) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/roles/role_list_deleted", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	public function role_list_deleted(){
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/roles/role_list_deleted", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role = $this->Roles_model->get_user_roles_deleted();
		$data = array();
		foreach($role->result() as $r) {
			if($r->role_access==1): $r_access = $this->lang->line('xin_role_all_menu');
			elseif($r->role_access==2): $r_access = $this->lang->line('xin_role_cmenu'); endif;
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			// luffy restore button
			$user = $this->Xin_model->read_employee_info($session['user_id']);
			$restore='';
			if($user[0]->user_role_id==1)
				if(!empty($session))
					$restore='<span data-toggle="tooltip" data-placement="top" title="Restore"><button type="button" class="btn icon-btn btn-xs btn-success waves-effect waves-light restore" data-toggle="modal" data-target=".restore-modal" data-record-id="'. $r->role_id . '"><span class="fa fa-undo"></span></button></span>';
			$action=$restore;
			$data[] = array(
				$action,
				#$r->role_id,
				$r->role_name,
				$r_access,
				$comp_name,
				#$created_at
			);
		}
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $role->num_rows(),
			"recordsFiltered" => $role->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
  }
	public function delete() {
		if($this->input->post('is_ajax')==2) {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Roles_model->delete_record($id);
			if(isset($id))
				$Return['result'] = $this->lang->line('xin_role_success_deleted');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
		}
	}
	//luffy restore
	public function restore() {
		if($this->input->post('is_ajax')==2) {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Roles_model->restore($id);
			if(isset($id))
				$Return['result'] = 'The data has been restored.';
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
		}
	}
}
