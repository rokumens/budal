<?php
 /**
 * @author   luffy
 * Custom for Appraisal module
 * Subtask
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Appraisal_sub_task extends MY_Controller {
	 public function __construct() {
    parent::__construct();
		$this->load->model("Appraisal_sub_task_model");
		$this->load->model("Appraisal_task_model");
		$this->load->model("Appraisal_model");
		$this->load->model("Kpi_sales_model");
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
	// # luffy 28 Dec 2019 11:41 am
	// function checkUrl404($url){
	// 	$code = '';
  //   if( is_null( $url ) ){
  //     return false;
  //   }else{
	// 		// url for test, fb ig twitter etc....
	// 		// $url='https://www.google.com/search?q=test&oq=test&aqs=chrome..69i57j0l2j69i61l2j69i65l2j69i60.1162j0j7&sourceid=chrome&ie=UTF-8';
  //     $handle = curl_init($url);
  //     curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
	// 		// curl_setopt($handle,CURLOPT_URL,$url);
	// 		// curl_setopt($handle,CURLOPT_RETURNTRANSFER,1);
	// 		// curl_setopt($handle,CURLOPT_FOLLOWLOCATION,1);
	// 		/* Get the html page or whatever is linked in $url. */
  //     curl_exec($handle);
	// 		/* Check for 404 (file not found). */
  //     $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	// 		// checking http status code
	// 	 	switch($httpCode){
	// 	 		 case 0:
	//   			 return FALSE;
	//   			 break;
	// 	 		 case 200:
	//   			 return TRUE;
	//   			 break;
	// 	 		 case 302:
	//   			 return TRUE;
	//   			 break;
	//   		 case 401:
	//   			 return FALSE;
	//   			 break;
	//   		 case 404:
	//   			 return FALSE;
	//   			 break;
	//   		 case 500:
	//   			 return FALSE;
	//   			 break;
	//   		 case 502:
	//   			 return FALSE;
	//   			 break;
	//   		 case 503:
	//   			 return FALSE;
	//   			 break;
	//   		 default:
	//   			 return FALSE;
	//   			 break;
	// 	 	}
  //     curl_close($handle);
  //   }
	// }
	public function index() {
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(empty($session))
			redirect('admin/');
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_performance!='true')
			redirect('admin/dashboard');
		$data['title'] = 'Subtask | '.$this->Xin_model->site_title();
		$data['getAllJobTask'] = $this->Appraisal_sub_task_model->get_all_job_task_list($session['user_id']);
		$data['allSubTaskStatus'] = $this->Appraisal_sub_task_model->all_subtask_status_selain_completed();	// for combobox status
		$data['breadcrumbs'] = 'Subtask';
		$data['path_url'] = 'appraisal_sub_task';
		if(in_array('1003',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/appraisal/sub_task_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data);
			}else{
				redirect('admin/');
			}
		}else{
			redirect('admin/dashboard');
		}
  }
  public function subtask_list() {
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session))
			$this->load->view("admin/appraisal/sub_task_list", $data);
		else redirect('admin/');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('2014',$role_resources_ids)){ #myOwn
			$allSubTask = $this->Appraisal_sub_task_model->my_own_appraisal_subtask($session['user_id']);
		}elseif(in_array('2084',$role_resources_ids)){ #auditor
			$allSubTask = $this->Appraisal_sub_task_model->all_appraisal_subtask();
		}elseif(in_array('2085',$role_resources_ids)){ #reviewer
			$allSubTask = $this->Appraisal_sub_task_model->allSubtaskforReviewer();
		}else{ //pake my own biar: No data available in table
			$allSubTask = $this->Appraisal_sub_task_model->my_own_appraisal_subtask($session['user_id']);
		}
		// else{ #ga boleh dimunculkan
		// 	$allSubTask = $this->Appraisal_sub_task_model->all_appraisal_subtask();
		// }
		$data = array();
    foreach($allSubTask->result() as $r) {
			if(in_array('2011',$role_resources_ids))  #update
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-subtask_id="'. $r->id .'"><span class="fa fa-pencil"></span></button></span>';
			else $edit = '';
			if(in_array('2012',$role_resources_ids)) { #del
				($session['user_id']==$r->created_by)?$asMyOwn=TRUE:$asMyOwn=FALSE;
				$isValidByAuditor=$r->auditor_is_valid;
				$isQualifiedByReviewer=$r->reviewer_is_qualified;
				$subtaskStatusId=$r->status;
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->id .'"><span class="fa fa-trash"></span></button></span>';
				if(($asMyOwn==TRUE)&&($isValidByAuditor==1)&&($isQualifiedByReviewer==1)&&($subtaskStatusId==1)) {
					$delete = '';
				}
			} else {
				$delete = '';
			}
			if(in_array('2013',$role_resources_ids))  #view
				$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light view-data" data-toggle="modal" data-target=".view-modal-data-bg" data-subtask_id="'. $r->id .'"><span class="fa fa-eye"></span></button></span>';
			else $view = '';
			$combhr = $edit.$delete.$view;
			$mainTask = $this->Appraisal_sub_task_model->getJobTask($r->appraisal_task_id);
			$subtaskTitle = $this->Appraisal_sub_task_model->getSubtaskNameBySubtaskTitleId($r->name);
			$subTaskStatus = $this->Appraisal_sub_task_model->getStatus($r->id);
			if($subTaskStatus->status==3){ #pending
				$subTaskStatusName = $subTaskStatus->name.'<br /><small>Waiting for validation from auditor.</small>';
			}elseif($subTaskStatus->status==2){ #valid
				$subTaskStatusName = $subTaskStatus->name.'<br /><small>Now waiting for qualification from reviewer.</small>';
			}else{$subTaskStatusName = $subTaskStatus->name;}
			if(($r->status==4)&&($r->auditor_is_reject==1)){
				$statusBy='<br /><small>by: Auditor</small>';
			}elseif(($r->status==4)&&($r->reviewer_is_reject==1)){
				$statusBy='<br /><small>by: Reviewer</small>';
			}else{$statusBy='';}
			$data[]=array(
				$combhr,
				ucfirst($subtaskTitle->sub_task_title_name),
				$mainTask->name,
				// # luffy 1 January 2019 03:38 pm | no tumpan tindih data row
				// $subTaskStatusName.$statusBy,
				$subTaskStatusName,
				$r->username,
				$r->location_name ? $r->location_name : '-',
				date('d-M-Y',strtotime($r->created_at))
			);
    }
	  $output=array(
		   "draw" => $draw,
			 "recordsTotal" => $allSubTask->num_rows(),
			 "recordsFiltered" => $allSubTask->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
  }
	// get auto subtask name based on the main task.
	public function get_subtask() {
		 $data['title'] = $this->Xin_model->site_title();
		 $session = $this->session->userdata('username');
		 $maintaskId = $this->uri->segment(4);
		 $userId = $session['user_id'];
		 $getAllJobTask = $this->Appraisal_sub_task_model->get_all_job_task_list($session['user_id']);
		 $data = array('maintask_id' => $maintaskId, 'user_id' => $userId);
		 if(!empty($session))
			 $this->load->view("admin/appraisal/get_subtask", $data);
		 else redirect('admin/');
		 $draw = intval($this->input->get("draw"));
		 $start = intval($this->input->get("start"));
		 $length = intval($this->input->get("length"));
	}
	public function add_subtask() {
		if($this->input->post('add_type')=='subtask') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$urlParam=$this->input->post('url');
			# luffy 24 Dec 2019 03:59 pm
			$checkingUrl=$this->Appraisal_sub_task_model->checkUrlInSubtask($this->getHost($urlParam))->row();
			if(!empty($checkingUrl)){
				$existingUrl=$checkingUrl->url;
				$urlParamByUser=$this->getHost($urlParam);
				if($urlParamByUser == $existingUrl)
					$Return['error'] = "Url has been used.";
			}
			if($this->input->post('job_task')==='chooseSubtask'){
	    	$Return['error'] = "Please choose main task.";
			}elseif($this->input->post('job_task')===''){
				$Return['error'] = "Ask your leader to assign a task for you if you don't have any task yet.";
			}elseif($urlParam===''){
				$Return['error'] = "Please enter url.";
			}elseif(filter_var($urlParam, FILTER_VALIDATE_URL) === FALSE) {
			  $Return['error'] = "Not a valid URL";
			}
			// validating the file
			elseif($_FILES['scan_file']['size'] == 0) {
				 $fname = '';	// no file
				 # luffy 28 Dec 2019 12:51 pm
				 $fileHash = '';	// no hash
				 $Return['error'] = 'Please upload the file.';
			}elseif($_FILES['scan_video']['size'] == 0) {
				$fname = '';	// no file
				# luffy 28 Dec 2019 12:51 pm
				$fileHash = '';	// no hash
				$Return['error'] = 'Please upload the video.';
			}else{
				// upload the file image go go goooomu...gomuuuu..nooooo.!!!!	=)
				if(is_uploaded_file($_FILES['scan_file']['tmp_name'])) {
					//checking image type
					$allowed = array('png','jpg','jpeg');
					$filename = $_FILES['scan_file']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["scan_file"]["tmp_name"];
						$folderDestination = "uploads/appraisal/subtask/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$lname = basename($_FILES["scan_file"]["name"]);
						$newfilename = 'subtask_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $folderDestination.$newfilename);
						# luffy 28 Dec 2019 01:02 pm | get the hash before file being uploaded :)
						$uploadedHash=sha1_file($folderDestination.$newfilename);
						$checkingHash=$this->Appraisal_sub_task_model->checkHashInSubtask($uploadedHash)->row();
						if(!empty($checkingHash)){
							$existingHash=$checkingHash->file_hash;
							if($uploadedHash == $existingHash){
								$Return['error'] = "This image you pick has been used.";
								# existed? removed the image biar ga numpuk2 nyampah :)
								unlink($folderDestination.$newfilename);
							}
						}else{
							$fname = $newfilename;
							$fileHash=sha1_file($folderDestination.$newfilename);
						}
					} else {$Return['error'] = 'The attachment file type must be in: png, jpg, jpeg';}
				}
				// upload the file video go go goooomu...gomuuuu..nooooo.!!!!	=)
				if(is_uploaded_file($_FILES['scan_video']['tmp_name'])) {
					//checking image type
					$allowed = array('mp4','mkv','avi');
					$filename = $_FILES['scan_video']['name'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						$tmp_name = $_FILES["scan_video"]["tmp_name"];
						$folderDestination = "uploads/appraisal/subtask/";
						// basename() may prevent filesystem traversal attacks;
						// further validation/sanitation of the filename may be appropriate
						$lname = basename($_FILES["scan_video"]["name"]);
						$newfilename = 'subtask_'.round(microtime(true)).'.'.$ext;
						move_uploaded_file($tmp_name, $folderDestination.$newfilename);
						# luffy 28 Dec 2019 01:02 pm | get the hash before file being uploaded :)
						$uploadedHash=sha1_file($folderDestination.$newfilename);
						$checkingHash=$this->Appraisal_sub_task_model->checkHashInSubtask($uploadedHash)->row();
						if(!empty($checkingHash)){
							$existingHash=$checkingHash->file_hash;
							if($uploadedHash == $existingHash){
								$Return['error'] = "This video you pick has been used.";
								# existed? removed the image biar ga numpuk2 nyampah :)
								unlink($folderDestination.$newfilename);
							}
						}else{
							$fnameVideo = $newfilename;
							$fileHashVideo=sha1_file($folderDestination.$newfilename);
						}
					} else {$Return['error'] = 'The attachment file type must be in: mp4, mkv, avi';}
				}
			}
			if($Return['error']!='') $this->output($Return);
			$session = $this->session->userdata('username');
			$data = array(
				'appraisal_task_id' => $this->input->post('job_task'),
				'name' => $this->input->post('subtask_name'),
				'description' => $this->input->post('subtask_description'),
				'point' => 0,
				'status' => 3, //1=qualified, 2=valid, 3=pending, 4=rejected
				'file' => $fname,
				'file_hash' => $fileHash,
				'file_video' => $fnameVideo,
				'file_video_hash' => $fileHashVideo,
				'url' => $this->gethost($urlParam),
				'created_by' => $session['user_id'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$result = $this->Appraisal_sub_task_model->add($data);
			if ($result == TRUE)
				$Return['result'] = "Subtask added.";
			else $Return['error'] = $this->lang->line('xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	public function read(){
	 $data['title'] = $this->Xin_model->site_title();
	 $role_resources_ids = $this->Xin_model->user_role_resource();
	 $session = $this->session->userdata('username');
	 $userId=$session['user_id'];
	 $id = $this->input->get('subtask_id');
	 $result = $this->Appraisal_sub_task_model->read_task_list_information($id);
	 $allJobTask = $this->Appraisal_sub_task_model->get_all_job_task_list($userId);
	 $subtaskTitle = $this->Appraisal_sub_task_model->getSubtaskNameBySubtaskTitleId($result[0]->name);
	 $allSubTaskStatus = $this->Appraisal_sub_task_model->get_all_subtask_status();
	 $allSubtaskTitle=$this->Appraisal_sub_task_model->getAllSubtaskTitle();
	 $allSubtaskStatusAuditor=$this->Appraisal_sub_task_model->allSubTaskStatusAuditor();
	 $allSubtaskStatusReviewer=$this->Appraisal_sub_task_model->allSubTaskStatusReviewer();
	 $allSubtaskStatus=$this->Appraisal_sub_task_model->allSubTaskStatus();
	 // to limit the Appraisal based on Progress Percentage & Due Date
	 // after due date, NO MORE EDITTING and set Appraisal Status to Completed/Delayed/Overdue
	 // It's applied only in Employee not in Admin.
	 $appraisalTaskId=$result[0]->appraisal_task_id;
	 $allSubtaskTitleByMainTask=$this->Appraisal_sub_task_model->getAllSubtaskTitleByMainTaskId($appraisalTaskId);
	 $userIdCreateTheSubTask=$this->Appraisal_sub_task_model->my_own_appraisal_subtask($userId)->row();
	 in_array('2084',$role_resources_ids)?$asAuditor=TRUE:$asAuditor=FALSE;
	 in_array('2085',$role_resources_ids)?$asReviewer=TRUE:$asReviewer=FALSE;
	 ($session['user_id']==$result[0]->created_by)?$asMyOwn=TRUE:$asMyOwn=FALSE;
	 //subtask status detail description
	 if($result[0]->status==3){ #pending
		 $subTaskStatusName = $result[0]->subtask_status_name.'<br /><small>Waiting for validation from auditor.</small>';
	 }elseif($result[0]->status==2){ #valid
		 $subTaskStatusName = $result[0]->subtask_status_name.'<br /><small>Now waiting for qualification from reviewer.</small>';
	 }else{$subTaskStatusName = $result[0]->subtask_status_name;}
	 if(!empty($userIdCreateTheSubTask->created_by)){
		 $getCurrentUserAppraisal=$this->Appraisal_sub_task_model->read_appraisal_information($userIdCreateTheSubTask->created_by,$appraisalTaskId); //current user id, appraisal task id.
		 if(!is_null($getCurrentUserAppraisal)){
			 $dueDate=$getCurrentUserAppraisal->due_date;
			 $today=date('Y-m-d');
			 $data = array(
				 'subtask_id' => $result[0]->id,
				 'jobTaskName' => $result[0]->jobtask_jobtaskname,
				 'subtaskName' => $subtaskTitle->sub_task_title_name,
				 'subTaskDescription' => $result[0]->description,
				 'statusDetail' => $subTaskStatusName,
				 'statusId' => $result[0]->subtaskStatusId,
				 'statusName' => $result[0]->subtask_status_name,
				 'created_by' => $result[0]->created_by,
				 'allJobTask' => $allJobTask,
				 'jobTaskId' => $appraisalTaskId,
				 'allSubTaskStatus' => $allSubTaskStatus,
				 'subtaskStatusId' => $result[0]->status,
				 'allSubtaskTitle' => $allSubtaskTitle,
				 'allSubtaskByMainTask' => $allSubtaskTitleByMainTask,
				 'subtaskTitleId' => $result[0]->name,
				 'subtaskUrl' => $result[0]->url,
				 'asAuditor' => $asAuditor,
				 'asReviewer' => $asReviewer,
				 'asMyOwn' => $asMyOwn,
				 'isValidByAuditor' => $result[0]->auditor_is_valid,
				 'isQualifiedByReviewer' => $result[0]->reviewer_is_qualified,
				 'isRejectedByAuditor' => $result[0]->auditor_is_reject,
				 'isRejectedByReviewer' => $result[0]->reviewer_is_reject,
				 'dueDate' => $dueDate,
				 'today' => $today,
			 );
		 }
	 }
	 // ..and below is for admin / whoever who was not creating the subtask.
	 $data = array(
		 'subtask_id' => $result[0]->id,
		 'jobTaskName' => $result[0]->jobtask_jobtaskname,
		 'subtaskName' => $subtaskTitle->sub_task_title_name,
		 'subTaskDescription' => $result[0]->description,#$arrayName = array('' => , );
		 'subtaskFile' => $result[0]->file,
		 'subtaskFileVideo' => $result[0]->file_video,
		 'statusDetail' => $subTaskStatusName,
		 'statusId' => $result[0]->subtaskStatusId,
		 'statusName' => $result[0]->subtask_status_name,
		 'created_by' => $result[0]->created_by,
		 'allJobTask' => $allJobTask,
		 'jobTaskId' => $result[0]->appraisal_task_id,
		 'allSubTaskStatus' => $allSubTaskStatus,
		 'subtaskStatusId' => $result[0]->status,
		 'allSubtaskTitle' => $allSubtaskTitle,
		 'allSubtaskByMainTask' => $allSubtaskTitleByMainTask,
		 'subtaskTitleId' => $result[0]->name,
		 'subtaskUrl' => $result[0]->url,
		 'allSubTaskStatusAuditor' => $allSubtaskStatusAuditor,
		 'allSubTaskStatusReviewer' => $allSubtaskStatusReviewer,
		 'allSubtaskStatus' => $allSubtaskStatus,
		 'asAuditor' => $asAuditor,
		 'asReviewer' => $asReviewer,
		 'asMyOwn' => $asMyOwn,
		 'isValidByAuditor' => $result[0]->auditor_is_valid,
		 'isQualifiedByReviewer' => $result[0]->reviewer_is_qualified,
		 'isRejectedByAuditor' => $result[0]->auditor_is_reject,
		 'isRejectedByReviewer' => $result[0]->reviewer_is_reject,
	 );
	 $session = $this->session->userdata('username');
	 if(!empty($session))
		 $this->load->view('admin/appraisal/dialog_appraisal_sub_task', $data);
	 else redirect('admin/');
 }
 public function update(){
	 if($this->input->post('edit_type')=='subtask_update') {
		 $session = $this->session->userdata('username');
		 $id = $this->uri->segment(4);	// subtask id
		 $subTaskCreatedBy=$this->Appraisal_sub_task_model->read_task_list_information($id)[0]->created_by;
		 #$employeeId = $session['user_id']; // user by session
		 $employeeId = $subTaskCreatedBy; // user by created the subtask based on db.
		 $role_resources_ids = $this->Xin_model->user_role_resource();
		 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		 $Return['csrf_hash'] = $this->security->get_csrf_hash();
		 $existingFile = $this->Appraisal_sub_task_model->getFileName($id);
		 $existingFileVideo = $this->Appraisal_sub_task_model->getFileNameVideo($id);
		 $subtaskNameParam=$this->input->post('subtask_name');
		 $subtaskStatusParam=$this->input->post('subtask_status');
		 $subtaskDescParam=$this->input->post('subtask_description');
		 $urlParam=$this->input->post('url');

		 // image
		 $fname=$existingFile->file;
		 $fileHash=$existingFile->file_hash;
		 // video
		 $fnameVideo=$existingFileVideo->file_video;
		 $fileHashVideo=$existingFileVideo->file_video_hash;
		 # luffy 24 Dec 2019 03:59 pm
		 $checkingUrl=$this->Appraisal_sub_task_model->checkUrlInSubtask($this->getHost($urlParam))->row();
		 if(!empty($checkingUrl)){
			 $existingUrl=$checkingUrl->url;
			 $urlParamByUser=$this->getHost($urlParam);
			 if($urlParamByUser == $existingUrl)
				 $Return['error'] = "Url has been used.";
		 }
		 if($subtaskNameParam===''){
		 		$Return['error'] = "Subtask name can not be empty.";
		 }elseif((in_array('2084',$role_resources_ids)) &&($this->input->post('subtask_status')==='3')){ #2=pending
		 		$Return['error'] = "Please validate or reject this subtask for status.";
		 }elseif((in_array('2085',$role_resources_ids)) &&($this->input->post('subtask_status')==='2')){ #2=pending
		 		$Return['error'] = "Please qualify or reject this subtask.";
		 }
		 # luffy 24 Dec 2019 04:42 pm
		 elseif($urlParam===''){
				$Return['error'] = "Please enter url.";
		 }elseif(filter_var($urlParam, FILTER_VALIDATE_URL) === FALSE) {
			  $Return['error'] = "Not a valid URL";
		 // validate the file
	 	 }
		 /*
		 jazz 7821 - 12jan2020 : 17:15
		 dimatikan karen filename udah didefinisikan di line 428
		 */
		 // elseif($_FILES['scan_file']['size'] == 0){
			//  	$fileHash = '';	// no hash
			// 	if(!empty($existingFile)){
			// 		$fname=$existingFile->file;
			// 	}else{
			// 		$fname='';
		 // 		 	$Return['error'] = 'Please upload the file.';
			// 	}
		 // }
		 else{
			 // image
			 $allowed = array('png','jpg','jpeg');
			 $filename = $_FILES['scan_file']['name'];
			 //checking file type
			 $ext = pathinfo($filename, PATHINFO_EXTENSION);
			 $tmp_name = $_FILES["scan_file"]["tmp_name"];
			 // video
			 $allowedVideo = array('mp4','mkv','avi');
			 $filenameVideo = $_FILES['scan_video']['name'];
			 //checking file type
			 $extVideo = pathinfo($filenameVideo, PATHINFO_EXTENSION);
			 $tmp_nameVideo = $_FILES["scan_video"]["tmp_name"];
			 // Remove the file too from directory.
			 $folderDestination = "uploads/appraisal/subtask/";

			 # luffy 24 Dec 2019 03:59 pm
			 $checkingUrl=$this->Appraisal_sub_task_model->checkUrlInSubtask($this->getHost($urlParam))->row();
			 if(!empty($checkingUrl)){
			 	$existingUrl=$checkingUrl->url;
			 	$urlParamByUser=$this->getHost($urlParam);
			 	if($urlParamByUser == $existingUrl)
			 		$Return['error'] = "Url has been used.";
			 }else{
				 // upload the file go go goooomu...gomuuuu..nooooo.!!!!	=)
				 if(is_uploaded_file($_FILES['scan_file']['tmp_name'])){
					 if(in_array($ext,$allowed)){
						 // basename() may prevent filesystem traversal attacks;
						 // further validation/sanitation of the filename may be appropriate
						 // $lname = basename($_FILES["scan_file"]["name"]);
						 $newfilename = 'subtask_'.round(microtime(true)).'.'.$ext;
						 move_uploaded_file($tmp_name, $folderDestination.$newfilename);
						 if(!empty($existingFile))
							 @unlink($folderDestination.$existingFile->file);
						 # luffy 28 Dec 2019 07:38 pm | get the hash before file being uploaded :)
						 $uploadedHash=sha1_file($folderDestination.$newfilename);
						 $checkingHash=$this->Appraisal_sub_task_model->checkHashInSubtask($uploadedHash)->row();
						 if(!empty($checkingHash)){
							 $existingHash=$checkingHash->file_hash;
							 if($uploadedHash == $existingHash){
								 $Return['error'] = "This image you pick has been used.";
								 # existed? removed the image biar ga numpuk2 nyampah :)
								 unlink($folderDestination.$newfilename);
							 }
						 }else{
							 $fname = $newfilename;
							 $fileHash=sha1_file($folderDestination.$newfilename);
						 }
				 	 } else {
						 $Return['error'] = 'The attachment file type must be in: png, jpg, jpeg';
					 }
				 }
				 if(is_uploaded_file($_FILES['scan_video']['tmp_name'])){
					 if(in_array($extVideo,$allowedVideo)){
						 // basename() may prevent filesystem traversal attacks;
						 // further validation/sanitation of the filename may be appropriate
						 // $lname = basename($_FILES["scan_file"]["name"]);
						 $newfilenameVideo = 'subtask_'.round(microtime(true)).'.'.$extVideo;
						 move_uploaded_file($tmp_nameVideo, $folderDestination.$newfilenameVideo);
						 if(!empty($existingFileVideo))
							 @unlink($folderDestination.$existingFileVideo->file_video);
						 # luffy 28 Dec 2019 07:38 pm | get the hash before file being uploaded :)
						 $uploadedHashVideo=sha1_file($folderDestination.$newfilenameVideo);
						 $checkingHashVideo=$this->Appraisal_sub_task_model->checkHashInSubtaskVideo($uploadedHashVideo)->row();
						 if(!empty($checkingHashVideo)){
							 $existingHashVideo=$checkingHashVideo->file_video_hash;
							 if($uploadedHashVideo == $existingHashVideo){
								 $Return['error'] = "This video you pick has been used.";
								 # existed? removed the image biar ga numpuk2 nyampah :)
								 unlink($folderDestination.$newfilenameVideo);
							 }
						 }else{
							 $fnameVideo = $newfilenameVideo;
							 $fileHashVideo=sha1_file($folderDestination.$newfilenameVideo);
						 }
				 	 }else {
						 $Return['error'] = 'The attachment file type must be in: mp4, mkv, avi';
					 }
				 }
			 }
		 }

		 if($Return['error']!='') $this->output($Return);
		 // to limit the Appraisal based on Progress Percentage & Due Date
		 // after due date, NO MORE EDITTING and set Appraisal Status to Completed/Delayed/Overdue
		 // It's applied only in User not in Admin.
		 $readSubtask = $this->Appraisal_sub_task_model->read_task_list_information($id);
		 $session = $this->session->userdata('username');
		 $appraisalTaskId=$readSubtask[0]->appraisal_task_id;
		 $userIdCreateTheSubTask=$this->Appraisal_sub_task_model->my_own_appraisal_subtask($employeeId)->row();
		 // update the appraisal list too, starting from here.
		 $getCurrentUserAppraisal=$this->Appraisal_sub_task_model->read_appraisal_information($userIdCreateTheSubTask->created_by,$appraisalTaskId); //current user id, appraisal task id.
		 $dueDate=$getCurrentUserAppraisal->due_date;
		 $point=0; // Update the POINT too.
		 $auditorIsValid=0;$reviewerIsValid=0;
		 $statusByAuditor=3; #if rejected by auditor force it back to pending.
		 $statusByReviewer=3; #if rejected by reviewer force it back to pending.
		 $today=date("Y-m-d");
		 $todayZz = new DateTime($today);
		 $dueDateZz = new DateTime($dueDate);
		 $interval = $todayZz->diff($dueDateZz);
		 $diffZZ=$interval->format('%R%a');
		 $diff=(int)$diffZZ;
		 // hanya employee
		 if(!empty($userIdCreateTheSubTask)&&($employeeId==$session['user_id'])){
			 // after Delayed and Overdue, no more editting the subtask.
			 // LIMIT the subtask if overdue given in Apprisal.
			 if($diff>=0){	// kalo mo kasih spare, buat if($diff>=7) = 7 hari / seminggu
					$data=array(
						'name' => $subtaskNameParam,
						'url' => $this->gethost($urlParam),
						'description' => $subtaskDescParam,
						'status' => $subtaskStatusParam,
						'point' => $point,
						'file' => $fname,
						'file_hash' => $fileHash,
						'file_video' => $fnameVideo,
						'file_video_hash' => $fileHashVideo,
					);
					$result = $this->Appraisal_sub_task_model->update_record($data,$id);
			 } // overdue limit
			 // Assigned Task was Overdue.
			 else{
			 		$Return['error'] = "Overdue. Can't update the current task anymore.";
					//update appraisal status is now Overdue
					$dataToAppraisalOverdue = array('appraisal_status'=>5);
				  $appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;	// appraisal task id
				  $this->Appraisal_model->updateByAppraisalTaskIdAndEmployeeId($dataToAppraisalOverdue, $appraisalTaskId, $employeeId);
			 }
		 }else{ // auditor/reviewer/selain si pembuat subtask.
			 if($diff>=0){
				 #Auditor
				 if(in_array('2084',$role_resources_ids)){
					 if($subtaskStatusParam==2){ #is_valid
						// 	$auditorIsValid=1; #is_valid
						// 	$statusByAuditor=$subtaskStatusParam;
							$dataAuditor=array(
		 					 'status' => 2,
		 					 'auditor_id' => $session['user_id'],
		 					 'auditor_is_valid' => 1,
							 'auditor_is_reject' => 0,
		 					 'auditor_date' => date('Y-m-d H:i:s'),
		 				 );
					 }elseif($subtaskStatusParam==4){ #is_reject
						// 	$auditorIsValid=1; #is_valid
						// 	$statusByAuditor=$subtaskStatusParam;
							$dataAuditor=array(
		 					 'status' => 4,
		 					 'auditor_id' => $session['user_id'],
		 					 'auditor_is_valid' => 0,
		 					 'auditor_is_reject' => 1,
		 					 'auditor_date' => date('Y-m-d H:i:s'),
		 				 );
					 }else{
						 $dataAuditor=array(
							'status' => $subtaskStatusParam,
							'auditor_id' => $session['user_id'],
							'auditor_is_valid' => 0,
							'auditor_is_reject' => 0,
							'auditor_date' => date('Y-m-d H:i:s'),
						 );
					 }
					 $result = $this->Appraisal_sub_task_model->update_record($dataAuditor,$id);
				 } // end auditor
				 #Reviewer
				 elseif(in_array('2085',$role_resources_ids)){
					 $currentSubtask=$this->Appraisal_sub_task_model->read_task_list_information($id);
					 if($subtaskStatusParam==1){ #is_qualified
						 $dataReviewer=array(
							 'status' => 1,
							 'point' => 1,
							 'auditor_is_valid' => 1, //back to 0 if when rejected (need auditor to validate it again)
							 'reviewer_id' => $session['user_id'],
							 'reviewer_is_qualified' => 1,
							 'reviewer_is_reject' => 0,
							 'reviewer_date' => date('Y-m-d H:i:s'),
						 );
					 }elseif($subtaskStatusParam==4){ #is_reject
						 $dataReviewer=array(
							 'status' => 4,
							 'point' => 0,
							 'auditor_is_valid' => 0, //back to 0 if when rejected (need auditor to validate it again)
							 'reviewer_id' => $session['user_id'],
							 'reviewer_is_qualified' => 0,
							 'reviewer_is_reject' => 1,
							 'reviewer_date' => date('Y-m-d H:i:s'),
						 );
					 }else{
						 $dataReviewer=array(
							 'status' => $subtaskStatusParam,
							 'point' => 0,
							 'auditor_is_valid' => 0, //back to 0 if when rejected (need auditor to validate it again)
							 'reviewer_id' => $session['user_id'],
							 'reviewer_is_qualified' => 0,
							 'reviewer_is_reject' => 0,
							 'reviewer_date' => date('Y-m-d H:i:s'),
						 );
					 }
					 $result = $this->Appraisal_sub_task_model->update_record($dataReviewer,$id);
					 //progress percentage starting here >> sending to appraisal
					 // current bonus
					 $currentBonusInAppraisal=$getCurrentUserAppraisal->final_amount;
					 // current grade
					 $currentGradeInAppraisal=$getCurrentUserAppraisal->grade_id;
					 //get current total point
					 $appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;	// appraisal task id
					 $totalPointByTaskIdAndUserId = $this->Appraisal_sub_task_model->getSumSubTaskPoint($appraisalTaskId, $employeeId)[0]->sum_total_point;	// $appraisalTaskId, $userId
					 // New Grading System
					 #$objGradeDetail=$this->Appraisal_sub_task_model->getGradeDetailByTaskId($appraisalTaskId);
					 $gradeDetailId=$this->Appraisal_sub_task_model->allGradesByLowestMonthlRequirement($appraisalTaskId)->grade_detail_id;
					 $objGradeDetail=$this->Appraisal_sub_task_model->getGradeDetailByMainTaskAndGradeDetailId($appraisalTaskId,$gradeDetailId);
					 $minimumMonthlyRequirement=$objGradeDetail->monthlyRequirement;
					 // count progress percentage for Grade
					 if($totalPointByTaskIdAndUserId>0){
						 // limit the task progress percentage
						 // batasin percentage, kalo ga gini ntar jadi 110%
						 $progressPercentage = ($totalPointByTaskIdAndUserId/$minimumMonthlyRequirement)*100;
						 if($totalPointByTaskIdAndUserId>=$minimumMonthlyRequirement)
							 $progressPercentage=100;
					 }else{$progressPercentage=0;}
					 // update appraisal status too.
					 // pake patokan task progress percentage.
					 if($progressPercentage==0){ // pending
						 $appraisalStatus=1;
						 $overdueDays=0;
						 $delayedDays=0;
					 }elseif($progressPercentage>0 && $progressPercentage<100 && $diff>=0){ //in progress
						 $appraisalStatus=2;
						 $overdueDays=0;
						 $delayedDays=0;
						 $bonus = 0; // bonus 0 if still in progress.
					 }elseif($progressPercentage>=100 && $diff>=0){	//completed
						 $appraisalStatus=3;
						 $overdueDays=0;
						 $delayedDays=0;
					 }elseif(($progressPercentage==100)&&($diff<=-1)){	//delayed
						 $appraisalStatus=4;
						 $overdueDays=0;
						 $delayedDays=$diff;
					 }elseif(($progressPercentage<100)&&($diff<=-1)){	//overdue
						 $appraisalStatus=5;
						 $overdueDays=$diff;
						 $delayedDays=0;
					 }
					 // for BONUS -> final_amount
					 // current bonus in appraisal
					 $bonus = $currentBonusInAppraisal;
					 $minimumBonusRequirement = array();
					 $arrBonus = array();
					 $allCurrentKpi = $this->Kpi_sales_model->all_kpi_by_jobtask($appraisalTaskId);
					 foreach($allCurrentKpi as $singKpi){
							$minimumBonusRequirement[]=$singKpi->minimum_requirement;
							$arrBonus[]=$singKpi->employee_bonus;
					 }
					 $currentTotalPoint=$totalPointByTaskIdAndUserId;
					 if(in_array($currentTotalPoint, $minimumBonusRequirement)){
							$key = array_search($currentTotalPoint, $minimumBonusRequirement);
							$bonus=$arrBonus[$key];
							$currentMinimumBonusRequirement = $minimumBonusRequirement[$key];
							$arrKeys = array_keys($minimumBonusRequirement);
							// count the bonus
							$progressPercentageBonus = ($totalPointByTaskIdAndUserId/$currentMinimumBonusRequirement)*100;
					 }
					 // for Final GRADE id that the employee reached in the end of appraisal's period.
					 // #staticVars
					 // $appraisalTaskId=380;
					 // $employeeId=76;
					 // $currentTotalPoint=3;
					 $shiftId=1;
					 $arrTask = array();
					 $arrMonthlyRequirement = array();
					 //get the subdept id
					 $currSubDeptId = $this->Appraisal_sub_task_model->getSubDeptIdByTaskIdEmployeeId($appraisalTaskId,$employeeId)->sub_department_id;
					 #$allCurrentTask = $this->Appraisal_task_model->all_appraisal_task_by_subdept($currSubDeptId)->result();
					 $shiftId=$this->Appraisal_sub_task_model->getShiftByMainTask($appraisalTaskId)->office_shift_id;
					 $allCurrentTask = $this->Appraisal_task_model->allAppraisalByMainTaskAndShift($currSubDeptId,$shiftId)->result();
					 foreach($allCurrentTask as $singCurrentTask){
						 $arrMonthlyRequirement[]=$singCurrentTask->monthlyRequirement;
						 $arrTask[]=$singCurrentTask->id;
					 }
					 $currentMonthlyRequirement=current($arrMonthlyRequirement);
					 $nextMonthlyRequirement=next($arrMonthlyRequirement);
					 $endMonthlyRequirement=end($arrMonthlyRequirement);
					 $currentTaskId=current($arrTask);
					 $nextTaskId=next($arrTask);
					 $endTaskId=end($arrTask);
					 //// NOTE: Allowed up to 3 Grades only. If want to available up to more than 3, just add/insert the other elseif nextRequirement.
					 #if(($currentTotalPoint<=$currentMonthlyRequirement)||($currentTotalPoint===$currentMonthlyRequirement)){
					 if($currentTotalPoint<$currentMonthlyRequirement){
						 // before reach the first requirement
						 $finalGradeId=0;
					 }elseif($currentTotalPoint===$currentMonthlyRequirement){
						 // the beginning of the monthly requirement.
						 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($appraisalTaskId,$currentMonthlyRequirement)->grade_detail_id;
					 }elseif(($currentTotalPoint>$currentMonthlyRequirement)&&($currentTotalPoint<$nextMonthlyRequirement)){
						 // it's in between the beginning & next monthly requirement.
						 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($appraisalTaskId,$currentMonthlyRequirement)->grade_detail_id;
					 }// tambah di sini if more than 3 grades.
					 elseif($currentTotalPoint===$nextMonthlyRequirement){
						 // it's matched with the next requirement.
						 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($appraisalTaskId,$nextMonthlyRequirement)->grade_detail_id;
					 }elseif(($currentTotalPoint>$nextMonthlyRequirement)&&($currentTotalPoint<$endMonthlyRequirement)){
						 // it's in between next and the last monthly requirement.
						 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($appraisalTaskId,$nextMonthlyRequirement)->grade_detail_id;
					 }elseif(($currentTotalPoint===$endMonthlyRequirement)||($currentTotalPoint>=$endMonthlyRequirement)){
						 // in the end of monthly requirement
						 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($appraisalTaskId,$endMonthlyRequirement)->grade_detail_id;
					 }else{
						 // no need to update the assign task, no condition matched at all from above.
						 $dataToAppraisal = array(
							 'final_point' => $totalPointByTaskIdAndUserId,
							 'progress_percentage' => $progressPercentage,
							 'appraisal_status' => $appraisalStatus,
							 'delayed_days' => $delayedDays,
							 'final_amount' => $bonus
						 );
					 }
					 $dataToAppraisal = array(
						 'final_point' => $totalPointByTaskIdAndUserId,
						 'progress_percentage' => $progressPercentage,
						 'appraisal_status' => $appraisalStatus,
						 'delayed_days' => $delayedDays,
						 'final_amount' => $bonus,
						 'final_grade_id' => $finalGradeId, #grade_detail_id
					 );
					 // update appraisal
					 $this->Appraisal_model->updateByAppraisalTaskIdAndEmployeeId($dataToAppraisal,$appraisalTaskId,$employeeId);
					 // end appraisal
				 } // end reviewer
			 } // overdue limit
			 // Assigned Task was Overdue.
			 else{
					$Return['error'] = "Overdue. Can't update the current task anymore.";
					//update appraisal status is now Overdue
					$dataToAppraisalOverdue = array('appraisal_status'=>5);
					$appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;	// appraisal task id
					$this->Appraisal_model->updateByAppraisalTaskIdAndEmployeeId($dataToAppraisalOverdue, $appraisalTaskId, $employeeId);
			 }
		 }
		 if($Return['error']!='') $this->output($Return);
		 // Subtask updated succeed.
		 if($result == TRUE) {
		 	 $Return['result'] = "Subtask updated.";
		 }else{	//subtask updated = true
		 	 $Return['error'] = $this->lang->line('xin_error_msg');
		 }
		 $this->output($Return);
		 exit;
	 }
 }
 public function delete() {
	 $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
	 $id = $this->uri->segment(4);
	 $session = $this->session->userdata('username');
	 #$appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;	// appraisal task id
	 $Return['csrf_hash'] = $this->security->get_csrf_hash();
	 $employeeId = $session['user_id']; // current user
	 // to limit the Appraisal based on Progress Percentage & Due Date
	 // after due date, NO MORE EDITTING and set Appraisal Status to Completed/Delayed/Overdue
	 // It's applied only in User not in Admin.
	 $result = $this->Appraisal_sub_task_model->read_task_list_information($id);
	 $session = $this->session->userdata('username');
	 $appraisalTaskId=$result[0]->appraisal_task_id;
	 $userIdCreateTheSubTask=$this->Appraisal_sub_task_model->my_own_appraisal_subtask($session['user_id'])->row();
	 $getCurrentUserAppraisal=$this->Appraisal_sub_task_model->read_appraisal_information($userIdCreateTheSubTask->created_by,$appraisalTaskId); //current user id, appraisal task id.
	 $dueDate=$getCurrentUserAppraisal->due_date;
	 // current bonus
	 $currentBonusInAppraisal=$getCurrentUserAppraisal->final_amount;
	 // current grade
	 $currentGradeInAppraisal=$getCurrentUserAppraisal->grade_id;
	 // after Delayed and Overdue, no more editting the subtask.
	 $today=date('Y-m-d');
	 $todayZz = new DateTime($today);
	 $dueDateZz = new DateTime($dueDate);
	 $interval = $todayZz->diff($dueDateZz);
	 $diffZZ=$interval->format('%R%a');
	 $diff=(int)$diffZZ;
	 // LIMIT the subtask if overdue given in Apprisal.
	 if($diff>=0){	// kalo mo kasih spare, buat if($diff>=7) = 7 hari / seminggu
			 if(isset($id)){
				 //get task id first
				 $appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;
				 // Remove the file too from directory.
				 $existingFile = $this->Appraisal_sub_task_model->getFileName($id);
				 $folderDestination = "uploads/appraisal/subtask/";
				 if(!empty($existingFile))
					 @unlink($folderDestination.$existingFile->file);
				 // DELETE the Subtask.
				 $result = $this->Appraisal_sub_task_model->delete_record($id);
				 $Return['result'] = "Subtask deleted.";
				 // update the appraisal list too, starting from here.
				 //get current total point
				 $totalPointByTaskIdAndUserId = $this->Appraisal_sub_task_model->getSumSubTaskPoint($appraisalTaskId, $employeeId)[0]->sum_total_point;	// $appraisalTaskId, $userId
				 // New Grading System
				 $objGradeDetail=$this->Appraisal_sub_task_model->getGradeDetailByTaskId($appraisalTaskId);
				 $gradeId = $objGradeDetail->gradeId;
				 $minimumMonthlyRequirement=$objGradeDetail->monthlyRequirement;
				 // count progress percentage for Grade
				 if($totalPointByTaskIdAndUserId>0){
					 // limit the task progress percentage
					 // batasin percentage, kalo ga gini ntar jadi 110%, ga lucu :)
					 $progressPercentage = ($totalPointByTaskIdAndUserId/$minimumMonthlyRequirement)*100;
					 if($totalPointByTaskIdAndUserId>=$minimumMonthlyRequirement)
						 $progressPercentage=100;
				 }else{$progressPercentage=0;}
				 // update appraisal status too.
				 // pake patokan task progress percentage.
				 if($progressPercentage==0){ // pending
					 $appraisalStatus=1;
					 $overdueDays=0;
					 $delayedDays=0;
				 }elseif($progressPercentage>0 && $progressPercentage<100 && $diff>=0){ // in progress
					 $appraisalStatus=2;
					 $overdueDays=0;
					 $delayedDays=0;
					 $bonus = 0; // bonus 0 if still in progress.
				 }elseif($progressPercentage>=100 && $diff>=0){	// completed
					 $appraisalStatus=3;
					 $overdueDays=0;
					 $delayedDays=0;
				 }elseif(($progressPercentage==100)&&($diff<=-1)){	// delayed
					 $appraisalStatus=4;
					 $overdueDays=0;
					 $delayedDays=$diff;
				 }elseif(($progressPercentage<100)&&($diff<=-1)){	// overdue
					 $appraisalStatus=5;
					 $overdueDays=$diff;
					 $delayedDays=0;
				 }
				 // for BONUS -> final_amount
				 // current bonus in appraisal
				 $bonus = $currentBonusInAppraisal;
		 		 $minimumBonusRequirement = array();
		 		 $arrBonus = array();
		 		 $allCurrentKpi = $this->Kpi_sales_model->all_kpi_by_jobtask($appraisalTaskId);
		 		 foreach($allCurrentKpi as $singKpi){
		 				$minimumBonusRequirement[]=$singKpi->minimum_requirement;
		 				$arrBonus[]=$singKpi->employee_bonus;
		 		 }
		 		 $currentTotalPoint=$totalPointByTaskIdAndUserId;
		 		 if(in_array($currentTotalPoint, $minimumBonusRequirement)){
			 			$key = array_search($currentTotalPoint, $minimumBonusRequirement);
			 			$bonus=$arrBonus[$key];
			 			$currentMinimumBonusRequirement = $minimumBonusRequirement[$key];
			 			$arrKeys = array_keys($minimumBonusRequirement);
						// count the bonus
						$progressPercentageBonus = ($totalPointByTaskIdAndUserId/$currentMinimumBonusRequirement)*100;
		 		 }
				 // for Final GRADE id that the employee reached in the end of appraisal's period.
		 		 $arrTask = array();
		 		 $arrMonthlyRequirement = array();
				 //get the subdept id
				 $currSubDeptId = $this->Appraisal_sub_task_model->getSubDeptIdByTaskIdEmployeeId($appraisalTaskId,$employeeId)->sub_department_id;
				 $allCurrentTask = $this->Appraisal_task_model->all_appraisal_task_by_subdept($currSubDeptId)->result();
		 		 foreach($allCurrentTask as $singCurrentTask){
		 			 $arrMonthlyRequirement[]=$singCurrentTask->monthlyRequirement;
		 			 $arrTask[]=$singCurrentTask->id;
		 		 }
				 $currentMonthlyRequirement=current($arrMonthlyRequirement);
				 $nextMonthlyRequirement=next($arrMonthlyRequirement);
				 $endMonthlyRequirement=end($arrMonthlyRequirement);
				 $currentTaskId=current($arrTask);
				 $nextTaskId=next($arrTask);
				 $endTaskId=end($arrTask);
				 //// NOTE: Allowed up to 3 Grades only. If want to available up to more than 3, just add/insert the other elseif nextRequirement.
				 #if(($currentTotalPoint<=$currentMonthlyRequirement)||($currentTotalPoint===$currentMonthlyRequirement)){
				 if($currentTotalPoint<=$currentMonthlyRequirement){
					 // the beginning of the monthly requirement.
					 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($currentTaskId)->grade_id;
				 }elseif(($currentTotalPoint>$currentMonthlyRequirement)&&($currentTotalPoint<$nextMonthlyRequirement)){
					 // it's in between the beginning & next monthly requriement.
					 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($currentTaskId)->grade_id;
				 }elseif($currentTotalPoint===$nextMonthlyRequirement){
					 // it's matched with the next requirement.
					 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($nextTaskId)->grade_id;
				 }elseif(($currentTotalPoint>$nextMonthlyRequirement)&&($currentTotalPoint<$endMonthlyRequirement)){
					 // it's in between next and the last monthly requirement.
					 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($nextTaskId)->grade_id;
				 #}elseif(($currentTotalPoint===$endMonthlyRequirement)||($currentTotalPoint>=$endMonthlyRequirement)){
				 }elseif($currentTotalPoint>=$endMonthlyRequirement){
					 // in the end of monthly requirement
					 $finalGradeId=$this->Appraisal_task_model->getGradeListByTaskId($endTaskId)->grade_id;
				 }else{
					 // no need to update the assign task, no condition matched at all from above.
					 $dataToAppraisal = array(
					 	 'final_point' => $totalPointByTaskIdAndUserId,
					 	 'progress_percentage' => $progressPercentage,
					 	 'appraisal_status' => $appraisalStatus,
					 	 'delayed_days' => $delayedDays,
					 	 'final_amount' => $bonus
					 );
				 }
				 $dataToAppraisal = array(
				 	 'final_point' => $totalPointByTaskIdAndUserId,
				 	 'progress_percentage' => $progressPercentage,
				 	 'appraisal_status' => $appraisalStatus,
				 	 'delayed_days' => $delayedDays,
				 	 'final_amount' => $bonus,
				 	 'final_grade_id' => $finalGradeId, #grade_detail_id
				 );
				 //update appraisal
				 $this->Appraisal_model->updateByAppraisalTaskIdAndEmployeeId($dataToAppraisal,$appraisalTaskId,$employeeId);
			 } else {
				 $Return['error'] = $this->lang->line('xin_error_msg');
			 }
	 } // overdue limit
	 // Assigned Task was Overdue.
	 else{
			$Return['error'] = "Overdue. Can't delete this task anymore.";
			//appraisal status is now Overdue
			$dataToAppraisalOverdue = array('appraisal_status'=>5);
			$appraisalTaskId = $this->Appraisal_sub_task_model->read_task_list_information($id)[0]->appraisal_task_id;	// appraisal task id
			$this->Appraisal_model->updateByAppraisalTaskIdAndEmployeeId($dataToAppraisalOverdue,$appraisalTaskId,$employeeId);
	 }
	 $this->output($Return);
 }
 # luffy 24 Dec 2019 03:38 pm
 // to get only host without http or https
 function getHost($url){
		$find_h = '#^http(s)?://#';
		$find_w = '/^www\./';
		$replace = '';
		$output = preg_replace( $find_h, $replace, $url );
		$output = preg_replace( $find_w, $replace, $output );
		return $output;
 }
}
