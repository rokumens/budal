<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class department_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
		public function get_departments() {
			$query = $this->db->query("SELECT * from xin_departments WHERE deleted_at IS NULL");
	  	  return $query;
		}
		public function get_departments_deleted() {
			$query = $this->db->query("SELECT * from xin_departments WHERE deleted_at IS NOT NULL");
	  	  return $query;
		}
		public function get_subdepartments_deleted() {
			$query = $this->db->query("SELECT * from xin_sub_departments WHERE deleted_at IS NOT NULL");
	  	  return $query;
		}
		public function get_sub_departments() {
		  return $this->db->query("SELECT * from xin_sub_departments WHERE deleted_at IS NULL");
		}
	 public function read_department_information($id) {
		$sql = 'SELECT * FROM xin_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	public function read_sub_department_info($id) {
		$sql = 'SELECT * FROM xin_sub_departments WHERE sub_department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get single record > company | locations
	 public function ajax_location_information($id) {
		$sql = 'SELECT * FROM xin_office_location WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// get single record > company | employees
	 public function ajax_company_employee_info($id) {
		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? AND is_active=1 AND deleted_at IS NULL AND fingerprint_location!=0';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// luffy
	// add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_departments', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to add record in table
	public function add_sub($data){
		$this->db->insert('xin_sub_departments', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// luffy
	// delete
	public function delete_record($id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->set('status', 0);
    $this->db->where('department_id', $id);
    $this->db->update('xin_departments');
	}
	// luffy
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->set('status', 1);
    $this->db->where('department_id', $id);
    $this->db->update('xin_departments');
	}
	// luffy
	// destroy permanent
	public function destroy($id){
		$this->db->where('department_id', $id);
		$this->db->delete('xin_departments');
	}
	// delelete sub department
	public function delete_sub_record($id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('deleted_at', date('Y-m-d H:i:s'));
    $this->db->set('deleted_by', $userId);
    $this->db->where('sub_department_id', $id);
    $this->db->update('xin_sub_departments');
	}
	// luffy restore for sub department
	public function sub_restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->where('sub_department_id', $id);
    $this->db->update('xin_sub_departments');
	}
	// luffy
	// update
	public function update_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('department_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_departments',$data))
			return true;
		else return false;
	}
	// Function to update record in table
	public function update_sub_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('sub_department_id', $id);
		$data = $this->security->xss_clean($data);
    if($this->db->update('xin_sub_departments',$data))
			return true;
		else return false;
	}
	// get all departments
	public function all_departments() {
	  $query = $this->db->query("SELECT * from xin_departments WHERE deleted_at IS NULL");
  	  return $query->result();
	}
}
?>
