<?php
 /**
 * @author   luffy
 * Rewards module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Rewards extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Rewards_model");
		$this->load->model("Rewards_amount_model");
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
		if(empty($session))
			redirect('admin/');
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true')
			redirect('admin/dashboard');
		$data['title'] = 'Rewards Points | '.$this->Xin_model->site_title();
		$data['allRewards'] = $this->Rewards_model->all_rewards();
		$data['breadcrumbs'] = 'Rewards Points';
		$data['path_url'] = 'rewards';
		$data['amount'] = $this->Rewards_amount_model->getCurrentRewardsPointAmount()->amount;
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1004',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/rewards/rewards_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

  public function rewards_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/rewards/rewards_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('2019',$role_resources_ids))
			$rewards = $this->Rewards_model->my_own_rewards($session['user_id']);
		else $rewards = $this->Rewards_model->all_rewards();
		$data = array();
    foreach($rewards->result() as $r) {
			if(in_array('2016',$role_resources_ids))  //update
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-rewards_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			else $edit = '';
			if(in_array('2017',$role_resources_ids))  // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
			else $delete = '';
			if(in_array('2018',$role_resources_ids))  //view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-rewards_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			else $view = '';
			$combhr = $edit.$delete.$view;
			$data[] = array(
				$combhr,
				$r->rewards_name,
				$r->rewards_point,
				"Rp. ".number_format($r->amount,0,',','.')
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $rewards->num_rows(),
			 "recordsFiltered" => $rewards->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	public function add_rewards() {
		if($this->input->post('add_type')=='add_rewards') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
	 		if($this->input->post('rewardName')==='') {
	 				$Return['error'] = "Reward Name is required.";
	 		} else if($this->input->post('rewardPoint')==='') {
	 				$Return['error'] = "Reward Point is required.";
	 		} else if($this->input->post('rewardPoint')==0) {
	 				$Return['error'] = "Reward Point can not 0 (zero).";
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
				'rewards_name' => $this->input->post('rewardName'),
				'rewards_point' => $this->input->post('rewardPoint'),
				'rewards_amount_id' => 1,
				'amount' => str_replace('.', '', $this->input->post('amount')),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => ''
			);
			$result = $this->Rewards_model->add($data);
			if ($result == TRUE) {
				$Return['result'] = "Rewards Points added.";
				//update the amount per point too :)
		 		$dataRewardsAmount = array(
		 			'amount' => $this->input->post('valuePerPoint'),
		 			'updated_at' => date('Y-m-d H:i:s')
		 		);
		 		$this->Rewards_amount_model->update_record($dataRewardsAmount,1);
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('rewards_id');
	 $result = $this->Rewards_model->read_rewards_information($id);
	 $data = array(
		 'rewards_id' => $result[0]->id,
		 'rewardName' => $result[0]->rewards_name,
		 'rewardPoint' => $result[0]->rewards_point,
		 'valuePerPoint' => $this->Rewards_amount_model->getCurrentRewardsPointAmount()->amount,
		 'amount' => $result[0]->amount
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/rewards/dialog_rewards', $data);
	 } else {
		 redirect('admin/');
	 }
 }
  public function update() {
 	 if($this->input->post('edit_type')=='rewards_update') {
	 	 $id = $this->uri->segment(4);
	 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
	 		if($this->input->post('rewardName')==='') {
	 				$Return['error'] = "Reward Name is required.";
	 		} else if($this->input->post('rewardPoint')==='') {
	 				$Return['error'] = "Reward Point is required.";
	 		} else if($this->input->post('rewardPoint')==0) {
	 				$Return['error'] = "Reward Point can not 0 (zero).";
	 		} else if($this->input->post('valuePerPoint')==='') {
	 				$Return['error'] = "Value Per Point is required.";
	 		} else if($this->input->post('valuePerPoint')==0) {
	 				$Return['error'] = "Value Per Point can not 0 (zero).";
	 		}
	 		if($Return['error']!=''){
	 				$this->output($Return);
	 		}
	 		$session = $this->session->userdata('username');
			// $note = htmlspecialchars(addslashes($this->input->post('note')), ENT_QUOTES);
	 		$data = array(
				'rewards_name' => $this->input->post('rewardName'),
	 		  'rewards_point' => $this->input->post('rewardPoint'),
	 		  'rewards_amount_id' => 1,
	 		  'amount' => str_replace('.', '', $this->input->post('amount')),
	 		  'updated_at' => date('Y-m-d H:i:s')
	 		);
	 	 $result = $this->Rewards_model->update_record($data,$id);
	 	 if ($result == TRUE) {
	 		 $Return['result'] = "Rewards Points updated.";
			 //update the amount per point too :)
			 $dataRewardsAmount = array(
				 'amount' => $this->input->post('valuePerPoint'),
				 'updated_at' => date('Y-m-d H:i:s')
			 );
			 $this->Rewards_amount_model->update_record($dataRewardsAmount,1);
	 	 } else {
	 		 $Return['error'] = $this->lang->line('xin_error_msg');
	 	 }
	 	 $this->output($Return);
	 	 exit;
 	 }
  }
	public function delete() {
 	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 	 $id = $this->uri->segment(4);
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
 	 $result = $this->Rewards_model->delete_record($id);
 	 if(isset($id))
 		 $Return['result'] = "Rewards Points deleted.";
 	 else $Return['error'] = $this->lang->line('xin_error_msg');
 	 $this->output($Return);
  }

}
