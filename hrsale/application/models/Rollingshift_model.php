<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rollingshift_model extends CI_Model {
  // luffy 9 Feb 2020 11:40pm
	public function add($data){
    $this->db->insert_batch('rollingshift', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
  }
  // get all employee
  public function getAllEmployee()
  {
    $sql = 'SELECT
      employee.employee_id, employee.username, employee.user_id,
      subDept.sub_department_id, subDept.department_name,
      shift.shift_name, employee.office_shift_id
      FROM xin_employees AS employee
      LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = employee.office_shift_id
      LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = employee.sub_department_id
      WHERE employee.is_active = 1 AND employee.deleted_at IS NULL AND employee.sub_department_id IS NOT NULL
      ORDER BY employee.employee_id DESC';
    $query = $this->db->query($sql);
    return $query;
  }
  // get employee by sub_department_id and office_shift_id
  public function getEmployeeByDivisi($sub_dept_id, $shift_id)
  {
    $sql = "SELECT
      subDept.department_name, employee.employee_id, employee.username,
      shift.shift_name, count(employee.user_id) AS totalEmployeeInDivisi
      FROM xin_employees AS employee
      LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = employee.office_shift_id
      LEFT JOIN xin_sub_departments AS subDept ON subDept.sub_department_id = employee.sub_department_id
      WHERE employee.sub_department_id = $sub_dept_id AND employee.shift_id = $shift_id AND employee.sub_department_id IS NOT NULL
      ORDER BY employee.employee_id DESC";
    $query = $this->db->query($sql);
    return $query;
  }
  // get employee rolling shift
  public function getEmployeeRollingshift()
  {
    $this->db->select('
      employee.user_id,employee.username,employee.employee_id,
      shift.office_shift_id, shift.shift_name,
      subDept.sub_department_id,dept.department_id
    ');
    $this->db->from('xin_employees AS employee');
    $this->db->join('xin_sub_departments AS subDept', 'subDept.sub_department_id = employee.sub_department_id', 'left');
    $this->db->join('xin_departments AS dept', 'dept.department_id = employee.department_id', 'left');
    $this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = employee.office_shift_id', 'left');
    $this->db->where('employee.is_active', 1);
    $this->db->where('employee.deleted_at IS NULL');
    $this->db->where('employee.user_id NOT IN (SELECT user_id FROM rollingshift)',NULL,FALSE);
    $this->db->order_by('employee.first_name', 'asc');
    return $this->db->get();
  }
  // get all sub_department
  public function all_subdepartments() {
    $this->db->select('*');
    $this->db->from('xin_sub_departments');
    $this->db->where('department_id', 2);
    return $this->db->get()->result();
  }
  // get rollingshift by user Id
  public function getRollingshiftByUserIdRollingshift($id)
  {
    return $this->db->get_where('rollingshift', ['user_id'=>$id, 'have_quota'=>1]);
  }
  // get rollingshift by id
  public function getRollingshiftId($id)
  {
    $sql = "SELECT * FROM rollingshift
            WHERE id=$id";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
// get roling shift by user id
  public function getRollingshiftByUserId($userId)
  {
    $this->db->select('
      employee.username, employee.employee_id, employee.fingerprint_location, employee.user_id,
      shift.shift_name, shift.office_shift_id, 
      sub_department.department_name, sub_department.sub_department_id'
    );
    $this->db->from('xin_employees AS employee');
    $this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = employee.office_shift_id', 'left');
    $this->db->join('xin_sub_departments AS sub_department', 'sub_department.sub_department_id = employee.sub_department_id', 'left');
    $this->db->where('employee.user_id', $userId);
    return $this->db->get();
  }
  // insert rolling shift
  public function insertRollingshift($data)
  {
    $this->db->insert('rollingshift', $data);
  }
  // get rolling shift by sub_department id and date
  public function getRollingshift($subDeptId = 0, $date)
  {
    $firstDateClicked = date('Y-m-d', strtotime(getFirstDateFromYearMonth_dmY($date)));
    $lastDateClicked = date('Y-m-d', strtotime(getLastDateFromYearMonth_dmY($date)));
    $sunday = date('Y-m-d', strtotime('last Sunday', strtotime($date)));
    $saturday = date('Y-m-d', strtotime('next Saturday', strtotime($date)));
    $this->db->select('rollingshift.*, employee.*');
    $this->db->from('xin_employees AS employee');
    $this->db->join('rollingshift', 'rollingshift.user_id = employee.user_id', 'left');
    $this->db->where('employee.is_active', 1);
    $this->db->where('employee.deleted_at', NULL);
    if($subDeptId > 0){
      $this->db->where('employee.sub_department_id', $subDeptId);
    }elseif($subDeptId == 'others'){
      $this->db->where('employee.employee_id = 6360 OR employee.employee_id = 6345', NULL, FALSE);
    }else{
      $this->db->where('employee.department_id = 2 OR employee.employee_id = 6360 OR employee.employee_id = 6345', NULL, FALSE);
    }
    $this->db->group_by('employee.user_id');
    $this->db->order_by('employee.employee_id', 'ASC');
    return $this->db->get();
  }
  public function checkRollingshiftInMonth($user_id, $date) // check user ID insert type
  {
    $firstDateClicked = date('Y-m-d', strtotime(getFirstDateFromYearMonth_dmY($date)));
    $lastDateClicked = date('Y-m-d', strtotime(getLastDateFromYearMonth_dmY($date)));
    $query = $this->db->get_where('rollingshift', ['rollingshift.user_id'=>$user_id, 'rollingshift_start_day'=>$firstDateClicked, 'rollingshift_end_day'=>$lastDateClicked])->row();
    if($query->rollingshift_start_day == $firstDateClicked AND $query->rollingshift_end_day == $lastDateClicked){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  public function checkDayoffInRollingshift($period)
  {
    $rollingshift = $this->db->get_where('rollingshift', ['period'=>$period])->row();
    $this->db->where("dayoff_date BETWEEN '$rollingshift->rollingshift_start_day' AND '$rollingshift->rollingshift_end_day'", NULL, FALSE);
    return $this->db->get('dayoff');
  }
  // get rolling shift by period
  public function getAllRollingshiftPeriodHaveDayoff($period = NULL)
  {
    $rollingshift = $this->db->get_where('rollingshift', ['period'=>$period])->row();
    $this->db->select('rollingshift.*, employee.username, shift.shift_name, subdept.department_name, dayoff.dayoff_date');
    $this->db->from('rollingshift');
    $this->db->join('xin_employees AS employee', 'employee.user_id = rollingshift.user_id', 'left');
    $this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = rollingshift.office_shift_id', 'left');
    $this->db->join('xin_sub_departments AS subdept', 'subdept.sub_department_id = rollingshift.sub_department_id', 'left');
    $this->db->join('dayoff', 'dayoff.user_id = rollingshift.user_id', 'left');
    $this->db->where('rollingshift.period', $period);
    $this->db->where("dayoff.dayoff_date BETWEEN '$rollingshift->rollingshift_start_day' AND '$rollingshift->rollingshift_end_day'", NULL, FALSE);
    $this->db->where('employee.fingerprint_location!=', '');
    // luffy 5 February 2020 06:13 pm
    $this->db->where('employee.is_active=', 1);
    return $this->db->get();
  }
  // get rolling shift by period
  public function getAllRollingshiftPeriodNoDayoff($period = NULL)
  {
    $this->db->select('rollingshift.*, employee.username, shift.shift_name, subdept.department_name');
    $this->db->from('rollingshift');
    $this->db->join('xin_employees AS employee', 'employee.user_id = rollingshift.user_id', 'left');
    $this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = rollingshift.office_shift_id', 'left');
    $this->db->join('xin_sub_departments AS subdept', 'subdept.sub_department_id = rollingshift.sub_department_id', 'left');
    $this->db->where('rollingshift.period', $period);
    $this->db->where('employee.fingerprint_location!=', '');
    // luffy 5 February 2020 06:13 pm
    $this->db->where('employee.is_active=', 1);
    return $this->db->get();
  }
  // get all rolling shift by sub departmnet id
  public function getRollingshiftBySubdeptId($subDeptId = 0)
  {
    $this->db->select('employee.user_id, employee.employee_id, employee.sub_department_id, employee.office_shift_id');
    $this->db->from('xin_employees AS employee');
    $this->db->where('employee.is_active', 1);
    $this->db->where('employee.deleted_at', NULL);
    if($subDeptId > 0){
      $this->db->where('employee.sub_department_id', $subDeptId);
    }elseif($subDeptId == 'others'){
      $this->db->where('employee.employee_id = 6360 OR employee.employee_id = 6345', NULL, FALSE);
    }else{
      $this->db->where('employee.department_id = 2 OR employee.employee_id = 6360 OR employee.employee_id = 6345', NULL, FALSE);
    }
    return $this->db->get();
  }
  public function getEmployeeRollingshiftById($id)
  {
    $sql = 'SELECT rollingshift.id, rollingshift.period, rollingshift.user_id, rollingshift.employee_id, rollingshift.sub_department_id, rollingshift.office_shift_id, rollingshift.rollingshift_date, rollingshift.is_leave_at, 
            employee.username 
            FROM rollingshift
            LEFT JOIN xin_employees AS employee ON employee.user_id = rollingshift.user_id
            WHERE rollingshift.id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
  }
  public function getAllShift()
  {
    $sql = 'SELECT office_shift_id, shift_name 
            FROM xin_office_shift';
		$query = $this->db->query($sql);
		return $query;
  }
  public function getAllSubdepartmentOprasional()// get all sub department where department is oprasional
  {
    $this->db->select('sub_department_id, department_name');
    $this->db->where('department_id = 2 OR sub_department_id = 35 OR sub_department_id = 33', NULL, FALSE);
    return $this->db->get('xin_sub_departments');
  }
  public function update($id, $data)
  {
    $this->db->update('rollingshift', $data, ['id'=>$id]);
    return $this->db->affected_rows();
  }
  // update dayoff have anual leave
  public function updateAnualLeave($where, $data)
  {
    $employee_id = $where['employee_id'];
    $is_leave_at = $where['anual_leave_date'];
    $this->db->where("employee_id = $employee_id AND rollingshift_date >= '$is_leave_at'", NULL, FALSE);
    $this->db->update('rollingshift', $data);
    if($this->db->affected_rows() > 0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  // check anual leave on rollingshift by user id and period
  public function getRollingByPeriodId($lastPeriod, $user_id)
  {
    $sql = "SELECT * FROM rollingshift WHERE period = ? AND employee_id = ? ORDER BY id DESC";
		$binds = array($lastPeriod, $user_id);
		$query = $this->db->query($sql, $binds);
		return $query;
  }
  public function getRollingByUserId($userId, $date)
  {
    return $this->db->get_where('rollingshift', ['user_id'=>$userId, 'rollingshift_date'=>$date]);
  }
  public function getRollingshiftByDate($dateFrom)
  {
    $sql = 'SELECT * FROM rollingshift WHERE rollingshift_date = ?';
		$binds = array($dateFrom);
		$query = $this->db->query($sql, $binds);
		return $query;
  }
  // get rollingshift by period
  public function getRollingshiftByPeriod($period, $employee_id, $date)
  {
    $sql = "SELECT * FROM rollingshift WHERE period = ? AND employee_id = ? AND rollingshift_date = ?";
		$binds = array($period, $employee_id, $date);
		$query = $this->db->query($sql, $binds);
		return $query;
  }
  public function getMaxPeriod()
  {
    $sql = 'SELECT MAX(period) AS period FROM rollingshift';
    $query = $this->db->query($sql);
    return $query->row();
  }
  public function get_rollingshifts()
  {
    $sql = 'SELECT * FROM rollingshift GROUP BY period ORDER BY period DESC';
		$query = $this->db->query($sql);
		return $query;
  }
  // luffy 1 February 2020 11:31 am
  // get all rolling shift data by period
  public function getAllRollingshiftByPeriod($period) {
		$sql = 'SELECT 
              shift.employee_id, shift.rollingshift_date, shift.rollingshift_start_day, shift.rollingshift_end_day,
              employee.fingerprint_location, employee.username,
              subdept.department_name,
              officeshift.shift_name
            FROM rollingshift AS shift
            LEFT JOIN xin_employees AS employee ON employee.user_id = shift.user_id
            LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id = shift.sub_department_id
            LEFT JOIN xin_office_shift AS officeshift ON officeshift.office_shift_id = employee.office_shift_id
            WHERE shift.period = ? AND employee.fingerprint_location<>"" AND employee.is_active = 1
            GROUP BY shift.user_id';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
  }
  
  // luffy 2 February 2020 11:31 am
  public function AllRolingshiftGroupByPeriod($period) {
		$sql = 'SELECT * FROM rollingshift AS shift
            GROUP BY rollingshift_date';
		$binds = array($period);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
	}

  // luffy 2 February 2020 06:27 am
  public function getNameRollingshiftByPeriodDateSubdept($period,$date,$shiftId,$subDeptId) {
		$sql = 'SELECT 
              shift.employee_id, shift.rollingshift_date,
              employee.username
            FROM rollingshift as shift
            LEFT JOIN xin_employees AS employee ON employee.user_id = shift.user_id
            WHERE shift.period=? AND shift.rollingshift_date=? AND shift.office_shift_id=? AND shift.sub_department_id=? AND employee.fingerprint_location<>"" AND employee.is_active = 1 AND shift.is_leave_at IS NULL';
		$binds = array($period,$date,$shiftId,$subDeptId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
	}
  // luffy 2 February 2020 08:46 am
  public function getNameRollingshiftByPeriodDateOther($period,$date,$shiftId) {
		$sql = 'SELECT 
              shift.employee_id, shift.rollingshift_date,
              employee.username
            FROM rollingshift as shift
            LEFT JOIN xin_employees AS employee ON employee.user_id = shift.user_id
            WHERE (employee.employee_id=6360 OR employee.employee_id=6345)AND shift.period=? AND shift.rollingshift_date=? AND shift.office_shift_id=? AND employee.fingerprint_location<>"" AND employee.is_active = 1 AND shift.is_leave_at IS NULL';
		$binds = array($period,$date,$shiftId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query->result();
    else return null;
	}
  // luffy 1 February 2020 08:46 am
  public function getNameRollingshiftByPeriodDateDayoff($period,$date,$shiftId) {
		$sql = 'SELECT 
              shift.employee_id, shift.rollingshift_date,
              employee.username
            FROM rollingshift as shift
            LEFT JOIN xin_employees AS employee ON employee.user_id = shift.user_id
            LEFT JOIN dayoff AS dayoff ON dayoff.user_id = shift.user_id
            WHERE shift.period=? AND shift.rollingshift_date=? AND shift.office_shift_id=? AND shift.rollingshift_date = dayoff.dayoff_date AND employee.fingerprint_location<>"" AND dayoff.dayoff_date BETWEEN shift.rollingshift_start_day AND shift.rollingshift_end_day AND employee.is_active = 1 AND shift.is_leave_at IS NULL';
		$binds = array($period,$date,$shiftId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
      return $query;
    else return null;
  }
}

/* End of file rollingshift_model.php */
