<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpi_sales_model extends CI_Model {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

	public function get_kpi_sales(){
	  return $this->db->get("luffy_kpi_sales");
	}

  public function all_kpi_sales(){
    $this->db->from("luffy_kpi_sales");
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  public function all_kpi_by_jobtask($jobTaskId){
    $this->db->from("luffy_kpi_sales");
    $this->db->order_by("minimum_requirement", "asc");
    $this->db->where('job_task', $jobTaskId);
    $query = $this->db->get();
    return $query->result();
  }

  // ini buat View Own
  public function my_own_kpi_sales($id){
    $this->db->from("luffy_kpi_sales");
    $this->db->where('employee_id', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return $query;
	}

  // get all departments
	public function all_sub_departments(){
	  $query = $this->db->query("SELECT * from xin_sub_departments");
    return $query->result();
	}

  // get all job task
	public function all_jobtask(){
	  $query = $this->db->query("SELECT * from luffy_appraisal_task");
    return $query->result();
	}

  // get all employees
	public function all_employees(){
	  $query = $this->db->query("SELECT * from xin_employees");
    return $query->result();
	}

  // Function to add record in table
	public function add($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('luffy_kpi_sales', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		 else return false;
	}

  // Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('luffy_kpi_sales');
	}

	// Function to update record in table
	public function update_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
		$this->db->where('id', $id);
		if( $this->db->update('luffy_kpi_sales',$data))
			return true;
		else return false;
	}

  public function read_kpi_sales_information($id) {
    $sql = 'SELECT
              kpi.*, jobtask.name
            FROM luffy_kpi_sales AS kpi
              LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.id = kpi.job_task
            WHERE kpi.id=?';
   $binds = array($id);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->result();
   else return null;

 }

  // // NGGA dipake lagi - skrg dah ke KPI Report :) #luffy 21 nov 2019
  // // for KPI Sales Summary
  // // Function to add record in table
	// public function addKpiSummary($data){
	// 	$this->db->insert('luffy_kpi_sales_summary', $data);
	// 	if ($this->db->affected_rows() > 0)
	// 		return true;
	// 	else return false;
	// }
  // // Function to update record in table
	// public function updateKpiSummary($data, $date){
	// 	$this->db->where('date', $date);
	// 	if( $this->db->update('luffy_kpi_sales_summary',$data)) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
  // public function getKpiSummaryByDate($date) {
  //    $sql = 'SELECT * FROM luffy_kpi_sales_summary
  //            WHERE date=? LIMIT 1';
  //    $binds = array($date);
  //    $query = $this->db->query($sql,$binds);
  //    if ($query->num_rows() > 0)
  //      return $query->row();
  //    else return null;
  // }
  
  // get job task by id
  public function getJobTask($jobId) {
     $sql = 'SELECT name FROM luffy_appraisal_task WHERE id=? LIMIT 1';
     $binds = array($jobId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0) {
       return $query->row();
     } else {
       return null;
     }
  }
  // get total SUM by Employee Bonus and Total Deposit from KPI Sales.
  public function getSumKpiSummary($date) {
     $sql = 'SELECT
              DATE_FORMAT(created_at, "%Y-%m-%d") as created_date,
              SUM(employee_bonus) AS sum_employee_bonus,
              SUM(total_deposit) AS sum_total_deposit
             FROM luffy_kpi_sales
             WHERE created_at=?
             GROUP BY YEAR(created_at), MONTH(created_at), DAY(created_at)';
     $binds=array($date);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;
  }

  // get bonus based on Grade
  public function get_bonus_grade($jobTaskId) {
    $sql = 'SELECT
              kpi.employee_bonus AS bonus,
              -- SUM(point) AS sum_total_point
              subtask.appraisal_task_id AS jobTask,
              jobtask.minimum_monthly_requirement_grade_b AS minimumRequirement
            FROM luffy_kpi_sales AS kpi
              LEFT JOIN luffy_appraisal_sub_task AS subtask ON subtask.appraisal_task_id = kpi.job_task
              LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.minimum_monthly_requirement_grade_b = kpi.minimum_requirement
            WHERE kpi.job_task=? GROUP BY kpi.employee_bonus';
   $binds = array($jobTaskId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->result();
   else return null;
 }

  // get bonus based on Kpi
  public function get_bonus_kpi($jobTaskId) {
    $sql = 'SELECT
              kpi.employee_bonus AS bonus,
              -- SUM(point) AS sum_total_point
              subtask.appraisal_task_id AS jobTask,
              jobtask.minimum_monthly_requirement_grade_b AS minimumRequirement
            FROM luffy_kpi_sales AS kpi
              LEFT JOIN luffy_appraisal_sub_task AS subtask ON subtask.appraisal_task_id = kpi.job_task
              LEFT JOIN luffy_appraisal_task AS jobtask ON jobtask.minimum_monthly_requirement_grade_b = kpi.minimum_requirement
            WHERE kpi.job_task=? GROUP BY kpi.employee_bonus';
   $binds = array($jobTaskId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->result();
   else return null;
 }

 // get minimum requirement by task id
 public function getMinimumRequirement($taskId) {
   $sql = 'SELECT
            grade.minimum_daily_requirement AS dailyRequirement, grade.minimum_monthly_requirement AS monthlyRequirement,
            grade.grade_detail_id AS gradeId,gradeDetail.grade_name as gradeName
          FROM luffy_appraisal_task AS task
            LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = task.sub_department_id
            LEFT JOIN luffy_grade AS grade ON grade.id = task.grade_list_id
            LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
          WHERE task.id=?';
   $binds = array($taskId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->row();
   else return null;
 }
 // used to get the lowest monthly requirement in kpi sales ajax get requirement
 public function getLowestMonthlyRequirement($mainTaskId) {
   $sql = 'SELECT
            MIN(minimum_monthly_requirement) AS monthlyRequirement
          FROM luffy_grade
          WHERE maintask_id=?';
   $binds = array($mainTaskId);
   $query = $this->db->query($sql, $binds);
   if ($query->num_rows() > 0)
     return $query->row();
   else return null;
 }

}
?>
