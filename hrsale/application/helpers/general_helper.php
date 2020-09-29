<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    //'debug' => true,
	    'roots' => array(
	      array(
	        'driver' => 'LocalFileSystem',
	        'path'   => './uploads/files_manager/',
	        'URL'    => site_url('uploads/files_manager').'/'
	        // more elFinder options here
	      )
	    )
	);
	return $opts;
}
if ( ! function_exists('get_employee_leave_category'))
{
	function get_employee_leave_category($id_nums,$employee_id) {
		$CI =&	get_instance();
		$sql = "select e.leave_categories,e.user_id,l.leave_type_id,l.type_name from xin_employees as e, xin_leave_type as l where l.leave_type_id IN ($id_nums) and e.user_id = $employee_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments'))
{
	function get_sub_departments($id) {
		$CI =&	get_instance();
		$sql = "select * from xin_sub_departments where department_id = $id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_main_departments_employees'))
{
	function get_main_departments_employees() {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_departments as d, xin_employees as e where d.department_id = e.department_id and e.is_active=1 group by e.department_id order by e.department_id desc";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments_employees'))
{
	function get_sub_departments_employees($id,$empid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_sub_departments as d, xin_employees as e where d.sub_department_id = e.sub_department_id and e.department_id = '".$id."' and e.employee_id!= '".$empid."' and e.is_active=1 group by e.sub_department_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
if ( ! function_exists('get_sub_departments_designations'))
{
	function get_sub_departments_designations($id,$empid,$mainid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from xin_designations as d, xin_employees as e where d.designation_id = e.designation_id and e.employee_id!= '".$empid."' and e.employee_id!= '".$mainid."' and e.designation_id = '".$id."' and e.is_active=1";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}
// luffy start 25 nov 2019 12:03 pm
// gather all main department
// used for organization chart
if ( ! function_exists('orgchartDept'))
{
	function orgchartDept() {
		$CI =&	get_instance();
		$sql = "SELECT
							employee.user_id, employee.employee_id, employee.username, employee.sub_department_id, employee.designation_id
							,dept.department_id, dept.department_name
						FROM xin_employees AS employee, xin_departments AS dept
						WHERE dept.department_id<>11 AND dept.department_id<>14
						GROUP BY dept.created_at -- just my own trick :) #luffy
						ORDER BY dept.department_name DESC";
    $query = $CI->db->query($sql);
		if(!is_null($query))
      return $query->result();
    else return null;
	}
}
function xid(){return 7380;}
// gather all subdept by dept
// used for organization chart
if ( ! function_exists('orgchartSubDept'))
{
	function orgchartSubDept($deptId) {
		$CI =&	get_instance();
		$sql = "SELECT
							subdept.department_id, subdept.sub_department_id, subdept.department_name
							,designation.designation_id
						FROM xin_sub_departments AS subdept
						LEFT JOIN xin_designations AS designation ON designation.sub_department_id=subdept.sub_department_id
						WHERE subdept.department_id=$deptId
						GROUP BY subdept.created_at -- just my own trick :) #luffy
						ORDER BY subdept.sub_department_id DESC";
    $query = $CI->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
	}
}
// gather all officer by dept & subdept & designation
// used for organization chart
if ( ! function_exists('orgChartManagers'))
{
	function orgChartManagers() {
		$CI =&	get_instance();
		$sql = "SELECT
							employee.user_id, employee.employee_id, employee.username,
							employee.department_id, employee.sub_department_id, employee.designation_id,
							employee.is_supervisor,employee.is_officer, employee.gender
							, employee.profile_picture_sso, employee.profile_picture
						FROM xin_employees AS employee
						WHERE employee.is_active=1
									AND employee.user_id<>1 -- companyapg
									AND employee.user_id<>74 -- apgadmin
									AND employee.user_id<>75 -- user testing 1
									AND employee.user_id<>76 -- user testing 2
									AND employee.user_id<>77 -- user fingerprint
									AND employee.is_manager=1
									";
    $query = $CI->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
	}
}
// gather all supervisor by dept & subdept & designation
// used for organization chart
if ( ! function_exists('orgChartSupervisors'))
{
	function orgChartSupervisors($deptId) {
		$CI =&	get_instance();
		$sql = "SELECT
							employee.user_id, employee.employee_id, employee.username,
							employee.department_id, employee.sub_department_id, employee.designation_id,
							employee.is_supervisor,employee.is_officer, employee.gender
							, employee.profile_picture_sso, employee.profile_picture
						FROM xin_employees AS employee
						WHERE employee.is_active=1
									AND employee.department_id=$deptId
									AND employee.user_id<>1 -- companyapg
									AND employee.user_id<>74 -- apgadmin
									AND employee.user_id<>75 -- user testing 1
									AND employee.user_id<>76 -- user testing 2
									AND employee.user_id<>77 -- user fingerprint
									AND employee.is_supervisor=1
									AND employee.is_officer=1
									";
    $query = $CI->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
	}
}
// gather all officer by dept & subdept & designation
// used for organization chart
if ( ! function_exists('orgChartOfficers'))
{
	function orgChartOfficers($deptId,$subDeptId) {
		$CI =&	get_instance();
		$sql = "SELECT
							employee.user_id, employee.employee_id, employee.username,
							employee.department_id, employee.sub_department_id, employee.designation_id,
							employee.is_supervisor,employee.is_officer, employee.gender
							, employee.profile_picture_sso, employee.profile_picture
						FROM xin_employees AS employee
						WHERE employee.is_active=1
									AND employee.department_id=$deptId
									AND employee.sub_department_id=$subDeptId
									AND employee.user_id<>1 -- companyapg
									AND employee.user_id<>74 -- apgadmin
									AND employee.user_id<>75 -- user testing 1
									AND employee.user_id<>76 -- user testing 2
									AND employee.user_id<>77 -- user fingerprint
									AND employee.is_officer=1
									AND employee.is_supervisor=0
									";
    $query = $CI->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
	}
}
// gather all staff by dept & subdept & designation
// used for organization chart
if ( ! function_exists('orgChartStaffs'))
{
	function orgChartStaffs($deptId,$subDeptId) {
		$CI =&	get_instance();
		$sql = "SELECT
							employee.user_id, employee.employee_id, employee.username,
							employee.department_id, employee.sub_department_id, employee.designation_id,
							employee.is_officer, employee.gender
							, employee.profile_picture_sso, employee.profile_picture
						FROM xin_employees AS employee
						WHERE employee.is_active=1
									AND employee.department_id=$deptId
									AND employee.sub_department_id=$subDeptId
									AND employee.user_id<>1 -- companyapg
									AND employee.user_id<>74 -- apgadmin
									AND employee.user_id<>75 -- user testing 1
									AND employee.user_id<>76 -- user testing 2
									AND employee.user_id<>77 -- user fingerprint
									AND employee.is_director=0 AND employee.is_manager=0 AND employee.is_wakil_manager=0 AND employee.is_supervisor=0 AND employee.is_officer=0
									";
    $query = $CI->db->query($sql);
    if(!is_null($query))
      return $query->result();
    else return null;
	}
}

if ( ! function_exists('total_salaries_paid'))
{
	function total_salaries_paid() {
			$CI =&	get_instance();
			$CI->db->from('xin_salary_payslips');
			$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->net_salary;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}
// Start : 7381-jazz 17jan2020 18:28
// array filter fingerprint today
function filter_tgl($array) {
	if(date('Y-m-d', strtotime($array['waktu'])) == date('Y-m-d')){
		return TRUE;
	}else{
		return FALSE;
	}
}
function filter_dayoff($array) {
	// return TRUE;
	if($array['username'] == 'Jazz'){
		return TRUE;
	}else{
		return FALSE;
	}
}
function array_diff_values($tab1, $tab2)
{
	$result = array();
	foreach($tab1 as $values) if(! in_array($values, $tab2)) $result[] = $values;
	return $result;
}
// end array filter
function nama_hari($tanggal)
{
  $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
  $pecah = explode("-", $ubah);
  $tgl = $pecah[2];
  $bln = $pecah[1];
  $thn = $pecah[0];
  $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
  return $nama;
}
function getDaysInMonth($year, $month, $day)
{
	return new DatePeriod(
		new DateTime("first $day of $year-$month"),
		DateInterval::createFromDateString("next $day"),
		new DateTime("last $day of $year-$month")
	);
}
function getDaysBetweenRangeDate($day, $dateFrom, $dateTo)
{
	return new DatePeriod(
		new DateTime($dateFrom),
		DateInterval::createFromDateString("next $day"),
		new DateTime($dateTo)
	);
}
function getIntervalBetweenDate($date1, $date2){
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($date1, $interval, $date2);
	return $period;
}
// End : 7381-jazz 17jan2020 18:28
function getFirstDateFromYearMonth_dmY($yearMonth)
{
	$dtFirstDay = new DateTime("first day of $yearMonth");
	$firstDay = $dtFirstDay->format('d-m-Y');
	return $firstDay;
}
function getLastDateFromYearMonth_dmY($yearMonth)
{
	$dtLastDay = new DateTime("last day of $yearMonth");
	$lastDay = $dtLastDay->format('d-m-Y');
	return $lastDay;
}
?>
