<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appraisal_model extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->load->database();
  }
	public function get_appraisal() {
	  return $this->db->get("luffy_appraisal");
	}
  public function all_appraisal() {
    $sql = 'SELECT
              assignTask.*,
              status.name AS appraisal_status_name,
              approvalstatus.name AS approvalstatus_name,
              employee.first_name, employee.last_name, employee.employee_id, employee.username, employee.fingerprint_location,
              maintask.name AS taskName, maintask.office_shift_id,
              shift.shift_name,
              location.location_name
            FROM luffy_appraisal AS assignTask
               LEFT JOIN luffy_appraisal_status AS status ON status.id = assignTask.appraisal_status
               LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = assignTask.approval_status
               LEFT JOIN xin_employees AS employee ON employee.user_id = assignTask.employee_id
               LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = assignTask.appraisal_task_id
               LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
               LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            ORDER BY assignTask.id DESC';
    $query = $this->db->query($sql);
    return $query;
  }
  public function my_own_appraisal($userId, $shiftId) {
    $sql = 'SELECT
              assignTask.*,
              status.name AS appraisal_status_name,
              approvalstatus.name AS approvalstatus_name,
              employee.first_name, employee.last_name, employee.employee_id, employee.username, employee.fingerprint_location,
              maintask.name AS taskName, maintask.office_shift_id,
              shift.shift_name,
              location.location_name
            FROM luffy_appraisal AS assignTask
               LEFT JOIN luffy_appraisal_status AS status ON status.id = assignTask.appraisal_status
               LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = assignTask.approval_status
               LEFT JOIN xin_employees AS employee ON employee.user_id = assignTask.employee_id
               LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = assignTask.appraisal_task_id
               LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
               LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE assignTask.employee_id=? AND maintask.office_shift_id=?
            ORDER BY assignTask.id DESC';
   $binds = array($userId, $shiftId);
   $query = $this->db->query($sql,$binds);
   return $query;
 }
  // get all departments
	public function all_sub_departments() {
	  $query = $this->db->query("SELECT * from xin_sub_departments");
    return $query->result();
	}
  public function getSubDeptByEmployeeId($userId){
    $sql = 'SELECT subDept.sub_department_id, subDept.department_name
            FROM xin_employees AS employee
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = employee.sub_department_id
            WHERE employee.user_id=?
            ORDER BY subDept.sub_department_id DESC';
     $binds = array($userId);
     $query = $this->db->query($sql,$binds);
  		if ($query->num_rows() > 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  }
  // get all job task
	public function all_jobtask() {
	  $query = $this->db->query("SELECT * from luffy_appraisal_task");
    return $query->result();
	}
  // get all employees
	public function all_employees() {
	  $query = $this->db->query("SELECT * from xin_employees");
    return $query->result();
	}
  // luffy add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('luffy_appraisal', $data);
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
    if($this->db->update('luffy_appraisal',$data))
			return true;
		else return false;
	}
  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_appraisal');
	}
	// update the appraisal when Status for Sub Task was 'Completed'.
	public function updateByAppraisalTaskIdAndEmployeeId($data, $appraisalTaskId, $employeeId){
    $arrayCondition = array(
      'appraisal_task_id' => $appraisalTaskId,
      'employee_id' => $employeeId
    );
		$this->db->where($arrayCondition);
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
		if( $this->db->update('luffy_appraisal',$data))
			return true;
		else return false;
	}
  // sub department > employee
  // get all employee list based on sub department id for multiple select ajax maintask.
	public function ajax_subdept_employee_info($id) {
		$sql = 'SELECT * FROM xin_employees WHERE sub_department_id=? AND is_active=1 AND deleted_at IS NULL AND fingerprint_location != 0';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
  // sub department > employee
  // get all employee list for single select ajax maintask.
	public function ajax_single_employee_list() {
		$sql = 'SELECT * FROM xin_employees WHERE is_active=1 AND deleted_at IS NULL AND fingerprint_location != 0';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
			return $query->result();
		 else return null;
	}
  // sub department > main task
  // get all task list based on sub department id for multiple select ajax maintask.
	public function ajax_jobtask_info($subDeptId) {
		$sql = 'SELECT
              maintask.id,maintask.name,maintask.description,maintask.sub_department_id,maintask.office_shift_id,maintask.created_by,maintask.created_at,maintask.updated_at,
              gradeDetail.grade_detail_id AS gradeDetailId,gradeDetail.grade_name as gradeName,
              grade.id AS gradeId,grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              shift.shift_name
            FROM luffy_appraisal_task as maintask
              LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE maintask.sub_department_id = ?
            GROUP BY grade.maintask_id
            ORDER BY maintask.office_shift_id ASC';
		$binds = array($subDeptId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
  // sub department > task
  // get all task list for single select ajax task.
  // use GROUP if 'all sub-department' was applied on Task List module
  // but remove GRUP BY if 'all sub-department' is NOT applied on Task List module.
	public function ajax_single_task_list() { //                   |
		// $sql = 'SELECT * FROM luffy_appraisal_task --               |
    //         GROUP BY name,grade_id';  //  <--- use/remove it. <---
    $sql = 'SELECT
              maintask.id,maintask.name,maintask.description,maintask.sub_department_id,maintask.office_shift_id,maintask.created_by,maintask.created_at,maintask.updated_at,
              gradeDetail.grade_detail_id AS gradeDetailId,gradeDetail.grade_name as gradeName,
              grade.id AS gradeId,grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
              shift.shift_name
            FROM luffy_appraisal_task as maintask
              LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            GROUP BY grade.maintask_id
            ORDER BY maintask.office_shift_id ASC';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
  // check if the task is for kpi or grade in appraisal model.
	public function is_jobtask_for_kpi($subDepartmentId) {
    $sqlKpi = 'SELECT
              kpi.minimum_requirement AS minimumRequirementBonus, kpi.employee_bonus AS bonus, kpi.id as kpi_id,
              maintask.id, maintask.name, maintask.minimum_monthly_requirement_grade_a AS minimumRequirementGradeA, maintask.minimum_monthly_requirement_grade_b AS minimumRequirementGradeB, maintask.sub_department_id
            FROM luffy_kpi_sales AS kpi
               LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id=kpi.job_task
            WHERE maintask.sub_department_id=?';
    $bindsKpi = array($subDepartmentId);
    $queryKpi = $this->db->query($sqlKpi, $bindsKpi);
    if ($queryKpi->num_rows() > 0)
      return "true";
    else return "false";
	}
  // get department by subdepartment
	public function getSubDepartmentBy($id) {
		$sql = 'SELECT department_id,department_name FROM xin_sub_departments WHERE sub_department_id = ? ORDER BY sub_department_id DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return null;
		}
	}
  // get job task name by task id
	public function getJobtaskNameBy($id) {
		$sql = 'SELECT name FROM luffy_appraisal_task WHERE id = ? ORDER BY sub_department_id DESC';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->row();
		else return null;
	}
  // get job task name by kpi id
	public function getJobtaskNameKPI($kpiId) {
		$sql = 'SELECT maintask.name FROM luffy_appraisal_task AS maintask
            LEFT JOIN luffy_kpi_sales AS kpi ON kpi.job_task = maintask.id
            LEFT JOIN luffy_appraisal AS assignTask ON assignTask.kpi_id = kpi.id
            WHERE kpi.id=?';
		$binds = array($kpiId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->row();
		else return null;
	}
  public function read_appraisal_information($id) {
    $sql = 'SELECT
              assignTask.*,
              reviewer.first_name AS reviewer_firstname, reviewer.last_name AS reviewer_lastname,
              approvedby.first_name AS approvedby_firstname, approvedby.last_name AS approvedby_lastname,
              employee.first_name, employee.last_name, employee.employee_id AS nikId, employee.username, employee.fingerprint_location,
              dept.department_name,
              subDept.department_name AS subdept_deptname,
              maintask.name AS jobtask_jobtaskname,maintask.office_shift_id,
              approval.name AS approval_name,
              status.name AS status_name,
              MAX(grade.grade_detail_id) as gradeDetailId,grade.id as gradeId,
              gradeDetail.grade_name as gradeName,
              shift.shift_name
            FROM luffy_appraisal AS assignTask
               LEFT JOIN xin_employees AS reviewer ON reviewer.user_id = assignTask.reviewer_id
               LEFT JOIN xin_employees AS approvedby ON approvedby.user_id = assignTask.approved_by
               LEFT JOIN xin_employees AS employee ON employee.user_id = assignTask.employee_id
               LEFT JOIN xin_departments AS dept ON dept.department_id = assignTask.department_id
               LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = assignTask.sub_department_id
               LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = assignTask.appraisal_task_id
               LEFT JOIN luffy_appraisal_approval_status AS approval ON approval.id = assignTask.approval_status
               LEFT JOIN luffy_appraisal_status AS status ON status.id = assignTask.appraisal_status
               -- LEFT JOIN luffy_kpi_sales AS kpi ON kpi.job_task = assignTask.appraisal_task_id AND kpi.minimum_requirement = assignTask.final_point
               LEFT JOIN luffy_grade AS grade ON grade.maintask_id = maintask.id
               LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = assignTask.grade_id
               LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE assignTask.id=?';
   $binds = array($id);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->result();
   else return null;
 }
 public function get_due_date_by_id($appraisalId) {
   $sql = 'SELECT due_date AS endPeriodDate FROM luffy_appraisal WHERE id=?';
   $binds = array($appraisalId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->row();
   else return null;
 }
 // get total all summarize bonus of the 'current' user
 public function sum_total_bonus($employeeId,$monthPeriod){
   $sql = "SELECT SUM(final_amount) AS totalBonus
           FROM luffy_appraisal
           WHERE employee_id=? AND MONTH(start_date)=?";
   $binds = array($employeeId,$monthPeriod);
   $query = $this->db->query($sql,$binds);
   if ($query->num_rows() > 0)
     return $query->row();
   else return null;
 }
 // get all employees for multiple adding selected by all subdepartment
 public function getAllEmployees(){
   $sql = 'SELECT employee.user_id,employee.fingerprint_location,subDept.sub_department_id,dept.department_id
           FROM xin_employees AS employee
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = employee.sub_department_id
              LEFT JOIN xin_departments AS dept ON dept.department_id = employee.department_id
            WHERE is_active=1
            ORDER BY subDept.sub_department_id DESC';
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0)
     return $query->result();
    else return null;
 }
 // get all employees for multiple adding selected by all subdepartment
 public function getallEmployeesBySubDeptId($employeeId){
   $sql = 'SELECT employee.user_id,employee.fingerprint_location,subDept.sub_department_id,dept.department_id
           FROM xin_employees AS employee
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = employee.sub_department_id
              LEFT JOIN xin_departments AS dept ON dept.department_id = employee.department_id
           WHERE subDept.sub_Department_id=? AND WHERE is_active=1
           ORDER BY employee.first_name ASC';
    $bind = array($employeeId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows() > 0)
       return $query->result();
    else return null;
 }
 // get subdepartment name by subdepartment id for ajax success output result.
 public function getSubDeptNameBySubDeptId($subDeptId){
   $sql = 'SELECT department_name AS subDeptName FROM xin_sub_departments WHERE sub_department_id=?';
   $bind = array($subDeptId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->row();
   else return null;
 }
 // 3 functions below 1 packet used for deletion the assigned maintask.
 // get all employee id & task id by appraisal id
 public function getUserIdTaskIdByAppraisalId($appraisalId){
   $sql = 'SELECT employee_id AS employeeId,appraisal_task_id AS taskId FROM luffy_appraisal WHERE id=?';
   $bind = array($appraisalId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->row();
   else return null;
 }
 // get all subtask by employee id & task id
 public function getSubtaskByUserIdTaskId($employeeId,$taskId){
   $sql = 'SELECT id,appraisal_task_id,created_by,name FROM luffy_appraisal_sub_task
           WHERE created_by=? AND appraisal_task_id=?';
   $bind = array($employeeId,$taskId);
   $query = $this->db->query($sql,$bind);
   if(!is_null($query))
     return $query->result();
   else return null;
 }
 // delete all the related subtasks by assigned maintask.
 public function deleteSubtaskBySubtaskId($id){
   $this->db->where('id', $id);
   if($this->db->delete('luffy_appraisal_sub_task'))
     return true;
   else return false;
 }
 // get grade
 // public function getGradeDetailByTaskId($appraisalTaskId){
 //    $sql = 'SELECT
 //             grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
 //             grade.grade_detail_id AS gradeId,gradeDetail.grade_name as gradeName
 //           FROM luffy_appraisal_task AS maintask
 //             -- LEFT JOIN luffy_appraisal_sub_task AS subtask ON maintask.id = subtask.appraisal_task_id
 //             LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
 //             LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = maintask.grade_id
 //             -- LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
 //             LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id
 //             LEFT JOIN luffy_appraisal_task AS maintask ON maintask.sub_department_id = subDept.sub_department_id
 //           WHERE maintask.id=?';
 //    $binds = array($appraisalTaskId);
 //    $query = $this->db->query($sql, $binds);
 //    if ($query->num_rows() > 0) {
 //      return $query->row();
 //    } else {
 //      return null;
 //    }
 // }
 public function getGradeDetailByTaskId($mainTaskId){
    $sql = 'SELECT
              grade.minimum_daily_requirement AS dailyRequirement,
              grade.minimum_monthly_requirement AS monthlyRequirement,
              MAX(grade.grade_detail_id) AS gradeId,
              gradeDetail.grade_name AS gradeName
           FROM luffy_grade AS grade
             LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
             LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
           WHERE grade.maintask_id=?';
    $binds = array($mainTaskId);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows() > 0)
      return $query->row();
    else return null;
 }
 // get grade name
 public function getGradeNameByGradeDetailId($gradeDetailId){
   $sql = 'SELECT grade_name FROM luffy_grade_detail WHERE grade_detail_id=?';
   $bind = array($gradeDetailId);
   $query = $this->db->query($sql,$bind);
   if ($query->num_rows() > 0)
      return $query->row();
   else return null;
 }
 // get current employee's shift
 public function getShiftBySessionUserId($sessionUserId){
   $sql = 'SELECT office_shift_id FROM xin_employees WHERE user_id=?';
   $bind = array($sessionUserId);
   $query = $this->db->query($sql,$bind);
   if ($query->num_rows() > 0)
      return $query->row();
   else return null;
 }
 // all appraisal by user id
 public function appraisalByUserId($userId) {
   $sql = 'SELECT
             assignTask.*,
             status.name AS appraisal_status_name,
             approvalstatus.name AS approvalstatus_name,
             employee.first_name, employee.last_name, employee.employee_id, employee.username, employee.fingerprint_location,
             maintask.name AS taskName, maintask.office_shift_id,
             shift.shift_name
           FROM luffy_appraisal AS assignTask
              LEFT JOIN luffy_appraisal_status AS status ON status.id = assignTask.appraisal_status
              LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = assignTask.approval_status
              LEFT JOIN xin_employees AS employee ON employee.user_id = assignTask.employee_id
              LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = assignTask.appraisal_task_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
           WHERE assignTask.employee_id=?';
   $bind = array($userId);
   $query = $this->db->query($sql,$bind);
   if ($query->num_rows() > 0)
     return $query->result();
   else return null;
 }
}
?>
