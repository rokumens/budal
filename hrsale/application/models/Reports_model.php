<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// get payslip list> reports
	public function get_payslip_list($cid,$eid,$re_date) {
	  if($eid=='' || $eid==0){
		$sql = 'SELECT * from xin_salary_payslips where salary_month = ? and company_id = ?';
		$binds = array($re_date,$cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	  } else {
		$sql = 'SELECT * from xin_salary_payslips where employee_id = ? and salary_month = ? and company_id = ?';
		$binds = array($eid,$re_date,$cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	  }
	}
	// get training list> reports
	public function get_training_list($cid,$sdate,$edate) {
		$sql = 'SELECT * from `xin_training` where company_id = ? and start_date >= ? and finish_date <= ?';
		$binds = array($cid,$sdate,$edate);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get project list> reports
	public function get_project_list($projId,$projStatus) {
		if($projId==0 && $projStatus==4) {
			return $query = $this->db->query("SELECT * FROM `xin_projects`");
		} else if($projId==0 && $projStatus!=4) {
			$sql = 'SELECT * from `xin_projects` where status = ?';
			$binds = array($projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus==4) {
			$sql = 'SELECT * from `xin_projects` where project_id = ?';
			$binds = array($projId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus!=4) {
			$sql = 'SELECT * from `xin_projects` where project_id = ? and status = ?';
			$binds = array($projId,$projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}

	// get task list> reports
	public function get_task_list($taskId,$taskStatus) {
		  if($taskId==0 && $taskStatus==4) {
			  return $query = $this->db->query("SELECT * FROM xin_tasks");
		  } else if($taskId==0 && $taskStatus!=4) {
			  $sql = 'SELECT * from xin_tasks where task_status = ?';
			  $binds = array($taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus==4) {
			  $sql = 'SELECT * from xin_tasks where task_id = ?';
			  $binds = array($taskId);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus!=4) {
		  	  $sql = 'SELECT * from xin_tasks where task_id = ? and task_status = ?';
			  $binds = array($taskId,$taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}

	// get roles list> reports
	public function get_roles_employees($role_id) {
		  if($role_id==0) {
				$sql = 'SELECT employee.*, location.location_name
								FROM xin_employees AS employee
								LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
								WHERE employee.is_active = 1 AND employee.deleted_at IS NULL AND employee.fingerprint_location != 0';
			  return $query = $this->db->query($sql);
		  } else {
				$sql = 'SELECT employee.*, location.location_name
								FROM xin_employees AS employee
								LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
								where employee.user_role_id = ? AND employee.is_active = 1 AND employee.deleted_at IS NULL AND employee.fingerprint_location != 0';
			  // $sql = 'SELECT * from xin_employees where user_role_id = ?';
			  $binds = array($role_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}

	// get employees list> reports
	public function get_employees_reports($company_id,$department_id,$designation_id) {
		  if($company_id==0 && $department_id==0 && $designation_id==0) {
		 	 return $query = $this->db->query("SELECT * FROM xin_employees");
		  } else if($company_id!=0 && $department_id==0 && $designation_id==0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ?';
			  $binds = array($company_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($company_id!=0 && $department_id!=0 && $designation_id==0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ?';
			  $binds = array($company_id,$department_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($company_id!=0 && $department_id!=0 && $designation_id!=0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ? and designation_id = ?';
			  $binds = array($company_id,$department_id,$designation_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else {
			  return $query = $this->db->query("SELECT * FROM xin_employees");
		  }
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
   if ($queryA1->num_rows() > 0) {
     return $queryA1->result();
   } else {
     return null;
   }
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
 public function a1TotalCallActionByResponseIdAndEmail($reportDate,$responseId,$userEmail){
   $year=date("Y",strtotime($reportDate));
   $month=date("n",strtotime($reportDate));
   $apgdb = $this->load->database('apgdb',true);
   $sqlA1 = "SELECT COUNT(a1Items.connect_response) AS total
             FROM items AS a1Items
             LEFT JOIN users AS a1Users ON a1Items.assign_to=a1Users.id
             WHERE (a1Items.connect_response=? AND a1Users.email=?)
                   AND (YEAR(a1Items.contacted_date)='{$year}' AND MONTH(a1Items.contacted_date)='{$month}')";
   $bind=array($responseId,$userEmail);
   $queryA1 = $apgdb->query($sqlA1,$bind);
   if ($queryA1->num_rows()>0)
     return $queryA1->row();
   else return 0;
 }
 // get total COUNT lupa absen fingerprint
 public function totalLupaAbsenByDateAndEmployeeId($reportDate,$employeeId){
   $year=date("Y",strtotime($reportDate));
   $month=date("n",strtotime($reportDate));
   $sql = "SELECT COUNT(approval_status) AS totalLupaAbsen
           FROM xin_attendance_time
           WHERE (approval_status=1 AND approved_by<>0 AND employee_id=?)
                 AND (YEAR(attendance_date)='{$year}' AND MONTH(attendance_date)='{$month}')";
   $this->db->order_by("employee.first_name asc");
   $bind=array($employeeId);
   $query = $this->db->query($sql,$bind);
   if ($query->num_rows()>0)
     return $query->row();
   else return null;
 }
 // get total COUNT late
 public function totalLateByDateAndEmployeeId($reportDate,$employeeId){
   $year=date("Y",strtotime($reportDate));
   $month=date("n",strtotime($reportDate));
   $sql = "SELECT COUNT(late) AS totalTelat
           FROM xin_attendance_time
           WHERE (late<>'' AND employee_id=?)
                 AND (YEAR(attendance_date)='{$year}' AND MONTH(attendance_date)='{$month}')";
   $this->db->order_by("employee.first_name asc");
   $bind=array($employeeId);
   $query = $this->db->query($sql,$bind);
   if ($query->num_rows()>0)
     return $query->row();
   else return null;
 }
 public function getActiveEmployees(){
   $sql = "SELECT * FROM xin_employees WHERE is_active=1 AND fingerprint_location!=''";
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

}
?>
