<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Grade_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function all_minimum_requirements(){
     $sql = 'SELECT grade.*,gradeDetail.*,subDept.department_name,subDept.sub_department_id AS subDeptId, maintask.name AS maintaskName, maintask.office_shift_id, maintask.sub_department_id
             FROM luffy_grade AS grade
             LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
             LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
             LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
             ORDER BY grade.id DESC';
     $query = $this->db->query($sql);
     return $query->result();
	}
  // checking grade in main task list by Subdept, Shift, Grade, Requirement
  // used in maintask
  public function existingGrade_By_SubdeptShiftGradeMonthlyRequirement($subDeptId,$officeShiftId,$gradeDetailId,$monthlyRequirement){
     $sql = 'SELECT
              grade.grade_detail_id AS gradeDetailId,
              grade.minimum_daily_requirement AS dailyRequirement,
              grade.minimum_monthly_requirement AS monthlyRequirement,
              maintask.sub_department_id AS subDeptId,
              maintask.name AS maintaskName,
              maintask.office_shift_id AS shiftId
             FROM luffy_grade as grade
             LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
             WHERE maintask.sub_department_id=? AND maintask.office_shift_id=? AND grade.grade_detail_id=? AND grade.minimum_monthly_requirement=?';
     $bind=array($subDeptId,$officeShiftId,$gradeDetailId,$monthlyRequirement);
     $query=$this->db->query($sql,$bind);
     if($query->num_rows()>0)
       return 'existed';
     else return 'not existed';
	}
  // checking grade in grade list by Maintask, Grade, Requirement
  // used in grade
  public function existingGrade_By_MaintaskGradeMonthlyRequirement($maintaskId,$gradeDetailId,$monthlyRequirement){
    $sql = 'SELECT
             grade.grade_detail_id AS gradeDetailId,
             grade.minimum_daily_requirement AS dailyRequirement,
             grade.minimum_monthly_requirement AS monthlyRequirement,
             maintask.sub_department_id AS subDeptId,
             maintask.name AS maintaskName,
             maintask.office_shift_id AS shiftId
            FROM luffy_grade as grade
            LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            WHERE maintask.id=? AND grade.grade_detail_id=? AND grade.minimum_monthly_requirement=?';
    $bind=array($maintaskId,$gradeDetailId,$monthlyRequirement);
    $query=$this->db->query($sql,$bind);
    if($query->num_rows()>0)
      return 'existed';
    else return 'not existed';
	}
  // checking grade in grade list by Maintask, Subdept, Shift, Requirement
  // used in grade
  public function existingGrade_By_MaintaskSubdeptShiftMonthlyRequirement($maintaskId,$subDept,$shift,$monthlyRequirement){
    $sql = 'SELECT
             grade.grade_detail_id AS gradeDetailId,
             grade.minimum_daily_requirement AS dailyRequirement,
             grade.minimum_monthly_requirement AS monthlyRequirement,
             maintask.sub_department_id AS subDeptId,
             maintask.name AS maintaskName,
             maintask.office_shift_id AS shiftId
            FROM luffy_grade as grade
            LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            WHERE maintask.id=? AND maintask.sub_department_id=? AND maintask.office_shift_id=? AND grade.minimum_monthly_requirement=?';
    $bind=array($maintaskId,$subDept,$shift,$monthlyRequirement);
    $query=$this->db->query($sql,$bind);
    if($query->num_rows()>0)
      return 'existed';
    else return 'not existed';
	}
  // checking grade in grade list by Grade Detail Id, Subdept, Shift
  // used in grade, "ONLY" in Create not in update.
  public function existingGrade_By_GradeDetailIdMaintaskSubdeptShift($gradeDetailId,$maintaskId,$subDept,$shift){
    $sql = 'SELECT
             grade.grade_detail_id AS gradeDetailId,
             grade.minimum_daily_requirement AS dailyRequirement,
             grade.minimum_monthly_requirement AS monthlyRequirement,
             maintask.sub_department_id AS subDeptId,
             maintask.name AS maintaskName,
             maintask.office_shift_id AS shiftId
            FROM luffy_grade as grade
            LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            WHERE grade.grade_detail_id=? AND maintask.id=? AND maintask.sub_department_id=? AND maintask.office_shift_id=?';
    $bind=array($gradeDetailId,$maintaskId,$subDept,$shift);
    $query=$this->db->query($sql,$bind);
    if($query->num_rows()>0)
      return 'existed';
    else return 'not existed';
	}
  // get current grade by maintask id
  // used in maintask when editing single shift to All Shift
  public function currentGradeByMaintask($maintaskId){
    $sql = 'SELECT
             grade.grade_detail_id AS gradeDetailId,
             grade.minimum_daily_requirement AS dailyRequirement,
             grade.minimum_monthly_requirement AS monthlyRequirement,
             maintask.sub_department_id AS subDeptId,
             maintask.name AS maintaskName,
             maintask.office_shift_id AS shiftId
            FROM luffy_grade as grade
            LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            WHERE maintask.id=?';
    $bind=array($maintaskId);
    $query=$this->db->query($sql,$bind);
    return $query->result();
	}
  public function all_sub_departments(){
    $this->db->from("xin_sub_departments");
    $this->db->order_by("department_name", "asc");
    $query = $this->db->get();
    return $query;
	}
  // luffy add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('luffy_grade', $data);
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
    if($this->db->update('luffy_grade',$data))
			return true;
		else return false;
	}
  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_grade');
	}
	// Function to read minimum requirement information
	public function read_requirement_information($id){
    $sql = 'SELECT
              grade.id,grade.minimum_daily_requirement,grade.minimum_monthly_requirement,grade.maintask_id,
              gradeDetail.*,
              subDept.department_name,maintask.office_shift_id,maintask.sub_department_id,maintask.name AS mainTaskName
            FROM luffy_grade AS grade
            LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = grade.grade_detail_id
            LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = grade.maintask_id
            LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
            WHERE grade.id=?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows()> 0)
			return $query->result();
		else return null;
	}
  // Function to get current grade table status > auto increment
  public function gradeTableStatus(){
    $sql = "SHOW TABLE STATUS LIKE 'luffy_grade'";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0)
      return $query->result();
    else return null;
  }
  // get subdepartment
  public function getSubdeptByMainTask($maintaskId) {
     $sql = 'SELECT
               maintask.*,
               subdept.sub_department_id, subdept.department_name,
               shift.shift_name
             FROM luffy_appraisal_task AS maintask
                LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = maintask.sub_department_id
                LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
             WHERE maintask.id=? ORDER BY maintask.id DESC';
     $binds = array($maintaskId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->row();
     else return null;
  }
}
?>
