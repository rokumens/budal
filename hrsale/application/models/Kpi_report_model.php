<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kpi_report_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function getActiveEmployees(){
    $sql = "SELECT employee.*, location.location_name
            FROM xin_employees AS employee
            LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE is_active=1 AND fingerprint_location!=0";
    $query = $this->db->query($sql);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  public function getOwnReport($userId){
    $sql = "SELECT employee.*, location.location_name
            FROM xin_employees AS employee
            LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE employee.user_id = $userId AND is_active=1 AND fingerprint_location!=0";
    $query = $this->db->query($sql);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  public function read_user_info($id) {
    $sql = 'SELECT * FROM xin_employees WHERE employee_id = ?';
    $binds = array($id);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // used to get all kpi list by subdepartment and shift in kpi report detail.
  public function allKpiBySubdeptAndShift($subDeptId,$shift) {
    $sql = 'SELECT
              kpi.id AS kpiId,
              maintask.id AS maintask_id,maintask.name AS taskName, maintask.sub_department_id,
              subDept.department_name,
              shift.shift_name
            FROM luffy_kpi_sales AS kpi
              LEFT JOIN luffy_appraisal_task AS maintask ON maintask.id = kpi.job_task
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE maintask.sub_department_id=? AND maintask.office_shift_id=?';
   $bind = array($subDeptId,$shift);
   $query = $this->db->query($sql,$bind);
   return $query;
  }
  // used to get the bonus in kpi report detail.
  public function employeeBonusAchieved($employeeId,$mainTaskId,$startDate,$toDate) {
    $sql = 'SELECT final_amount AS employeeBonusAchieved
            FROM luffy_appraisal
            WHERE employee_id=? AND appraisal_task_id=? AND (start_date >= ? AND due_date <= ?)';
    $binds = array($employeeId,$mainTaskId,$startDate,$toDate);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return 0;
  }
}
?>
