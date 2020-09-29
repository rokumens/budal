<?php
 /**
 * Customer Data
 * Import customer number from Excel
 * @author luffy
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {

	public function __construct() {
  	parent::__construct();
		//load the models
		$this->load->model("Customer_model");
		$this->load->model("Xin_model");
		$this->session->set_userdata('lastUrl',current_url().$this->input->server('QUERY_STRING'));
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
		$data['title'] = 'Customer Data | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Customer Data';
		$data['path_url'] = 'customer';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('3001',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/customer/customer_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

	public function customer_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/customer/customer_list", $data);
		} else {
			redirect('admin/');
		}

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$contacts = $this->Customer_model->get_contacts();
		$data = array();
		$no=1;
		foreach($contacts->result() as $r) {
			$data[] = array(
				$no++,
				$r->mobile_number,
				$r->email
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

	public function duplicate_contacts_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){
			$this->load->view("admin/customer/customer_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$duplicateContacts = $this->Customer_model->get_duplicate_contacts();
		$data = array();
		foreach($duplicateContacts->result() as $r) {
			$data[] = array(
				$r->mobile_number,
				$r->count_mobile_number
			);
		}
		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $duplicateContacts->num_rows(),
			 "recordsFiltered" => $duplicateContacts->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function import() {
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = 'Import Customer | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Import Customer';
		$data['path_url'] = 'import_customer';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('3002',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/customer/customer_import", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
  }

	// Validate and import contacts list from excel.
	public function import_customer() {
		$session = $this->session->userdata('username');
		if($this->input->post('is_ajax')=='3') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();

			//validate whether uploaded file is a csv file
	   	$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			// 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'

			if($_FILES['file']['name']==='') {
				// $Return['error'] = $this->lang->line('xin_employee_imp_allowed_size');
				$Return['error'] = "Please select csv file to upload.";
			} else {
				if(in_array($_FILES['file']['type'],$csvMimes)){

					if(is_uploaded_file($_FILES['file']['tmp_name'])){

						// check file size
						$maxFileSize=10000000; // 10 Mb
						if(filesize($_FILES['file']['tmp_name']) > $maxFileSize) {

							// $Return['error'] = $this->lang->line('xin_error_employees_import_size');
							$Return['error'] = "Please select csv or excel file (allowed file size 10MB)";

						}else{

							//open uploaded csv file with read only mode
							$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

							//skip first line
							fgetcsv($csvFile);

							$idUpload = uniqid();
							// $counter=1;

							//parse data from csv file line by line
							while(($line = fgetcsv($csvFile)) !== FALSE){
								$data = array(
									'id_upload' => $idUpload,
									'mobile_number' => $line[0],
									'email' => $line[1],
									'created_at' => date('Y-m-d H:i:s'),
									'uploaded_by' => $session['user_id']
								);
								// $Return['counting'] = '..importing data '.$counter++;
								// $Return['counting'] '...importing data '.$counter++. '<br /><script>setInterval("window.scroll(0, Math.pow(10,10))", 500);</script>';
								$result = $this->Customer_model->add($data);
							}

							// get duplicatess.
							$duplicates = $this->Customer_model->duplicate();
							foreach($duplicates->result() as $singDuplicate){
								$duplicateData = array(
									'id_upload' => $idUpload,
									'mobile_number' => $singDuplicate->mobile_number,
									'count_mobile_number' => $singDuplicate->count_mobile_number
								);
								$this->Customer_model->addDuplicate($duplicateData);
							}

							//close opened csv file
							fclose($csvFile);

							$Return['result'] = 'Customer imported successfully. Going back to Customer Data list now...';
						}
					}else{
						$Return['error'] = 'No customer imported.';
					}
				}else{
					$Return['error'] = 'Format file error.';
				}
			} // file empty

			// if($Return['error']!=''){
	    // 	$this->output($Return);
	  	// }

			$this->output($Return);
			exit;
		}
	}

	public function delete() {
 	 /* Define return | here result is used to return user data and error for error message */
 	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
 	 $Return['csrf_hash'] = $this->security->get_csrf_hash();

	 $contacts = $this->Customer_model->get_contacts();
	 if(!empty($contacts->result())){
		 $this->Customer_model->empty_customer_data();
		 $Return['result'] = "All customers data deleted.";
	 }else{
		 $Return['error'] = "Customer data is empty.";
	 }

	 // $result = $this->Customer_model->empty_customer_data();
	 // $Return['result'] = "All customers data deleted.";

	 $this->output($Return);
  }

}
