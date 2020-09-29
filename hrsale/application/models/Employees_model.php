<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employees_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 	// get all employees
	public function get_employees() {
		$this->db->where('is_active = 1 AND deleted_at IS NULL AND fingerprint_location != 0', NULL, FALSE);
	  return $this->db->get("xin_employees");
	}
	// get employees
	public function get_attendance_employees() {
    $sql = 'SELECT * FROM xin_employees AS employee
						LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
						WHERE employee.is_active=? AND employee.deleted_at IS NULL AND employee.fingerprint_location != 0';
		$binds = array(1);
		$query = $this->db->query($sql,$binds);
	  return $query;
	}
	// get employees where company is apg
	public function employeeActiveAPG() {
    $sql = 'SELECT * FROM xin_employees WHERE is_active=1 AND deleted_at IS NULL AND fingerprint_location != 0';
		$query = $this->db->query($sql);
	  return $query;
	}
	// Jazz 7381 - 8 february 2020 19:59
	// get approver where not in luffy approver table
	public function employeeApprover() {
    $sql = 'SELECT * FROM xin_employees AS employee 
						LEFT JOIN luffy_approver AS approver ON approver.approver = employee.user_id
						WHERE approver IS NULL AND employee.is_active=1 AND employee.deleted_at IS NULL AND employee.fingerprint_location != 0';
		$binds = array(1,1);
		$query = $this->db->query($sql,$binds);
	  return $query;
	}
	// end jazz
	// get deleted employees
	public function get_attendance_employees_deleted() {
    $sql = 'SELECT * FROM xin_employees WHERE is_active=? AND deleted_at IS NOT NULL';
		$binds = array(0);
		$query = $this->db->query($sql,$binds);
	  return $query;
	}
	// get total number of employees
	public function get_total_employees() {
		$this->db->where('is_active', 1);
		$this->db->where('deleted_at', NULL);
		$this->db->where('fingerprint_location !=', 0);
	  $query = $this->db->get("xin_employees");
	  return $query->num_rows();
	}
	public function read_employee_information($id) {
		$sql = 'SELECT * FROM xin_employees WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		 else return null;
	}
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_employees', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// luffy
	// soft delete
	public function delete_record($id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->set('is_active', 0);
    $this->db->where('user_id', $id);
    $this->db->update('xin_employees');
	}
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->set('is_active', 1);
    $this->db->where('user_id', $id);
    $this->db->update('xin_employees');
	}
	// luffy
	// destroy permanent
	public function destroy($id){
		$this->db->where('user_id', $id);
		$this->db->delete('xin_employees');
	}
	/*  Update Employee Record */
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data))
			return true;
		else return false;
	}
	// Function to update record in table > basic_info
	public function basic_info($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data))
			return true;
		else return false;
	}

	// Function to update record in table > change_password
	public function change_password($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data))
			return true;
		else return false;
	}
	// Function to update record in table > social_info
	public function social_info($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data))
			return true;
		else return false;

	}
	// Function to update record in table > profile picture
	public function profile_picture($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data))
			return true;
		else return false;
	}
	// Function to add record in table > contact_info
	public function contact_info_add($data){
		$this->db->insert('xin_employee_contacts', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		 else
			return false;

	}

	// Function to update record in table > contact_info
	public function contact_info_update($data, $id){
		$this->db->where('contact_id', $id);
		if( $this->db->update('xin_employee_contacts',$data))
			return true;
		else return false;
	}
	// Function to update record in table > document_info_update
	public function document_info_update($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
		$this->db->where('document_id', $id);
		if( $this->db->update('xin_employee_documents',$data))
			return true;
		else return false;
	}
	// Function to update record in table > document_info_update
	public function img_document_info_update($data, $id){
		$this->db->where('immigration_id', $id);
		if( $this->db->update('xin_employee_immigration',$data))
			return true;
		else return false;
	}
	// Function to add record in table > document info
	public function document_info_add($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_employee_documents', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to add record in table > immigration info
	public function immigration_info_add($data){
		$this->db->insert('xin_employee_immigration', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to add record in table > qualification_info_add
	public function qualification_info_add($data){
		$this->db->insert('xin_employee_qualification', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > qualification_info_update
	public function qualification_info_update($data, $id){
		$this->db->where('qualification_id', $id);
		if( $this->db->update('xin_employee_qualification',$data))
			return true;
		else return false;
	}
	// Function to add record in table > work_experience_info_add
	public function work_experience_info_add($data){
		$this->db->insert('xin_employee_work_experience', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > work_experience_info_update
	public function work_experience_info_update($data, $id){
		$this->db->where('work_experience_id', $id);
		if( $this->db->update('xin_employee_work_experience',$data))
			return true;
		else return false;
	}
	// Function to add record in table > bank_account_info_add
	public function bank_account_info_add($data){
		$this->db->insert('xin_employee_bankaccount', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > bank_account_info_update
	public function bank_account_info_update($data, $id){
		$this->db->where('bankaccount_id', $id);
		if( $this->db->update('xin_employee_bankaccount',$data))
			return true;
		else return false;
	}
	// Function to add record in table > contract_info_add
	public function contract_info_add($data){
		$this->db->insert('xin_employee_contract', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	//for current contact > employee
	public function check_employee_contact_current($id) {
	  $sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ? and contact_type = ? limit 1';
		$binds = array($id,'current');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	//for permanent contact > employee
	public function check_employee_contact_permanent($id) {
		$sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ? and contact_type = ? limit 1';
		$binds = array($id,'permanent');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get current contacts by id
	 public function read_contact_info_current($id) {
		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? and contact_type = ? limit 1';
		$binds = array($id,'current');
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		return $row;
	}
	// get permanent contacts by id
	 public function read_contact_info_permanent($id) {
		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? and contact_type = ? limit 1';
		$binds = array($id,'permanent');
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		return $row;
	}
	// Function to update record in table > contract_info_update
	public function contract_info_update($data, $id){
		$this->db->where('contract_id', $id);
		if( $this->db->update('xin_employee_contract',$data))
			return true;
		else return false;
	}
	// Function to add record in table > leave_info_add
	public function leave_info_add($data){
		$this->db->insert('xin_employee_leave', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > leave_info_update
	public function leave_info_update($data, $id){
		$this->db->where('leave_id', $id);
		if( $this->db->update('xin_employee_leave',$data))
			return true;
		else return false;
	}
	// Function to add record in table > shift_info_add
	public function shift_info_add($data){
		$this->db->insert('xin_employee_shift', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > shift_info_update
	public function shift_info_update($data, $id){
		$this->db->where('emp_shift_id', $id);
		if( $this->db->update('xin_employee_shift',$data))
			return true;
		else return false;
	}
	// Function to add record in table > location_info_add
	public function location_info_add($data){
		$this->db->insert('xin_employee_location', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to update record in table > location_info_update
	public function location_info_update($data, $id){
		$this->db->where('office_location_id', $id);
		if( $this->db->update('xin_employee_location',$data))
			return true;
		else return false;
	}
	// get all office shifts
	public function all_office_shifts() {
	  $query = $this->db->query("SELECT * from xin_office_shift");
	  return $query->result();
	}
	// get contacts
	public function set_employee_contacts($id) {
		$sql = 'SELECT * FROM xin_employee_contacts WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
    return $query;
	}
	// get documents
	public function set_employee_documents($id) {
		$sql = 'SELECT * FROM xin_employee_documents WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get immigration
	public function set_employee_immigration($id) {
		$sql = 'SELECT * FROM xin_employee_immigration WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}
	// get employee qualification
	public function set_employee_qualification($id) {
		$sql = 'SELECT * FROM xin_employee_qualification WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee work experience
	public function set_employee_experience($id) {
		$sql = 'SELECT * FROM xin_employee_work_experience WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee bank account
	public function set_employee_bank_account($id) {
		$sql = 'SELECT * FROM xin_employee_bankaccount WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee contract
	public function set_employee_contract($id) {
		$sql = 'SELECT * FROM xin_employee_contract WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	 	return $query;
	}
	// get employee office shift
	public function set_employee_shift($id) {
		$sql = 'SELECT * FROM xin_employee_shift WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee leave
	public function set_employee_leave($id) {
		$sql = 'SELECT * FROM xin_employee_leave WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get employee location
	public function set_employee_location($id) {
		$sql = 'SELECT * FROM xin_employee_location WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	 // get document type by id
	 public function read_document_type_information($id) {
		$sql = 'SELECT * FROM xin_document_type WHERE document_type_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// contract type
	public function read_contract_type_information($id) {
		$sql = 'SELECT * FROM xin_contract_type WHERE contract_type_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// contract employee
	public function read_contract_information($id) {
		$sql = 'SELECT * FROM xin_employee_contract WHERE contract_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// office shift
	public function read_shift_information($id) {
		$sql = 'SELECT * FROM xin_office_shift WHERE office_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get all contract types
	public function all_contract_types() {
	  $query = $this->db->query("SELECT * from xin_contract_type");
	  return $query->result();
	}
	// get all contracts
	public function all_contracts() {
	  $query = $this->db->query("SELECT * from xin_employee_contract");
  	return $query->result();
	}
	// get all document types
	public function all_document_types() {
	  $query = $this->db->query("SELECT * from xin_document_type");
  	return $query->result();
	}
	// get all education level
	public function all_education_level() {
	  $query = $this->db->query("SELECT * from xin_qualification_education_level");
  	return $query->result();
	}
	// get education level by id
	 public function read_education_information($id) {
		$sql = 'SELECT * FROM xin_qualification_education_level WHERE education_level_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get all qualification languages
	public function all_qualification_language() {
	  $query = $this->db->query("SELECT * from xin_qualification_language");
  	return $query->result();
	}
	// get languages by id
	 public function read_qualification_language_information($id) {
		$sql = 'SELECT * FROM xin_qualification_language WHERE language_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get all qualification skills
	public function all_qualification_skill() {
	  $query = $this->db->query("SELECT * from xin_qualification_skill");
  	  return $query->result();
	}
	// get qualification by id
	 public function read_qualification_skill_information($id) {
		$sql = 'SELECT * FROM xin_qualification_skill WHERE skill_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get contacts by id
	 public function read_contact_information($id) {
		$sql = 'SELECT * FROM xin_employee_contacts WHERE contact_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get documents by id
	public function read_document_information($id) {
		$sql = 'SELECT * FROM xin_employee_documents WHERE document_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get documents by id
	 public function read_imgdocument_information($id) {
		$sql = 'SELECT * FROM xin_employee_immigration WHERE immigration_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get qualifications by id
	 public function read_qualification_information($id) {
		$sql = 'SELECT * FROM xin_employee_qualification WHERE qualification_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get qualifications by id
	 public function read_work_experience_information($id) {
		$sql = 'SELECT * FROM xin_employee_work_experience WHERE work_experience_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get bank account by id
	 public function read_bank_account_information($id) {
		$sql = 'SELECT * FROM xin_employee_bankaccount WHERE bankaccount_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get leave by id
	 public function read_leave_information($id) {
		$sql = 'SELECT * FROM xin_employee_leave WHERE leave_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get shift by id
	 public function read_emp_shift_information($id) {
		$sql = 'SELECT * FROM xin_employee_shift WHERE emp_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// Function to Delete selected record from table
	public function delete_contact_record($id){
		$this->db->where('contact_id', $id);
		$this->db->delete('xin_employee_contacts');
	}
	// Function to Delete selected record from table
	public function delete_document_record($id){
		$this->db->where('document_id', $id);
		$this->db->delete('xin_employee_documents');
    // luffy 7 January 2020 02:51 pm
    // $session=$this->session->userdata('username');
    // $userId=$session['user_id'];
    // $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    // $this->db->set('deleted_by', $userId);
    // $this->db->where('document_id', $id);
    // $this->db->update('xin_employee_documents');
	}
	// Function to Delete selected record from table
	public function delete_imgdocument_record($id){
		$this->db->where('immigration_id', $id);
		$this->db->delete('xin_employee_immigration');
	}
	// Function to Delete selected record from table
	public function delete_qualification_record($id){
		$this->db->where('qualification_id', $id);
		$this->db->delete('xin_employee_qualification');
	}
	// Function to Delete selected record from table
	public function delete_work_experience_record($id){
		$this->db->where('work_experience_id', $id);
		$this->db->delete('xin_employee_work_experience');
	}
	// Function to Delete selected record from table
	public function delete_bank_account_record($id){
		$this->db->where('bankaccount_id', $id);
		$this->db->delete('xin_employee_bankaccount');
	}
	// Function to Delete selected record from table
	public function delete_contract_record($id){
		$this->db->where('contract_id', $id);
		$this->db->delete('xin_employee_contract');
	}
	// Function to Delete selected record from table
	public function delete_leave_record($id){
		$this->db->where('leave_id', $id);
		$this->db->delete('xin_employee_leave');
	}
	// Function to Delete selected record from table
	public function delete_shift_record($id){
		$this->db->where('emp_shift_id', $id);
		$this->db->delete('xin_employee_shift');
	}
	// Function to Delete selected record from table
	public function delete_location_record($id){
		$this->db->where('office_location_id', $id);
		$this->db->delete('xin_employee_location');
	}
	// get location by id
	 public function read_location_information($id) {
		$sql = 'SELECT * FROM xin_employee_location WHERE office_location_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	public function record_count() {
    return $this->db->count_all("xin_employees");
  }
  public function fetch_all_employees($limit, $start) {
    $this->db->limit($limit, $start);
		$this->db->order_by("designation_id asc");
    $query = $this->db->get("xin_employees");
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
   }
   public function des_fetch_all_employees($limit, $start) {
    // $this->db->limit($limit, $start);
		$sql = 'SELECT * FROM xin_employees order by designation_id asc limit ?, ?';
		$binds = array($limit,$start);
		$query = $this->db->query($sql, $binds);
    //  $query = $this->db->get("xin_employees");
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
   }
   // get list all Adjustment (+) by user id
   // used on payroll > generate payslip > modal 'view'
	public function set_employee_allowances($id) {
		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
    return $query;
	}
  // luffy
  // get list all Adjustment (-) by user id
  // used on payroll > generate payslip > modal 'view'
	public function allAdjustmentMinusByUserId($id) {
		$sql = 'SELECT * FROM xin_salary_adjustment_minus WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
    return $query;
	}
	// get employee overtime
	public function set_employee_overtime($id) {
		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee allowances
	public function set_employee_deductions($id) {
		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	//-- payslip data
	// get employee allowances
	public function set_employee_allowances_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_allowances WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// luffy - 4 december 2019 01:58 pm
  // get employee adjustment minus by payslip id
  // used in payslip
	public function getAdjustmentMinusByPayslipid($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_adjustment_minus WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee overtime
	public function set_employee_overtime_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_overtime WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	// get employee allowances
	public function set_employee_deductions_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_loan WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	  return $query;
	}
	//------
	// get employee allowances
	public function count_employee_allowances_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_allowances WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	// get employee overtime
	public function count_employee_overtime_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_overtime WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	// get employee allowances
	public function count_employee_deductions_payslip($id) {
		$sql = 'SELECT * FROM xin_salary_payslip_loan WHERE payslip_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	//////////////////////
	// get employee allowances
	public function count_employee_allowances($id) {
		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	// get employee overtime
	public function count_employee_overtime($id) {
		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	// get employee allowances
	public function count_employee_deductions($id) {
		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
  	return $query->num_rows();
	}
	// get employee salary allowances
	public function read_salary_allowances($id) {
		$sql = 'SELECT * FROM xin_salary_allowances WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get employee overtime
	public function read_salary_overtime($id) {
		$sql = 'SELECT * FROM xin_salary_overtime WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get employee salary loan_deduction
	public function read_salary_loan_deductions($id) {
		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get employee salary loan_deduction
	public function read_single_loan_deductions($id) {
		$sql = 'SELECT * FROM xin_salary_loan_deductions WHERE loan_deduction_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	//Calculates how many months is past between two timestamps.
	public function get_month_diff($start, $end = FALSE) {
		$end OR $end = time();
		$start = new DateTime($start);
		$end   = new DateTime($end);
		$diff  = $start->diff($end);
		return $diff->format('%y') * 12 + $diff->format('%m');
	}
	// get employee salary allowances
	public function read_single_salary_allowance($id) {
		$sql = 'SELECT * FROM xin_salary_allowances WHERE allowance_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get employee overtime record
	public function read_salary_overtime_record($id) {
		$sql = 'SELECT * FROM xin_salary_overtime WHERE salary_overtime_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// Function to add record in table > allowance
	public function add_alary_allowances($data){
    # luffy 4 January 2020 01:19 pm
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
    $this->db->insert('xin_salary_allowances', $data);
    if ($this->db->affected_rows() > 0)
      return true;
    else return false;
	}
  // Function to Delete selected record from table
	public function delete_allowance_record($id){
		$this->db->where('allowance_id', $id);
		$this->db->delete('xin_salary_allowances');
	}

  // luffy 29 november 2019 08:19 pm
  // get all employee salary adjustment minus
  // used in employee detail > set playslip
  public function all_adjustment_minus($userId) {
    $sql = 'SELECT * FROM xin_salary_adjustment_minus WHERE employee_id = ?';
    $binds = array($userId);
    $query = $this->db->query($sql, $binds);
    return $query;
  }
  // luffy 29 november 2019 08:19 pm
  // for adding new adjustment (-)
  // used in employee detail > set playslip
  public function add_adjustment_minus($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_salary_adjustment_minus', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
  // luffy 29 november 2019 08:19 pm
  // for update adjustment (-)
  // used in employee detail > set playslip
  public function update_adjustment_minus($data,$id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('adjustment_minus_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_salary_adjustment_minus',$data))
			return true;
		else return false;
	}
  // luffy 30 november 2019 10:55 am
  // for delete adjustment (-)
  // used in employee detail > set playslip
	public function del_adjustment_minus($id){
		$this->db->where('adjustment_minus_id', $id);
		$this->db->delete('xin_salary_adjustment_minus');
	}
  // luffy 30 november 2019 10:35 am
  // for reading adjustment (-)
  // used in employee detail > set playslip
	public function read_adjustment_minus($id) {
		$sql = 'SELECT * FROM xin_salary_adjustment_minus WHERE adjustment_minus_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}

	// Function to add record in table > loan
	public function add_salary_loan($data){
		$this->db->insert('xin_salary_loan_deductions', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to add record in table > overtime
	public function add_salary_overtime($data){
		$this->db->insert('xin_salary_overtime', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to Delete selected record from table
	public function delete_loan_record($id){
		$this->db->where('loan_deduction_id', $id);
		$this->db->delete('xin_salary_loan_deductions');
	}
	// Function to Delete selected record from table
	public function delete_overtime_record($id){
		$this->db->where('salary_overtime_id', $id);
		$this->db->delete('xin_salary_overtime');
	}
	// Function to update record in table > update allowance record
	public function salary_allowance_update_record($data, $id){
		// $this->db->where('allowance_id', $id);
		// if( $this->db->update('xin_salary_allowances',$data))
		// 	return true;
	  // else return false;
    # luffy 4 January 2020 01:40 pm
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('allowance_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_salary_allowances',$data))
			return true;
		else return false;
	}
	// Function to update record in table > update allowance record
	public function salary_loan_update_record($data, $id){
		$this->db->where('loan_deduction_id', $id);
		if( $this->db->update('xin_salary_loan_deductions',$data))
			return true;
		else return false;
	}
	// Function to update record in table > update allowance record
	public function salary_overtime_update_record($data, $id){
		$this->db->where('salary_overtime_id', $id);
		if( $this->db->update('xin_salary_overtime',$data))
			return true;
		else return false;
	}

  // luffy start
  // get employee by KPS location
  public function fetch_by_location($transfer_location_id,$limit, $start) {
     $sql = 'SELECT
               employee.user_id, employee.first_name, employee.last_name, employee.gender, employee.email, employee.contact_no, employee.profile_picture, employee.designation_id,
               location.location_id, location.location_name,
               designation.designation_name
             FROM xin_employees AS employee
                LEFT JOIN xin_employee_transfer AS transfer ON transfer.employee_id = employee.user_id
                LEFT JOIN xin_office_location AS location ON location.location_id = transfer.transfer_location
                LEFT JOIN xin_designations AS designation ON employee.designation_id = designation.designation_id
             WHERE transfer.transfer_location=?';

     $this->db->limit($limit, $start);
     $this->db->order_by("employee.first_name asc");
     $binds = array($transfer_location_id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;
  }
  // luffy start
  // get employee by shift
  public function fetch_by_shift($shift_id,$limit, $start) {
     $sql = 'SELECT
               employee.user_id, employee.first_name, employee.last_name, employee.gender, employee.email, employee.contact_no, employee.profile_picture, employee.designation_id,
               shift.shift_name
             FROM xin_employees AS employee
                LEFT JOIN xin_office_shift AS shift ON shift.office_shift_id = employee.office_shift_id
             WHERE employee.office_shift_id=?';

     $this->db->limit($limit, $start);
     $this->db->order_by("employee.first_name asc");
     $binds = array($shift_id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;
  }
  // luffy start
  // get employee by job
  public function fetch_by_department($department_id,$limit, $start) {
     $sql = 'SELECT
               employee.user_id, employee.first_name, employee.last_name, employee.gender, employee.email, employee.contact_no, employee.profile_picture, employee.designation_id,
               department.department_name
             FROM xin_employees AS employee
                LEFT JOIN xin_departments AS department ON department.department_id = employee.department_id
             WHERE employee.department_id=?';
     $this->db->limit($limit, $start);
     $this->db->order_by("employee.first_name asc");
     $binds = array($department_id);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->result();
     else return null;

  }
  // get employees list> directory
  // by company > location > department > shift
	public function get_employees_directory($company_id = 0, $location_id = 0, $department_id = 0, $shift_id = 0) {
		$this->db->select('*');
		$this->db->from('xin_employees AS employee');
		$this->db->join('xin_office_shift AS shift', 'shift.office_shift_id = employee.office_shift_id', 'left');
		$this->db->join('xin_office_location AS location', 'location.location_id = employee.fingerprint_location', 'left');
		$this->db->where('employee.fingerprint_location !=', 0);
		$this->db->where('employee.is_active', 1);
		if($company_id != 0){
			$this->db->where('employee.company_id', $company_id);
		}
		if($location_id != 0){
			$this->db->where('location.location_active', 1);
			$this->db->where('employee.fingerprint_location', $location_id);
		}
		if($department_id != 0){
			$this->db->where('employee.department_id', $department_id);
		}
		if($shift_id != 0){
			$this->db->where('employee.office_shift_id', $shift_id);
		}
		return $this->db->get();
	}
  // get all designations
	public function all_designations(){
	  $query = $this->db->query("SELECT * from xin_designations");
	  return $query->result();
	}
  // luffy
	// get company > departments
	public function ajax_location_info($id) {
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_office_location');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
  // departments
	public function ajax_company_departments_info($id) {
		$condition = "company_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_departments');
		$this->db->where($condition);
		$this->db->limit(100);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// shift
	public function ajax_shift_information() {
    $sql = 'SELECT * from xin_office_shift';
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0)
      return $query->result();
    else return null;
	}
  // all employees who has fingerprint data only
  public function getEmployeesHaveLocationOnly(){
    $sql = "SELECT * FROM xin_employees WHERE fingerprint_location!=''";
    $query = $this->db->query($sql);
    if ($query->num_rows()>0)
      return $query;
    else return null;
  }
  // all employees who are active and have location only.
  public function allEmployeesHaveFingerprintLocation(){
    $sql = "SELECT * FROM xin_employees WHERE is_active=? AND fingerprint_location!=''";
    $bind = array(1);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows()>0)
      return $query;
    else return null;
  }
  // get employee's data by nik id. eg: 7380
  public function getEmployeeDataByNikId($nikId){
    $sql = "SELECT * FROM xin_employees WHERE employee_id=?";
    $bind = array($nikId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get employee's data by user id. eg: 35
  // if in case fetching data using session user id.
  public function getEmployeeDataByUserId($userId){
    $sql = "SELECT * FROM xin_employees WHERE user_id=?";
    $bind = array($userId);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows()>0)
      return $query->row();
    else return null;
  }
  // get all employees who are not active, used in employee exit.
  public function getEmployeesInactive(){
    $sql = "SELECT employee.*, location.location_name 
						FROM xin_employees AS employee
						LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
						WHERE is_active=?";
    $bind = array(0);
    $query = $this->db->query($sql,$bind);
    if ($query->num_rows()>0)
      return $query;
    else return null;
  }
  // get subdept by nik id.
	public function getSubdeptByNikId($nikId){
    $sql = 'SELECT
              employee.*,
              subdept.sub_department_id AS subdeptId,subdept.department_name
            FROM xin_employees AS employee
               LEFT JOIN xin_sub_departments AS subdept ON subdept.sub_department_id=employee.sub_department_id
            WHERE employee.employee_id=? AND is_active=1 AND deleted_at IS NULL';
    $bind = array($nikId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query->row();
    else return null;
	}
  // get subdept by nik id.
	public function getActiveEmployeeBySubdeptShiftId($subdeptId, $shiftId){
    $sql = 'SELECT user_id, employee_id, username, office_shift_id, sub_department_id FROM xin_employees
            WHERE sub_department_id=? AND office_shift_id = ? AND is_active=1 AND deleted_at IS NULL';
    $bind = array($subdeptId, $shiftId);
    $query = $this->db->query($sql,$bind);
    if(!is_null($query))
      return $query;
    else return null;
	}

  // luffy 14 Dec 2019 07:02pm
  // get approval's data by user id
  public function getNamebyUserId($userId){
    $sql = "SELECT * FROM xin_employees WHERE user_id=?";
    $binds = array($userId);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
  // luffy 14 Dec 2019 06:49pm
  // get approval's data by employee id
  public function getNamebyEmployeeId($employeeId){
    $sql = "SELECT * FROM xin_employees WHERE employee_id=?";
    $binds = array($employeeId);
    $query = $this->db->query($sql, $binds);
    if ($query->num_rows() > 0) {
      return $query->row();
    } else {
      return null;
    }
  }
}
?>
