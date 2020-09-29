<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dayoff_model extends CI_Model {
  // luffy 9 Feb 2020 11:40pm
	public function add($data){
    $this->db->insert_batch('dayoff', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
  }
  public function getAllEmployee($subDeptId = 0, $shiftId)//get all employee
  {
    $this->db->select("user_id, employee_id, username, office_shift_id, sub_department_id");
    $this->db->from('xin_employees');
    $this->db->where('is_active', 1);
    $this->db->where('deleted_at', NULL);
    $this->db->where('sub_department_id <>', 37);
    $this->db->where('sub_department_id <>', 38);
    $this->db->where('sub_department_id <>', 39);
    $this->db->where('sub_department_id <>', 40);
    if ($subDeptId != 0) {
      $this->db->where('sub_department_id', $subDeptId);
    }
    $this->db->where('office_shift_id', $shiftId);
    return $this->db->get();
  }
  public function updateApproval($period, $data)
  {
    if($this->db->update('dayoff', $data, ['period'=>$period])) {
			return true;
		} else {
			return false;
		}	
  }
  public function getTotalSubDept()// get total subdept
  {
    $sql = "SELECT sub_department_id 
            FROM xin_sub_departments 
            WHERE sub_department_id<>37 AND sub_department_id<>38 AND sub_department_id<>39 AND sub_department_id<>40";
    $query = $this->db->query($sql);
    return $query;
  }
  // luffy 28 january 2020
  // select all sub dept excepts from manager to director
  public function all_subdepartments() { // get all subdepartment
	  $query = $this->db->query("SELECT * from xin_sub_departments WHERE sub_department_id<>37 AND sub_department_id<>38 AND sub_department_id<>39 AND sub_department_id<>40");
    return $query->result();
  }
  // get dayoff by user Id
  public function getDayoffByUserIdDayoff($id)
  {
    return $this->db->get_where('dayoff', ['user_id'=>$id, 'have_quota'=>1, 'sub_department_id'=>37, 'sub_department_id'=>38, 'sub_department_id'=>39, 'sub_department_id'=>40]);
  }
  // get employee by id
  public function getEmployeeById($id)
  {
    $sql = "SELECT employee.username, employee.employee_id, employee.fingerprint_location, employee.user_id,
                  shift.shift_name, shift.office_shift_id, 
                  sub_department.department_name, sub_department.sub_department_id 
            FROM xin_employees AS employee
            LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = employee.office_shift_id
            LEFT JOIN xin_sub_departments AS sub_department ON sub_department.sub_department_id = employee.sub_department_id
            WHERE employee.user_id = ? AND sub_department_id<>37 AND sub_department_id<>38 AND sub_department_id<>39 AND sub_department_id<>40";
    $binds = array($id);
    $query = $this->db->query($sql, $binds);
    return $query;
  }
  // get dayoff by id
  public function getDayoffId($id)
  {
    $sql = "SELECT * FROM dayoff
            WHERE id=$id";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
  public function insertDayoff($data)//insert dayoff
  {
    $this->db->trans_begin();
      $this->db->insert('dayoff', $data);
      $id = $this->db->insert_id();
      $this->db->select('user_id, dayoff_start_day, dayoff_end_day');
      $dayoff = $this->db->get_where('dayoff', ['id'=>$id])->row();
      $this->db->select('count(user_id) as total_user');
      $totalUser = $this->db->get_where('dayoff', ['user_id'=> $dayoff->user_id, 'dayoff_start_day'=>$dayoff->dayoff_start_day, 'dayoff_end_day'=>$dayoff->dayoff_end_day])->row();
      $this->db->update('dayoff', ['month_quota'=>$totalUser->total_user], ['user_id'=> $dayoff->user_id, 'dayoff_start_day'=>$dayoff->dayoff_start_day, 'dayoff_end_day'=>$dayoff->dayoff_end_day]);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
    }
    else{
      $this->db->trans_commit();
    }
  }
  // get dayoff by sub departmnert id and date
  public function getDayoff($subDeptId = 0, $date)//get dayoff by subdept and date
  {
    $firstDateClicked = date('Y-m-d', strtotime(getFirstDateFromYearMonth_dmY($date)));
    $lastDateClicked = date('Y-m-d', strtotime(getLastDateFromYearMonth_dmY($date)));
    $sunday = date('Y-m-d', strtotime('last Sunday', strtotime($date)));
    $saturday = date('Y-m-d', strtotime('next Saturday', strtotime($date)));
    $this->db->select('dayoff.*, employee.*');
    $this->db->from('xin_employees AS employee');
    $this->db->join('dayoff', 'dayoff.user_id = employee.user_id', 'left');
    if($subDeptId != 0){
      $this->db->where("(dayoff.employee_quota > 0 AND dayoff.have_quota = 1 AND employee.user_id NOT IN (SELECT user_id FROM dayoff WHERE dayoff.dayoff_date >= '$sunday' AND dayoff.dayoff_date <= '$saturday')) OR (employee.user_id NOT IN (SELECT user_id FROM dayoff WHERE dayoff_date >= '$firstDateClicked' AND dayoff_date <= '$lastDateClicked') AND employee.is_active = 1 AND employee.deleted_at IS NULL AND employee.sub_department_id = $subDeptId)", NULL, FALSE);
      $this->db->where('employee.sub_department_id <>', 37);
      $this->db->where('employee.sub_department_id <>', 38);
      $this->db->where('employee.sub_department_id <>', 39);
      $this->db->where('employee.sub_department_id <>', 40);
    }else{
      $this->db->where("(dayoff.employee_quota > 0 AND dayoff.have_quota = 1 AND employee.user_id NOT IN (SELECT user_id FROM dayoff WHERE dayoff.dayoff_date >= '$sunday' AND dayoff.dayoff_date <= '$saturday')) OR (employee.user_id NOT IN (SELECT user_id FROM dayoff WHERE dayoff_date >= '$firstDateClicked' AND dayoff_date <= '$lastDateClicked') AND employee.is_active = 1 AND employee.deleted_at IS NULL)", NULL, FALSE);
      $this->db->where('employee.sub_department_id <>', 37);
      $this->db->where('employee.sub_department_id <>', 38);
      $this->db->where('employee.sub_department_id <>', 39);
      $this->db->where('employee.sub_department_id <>', 40);
    }
    $this->db->group_by('employee.user_id');
    $this->db->order_by('employee.employee_id', 'ASC');
    return $this->db->get();
  }
  public function delete_record($id) //delate dayoff by id
  {
    // begin
    $this->db->trans_begin();
    $this->db->select('user_id, dayoff_date, dayoff_start_day, dayoff_end_day');
    $this->db->from('dayoff');
    $this->db->where('id', $id);
    $user1 = $this->db->get()->row();
    // delete
    $this->db->where('id', $id);
    $this->db->delete('dayoff');
    // get employee quota
    $this->db->select('count(user_id) as quotaRow, employee_quota, dayoff_date, dayoff_start_day, dayoff_end_day');
    $this->db->from('dayoff');
    $this->db->where('user_id', $user1->user_id);
    $this->db->where('dayoff_start_day', $user1->dayoff_start_day);
    $this->db->where('dayoff_end_day', $user1->dayoff_end_day);
    $user2 = $this->db->get()->row();
    // end
    if($user2->quotaRow > 0){
      $this->db->where('user_id', $user1->user_id);
      $this->db->update('dayoff', ['employee_quota'=>$user2->employee_quota+1, 'have_quota'=>1], ['dayoff_start_day'=>$user2->dayoff_start_day, 'dayoff_end_day'=>$user2->dayoff_end_day]);
      $this->db->trans_complete();
    }
    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
    }
    else{
      $this->db->trans_commit();
    }
  }
  public function getEmployeeBySubdeptId($subdeptId = 0){
    $this->db->select('dayoff.*, employee.*, shift.office_shift_id, shift.shift_name, subdept.department_name');
    $this->db->from('xin_employees AS employee');
    if($subdeptId != 0){
      $this->db->where('employee.sub_department_id', $subdeptId);
    }
    $this->db->join('dayoff', 'dayoff.user_id = employee.user_id', 'left');
    $this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = employee.office_shift_id', 'left');
    $this->db->join('xin_sub_departments AS subdept', 'subdept.sub_department_id = employee.sub_department_id', 'left');
    $this->db->where('employee.is_active', 1);
    $this->db->where('employee.deleted_at', NULL);
    $this->db->where('employee.sub_department_id <>', 37);
    $this->db->where('employee.sub_department_id <>', 38);
    $this->db->where('employee.sub_department_id <>', 39);
    $this->db->where('employee.sub_department_id <>', 40);
    $this->db->order_by('employee.employee_id', 'ASC');
    return $this->db->get();
  }
  public function getDayoffByPeriod($period)
  {
    $sql = 'SELECT dayoff.*, shift.shift_name, employee.username, subDept.department_name
            FROM dayoff
            LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = dayoff.office_shift_id
            LEFT JOIN xin_employees AS employee ON employee.user_id = dayoff.user_id
            LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = dayoff.sub_department_id
            WHERE period = ?';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		return $query;
  }
  public function checkDayoffInMonth($user_id, $date) // check user ID insert type
  {
    $firstDateClicked = date('Y-m-d', strtotime(getFirstDateFromYearMonth_dmY($date)));
    $lastDateClicked = date('Y-m-d', strtotime(getLastDateFromYearMonth_dmY($date)));
    $query = $this->db->get_where('dayoff', ['dayoff.user_id'=>$user_id, 'dayoff_start_day'=>$firstDateClicked, 'dayoff_end_day'=>$lastDateClicked])->row();
    if($query->dayoff_start_day == $firstDateClicked AND $query->dayoff_end_day == $lastDateClicked){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  public function update($where, $data)
  {
    $this->db->update('dayoff', $data, $where);
    return $this->db->affected_rows();
  }
  // luffy 28 January 2020 09:47 pm | get the latest period
  public function getMaxPeriod()
  {
    $sql = 'SELECT MAX(period) AS period FROM dayoff';
    $query = $this->db->query($sql);
    return $query->row();
  }
  public function get_dayoff()
  {
    $sql = 'SELECT * FROM dayoff GROUP BY period ORDER BY period DESC';
		$query = $this->db->query($sql);
		return $query;
  }
  public function getDayoffInDate($dayStart, $dayEnd)
  {
    $sql = 'SELECT dayoff.* FROM dayoff WHERE dayoff_start_day = ? OR dayoff_end_day = ?';
		$binds = array($dayStart, $dayEnd);
		$query = $this->db->query($sql, $binds);
		return $query->result();
  }
  public function getCountEmployee($subdeptId, $officeShiftId)
  {
    $sql = "SELECT count(user_id) AS countEmployee FROM xin_employees WHERE sub_department_id = ".$subdeptId." AND office_shift_id = ".$officeShiftId."";
    $query = $this->db->query($sql);
    return $query;
  }
  public function checkQuotaDayoff($date_drop, $user_id)
  {
    $sql = "SELECT user_id FROM dayoff WHERE sub_department_id = ".$subdeptId." AND office_shift_id = ".$officeShiftId." AND dayoff_date = '$date_drop'";
		$query = $this->db->query($sql);
    return $query;
  }
  public function getQuotaDayoff($subdeptId, $officeShiftId, $date_drop)
  {
    $sql = "SELECT user_id FROM dayoff WHERE sub_department_id = ".$subdeptId." AND office_shift_id = ".$officeShiftId." AND dayoff_date = '$date_drop'";
		$query = $this->db->query($sql);
    return $query;
  }
  // jazz 7381 5 february 2020 17:53
  // get approval by period
  public function getApprovalByPeriod($period)
  {
    $sql = 'SELECT 
              approval_1, approved_by_1, approval_action_by_1, approved_date_1,
              approval_2, approved_by_2, approval_action_by_2, approved_date_2,
              approval_3, approved_by_3, approval_action_by_3, approved_date_3
            FROM dayoff
            WHERE period = ?';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->row();
    else return null;
  }
  // get employee by user id
  public function getEmployeeByUserId($userId)
  {
    $sql = 'SELECT 
              employee_id, username
            FROM xin_employees
            WHERE user_id = ?';
		$binds = array($userId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->row();
    else return null;
  }
  // luffy 29 January 2020 06:31 pm
  // get all dayoff data by period
  public function getAllDayoffByPeriod($period) {
		$sql = 'SELECT 
              dayoff.employee_id, dayoff.dayoff_date, dayoff.dayoff_start_day, dayoff.dayoff_end_day, dayoff.note, dayoff.approval_action_by_1, dayoff.approval_action_by_2, dayoff.approval_action_by_3,  
              employee.fingerprint_location, employee.username, location.location_name,
              subdept.department_name,
              shift.shift_name
            FROM dayoff AS dayoff
            LEFT JOIN xin_employees AS employee ON employee.user_id = dayoff.user_id
            LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = dayoff.sub_department_id
            LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = dayoff.office_shift_id
            LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
            WHERE dayoff.period = ? AND employee.is_active=1 AND employee.deleted_at IS NULL AND employee.fingerprint_location != 0
            GROUP BY dayoff.user_id';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
	}
  // luffy 30 January 2020 06:31 pm
  // get all dayoff data by period
  public function getDayoffDateByRangeDate($dateFrom,$dateTo) {
		$sql = 'SELECT dayoff_date FROM `dayoff` WHERE `dayoff_date` BETWEEN ? AND ? GROUP BY dayoff_date';
		$binds = array($dateFrom,$dateTo);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
  }
  // Approval
  // jazz 04 February 2020
  public function getApprovalStatus($period)
  {
    $sql = 'SELECT * FROM `dayoff` WHERE `period` = ?';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query;
    else return null;
  }
  public function getAllApprover()
  {
    $sql = "SELECT employee.user_id, employee.username FROM luffy_approver 
            LEFT JOIN xin_employees AS employee ON employee.user_id = luffy_approver.approver
    ";
		$query = $this->db->query($sql);
    return $query;
  }
}
/* End of file Dayoff_model.php */
