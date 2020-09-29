<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
class designation_model extends CI_Model {
  public function __construct(){
      parent::__construct();
      $this->load->database();
  }
	public function get_designations(){
		$query = $this->db->query("SELECT * from xin_designations WHERE deleted_at IS NULL");
		return $query;
	}
	public function get_designations_deleted(){
		$query = $this->db->query("SELECT * from xin_designations WHERE deleted_at IS NOT NULL");
		return $query;
	}
	public function read_designation_information($id) {
		$sql = 'SELECT * FROM xin_designations WHERE designation_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if($query->num_rows() > 0)
			return $query->result();
		else return null;
	}
	// luffy
	// update
	public function update_record($data, $id){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('updated_at', date('Y-m-d H:i:s'));
    $this->db->set('updated_by', $userId);
    $this->db->where('designation_id', $id);
		// $data = $this->security->xss_clean($data);
    if($this->db->update('xin_designations',$data))
			return true;
		else return false;
	}
	// luffy
	// add
	public function add($data){
		$session=$this->session->userdata('username');
    $userId=$session['user_id'];
    $this->db->set('created_at',date('Y-m-d H:i:s'));
    $this->db->set('created_by',$userId);
		$this->db->insert('xin_designations', $data);
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
    $this->db->where('designation_id', $id);
    $this->db->update('xin_designations');
	}
	// luffy
	// luffy restore
	public function restore($id){
    $this->db->set('deleted_at', NULL);
    $this->db->set('deleted_by', 0);
    $this->db->set('status', 1);
    $this->db->where('designation_id', $id);
    $this->db->update('xin_designations');
	}
	// luffy
	// destroy permanent
	public function destroy($id){
		$this->db->where('designation_id', $id);
		$this->db->delete('xin_designations');
	}

	// get all designations
	public function all_designations(){
	  $query = $this->db->query("SELECT * from xin_designations");
	  return $query->result();
	}
	// get department > designations
	public function ajax_designation_information($id) {
		$sql = 'SELECT * FROM xin_designations WHERE sub_department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// get company > designations
	public function ajax_company_designation_info($id) {
		$sql = 'SELECT * FROM xin_designations WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0)
			return $query->result();
		else return false;
	}
	// luffy
	public function getTitle($id) {
	 $sql = 'SELECT designation_name FROM xin_designations WHERE designation_id = ?';
	 $binds = array($id);
	 $query = $this->db->query($sql, $binds);
	 if ($query->num_rows() > 0)
		 return $query->result();
	 else return null;
 }

}
?>
