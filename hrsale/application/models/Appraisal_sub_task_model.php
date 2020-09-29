<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_sub_task_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
	public function all_appraisal_subtask() {
    $sql = 'SELECT
              subtask.*,
              employee.username, employee.first_name, employee.last_name, employee.fingerprint_location,
              location.location_name
            FROM luffy_appraisal_sub_task AS subtask
               LEFT JOIN xin_employees AS employee ON employee.user_id = subtask.created_by
               LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            ORDER BY subtask.id DESC';
    $query = $this->db->query($sql);
    if(!is_null($query))
      return $query;
    else return null;
	}
	public function allSubtaskforReviewer() {
    $sql = 'SELECT
              subtask.*,
              employee.username, employee.first_name, employee.last_name, employee.fingerprint_location,
              location.location_name
            FROM luffy_appraisal_sub_task AS subtask
               LEFT JOIN xin_employees AS employee ON employee.user_id = subtask.created_by
               LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE (subtask.status=1 AND subtask.reviewer_is_qualified=1) OR (subtask.status=2 AND subtask.auditor_is_valid=1)
            ORDER BY subtask.id DESC';
    $query = $this->db->query($sql);
    if(!is_null($query))
      return $query;
    else return null;
	}
  // view my own
	public function my_own_appraisal_subtask($employeeId){
    $sql = 'SELECT
              subtask.*,
              employee.username, employee.first_name, employee.last_name, employee.fingerprint_location,
              location.location_name
            FROM luffy_appraisal_sub_task AS subtask
               LEFT JOIN xin_employees AS employee ON employee.user_id = subtask.created_by
               LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE subtask.created_by=?
            ORDER BY subtask.id DESC';
    $bind = array($employeeId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query;
    else return null;
	}
  // task should be taken from the task which has been assigned to employee.
	public function get_all_job_task_list($employeeId){
    $sql = 'SELECT
              appraisal.*,
              jobtask.id AS jobtask_id, jobtask.name AS jobtask_name
            FROM luffy_appraisal AS appraisal
               LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.id = appraisal.appraisal_task_id
            WHERE appraisal.employee_id=?
            ORDER BY appraisal.id DESC';
    $binds = array($employeeId);
    $query = $this->db->query($sql,$binds);
    return $query->result();
  }
  // get all subtask list for combobox in add template selain Completed
	public function all_subtask_status_selain_completed(){
	  $query = $this->db->query("SELECT * FROM luffy_appraisal_sub_task_status WHERE id<>1 ORDER BY name DESC");
    return $query->result();
	}
  // get all subtask list for combobox in update template.
	public function get_all_subtask_status(){
	  $query = $this->db->query("SELECT * FROM luffy_appraisal_sub_task_status ORDER BY name DESC");
    return $query->result();
	}
  // luffy add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('luffy_appraisal_sub_task', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// luffy update
	public function update_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('luffy_appraisal_sub_task',$data))
			return true;
		else return false;
	}
  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_appraisal_sub_task');
	}
  // get task's all task by id
  public function getJobTask($id) {
     $sql = 'SELECT
               subtask.*,
               jobtask.id, jobtask.name
             FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.id = subtask.appraisal_task_id
             WHERE subtask.appraisal_task_id=? ORDER BY subtask.id DESC';
     $binds = array($id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get task's status by id
  public function getStatus($id) {
     $sql = 'SELECT
               subtask.status,
               subtask_status.name
             FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal_sub_task_status AS subtask_status ON subtask_status.id = subtask.status
             WHERE subtask.id=? LIMIT 1';
     $binds = array($id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get subtask by //
  public function checkSubtaskId($id) {
    $this->db->select('id');
    $query = $this->db->get_where('luffy_appraisal_sub_task', ['id'=>$id]);
    if ($query->num_rows() > 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
  // get file by id
  public function getFileName($id) {
     $sql = 'SELECT file, file_hash FROM luffy_appraisal_sub_task WHERE id=?';
     $binds = array($id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get file video by id
  public function getFileNameVideo($id) {
     $sql = 'SELECT file_video, file_video_hash FROM luffy_appraisal_sub_task WHERE id=?';
     $binds = array($id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get current final point for this appraisal from the appraisal table
  public function getCurrentFinalPoint($subTaskId) {
     $sql = 'SELECT
               appraisal.final_point
             FROM luffy_appraisal AS appraisal
                LEFT JOIN luffy_appraisal_sub_task AS subtask ON appraisal.appraisal_task_id = subtask.appraisal_task_id
             WHERE subtask.id=? LIMIT 1';
     $binds = array($subTaskId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get total SUM by point from sub appraisal task.
  public function getSumSubTaskPoint($appraisalTaskId,$userId) {
     $sql = 'SELECT
              SUM(point) AS sum_total_point
             FROM luffy_appraisal_sub_task WHERE appraisal_task_id=? AND created_by=?';
     $binds=array($appraisalTaskId,$userId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->result();
     } else {
       return null;
     }
  }
  // get main task name
  public function getMaintaskName($appraisalTaskId) {
     $sql = 'SELECT name FROM luffy_appraisal_task WHERE id=?';
     $binds=array($appraisalTaskId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->result();
     } else {
       return null;
     }
  }
  // get sub department id by task id and employee id.
  public function getSubDeptIdByTaskIdEmployeeId($appraisalTaskId,$userId) {
     $sql = 'SELECT sub_department_id
             FROM luffy_appraisal WHERE appraisal_task_id=? AND employee_id=?';
     $binds=array($appraisalTaskId,$userId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get grade
  public function getGradeDetailByTaskId($mainTaskId){
     $sql = 'SELECT
              grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              grade.grade_detail_id AS gradeId,gradeDetail.grade_name as gradeName
            FROM luffy_appraisal AS appraisal
              LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = appraisal.appraisal_task_id
              LEFT JOIN luffy_appraisal_sub_task AS subtask ON maintask.id = subtask.appraisal_task_id
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = appraisal.grade_id -- AND grade.sub_department_id = subDept.sub_department_id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
            WHERE appraisal.appraisal_task_id=?';
     $binds = array($mainTaskId);
     $query = $this->db->query($sql, $binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get grade detail
  // used for getting progress percentage in subtask
  public function getGradeDetailByMainTaskAndGradeDetailId($mainTaskId,$gradeDetailId){
     $sql = 'SELECT
              grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              grade.grade_detail_id AS gradeId,gradeDetail.grade_name as gradeName
            FROM luffy_grade AS grade
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
            WHERE grade.maintask_id=? AND grade.grade_detail_id=?';
     $binds = array($mainTaskId,$gradeDetailId);
     $query = $this->db->query($sql, $binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get total SUM by point from sub appraisal task.
  public function getBonusInfo($kpi_id) {
     $sql = 'SELECT minimum_requirement, employee_bonus FROM luffy_kpi_sales WHERE id=?';
     $binds=array($kpi_id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get apprisal by user id & jobtask id
  public function get_appraisal_by_userid_jobtaskid($userId, $jobTaskId) {
     $sql = 'SELECT sub_department_id, kpi_id FROM luffy_appraisal WHERE employee_id=? AND appraisal_task_id=?';
     $binds=array($userId,$jobTaskId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  public function read_task_list_information($id) {
    $sql = 'SELECT
              subtask.*,
              jobtask.id AS jobtask_id, jobtask.name AS jobtask_jobtaskname,
              subtask_status.id AS subtaskStatusId,subtask_status.name AS subtask_status_name
            FROM luffy_appraisal_sub_task AS subtask
               LEFT JOIN luffy_appraisal_task AS jobtask ON subtask.appraisal_task_id=jobtask.id
               LEFT JOIN luffy_appraisal_sub_task_status AS subtask_status ON subtask.status=subtask_status.id
            WHERE subtask.id=?';
   $binds = array($id);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0) {
     return $query->result();
   } else {
     return null;
   }
  }
  public function read_appraisal_information($employeeId,$appraisalTaskId) {
    $sql = 'SELECT
               appraisal.*,
               reviewer.first_name AS reviewer_firstname, reviewer.last_name AS reviewer_lastname,
               employee.first_name, employee.last_name, employee.fingerprint_location,
               dept.department_name,
               subdept.department_name AS subdept_deptname,
               jobtask.name AS jobtask_jobtaskname,
               approval.name AS approval_name,
               status.name AS status_name
             FROM luffy_appraisal AS appraisal
                LEFT JOIN xin_employees AS reviewer ON reviewer.user_id = appraisal.reviewer_id
                LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
                LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
                LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = appraisal.sub_department_id
                LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.id = appraisal.appraisal_task_id
                LEFT JOIN luffy_appraisal_approval_status AS approval ON approval.id = appraisal.approval_status
                LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
             WHERE appraisal.employee_id=? AND appraisal.appraisal_task_id=?';
    $binds = array($employeeId,$appraisalTaskId);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
  // ga dipake :)
  // get current user's assigned task which is having pending status/not yet approved/rejected.
  public function appraisalDateBySubTaskAndUser($subTaskId,$userId){
    $sql = 'SELECT
              appraisal.start_date AS appraisalStartDate, appraisal.due_Date AS appraisalDueDate,
              appraisalStatus.id AS appraisalStatusId,
              appraisalApproval.id AS appraisalApprovalId
            FROM luffy_appraisal AS appraisal
               LEFT JOIN luffy_appraisal_sub_task AS subtask ON appraisal.appraisal_task_id = subtask.appraisal_task_id
               LEFT JOIN luffy_appraisal_status AS appraisalStatus ON appraisalStatus.id = appraisal.appraisal_status
               LEFT JOIN luffy_appraisal_sub_task AS appraisalApproval ON appraisalApproval.id = appraisal.approval_status
            WHERE appraisal.appraisal_task_id=?
              AND appraisal.employee_id=?
              AND appraisal.appraisal_status<>1 -- pending
              AND appraisal.approval_status=1 -- pending
              LIMIT 1';
    $binds = array($subTaskId, $userId);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
  // get all subtask title
  public function getAllSubtaskTitle(){
     $sql = 'SELECT * FROM luffy_appraisal_sub_task_title';
     $query = $this->db->query($sql);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;
  }
  // get all subtask title by main task.
  public function getAllSubtaskTitleByMainTaskId($mainTaskId){
     $sql = 'SELECT * FROM luffy_appraisal_sub_task_title WHERE maintask_id=?';
     $bind=array($mainTaskId);
     $query = $this->db->query($sql,$bind);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;
  }
  // get subtask task name by subtask
  public function getSubtaskNameBySubtaskTitleId($subtaskTitleId) {
     $sql = 'SELECT sub_task_title_name FROM luffy_appraisal_sub_task_title WHERE id=?';
     $binds=array($subtaskTitleId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  public function getAllSubtaskTitleByMaintTaskId($mainTaskId){
    $sql = 'SELECT id, maintask_id, sub_task_title_name
            FROM luffy_appraisal_sub_task_title WHERE maintask_id=?';
    $bind = array($mainTaskId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query->result();
    else return null;
  }
  public function allSubTaskStatus(){ #Auditor
    $sql = 'SELECT id,name FROM luffy_appraisal_sub_task_status'; // Valid & Rejected
    $query = $this->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
  }
  public function allSubTaskStatusAuditor(){ #Auditor
    $sql = 'SELECT id,name FROM luffy_appraisal_sub_task_status WHERE id in (2,4)'; // Valid & Rejected
    $query = $this->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
  }
  public function allSubTaskStatusReviewer(){ #Reviewer
    $sql = 'SELECT id,name FROM luffy_appraisal_sub_task_status WHERE id in (1,4)'; // Qualified & Rejected
    $query = $this->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
  }
  // fetch all the grades by maintask by the lowest monthly requirement
  public function allGradesByLowestMonthlRequirement($mainTaskId){
    $sql = 'SELECT * FROM luffy_grade WHERE maintask_id=? ORDER BY minimum_monthly_requirement ASC LIMIT 1';
    $bind = array($mainTaskId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query->row();
    else return null;
  }
  // get shift by maintask id
  public function getShiftByMainTask($mainTaskId){
    $sql = 'SELECT office_shift_id FROM luffy_appraisal_task WHERE id=?';
    $bind = array($mainTaskId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query->row();
    else return null;
  }
  # luffy 23 Dec 2019 03:19 pm
  // get subtask by url
  public function checkUrlInSubtask($url) {
     $sql = 'SELECT url FROM luffy_appraisal_sub_task WHERE url=?';
     $binds=array($url);
     $query = $this->db->query($sql,$binds);
     return $query;
  }
  # luffy 28 Dec 2019 01:04 pm
  // get subtask by file hash
  public function checkHashInSubtask($url) {
     $sql = 'SELECT file_hash FROM luffy_appraisal_sub_task WHERE file_hash=?';
     $binds=array($url);
     $query = $this->db->query($sql,$binds);
     return $query;
  }

  public function checkHashInSubtaskVideo($url) {
     $sql = 'SELECT file_video_hash FROM luffy_appraisal_sub_task WHERE file_hash=?';
     $binds=array($url);
     $query = $this->db->query($sql,$binds);
     return $query;
  }

}
?>
