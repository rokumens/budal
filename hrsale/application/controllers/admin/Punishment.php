<?php
 /**
 * @author   luffy
 * Punishment module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Punishment extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Punishment_model");
		$this->load->model("Punishment_amount_model");
		$this->load->model("Xin_model");
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
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = 'Punishment Points | '.$this->Xin_model->site_title();
		$data['allPunishment'] = $this->Punishment_model->all_punishment();
		$data['breadcrumbs'] = 'Punishment Points';
		$data['path_url'] = 'punishment';	//js named di sini jg.
		$data['amount'] = $this->Punishment_amount_model->getCurrentPunishmentPointAmount()->amount;
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1004',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/punishment/punishment_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function punishment_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/punishment/punishment_list", $data);
		} else {
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('2024',$role_resources_ids)){
			$punishment = $this->Punishment_model->my_own_punishment($session['user_id']);
		} else {
			$punishment = $this->Punishment_model->all_punishment();
		}
		$data = array();
	    foreach($punishment->result() as $r) {
				if(in_array('2016',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-punishment_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('2017',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('2018',$role_resources_ids)) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-punishment_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$delete.$view;
				$data[] = array(
					$combhr,
					$r->punishment_name,
					$r->punishment_point,
					"Rp. ".number_format($r->amount,0,',','.')
				);
	    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $punishment->num_rows(),
			 "recordsFiltered" => $punishment->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	// Validate and add job tasks
	public function add_punishment() {
		if($this->input->post('add_type')=='add_punishment') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			/* Server side PHP input validation */
	 		if($this->input->post('punishmentName')==='') {
	 				$Return['error'] = "Punishment Name is required.";
	 		} else if($this->input->post('punishmentPoint')==='') {
	 				$Return['error'] = "Punishment Point is required.";
	 		} else if($this->input->post('punishmentPoint')==0) {
	 				$Return['error'] = "Punishment Point can not 0 (zero).";
	 		} else if($this->input->post('valuePerPoint')==='') {
	 				$Return['error'] = "Value Per Point is required.";
	 		} else if($this->input->post('valuePerPoint')==0) {
	 				$Return['error'] = "Value Per Point can not 0 (zero).";
	 		}
	 		if($Return['error']!=''){
	 				$this->output($Return);
	 		}
			$session = $this->session->userdata('username');
			$data = array(
				'punishment_name' => $this->input->post('punishmentName'),
				'punishment_point' => $this->input->post('punishmentPoint'),
				'punishment_amount_id' => 1,
				'amount' => str_replace('.', '', $this->input->post('amount')),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => ''
			);
			$result = $this->Punishment_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Punishment Points added.";
				//update the amount per point too :)
		 		$dataPunishmentAmount = array(
		 			'amount' => $this->input->post('valuePerPoint'),
		 			'updated_at' => date('Y-m-d H:i:s')
		 		);
		 		$this->Punishment_amount_model->update_record($dataPunishmentAmount,1);
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('punishment_id');
	 $result = $this->Punishment_model->read_punishment_information($id);
	 $data = array(
		 'punishment_id' => $result[0]->id,
		 'punishmentName' => $result[0]->punishment_name,
		 'punishmentPoint' => $result[0]->punishment_point,
		 'valuePerPoint' => $this->Punishment_amount_model->getCurrentPunishmentPointAmount()->amount,
		 'amount' => $result[0]->amount
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/punishment/dialog_punishment', $data);
	 } else {
		 redirect('admin/');
	 }
 }

	// Validate and update info in database
  public function update() {
 	 if($this->input->post('edit_type')=='punishment_update') {
 	 $id = $this->uri->segment(4);

 	 /* Define return | here result is used to return user data and error for error message */
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();

 		/* Server side PHP input validation */
 		if($this->input->post('punishmentName')==='') {
 				$Return['error'] = "Punishment Name is required.";
 		} else if($this->input->post('punishmentPoint')==='') {
 				$Return['error'] = "Punishment Point is required.";
 		} else if($this->input->post('punishmentPoint')==0) {
 				$Return['error'] = "Punishment Point can not 0 (zero).";
 		} else if($this->input->post('valuePerPoint')==='') {
 				$Return['error'] = "Value Per Point is required.";
 		} else if($this->input->post('valuePerPoint')==0) {
 				$Return['error'] = "Value Per Point can not 0 (zero).";
 		}
 		if($Return['error']!=''){
 				$this->output($Return);
 		}
 		$session = $this->session->userdata('username');
 		$data = array(
			'punishment_name' => $this->input->post('punishmentName'),
 		  'punishment_point' => $this->input->post('punishmentPoint'),
 		  'punishment_amount_id' => 1,
 		  'amount' => str_replace('.', '', $this->input->post('amount')),
 		  'updated_at' => date('Y-m-d H:i:s')
 		);
 	 $result = $this->Punishment_model->update_record($data,$id);
 	 if ($result == TRUE) {
 		 $Return['result'] = "Punishment Points updated.";
		  //update the amount per point too :)
	 		$dataPunishmentAmount = array(
	 			'amount' => $this->input->post('valuePerPoint'),
	 			'updated_at' => date('Y-m-d H:i:s')
	 		);
	 		$this->Punishment_amount_model->update_record($dataPunishmentAmount,1);
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
 	 $result = $this->Punishment_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "Punishment Points deleted.";
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
