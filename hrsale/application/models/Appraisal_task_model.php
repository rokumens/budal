<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appraisal_task_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }
  // all task list
	public function all_appraisal_task() {
    $sql = 'SELECT
              maintask.id,maintask.name AS taskName, maintask.sub_department_id, maintask.office_shift_id,
              subDept.department_name,
              -- gradeDetail.grade_detail_id as gradeDetailId,gradeDetail.grade_name as gradeName,
              -- grade.id AS gradeId, grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              shift.shift_name
            FROM luffy_appraisal_task AS maintask
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              -- LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
              -- LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            ORDER BY maintask.id DESC';
   $query = $this->db->query($sql);
   return $query;
	}
  // all task list by sub department
  // used in subtask
	public function all_appraisal_task_by_subdept($subDeptId) {
    $sql = 'SELECT
              maintask.id,maintask.name AS taskName, maintask.sub_department_id, maintask.office_shift_id,
              subDept.department_name,
              gradeDetail.grade_detail_id as gradeDetailId,gradeDetail.grade_name as gradeName,
              grade.id AS gradeId, grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              shift.shift_name
            FROM luffy_appraisal_task AS maintask
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE maintask.sub_department_id=?
            ORDER BY gradeDetail.grade_detail_id DESC'; //order by ini jgn diubah, ntar susunan array'nya jd salah di subtask.
   $bind = array($subDeptId);
   $query = $this->db->query($sql,$bind);
   return $query;
	}
  // all task list by main task
  // used in for grading system in subtask
	public function allAppraisalByMainTaskAndShift($subDeptId,$shift) {
    $sql = 'SELECT
              maintask.id,maintask.name AS taskName, maintask.sub_department_id, maintask.office_shift_id,
              subDept.department_name,
              gradeDetail.grade_detail_id as gradeDetailId,gradeDetail.grade_name as gradeName,
              grade.id AS gradeId, grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              shift.shift_name
            FROM luffy_appraisal_task AS maintask
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE maintask.sub_department_id=? AND maintask.office_shift_id=?
            ORDER BY grade.minimum_monthly_requirement ASC'; //order by ini jgn diubah, buat nextMonthlyRequirement array berurut.
   $bind = array($subDeptId,$shift);
   $query = $this->db->query($sql,$bind);
   return $query;
	}
  // get grade name by subDeptId.
	public function getGrade($subDeptId) {
    $sql = 'SELECT
              grade.id,grade.minimum_daily_requirement,grade.minimum_monthly_requirement,
              gradeDetail.grade_detail_id,gradeDetail.grade_name as gradeName
            FROM luffy_grade_detail AS gradeDetail
               LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id
               LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            WHERE maintask.sub_department_id = ?
            ORDER BY gradeDetail.grade_name ASC';
    $bind = array($subDeptId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {return null;}
	}
  // get grade detail id by grade id to save grade id in creating & updating a task.
	public function getGradeDetailByGradeId($gradeId) {
    $sql = 'SELECT grade_detail_id FROM luffy_grade WHERE id=?';
    $bind = array($gradeId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {return null;}
	}
  // // GA DIPAKE // get grade id by task id
	// public function getGradeListByTaskId($taskId) {
  //   $sql = 'SELECT name,sub_department_id FROM luffy_appraisal_task WHERE id=?';
  //   $bind = array($taskId);
  //   $query = $this->db->query($sql,$bind);
  //   if ($query->num_rows() > 0) {
  //     return $query->row();
  //   } else {return null;}
	// }
  // used in subtask to get final grade detail id putin assign appraisal.
	public function getGradeListByTaskId($mainTaskId,$monthlyRequirement) {
    $sql = 'SELECT
              maintask.name,maintask.sub_department_id,
              grade.grade_detail_id
            FROM luffy_appraisal_task AS maintask
            LEFT JOIN luffy_grade AS grade ON grade.maintask_id=maintask.id
            WHERE grade.maintask_id=? AND grade.minimum_monthly_requirement=?';
    $bind = array($mainTaskId,$monthlyRequirement);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {return null;}
	}
  // get grade name by subDeptId.
  public function allGradeForDialog()
	{
    $this->db->from("luffy_grade_detail");
    $this->db->order_by("grade_name", "asc");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {return null;}
	}
  // get minimum requirement by subDeptId and grade id.
	public function getMinimumRequirement($subDeptId,$gradeId) {
    $sql = 'SELECT
              minimum_daily_requirement AS dailyRequirement,
              minimum_monthly_requirement AS monthlyRequirement
            FROM luffy_grade
            WHERE sub_department_id=? AND id=?';
    $bind = array($subDeptId,$gradeId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {return null;}
	}
  // get all departments
	public function all_sub_departments()
	{
	  $query = $this->db->query("SELECT * from xin_sub_departments");
    return $query->result();
	}
  // get all departments
	public function luffy_appraisal_sub_task_title()
	{
	  $query = $this->db->query("SELECT * from xin_sub_departments");
    return $query->result();
	}
  // luffy add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('luffy_appraisal_task', $data);
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
    if($this->db->update('luffy_appraisal_task',$data))
			return true;
		else return false;
	}
  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_appraisal_task');
	}
	// Update grade in main task from grade
	public function updateGradeInMainTaskFromGrade($data, $mainTaskId){
		$this->db->where('id', $mainTaskId);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_appraisal_task',$data)) {
			return true;
		} else {
			return false;
		}
	}
  // get department
  public function getDepartment($id) {
     $sql = 'SELECT
               task.*,
               subdept.sub_department_id, subdept.department_name
             FROM luffy_appraisal_task AS task
                LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = task.sub_department_id
             WHERE task.sub_department_id=? ORDER BY task.id DESC';
     $binds = array($id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  public function read_appraisal_task_information($mainTaskId) {
    $sql = 'SELECT
              task.*,
              subDept.sub_department_id, subDept.department_name,
              grade.minimum_daily_requirement, grade.minimum_monthly_requirement, grade.id AS gradeId,
              gradeDetail.grade_detail_id,gradeDetail.grade_name as gradeName,
              shift.shift_name
            FROM luffy_appraisal_task AS task
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = task.sub_department_id
              LEFT JOIN luffy_grade AS grade ON grade.maintask_id = task.id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = task.office_shift_id
            WHERE task.id=?';
   $binds = array($mainTaskId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0) {
     return $query->result();
   } else {
     return null;
   }
 }
 #get & del all related kpi sales.
 public function getKpiByMainTaskId($mainTaskId){
   $sql = 'SELECT id,job_task,minimum_requirement,minimum_amount,value_percentage,value_amount,employee_bonus,total_deposit,created_at,updated_at
           FROM luffy_kpi_sales WHERE job_task=?';
   $bind = array($mainTaskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 public function delKpiByMaintaskId($id){
   $this->db->where('job_task', $id);
   if($this->db->delete('luffy_kpi_sales'))
     return true;
   else return false;
 }
 #get & del all related assigned task.
 public function getApprisalByAppraisalTaskId($mainTaskId){
   $sql = 'SELECT * FROM luffy_appraisal WHERE appraisal_task_id=?';
   $bind = array($mainTaskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 public function delAssignTaskByMaintaskId($mainTaskId){
   $this->db->where('appraisal_task_id', $mainTaskId);
   if($this->db->delete('luffy_appraisal'))
     return true;
   else return false;
 }
 #get & del all related subtask.
 public function getSubtaskByMainTaskId($mainTaskId){
   $sql = 'SELECT id,appraisal_task_id,created_by,name FROM luffy_appraisal_sub_task
           WHERE appraisal_task_id=?';
   $bind = array($mainTaskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 // delete all the related subtasks by assigned task.
 public function delSubtaskByMainTaskId($mainTaskId){
   $this->db->where('appraisal_task_id', $mainTaskId);
   if($this->db->delete('luffy_appraisal_sub_task'))
     return true;
    else return false;
 }
 #get & del all related subtask title.
 public function getSubtaskTitleByMainTaskId($mainTaskId){
   $sql = 'SELECT id, maintask_id, sub_task_title_name
           FROM luffy_appraisal_sub_task_title WHERE maintask_id=?';
   $bind = array($mainTaskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 public function delSubtaskTitleByMaintaskId($id){
   $this->db->where('maintask_id', $id);
   if($this->db->delete('luffy_appraisal_sub_task_title'))
     return true;
   else return false;
 }
 #get & del all related grade list.
 public function getGradeListByMainTaskId($mainTaskId){
   $sql = 'SELECT id, maintask_id, grade_detail_id
           FROM luffy_grade WHERE maintask_id=?';
   $bind = array($mainTaskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 public function delGradeListByMaintaskId($id){
   $this->db->where('maintask_id', $id);
   if($this->db->delete('luffy_grade'))
     return true;
   else return false;
 }
  // Function to get current main task table status > auto increment
  public function mainTaskTableStatus(){
    $sql = "SHOW TABLE STATUS LIKE 'luffy_appraisal_task'";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {return null;}
  }
  // luffy add subtask title
  public function addSubtaskTitle($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
    $this->db->insert('luffy_appraisal_sub_task_title', $data);
    if ($this->db->affected_rows() > 0)
      return true;
    else return false;
  }
  // fetchall subtask title by main task id
	public function allSubtaskTitleByTaskId($mainTaskId) {
    $sql = 'SELECT id,sub_task_title_name FROM luffy_appraisal_sub_task_title WHERE maintask_id=?';
    $bind = array($mainTaskId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0) {
      return $query->result();
    } else {return null;}
	}
  // luffy update subtask title
  public function update_subtask_title($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('id', $id);
    $data = $this->security->xss_clean($data);
    if($this->db->update('luffy_appraisal_sub_task_title',$data))
      return true;
    else return false;
  }
  // luffy 29 December 2019 02:36 pm
  // deleting the subtask title when updating maintask.
	public function deleteSubtaskTitle($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_appraisal_sub_task_title');
	}

  // checking existing maintask
  public function existingMaintask($maintTaskName,$subDeptId,$shiftId){
    $sql = 'SELECT name,sub_department_id,office_shift_id
            FROM luffy_appraisal_task
            WHERE name=? AND sub_department_id=? AND office_shift_id=?';
    $bind=array($maintTaskName,$subDeptId,$shiftId);
    $query=$this->db->query($sql,$bind);
    if ($query->num_rows()>0) {
      return 'existed';
    }else{return 'not existed';}
	}
  // all grade list by main task
  public function allGradeByMainTask($mainTaskId){
     $sql = 'SELECT grade.*,gradeDetail.*
             FROM luffy_grade AS grade
             LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
             WHERE grade.maintask_id=?
             ORDER BY gradeDetail.grade_detail_id ASC';
     $bind = array($mainTaskId);
     $query = $this->db->query($sql,$bind);
     return $query->result();
	}

}
?>
