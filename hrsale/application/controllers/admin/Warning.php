<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warning extends MY_Controller {

	 public function __construct() {
    parent::__construct();
		//load the model
		$this->load->model("Warning_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Employees_model");
		// luffy 20 Dec 2019 07:41 pm
		$this->load->library('Pdf');
		$this->load->model("Department_model");
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
		$data['title'] = $this->lang->line('left_warnings').' | '.$this->Xin_model->site_title();
		$data['all_employees'] = $this->Employees_model->employeeActiveAPG();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['allApprover'] = $this->Xin_model->get_approver_list()->result();
		$data['breadcrumbs'] = $this->lang->line('left_warnings');
		$data['path_url'] = 'warning';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('20',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/warning/warning_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			}else{
				redirect('admin/');
			}
		}else{
			redirect('admin/dashboard');
		}
   }
	 // get company > employees
	 public function get_employees_warning_to() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/warning/get_employees_warning_to", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 // get company > employees
	 public function get_employees_warning_by() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'company_id' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/warning/get_employees_warning_by", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 // get employee > warning type
	 public function get_warning_type() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'warning_to' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/warning/get_warning_type", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

	 // get employee > warning counter
	 public function get_warning_counter() {
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$data = array(
			'warning_to' => $id
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/warning/get_warning_counter", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }

   public function warning_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$userEmail=$session['email'];
		if(!empty($session))
			$this->load->view("admin/warning/warning_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('377',$role_resources_ids))
			$warning = $this->Warning_model->get_employee_warning($session['user_id']);
		else $warning = $this->Warning_model->get_warning();
		$data = array();
    foreach($warning->result() as $r) {
			// get user > warning to
			$user = $this->Xin_model->read_user_info($r->warning_to);
			// user full name
			if(!is_null($user)){
				$warning_to = $user[0]->first_name.' '.$user[0]->last_name;
				$location = $user[0]->fingerprint_location;
			} else {
				$warning_to = '--';
				$location = 'X';
			}
			// get user > warning by
			$user_by = $this->Xin_model->read_user_info($r->warning_by);
			// user full name
			if(!is_null($user_by))
				$warning_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
			else $warning_by = '--';
			// get warning date
			$warning_date = $this->Xin_model->set_date_format($r->warning_date);
			// get status
			if($r->status==0): $status = $this->lang->line('xin_pending');
			elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
			// get warning type
			$warning_type = $this->Warning_model->read_warning_type_information($r->warning_type_id);
			if(!is_null($warning_type))
				$wtype = $warning_type[0]->type;
			else $wtype = '--';
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company))
				$comp_name = $company[0]->name;
			else $comp_name = '--';
			if(in_array('226',$role_resources_ids))  //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-warning_id="'. $r->warning_id . '"><span class="fa fa-pencil"></span></button></span>';
			else $edit = '';
			if(in_array('227',$role_resources_ids))  // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->warning_id . '"><span class="fa fa-trash"></span></button></span>';
			else $delete = '';
			if(in_array('238',$role_resources_ids))  //view
				if(($userEmail==='8000@asiapowergames.com')||($userEmail==='7200@asiapowergames.com')||($userEmail==='7369@asiapowergames.com')||($userEmail==='7380@asiapowergames.com')){
					$view='<span data-toggle="tooltip" data-placement="top" title="View & Approval"><a href="'.site_url().'admin/warning/details/'.$r->warning_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				}else{
					#modal
					$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-warning_id="'. $r->warning_id . '"><span class="fa fa-eye"></span></button></span>';
				}
			else $view = '';
			$combhr = $edit.$view.$delete;
			$data[] = array(
				$combhr,
				$warning_to,
				$location,
				$wtype,
				$r->subject,
				$warning_by,
				$warning_date,
				$status
			);
    }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $warning->num_rows(),
			 "recordsFiltered" => $warning->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }

	public function read(){ //modal
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('warning_id');
		$result = $this->Warning_model->read_warning_information($id);
		$getCounter = $this->Warning_model->getCounterByEmployeeId($result[0]->warning_to);
		$counter=$getCounter->countWarningCounter;
		$warningStatus=$result[0]->status;
		if($counter==1) $ordinalNumber='st';
		elseif($counter==2) $ordinalNumber='nd';
		else $ordinalNumber='rd';
		$allApprover = $this->Xin_model->get_approver_list()->result();
		$data = array(
			'warning_id' => $result[0]->warning_id,
			'company_id' => $result[0]->company_id,
			'warning_to' => $result[0]->warning_to,
			'warning_by' => $result[0]->warning_by,
			// 'approvedBy' => $result[0]->approved_by,
			'warning_date' => $result[0]->warning_date,
			'warning_type_id' => $result[0]->warning_type_id,
			'subject' => $result[0]->subject,
			'description' => $result[0]->description,
			'counter' => $counter,	// luffy
			'ordinalNumber' => $ordinalNumber,	// luffy
			'status' => $warningStatus,
			'all_employees' => $this->Xin_model->all_employees(),
			'get_all_companies' => $this->Xin_model->get_companies(),
			'all_warning_types' => $this->Warning_model->all_warning_types(),
			# luffy 21 Dec 2019 03:59 pm
			'letterNumber' => $result[0]->warning_letter_number,
			'approval_1'=>$result[0]->approval_1,
			'approval_2'=>$result[0]->approval_2,
			'allApprover'=>$allApprover,
		);
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view('admin/warning/dialog_warning', $data);
		else redirect('admin/');
	}

	// Validate and add info in database
	public function add_warning() {
		if($this->input->post('add_type')=='warning') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$session=$this->session->userdata('username');
	    $userId=$session['user_id'];
			$description = $this->input->post('description');
			$approval1 = $this->input->post('approval_by_1');
			$approval2 = $this->input->post('approval_by_2');
			$warningTypeParam = $this->input->post('type');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$getCounter = $this->Warning_model->getCounterByEmployeeId($this->input->post('warning_to'));
			if(!empty($getCounter))
				$counter=$getCounter->countWarningCounter;
			else $counter=0;
			if($this->lang->line('xin_employee_error_warning_type')==1) $ordinalNumber='st';
			elseif($this->lang->line('xin_employee_error_warning_type')==2) $ordinalNumber='nd';
			else $ordinalNumber='rd';
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('warning_to')==='') {
	      $Return['error'] = $this->lang->line('xin_employee_error_warning');
			}elseif($counter>=3){
				 $Return['error'] = "Can't continue this action. <br /> This employee has already got warning letter 3 times.";
			}elseif($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_warning_type');
			}elseif($this->input->post('subject')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_subject');
			}elseif($this->input->post('warning_by')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_warning_by');
			}elseif($this->input->post('warning_date')==='') {
				 $Return['error'] = $this->lang->line('xin_employee_error_warning_date');
			}elseif($approval1==='') {
				 $Return['error'] = 'Please choose approval 1.';
			}elseif($approval2==='') {
				 $Return['error'] = 'Please choose approval 2.';
			}elseif($approval1===$approval2) {
				 $Return['error'] = 'Approver can not be the same person.';
			}
			// # luffy 20 Dec 2019 05:55pm | not using upload file anymore for warning letter.
			// elseif(empty($_FILES['warning_attachmentzz']['name'])) {
			// 	$Return['error'] = "Please upload warning letter.";
			// }
			// // luffy 8 Dec 2019 - 01:26 pm
			// if(!empty($_FILES['warning_attachmentzz']['name'])) {
			// 	if(is_uploaded_file($_FILES['warning_attachmentzz']['tmp_name'])) {
			// 		//checking file type
			// 		$allowed =  array('pdf');
			// 		$filename = $_FILES['warning_attachmentzz']['name'];
			// 		$ext = pathinfo($filename, PATHINFO_EXTENSION);
			// 		if(in_array($ext,$allowed)){
			// 			$tmp_name = $_FILES["warning_attachmentzz"]["tmp_name"];
			// 			$documentd = "uploads/warning/";
			// 			// basename() may prevent filesystem traversal attacks;
			// 			// further validation/sanitation of the filename may be appropriate
			// 			$name = basename($_FILES["warning_attachmentzz"]["name"]);
			// 			$employeeId=$this->input->post('warning_to');
			// 			$employeeNIK_id = $this->Warning_model->getNIK($employeeId)->employee_id;
			// 			$newfilename = 'Warning_Letter_'.$this->input->post('type').$ordinalNumber.'_nik-'.$employeeNIK_id.'_'.round(microtime(true)).'.'.$ext;
			// 			move_uploaded_file($tmp_name, $documentd.$newfilename);
			// 			$fname = $newfilename;
			// 		}else{
			// 			$Return['error'] = "The warning letter file type must be pdf.";
			// 		}
			// 	}
			// }
			if($Return['error']!='')
	    	$this->output($Return);
			$data = array(
				'warning_to' => $this->input->post('warning_to'),
				'company_id' => $this->input->post('company_id'),
				'warning_type_id' => $warningTypeParam,
				'description' => $qt_description,
				'warning_counter' => $counter,
				'subject' => $this->input->post('subject'),
				'warning_by' => $this->input->post('warning_by'),
				'warning_date' => $this->input->post('warning_date'),
				'status' => '0',
				// # luffy 20 Dec 2019 05:56 pm | ga dipake lagi.
				// 'warning_attachment' => $fname,
				# luffy 20 Dec 2019 07:31 pm
				'approval_1' => $approval1,
				'approval_2' => $approval2,
				'created_by' => $userId,
				'created_at' => date('Y-m-d H:i:s'),
			);
			// luffy 10 Dec 2019 03:25pm | Paramaters for sending to slack.
			// send notif to Slack for approval
			$warningToData=$this->Employees_model->read_employee_information($this->input->post('warning_to'));
			$warningToName=$warningToData[0]->employee_id.' - '.$warningToData[0]->username;
			$warningByData=$this->Employees_model->read_employee_information($this->input->post('warning_by'));
			$warningByName=$warningByData[0]->employee_id.' - '.$warningByData[0]->username;
			$warningDate=date('d F Y',strtotime($this->input->post('warning_date')));
			$warningSubject=$this->input->post('subject');
			// save warning to db
			$result = $this->db->insert('xin_employee_warnings', $data);
			// get the next auto increment id
			$currentIncrementId = $this->db->insert_id();
			if ($result == TRUE){
				# luffy 21 Dec 2019 06:00 pm
				switch ($warningTypeParam) {
					case '1':
						$warningKe='1st';
						break;
					case '2':
						$warningKe='2nd';
						break;
					case '3':
						$warningKe='3rd';
						break;
				}
				$Return['result'] = 'Warning added.';
				$this->sendCreatedWarningToChannel($currentIncrementId,$warningToName,$warningKe,$warningByName,$warningDate,$warningSubject,$qt_description,$approval1,$approval2);
				// luffy 20 Dec 2019 07:56 pm
				// update letter number
				$lastQuery = $this->Warning_model->read_warning_information($currentIncrementId);
				$letterNumber = $currentIncrementId;
				$type='warning';
				$month=date('m',strtotime($lastQuery[0]->warning_date));
				$year=date('Y',strtotime($lastQuery[0]->warning_date));
				$nomorSurat=$this->nomor_surat($letterNumber,$type,$month,$year);
				$dataLetterNumber=array(
					'warning_letter_number' => $nomorSurat
				);
				$this->Warning_model->update_record($dataLetterNumber,$currentIncrementId);
			}else{
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}

	// Validate and update info in database
	public function update() {
		if($this->input->post('edit_type')=='warning') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// get the current user for approved by
			$session = $this->session->userdata('username');
			$currentUser=$session['user_id'];
			$description = $this->input->post('description');
			$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
			$approval1 = $this->input->post('approval_by_1');
			$approval2 = $this->input->post('approval_by_2');
			// luffy
			if(($this->input->post('status')==1)&&($this->input->post('warning_counter')<3))
				$counter=$this->input->post('warning_counter')+1;
		  else $counter=$this->input->post('warning_counter');
			if($counter==1) $ordinalNumber='st';
			elseif($counter==2) $ordinalNumber='nd';
			else $ordinalNumber='rd';
			if($this->input->post('company_id')==='') {
				$Return['error'] = $this->lang->line('error_company_field');
			}elseif($this->input->post('warning_to')==='') {
  			$Return['error'] = $this->lang->line('xin_employee_error_warning');
			}elseif($this->input->post('type')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_warning_type');
			}elseif($this->input->post('subject')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_subject');
			}elseif($this->input->post('warning_by')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_warning_by');
			}elseif($this->input->post('warning_date')==='') {
				$Return['error'] = $this->lang->line('xin_employee_error_warning_date');
			}elseif($approval1==='') {
				 $Return['error'] = 'Please choose approval 1.';
			}elseif($approval2==='') {
				 $Return['error'] = 'Please choose approval 2.';
			}elseif($approval1===$approval2) {
				 $Return['error'] = 'Approver can not be the same person.';
		  }
			if($Return['error']!='')
				$this->output($Return);
			// #luffy 8 Dec 2019 02:18 pm
			// elseif($this->input->post('status')==='1' && empty($this->input->post('existingWarningLetter'))) {
			// 	$Return['error'] = "Please upload warning letter.";
			// }
			$data = array(
				// 'warning_to' => $this->input->post('warning_to'),
				'company_id' => $this->input->post('company_id'),
				// 'warning_type_id' => $this->input->post('type'),
				'description' => $qt_description,
				'subject' => $this->input->post('subject'),
				'warning_by' => $this->input->post('warning_by'),
				'warning_date' => $this->input->post('warning_date'),
				'status' => $this->input->post('status'),
				'warning_counter' => $counter,
				// 'approved_by' => $currentUser,
				// 'approval_date' => date('Y-m-d H:i:s')
				# luffy 21 Dec 2019 04:03 pm
				'approval_1' => $approval1,
				'approval_2' => $approval2,
			);
			// luffy - 8 Dec 2019 02:16 pm
			// approval on warning detail page.
			// $nikApprover='8000';
			// $currentNikApprover = $this->Warning_model->getNIK($currentUser)->employee_id;
			// if($currentNikApprover!=$nikApprover){
			// 	$Return['error'] = 'Please ask 8000-Roy to approve this.';
			// }else{
				$result = $this->Warning_model->update_record($data,$id);
				if ($result == TRUE)
					$Return['result'] = $this->lang->line('xin_employee_warning_updated');
				else $Return['error'] = $this->lang->line('xin_error_msg');
			// }
			$this->output($Return);
			exit;
			if($Return['error']!='')
				$this->output($Return);
		}
	}

	# luffy - 10 Dec 2019 11:06 am
	# for updating data on warning detail
	public function update_warning_detail() {
		if($this->input->post('edit_type')=='update_warning_detail') {
			$id = $this->uri->segment(4);
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			// get the current user for approved by
			$session = $this->session->userdata('username');
			$currentUser=$session['user_id'];
			$status=$this->input->post('approval');
			$warningDetailData=$this->Warning_model->read_warning_information($id);
			# luffy 21 Dec 2019 11:57 am
			$currWarning=$this->Warning_model->read_warning_information($id);
			$approval_1=$currWarning[0]->approval_1;
			$approval_2=$currWarning[0]->approval_2;
			$approvedBy_1=$currWarning[0]->approved_by_1;
			$approvedBy_2=$currWarning[0]->approved_by_2;
			$approver_1 = $this->Employees_model->getNamebyUserId($approval_1)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_1)->username;
			$approver_2 = $this->Employees_model->getNamebyUserId($approval_2)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_2)->username;
			$approval_status_by_1 = $currWarning[0]->approval_status_by_1;
			$approval_status_by_2 = $currWarning[0]->approval_status_by_2;
			$warningType = $currWarning[0]->warning_type_id;
			switch ($warningType) {
				case 1:
					$warningKe='1st';
					break;
				case 2:
					$warningKe='2nd';
					break;
				case 3:
					$warningKe='3rd';
					break;
			}
			if(($currentUser!=$approval_1)&&($currentUser!=$approval_2)){
				# let the HR & others can still update but not allowed for approval.
				if($status!=0)
					$Return['error'] = "Please ask $approver_1 or $approver_2 for approval.";
			}else{
				# approver 1 & 2 give the approval accepted or rejected.
				if($status==0) $Return['error'] = "Please accept or reject.";
				# approver 1
				if($currentUser==$approval_1){
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
						// get the warning counter
						$getCounter = $this->Warning_model->getCounterByEmployeeId($warningDetailData[0]->warning_to);
						$currentCounter = $getCounter->countWarningCounter;
						if(($isAccepted==1)&&($currentCounter<3))
							$counter=$currentCounter+1;
					  else $counter=$currentCounter;
						$data = array(
							'status' => $isAccepted,
							'warning_counter' => $counter,
							#both approver 1 or 2 will update this data columnn whenever after approval.
							'approval_date' => date('Y-m-d H:i:s'),
							# luffy 21 Dec 2019 12:08 pm
							'approved_by_1' => $currentUser,
							'approval_date_1' => date('Y-m-d H:i:s'),
							'approval_status_by_1' => $status
						);
						// luffy 10 Dec 2019 03:25pm | Paramaters for sending to slack.
						// send notif to Slack for approval
						$warningToData=$this->Employees_model->read_employee_information($warningDetailData[0]->warning_to);
						$warningToName=$warningToData[0]->employee_id.' - '.$warningToData[0]->username;
						$warningByData=$this->Employees_model->read_employee_information($warningDetailData[0]->warning_by);
						$warningByName=$warningByData[0]->employee_id.' - '.$warningByData[0]->username;
						$approvalByData=$this->Employees_model->read_employee_information($currentUser);
						$approvalByName=$approvalByData[0]->employee_id.' - '.$approvalByData[0]->username;
						$warningDate=date('d F Y',strtotime($this->input->post('warning_date')));
						$warningSubject=$this->input->post('subject');
						$warningStatus='';
						if($status==1)
							$warningStatus='accepted';
						elseif($status==2)
							$warningStatus='rejected';
						else $warningStatus='pending';
						$result=$this->Warning_model->update_record($data,$id);
						if($result==TRUE){
							$Return['result']="Warning has been $warningStatus.";
							// send notif to channel.
							$this->sendApprovalWarningToChannel($id,$warningToName,$warningKe,$warningByName,$warningDate,$warningSubject,$warningStatus,$approvalByName);
						}else{
							$Return['error'] = $this->lang->line('xin_error_msg');
						}
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
							// get the warning counter
							$getCounter = $this->Warning_model->getCounterByEmployeeId($warningDetailData[0]->warning_to);
							$currentCounter = $getCounter->countWarningCounter;
							if(($isAccepted==1)&&($currentCounter<3))
								$counter=$currentCounter+1;
						  else $counter=$currentCounter;
							$data = array(
								'status' => $isAccepted,
								'warning_counter' => $counter,
								#both approver 1 or 2 will update this data columnn whenever after approval.
								'approval_date' => date('Y-m-d H:i:s'),
								# luffy 21 Dec 2019 12:08 pm
								'approved_by_2' => $currentUser,
								'approval_date_2' => date('Y-m-d H:i:s'),
								'approval_status_by_2' => $status
							);
							// luffy 10 Dec 2019 03:25pm | Paramaters for sending to slack.
							// send notif to Slack for approval
							$warningToData=$this->Employees_model->read_employee_information($warningDetailData[0]->warning_to);
							$warningToName=$warningToData[0]->employee_id.' - '.$warningToData[0]->username;
							$warningByData=$this->Employees_model->read_employee_information($warningDetailData[0]->warning_by);
							$warningByName=$warningByData[0]->employee_id.' - '.$warningByData[0]->username;
							$approvalByData=$this->Employees_model->read_employee_information($currentUser);
							$approvalByName=$approvalByData[0]->employee_id.' - '.$approvalByData[0]->username;
							$warningDate=date('d F Y',strtotime($this->input->post('warning_date')));
							$warningSubject=$this->input->post('subject');
							if($status==1)
								$warningStatus='accepted';
							elseif($status==2)
								$warningStatus='rejected';
							else $warningStatus='pending';
							$result=$this->Warning_model->update_record($data,$id);
							if($result==TRUE){
								$Return['result']="Warning has been $warningStatus.";
								// send notif to channel.
								$this->sendApprovalWarningToChannel($id,$warningToName,$warningKe,$warningByName,$warningDate,$warningSubject,$warningStatus,$approvalByName);
							}else{
								$Return['error'] = $this->lang->line('xin_error_msg');
							}
						}
					}
				}
			}
			$this->output($Return);
			exit;
			if($Return['error']!='')
				$this->output($Return);
		}
	}

	// link detail after click from APG Bot.
	public function details() {
		$session = $this->session->userdata('username');
		$currentUser=$session['user_id'];
		if(empty($session))
			redirect('admin/');
		$id = $this->uri->segment(4);
		$result = $this->Warning_model->read_warning_information($id);
 		if(is_null($result))
 			redirect('admin/warning');
		$warningId=$result[0]->warning_id;
		$warningTo=$this->Employees_model->read_employee_information($result[0]->warning_to);
		$submittedBy=$this->Employees_model->read_employee_information($result[0]->warning_by);
		$approvalStatus=$result[0]->status;
		$warningToFullName=$warningTo[0]->first_name.' '.$warningTo[0]->last_name.' ('.$warningTo[0]->username.')';
		$warningByFullName=$submittedBy[0]->employee_id.' - '.ucwords(strtolower($submittedBy[0]->username));
		$approval_1=$result[0]->approval_1;
		$approval_2=$result[0]->approval_2;
		$approvedBy_1=$result[0]->approved_by_1;
		$approvedBy_2=$result[0]->approved_by_2;
		$approval_status_by_1=$result[0]->approval_status_by_1;
		$approval_status_by_2=$result[0]->approval_status_by_2;
		$approver_1_name = $this->Employees_model->getNamebyUserId($approval_1)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_1)->username;
		$approver_2_name = $this->Employees_model->getNamebyUserId($approval_2)->employee_id.' - '.$this->Employees_model->getNamebyUserId($approval_2)->username;
		if($approvalStatus==0) $approvalStatusName='Pending';
		elseif($approvalStatus==1) $approvalStatusName='Accepted';
		elseif($approvalStatus==2) $approvalStatusName='Rejected';
		if($result[0]->warning_type_id==1)
			$warningType='First Warning';
		elseif($result[0]->warning_type_id==2)
			$warningType='Second Warning';
		elseif($result[0]->warning_type_id==3)
			$warningType='Third Warning';
		$warningSubject=$result[0]->subject;
		$warningDescription=$result[0]->description;
		$warningLetter=$result[0]->warning_attachment;
		$letterNumber=$result[0]->warning_letter_number;
		$sessionGoogleAccessProfile=$this->session->access_profile;
		$data = array(
			 // 'currentEmailLoggedIn' => empty($sessionGoogleAccessProfile)?'':$sessionGoogleAccessProfile->emails[0]->value,
			 'warningId' => $warningId,
			 'warningType' => $warningType,
			 'warningSubject' => $warningSubject,
			 'warningDescription' => $warningDescription,
			 'warningToFullName' => $warningToFullName,
			 'warningByFullName' => $warningByFullName,
			 'warningDate' => date('d M Y',strtotime($result[0]->warning_date)),
			 'approvedAt' => ($approvalStatus==0)?'-':date('d F Y',strtotime($result[0]->approval_date)),
			 'submittedBy' => $warningByFullName,
			 'approvalStatus' => $approvalStatus,
			 'approvalStatusName' => $approvalStatusName,
			 'warningLetter' => $warningLetter,
			 'letterNumber' => $letterNumber,
			 # luffy 21 Dec 2019 12:56 pm
			 'currentUser' => $currentUser,
			 'approval_1'=>$approval_1,
			 'approval_2'=>$approval_2,
			 'approval_1_by'=>$approver_1_name,
			 'approval_2_by'=>$approver_2_name,
			 'approval_status_by_1'=>$approval_status_by_1,
			 'approval_status_by_2'=>$approval_status_by_2,
 		);
		$data['title'] = 'Warning Detail for '.$warningToFullName;
 		$data['breadcrumbs'] = 'Warning detail';
 		$data['path_url'] = 'warning';
 		$session = $this->session->userdata('username');
 		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){
			$data['subview'] = $this->load->view("admin/warning/details", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}

	public function delete() {
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		if(isset($id)) {
			// get the approval status
			$currentWarningInfo = $this->Warning_model->read_warning_information($id);
			$isApproved=$currentWarningInfo[0]->status;
			# luffy 11 Dec 2019 - 11:04 am
			// get the current user for approved by
			$session = $this->session->userdata('username');
			$currentUser=$session['user_id'];
			$nikApprover='8000';
			$currentNikApprover = $this->Warning_model->getNIK($currentUser)->employee_id;
			// ntar dibenerin.
			// if($isApproved==1 && $currentNikApprover!=$nikApprover){
			// 	$Return['error'] = 'Please ask 8000-Roy to approve this.';
			if($isApproved==1){
				$Return['error'] = "It has been accepeted, can't delete it.";
			}else{
				// then DELETE the warning record
				$result = $this->Warning_model->delete_record($id);
				$Return['result'] = 'Warning deleted.';
			}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}

	// luffy 9 Dec 2019 - 02:33 pm
	// send channel notif to approve Warning after created.
	function sendCreatedWarningToChannel($warningId,$warningTo,$warningKe,$createdName,$warningDate,$warningSubject,$warningReason,$approver1,$approver2){
		$callSlack=curl_init('https://hooks.slack.com/services/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'); #9-it-support-kanon-a2
		$redirectTo=site_url().'admin/warning/details/'.$warningId;
		# luffy 21 Dec 2019 08:26 pm
		if($approver1=='7') $mentionApprover1='<@UCG1EANCS>'; #goku
		elseif($approver1=='54') $mentionApprover1='<@U03K0R81Z>'; #roy
		elseif($approver1=='106') $mentionApprover1='<@UQQ4H3LHW>'; #medusa
		elseif($approver1=='11') $mentionApprover1='<@U488W9NUD>'; #rocky
		elseif($approver1=='73') $mentionApprover1='<@UJ9H9LDHR>'; #caroline
		elseif($approver1=='56') $mentionApprover1='<@UHYCRABSM>'; #helen
		if($approver2=='7') $mentionApprover2='<@UCG1EANCS>'; #goku
		elseif($approver2=='54') $mentionApprover2='<@U03K0R81Z>'; #roy
		elseif($approver2=='106') $mentionApprover2='<@UQQ4H3LHW>'; #medusa
		elseif($approver2=='11') $mentionApprover2='<@U488W9NUD>'; #rocky
		elseif($approver2=='73') $mentionApprover2='<@UJ9H9LDHR>'; #caroline
		elseif($approver2=='56') $mentionApprover2='<@UHYCRABSM>'; #helen
		$array = array(
			'username' => 'APG Bot',
			// 'channel' => 'GJ32TFJ2G', #9-it-support-kanon-a2
			'channel' => 'DFTV5U3E3', #luffy
			'text' => "$warningKe warning letter just created and need your approval. $mentionApprover1 $mentionApprover2", #roy
			'mrkdwn' => true,
			'attachments' => array(
				 array(
					'color' => '#ff4757',
					'title' => "$warningKe warning for $warningTo",
					'fallback' => 'fallback',
					'pretext' => '',
					'author_name' => ">>Please <$redirectTo|click here> for approval.",
					'author_link' => '#',
					'author_icon' => '',
					#'title_link' => '',
					'text' => 'Warning Subject: '.$warningSubject,
					'fields' => array(
						array(
							'title' => 'Reason: '.$warningReason,
							'value' => 'Warning Date: '.$warningDate,
							'short' => false
						)
					),
					'footer' => "Warning letter created by *$createdName* | Thank you for your kind attention.",
					'footer_icon'=> 'https://emoji.slack-edge.com/T03JZKZCX/apg/5032c072b6a519ac.png'
				)
			)
		);
		$data = json_encode($array);
		curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
		curl_setopt($callSlack, CURLOPT_CRLF, true);
		curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
			'Content-Type => application/json',
			'Content-Length => ' . strlen($data))
		);
		$result = curl_exec($callSlack);
		curl_close($callSlack);
		return $result;
	}

	// luffy 10 Dec 2019 - 05:14 pm
	// send channel notif when warning has been approved/rejected
	function sendApprovalWarningToChannel($warningId,$warningTo,$warningKe,$createdName,$warningDate,$warningSubject,$warningStatus,$approvalByName){
		$callSlack=curl_init('https://hooks.slack.com/services/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'); #9-it-support-kanon-a2
		$redirectTo=site_url().'admin/warning/details/'.$warningId;
		$array = array(
			'username' => 'APG Bot',
			// 'channel' => 'GJ32TFJ2G', #9-it-support-kanon-a2
			'channel' => 'DFTV5U3E3', #luffy
			'text' => "$warningKe warning letter for $warningTo has been $warningStatus by $approvalByName. Fyi <@UJ9H9LDHR> <@UHYCRABSM>",
			'mrkdwn' => true,
			'attachments' => array(
				 array(
					'color' => '#ff4757',
					'title' => "",
					'fallback' => 'fallback',
					'pretext' => '',
					'author_name' => "<$redirectTo|Click here> for detail.",
					'author_link' => '#',
					'author_icon' => '',
					'text' => '',
					'fields' => array(
						array(
							'title' => '',
							'value' => '',
							'short' => false
						)
					),
					'footer' => '',
					'footer_icon'=> ''
				)
			)
		);
		$data = json_encode($array);
		curl_setopt($callSlack, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($callSlack, CURLOPT_POSTFIELDS, $data);
		curl_setopt($callSlack, CURLOPT_CRLF, true);
		curl_setopt($callSlack, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($callSlack, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($callSlack, CURLOPT_HTTPHEADER, array(
			'Content-Type => application/json',
			'Content-Length => ' . strlen($data))
		);
		$result = curl_exec($callSlack);
		curl_close($callSlack);
		return $result;
	}

	# luffy 20 Dec 2019 08:09 pm
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
	public function warning_letter() {
		// $system = $this->Xin_model->read_setting_info(1);
	 	// create new PDF document
		$session = $this->session->userdata('username');
		if(empty($session))
			redirect('admin/');
 		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(5);
		$warningData=$this->Warning_model->read_warning_information($id);
		$creator=$this->Employees_model->getNamebyUserId(35);
	  $author=$creator->employee_id.' - '.$creator->username;
		$user = $this->Xin_model->read_user_info($warningData[0]->warning_to);
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$jabatan = $designation[0]->designation_name;
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		$departmentName =$department[0]->department_name;
		switch ($warningData[0]->warning_type_id) {
			case 1:
				$warningKe='Satu (1)';
				break;
			case 2:
				$warningKe='Dua (2)';
				break;
			case 3:
				$warningKe='Tiga (3)';
				break;
		}
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		$clogo = base_url().'uploads/logo/signin/apg.png';
		$employeeName = $user[0]->first_name.' '.$user[0]->last_name;
		$employeeNIK = $user[0]->employee_id.' - '.$user[0]->username;
		$reason=$warningData[0]->description;
		$warningDate=$warningData[0]->warning_date;
		$warningDate=date('d F Y',strtotime($warningDate));
		$letterNumber=$warningData[0]->warning_letter_number;
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
		$approver1Data=$this->Xin_model->read_user_info($warningData[0]->approval_1);
		$approver1Designation = $this->Designation_model->read_designation_information($approver1Data[0]->designation_id);
		$approver1Jabatan = $approver1Designation[0]->designation_name;
		$approver1NIK = $approver1Data[0]->employee_id.' - '.$approver1Data[0]->username;
		$isApprovedBy1 = $warningData[0]->approval_status_by_1;
		if((!empty($isApprovedBy1))&&($isApprovedBy1==1))
			$tandaTanganApprover1='<img src="'.site_url().'uploads/signatures/'.$approver1Data[0]->employee_id.'_ttd.png" />';
		else $tandaTanganApprover1='';

		# luffy 18 December 2019 01:20 pm | Approver 2 detail
		$approver2Data=$this->Xin_model->read_user_info($warningData[0]->approval_2);
		$approver2Designation = $this->Designation_model->read_designation_information($approver2Data[0]->designation_id);
		$approver2Jabatan = $approver2Designation[0]->designation_name;
		$approver2NIK = $approver2Data[0]->employee_id.' - '.$approver2Data[0]->username;
		$isApprovedBy2 = $warningData[0]->approval_status_by_2;
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
		$pdf->SetTitle($company[0]->name.' - Warning Letter');
		$pdf->SetSubject('Warning Letter');
		$pdf->SetKeywords('Warning Letter');
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
									<td align="center" height="100">
										<h3><u>BERITA KEPUTUSAN PERUSAHAAN</u></h3>
										<br/>
										<h3>'.$letterNumber.'</h3>
									</td>
								</tr>
							</table>

							<table cellpadding="10" width="1000">
								<tr>
									<td width="300" height="10">
										Surat Peringatan ini diberikan kepada :
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td width="140" >
										Nama <br />
										NIK <br />
										Jabatan <br />
										Departemen
									</td>
									<td align="left">
										: '.$employeeName.' <br />
										: '.$employeeNIK.' <br />
										: '.$jabatan.'<br />
										: '.$departmentName.'
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Dengan ini perusahaan <strong>'.$company_name.' Corporation Ltd</strong> memberikan Surat Peringatan berikut ini:
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td width="140" >
										Surat Peringatan ke <br />
										Alasan <br />
									</td>
									<td align="left" width="860">
										: '.$warningKe.' <br />
										: '.$reason.'
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Demikian Surat Peringatan ini dikeluarkan untuk dapat dijadikan sebagai bahan perhatian.
									</td>
								</tr>
							</table>

							<table cellpadding="10">
								<tr>
									<td>
										Ditetapkan di Cambodia<br />
										Pada Tanggal : '.$warningDate.'
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
		$pdf->Output('Warning_Letter_'.$fname.'.pdf', 'I');
		ob_end_flush();
		# luffy 18 Dec 2019 08:44 pm
		ob_end_clean();
		exit;
	 }

}
