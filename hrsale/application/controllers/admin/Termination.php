<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termination extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Termination_model");
		//luffy start
		$this->load->model("Employees_model");
		$this->load->model("Warning_model");
		// luffy end
		$this->load->model("Department_model");
		$this->load->model("Xin_model");
		// luffy 14 Dec 2019 07:17 pm
		$this->load->library('Pdf');
		$this->load->model("Designation_model");
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
			$data['title'] = $this->lang->line('left_terminations').' | '.$this->Xin_model->site_title();
			$data['all_employees'] = $this->Xin_model->all_employees();
			$data['get_all_companies'] = $this->Xin_model->get_companies();
			# luffy 1 January 2020
			$data['allApprover'] = $this->Xin_model->get_approver_list()->result();
			$data['all_termination_types'] = $this->Termination_model->all_termination_types();
			$data['breadcrumbs'] = $this->lang->line('left_terminations');
			$data['path_url'] = 'termination';
			$role_resources_ids = $this->Xin_model->user_role_resource();
			$currentUser=$session['user_id'];
			if(in_array('21',$role_resources_ids)) {
				if(!empty($session)){
					$data['subview'] = $this->load->view("admin/termination/termination_list", $data, TRUE);
					$this->load->view('admin/layout/layout_main', $data); //page load
				} else {
					redirect('admin/');
				}
			} else {
				redirect('admin/dashboard');
			}
    }

    public function termination_list(){
			$data['title'] = $this->Xin_model->site_title();
			$session = $this->session->userdata('username');
			if(!empty($session))
				$this->load->view("admin/termination/termination_list", $data);
			else redirect('admin/');
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$termination = $this->Termination_model->get_terminations();
			$role_resources_ids = $this->Xin_model->user_role_resource();
			$data = array();
	    foreach($termination->result() as $r) {
				// get user > termination to
				$euser = $this->Xin_model->read_user_info($r->employee_id);
				// user full name
				if(!is_null($euser)){
					$ful_name = $euser[0]->first_name.' '.$euser[0]->last_name;
					$location = $euser[0]->fingerprint_location;
				} else {
					$ful_name = '--';
					$location = 'X';
				}
				// get notice date
				$notice_date = $this->Xin_model->set_date_format($r->notice_date);
				// get termination date
				$termination_date = $this->Xin_model->set_date_format($r->termination_date);
				// get status
				if($r->status==0): $status = $this->lang->line('xin_pending');
				elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
				// get termination type
				$termination_type = $this->Termination_model->read_termination_type_information($r->termination_type_id);
				if(!is_null($termination_type))
					$ttype = $termination_type[0]->type;
				else $ttype = '--';
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company))
					$comp_name = $company[0]->name;
				else $comp_name = '--';
				if(in_array('229',$role_resources_ids))  //edit
					$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-termination_id="'. $r->termination_id . '"><span class="fa fa-pencil"></span></button></span>';
				else $edit = '';
				if(in_array('230',$role_resources_ids))  // delete
					$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->termination_id . '"><span class="fa fa-trash"></span></button></span>';
				else $delete = '';
				if(in_array('239',$role_resources_ids))  //view
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-termination_id="'. $r->termination_id . '"><span class="fa fa-eye"></span></button></span>';
				else $view = '';
				// # luffy 14 Dec 2019 05:49 pm
				// # create pdf termination letter
				// $terminationLetter='<span data-toggle="tooltip" data-placement="top" title="Termination Letter"><a href="'.site_url().'admin/termination/termination_letter/p/'.$r->termination_id.'">
				// <button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light">
				// <span class="fa fa-file-pdf-o"></span></button></a></span>';
				$combhr = $edit.$view.$delete;
				$data[] = array(
					$combhr,
					$ful_name,
					$location,
					$ttype,
					$notice_date,
					$termination_date,
					$status
				);
	    }
		  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $termination->num_rows(),
			 "recordsFiltered" => $termination->num_rows(),
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
		if(!empty($session))
			$this->load->view("admin/termination/get_employees", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 public function read(){
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('termination_id');
		$result = $this->Termination_model->read_termination_information($id);
		$session=$this->session->userdata('username');
		$userId=$session['user_id'];
		# luffy 18 December 2019 02:54 pm
		$approver1Data=$this->Xin_model->read_user_info($result[0]->approval_1);
		$approver1Name = $approver1Data[0]->employee_id.' - '.$approver1Data[0]->username;
		$approver2Data=$this->Xin_model->read_user_info($result[0]->approval_2);
		$approver2Name = $approver2Data[0]->employee_id.' - '.$approver2Data[0]->username;
		$allApprover = $this->Xin_model->get_approver_list()->result();
		$data = array(
			'termination_id' => $result[0]->termination_id,
			'employee_id' => $result[0]->employee_id,
			'company_id' => $result[0]->company_id,
			'terminated_by' => $result[0]->terminated_by,
			'termination_type_id' => $result[0]->termination_type_id,
			'termination_date' => $result[0]->termination_date,
			'notice_date' => $result[0]->notice_date,
			'description' => $result[0]->description,
			'status' => $result[0]->status,
			'letterNumber' => $result[0]->termination_letter_number, # luffy 15 Nov 2019 07:08 pm
			'all_employees' => $this->Xin_model->all_employees(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_termination_types' => $this->Termination_model->all_termination_types(),
			'terminationAttachment' => $result[0]->termination_attachment,
			'currentUser' => $userId,
			'approvedBy1' => $result[0]->approved_by_1,
			'approvedBy2' => $result[0]->approved_by_2,
			'approval_1' => $result[0]->approval_1,
			'approval_2' => $result[0]->approval_2,
			'approval_status_by_1' => $result[0]->approval_status_by_1,
			'approval_status_by_2' => $result[0]->approval_status_by_2,
			# luffy 18 Dec 2019 02:57 pm
			'approver1Name' => $approver1Name,
			'approver2Name' => $approver2Name,
			# luffy 1 December 2020
			'allApprover'=>$allApprover,
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view('admin/termination/dialog_termination', $data);
		else redirect('admin/');
	}

	// Validate and add info in database
	public function add_termination() {
		if($this->input->post('add_type')=='termination') {
			$session=$this->session->userdata('username');
	    $userId=$session['user_id'];
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$notice_date = $this->input->post('notice_date');
			$termination_date = $this->input->post('termination_date');
			$approval1 = $this->input->post('approval_by_1');
			$approval2 = $this->input->post('approval_by_2');
			$nt_date = strtotime($notice_date);
    	$tt_date = strtotime($termination_date);
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('employee_id')==='') {
	 			$Return['error'] = $this->lang->line('xin_error_employee_id');
			}elseif($this->input->post('notice_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_resignation_notice_date');
			}elseif($this->input->post('termination_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_termination_date');
			}elseif($nt_date > $tt_date) {
	  		$Return['error'] = $this->lang->line('xin_error_termination_notice_date_less');
			}elseif($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('xin_error_termination_type');
			}elseif($approval1==='') {
				$Return['error'] = 'Please choose approval 1';
			}elseif($approval2==='') {
				$Return['error'] = 'Please choose approval 1';
			}elseif($approval1===$approval2) {
				$Return['error'] = 'Approver can not be the same person.';
			}
			// // luffy 14 Dec 2019 06:41 pm
			// // not used anymore >> now create pdf.
			// elseif(empty($_FILES['termination_attachmentzz']['name'])) {
			// 	$Return['error'] = "Please upload termination letter.";
			// }
			// // luffy 8 Dec 2019 - 01:26 pm
			// if(!empty($_FILES['termination_attachmentzz']['name'])) {
			// 	if(is_uploaded_file($_FILES['termination_attachmentzz']['tmp_name'])) {
			// 		//checking file type
			// 		$allowed =  array('pdf');
			// 		$filename = $_FILES['termination_attachmentzz']['name'];
			// 		$ext = pathinfo($filename, PATHINFO_EXTENSION);
			// 		if(in_array($ext,$allowed)){
			// 			$tmp_name = $_FILES["termination_attachmentzz"]["tmp_name"];
			// 			$documentd = "uploads/termination/";
			// 			// basename() may prevent filesystem traversal attacks;
			// 			// further validation/sanitation of the filename may be appropriate
			// 			$name = basename($_FILES["termination_attachmentzz"]["name"]);
			// 			$employeeId=$this->input->post('employee_id');
			// 			$employeeNIK_id = $this->Warning_model->getNIK($employeeId)->employee_id;
			// 			$newfilename = 'Termination_Letter_'.'nik-'.$employeeNIK_id.'_'.round(microtime(true)).'.'.$ext;
			// 			move_uploaded_file($tmp_name, $documentd.$newfilename);
			// 			$fname = $newfilename;
			// 		}else{
			// 			$Return['error'] = "The termination letter file type must be pdf.";
			// 		}
			// 	}
			// }
			if($Return['error']!='')
	    	$this->output($Return);
			$data = array(
				'employee_id' => $this->input->post('employee_id'),
				'company_id' => $this->input->post('company_id'),
				'notice_date' => $this->input->post('notice_date'),
				'description' => $qt_description,
				'termination_date' => $this->input->post('termination_date'),
				'termination_type_id' => $this->input->post('type'),
				'terminated_by' => $this->input->post('user_id'),
				'status' => '0',
				'approval_1' => $approval1,
				'approval_2' => $approval2,
				'created_by' => $userId,
				'created_at' => date('Y-m-d H:i:s'),
				// 'termination_attachment' => $fname,
			);
			// save termination to db
			$result = $this->db->insert('xin_employee_terminations', $data);
			// get the next auto increment id
			$currentIncrementId = $this->db->insert_id();
			if($result==TRUE){
				$Return['result'] = $this->lang->line('xin_success_termination_added');
				// luffy 15 Dec 2019 06:45 pm
				// update letter number
				$lastQuery = $this->Termination_model->read_termination_information($currentIncrementId);
				$letterNumber = $currentIncrementId;
				$type='termination';
				$month=date('m',strtotime($lastQuery[0]->termination_date));
				$year=date('Y',strtotime($lastQuery[0]->termination_date));
				$nomorSurat=$this->nomor_surat($letterNumber,$type,$month,$year);
				$dataLetterNumber=array(
					'termination_letter_number' => $nomorSurat
				);
				$this->Termination_model->update_record($dataLetterNumber,$currentIncrementId);
			}else{$Return['error'] = $this->lang->line('xin_error_msg');}
			$this->output($Return);
			exit;
		}
	}

	// Validate and update info in database
	public function update(){
		if($this->input->post('edit_type')=='termination') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// get the current user for approved by
			$session = $this->session->userdata('username');
			$currentUser=$session['user_id'];
			$notice_date = $this->input->post('notice_date');
			$termination_date = $this->input->post('termination_date');
			$status = $this->input->post('status');
			$nt_date = strtotime($notice_date);
	    $tt_date = strtotime($termination_date);
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$approval1 = $this->input->post('approval_by_1');
			$approval2 = $this->input->post('approval_by_2');
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('employee_id')==='') {
	      $Return['error'] = $this->lang->line('xin_error_employee_id');
			}elseif($this->input->post('notice_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_resignation_notice_date');
			}elseif($this->input->post('termination_date')==='') {
				$Return['error'] = $this->lang->line('xin_error_termination_date');
			}elseif($nt_date > $tt_date) {
	      $Return['error'] = $this->lang->line('xin_error_termination_notice_date_less');
			}elseif($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('xin_error_termination_type');
			}
			// #luffy 8 Dec -2019 - 06:23 pm
			// elseif($this->input->post('status')==='1' && empty($_FILES['termination_attachmentzz']['name'])) {
			// 	$Return['error'] = 'Termination Letter Attachment field is required.';
			// }
			if($Return['error']!='')
				$this->output($Return);
			# luffy 16 Dec 2019 05:16 pm
			$currTermination=$this->Termination_model->read_termination_information($id);
			$approval_1=$currTermination[0]->approval_1;
			$approval_2=$currTermination[0]->approval_2;
			$approvedBy_1=$currTermination[0]->approved_by_1;
			$approvedBy_2=$currTermination[0]->approved_by_2;
			# luffy - 8 Dec 2019 06:33 pm
			$approver_1 = $this->Employees_model->getNamebyUserId($approval_1)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_1)->username;
			$approver_2 = $this->Employees_model->getNamebyUserId($approval_2)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_2)->username;
			$approval_status_by_1 = $currTermination[0]->approval_status_by_1;
			$approval_status_by_2 = $currTermination[0]->approval_status_by_2;
			if(($currentUser!=$approval_1)&&($currentUser!=$approval_2)){
				# luffy 17 Dec 2019 05:17 pm
				# let the HR can still update but not allowed for approval.
				if($status!=0){
					$Return['error'] = "Please ask $approver_1 or $approver_2 for approval.";
				}else{
					$data = array(
						'notice_date' => $this->input->post('notice_date'),
						'description' => $qt_description,
						'termination_date' => $this->input->post('termination_date'),
						'termination_type_id' => $this->input->post('type'),
						'terminated_by' => $this->input->post('user_id'),
						'status' => 0, #forced to 0, hr no need for approval
						# luffy 1 January 2020 11:47 am
						'approval_1' => $approval1,
						'approval_2' => $approval2,
					);
				}
			}else{
				# approver 1 give the approval accepted or rejected.
				if($status==0) $Return['error'] = "Please accept or reject.";
				# approver 1
				if($currentUser==$approval_1){
					# luffy 17 Dec 2019 05:17 pm
					# approver 1 kasih notif tidak bisa meng accept / reject 2x
					if($currentUser==$approvedBy_1 && $approval_status_by_1==$status){
						($approval_status_by_1==1)?$approval_status_by_1_name='accepted':$approval_status_by_1_name='rejected';
						$Return['error'] = "You already $approval_status_by_1_name this.";
					}else{
						# for updating the final result of Termination Status
						if($approval_status_by_2==1 && $status==1)
							$isAccepted=1; #status
						elseif($approval_status_by_2==2 && $status==2)
							$isAccepted=2; #rejected
						else $isAccepted=0; #pending
						# approver 1 can still change status accepted > rejected || rejected > accepted
						$data = array(
							'notice_date' => $this->input->post('notice_date'),
							'description' => $qt_description,
							'termination_date' => $this->input->post('termination_date'),
							'termination_type_id' => $this->input->post('type'),
							'terminated_by' => $this->input->post('user_id'),
							'status' => $isAccepted,
							# luffy 16 Dec 2019 04:04pm
							'approved_by_1' => $currentUser,
							'approval_date_1' => date('Y-m-d H:i:s'),
							'approval_status_by_1' => $status
						);
					}
				}
				#approver 2
				elseif($currentUser==$approval_2){
					# approver 2 kasih notif tidak bisa meng accept / reject 2x
					if($currentUser==$approvedBy_2 && $approval_status_by_2==$status){
						($approval_status_by_2==1)?$approval_status_by_2_name='accepted':$approval_status_by_2_name='rejected';
						$Return['error'] = "You already $approval_status_by_2_name this.";
					}else{
						# luffy 17 Dec 2019 06:03 pm
						# approver 2 can still allowed to change status for accepted or rejected.
						if($currentUser!=$approvedBy_1){
							#update the final result of Termination Status
							if($approval_status_by_1==1 && $status==1)
								$isAccepted=1; #status
							elseif($approval_status_by_1==2 && $status==2)
								$isAccepted=2; #rejected
							else $isAccepted=0; #pending
							# approver 2 can still change status accepted > rejected || rejected > accepted
							$data = array(
								'notice_date' => $this->input->post('notice_date'),
								'description' => $qt_description,
								'termination_date' => $this->input->post('termination_date'),
								'termination_type_id' => $this->input->post('type'),
								'terminated_by' => $this->input->post('user_id'),
								'status' => $isAccepted,
								# luffy 16 Dec 2019 04:04pm
								'approved_by_2' => $currentUser,
								'approval_date_2' => date('Y-m-d H:i:s'),
								'approval_status_by_2' => $status
							);
						}
					}
				}
			}
			if($Return['error']!='')
				$this->output($Return);
			$dataInactive = array(
				'is_active' => 0,
				'inactive_reason' => 3 #1=resign, 2=contract, 3=terminate, 4=runaway
			);
			$employeeId = $this->input->post('employee_id');
			if($this->input->post('status')==1)
				$this->Employees_model->basic_info($dataInactive,$employeeId);
			$result = $this->Termination_model->update_record($data,$id);
			if($result == TRUE)
				$Return['result'] = $this->lang->line('xin_success_termination_updated');
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		} //end submit
	} // end function

	public function delete() {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if(isset($id)) {
			// # luffy 18 Dec 2019 11:01 am | attachment not used anymore, now generate pdf for the letter.
			// // Remove the termination letter file too from directory.
			// $currentTerminationInfo = $this->Termination_model->read_termination_information($id);
			// $terminationAttachment=$currentTerminationInfo[0]->termination_attachment;
			// if(!empty($terminationAttachment)){
			// 	$folderDestination = "uploads/termination/";
			// 		@unlink($folderDestination.$terminationAttachment);
			// }
			# luffy 18 December 2019 11:32 am | if deleted, re-active the employee again.
			$dataReActive = array(
				'is_active' => 1,
				'inactive_reason' => 0,
			);
			$currTermination=$this->Termination_model->read_termination_information($id);
			$employeeId=$currTermination[0]->employee_id;
			$this->Employees_model->basic_info($dataReActive,$employeeId);
			// then DELETE the termination.
			$result = $this->Termination_model->delete_record($id);
			$Return['result'] = $this->lang->line('xin_success_termination_deleted');
		}else{
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	public function nomor_surat($suratNomorKe,$type,$month,$year){
		$letterNumber=str_pad($suratNomorKe,8,'0',STR_PAD_LEFT);
		switch ($type) {
			case 'termination':
				$letterType='PHK';
				break;
			case 'warning':
				$letterType='SP';
				break;
		}
		switch ($month) {
			case '1':
				$letterMonth='I';
				break;
			case '2':
				$letterMonth='II';
				break;
			case '3':
				$letterMonth='III';
				break;
			case '4':
				$letterMonth='IV';
				break;
			case '5':
				$letterMonth='V';
				break;
			case '6':
				$letterMonth='VI';
				break;
			case '7':
				$letterMonth='VII';
				break;
			case '8':
				$letterMonth='VIII';
				break;
			case '9':
				$letterMonth='IX';
				break;
			case '10':
				$letterMonth='X';
				break;
			case '11':
				$letterMonth='XI';
				break;
			case '12':
				$letterMonth='XII';
				break;
		}
		$nomorSurat=$letterNumber.'/APG/HRD/'.$letterType.'/'.$letterMonth.'/'.$year;
		return $nomorSurat;
	}

	// luffy 14 Dec 2019 06:50pm
	// create termination letter PDF
	public function termination_letter() {
		// $system = $this->Xin_model->read_setting_info(1);
	 	// create new PDF document
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
 		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(5);
		$terminationData=$this->Termination_model->read_termination_information($id);
		$creator=$this->Employees_model->getNamebyUserId(35);
	  $author=$creator->employee_id.' - '.$creator->username;
		$user = $this->Xin_model->read_user_info($terminationData[0]->employee_id);
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$jabatan = $designation[0]->designation_name;
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		$clogo = base_url().'uploads/logo/signin/apg.png';
		$employeeName = $user[0]->first_name.' '.$user[0]->last_name;
		$employeeNIK = $user[0]->employee_id.' - '.$user[0]->username;
		$reason=$terminationData[0]->description;
		$terminationDate=$terminationData[0]->termination_date;
		$terminationDate=date('d F Y',strtotime($terminationDate));
		$letterNumber=$terminationData[0]->termination_letter_number;
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		if(!is_null($company)){
		  $company_name = $company[0]->name;
		  $address_1 = $company[0]->address_1;
		  $address_2 = $company[0]->address_2;
		  $city = $company[0]->city;
		  $state = $company[0]->state;
		  $zipcode = $company[0]->zipcode;
		} else {
		  $company_name = '--';
		  $address_1 = '--';
		  $address_2 = '--';
		  $city = '--';
		  $state = '--';
		  $zipcode = '--';
		}
		# luffy 18 December 2019 12:54 pm | Approver 1 detail
		$approver1Data=$this->Xin_model->read_user_info($terminationData[0]->approval_1);
		$approver1Designation = $this->Designation_model->read_designation_information($approver1Data[0]->designation_id);
		$approver1Jabatan = $approver1Designation[0]->designation_name;
		$approver1NIK = $approver1Data[0]->employee_id.' - '.$approver1Data[0]->username;
		$isApprovedBy1 = $terminationData[0]->approval_status_by_1;
		if((!empty($isApprovedBy1))&&($isApprovedBy1==1))
			$tandaTanganApprover1='<img src="'.site_url().'uploads/signatures/'.$approver1Data[0]->employee_id.'_ttd.png" />';
		else $tandaTanganApprover1='';

		# luffy 18 December 2019 01:20 pm | Approver 2 detail
		$approver2Data=$this->Xin_model->read_user_info($terminationData[0]->approval_2);
		$approver2Designation = $this->Designation_model->read_designation_information($approver2Data[0]->designation_id);
		$approver2Jabatan = $approver2Designation[0]->designation_name;
		$approver2NIK = $approver2Data[0]->employee_id.' - '.$approver2Data[0]->username;
		$isApprovedBy2 = $terminationData[0]->approval_status_by_2;
		if((!empty($isApprovedBy2))&&($isApprovedBy2==1))
			$tandaTanganApprover2='<img src="'.site_url().'uploads/signatures/'.$approver2Data[0]->employee_id.'_ttd.png" />';
		else $tandaTanganApprover2='';

		// set default header data
		$c_info_email = $company[0]->email;
		$c_info_phone = $company[0]->contact_number;
		$country = $this->Xin_model->read_country_info($company[0]->country);
		$c_info_address = $company[0]->address_1.' '.$company[0]->address_2.', '.$company[0]->city.' - '.$company[0]->zipcode.', '.$country[0]->country_name;
		$email_phone_address = "".$this->lang->line('dashboard_email')." : $c_info_email | ".$this->lang->line('xin_phone')." : $c_info_phone \n".$this->lang->line('xin_address').": $c_info_address";
		$header_string = $email_phone_address;
		//starting the pdf
		// set document information
		$pdf->SetCreator($author);
		$pdf->SetAuthor($author);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		// set margins
		// $pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		// set auto page breaks
		// $pdf->SetAutoPageBreak(TRUE, 25);
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor($author);
		$pdf->SetTitle($company[0]->name.' - Termination Letter');
		$pdf->SetSubject('Termination Letter');
		$pdf->SetKeywords('Termination Letter');
		// set font
		$pdf->SetFont('helvetica', 'B', 12);
		// set header and footer fonts
		//	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// ---------------------------------------------------------
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		// $pdf->SetFont('dejavusans', '', 8, '', true);
		$pdf->SetFont('helvetica', '', 10, '', true);
		// Add a page
		// This method has several options, check the source code documentation for more information.
		// $pdf->AddPage();
		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(0, 0, 0, true);
		// set auto page breaks false
		$pdf->SetAutoPageBreak(false, 0);
		// add a page
		$pdf->AddPage('P', 'A4');
		// Display image on full page
		$pdf->Image(base_url().'uploads/logo/background_form_hrd.png', 0, 0, 210, 297, 'PNG', '', '', true, 200, '', false, false, 0, false, false, true);
		$tbl = "<html><head>";
    $tbl .= "<style>
		    .logoApgCenter{
					display: block;
					margin-left: auto;
					margin-right: auto;
					width: 50%;
		    }
				.garisTable{
					border:2px solid #444; padding:2px; border-bottom:2px solid #444;
				}
	    </style>";
    $tbl .= "</head><body>";
		$tbl .= '
			<div>

				<table cellpadding="0">
					<tr>
						<td width="130">
							&nbsp;
						</td>
						<td width="500">
							<table>
								<tr>
									<td height="120">&nbsp;</td>
								</tr>
							</table>

							<table>
								<tr>
									<td align="center" height="60">
										<h3><u>BERITA KEPUTUSAN PERUSAHAAN</u></h3>
										<br/>
										<h3>'.$letterNumber.'</h3>
									</td>
								</tr>
							</table>

							<table cellpadding="10" width="1000">
								<tr>
									<td width="100" height="50">
										Perihal
									</td>
									<td align="left" width="400" height="50" align="left">
										: Pemutusan Hubungan Kerja
									</td>
								</tr>
							</table>

							<table cellpadding="10" width="1000">
								<tr>
									<td height="10">Dengan hormat,</td>
								</tr>
								<tr>
									<td width="160" height="10">
										Diberitahukan kepada :
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td width="100" >
										Nama <br />
										NIK <br />
										Jabatan <br />
									</td>
									<td align="left" align="left">
										: '.$employeeName.' <br />
										: '.$employeeNIK.' <br />
										: '.$jabatan.'
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Bahwa Perusahaan <strong>'.$company_name.' Corporation Ltd</strong> memutuskan untuk mengakhiri hubungan kerja dengan Sdr/i '.$employeeName.'.
										Keputusan ini diambil dikarenakan Sdr/i '.$reason.'.
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Dengan demikian terhitung mulai tanggal '.$terminationDate.' hubungan kerja antara
										<strong>'.$company_name.' Corporation Ltd</strong> dengan Sdr/i. sudah berakhir dan perusahaan <strong>'.$company_name.' Corporation Ltd</strong> sudah tidak bertanggung jawab dengan kegiatan yang dilakukan oleh Sdr/i. di wilayah Cambodia.
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Demikian Surat Pemutusan Hubungan Kerja ini kami sampaikan. Atas perhatian dan pengertian Sdr/i kami ucapkan terima kasih.
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Dengan Hormat, <br />
										<strong>'.$company_name.' Corporation Ltd</strong><br /><br />
										Ditetapkan di Cambodia<br />
										Pada Tanggal : '.$terminationDate.'
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<strong>'.$approver1Jabatan.'</strong> <br /><br />
										'.$tandaTanganApprover1.'
									</td>
									<td>
										<strong>'.$approver2Jabatan.'</strong> <br /><br />
										'.$tandaTanganApprover2.'
									</td>
								</tr>
								<tr>
									<td>
										<strong>'.$approver1NIK.'</strong>
									</td>
									<td>
										<strong>'.$approver2NIK.'</strong>
									</td>
								</tr>
							</table>
						</td>
						<td width="130">
							&nbsp;
						</td>
					</tr>
				</table>
			</div>';
		$tbl .= '</body></html>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		//Close and output PDF document
		// luffy 28 nov 2019
		ob_start();
		# luffy 18 Dec 2019 08:44 pm
		ob_clean();
		ob_flush();
		$pdf->Output('Termination_Letter_'.$fname.'.pdf', 'I');
		ob_end_flush();
		# luffy 18 Dec 2019 08:44 pm
		ob_end_clean();
		exit;
	 }

}
