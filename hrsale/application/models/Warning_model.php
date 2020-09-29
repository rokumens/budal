<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class warning_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

	public function get_warning() {
	  return $this->db->query("SELECT * FROM xin_employee_warnings ORDER BY warning_id DESC");
	}

	public function get_employee_warning($id) {
		$sql = 'SELECT * FROM xin_employee_warnings WHERE warning_to = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function read_warning_information($id) {
		$sql = 'SELECT * FROM xin_employee_warnings WHERE warning_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	public function getCounterByEmployeeId($employeeId) {
		$sql = 'SELECT
             COUNT(warning_to) AS countWarningCounter
            FROM xin_employee_warnings WHERE warning_to=? AND status=1';
		$binds = array($employeeId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->row();
		else return null;
	}
	public function getWarningInfoByEmployeeId($employeeId) {
		$sql = 'SELECT * FROM xin_employee_warnings WHERE warning_to = ?';
		$binds = array($employeeId);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
  }
	 public function getWarningTypeNameById($id) {
		$sql = 'SELECT type FROM xin_warning_type WHERE warning_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->row();
		else return null;
  }
  public function read_warning_type_information($id) {
		$sql = 'SELECT * FROM xin_warning_type WHERE warning_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	public function all_warning_types() {
	  $query = $this->db->query("SELECT * from xin_warning_type");
  	return $query->result();
	}
	// Function to add record in table
	public function add($data){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_employee_warnings', $data);
		if ($this->db->affected_rows() > 0)
			return true;
		else return false;
	}
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('warning_id', $id);
		$this->db->delete('xin_employee_warnings');
	}

	// Function to update record in table
	public function update_record($data, $id){
    $session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
		$this->db->where('warning_id', $id);
		if( $this->db->update('xin_employee_warnings',$data))
			return true;
		else return false;
	}

  // get employee NIK id by employee's id
  public function getNIK($employeeId) {
     $sql = 'SELECT employee_id FROM xin_employees WHERE user_id=?';
     $binds = array($employeeId);
     $query = $this->db->query($sql,$binds);
     if ($query->num_rows() > 0)
       return $query->row();
     else return null;
  }
}
?>
