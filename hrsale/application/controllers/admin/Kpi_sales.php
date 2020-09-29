<?php
 /**
 * @author   luffy
 * Custom for KPI Sales module
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpi_sales extends MY_Controller {

	public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Kpi_sales_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Grade_model");
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
	public function index() {
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true')
			redirect('admin/dashboard');
		$data['title'] = 'KPI Sales | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'KPI Sales';
		$data['path_url'] = 'kpi_sales';
		$data['allJobTask']=$this->Appraisal_task_model->all_appraisal_task()->result();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('1006',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/kpi_sales/kpi_sales_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }
  public function kpi_sales_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/kpi_sales/kpi_sales_list", $data);
		} else {
			redirect('admin/');
		}
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		// // Luffy's note kalau KPI mau di "my own" kan:
		// // View Own berlaku, datatable akan kosong jika bukan miliknya.
		// // catatan 1: PENTING > untuk View Own ini, di role Admin jangan dicentang, hanya centang View Own role punya user saja.
		// // catatan 2: dan kalau sudah centang View Own, centang juga View (di role user), biar user bisa view.
		// if(in_array('2029',$role_resources_ids)){
		// 	$kpi_sales = $this->Kpi_sales_model->my_own_kpi_sales($session['user_id']);
		// } else {
		// 	$kpi_sales = $this->Kpi_sales_model->all_kpi_sales();
		// }
		$kpi_sales = $this->Kpi_sales_model->all_kpi_sales();
		$data = array();
	    foreach($kpi_sales->result() as $r) {
				if(in_array('2026',$role_resources_ids)) { //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-kpi_sales_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('2027',$role_resources_ids)) { // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
				} else {
					$delete = '';
				}
				if(in_array('2028',$role_resources_ids)) { //view
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-kpi_sales_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
				} else {
					$view = '';
				}
				$combhr = $edit.$delete.$view;
				$jobTask = $this->Kpi_sales_model->getJobTask($r->job_task);
				$data[] = array(
					$combhr,
					$jobTask->name,
					$r->minimum_requirement.'x',
					'Rp. '.number_format($r->minimum_amount,0,",","."),
					'Rp. '.number_format($r->total_deposit,0,',','.'),
					$r->value_percentage*100 .'%',
					'Rp. '.number_format($r->value_amount,0,',','.'),
					'Rp. '.number_format($r->employee_bonus,0,',','.')
				);
	    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $kpi_sales->num_rows(),
			 "recordsFiltered" => $kpi_sales->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// get grade > minimum requirement by task id
	public function get_requirement() {
		 $data['title'] = $this->Xin_model->site_title();
		 $taskId = $this->uri->segment(4);
		 $data = array('taskId'=>$taskId);
		 $session = $this->session->userdata('username');
		 if(!empty($session)){
			 $this->load->view("admin/kpi_sales/get_requirement",$data);
		 } else {redirect('admin/');}
		 // Datatables Variables
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	public function add_kpi_sales() {
		if($this->input->post('add_type')=='add_kpi_sales') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			if($this->input->post('jobtask')==='') {
	       $Return['error'] = "Please choose main task.";
			}elseif($this->input->post('valuePercentage')==='') {
	       $Return['error'] = "Value Percentage is required.";
			}elseif($this->input->post('valuePercentage')===0) {
	       $Return['error'] = "Value Percentage can not 0 (zero).";
			}elseif($this->input->post('minimumAmount')==='') {
	       $Return['error'] = "Minimum Amount is required.";
			}elseif($this->input->post('minimumAmount')===0) {
		     $Return['error'] = "Minimum Amount can not 0 (zero).";
			}elseif($this->input->post('valueAmount')==='') {
				$Return['error'] = "Value Amount is required.";
			}elseif($this->input->post('valueAmount')===0) {
				$Return['error'] = "Value Amount can not 0 (zero).";
			}elseif($this->input->post('employeeBonus')==='') {
				$Return['error'] = "Employee Bonus is required.";
			}elseif($this->input->post('employeeBonus')===0) {
				$Return['error'] = "Employee Bonus can not 0 (zero).";
			}
			if($Return['error']!='')
       	$this->output($Return);
			$session = $this->session->userdata('username');
			$data = array(
				'job_task' => $this->input->post('jobtask'),
				'minimum_requirement' => $this->input->post('monthlyRequirement'),
				'minimum_amount' => str_replace('.','',$this->input->post('minimumAmount')),
				'value_percentage' => $this->input->post('valuePercentage')/100,
				'value_amount' => str_replace('.','',$this->input->post('valueAmount')),
				'employee_bonus' => str_replace('.','',$this->input->post('employeeBonus')),
				'total_deposit' => str_replace('.','',$this->input->post('totalDeposit'))
			);
			$result = $this->Kpi_sales_model->add($data);
			if($result == TRUE){
				$Return['result'] = "KPI Sales added.";
				// // NGGA dipake lagi - skrg dah ke KPI Report :) #luffy 21 nov 2019
				// // save/update the KPI Summary too.
	 		  // $today = date('Y-m-d');
				// $currentSUMEmployeeBonus = $this->Kpi_sales_model->getSumKpiSummary($today)[0]->sum_employee_bonus;
				// $currentSUMTotalDeposit = $this->Kpi_sales_model->getSumKpiSummary($today)[0]->sum_total_deposit;
	 		  // $checkKpiSummary = $this->Kpi_sales_model->getKpiSummaryByDate($today);
	 		  // if(empty($checkKpiSummary)){
	 			//   $dataKpiSummary=array(
	 			// 	  'date' => $today,
	 			// 	  'summary_employee_bonus' => $currentSUMEmployeeBonus,
	 			// 	  'summary_total_deposit' => $currentSUMTotalDeposit
	 			//   );
	 			//   $this->Kpi_sales_model->addKpiSummary($dataKpiSummary);
	 		  // }else{
	 			//   $dataKpiSummary=array(
	 			// 	  'summary_employee_bonus' => $currentSUMEmployeeBonus,
	 			// 	  'summary_total_deposit' => $currentSUMTotalDeposit
	 			//   );
	 			//   $this->Kpi_sales_model->updateKpiSummary($dataKpiSummary,$today);
	 		  // }
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	public function read() {
	 $data['title'] = $this->Xin_model->site_title();
	 $id = $this->input->get('kpi_sales_id');
	 $result = $this->Kpi_sales_model->read_kpi_sales_information($id);
	 $allJobTask=$this->Kpi_sales_model->all_jobtask();
	 $jobTask = $this->Kpi_sales_model->getJobTask($result[0]->job_task);
	 $data = array(
		 'kpi_sales_id'	=> $result[0]->id,
		 'jobTaskName' => $jobTask->name,
		 'monthlyRequirement' => $result[0]->minimum_requirement,
		 'minAmount' => $result[0]->minimum_amount,
		 'valuePercentage' => $result[0]->value_percentage*100,
		 'valueAmount' => $result[0]->value_amount,
		 'employeeBonus' => $result[0]->employee_bonus,
		 'totalDeposit' => $result[0]->total_deposit,
		 'allJobTask' => $allJobTask,
		 'jobTaskId' => $result[0]->job_task
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session)){
		 $this->load->view('admin/kpi_sales/dialog_kpi_sales', $data);
	 } else {
		 redirect('admin/');
	 }
 }
  public function update() {
 	 if($this->input->post('edit_type')=='kpi_sales_update') {
 	 $id = $this->uri->segment(4);
 		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if($this->input->post('jobtask')===''){
			$Return['error'] = "Please choose a task.";
		}elseif($this->input->post('valuePercentage')==='') {
			$Return['error'] = "Value Percentage is required.";
		}elseif($this->input->post('valuePercentage')===0) {
			$Return['error'] = "Value Percentage can not 0 (zero).";
		}elseif($this->input->post('minimumAmount')==='') {
			$Return['error'] = "Minimum Amount is required.";
		}elseif($this->input->post('minimumAmount')===0) {
			$Return['error'] = "Minimum Amount can not 0 (zero).";
		}elseif($this->input->post('valueAmount')==='') {
			$Return['error'] = "Value Amount is required.";
		}elseif($this->input->post('valueAmount')===0) {
			$Return['error'] = "Value Amount can not 0 (zero).";
		}elseif($this->input->post('employeeBonus')==='') {
			$Return['error'] = "Employee Bonus is required.";
		}elseif($this->input->post('employeeBonus')===0) {
			$Return['error'] = "Employee Bonus can not 0 (zero).";
		}
		if($Return['error']!='')
			$this->output($Return);
 		$session = $this->session->userdata('username');
 		$data = array(
			'job_task' => $this->input->post('jobtask'),
			'minimum_requirement' => $this->input->post('monthlyRequirement'),
			'minimum_amount' => str_replace('.','',$this->input->post('minimumAmount')),
			'value_percentage' => $this->input->post('valuePercentage')/100,
			'value_amount' => str_replace('.','',$this->input->post('valueAmount')),
			'employee_bonus' => str_replace('.','',$this->input->post('employeeBonus')),
			'total_deposit' => str_replace('.','',$this->input->post('totalDeposit'))
 		);
 	 $result = $this->Kpi_sales_model->update_record($data,$id);
 	 if ($result == TRUE) {
 		 $Return['result'] = "KPI Sales updated.";
		 // // // NGGA dipake lagi - skrg dah ke KPI Report :) #luffy 21 nov 2019
		 // // save/update the KPI Summary too.
		 // $dateToUpdate = $this->Kpi_sales_model->read_kpi_sales_information($id)[0]->created_at;
		 // $currentSUMEmployeeBonus = $this->Kpi_sales_model->getSumKpiSummary($dateToUpdate)[0]->sum_employee_bonus;
		 // $currentSUMTotalDeposit = $this->Kpi_sales_model->getSumKpiSummary($dateToUpdate)[0]->sum_total_deposit;
		 // $checkKpiSummary = $this->Kpi_sales_model->getKpiSummaryByDate($dateToUpdate);
		 // if(empty($checkKpiSummary)){
			//  $dataKpiSummary=array(
			// 	 'date' => $dateToUpdate,
			// 	 'summary_employee_bonus' => $currentSUMEmployeeBonus,
			// 	 'summary_total_deposit' => $currentSUMTotalDeposit
			//  );
			//  $this->Kpi_sales_model->addKpiSummary($dataKpiSummary);
		 // }else{
			//  $dataKpiSummary=array(
			// 	 'summary_employee_bonus' => $currentSUMEmployeeBonus,
			// 	 'summary_total_deposit' => $currentSUMTotalDeposit
			//  );
			//  $this->Kpi_sales_model->updateKpiSummary($dataKpiSummary,$dateToUpdate);
		 // }
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
 	 exit;
 	 }
  }
	public function delete() {
 	 $Return = array('result'=>'','error'=>'','csrf_hash'=>'');
 	 $id = $this->uri->segment(4);
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 $dateToUpdate = $this->Kpi_sales_model->read_kpi_sales_information($id)[0]->created_at;
 	 $result = $this->Kpi_sales_model->delete_record($id);
 	 if(isset($id)) {
 		 $Return['result'] = "KPI Sales deleted.";
		 // // // NGGA dipake lagi - skrg dah ke KPI Report :) #luffy 21 nov 2019
		 // if(!is_null($this->Kpi_sales_model->getSumKpiSummary($dateToUpdate))){
			//  $currentSUMEmployeeBonus = $this->Kpi_sales_model->getSumKpiSummary($dateToUpdate)[0]->sum_employee_bonus;
			//  $currentSUMTotalDeposit = $this->Kpi_sales_model->getSumKpiSummary($dateToUpdate)[0]->sum_total_deposit;
		 // }else{
			//  $currentSUMEmployeeBonus = 0;
			//  $currentSUMTotalDeposit = 0;
		 // }
		 // $dataKpiSummary=array(
			//  'summary_employee_bonus' => $currentSUMEmployeeBonus,
			//  'summary_total_deposit' => $currentSUMTotalDeposit
		 // );
		 // $this->Kpi_sales_model->updateKpiSummary($dataKpiSummary,$dateToUpdate);
 	 } else {
 		 $Return['error'] = $this->lang->line('xin_error_msg');
 	 }
 	 $this->output($Return);
  }

}
