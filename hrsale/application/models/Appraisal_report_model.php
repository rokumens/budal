<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_report_model extends CI_Model {
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  //filtering the appraisal report for admin
  public function show_report_list($employeeId, $month, $year) {
     if((is_null($employeeId))||($employeeId=='')){
        $sql = 'SELECT
                  appraisal.*,
                  reviewer.first_name AS reviewer_firstname, reviewer.last_name AS reviewer_lastname,
                  approvedby.first_name AS approvedby_firstname, approvedby.last_name AS approvedby_lastname,
                  employee.first_name, employee.last_name,
                  dept.department_name,
                  subDept.department_name AS subdept_deptname,
                  task.name AS jobtask_jobtaskname,
                  approval.name AS approvalstatus_name,
                  status.name AS appraisal_status_name,
                  gradeDetail.grade_name as gradeName
                FROM luffy_appraisal AS appraisal
                   LEFT JOIN xin_employees AS reviewer ON reviewer.user_id = appraisal.reviewer_id
                   LEFT JOIN xin_employees AS approvedby ON approvedby.user_id = appraisal.approved_by
                   LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
                   LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
                   LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = appraisal.sub_department_id
                   LEFT JOIN luffy_appraisal_task AS task ON task.id = appraisal.appraisal_task_id
                   LEFT JOIN luffy_appraisal_approval_status AS approval ON approval.id = appraisal.approval_status
                   LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
                   LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
                   LEFT JOIN luffy_grade AS grade ON9 grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
            WHERE
                (appraisal.approval_status=2 -- Approved
            OR
                appraisal.approval_status=3) -- Rejected
            GROUP BY appraisal.employee_id AND MONTH(appraisal.start_date)
            ORDER BY appraisal.id DESC';
         $query = $this->db->query($sql);
         return $query;
     }else{
       if($employeeId!=0){
         $sql = 'SELECT
                  appraisal.*,
                  status.name AS appraisal_status_name,
                  approvalstatus.name AS approvalstatus_name,
                  employee.first_name, employee.last_name,
                  dept.department_name,
                  subDept.department_name AS subdept_deptname,
                  task.name AS jobtask_jobtaskname,
                  gradeDetail.grade_name as gradeName
                FROM luffy_appraisal AS appraisal
                   LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
                   LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = appraisal.approval_status
                   LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
                   LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
                   LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = appraisal.sub_department_id
                   LEFT JOIN luffy_appraisal_task AS task ON task.id = appraisal.appraisal_task_id
                   LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
                   LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
                WHERE
                   appraisal.employee_id=? AND
                   (MONTH(appraisal.start_date)=? AND YEAR(appraisal.start_date)=?)
                AND
                    (appraisal.approval_status=2 -- Approved
                OR
                    appraisal.approval_status=3) -- Rejected
                GROUP BY appraisal.employee_id AND MONTH(appraisal.start_date)
                ORDER BY appraisal.id DESC';
          $binds=array($employeeId,$month,$year);
          $query = $this->db->query($sql,$binds);
       }else{
          $sql = 'SELECT
                  appraisal.*,
                  status.name AS appraisal_status_name,
                  approvalstatus.name AS approvalstatus_name,
                  employee.first_name, employee.last_name,
                  dept.department_name,
                  subDept.department_name AS subdept_deptname,
                  task.name AS jobtask_jobtaskname,
                  gradeDetail.grade_name as gradeName
                FROM luffy_appraisal AS appraisal
                   LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
                   LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = appraisal.approval_status
                   LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
                   LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
                   LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = appraisal.sub_department_id
                   LEFT JOIN luffy_appraisal_task AS task ON task.id = appraisal.appraisal_task_id
                   LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
                   LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
                WHERE
                   appraisal.id>=1 AND
                   (MONTH(appraisal.start_date)=? AND YEAR(appraisal.start_date)=?)
                AND
                    (appraisal.approval_status=2 -- Approved
                OR
                    appraisal.approval_status=3) -- Rejected
                GROUP BY appraisal.employee_id AND MONTH(appraisal.start_date)
                ORDER BY appraisal.id DESC';
          $binds=array($month,$year);
          $query = $this->db->query($sql,$binds);
       }
       return $query;
     }
   }

  //filtering the appraisal report for user
  public function my_appraisal_report_filtered($employeeId, $month, $year) {
    if((!is_null($employeeId))&&(!is_null($month))&&(!is_null($year))){
      $sql = 'SELECT
             appraisal.*,
             status.name AS appraisal_status_name,
             approvalstatus.name AS approvalstatus_name,
             employee.first_name, employee.last_name,
             dept.department_name,
             subDept.department_name AS subdept_deptname,
             task.name AS jobtask_jobtaskname,
             gradeDetail.grade_name as gradeName
           FROM luffy_appraisal AS appraisal
              LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
              LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = appraisal.approval_status
              LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
              LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = appraisal.sub_department_id
              LEFT JOIN luffy_appraisal_task AS task ON task.id = appraisal.appraisal_task_id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
              LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
           WHERE
              appraisal.employee_id=? AND
              (MONTH(appraisal.start_date)=? AND YEAR(appraisal.start_date)=?)
           AND
               (appraisal.approval_status=2 -- Approved
           OR
               appraisal.approval_status=3) -- Rejected
           GROUP BY appraisal.employee_id AND MONTH(appraisal.start_date)
           ORDER BY appraisal.id DESC';
      $binds=array($employeeId,$month,$year);
      $query = $this->db->query($sql,$binds);
      return $query;
    }
  }

  //all the appraisal report for user (my own)
  public function my_appraisal_report_all($employeeId){
      $sql = 'SELECT
             appraisal.*,
             status.name AS appraisal_status_name,
             approvalstatus.name AS approvalstatus_name,
             employee.first_name, employee.last_name
             dept.department_name,
             subDept.department_name AS subdept_deptname,
             task.name AS jobtask_jobtaskname,
             gradeDetail.grade_name as gradeName
           FROM luffy_appraisal AS appraisal
              LEFT JOIN luffy_appraisal_status AS status ON status.id = appraisal.appraisal_status
              LEFT JOIN luffy_appraisal_approval_status AS approvalstatus ON approvalstatus.id = appraisal.approval_status
              LEFT JOIN xin_employees AS employee ON employee.user_id = appraisal.employee_id
              LEFT JOIN xin_departments AS dept ON dept.department_id = appraisal.department_id
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = appraisal.sub_department_id
              LEFT JOIN luffy_appraisal_task AS task ON task.id = appraisal.appraisal_task_id
              LEFT JOIN luffy_grade_detail AS gradeDetail ON gradeDetail.grade_detail_id = task.grade_id
              LEFT JOIN luffy_grade AS grade ON grade.grade_detail_id = gradeDetail.grade_detail_id AND grade.sub_department_id = subDept.sub_department_id
           WHERE
              appraisal.employee_id=?
           AND
               (appraisal.approval_status=2 -- Approved
           OR
               appraisal.approval_status=3) -- Rejected
           GROUP BY appraisal.employee_id AND MONTH(appraisal.start_date)
           ORDER BY appraisal.id DESC';
      $binds=array($employeeId);
      $query = $this->db->query($sql,$binds);
      return $query;
  }

  // Function to add record in table
	public function add($data){
		$this->db->insert('luffy_appraisal_report', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}

  // Function to update record in table
	public function update_record($data, $monthPeriod, $employeeId){
    $where = array('MONTH(period)'=>$monthPeriod,'employee_id'=>$employeeId);
    $this->db->where($where);
		if( $this->db->update('luffy_appraisal_report',$data))
			return true;
		else return false;
	}

  // appraisal report information
  public function appraisal_report_by_month_userid($monthPeriod,$employeeId) {
    $sql = 'SELECT MONTH(period) AS period, employee_id, total_bonus
            FROM luffy_appraisal_report
            WHERE MONTH(period)=? AND employee_id=?
            ORDER BY period DESC';
    $binds = array($monthPeriod,$employeeId);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows() > 0)
      return $query->row();
    else return null;
  }

  public function all_appraisal_report() {
    $sql = 'SELECT
              appraisalReport.*,
              employee.first_name, employee.last_name,
              subdept.department_name AS subdept_deptname
            FROM luffy_appraisal_report AS appraisalReport
               LEFT JOIN xin_employees AS employee ON employee.user_id = appraisalReport.employee_id
               LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = employee.sub_department_id
            ORDER BY appraisalReport.id DESC';
    $query = $this->db->query($sql);
    return $query->row();
  }

  // get appraisal report by month and employee Id
  public function getAppraisalReportBy_Month_UserId($monthPeriode, $employeeId) {
     $sql = 'SELECT * FROM luffy_appraisal_report
             WHERE MONTH(period)=? AND employee_id=?';
     $binds=array($monthPeriode,$employeeId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->row();
    else return null;
  }

  // get department by subdepartment
  public function getJobtaskNameBy($subDeptId) {
		$sql = 'SELECT name FROM luffy_appraisal_task WHERE id = ? ORDER BY sub_department_id DESC';
		$binds = array($subDeptId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->row();
		else return null;
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
            WHERE user_id=? AND is_active=1 AND fingerprint_location!=0";
    $bind = array($userId);
    $query = $this->db->query($sql,$bind);
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
  //for havefun aza ea ea eaa hahaaa :v
  private function a1GetItems(){
    // // calling A2
    // $queryA2 = $this->db->query('SELECT * FROM luffy_appraisal_task');
    // $resultA2 = $queryA2->result_array();
    // calling A1
    $apgdb = $this->load->database('apgdb',true);
    #$queryA1 = $apgdb->query('SELECT * FROM items WHERE connect_response IS NOT NULL ORDER BY id DESC');
    $sqlA1 = 'SELECT * FROM items';
    $queryA1 = $apgdb->query($sqlA1);
    $resultA1 = $queryA1->result_array();
    $query = array(
      #"A2AppraisalTask"=>$resultA2,
      "a1Items"=>$resultA1
    );
    #return $query;
    #return $resultA1;
    if ($queryA1->num_rows() > 0)
      return $queryA1->result();
    else return null;
  }
  public function a1AllConnectResponse(){
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT * FROM connect_response";
    $queryA1 = $apgdb->query($sqlA1);
    if ($queryA1->num_rows()>0)
      return $queryA1->result();
    else return null;
  }
  // get total COUNT call action from a1 based on connect response & employee
  // daily
  public function a1TotalCallActionByResponseIdAndEmailDaily($responseId,$userEmail,$reportDate){
    $date=date("Y-m-d",strtotime($reportDate));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.connect_response) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE (a1Items.connect_response=? AND a1Users.email=?)
                AND (DATE_FORMAT(a1Items.contacted_date,'%Y-%m-%d')=?) AND a1Items.contacted<>?";
    $bind=array($responseId,$userEmail,$date,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // monthly
  public function a1TotalCallActionByResponseIdAndEmailMonthly($responseId,$userEmail,$reportDate){
    $period=$reportDate.'-01';
    $year=date("Y",strtotime($period));
    $month=date("m",strtotime($period));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.connect_response) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE (a1Items.connect_response=? AND a1Users.email=?)
                AND (YEAR(a1Items.contacted_date)=? AND MONTH(a1Items.contacted_date)=?) AND a1Items.contacted<>?";
    $bind=array($responseId,$userEmail,$year,$month,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // custom
  public function a1TotalCallActionByResponseIdAndEmailCustom($responseId,$userEmail,$reportDateFrom,$reportDateTo){
    $dateFrom=date("Y-m-d",strtotime($reportDateFrom));
    $dateTo=date("Y-m-d",strtotime($reportDateTo));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.connect_response) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE (a1Items.connect_response=? AND a1Users.email=?)
                AND (DATE_FORMAT(a1Items.contacted_date,'%Y-%m-%d') BETWEEN ? AND ?) AND a1Items.contacted<>?";
    $bind=array($responseId,$userEmail,$dateFrom,$dateTo,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // get total COUNT call action from a1 based on employee email & date
  // daily
  public function a1TotalCallActionByEmailDaily($userEmail,$reportDate){
    $date=date("Y-m-d",strtotime($reportDate));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.contacted) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE a1Users.email=?
                AND (DATE_FORMAT(a1Items.contacted_date,'%Y-%m-%d')=?) AND a1Items.contacted<>?";
    $bind=array($userEmail,$date,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // monthly
  public function a1TotalCallActionByEmailMonthly($userEmail,$reportDate){
    $period=$reportDate.'-01';
    $year=date("Y",strtotime($period));
    $month=date("m",strtotime($period));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.contacted) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE a1Users.email=?
                AND (YEAR(a1Items.contacted_date)=? AND MONTH(a1Items.contacted_date)=?) AND a1Items.contacted<>?";
    $bind=array($userEmail,$year,$month,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // custom
  public function a1TotalCallActionByEmailCustom($userEmail,$reportDateFrom,$reportDateTo){
    $dateFrom=date("Y-m-d",strtotime($reportDateFrom));
    $dateTo=date("Y-m-d",strtotime($reportDateTo));
    $apgdb = $this->load->database('apgdb',true);
    $sqlA1 = "SELECT COUNT(a1Items.contacted) AS total
              FROM items AS a1Items
              LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
              WHERE a1Users.email=?
                AND (DATE_FORMAT(a1Items.contacted_date,'%Y-%m-%d') BETWEEN ? AND ?) AND a1Items.contacted<>?";
    $bind=array($userEmail,$dateFrom,$dateTo,0);
    $queryA1 = $apgdb->query($sqlA1,$bind);
    if ($queryA1->num_rows()>0)
      return $queryA1->row();
    else return 0;
  }
  // all main task list by main task and employee's shift
  // used to fetch all main task in appraisal report detail.
  public function allAppraisalByMainTaskAndShift($subDeptId,$shift) {
    $sql = 'SELECT
              maintask.id,maintask.name AS taskName, maintask.sub_department_id,
              subDept.department_name,
              shift.shift_name
            FROM luffy_appraisal_task AS maintask
              LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = maintask.sub_department_id
              LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = maintask.office_shift_id
            WHERE maintask.sub_department_id=? AND maintask.office_shift_id=?';
    $bind = array($subDeptId,$shift);
    $query = $this->db->query($sql,$bind);
    return $query;
  }
  // get total point by subtask, main task, user id and month from sub task.
  // daily
  public function totalPointBySubtaskTitleDaily($subtaskTitle,$mainTaskId,$userId,$date) {
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPoint
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE subtask.name=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND DATE(subtask.created_at)=?';
      $binds=array($subtaskTitle,$mainTaskId,$userId,$date);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // monthly
  public function totalPointBySubtaskTitleMonthly($subtaskTitle,$mainTaskId,$userId,$month) {
      $period=$month.'-01';
      $year=date('Y',strtotime($period));
      $month=date('m',strtotime($period));
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPoint
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE subtask.name=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND (YEAR(subtask.created_at)=? AND MONTH(subtask.created_at)=?)';
      $binds=array($subtaskTitle,$mainTaskId,$userId,$year,$month);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // custom
  public function totalPointBySubtaskTitleCustom($subtaskTitle,$mainTaskId,$userId,$dateFrom,$dateTo) {
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPoint
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE subtask.name=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND (DATE(subtask.created_at) BETWEEN ? AND ?)';
      $binds=array($subtaskTitle,$mainTaskId,$userId,$dateFrom,$dateTo);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // get total point by main task, user id and month from sub task.
  // daily
  public function totalPointByMainTaskDaily($mainTaskId,$userId,$date) {
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPointByMainTask
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND DATE(subtask.created_at)=?';
      $binds=array($mainTaskId,$userId,$date);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // monthly
  public function totalPointByMainTaskMonthly($mainTaskId,$userId,$month) {
      $period=$month.'-01';
      $year=date('Y',strtotime($period));
      $month=date('m',strtotime($period));
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPointByMainTask
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND (YEAR(subtask.created_at)=? AND MONTH(subtask.created_at)=?)';
      $binds=array($mainTaskId,$userId,$year,$month);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // custom
  public function totalPointByMainTaskCustom($mainTaskId,$userId,$dateFrom,$dateTo) {
      $sql = 'SELECT SUM(subtask.point) AS subTaskTotalPointByMainTask
              FROM luffy_appraisal_sub_task AS subtask
                LEFT JOIN luffy_appraisal AS assignTask ON subtask.appraisal_task_id=assignTask.appraisal_task_id
              WHERE assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND (DATE(subtask.created_at) BETWEEN ? AND ?)';
      $binds=array($mainTaskId,$userId,$dateFrom,$dateTo);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  //get single appraisal single detail based on current employee & month
  //daily report
  public function getAppraisalByMaintaskEmployeeDaily($mainTask,$userId,$date) {
    $sql = 'SELECT * FROM luffy_appraisal
            WHERE appraisal_task_id=? AND employee_id=? AND start_date=?';
    $binds = array($mainTask,$userId,$date);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  //monthly report
  public function getAppraisalByMaintaskEmployeeMonthly($mainTask,$userId,$month) {
    $period=$month.'-01';
    $sql = 'SELECT * FROM luffy_appraisal
            WHERE appraisal_task_id=? AND employee_id=? AND start_date>=?';
    $binds = array($mainTask,$userId,$period);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  //custom report
  public function getAppraisalByMaintaskEmployeeCustom($mainTask,$userId,$dateFrom,$dateTo) {
    $sql = 'SELECT * FROM luffy_appraisal
            WHERE appraisal_task_id=? AND employee_id=? AND (start_date BETWEEN ? AND ?)';
    $binds = array($mainTask,$userId,$dateFrom,$dateTo);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get grade name by main task, subtask, user id, and month from grade detail.
  // used in report detail.
  // daily
  public function getGradeNameByFinalGradeIdDaily($finalGradeId,$mainTask,$userId,$date) {
      $sql = 'SELECT gradeDetail.grade_name AS gradeName
              FROM luffy_grade_detail AS gradeDetail
                LEFT JOIN luffy_appraisal AS assignTask ON assignTask.final_grade_id=gradeDetail.grade_detail_id
              WHERE assignTask.final_grade_id=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND assignTask.start_date=?';
      $binds=array($finalGradeId,$mainTask,$userId,$date);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // monthly
  public function getGradeNameByFinalGradeIdMonthly($finalGradeId,$mainTask,$userId,$month) {
      $period=$month.'-01';
      $sql = 'SELECT gradeDetail.grade_name AS gradeName
              FROM luffy_grade_detail AS gradeDetail
                LEFT JOIN luffy_appraisal AS assignTask ON assignTask.final_grade_id=gradeDetail.grade_detail_id
              WHERE assignTask.final_grade_id=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND assignTask.start_date=?';
      $binds=array($finalGradeId,$mainTask,$userId,$period);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // custom
  public function getGradeNameByFinalGradeIdCustom($finalGradeId,$mainTask,$userId,$dateFrom,$dateTo) {
      $sql = 'SELECT gradeDetail.grade_name AS gradeName
              FROM luffy_grade_detail AS gradeDetail
                LEFT JOIN luffy_appraisal AS assignTask ON assignTask.final_grade_id=gradeDetail.grade_detail_id
              WHERE assignTask.final_grade_id=? AND assignTask.appraisal_task_id=? AND assignTask.employee_id=? AND (assignTask.start_date BETWEEN ? AND ?)';
      $binds=array($finalGradeId,$mainTask,$userId,$dateFrom,$dateTo);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0)
        return $query->row();
      else return null;
  }
  // Jazz
  public function insertDataAPI_AMP($dataTransaction, $brand_id, $company_id, $channel)
  {
    foreach($dataTransaction->data as $d){
      $kode = md5($d->timestamp.$d->amount.$d->created_by.$d->approved_by);
      $sql = "
        INSERT IGNORE INTO api_amp_data (
          timestamp,
          date,
          type,
          amount,
          created_by,
          approved_by,
          brand_id,
          company_id,
          unique_code,
          imported_at,
          channel
      ) VALUES(
          ".$d->timestamp.",
          '".date('Y-m-d H:i:s', strtotime($d->date))."',
          '".$d->type."',
          '".$d->amount."',
          '".$this->filterEmployeeIdApi_AMP($d->created_by)."',
          '".$this->filterEmployeeIdApi_AMP($d->approved_by)."',
          '".$brand_id."',
          '".$company_id."',
          '".$kode."',
          '".date('Y-m-d H:i:s')."',
          '".$channel."'
      )";
      $this->db->query($sql);
    }
  }

  // Luffy 19 January 2020 01:27 pm
  // save api data from tmp
  public function insertDataAPI_TMP($dataTransaction, $channel)
  {
    foreach($dataTransaction->data as $d){
      $kode = md5($d->date.$d->amount.$d->created_by.$d->approved_by);
      $sql = "
        INSERT IGNORE INTO api_tmp_data (
          date,
          type,
          amount,
          created_by,
          approved_by,
          channel,
          unique_code,
          imported_at
      ) VALUES(
          '".date('Y-m-d H:i:s', strtotime($d->date))."',
          '".$d->type."',
          '".$d->amount."',
          '".$this->filterEmployeeIdApi_TMP($channel,$d->created_by)."',
          '".$this->filterEmployeeIdApi_TMP($channel,$d->approved_by)."',
          '".$channel."',
          '".$kode."',
          '".date('Y-m-d H:i:s')."'
      )";
      $this->db->query($sql);
    }
  }

  private function filterEmployeeIdApi_AMP($value) {
    $preg=$value;
    if(strlen($value) > 4) {
      if (($value != 'MEMBER') && ($value != 'ADMIN')){
        $preg = preg_replace( '/[^0-9]/', '', $value );
        $preg = substr($preg,-4);
        if($preg == ''){
          $preg = $value;
        }
      }else{
        $preg=$value;
      }
    }else{
      $preg=$value;
    }
    return $preg;
  }
  // modified Luffy 25 January 2020 11:21 am
  private function filterEmployeeIdApi_TMP($channel,$value) {
    $preg=$value;
    if($channel=='ADMIN' || $channel=='MEMBER'){
      if(strlen($value) > 4) {
        if (($value != 'MEMBER') && ($value != 'ADMIN')){
          $emailAddress = $value;
          $emailDomain = explode('@', $emailAddress)[1];
          if($emailDomain == 'asiapowergames.com'){
            $explode = explode("@",$emailAddress);
            array_pop($explode);
            $userEmail = join('@', $explode);
            $preg = $userEmail;
          }
        }else{
          $preg=$value;
        }
      }else{
        $preg=$value;
      }
    }
    return $preg;
  }
  // luffy 23 January 2020 05:56 pm
  
  ///// WD brand Anonymous AMP start /////
  // get widrawal data on anonymous created_by
  public function getWidrawalAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal data on anonymous approved_by
  public function getWidrawalAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal amount on anonymous created_by
  public function sumWidrawalAmountAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get widrawal amount on anonymous approved_by
  public function sumWidrawalAmountAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// WD brand Anonymous AMP end /////

  ///// WD brand Seniormasteragent AMP start /////
  // get widrawal data on seniormasteragent created_by
  public function getWidrawalSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal data on seniormasteragent approved_by
  public function getWidrawalSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal amount on seniormasteragent created_by
  public function sumWidrawalAmountSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get widrawal amount on seniormasteragent approved_by
  public function sumWidrawalAmountSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// WD brand Ayosbobet AMP end /////

  ///// WD brand Ayosbobet AMP start /////
  // get widrawal data on ayosbobet created_by
  public function getWidrawalAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal data on ayosbobet approved_by
  public function getWidrawalAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal amount on ayosbobet created_by
  public function sumWidrawalAmountAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get widrawal amount on ayosbobet approved_by
  public function sumWidrawalAmountAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// WD brand Ayosbobet AMP end /////

  ///// WD brand SbobetHoki AMP start /////
  // get widrawal data on sbobetHoki created_by
  public function getWidrawalSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal data on sbobetHoki approved_by
  public function getWidrawalSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal amount on sbobetHoki created_by
  public function sumWidrawalAmountSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get widrawal amount on sbobetHoki approved_by
  public function sumWidrawalAmountSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// WD brand SbobetHoki AMP end /////

  ///// DEPO brand Anonymous AMP start /////
  // get depo data on anonymous created_by
  public function getDepoAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo data on anonymous approved_by
  public function getDepoAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo amount on anonymous created_by
  public function sumDepoAmountAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get depo amount on anonymous approved_by
  public function sumDepoAmountAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// DEPO brand Anonymous AMP end /////

  ///// DEPO brand Seniormasteragent AMP start /////
  // get depo data on seniormasteragent created_by
  public function getDepoSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo data on seniormasteragent approved_by
  public function getDepoSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo amount on seniormasteragent created_by
  public function sumDepoAmountSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get depo amount on seniormasteragent approved_by
  public function sumDepoAmountSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// DEPO brand Seniormasteragent AMP end /////

  ///// DEPO brand Ayosbobet AMP start /////
  // get depo data on ayosbobet created_by
  public function getDepoAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo data on ayosbobet approved_by
  public function getDepoAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo amount on ayosbobet created_by
  public function sumDepoAmountAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get depo amount on ayosbobet approved_by
  public function sumDepoAmountAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// DEPO brand Ayosbobet AMP end /////

  ///// DEPO brand SbobetHoki AMP start /////
  // get depo data on sbobetHoki created_by
  public function getDepoSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo data on sbobetHoki approved_by
  public function getDepoSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get depo amount on sbobetHoki created_by
  public function sumDepoAmountSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get depo amount on sbobetHoki approved_by
  public function sumDepoAmountSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDepo FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// DEPO brand SbobetHoki AMP end /////

  ///// TF brand Anonymous AMP start /////
  // get transfer data on anonymous created_by
  public function getTransferAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer data on anonymous approved_by
  public function getTransferAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer amount on anonymous created_by
  public function sumTransferAmountAnonymousCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get transfer amount on anonymous approved_by
  public function sumTransferAmountAnonymousApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=1 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// TF brand Anonymous AMP end /////

  ///// TF brand Seniormasteragent AMP start /////
  // get transfer data on seniormasteragent created_by
  public function getTransferSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer data on seniormasteragent approved_by
  public function getTransferSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer amount on seniormasteragent created_by
  public function sumTransferAmountSeniormasteragentCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get transfer amount on seniormasteragent approved_by
  public function sumTransferAmountSeniormasteragentApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=2 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// TF brand Seniormasteragent AMP end /////

  ///// TF brand Ayosbobet AMP start /////
  // get transfer data on ayosbobet created_by
  public function getTransferAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer data on ayosbobet approved_by
  public function getTransferAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer amount on ayosbobet created_by
  public function sumTransferAmountAyosbobetCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get transfer amount on ayosbobet approved_by
  public function sumTransferAmountAyosbobetApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="168" AND brand_id=3 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// TF brand Ayosbobet AMP end /////

  ///// TF brand SbobetHoki AMP start /////
  // get transfer data on sbobetHoki created_by
  public function getTransferSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer data on sbobetHoki approved_by
  public function getTransferSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer amount on sbobetHoki created_by
  public function sumTransferAmountSbobetHokiCreatedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get transfer amount on sbobetHoki approved_by
  public function sumTransferAmountSbobetHokiApprovedBy_AMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_amp_data
            WHERE company_id="001" AND brand_id=1 AND type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// TF brand SbobetHoki AMP end /////

  ///// DEPO TMP start /////
  // get deposit data created_by
  public function getDepositCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get deposit data approved_by
  public function getDepositApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get deposit amount created_by
  public function sumDepositAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDeposit FROM api_tmp_data
            WHERE type="DEPO" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get deposit amount approved_by
  public function sumDepositAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalDeposit FROM api_tmp_data
            WHERE type="DEPO" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// DEPO TMP end /////

  ///// Widrawal TMP start /////
  // get widrawal data created_by
  public function getWidrawalCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal data approved_by
  public function getWidrawalApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get widrawal amount created_by
  public function sumWidrawalAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_tmp_data
            WHERE type="WD" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get widrawal amount approved_by
  public function sumWidrawalAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalWidrawal FROM api_tmp_data
            WHERE type="WD" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Widrawal TMP end /////

  ///// Transfer TMP start /////
  // get transfer data created_by
  public function getTransferCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer data approved_by
  public function getTransferApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get transfer amount created_by
  public function sumTransferAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_tmp_data
            WHERE type="TF" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get transfer amount approved_by
  public function sumTransferAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalTransfer FROM api_tmp_data
            WHERE type="TF" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Transfer TMP end /////

  ///// Adjustment TMP start /////
  // get adjustment data created_by
  public function getAdjustmentCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="ADJ" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get adjustment data approved_by
  public function getAdjustmentApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="ADJ" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get adjustment amount created_by
  public function sumAdjustmentAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalAdjustment FROM api_tmp_data
            WHERE type="ADJ" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get adjustment amount approved_by
  public function sumAdjustmentAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalAdjustment FROM api_tmp_data
            WHERE type="ADJ" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Adjustment TMP end /////

  ///// Bonus TMP start /////
  // get bonus data created_by
  public function getBonusCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="BONUS" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get bonus data approved_by
  public function getBonusApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="BONUS" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get bonus amount created_by
  public function sumBonusAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalBonus FROM api_tmp_data
            WHERE type="BONUS" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get bonus amount approved_by
  public function sumBonusAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalBonus FROM api_tmp_data
            WHERE type="BONUS" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Bonus TMP end /////

  ///// Commission TMP start /////
  // get commission data created_by
  public function getCommissionCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="COMMISSION" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get commission data approved_by
  public function getCommissionApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="COMMISSION" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get commission amount created_by
  public function sumCommissionAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCommission FROM api_tmp_data
            WHERE type="COMMISSION" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get commission amount approved_by
  public function sumCommissionAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCommission FROM api_tmp_data
            WHERE type="COMMISSION" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Commission TMP end /////

  ///// Cashback TMP start /////
  // get cashback data created_by
  public function getCashbackCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="CASHBACK" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get cashback data approved_by
  public function getCashbackApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="CASHBACK" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get cashback amount created_by
  public function sumCashbackAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCashback FROM api_tmp_data
            WHERE type="CASHBACK" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get cashback amount approved_by
  public function sumCashbackAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCashback FROM api_tmp_data
            WHERE type="CASHBACK" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Cashback TMP end /////

  ///// Referral TMP start /////
  // get referral data created_by
  public function getReferralCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="REFERRAL" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get referral data approved_by
  public function getReferralApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="REFERRAL" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get referral amount created_by
  public function sumReferralAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalReferral FROM api_tmp_data
            WHERE type="REFERRAL" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get referral amount approved_by
  public function sumReferralAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalReferral FROM api_tmp_data
            WHERE type="REFERRAL" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Referral TMP end /////

  ///// Freebet TMP start /////
  // get freebet data created_by
  public function getFreebetCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="FREEBET" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get freebet data approved_by
  public function getFreebetApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="FREEBET" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get freebet amount created_by
  public function sumFreebetAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalFreebet FROM api_tmp_data
            WHERE type="FREEBET" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get freebet amount approved_by
  public function sumFreebetAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalFreebet FROM api_tmp_data
            WHERE type="FREEBET" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Freebet TMP end /////

  ///// Affiliate TMP start /////
  // get freebet data created_by
  public function getAffiliateCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="AFFILIATE" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get freebet data approved_by
  public function getAffiliateApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="AFFILIATE" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get freebet amount created_by
  public function sumAffiliateAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalAffiliate FROM api_tmp_data
            WHERE type="AFFILIATE" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get freebet amount approved_by
  public function sumAffiliateAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalAffiliate FROM api_tmp_data
            WHERE type="AFFILIATE" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Affiliate TMP end /////

  ///// Surrender TMP start /////
  // get surrender data created_by
  public function getSurrenderCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="SURRENDER" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get surrender data approved_by
  public function getSurrenderApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="SURRENDER" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get surrender amount created_by
  public function sumSurrenderAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalSurrender FROM api_tmp_data
            WHERE type="SURRENDER" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get surrender amount approved_by
  public function sumSurrenderAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalSurrender FROM api_tmp_data
            WHERE type="SURRENDER" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Surrender TMP end /////

  ///// Cancel TMP start /////
  // get cancel data created_by
  public function getCancelCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="CANCEL" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get cancel data approved_by
  public function getCancelApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT * FROM api_tmp_data
            WHERE type="CANCEL" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->result();
    else return null;
  }
  // get cancel amount created_by
  public function sumCancelAmountCreatedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCancel FROM api_tmp_data
            WHERE type="CANCEL" AND created_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get cancel amount approved_by
  public function sumCancelAmountApprovedBy_TMP($employeeId,$dateFrom, $dateTo) {
    $sql = 'SELECT SUM(amount) as totalCancel FROM api_tmp_data
            WHERE type="CANCEL" AND approved_by=? AND DATE_FORMAT(date,"%Y-%m-%d")>=? AND DATE_FORMAT(date,"%Y-%m-%d")<=?';
    $binds = array($employeeId, $dateFrom, $dateTo);
    $query = $this->db->query($sql,$binds);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  ///// Cancel TMP end /////

}
?>
